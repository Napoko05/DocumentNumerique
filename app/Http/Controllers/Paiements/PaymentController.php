<?php

namespace App\Http\Controllers\Paiements;

use App\Http\Controllers\Controller;
use App\Models\Document;
use App\Models\Payment;
use App\Services\LigdiCashService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Throwable;

class PaymentController extends Controller
{
    /**
     * --------------------------------------------------------------------------
     * CONSTRUCTEUR
     * --------------------------------------------------------------------------
     *
     * Toutes les routes nécessitent l'authentification sauf :
     *
     * - callback()     : appelé directement par LigdiCash
     * - cancelReturn() : retour navigateur après annulation LigdiCash
     *
     * return() reste protégé par auth car le paiement appartient
     * à l'utilisateur connecté qui vient de quitter le checkout.
     */
    public function __construct()
    {
        $this->middleware('auth')->except([
            'callback',
            'cancelReturn',
        ]);
    }

    /**
     * --------------------------------------------------------------------------
     * FORMULAIRE DE PAIEMENT
     * --------------------------------------------------------------------------
     */
    public function create(Document $document)
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
        | DOCUMENT PREMIUM
        |--------------------------------------------------------------------------
        */

        abort_unless(
            $document->isPremium(),
            404
        );

        /*
        |--------------------------------------------------------------------------
        | PRIX VALIDE
        |--------------------------------------------------------------------------
        */

        abort_unless(
            $document->price !== null &&
            (float) $document->price > 0,
            422,
            'Le prix de ce document est invalide.'
        );

        /*
        |--------------------------------------------------------------------------
        | PAIEMENT DÉJÀ EFFECTUÉ
        |--------------------------------------------------------------------------
        */

        $hasPaid = Payment::query()
            ->where('user_id', Auth::id())
            ->where('document_id', $document->id)
            ->where('status', 'paid')
            ->exists();

        if ($hasPaid) {
            return redirect()
                ->route(
                    'documents.show',
                    $document
                )
                ->with(
                    'success',
                    'Vous avez déjà payé ce document.'
                );
        }

        return view(
            'payments.create',
            compact('document')
        );
    }

    /**
     * --------------------------------------------------------------------------
     * CRÉATION DU PAIEMENT + REDIRECTION VERS LIGDICASH
     * --------------------------------------------------------------------------
     *
     * Flux :
     *
     * Document premium
     *       ↓
     * Payment pending
     *       ↓
     * createInvoice()
     *       ↓
     * payment_url
     *       ↓
     * Hosted Checkout LigdiCash
     */
    public function store(
        Document $document,
        LigdiCashService $ligdiCash
    ) {
        $user = Auth::user();

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
        | DOCUMENT PREMIUM
        |--------------------------------------------------------------------------
        */

        if (!$document->isPremium()) {
            return redirect()
                ->route(
                    'documents.show',
                    $document
                )
                ->with(
                    'info',
                    'Ce document est gratuit.'
                );
        }

        /*
        |--------------------------------------------------------------------------
        | PRIX SERVEUR
        |--------------------------------------------------------------------------
        */

        if (
            $document->price === null ||
            (float) $document->price <= 0
        ) {
            abort(
                422,
                'Le prix du document est invalide.'
            );
        }

        /*
        |--------------------------------------------------------------------------
        | PAIEMENT DÉJÀ PAYÉ
        |--------------------------------------------------------------------------
        */

        $alreadyPaid = Payment::query()
            ->where('user_id', $user->id)
            ->where('document_id', $document->id)
            ->where('status', 'paid')
            ->exists();

        if ($alreadyPaid) {
            return redirect()
                ->route(
                    'documents.show',
                    $document
                )
                ->with(
                    'success',
                    'Vous avez déjà payé ce document.'
                );
        }

        /*
        |--------------------------------------------------------------------------
        | RECHERCHE D'UNE TRANSACTION PENDING RÉCENTE
        |--------------------------------------------------------------------------
        |
        | On évite de créer plusieurs factures Hosted Payin pour
        | le même document dans un court intervalle.
        |
        */

        $existingPayment = Payment::query()
            ->where('user_id', $user->id)
            ->where('document_id', $document->id)
            ->where('status', 'pending')
            ->where(
                'created_at',
                '>=',
                now()->subMinutes(15)
            )
            ->latest('id')
            ->first();

        /*
        |--------------------------------------------------------------------------
        | PAIEMENT PENDING EXISTANT
        |--------------------------------------------------------------------------
        */

        if ($existingPayment) {

            /*
            |--------------------------------------------------------------------------
            | Une facture LigdiCash existe déjà
            |--------------------------------------------------------------------------
            */

            if ($existingPayment->ligdicash_payment_url) {
                return redirect()->away(
                    $existingPayment->ligdicash_payment_url
                );
            }

            /*
            |--------------------------------------------------------------------------
            | Pas encore de facture : on réutilise la transaction
            |--------------------------------------------------------------------------
            */

            $payment = $existingPayment;

        } else {

            /*
            |--------------------------------------------------------------------------
            | NOUVELLE TRANSACTION
            |--------------------------------------------------------------------------
            */

            $payment = DB::transaction(
                function () use (
                    $user,
                    $document
                ) {
                    /*
                    |--------------------------------------------------------------------------
                    | Référence Scientia
                    |--------------------------------------------------------------------------
                    */

                    $reference =
                        'PAY-' .
                        now()->format('YmdHis') .
                        '-' .
                        strtoupper(
                            Str::random(10)
                        );

                    /*
                    |--------------------------------------------------------------------------
                    | Transaction ID
                    |--------------------------------------------------------------------------
                    |
                    | Cette valeur est envoyée par LigdiCash
                    | dans custom_data.transaction_id.
                    |
                    */

                    $transactionId =
                        'SC-' .
                        now()->format('YmdHis') .
                        '-' .
                        strtoupper(
                            Str::random(12)
                        );

                    return Payment::create([
                        'user_id' =>
                            $user->id,

                        'document_id' =>
                            $document->id,

                        /*
                        |--------------------------------------------------------------------------
                        | Montant venant exclusivement de la DB
                        |--------------------------------------------------------------------------
                        */

                        'amount' =>
                            $document->price,

                        'currency' =>
                            'FCFA',

                        /*
                        |--------------------------------------------------------------------------
                        | Référence Scientia
                        |--------------------------------------------------------------------------
                        */

                        'payment_reference' =>
                            $reference,

                        /*
                        |--------------------------------------------------------------------------
                        | Identifiant marchand LigdiCash
                        |--------------------------------------------------------------------------
                        */

                        'transaction_id' =>
                            $transactionId,

                        /*
                        |--------------------------------------------------------------------------
                        | Statut initial
                        |--------------------------------------------------------------------------
                        */

                        'status' =>
                            'pending',

                        /*
                        |--------------------------------------------------------------------------
                        | Champs LigdiCash
                        |--------------------------------------------------------------------------
                        */

                        'ligdicash_token' =>
                            null,

                        'ligdicash_status' =>
                            'pending',

                        'ligdicash_payment_url' =>
                            null,

                        'ligdicash_response' =>
                            null,

                        /*
                        |--------------------------------------------------------------------------
                        | Finalisation
                        |--------------------------------------------------------------------------
                        */

                        'failure_reason' =>
                            null,

                        'paid_at' =>
                            null,
                    ]);
                }
            );
        }

        /*
        |--------------------------------------------------------------------------
        | CRÉATION DE LA FACTURE HOSTED PAYIN
        |--------------------------------------------------------------------------
        */

        try {

            $result = $ligdiCash->createInvoice(
                $payment
            );

        } catch (Throwable $e) {

            report($e);

            Log::error(
                'Création facture LigdiCash échouée.',
                [
                    'payment_id' =>
                        $payment->id,

                    'transaction_id' =>
                        $payment->transaction_id,

                    'error' =>
                        $e->getMessage(),
                ]
            );

            $payment->update([
                'status' =>
                    'failed',

                'ligdicash_status' =>
                    'failed',

                'failure_reason' =>
                    $e->getMessage(),
            ]);

            return redirect()
                ->route(
                    'payments.processing',
                    $payment
                )
                ->with(
                    'error',
                    'Impossible de démarrer le paiement LigdiCash.'
                );
        }

        /*
        |--------------------------------------------------------------------------
        | RÉCUPÉRATION URL HOSTED CHECKOUT
        |--------------------------------------------------------------------------
        */

        $payment = $payment->fresh();

        $paymentUrl =
            $result['payment_url']
            ?? $payment?->ligdicash_payment_url;

        if (!$paymentUrl) {

            $payment->update([
                'status' =>
                    'failed',

                'ligdicash_status' =>
                    'failed',

                'failure_reason' =>
                    'LigdiCash n\'a pas retourné une URL de paiement.',
            ]);

            return redirect()
                ->route(
                    'payments.processing',
                    $payment
                )
                ->with(
                    'error',
                    'LigdiCash n\'a pas fourni de page de paiement.'
                );
        }

        /*
        |--------------------------------------------------------------------------
        | REDIRECTION VERS LIGDICASH
        |--------------------------------------------------------------------------
        */

        return redirect()->away(
            $paymentUrl
        );
    }

    /**
     * --------------------------------------------------------------------------
     * RETOUR NAVIGATEUR APRÈS PAIEMENT
     * --------------------------------------------------------------------------
     *
     * Le navigateur revient ici après le Hosted Checkout.
     *
     * Le retour navigateur ne suffit jamais à considérer le paiement
     * comme payé.
     *
     * On appelle confirmPayment() pour vérifier le statut réel
     * auprès de LigdiCash.
     */
    public function return(
        Request $request,
        LigdiCashService $ligdiCash
    ) {
        /*
        |--------------------------------------------------------------------------
        | IDENTIFIANTS RETOURNÉS PAR LIGDICASH
        |--------------------------------------------------------------------------
        */

        $transactionId =
            $request->input('transaction_id')
            ?? $request->input('custom_data.transaction_id');

        $token =
            $request->input('token')
            ?? $request->input('invoiceToken');

        /*
        |--------------------------------------------------------------------------
        | Recherche dans custom_data si celui-ci est JSON
        |--------------------------------------------------------------------------
        */

        $customData = $request->input('custom_data');

        if (
            !$transactionId &&
            is_string($customData)
        ) {
            $decodedCustomData =
                json_decode(
                    $customData,
                    true
                );

            if (is_array($decodedCustomData)) {
                $transactionId =
                    $decodedCustomData['transaction_id']
                    ?? null;
            }
        }

        /*
        |--------------------------------------------------------------------------
        | RECHERCHE DU PAYMENT
        |--------------------------------------------------------------------------
        */

        $payment = null;

        /*
        |--------------------------------------------------------------------------
        | Recherche par transaction_id
        |--------------------------------------------------------------------------
        */

        if ($transactionId) {

            $payment = Payment::query()
                ->where(
                    'transaction_id',
                    $transactionId
                )
                ->first();
        }

        /*
        |--------------------------------------------------------------------------
        | Recherche par token
        |--------------------------------------------------------------------------
        */

        if (
            !$payment &&
            $token
        ) {
            $payment = Payment::query()
                ->where(
                    'ligdicash_token',
                    $token
                )
                ->first();
        }

        /*
        |--------------------------------------------------------------------------
        | PAYMENT INTROUVABLE
        |--------------------------------------------------------------------------
        */

        if (!$payment) {

            Log::warning(
                'Retour LigdiCash : paiement introuvable.',
                [
                    'transaction_id' =>
                        $transactionId,

                    'token' =>
                        $token,

                    'payload' =>
                        $request->all(),
                ]
            );

            return redirect()
                ->route('documents.index')
                ->with(
                    'error',
                    'Impossible de retrouver votre paiement.'
                );
        }

        /*
        |--------------------------------------------------------------------------
        | SÉCURITÉ UTILISATEUR
        |--------------------------------------------------------------------------
        */

        abort_unless(
            (int) $payment->user_id ===
                (int) Auth::id(),
            403
        );

        /*
        |--------------------------------------------------------------------------
        | DOCUMENT
        |--------------------------------------------------------------------------
        */

        $payment->loadMissing('document');

        /*
        |--------------------------------------------------------------------------
        | DÉJÀ PAYÉ
        |--------------------------------------------------------------------------
        */

        if ($payment->status === 'paid') {

            return redirect()
                ->route(
                    'documents.show',
                    $payment->document
                )
                ->with(
                    'success',
                    'Paiement confirmé. Vous pouvez maintenant accéder au document.'
                );
        }

        /*
        |--------------------------------------------------------------------------
        | CONFIRMATION RÉELLE AUPRÈS DE LIGDICASH
        |--------------------------------------------------------------------------
        */

        try {

            $result =
                $ligdiCash->confirmPayment(
                    $payment
                );

        } catch (Throwable $e) {

            report($e);

            Log::error(
                'Retour LigdiCash : erreur de confirmation.',
                [
                    'payment_id' =>
                        $payment->id,

                    'transaction_id' =>
                        $payment->transaction_id,

                    'error' =>
                        $e->getMessage(),
                ]
            );

            return redirect()
                ->route(
                    'payments.processing',
                    $payment
                )
                ->with(
                    'error',
                    'La vérification du paiement a échoué. Veuillez réessayer.'
                );
        }

        /*
        |--------------------------------------------------------------------------
        | PAYMENT CONFIRMÉ
        |--------------------------------------------------------------------------
        */

        if (
            ($result['status'] ?? null) ===
            'paid'
        ) {

            return redirect()
                ->route(
                    'documents.show',
                    $payment->document
                )
                ->with(
                    'success',
                    'Paiement confirmé. Vous pouvez maintenant accéder au document.'
                );
        }

        /*
        |--------------------------------------------------------------------------
        | PAYMENT ÉCHOUÉ
        |--------------------------------------------------------------------------
        */

        if (
            ($result['status'] ?? null) ===
            'failed'
        ) {

            return redirect()
                ->route(
                    'payments.processing',
                    $payment
                )
                ->with(
                    'error',
                    'Le paiement LigdiCash n\'a pas été effectué.'
                );
        }

        /*
        |--------------------------------------------------------------------------
        | PAYMENT TOUJOURS EN ATTENTE
        |--------------------------------------------------------------------------
        */

        return redirect()
            ->route(
                'payments.processing',
                $payment
            )
            ->with(
                'info',
                'Votre paiement est encore en cours de confirmation.'
            );
    }

    /**
     * --------------------------------------------------------------------------
     * CALLBACK SERVEUR LIGDICASH
     * --------------------------------------------------------------------------
     *
     * Cette méthode est appelée directement par LigdiCash.
     *
     * Aucune authentification utilisateur n'est nécessaire ici.
     *
     * Le statut est toujours confirmé auprès de l'API LigdiCash
     * avant de passer le Payment à "paid".
     */
    public function callback(
        Request $request,
        LigdiCashService $ligdiCash
    ) {
        /*
        |--------------------------------------------------------------------------
        | LOG DU CALLBACK
        |--------------------------------------------------------------------------
        */

        Log::info(
            'LigdiCash callback reçu.',
            [
                'payload' =>
                    $request->all(),
            ]
        );

        /*
        |--------------------------------------------------------------------------
        | IDENTIFIANTS
        |--------------------------------------------------------------------------
        */

        $transactionId =
            $request->input('transaction_id')
            ?? $request->input('custom_data.transaction_id');

        $token =
            $request->input('token')
            ?? $request->input('invoiceToken');

        /*
        |--------------------------------------------------------------------------
        | custom_data éventuellement envoyé sous forme JSON
        |--------------------------------------------------------------------------
        */

        $customData = $request->input('custom_data');

        if (
            !$transactionId &&
            is_string($customData)
        ) {

            $decodedCustomData =
                json_decode(
                    $customData,
                    true
                );

            if (is_array($decodedCustomData)) {

                $transactionId =
                    $decodedCustomData['transaction_id']
                    ?? null;
            }
        }

        /*
        |--------------------------------------------------------------------------
        | RECHERCHE DU PAYMENT
        |--------------------------------------------------------------------------
        */

        $payment = null;

        /*
        |--------------------------------------------------------------------------
        | Recherche par transaction_id
        |--------------------------------------------------------------------------
        */

        if ($transactionId) {

            $payment = Payment::query()
                ->where(
                    'transaction_id',
                    $transactionId
                )
                ->first();
        }

        /*
        |--------------------------------------------------------------------------
        | Recherche par token
        |--------------------------------------------------------------------------
        */

        if (
            !$payment &&
            $token
        ) {

            $payment = Payment::query()
                ->where(
                    'ligdicash_token',
                    $token
                )
                ->first();
        }

        /*
        |--------------------------------------------------------------------------
        | Paiement introuvable
        |--------------------------------------------------------------------------
        */

        if (!$payment) {

            Log::warning(
                'LigdiCash callback : paiement introuvable.',
                [
                    'transaction_id' =>
                        $transactionId,

                    'token' =>
                        $token,
                ]
            );

            return response()->json([
                'success' =>
                    false,

                'message' =>
                    'Paiement introuvable.',
            ], 404);
        }

        /*
        |--------------------------------------------------------------------------
        | DÉJÀ PAYÉ
        |--------------------------------------------------------------------------
        */

        if ($payment->status === 'paid') {

            return response()->json([
                'success' =>
                    true,

                'status' =>
                    'paid',

                'message' =>
                    'Paiement déjà confirmé.',
            ]);
        }

        /*
        |--------------------------------------------------------------------------
        | CONFIRMATION RÉELLE
        |--------------------------------------------------------------------------
        */

        try {

            $result =
                $ligdiCash->confirmPayment(
                    $payment
                );

        } catch (Throwable $e) {

            report($e);

            Log::error(
                'LigdiCash callback : erreur confirmation.',
                [
                    'payment_id' =>
                        $payment->id,

                    'transaction_id' =>
                        $payment->transaction_id,

                    'error' =>
                        $e->getMessage(),
                ]
            );

            return response()->json([
                'success' =>
                    false,

                'status' =>
                    'pending',

                'message' =>
                    'Impossible de confirmer le paiement.',
            ], 500);
        }

        /*
        |--------------------------------------------------------------------------
        | PAYÉ
        |--------------------------------------------------------------------------
        */

        if (
            ($result['status'] ?? null) ===
            'paid'
        ) {

            Log::info(
                'Paiement LigdiCash confirmé.',
                [
                    'payment_id' =>
                        $payment->id,

                    'transaction_id' =>
                        $payment->transaction_id,
                ]
            );

            return response()->json([
                'success' =>
                    true,

                'status' =>
                    'paid',

                'message' =>
                    'Paiement confirmé.',
            ]);
        }

        /*
        |--------------------------------------------------------------------------
        | ÉCHEC
        |--------------------------------------------------------------------------
        */

        if (
            ($result['status'] ?? null) ===
            'failed'
        ) {

            return response()->json([
                'success' =>
                    false,

                'status' =>
                    'failed',

                'message' =>
                    'Paiement non effectué.',
            ]);
        }

        /*
        |--------------------------------------------------------------------------
        | TOUJOURS PENDING
        |--------------------------------------------------------------------------
        */

        return response()->json([
            'success' =>
                true,

            'status' =>
                'pending',

            'message' =>
                'Paiement toujours en attente.',
        ]);
    }

    /**
     * --------------------------------------------------------------------------
     * PAGE DE TRAITEMENT
     * --------------------------------------------------------------------------
     */
    public function processing(Payment $payment)
    {
        /*
        |--------------------------------------------------------------------------
        | PROPRIÉTAIRE
        |--------------------------------------------------------------------------
        */

        abort_unless(
            (int) $payment->user_id ===
                (int) Auth::id(),
            403
        );

        /*
        |--------------------------------------------------------------------------
        | DOCUMENT
        |--------------------------------------------------------------------------
        */

        $payment->loadMissing('document');

        /*
        |--------------------------------------------------------------------------
        | SI DÉJÀ PAYÉ
        |--------------------------------------------------------------------------
        */

        if ($payment->status === 'paid') {

            return redirect()
                ->route(
                    'documents.show',
                    $payment->document
                )
                ->with(
                    'success',
                    'Paiement confirmé. Vous pouvez accéder au document.'
                );
        }

        /*
        |--------------------------------------------------------------------------
        | AFFICHAGE DE LA PAGE
        |--------------------------------------------------------------------------
        */

        return view(
            'payments.processing',
            compact('payment')
        );
    }

    /**
     * --------------------------------------------------------------------------
     * STATUT LOCAL
     * --------------------------------------------------------------------------
     *
     * Cette méthode lit uniquement notre base de données.
     *
     * Elle ne contacte pas LigdiCash.
     */
    public function status(Payment $payment)
    {
        /*
        |--------------------------------------------------------------------------
        | PROPRIÉTAIRE
        |--------------------------------------------------------------------------
        */

        abort_unless(
            (int) $payment->user_id ===
                (int) Auth::id(),
            403
        );

        return response()->json([
            'status' =>
                $payment->status,

            'paid' =>
                $payment->status === 'paid',

            'payment_reference' =>
                $payment->payment_reference,

            'transaction_id' =>
                $payment->transaction_id,

            'amount' =>
                $payment->amount,

            'currency' =>
                $payment->currency,

            'ligdicash_status' =>
                $payment->ligdicash_status,

            'paid_at' =>
                $payment->paid_at?->toISOString(),
        ]);
    }

    /**
     * --------------------------------------------------------------------------
     * CONFIRMATION MANUELLE
     * --------------------------------------------------------------------------
     *
     * Cette méthode contacte réellement LigdiCash.
     */
    public function confirm(
        Payment $payment,
        LigdiCashService $ligdiCash
    ) {
        /*
        |--------------------------------------------------------------------------
        | PROPRIÉTAIRE
        |--------------------------------------------------------------------------
        */

        abort_unless(
            (int) $payment->user_id ===
                (int) Auth::id(),
            403
        );

        /*
        |--------------------------------------------------------------------------
        | DÉJÀ PAYÉ
        |--------------------------------------------------------------------------
        */

        if ($payment->status === 'paid') {

            return response()->json([
                'success' =>
                    true,

                'status' =>
                    'paid',

                'paid' =>
                    true,

                'message' =>
                    'Paiement déjà confirmé.',
            ]);
        }

        /*
        |--------------------------------------------------------------------------
        | SEUL PENDING EST VÉRIFIABLE
        |--------------------------------------------------------------------------
        */

        if ($payment->status !== 'pending') {

            return response()->json([
                'success' =>
                    false,

                'status' =>
                    $payment->status,

                'paid' =>
                    false,

                'message' =>
                    'Ce paiement ne peut plus être confirmé.',
            ], 422);
        }

        /*
        |--------------------------------------------------------------------------
        | CONFIRMATION AUPRÈS DE LIGDICASH
        |--------------------------------------------------------------------------
        */

        try {

            $result =
                $ligdiCash->confirmPayment(
                    $payment
                );

        } catch (Throwable $e) {

            report($e);

            Log::error(
                'Confirmation manuelle LigdiCash échouée.',
                [
                    'payment_id' =>
                        $payment->id,

                    'transaction_id' =>
                        $payment->transaction_id,

                    'error' =>
                        $e->getMessage(),
                ]
            );

            return response()->json([
                'success' =>
                    false,

                'status' =>
                    $payment->fresh()->status,

                'paid' =>
                    false,

                'message' =>
                    'Impossible de vérifier le paiement auprès de LigdiCash.',
            ], 502);
        }

        /*
        |--------------------------------------------------------------------------
        | RÉPONSE
        |--------------------------------------------------------------------------
        */

        return response()->json([
            'success' =>
                ($result['status'] ?? null) === 'paid',

            'status' =>
                $result['status']
                ?? $payment->fresh()->status,

            'ligdicash_status' =>
                $result['ligdicash_status']
                ?? null,

            'paid' =>
                $result['paid']
                ?? false,

            'message' =>
                ($result['status'] ?? null) === 'paid'
                    ? 'Paiement confirmé.'
                    : 'Paiement toujours en attente.',
        ]);
    }

    /**
     * --------------------------------------------------------------------------
     * ANNULATION PAR L'UTILISATEUR
     * --------------------------------------------------------------------------
     */
    public function cancel(Payment $payment)
    {
        /*
        |--------------------------------------------------------------------------
        | PROPRIÉTAIRE
        |--------------------------------------------------------------------------
        */

        abort_unless(
            (int) $payment->user_id ===
                (int) Auth::id(),
            403
        );

        /*
        |--------------------------------------------------------------------------
        | DOCUMENT
        |--------------------------------------------------------------------------
        */

        $payment->loadMissing('document');

        /*
        |--------------------------------------------------------------------------
        | ANNULATION UNIQUEMENT SI PENDING
        |--------------------------------------------------------------------------
        */

        if ($payment->status === 'pending') {

            $payment->update([
                'status' =>
                    'cancelled',

                'failure_reason' =>
                    'Paiement annulé par l’utilisateur.',
            ]);
        }

        return redirect()
            ->route(
                'documents.show',
                $payment->document
            )
            ->with(
                'info',
                'Le paiement a été annulé.'
            );
    }

    /**
     * --------------------------------------------------------------------------
     * RETOUR APRÈS ANNULATION LIGDICASH
     * --------------------------------------------------------------------------
     *
     * Cette méthode est publique.
     *
     * Elle sert uniquement de retour navigateur depuis LigdiCash.
     */
    public function cancelReturn(
        Request $request
    ) {
        Log::info(
            'Retour annulation LigdiCash reçu.',
            [
                'payload' =>
                    $request->all(),
            ]
        );

        return redirect()
            ->route('documents.index')
            ->with(
                'info',
                'Le paiement a été annulé ou interrompu.'
            );
    }
}
