<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\Document;
use App\Models\Payment;
use Illuminate\Support\Facades\Auth;

class PublicDocumentController extends Controller
{
    /**
     * --------------------------------------------------------------------------
     * LISTE DES DOCUMENTS PUBLIÉS
     * --------------------------------------------------------------------------
     */
    public function index()
    {
        $documents = Document::query()
            ->with('staff')
            ->where('status', 'published')
            ->latest()
            ->paginate(12);

        return view(
            'PublicDoc.index',
            compact('documents')
        );
    }

    /**
     * --------------------------------------------------------------------------
     * DÉTAIL D'UN DOCUMENT
     * --------------------------------------------------------------------------
     *
     * Cette page est publique.
     *
     * Elle n'envoie jamais directement le fichier PDF.
     */
    public function show(Document $document)
    {
        /*
        |--------------------------------------------------------------------------
        | DOCUMENT PUBLIÉ
        |--------------------------------------------------------------------------
        */

        abort_unless(
            $document->status === 'published',
            404
        );

        /*
        |--------------------------------------------------------------------------
        | UTILISATEUR WEB
        |--------------------------------------------------------------------------
        |
        | Le paiement concerne uniquement App\Models\User.
        |
        */

        $hasPaid = false;

        if (
            Auth::guard('web')->check() &&
            $document->isPremium()
        ) {
            $hasPaid = Payment::query()
                ->where(
                    'user_id',
                    Auth::guard('web')->id()
                )
                ->where(
                    'document_id',
                    $document->id
                )
                ->where(
                    'status',
                    'paid'
                )
                ->exists();
        }

        /*
        |--------------------------------------------------------------------------
        | STAFF AUTORISÉ
        |--------------------------------------------------------------------------
        */

        $staffCanRead = false;

        if (Auth::guard('staff')->check()) {

            $staff = Auth::guard('staff')->user();

            $staffCanRead = in_array(
                $staff->role_alias,
                [
                    'admin',
                    'journalist',
                ],
                true
            );
        }

        return view(
            'PublicDoc.show',
            compact(
                'document',
                'hasPaid',
                'staffCanRead'
            )
        );
    }

    /**
     * --------------------------------------------------------------------------
     * LECTURE DU DOCUMENT
     * --------------------------------------------------------------------------
     *
     * FREE:
     *      accès direct
     *
     * PREMIUM:
     *      - staff admin/journaliste → accès direct
     *      - User web → paiement confirmé obligatoire
     */
    public function read(Document $document)
    {
        /*
        |--------------------------------------------------------------------------
        | DOCUMENT PUBLIÉ
        |--------------------------------------------------------------------------
        */

        abort_unless(
            $document->status === 'published',
            404
        );

        /*
        |--------------------------------------------------------------------------
        | FICHIER PDF
        |--------------------------------------------------------------------------
        */

        $path = storage_path(
            'app/public/' . $document->file_path
        );

        if (!file_exists($path)) {
            abort(
                404,
                'Fichier introuvable.'
            );
        }

        /*
        |--------------------------------------------------------------------------
        | DOCUMENT GRATUIT
        |--------------------------------------------------------------------------
        */

        if (!$document->isPremium()) {

            $document->increment('views');

            return response()->file($path);
        }

        /*
        |--------------------------------------------------------------------------
        | DOCUMENT PREMIUM
        |--------------------------------------------------------------------------
        */

        /*
        |--------------------------------------------------------------------------
        | 1. STAFF : ADMIN / JOURNALISTE
        |--------------------------------------------------------------------------
        |
        | Le staff de gestion n'a pas besoin d'un Payment utilisateur.
        |
        */

        if (Auth::guard('staff')->check()) {

            $staff = Auth::guard('staff')->user();

            if (
                in_array(
                    $staff->role_alias,
                    [
                        'admin',
                        'journalist',
                    ],
                    true
                )
            ) {
                $document->increment('views');

                return response()->file($path);
            }
        }

        /*
        |--------------------------------------------------------------------------
        | 2. USER WEB : CONNEXION
        |--------------------------------------------------------------------------
        */

        if (!Auth::guard('web')->check()) {

            return redirect()
                ->route('login')
                ->with(
                    'error',
                    'Veuillez vous connecter pour accéder à ce document premium.'
                );
        }

        /*
        |--------------------------------------------------------------------------
        | 3. USER WEB : PAIEMENT CONFIRMÉ
        |--------------------------------------------------------------------------
        */

        $hasPaid = Payment::query()
            ->where(
                'user_id',
                Auth::guard('web')->id()
            )
            ->where(
                'document_id',
                $document->id
            )
            ->where(
                'status',
                'paid'
            )
            ->exists();

        /*
        |--------------------------------------------------------------------------
        | 4. PAIEMENT NON CONFIRMÉ
        |--------------------------------------------------------------------------
        */

        if (!$hasPaid) {

            return redirect()
                ->route(
                    'payments.create',
                    [
                        'document' => $document->id,
                    ]
                )
                ->with(
                    'info',
                    'Le paiement est requis pour accéder à ce document premium.'
                );
        }

        /*
        |--------------------------------------------------------------------------
        | 5. ACCÈS AUTORISÉ
        |--------------------------------------------------------------------------
        */

        $document->increment('views');

        return response()->file($path);
    }
}
