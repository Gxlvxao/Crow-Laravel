<?php

namespace App\Http\Controllers;

use App\Models\AccessRequest;
use App\Models\Property;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class AdminController extends Controller
{
    public function dashboard()
    {
        $stats = [
            'pending_requests' => AccessRequest::where('status', 'pending')->count(),
            'exclusive_pending' => User::whereNotNull('developer_id')->where('status', 'pending')->count(),
            'total_properties' => Property::count(),
            'published_properties' => Property::where('status', 'active')->count(),
            'total_users' => User::where('role', '!=', 'admin')->count(),
            'developers' => User::where('role', 'developer')->count(),
            'clients' => User::where('role', 'client')->count(),
        ];

        $recentRequests = AccessRequest::with('user')
            ->where('status', 'pending')
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get();

        $recentProperties = Property::with('owner')
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get();

        return view('admin.dashboard', compact('stats', 'recentRequests', 'recentProperties'));
    }

    public function accessRequests()
    {
        $requests = AccessRequest::with(['user', 'reviewer'])
            ->orderBy('status', 'asc')
            ->orderBy('created_at', 'desc')
            ->paginate(20);

        return view('admin.access-requests', compact('requests'));
    }

    public function exclusiveRequests()
    {
        $pendingClients = User::with('developer')
            ->whereNotNull('developer_id')
            ->where('status', 'pending')
            ->orderBy('created_at', 'desc')
            ->paginate(20);

        return view('admin.exclusive-requests', compact('pendingClients'));
    }

    public function approveExclusiveRequest(User $user)
    {
        $user->update(['status' => 'active']);
        return redirect()->back()->with('success', 'Cliente aprovado! O Developer já pode conceder acessos.');
    }

    public function rejectExclusiveRequest(User $user)
    {
        $user->delete();
        return redirect()->back()->with('success', 'Cadastro rejeitado e removido.');
    }

    public function showAccessRequest(AccessRequest $accessRequest)
    {
        return view('admin.access-requests-show', compact('accessRequest'));
    }

    public function approveAccessRequest(AccessRequest $accessRequest)
    {
        $role = $accessRequest->requested_role;
        if (!$role) {
            $role = ($accessRequest->investor_type === 'developer') ? 'developer' : 'client';
        }

        $message = 'Pedido aprovado com sucesso!';

        $user = $accessRequest->user ?? User::where('email', $accessRequest->email)->first();

        if ($user) {
            $user->update([
                'status' => 'active',
                'role' => $role,
            ]);
            
            if (!$accessRequest->user_id) {
                $accessRequest->user_id = $user->id;
            }
            
            $message .= " Perfil vinculado.";
        } else {
            $tempPassword = Str::random(10);
            
            $user = User::create([
                'name' => $accessRequest->name,
                'email' => $accessRequest->email,
                'password' => Hash::make($tempPassword),
                'role' => $role,
                'status' => 'active',
                'email_verified_at' => now(),
            ]);

            $accessRequest->user_id = $user->id;
            
            $message .= " Usuário criado. SENHA TEMPORÁRIA: {$tempPassword}";
        }

        $accessRequest->status = 'approved';
        $accessRequest->reviewed_at = now();
        $accessRequest->reviewed_by = auth()->id();
        $accessRequest->requested_role = $role;
        $accessRequest->save();

        return redirect()->back()->with('success', $message);
    }

    public function rejectAccessRequest(Request $request, AccessRequest $accessRequest)
    {
        $validated = $request->validate([
            'rejection_reason' => 'nullable|string|max:500',
        ]);

        $accessRequest->update([
            'status' => 'rejected',
            'reviewed_at' => now(),
            'reviewed_by' => auth()->id(),
            'rejection_reason' => $validated['rejection_reason'] ?? null,
        ]);

        return redirect()->back()->with('success', 'Pedido rejeitado.');
    }

    public function toggleUserStatus(User $user)
    {
        if ($user->id === auth()->id()) {
            return redirect()->back()->with('error', 'Você não pode bloquear sua própria conta.');
        }

        $newStatus = $user->status === 'active' ? 'inactive' : 'active';
        $user->update(['status' => $newStatus]);

        return redirect()->back()->with('success', "Status alterado com sucesso.");
    }

    public function resetUserPassword(User $user)
    {
        $newPassword = Str::random(12);
        $user->update(['password' => Hash::make($newPassword)]);
        return redirect()->back()->with('success', "Senha resetada: {$newPassword}");
    }

    public function deleteUser(User $user)
    {
        if ($user->id === auth()->id()) {
            return redirect()->back()->with('error', 'Ação não permitida.');
        }
        $user->delete();
        return redirect()->back()->with('success', 'Usuário excluído.');
    }

    public function properties(Request $request)
    {
        $query = Property::with('owner');

        if ($request->filled('status')) $query->where('status', $request->status);
        if ($request->filled('search')) {
            $query->where(function($q) use ($request) {
                $q->where('title', 'like', '%' . $request->search . '%')
                  ->orWhere('city', 'like', '%' . $request->search . '%');
            });
        }

        $properties = $query->orderBy('created_at', 'desc')->paginate(20);
        return view('admin.properties', compact('properties'));
    }

    public function deleteProperty(Property $property)
    {
        if ($property->images) {
            foreach ($property->images as $image) Storage::disk('public')->delete($image);
        }
        $property->delete();
        return redirect()->back()->with('success', 'Imóvel excluído!');
    }
}