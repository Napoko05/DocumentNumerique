<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Staff;

class LoginController extends Controller
{
    /**
     * URL par défaut après connexion.
     */
    protected $redirectTo = '/home';

    /**
     * Constructeur.
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    // =========================================================
    // FORMULAIRE DE CONNEXION
    // =========================================================

    public function showLoginForm()
    {
        return view('auth.login');
    }

    // =========================================================
    // CONNEXION PRINCIPALE
    // =========================================================

    public function login(Request $request)
    {
        $request->validate([
            'login' => [
                'required',
                'string',
            ],

            'password' => [
                'required',
                'string',
            ],
        ], [
            'login.required' => 'Veuillez saisir votre email, numéro de téléphone ou matricule.',
            'password.required' => 'Veuillez saisir votre mot de passe.',
        ]);

        $user = $this->attemptLogin($request);

        // =====================================================
        // CONNEXION RÉUSSIE
        // =====================================================

        if ($user) {

            // Régénération de session pour la sécurité
            $request->session()->regenerate();

            return $this->authenticated($request, $user);
        }

        // =====================================================
        // ÉCHEC DE CONNEXION
        // =====================================================

        return back()
            ->withErrors([
                'login' => 'Identifiants incorrects.',
            ])
            ->withInput($request->only('login'));
    }

    // =========================================================
    // TENTATIVE DE CONNEXION
    // =========================================================

    protected function attemptLogin(Request $request)
    {
        $login = trim($request->login);

        $remember = $request->boolean('remember');

        // =====================================================
        // 1. USER : EMAIL
        // =====================================================

        if (filter_var($login, FILTER_VALIDATE_EMAIL)) {

            if (
                Auth::guard('web')->attempt(
                    [
                        'email' => $login,
                        'password' => $request->password,
                    ],
                    $remember
                )
            ) {
                return Auth::guard('web')->user();
            }
        }

        // =====================================================
        // 2. USER : NUMÉRO DE TÉLÉPHONE
        // =====================================================

        if (
            Auth::guard('web')->attempt(
                [
                    'numero' => $login,
                    'password' => $request->password,
                ],
                $remember
            )
        ) {
            return Auth::guard('web')->user();
        }

        // =====================================================
        // 3. STAFF : MATRICULE
        // =====================================================

        if (
            Auth::guard('staff')->attempt(
                [
                    'matricule' => $login,
                    'password' => $request->password,
                ],
                $remember
            )
        ) {
            return Auth::guard('staff')->user();
        }

        // =====================================================
        // AUCUNE CORRESPONDANCE
        // =====================================================

        return null;
    }

    // =========================================================
    // REDIRECTION APRÈS CONNEXION
    // =========================================================

    protected function authenticated(Request $request, $user)
    {
        session()->flash('success', 'Connexion réussie !');

        // =====================================================
        // UTILISATEUR SIMPLE
        // =====================================================

        if ($user instanceof User) {

            return redirect()->intended(
                route('home')
            );
        }

        // =====================================================
        // STAFF
        // =====================================================

        if ($user instanceof Staff) {

            // Vérification du rôle
            if (empty($user->role_alias)) {

                Auth::guard('staff')->logout();

                return redirect()
                    ->route('login')
                    ->withErrors([
                        'login' => 'Aucun rôle attribué à ce compte.',
                    ]);
            }

            // =================================================
            // REDIRECTION SELON LE RÔLE
            // =================================================

            return match ($user->role_alias) {

                'admin' =>
                    redirect()->route('admin.dashboard'),

                'journalist' =>
                    redirect()->route('journaliste.dashboard'),

                default =>
                    redirect()->route('home'),
            };
        }

        // =====================================================
        // CAS PAR DÉFAUT
        // =====================================================

        return redirect()->route('home');
    }

    // =========================================================
    // DÉCONNEXION
    // =========================================================

    public function logout(Request $request)
    {
        // Déconnexion User
        Auth::guard('web')->logout();

        // Déconnexion Staff
        Auth::guard('staff')->logout();

        // Invalidation de la session
        $request->session()->invalidate();

        // Nouveau token CSRF
        $request->session()->regenerateToken();

        return redirect()->route('home');
    }
}