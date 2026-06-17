<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class RegisterController extends Controller
{
    public function __construct()
    {
        $this->middleware('guest');
    }

    public function showRegistrationForm()
    {
        return view('auth.register');
    }

    public function register(Request $request)
    {
        // =========================
        // VALIDATION
        // =========================
        $request->validate([
            'nom' => ['required', 'string', 'max:255'],
            'prenom' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', 'unique:users,email'],
            'password' => [
                'required',
                'string',
                'min:8',
                'confirmed',
                'regex:/[a-z]/',
                'regex:/[A-Z]/',
                'regex:/[0-9]/',
                'regex:/[@$!%*#?&]/'
            ],
        ], [
            'password.regex' => 'Le mot de passe doit contenir majuscule, minuscule, chiffre et caractère spécial.',
        ]);

        // =========================
        // CREATION USER + ALIAS
        // =========================
        $user = User::create([
            'nom' => $request->nom,
            'prenom' => $request->prenom,
            'email' => $request->email,
            'password' => Hash::make($request->password),

            // 🔥 ALIAS SYSTEM
            'role_alias' => 'user',
            'role_label' => 'Utilisateur',

            'statut_compte' => 'actif',
            'is_active' => true,
        ]);

        // =========================
        // ROLE SPATIE (toujours utile)
        // =========================
        $user->assignRole('user');

        // =========================
        // LOGOUT (sécurité)
        // =========================
        auth()->logout();

        return redirect()->route('login')
            ->with('success', 'Compte créé avec succès. Connectez-vous.');
    }
}