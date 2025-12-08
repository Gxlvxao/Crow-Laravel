<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Property;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str; // <--- Importação corrigida aqui

class DeveloperController extends Controller
{
    public function index()
    {
        $clients = Auth::user()->clients()->orderBy('created_at', 'desc')->paginate(10);
        return view('developer.clients', compact('clients'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
        ]);

        $tempPassword = Str::random(10);

        User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($tempPassword),
            'role' => 'client',
            'status' => 'pending', 
            'developer_id' => Auth::id(),
            'email_verified_at' => now(),
        ]);

        return redirect()->back()->with('success', "Pré-cadastro realizado! O Admin precisa aprovar antes que você possa conceder acessos. Senha gerada: {$tempPassword}");
    }

    public function toggleClientStatus(User $client)
    {
        if ($client->developer_id !== Auth::id()) abort(403);

        if ($client->status === 'pending') {
            return redirect()->back()->with('error', 'Este cliente ainda aguarda aprovação do Administrador.');
        }

        $newStatus = $client->status === 'active' ? 'inactive' : 'active';
        $client->update(['status' => $newStatus]);

        return redirect()->back()->with('success', 'Status do cliente atualizado.');
    }

    public function destroy(User $client)
    {
        if ($client->developer_id !== Auth::id()) abort(403);
        $client->delete();
        return redirect()->back()->with('success', 'Cliente removido da sua carteira.');
    }

    public function toggleAccess(Request $request, Property $property)
    {
        if ($property->user_id !== Auth::id() && !Auth::user()->isAdmin()) {
            abort(403);
        }

        $request->validate([
            'user_id' => 'required|exists:users,id',
            'access' => 'required|boolean'
        ]);

        $user = User::find($request->user_id);

        if ($user->status !== 'active') {
            return response()->json(['message' => 'Cliente não está ativo ou pendente de aprovação.'], 403);
        }

        if ($request->boolean('access')) {
            $property->allowedUsers()->syncWithoutDetaching([
                $request->user_id => ['granted_by' => Auth::id()]
            ]);
            $message = 'Acesso concedido.';
        } else {
            $property->allowedUsers()->detach($request->user_id);
            $message = 'Acesso revogado.';
        }

        return response()->json(['message' => $message]);
    }
}