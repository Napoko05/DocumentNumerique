<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
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
     */
    public function store(Request $request): RedirectResponse
    {
        // Validation des données
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:'.User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        // Création de l'utilisateur
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        // Déclenchement de l’événement Registered (utile si tu envoies des mails de confirmation)
        event(new Registered($user));

        // ⚠️ On ne connecte PAS l’utilisateur ici (donc pas de Auth::login($user))

        // Redirection vers la page de connexion
        return redirect()->route('login')->with('success', 'Inscription réussie, veuillez vous connecter.');
    }
}
