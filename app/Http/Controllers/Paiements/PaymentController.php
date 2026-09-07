<?php

namespace App\Http\Controllers\Paiements;

use App\Http\Controllers\Controller;
use App\Models\Document;
use App\Models\Payment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class PaymentController extends Controller
{
    /**
     * --------------------------------------------------------------------------
     * CONSTRUCTEUR
     * --------------------------------------------------------------------------
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * --------------------------------------------------------------------------
     * FORMULAIRE DE PAIEMENT
     * --------------------------------------------------------------------------
     */
    public function create(Document $document)
    {
        abort_unless(
            $document->status === 'published',
            404
        );

        abort_unless(
            $document->isPremium(),
            404
        );

        abort_unless(
            $document->price !== null &&
            (float) $document->price > 0,
            422,
            'Le prix de ce document est invalide.'
        );

        $hasPaid = Payment::query()
            ->where('user_id', Auth::id())
            ->where('document_id', $document->id)
            ->where('status', 'paid')
            ->exists();

        if ($hasPaid) {
            return redirect()
                ->route('documents.show', $document)
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
     * CRÉATION D'UNE DEMANDE DE PAIEMENT
     * --------------------------------------------------------------------------
     *
     * Cette méthode crée uniquement une transaction "pending".
     *
     * Le statut "paid" sera défini uniquement après confirmation
     * réelle du paiement.
     */
    public function store(
        Request $request,
        Document $document
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
        |
        | Le montant vient toujours de la base de données.
        | Il ne faut jamais faire confiance à un montant envoyé par le navigateur.
        |
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
        | VALIDATION
        |--------------------------------------------------------------------------
        */

        $validated = $request->validate([
            'payment_method' => [
                'required',
                'string',
                'in:orange_money,moov_money',
            ],

            'phone' => [
                'required',
                'string',
                'regex:/^[0-9]{8}$/',
            ],
        ], [
            'payment_method.required' =>
                'Veuillez sélectionner un moyen de paiement.',

            'payment_method.in' =>
                'Le moyen de paiement sélectionné est invalide.',

            'phone.required' =>
                'Veuillez saisir votre numéro Mobile Money.',

            'phone.regex' =>
                'Le numéro Mobile Money doit contenir exactement 8 chiffres.',
        ]);

        /*
        |--------------------------------------------------------------------------
        | NORMALISATION DU NUMÉRO
        |--------------------------------------------------------------------------
        */

        $phone = preg_replace(
            '/\D/',
            '',
            $validated['phone']
        );

        /*
        |--------------------------------------------------------------------------
        | VÉRIFICATION DU NUMÉRO
        |--------------------------------------------------------------------------
        */

        if (
            strlen($phone) !== 8
        ) {
            return back()
                ->withInput()
                ->withErrors([
                    'phone' =>
                        'Le numéro Mobile Money doit contenir exactement 8 chiffres.'
                ]);
        }

        /*
        |--------------------------------------------------------------------------
        | VÉRIFICATION PAIEMENT EXISTANT
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
        | TRANSACTION PENDING EXISTANTE
        |--------------------------------------------------------------------------
        |
        | On évite de créer plusieurs paiements pour le même document
        | dans un court intervalle.
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

        if ($existingPayment) {
            return redirect()
                ->route(
                    'payments.processing',
                    $existingPayment
                );
        }

        /*
        |--------------------------------------------------------------------------
        | CRÉATION DE LA TRANSACTION
        |--------------------------------------------------------------------------
        */

        $payment = DB::transaction(function () use (
            $user,
            $document,
            $validated,
            $phone
        ) {

            /*
            |--------------------------------------------------------------------------
            | RÉFÉRENCE INTERNE
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
            | CRÉATION DU PAIEMENT
            |--------------------------------------------------------------------------
            */

            return Payment::create([
                'user_id' =>
                    $user->id,

                'document_id' =>
                    $document->id,

                /*
                | Montant provenant de la DB
                */
                'amount' =>
                    $document->price,

                'currency' =>
                    'FCFA',

                /*
                | Orange Money ou Moov Money
                */
                'payment_method' =>
                    $validated['payment_method'],

                /*
                | Numéro utilisé pour le paiement
                */
                'phone' =>
                    $phone,

                /*
                | Référence interne Scientia
                */
                'payment_reference' =>
                    $reference,

                /*
                | Pas encore confirmé
                */
                'status' =>
                    'pending',

                /*
                | Sera rempli après confirmation opérateur
                */
                'transaction_id' =>
                    null,

                'failure_reason' =>
                    null,

                'paid_at' =>
                    null,
            ]);
        });

        /*
        |--------------------------------------------------------------------------
        | REDIRECTION
        |--------------------------------------------------------------------------
        */

        return redirect()
            ->route(
                'payments.processing',
                $payment
            )
            ->with(
                'success',
                'Votre demande de paiement a été créée.'
            );
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

        $payment->load('document');

        /*
        |--------------------------------------------------------------------------
        | PAIEMENT DÉJÀ CONFIRMÉ
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
        | PAIEMENT ÉCHOUÉ
        |--------------------------------------------------------------------------
        */

        if ($payment->status === 'failed') {
            return view(
                'payments.processing',
                compact('payment')
            );
        }

        /*
        |--------------------------------------------------------------------------
        | PAIEMENT ANNULÉ
        |--------------------------------------------------------------------------
        */

        if ($payment->status === 'cancelled') {
            return view(
                'payments.processing',
                compact('payment')
            );
        }

        /*
        |--------------------------------------------------------------------------
        | PAIEMENT EN ATTENTE
        |--------------------------------------------------------------------------
        */

        return view(
            'payments.processing',
            compact('payment')
        );
    }

    /**
     * --------------------------------------------------------------------------
     * STATUT D'UN PAIEMENT
     * --------------------------------------------------------------------------
     *
     * Cette méthode ne modifie jamais le statut.
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

        /*
        |--------------------------------------------------------------------------
        | RÉPONSE JSON
        |--------------------------------------------------------------------------
        */

        return response()->json([
            'status' =>
                $payment->status,

            'paid' =>
                $payment->status === 'paid',

            'payment_reference' =>
                $payment->payment_reference,

            'transaction_id' =>
                $payment->transaction_id,

            'payment_method' =>
                $payment->payment_method,

            'phone' =>
                $payment->phone,

            'amount' =>
                $payment->amount,

            'currency' =>
                $payment->currency,

            'paid_at' =>
                $payment->paid_at?->toISOString(),
        ]);
    }

    public function confirm(Payment $payment)
{
    abort_unless(
        $payment->user_id === Auth::id(),
        403
    );

    if ($payment->status === 'paid') {
        return response()->json([
            'success' => true,
            'status' => 'paid',
            'message' => 'Paiement déjà confirmé.'
        ]);
    }

    if ($payment->status !== 'pending') {
        return response()->json([
            'success' => false,
            'status' => $payment->status,
            'message' => 'Ce paiement ne peut plus être confirmé.'
        ], 422);
    }

    /*
    |--------------------------------------------------------------------------
    | ICI viendra l'appel réel à Orange Money / Moov Money
    |--------------------------------------------------------------------------
    */

    return response()->json([
        'success' => false,
        'status' => 'pending',
        'message' => 'Paiement toujours en attente de confirmation.'
    ]);
}

    /**
     * --------------------------------------------------------------------------
     * ANNULATION
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

        /*
        |--------------------------------------------------------------------------
        | RETOUR
        |--------------------------------------------------------------------------
        */

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
}