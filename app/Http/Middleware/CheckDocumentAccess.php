<?php

namespace App\Http\Middleware;

use App\Models\Payment;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckDocumentAccess
{
    /**
     * Vérifie l'accès au document.
     *
     * Architecture :
     *
     * - Document gratuit → accès direct
     * - Staff admin/journaliste → accès direct
     * - User web → paiement confirmé obligatoire
     */
    public function handle(
        Request $request,
        Closure $next
    ) {
        /*
        |--------------------------------------------------------------------------
        | DOCUMENT
        |--------------------------------------------------------------------------
        */

        $document = $request->route('document');

        if (!$document) {
            abort(
                404,
                'Document introuvable.'
            );
        }

        /*
        |--------------------------------------------------------------------------
        | DOCUMENT GRATUIT
        |--------------------------------------------------------------------------
        */

        if (!$document->isPremium()) {
            return $next($request);
        }

        /*
        |--------------------------------------------------------------------------
        | STAFF
        |--------------------------------------------------------------------------
        |
        | Le staff ne passe pas par le système de paiement User.
        |
        | Admin et journaliste peuvent consulter les documents premium
        | directement.
        |
        */

        if (Auth::guard('staff')->check()) {

            $staff = Auth::guard('staff')->user();

            if (in_array(
                $staff->role_alias,
                [
                    'admin',
                    'journalist',
                ],
                true
            )) {
                return $next($request);
            }
        }

        /*
        |--------------------------------------------------------------------------
        | UTILISATEUR WEB
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
        | UTILISATEUR CONNECTÉ
        |--------------------------------------------------------------------------
        */

        $user = Auth::guard('web')->user();

        /*
        |--------------------------------------------------------------------------
        | PAIEMENT CONFIRMÉ
        |--------------------------------------------------------------------------
        */

        $hasPaid = Payment::query()
            ->where(
                'user_id',
                $user->id
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

        if ($hasPaid) {
            return $next($request);
        }

        /*
        |--------------------------------------------------------------------------
        | PAIEMENT REQUIS
        |--------------------------------------------------------------------------
        */

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
}
