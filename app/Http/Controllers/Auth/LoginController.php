<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Staff;

class LoginController extends Controller
{
    protected $redirectTo = '/home';

    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    // =========================
    // FORM LOGIN
    // =========================
    public function showLoginForm()
    {
        return view('auth.login');
    }

    // =========================
    // LOGIN PRINCIPAL
    // =========================
    public function login(Request $request)
    {
        $request->validate([
            'login'    => ['required', 'string'],
            'password' => ['required', 'string'],
        ]);

        $user = $this->attemptLogin($request);

        if ($user) {

            $request->session()->regenerate();

            return $this->authenticated($request, $user);
        }

        return back()
            ->withErrors([
                'login' => 'Identifiants incorrects.',
            ])
            ->onlyInput('login');
    }

    // =========================
    // TENTATIVE DE CONNEXION
    // =========================
    protected function attemptLogin(Request $request)
    {
        $login = trim($request->login);

        // =========================
        // USER (EMAIL)
        // =========================
        if (filter_var($login, FILTER_VALIDATE_EMAIL)) {

            if (
                Auth::guard('web')->attempt(
                    [
                        'email' => $login,
                        'password' => $request->password,
                    ],
                    $request->boolean('remember')
                )
            ) {
                return Auth::guard('web')->user();
            }
        }

        // =========================
        // STAFF (MATRICULE)
        // =========================
        if (
            Auth::guard('staff')->attempt(
                [
                    'matricule' => $login,
                    'password' => $request->password,
                ],
                $request->boolean('remember')
            )
        ) {

            return Auth::guard('staff')->user();
        }

        return null;
    }

    // =========================
    // REDIRECTION APRES LOGIN
    // =========================
    protected function authenticated(Request $request, $user)
    {
       
        session()->flash('success', 'Connexion réussie !');

        // =========================
        // UTILISATEUR SIMPLE
        // =========================
        if ($user instanceof User) {
            return redirect()->route('home');
        }

        // =========================
        // STAFF
        // =========================
        if ($user instanceof Staff) {

            if (empty($user->role_alias)) {

                Auth::guard('staff')->logout();

                return redirect()
                    ->route('login')
                    ->withErrors([
                        'login' => 'Aucun rôle attribué à ce compte.',
                    ]);
            }

            return match ($user->role_alias) {

                'admin' => redirect()->route('admin.dashboard'),

                'journalist' => redirect()->route('journalist.dashboard'),

                default => redirect()->route('home'),
            };
        }

        return redirect()->route('home');
    }

    // =========================
    // LOGOUT
    // =========================
    public function logout(Request $request)
    {
        Auth::guard('web')->logout();
        Auth::guard('staff')->logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('home');
    }
}
