<?php

namespace App\Http\Controllers\Users;

use App\Http\Controllers\Controller;
use App\Models\Document;
use App\Models\Payment;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class JournalistController extends Controller
{
    /**
     * --------------------------------------------------------------------------
     * CONSTRUCTEUR
     * --------------------------------------------------------------------------
     *
     * Protection supplémentaire des actions du journaliste.
     *
     * Les routes possèdent déjà ces middlewares, mais les conserver ici
     * permet de protéger le contrôleur même si une route est modifiée
     * ultérieurement.
     */
    public function __construct()
    {
        $this->middleware([
            'auth:staff',
            'role:journalist',
        ]);
    }


    /**
     * --------------------------------------------------------------------------
     * JOURNALISTE CONNECTÉ
     * --------------------------------------------------------------------------
     */
    private function staff()
    {
        return Auth::guard('staff')->user();
    }


    /**
     * --------------------------------------------------------------------------
     * DOCUMENTS DU JOURNALISTE
     * --------------------------------------------------------------------------
     *
     * IMPORTANT :
     * Toutes les statistiques utilisent cette requête.
     *
     * Un journaliste ne peut donc pas récupérer les documents
     * d'un autre journaliste.
     */
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


    /*
    |--------------------------------------------------------------------------
    | TABLEAU DE BORD
    |--------------------------------------------------------------------------
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


        /*
        |--------------------------------------------------------------------------
        | REVENUS
        |--------------------------------------------------------------------------
        */

        $payments = $this->myPayments();

        $revenue = (clone $payments)
            ->sum('amount');

        $totalPayments = (clone $payments)
            ->count();


        /*
        |--------------------------------------------------------------------------
        | TÉLÉCHARGEMENTS
        |--------------------------------------------------------------------------
        |
        | Pour le moment aucune colonne downloads n'est utilisée.
        |
        */

        $totalDownloads = 0;


        /*
        |--------------------------------------------------------------------------
        | VUE
        |--------------------------------------------------------------------------
        */

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

        /*
        |--------------------------------------------------------------------------
        | STATISTIQUES
        |--------------------------------------------------------------------------
        */

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


        /*
        |--------------------------------------------------------------------------
        | VUES PAR DOCUMENT
        |--------------------------------------------------------------------------
        */

        $viewsByDocument = (clone $documents)
            ->select([
                'id',
                'title',
                'views',
            ])
            ->orderByDesc('views')
            ->get();


        /*
        |--------------------------------------------------------------------------
        | VUE
        |--------------------------------------------------------------------------
        */

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

        /*
        |--------------------------------------------------------------------------
        | PAIEMENTS
        |--------------------------------------------------------------------------
        */

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


        /*
        |--------------------------------------------------------------------------
        | NOMBRE DE PAIEMENTS
        |--------------------------------------------------------------------------
        */

        $totalPayments = (clone $paymentsQuery)
            ->count();


        /*
        |--------------------------------------------------------------------------
        | VUE
        |--------------------------------------------------------------------------
        */

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
    | PROFIL
    |--------------------------------------------------------------------------
    */

    public function profile()
    {
        $staff = $this->staff();
          


        return view(
            'profile.index',
            compact('staff')
        );
    }


    /*
    |--------------------------------------------------------------------------
    | UTILISATEURS
    |--------------------------------------------------------------------------
    */

    public function users()
    {
        /*
        |--------------------------------------------------------------------------
        | IMPORTANT
        |--------------------------------------------------------------------------
        |
        | Cette méthode correspond à ta route :
        |
        | GET /journaliste/users
        |
        | Si un journaliste ne doit PAS voir tous les utilisateurs,
        | il faudra ajouter une règle métier spécifique ici.
        |
        */

        $users = User::query()
            ->latest()
            ->paginate(15);

        return view(
            'dashboard.journaliste_users',
            compact('users')
        );
    }
}