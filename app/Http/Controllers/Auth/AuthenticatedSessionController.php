<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AuthenticatedSessionController extends Controller
{
    /**
     * Affiche le formulaire de connexion.
     */
    public function create(): View
    {
        return view('auth.login');
    }

    /**
     * Traite la connexion.
     */
    public function store(LoginRequest $request): RedirectResponse
    {
        // Authentification
        $request->authenticate();

        // Regénérer la session pour sécurité
        $request->session()->regenerate();

        // Récupérer l'utilisateur connecté
        $user = Auth::user();

        // Redirection par rôle
        if ($user->hasRole('admin')) {
            return redirect()->route('admin.dashboard')
                ->with('success', 'Bienvenue sur le tableau de bord Admin.');
        }

        if ($user->hasRole('journalist')) {
            return redirect()->route('journalist.dashboard')
                ->with('success', 'Bienvenue sur le tableau de bord Journaliste.');
        }

        // Utilisateur simple → accueil avec statut connecté
        return redirect()->route('home')
            ->with('success', 'Connexion réussie. Vous êtes connecté en tant qu’utilisateur.');
    }

    /**
     * Déconnexion de l'utilisateur.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('home')
            ->with('success', 'Déconnexion réussie.');
    }
}
