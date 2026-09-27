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
            'nom' => [
                'required',
                'string',
                'max:255',
            ],

            'prenom' => [
                'required',
                'string',
                'max:255',
            ],

            'email' => [
                'required',
                'email',
                'max:255',
                'unique:users,email',
            ],

            'numero' => [
                'required',
                'string',
                'max:255',
                'unique:users,numero',
            ],

            'password' => [
                'required',
                'string',
                'min:8',
                'confirmed',
                'regex:/[a-z]/',
                'regex:/[A-Z]/',
                'regex:/[0-9]/',
                'regex:/[@$!%*#?&]/',
            ],

        ], [

            'nom.required' => 'Le nom est obligatoire.',
            'prenom.required' => 'Le prénom est obligatoire.',

            'email.required' => 'L’adresse e-mail est obligatoire.',
            'email.email' => 'Veuillez saisir une adresse e-mail valide.',
            'email.unique' => 'Cette adresse e-mail est déjà utilisée.',

            'numero.required' => 'Le numéro de téléphone est obligatoire.',
            'numero.unique' => 'Ce numéro de téléphone est déjà utilisé.',

            'password.required' => 'Le mot de passe est obligatoire.',
            'password.min' => 'Le mot de passe doit contenir au moins 8 caractères.',
            'password.confirmed' => 'La confirmation du mot de passe ne correspond pas.',

            'password.regex' =>
                'Le mot de passe doit contenir une majuscule, une minuscule, un chiffre et un caractère spécial.',
        ]);

        // =========================
        // CREATION USER + ALIAS
        // =========================
        $user = User::create([
            'nom' => $request->nom,
            'prenom' => $request->prenom,
            'email' => $request->email,

            // NUMÉRO DE TÉLÉPHONE
            'numero' => $request->numero,

            'password' => Hash::make($request->password),

            // =========================
            // ALIAS SYSTEM
            // =========================
            'role_alias' => 'user',
            'role_label' => 'Utilisateur',

            'statut_compte' => 'actif',
            'is_active' => true,
        ]);

        // =========================
        // ROLE SPATIE
        // =========================
        $user->assignRole('user');

        // =========================
        // LOGOUT (sécurité)
        // =========================
        auth()->logout();

        // =========================
        // REDIRECTION
        // =========================
        return redirect()
            ->route('login')
            ->with(
                'success',
                'Compte créé avec succès. Connectez-vous.'
            );
    }
}
