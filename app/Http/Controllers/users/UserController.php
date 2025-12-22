<?php

namespace App\Http\Controllers\users;

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
        $users = User::with('roles')->paginate(10);
        return view('users.index', compact('users'));
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
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|confirmed|min:8',
            'roles' => 'required|array',
        ]);

        $user = User::create([
            'name' => strip_tags($validated['name']),
            'email' => strtolower($validated['email']),
            'password' => Hash::make($validated['password']),
        ]);

        $user->syncRoles($validated['roles']); // Spatie

        return redirect()->route('users.index')->with('success', 'Utilisateur créé.');
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
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,'.$user->id,
            'password' => 'nullable|confirmed|min:8',
            'roles' => 'required|array',
        ]);

        $user->name = strip_tags($validated['name']);
        $user->email = strtolower($validated['email']);

        if (!empty($validated['password'])) {
            $user->password = Hash::make($validated['password']);
        }

        $user->save();
        $user->syncRoles($validated['roles']);

        return redirect()->route('users.index')->with('success', 'Utilisateur mis à jour.');
    }

    // Supprimer un utilisateur
    public function destroy(User $user)
    {
        $user->delete();
        return redirect()->route('users.index')->with('success', 'Utilisateur supprimé.');
    }
    
}
