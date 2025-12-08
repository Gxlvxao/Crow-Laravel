<?php

namespace App\Http\Controllers;

use App\Models\Property;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Mail\VisitRequestMail;
use Illuminate\Support\Facades\Mail;

class PropertyController extends Controller
{
    public function index(Request $request)
    {
        if (Auth::check()) {
            $query = Property::visibleForUser(Auth::user());
        } else {
            $query = Property::where('status', 'active')
                             ->where('is_exclusive', false);
        }

        if ($request->filled('city')) {
            $query->byCity($request->city);
        }
        if ($request->filled('type')) {
            $query->byType($request->type);
        }
        if ($request->filled('transaction_type')) {
            $query->byTransactionType($request->transaction_type);
        }
        if ($request->filled('bedrooms')) {
            $query->byBedrooms($request->bedrooms);
        }
        if ($request->filled('min_price') && $request->filled('max_price')) {
            $query->byPriceRange($request->min_price, $request->max_price);
        }

        $query->orderBy('is_featured', 'desc')
              ->orderBy('published_at', 'desc');

        $properties = $query->paginate(12);

        return view('properties.index', compact('properties'));
    }

    public function create()
    {
        if (!Auth::user()->canManageProperties()) abort(403);
        return view('properties.create');
    }

    public function store(Request $request)
    {
        if (!Auth::user()->canManageProperties()) abort(403);

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'cover_image' => 'required|image|mimes:jpeg,png,jpg,webp|max:5120',
            'images.*' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:5120',
            'type' => 'required|in:apartment,house,villa,land,commercial,office',
            'transaction_type' => 'required|in:sale,rent',
            'condition' => 'nullable|in:new,used,renovated,under_construction',
            'price' => 'required|numeric|min:0',
            'city' => 'required|string|max:255',
            'district' => 'nullable|string|max:255',
            'address' => 'required|string|max:255',
            'postal_code' => 'nullable|string|max:20',
            'bedrooms' => 'nullable|integer|min:0',
            'bathrooms' => 'nullable|integer|min:0',
            'area' => 'nullable|numeric|min:0',
            'land_area' => 'nullable|numeric|min:0',
            'year_built' => 'nullable|integer|min:1800|max:' . date('Y'),
            'energy_rating' => 'nullable|string|max:5',
            'video_url' => 'nullable|url',
            'whatsapp' => 'nullable|string|max:20',
            'features' => 'nullable|array',
            'is_exclusive' => 'nullable|boolean',
        ]);

        if ($request->hasFile('cover_image')) {
            $validated['cover_image'] = $request->file('cover_image')->store('properties/covers', 'public');
        }

        $imagePaths = [];
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                $imagePaths[] = $image->store('properties/gallery', 'public');
            }
        }
        $validated['images'] = $imagePaths;

        $validated['user_id'] = Auth::id();
        $validated['status'] = 'active'; 
        $validated['published_at'] = now();
        $validated['is_exclusive'] = $request->boolean('is_exclusive');

        $property = Property::create($validated);

        return redirect()->route('properties.show', $property)
            ->with('success', 'Imóvel criado com sucesso!');
    }

    public function show(Property $property)
    {
        if (Auth::check()) {
            $canView = Property::visibleForUser(Auth::user())->where('id', $property->id)->exists();
            if (!$canView) abort(403, 'Acesso restrito a este imóvel.');
        } else {
            if ($property->status !== 'active' || $property->is_exclusive) abort(403, 'Conteúdo exclusivo para membros.');
        }

        return view('properties.show', compact('property'));
    }

    public function edit(Property $property)
    {
        if (!Auth::user()->canManageProperties() || (Auth::id() !== $property->user_id && !Auth::user()->isAdmin())) abort(403);
        return view('properties.edit', compact('property'));
    }

    public function update(Request $request, Property $property)
    {
        if (!Auth::user()->canManageProperties() || (Auth::id() !== $property->user_id && !Auth::user()->isAdmin())) abort(403);

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'status' => 'required|in:draft,active,negotiating,sold',
            'cover_image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:5120',
            'images.*' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:5120',
            'type' => 'required|in:apartment,house,villa,land,commercial,office',
            'transaction_type' => 'required|in:sale,rent',
            'condition' => 'nullable|in:new,used,renovated,under_construction',
            'price' => 'required|numeric|min:0',
            'city' => 'required|string|max:255',
            'district' => 'nullable|string|max:255',
            'address' => 'required|string|max:255',
            'postal_code' => 'nullable|string|max:20',
            'bedrooms' => 'nullable|integer|min:0',
            'bathrooms' => 'nullable|integer|min:0',
            'area' => 'nullable|numeric|min:0',
            'land_area' => 'nullable|numeric|min:0',
            'year_built' => 'nullable|integer|min:1800|max:' . date('Y'),
            'energy_rating' => 'nullable|string|max:5',
            'video_url' => 'nullable|url',
            'whatsapp' => 'nullable|string|max:20',
            'features' => 'nullable|array',
            'is_exclusive' => 'nullable|boolean',
            'delete_images' => 'nullable|array',
        ]);

        if ($request->hasFile('cover_image')) {
            if ($property->cover_image) Storage::disk('public')->delete($property->cover_image);
            $validated['cover_image'] = $request->file('cover_image')->store('properties/covers', 'public');
        }

        $currentImages = $property->images ?? [];
        if ($request->filled('delete_images')) {
            foreach ($request->delete_images as $imageToDelete) {
                if (($key = array_search($imageToDelete, $currentImages)) !== false) {
                    Storage::disk('public')->delete($imageToDelete);
                    unset($currentImages[$key]);
                }
            }
            $currentImages = array_values($currentImages);
        }
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                $currentImages[] = $image->store('properties/gallery', 'public');
            }
        }
        $validated['images'] = $currentImages;
        $validated['is_exclusive'] = $request->boolean('is_exclusive');

        $property->update($validated);

        return redirect()->route('properties.show', $property)->with('success', 'Imóvel atualizado!');
    }

    public function destroy(Property $property)
    {
        if (!Auth::user()->canManageProperties() || (Auth::id() !== $property->user_id && !Auth::user()->isAdmin())) abort(403);
        if ($property->cover_image) Storage::disk('public')->delete($property->cover_image);
        if ($property->images) {
            foreach ($property->images as $image) Storage::disk('public')->delete($image);
        }
        $property->delete();
        return redirect()->route('properties.index')->with('success', 'Imóvel excluído!');
    }

    public function myProperties()
    {
        if (!Auth::user()->canManageProperties()) abort(403);
        $properties = Property::where('user_id', Auth::id())->orderBy('created_at', 'desc')->paginate(12);
        return view('properties.my-properties', compact('properties'));
    }

    public function sendVisitRequest(Request $request, Property $property)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email',
            'phone' => 'required|string|max:20',
            'preferred_date' => 'required|string',
            'message' => 'nullable|string',
        ]);
        $recipient = $property->owner->email ?? 'admin@crowglobal.com';
        return redirect()->back()->with('success', 'Sua solicitação de visita foi enviada! Entraremos em contato em breve.');
    }

    public function getAccessList(Property $property)
    {
        if (!Auth::user()->canManageProperties()) abort(403);
        
        $clients = Auth::user()->clients;
        $allowedIds = $property->allowedUsers()->pluck('users.id')->toArray();

        return response()->json([
            'clients' => $clients,
            'allowed_ids' => $allowedIds
        ]);
    }
}