<?php

namespace App\Http\Controllers\Users;

use App\Models\User;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Hash;
use App\Http\Controllers\Controller;

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'role:admin']); // seul admin peut gérer
    }

    // Afficher la liste des utilisateurs
    public function index()
    {
        $users = User::role('user')
            ->with('roles')
            ->latest()
            ->paginate(10);

        return view(
            'users.index',
            compact('users')
        );
    }

    // Formulaire création utilisateur
    public function create()
    {
        $roles = Role::all();
        return view('users.create', compact('roles'));
    }

    // Stocker un nouvel utilisateur
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nom' => 'required|string|max:255',
            'prenom' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|confirmed|min:8',
            'role' => 'required|string',
        ]);

        $user = User::create([
            'nom' => strip_tags($validated['nom']),
            'prenom' => strip_tags($validated['prenom']),
            'email' => strtolower($validated['email']),
            'password' => Hash::make($validated['password']),
        ]);

        $user->syncRoles($validated['role']);

        return redirect()
            ->route('admin.users.index')
            ->with('success', 'Utilisateur créé.');
    }

    // Formulaire édition
    public function edit(User $user)
    {
        $roles = Role::all();
        return view('users.edit', compact('user', 'roles'));
    }

    // Mettre à jour l’utilisateur
    public function update(Request $request, User $user)
    {
        $validated = $request->validate([
            'nom' => 'required|string|max:255',
            'prenom' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'password' => 'nullable|confirmed|min:8',
            'role' => 'required|string',
        ]);

        $user->update([
            'nom' => strip_tags($validated['nom']),
            'prenom' => strip_tags($validated['prenom']),
            'email' => strtolower($validated['email']),
            'password' => !empty($validated['password'])
                ? Hash::make($validated['password'])
                : $user->password,
        ]);

        $user->syncRoles($validated['role']);

        return redirect()
            ->route('admin.users.index')
            ->with('success', 'Utilisateur mis à jour.');
    }

    // Supprimer un utilisateur
    public function destroy(User $user)
    {
        $user->delete();
        return redirect()->route('users.index')->with('success', 'Utilisateur supprimé.');
    }
    public function activate(User $user)
    {
        $user->update([
            'is_active' => true
        ]);

        return back()->with(
            'success',
            'Utilisateur activé'
        );
    }
    public function deactivate(User $user)
    {
        $user->update([

            'is_active' => false
        ]);

        return back()->with(
            'success',
            'Utilisateur désactivé'
        );
    }
   
}
