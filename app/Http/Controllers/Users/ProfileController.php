<?php

namespace App\Http\Controllers\Users;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Illuminate\View\View;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;

class ProfileController extends Controller
{
    /**
     * Afficher le profil de l'utilisateur connecté.
     */
    public function edit(Request $request): View
    {
        $user = $request->user();

        return view('profile.user.edit', [
            'user' => $user,
        ]);
    }

    /**
     * Afficher la page de modification du mot de passe.
     */
    public function editPassword(Request $request): View
    {
        return view('profile.user.password');
    }

    /**
     * Mettre à jour les informations personnelles
     * de l'utilisateur connecté.
     */
    public function update(Request $request): RedirectResponse
    {
        $user = $request->user();

        $validated = $request->validate([
            'nom' => [
                'required',
                'string',
                'max:100',
            ],

            'prenom' => [
                'required',
                'string',
                'max:100',
            ],

            'email' => [
                'required',
                'string',
                'email',
                'max:255',
                Rule::unique('users', 'email')->ignore($user->id),
            ],

            'numero' => [
                'required',
                'string',
                'max:30',
            ],
        ], [
            'nom.required' =>
                'Le nom est obligatoire.',

            'prenom.required' =>
                'Le prénom est obligatoire.',

            'email.required' =>
                'L’adresse email est obligatoire.',

            'email.email' =>
                'Veuillez saisir une adresse email valide.',

            'email.unique' =>
                'Cette adresse email est déjà utilisée.',

            'numero.required' =>
                'Le numéro de téléphone est obligatoire.',
        ]);

        /*
         * Seuls les champs autorisés sont modifiés.
         * Aucun rôle ou champ administratif ne peut
         * être modifié depuis le profil utilisateur.
         */
        $user->nom = $validated['nom'];
        $user->prenom = $validated['prenom'];
        $user->email = $validated['email'];
        $user->numero = $validated['numero'];

        /*
         * Si l'utilisateur change son adresse email,
         * l'ancienne vérification ne doit plus être conservée.
         */
        if ($user->isDirty('email')) {
            $user->email_verified_at = null;
        }

        $user->save();

        return redirect()
            ->route('profile.edit')
            ->with(
                'success',
                'Votre profil a été mis à jour avec succès.'
            );
    }

    /**
     * Modifier le mot de passe de l'utilisateur connecté.
     *
     * L'ancien mot de passe est obligatoire.
     */
    public function updatePassword(Request $request): RedirectResponse
    {
        $user = $request->user();

        $validated = $request->validate([
            'current_password' => [
                'required',
                'current_password:web',
            ],

            'password' => [
                'required',
                'string',
                'min:8',
                'confirmed',
            ],
        ], [
            'current_password.required' =>
                'Votre mot de passe actuel est obligatoire.',

            'current_password.current_password' =>
                'Votre mot de passe actuel est incorrect.',

            'password.required' =>
                'Le nouveau mot de passe est obligatoire.',

            'password.min' =>
                'Le nouveau mot de passe doit contenir au moins 8 caractères.',

            'password.confirmed' =>
                'La confirmation du nouveau mot de passe ne correspond pas.',
        ]);

        /*
         * Enregistrer le nouveau mot de passe.
         */
        $user->password = Hash::make($validated['password']);

        $user->save();

        /*
         * Si le modèle User utilise Laravel Sanctum,
         * on invalide les tokens existants.
         *
         * La session web actuelle reste active.
         */
        if (method_exists($user, 'tokens')) {
            $user->tokens()->delete();
        }

        return redirect()
            ->route('profile.edit')
            ->with(
                'success',
                'Votre mot de passe a été modifié avec succès.'
            );
    }

    
/*
 * Affiche le formulaire "Mot de passe oublié".
 */
public function showForgotPasswordForm(): View
{
    return view('profile.user.forgot-password');
}


/**
 * Envoie le lien de réinitialisation par email.
 *
 * Utilise le broker "users".
 */
public function sendResetLink(Request $request): RedirectResponse
{
    $request->validate([
        'email' => [
            'required',
            'email',
            'max:255',
        ],
    ], [
        'email.required' => 'L’adresse email est obligatoire.',
        'email.email' => 'Veuillez saisir une adresse email valide.',
    ]);

    $status = Password::broker('users')->sendResetLink(
        $request->only('email')
    );

    if ($status === Password::RESET_LINK_SENT) {
        return back()->with(
            'success',
            'Un lien de réinitialisation a été envoyé à votre adresse email.'
        );
    }

    return back()
        ->withInput($request->only('email'))
        ->with(
            'error',
            'Impossible d’envoyer le lien de réinitialisation. Vérifiez l’adresse email saisie.'
        );
}


/**
 * Affiche le formulaire de définition du nouveau mot de passe.
 */
public function showResetPasswordForm(string $token): View
{
    return view('profile.user.reset-password', [
        'token' => $token,
        'email' => request()->query('email'),
    ]);
}


/**
 * Réinitialise réellement le mot de passe de l'utilisateur.
 *
 * Utilise exclusivement le broker "users".
 */
public function resetPassword(Request $request): RedirectResponse
{
    $validated = $request->validate([
        'token' => [
            'required',
            'string',
        ],
        'email' => [
            'required',
            'email',
            'max:255',
        ],
        'password' => [
            'required',
            'string',
            'min:8',
            'confirmed',
        ],
    ], [
        'token.required' => 'Le lien de réinitialisation est invalide.',
        'email.required' => 'L’adresse email est obligatoire.',
        'email.email' => 'Veuillez saisir une adresse email valide.',
        'password.required' => 'Le nouveau mot de passe est obligatoire.',
        'password.min' => 'Le nouveau mot de passe doit contenir au moins 8 caractères.',
        'password.confirmed' => 'La confirmation du nouveau mot de passe ne correspond pas.',
    ]);

    $status = Password::broker('users')->reset(
        [
            'email' => $validated['email'],
            'password' => $validated['password'],
            'password_confirmation' => $request->input('password_confirmation'),
            'token' => $validated['token'],
        ],
        function ($user, $password) {
            $user->password = Hash::make($password);
            $user->setRememberToken(Str::random(60));
            $user->save();
        }
    );

    if ($status === Password::PASSWORD_RESET) {
        return redirect()
            ->route('login')
            ->with(
                'success',
                'Votre mot de passe a été réinitialisé avec succès. Vous pouvez maintenant vous connecter.'
            );
    }

    return back()
        ->withInput($request->only('email'))
        ->with(
            'error',
            'Impossible de réinitialiser le mot de passe. Le lien est peut-être expiré ou invalide.'
        );
}


    /**
     * Supprimer le compte utilisateur.
     *
     * Cette méthode est conservée uniquement si la suppression
     * du compte est prévue dans les routes et dans l'interface.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $user = $request->user();

        $request->validate([
            'password' => [
                'required',
                'current_password:web',
            ],
        ], [
            'password.required' =>
                'Votre mot de passe est obligatoire pour supprimer le compte.',

            'password.current_password' =>
                'Votre mot de passe est incorrect.',
        ]);

        /*
         * Déconnexion du compte.
         */
        auth('web')->logout();

        /*
         * Invalidation complète de la session.
         */
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        /*
         * Suppression définitive du compte.
         */
        $user->delete();

        return redirect()
            ->route('login')
            ->with(
                'success',
                'Votre compte a été supprimé.'
            );
    }
}
