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

    public function editProfil(User $journaliste)
{
    abort_unless($journaliste->hasRole('journaliste'), 404);

    return view(
        'admin.staff.journalistes.edit',
        compact('journaliste')
    );
}

public function updateProfil(Request $request, User $journaliste)
{
    abort_unless($journaliste->hasRole('journaliste'), 404);

    $validated = $request->validate([
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
        'sexe' => [
            'required',
            'in:Masculin,Féminin',
        ],
        'email' => [
            'required',
            'email',
            'max:255',
            'unique:users,email,' . $journaliste->id,
        ],
        'tel' => [
            'nullable',
            'string',
            'max:30',
        ],
        'date_naissance' => [
            'nullable',
            'date',
        ],
    ]);

    $journaliste->update($validated);

    return redirect()
        ->route(
            'admin.staff.journalistes.editProfil',
            $journaliste
        )
        ->with(
            'success',
            'Les informations du journaliste ont été modifiées avec succès.'
        );
}

public function editPassword(User $journaliste)
{
    abort_unless($journaliste->hasRole('journaliste'), 404);

    return view(
        'admin.staff.journalistes.password',
        compact('journaliste')
    );
}

public function updatePassword(Request $request, User $journaliste)
{
    abort_unless($journaliste->hasRole('journaliste'), 404);

    $validated = $request->validate([
        'password' => [
            'required',
            'string',
            'min:8',
            'confirmed',
        ],
    ]);

    $journaliste->update([
        'password' => Hash::make($validated['password']),
    ]);

    return redirect()
        ->route(
            'admin.staff.journalistes.editPassword',
            $journaliste
        )
        ->with(
            'success',
            'Le mot de passe du journaliste a été modifié avec succès.'
        );
}

}