<?php

namespace App\Http\Controllers\Users;

use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;
use App\Http\Controllers\Controller;
use App\Models\Document;
use App\Models\Payment;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class JournalistController extends Controller
{

    /**
     * --------------------------------------------------------------------------
     * JOURNALISTE CONNECTÉ
     * --------------------------------------------------------------------------
     */
    private function staff()
    {
        return Auth::guard('staff')->user();
    }


    private function myDocuments()
    {
        $staff = $this->staff();

        return Document::query()
            ->where('staff_id', $staff->id);
    }


    /**
     * --------------------------------------------------------------------------
     * PAIEMENTS DU JOURNALISTE
     * --------------------------------------------------------------------------
     *
     * Un paiement est considéré ici uniquement s'il est payé.
     *
     * Le paiement doit obligatoirement être lié à un document appartenant
     * au journaliste connecté.
     */
    private function myPayments()
    {
        $staff = $this->staff();

        return Payment::query()
            ->where('status', 'paid')
            ->whereHas('document', function ($query) use ($staff) {
                $query->where('staff_id', $staff->id);
            });
    }


    /**
     * --------------------------------------------------------------------------
     * TABLEAU DE BORD
     * --------------------------------------------------------------------------
     */
    public function dashboard()
    {
        $staff = $this->staff();

        $documents = $this->myDocuments();

        /*
        |--------------------------------------------------------------------------
        | STATISTIQUES DOCUMENTS
        |--------------------------------------------------------------------------
        */

        $totalDocuments = (clone $documents)->count();

        $publishedDocuments = (clone $documents)
            ->where('status', 'published')
            ->count();

        $pendingDocuments = (clone $documents)
            ->where('status', 'pending')
            ->count();

        $draftDocuments = (clone $documents)
            ->where('status', 'draft')
            ->count();

        $rejectedDocuments = (clone $documents)
            ->where('status', 'rejected')
            ->count();

        $freeDocuments = (clone $documents)
            ->where('access_type', 'free')
            ->count();

        $premiumDocuments = (clone $documents)
            ->where('access_type', 'premium')
            ->count();

        $totalViews = (clone $documents)
            ->sum('views');


        /*
        |--------------------------------------------------------------------------
        | DOCUMENTS RÉCENTS
        |--------------------------------------------------------------------------
        */

        $recentDocuments = (clone $documents)
            ->with([
                'formation',
                'filiere',
                'level',
                'subject',
                'documentType',
            ])
            ->latest()
            ->limit(10)
            ->get();

        $payments = $this->myPayments();

        $revenue = (clone $payments)
            ->sum('amount');

        $totalPayments = (clone $payments)
            ->count();

        $totalDownloads = 0;

        return view(
            'dashboard.journaliste_dashboard',
            compact(
                'staff',
                'recentDocuments',

                'totalDocuments',
                'publishedDocuments',
                'pendingDocuments',
                'draftDocuments',
                'rejectedDocuments',

                'freeDocuments',
                'premiumDocuments',

                'totalViews',
                'totalDownloads',

                'revenue',
                'totalPayments'
            )
        );
    }


    /*
    |--------------------------------------------------------------------------
    | STATISTIQUES
    |--------------------------------------------------------------------------
    */

    public function statistics()
    {
        $documents = $this->myDocuments();

        $totalDocuments = (clone $documents)
            ->count();

        $publishedDocuments = (clone $documents)
            ->where('status', 'published')
            ->count();

        $pendingDocuments = (clone $documents)
            ->where('status', 'pending')
            ->count();

        $draftDocuments = (clone $documents)
            ->where('status', 'draft')
            ->count();

        $rejectedDocuments = (clone $documents)
            ->where('status', 'rejected')
            ->count();

        $freeDocuments = (clone $documents)
            ->where('access_type', 'free')
            ->count();

        $premiumDocuments = (clone $documents)
            ->where('access_type', 'premium')
            ->count();

        $totalViews = (clone $documents)
            ->sum('views');


        $viewsByDocument = (clone $documents)
            ->select([
                'id',
                'title',
                'views',
            ])
            ->orderByDesc('views')
            ->get();

        return view(
            'dashboard.journaliste_statistics',
            compact(
                'totalDocuments',

                'publishedDocuments',
                'pendingDocuments',
                'draftDocuments',
                'rejectedDocuments',

                'freeDocuments',
                'premiumDocuments',

                'totalViews',
                'viewsByDocument'
            )
        );
    }


    /*
    |--------------------------------------------------------------------------
    | REVENUS
    |--------------------------------------------------------------------------
    */

    public function revenues()
    {
        $paymentsQuery = $this->myPayments();

        $payments = (clone $paymentsQuery)
            ->with('document')
            ->latest()
            ->paginate(15);


        /*
        |--------------------------------------------------------------------------
        | TOTAL REVENUS
        |--------------------------------------------------------------------------
        */

        $totalRevenue = (clone $paymentsQuery)
            ->sum('amount');

        $totalPayments = (clone $paymentsQuery)
            ->count();

        return view(
            'dashboard.journaliste_revenues',
            compact(
                'payments',
                'totalRevenue',
                'totalPayments'
            )
        );
    }


    /*
    |--------------------------------------------------------------------------
    | PAIEMENTS
    |--------------------------------------------------------------------------
    */

    public function payments()
    {
        $paymentsQuery = $this->myPayments();

        $payments = (clone $paymentsQuery)
            ->with('document')
            ->latest()
            ->paginate(15);

        $totalRevenue = (clone $paymentsQuery)
            ->sum('amount');

        $totalPayments = (clone $paymentsQuery)
            ->count();

        return view(
            'dashboard.journaliste_payments',
            compact(
                'payments',
                'totalRevenue',
                'totalPayments'
            )
        );
    }


    /*
    |--------------------------------------------------------------------------
    | PROFIL DU JOURNALISTE
    |--------------------------------------------------------------------------
    */

    /**
     * Afficher le profil du journaliste connecté.
     */
    public function profil(Request $request): View
    {
        $journaliste = $this->staff();

        return view('profile.journaliste.edit', [
            'journaliste' => $journaliste,
        ]);
    }
    public function updateProfil(Request $request): RedirectResponse
    {
        $journaliste = $this->staff();

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

            'sexe' => [
                'required',
                'in:Masculin,Féminin',
            ],

            'date_naissance' => [
                'nullable',
                'date',
            ],

            'lieu_naissance' => [
                'nullable',
                'string',
                'max:150',
            ],

            'ville' => [
                'nullable',
                'string',
                'max:100',
            ],

            'specialite' => [
                'nullable',
                'string',
                'max:150',
            ],

            'tel' => [
                'nullable',
                'string',
                'max:30',
            ],

            'email' => [
                'required',
                'string',
                'email',
                'max:255',
                Rule::unique('staff', 'email')
                    ->ignore($journaliste->id),
            ],
        ], [
            'nom.required' =>
                'Le nom est obligatoire.',

            'prenom.required' =>
                'Le prénom est obligatoire.',

            'sexe.required' =>
                'Le sexe est obligatoire.',

            'sexe.in' =>
                'Veuillez sélectionner un sexe valide.',

            'date_naissance.date' =>
                'La date de naissance n’est pas valide.',

            'email.required' =>
                'L’adresse email est obligatoire.',

            'email.email' =>
                'Veuillez saisir une adresse email valide.',

            'email.unique' =>
                'Cette adresse email est déjà utilisée.',
        ]);

        /*
        |--------------------------------------------------------------------------
        | CHAMPS MODIFIABLES PAR LE JOURNALISTE
        |--------------------------------------------------------------------------
      
        */

        $journaliste->nom = $validated['nom'];
        $journaliste->prenom = $validated['prenom'];
        $journaliste->sexe = $validated['sexe'];
        $journaliste->date_naissance =
            $validated['date_naissance'] ?? null;

        $journaliste->lieu_naissance =
            $validated['lieu_naissance'] ?? null;

        $journaliste->ville =
            $validated['ville'] ?? null;

        $journaliste->specialite =
            $validated['specialite'] ?? null;

        $journaliste->tel =
            $validated['tel'] ?? null;

        $journaliste->email =
            $validated['email'];

        $journaliste->save();

        return redirect()
            ->route('journaliste.profil')
            ->with(
                'success',
                'Votre profil a été mis à jour avec succès.'
            );
    }


    /*
    |--------------------------------------------------------------------------
    | MOT DE PASSE DU JOURNALISTE
    |--------------------------------------------------------------------------
    */

    /**
     * Afficher la page de modification du mot de passe.
     */
    public function editPassword(Request $request): View
    {
        $journaliste = $this->staff();

        return view('profile.journaliste.password', [
            'journaliste' => $journaliste,
        ]);
    }


    /**
     * Modifier le mot de passe du journaliste connecté.
     *
     * Le journaliste doit obligatoirement fournir
     * son ancien mot de passe.
     */
    public function updatePassword(Request $request): RedirectResponse
    {
        $journaliste = $this->staff();

        $validated = $request->validate([
            'current_password' => [
                'required',
                'current_password:staff',
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

        $journaliste->password = Hash::make(
            $validated['password']
        );

        $journaliste->save();

        return redirect()
            ->route('journaliste.profil')
            ->with(
                'success',
                'Votre mot de passe a été modifié avec succès.'
            );
    }
    /*============================
      Rrcuperation du mot de passe par mail ou numero
/**
 * Affiche le formulaire "Mot de passe oublié".
 *
 * Cette page est volontairement publique.
 */
public function showForgotPasswordForm(): View
{
    return view('profile.journaliste.forgot_password');
}

/**
 * Envoie le lien de réinitialisation du mot de passe.
 *
 * Utilise exclusivement le broker "staff".
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

    $status = Password::broker('staff')->sendResetLink(
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
        ->with('error', 'Impossible d’envoyer le lien de réinitialisation. Vérifiez l’adresse email saisie.');
}

/**
 * Affiche le formulaire permettant de définir un nouveau mot de passe.
 */
public function showResetPasswordForm(string $token): View
{
    return view('profile.journaliste.reset_password', [
        'token' => $token,
        'email' => request()->query('email'),
    ]);
}

/**
 * Réinitialise réellement le mot de passe du journaliste.
 *
 * Utilise exclusivement le broker "staff".
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

    $status = Password::broker('staff')->reset(
        [
            'email' => $validated['email'],
            'password' => $validated['password'],
            'password_confirmation' => $request->input('password_confirmation'),
            'token' => $validated['token'],
        ],
        function ($staff, $password) {
            $staff->password = Hash::make($password);

            /*
             * Régénère le remember token si le modèle Staff
             * utilise le mécanisme "remember me".
             */
            $staff->setRememberToken(Str::random(60));

            $staff->save();
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
        ->with('error', 'Impossible de réinitialiser le mot de passe. Le lien est peut-être expiré ou invalide.');
}

}
