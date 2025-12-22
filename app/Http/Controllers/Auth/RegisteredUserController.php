<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    /**
     * Affiche le formulaire d'inscription.
     */
    public function create(): View
    {
        return view('auth.register');
    }

    /**
     * Traite la requête d'inscription.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        //  Validation stricte et sécurisée
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255', 'regex:/^[\pL\s\-]+$/u'],
            'email' => ['required', 'email:rfc,dns', 'max:255', 'unique:users,email'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        //  Création sécurisée de l'utilisateur
        $user = User::create([
            'name' => strip_tags($validated['name']),
            'email' => strtolower($validated['email']),
            'password' => Hash::make($validated['password']),
        ]);

        //  Événement Laravel (utile si tu veux envoyer un mail de bienvenue)
        event(new Registered($user));

        //  Connexion automatique
        Auth::login($user);

        //  Redirection vers la page d’accueil
        return redirect()->intended(RouteServiceProvider::HOME)->with('success', 'Inscription réussie.');
    }
}