<?php

namespace App\Http\Controllers\Users;

use App\Http\Controllers\Controller;
use App\Models\Document;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class JournalistController extends Controller
{
    /**
     * Protection des pages journaliste.
     */
    public function __construct()
    {
        $this->middleware([
            'auth:staff',
            'role:journalist',
        ]);
    }


    /*
    |--------------------------------------------------------------------------
    | TABLEAU DE BORD JOURNALISTE
    |--------------------------------------------------------------------------
    */

    public function dashboard()
    {
        /*
        |--------------------------------------------------------------------------
        | JOURNALISTE CONNECTÉ
        |--------------------------------------------------------------------------
        */

        $staff = Auth::guard('staff')->user();


        /*
        |--------------------------------------------------------------------------
        | REQUÊTE DE BASE
        |--------------------------------------------------------------------------
        |
        | Tous les documents appartenant
        | au journaliste connecté.
        |
        */

        $documentsQuery = Document::where(
            'staff_id',
            $staff->id
        );


        /*
        |--------------------------------------------------------------------------
        | STATISTIQUES
        |--------------------------------------------------------------------------
        */

        $statistics = $documentsQuery
            ->selectRaw('
                COUNT(*) AS total_documents,

                SUM(
                    CASE
                        WHEN status = "published"
                        THEN 1
                        ELSE 0
                    END
                ) AS published_documents,

                SUM(
                    CASE
                        WHEN status = "pending"
                        THEN 1
                        ELSE 0
                    END
                ) AS pending_documents,

                SUM(
                    CASE
                        WHEN status = "draft"
                        THEN 1
                        ELSE 0
                    END
                ) AS draft_documents,

                SUM(
                    CASE
                        WHEN status = "rejected"
                        THEN 1
                        ELSE 0
                    END
                ) AS rejected_documents,

                SUM(
                    CASE
                        WHEN access_type = "free"
                        THEN 1
                        ELSE 0
                    END
                ) AS free_documents,

                SUM(
                    CASE
                        WHEN access_type = "premium"
                        THEN 1
                        ELSE 0
                    END
                ) AS premium_documents,

                COALESCE(
                    SUM(views),
                    0
                ) AS total_views,

                COALESCE(
                    SUM(downloads),
                    0
                ) AS total_downloads
            ')
            ->first();


        /*
        |--------------------------------------------------------------------------
        | DOCUMENTS RÉCENTS
        |--------------------------------------------------------------------------
        |
        | Chargement des relations utilisées
        | dans le tableau du dashboard.
        |
        */

        $recentDocuments = Document::with([
            'formation',
            'filiere',
            'level',
            'subject',
            'documentType',
        ])
        ->where(
            'staff_id',
            $staff->id
        )
        ->latest()
        ->take(10)
        ->get();


        /*
        |--------------------------------------------------------------------------
        | RETOUR DE LA VUE
        |--------------------------------------------------------------------------
        */

        return view(
            'dashboard.journaliste_dashboard',
            [
                'staff' => $staff,

                /*
                |--------------------------------------------------------------
                | DOCUMENTS
                |--------------------------------------------------------------
                */

                'documents' => $recentDocuments,

                'recentDocuments' => $recentDocuments,


                /*
                |--------------------------------------------------------------
                | STATISTIQUES
                |--------------------------------------------------------------
                */

                'totalDocuments' =>
                    (int) (
                        $statistics->total_documents ?? 0
                    ),

                'publishedDocuments' =>
                    (int) (
                        $statistics->published_documents ?? 0
                    ),

                'pendingDocuments' =>
                    (int) (
                        $statistics->pending_documents ?? 0
                    ),

                'draftDocuments' =>
                    (int) (
                        $statistics->draft_documents ?? 0
                    ),

                'rejectedDocuments' =>
                    (int) (
                        $statistics->rejected_documents ?? 0
                    ),

                'freeDocuments' =>
                    (int) (
                        $statistics->free_documents ?? 0
                    ),

                'premiumDocuments' =>
                    (int) (
                        $statistics->premium_documents ?? 0
                    ),

                'totalViews' =>
                    (int) (
                        $statistics->total_views ?? 0
                    ),

                'totalDownloads' =>
                    (int) (
                        $statistics->total_downloads ?? 0
                    ),

            ]
        );
    }

    /*
    |--------------------------------------------------------------------------
    | LISTE DES UTILISATEURS
    |--------------------------------------------------------------------------
    |
    | Le journaliste peut uniquement
    | consulter les utilisateurs.
    |
    */

    public function users()
    {
        $users = User::with(
            'roles'
        )
        ->latest()
        ->paginate(15);


        return view(
            'users.index',
            compact('users')
        );
    }
}
