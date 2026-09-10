<?php

namespace App\Services;

use App\Models\Payment;
use Illuminate\Support\Facades\Http;
use RuntimeException;

class LigdiCashService
{
    /**
     * URL de base de l'API LigdiCash.
     */
    protected string $baseUrl;

    /**
     * Clé API LigdiCash.
     */
    protected string $apiKey;

    /**
     * Token API LigdiCash.
     */
    protected string $apiToken;

    public function __construct()
    {
        $this->baseUrl = rtrim(
            (string) config('services.ligdicash.base_url'),
            '/'
        );

        $this->apiKey = (string) config('services.ligdicash.api_key');

        $this->apiToken = (string) config('services.ligdicash.api_token');

        if ($this->baseUrl === '') {
            throw new RuntimeException(
                'LIGDICASH_BASE_URL n\'est pas configuré.'
            );
        }

        if ($this->apiKey === '') {
            throw new RuntimeException(
                'LIGDICASH_API_KEY n\'est pas configuré.'
            );
        }

        if ($this->apiToken === '') {
            throw new RuntimeException(
                'LIGDICASH_API_TOKEN n\'est pas configuré.'
            );
        }
    }

    /**
     * Crée une facture Hosted Payin LigdiCash.
     *
     * Cette méthode :
     * - vérifie le paiement ;
     * - construit la facture ;
     * - envoie la requête à LigdiCash ;
     * - enregistre le token ;
     * - enregistre l'URL de paiement ;
     * - conserve la réponse LigdiCash.
     */
    public function createInvoice(Payment $payment): array
    {
        $payment->loadMissing([
            'user',
            'document',
        ]);

        $user = $payment->user;
        $document = $payment->document;

        if (!$user) {
            throw new RuntimeException(
                'Utilisateur du paiement introuvable.'
            );
        }

        if (!$document) {
            throw new RuntimeException(
                'Document du paiement introuvable.'
            );
        }

        /*
        |--------------------------------------------------------------------------
        | Vérification du montant
        |--------------------------------------------------------------------------
        |
        | LigdiCash attend un montant entier en XOF.
        |
        */

        $amount = (int) round(
            (float) $payment->amount
        );

        if ($amount <= 0) {
            throw new RuntimeException(
                'Le montant du paiement est invalide.'
            );
        }

        /*
        |--------------------------------------------------------------------------
        | Vérification des URLs
        |--------------------------------------------------------------------------
        */

        $cancelUrl = config(
            'services.ligdicash.cancel_url'
        );

        $returnUrl = config(
            'services.ligdicash.return_url'
        );

        $callbackUrl = config(
            'services.ligdicash.callback_url'
        );

        if (!$cancelUrl) {
            throw new RuntimeException(
                'LIGDICASH_CANCEL_URL n\'est pas configuré.'
            );
        }

        if (!$returnUrl) {
            throw new RuntimeException(
                'LIGDICASH_RETURN_URL n\'est pas configuré.'
            );
        }

        if (!$callbackUrl) {
            throw new RuntimeException(
                'LIGDICASH_CALLBACK_URL n\'est pas configuré.'
            );
        }

        /*
        |--------------------------------------------------------------------------
        | Transaction ID Scientia
        |--------------------------------------------------------------------------
        |
        | C'est notre identifiant interne.
        | Il permettra de retrouver exactement le paiement.
        |
        */

        $transactionId = $payment->transaction_id;

        if (!$transactionId) {
            throw new RuntimeException(
                'Le paiement ne possède pas de transaction_id.'
            );
        }

        /*
        |--------------------------------------------------------------------------
        | Payload LigdiCash
        |--------------------------------------------------------------------------
        |
        | Hosted Payin :
        | customer doit être vide.
        |
        | Nous utilisons custom_data.transaction_id comme identifiant
        | marchand et laissons external_id vide.
        |
        */

        $payload = [
            'commande' => [
                'invoice' => [
                    'items' => [
                        [
                            'name' => $document->title,

                            'description' =>
                                'Accès au document premium',

                            'quantity' => 1,

                            'unit_price' => $amount,

                            'total_price' => $amount,
                        ],
                    ],

                    'total_amount' => $amount,

                    'devise' => 'XOF',

                    'description' =>
                        'Accès premium - ' . $document->title,

                    /*
                    |--------------------------------------------------------------------------
                    | IMPORTANT
                    |--------------------------------------------------------------------------
                    |
                    | Pour Hosted Payin, customer doit être vide.
                    |
                    */

                    'customer' => '',

                    'customer_firstname' =>
                        (string) ($user->prenom ?? ''),

                    'customer_lastname' =>
                        (string) ($user->nom ?? ''),

                    'customer_email' =>
                        (string) ($user->email ?? ''),

                    /*
                    |--------------------------------------------------------------------------
                    | Nous utilisons custom_data.transaction_id.
                    | Donc external_id reste vide.
                    |--------------------------------------------------------------------------
                    */

                    'external_id' => '',

                    /*
                    |--------------------------------------------------------------------------
                    | Toujours vide pour Hosted Payin.
                    |--------------------------------------------------------------------------
                    */

                    'otp' => '',
                ],

                /*
                |--------------------------------------------------------------------------
                | Boutique
                |--------------------------------------------------------------------------
                */

                'store' => [
                    'name' => 'Scientia',

                    'website_url' =>
                        config('app.url'),
                ],

                /*
                |--------------------------------------------------------------------------
                | URLs de retour
                |--------------------------------------------------------------------------
                */

                'actions' => [
                    'cancel_url' => $cancelUrl,

                    'return_url' => $returnUrl,

                    'callback_url' => $callbackUrl,
                ],

                /*
                |--------------------------------------------------------------------------
                | Données personnalisées
                |--------------------------------------------------------------------------
                */

                'custom_data' => [
                    'transaction_id' => $transactionId,
                ],
            ],
        ];

        /*
        |--------------------------------------------------------------------------
        | Appel API LigdiCash
        |--------------------------------------------------------------------------
        */

        $response = Http::timeout(30)
            ->acceptJson()
            ->withHeaders([
                'Apikey' => $this->apiKey,

                'Authorization' =>
                    'Bearer ' . $this->apiToken,

                'Content-Type' =>
                    'application/json',
            ])
            ->post(
                $this->baseUrl .
                '/pay/v01/redirect/checkout-invoice/create',
                $payload
            );

        /*
        |--------------------------------------------------------------------------
        | Erreur HTTP
        |--------------------------------------------------------------------------
        */

        if (!$response->successful()) {

            throw new RuntimeException(
                'LigdiCash a retourné une erreur HTTP : ' .
                $response->status()
            );
        }

        /*
        |--------------------------------------------------------------------------
        | Lecture de la réponse
        |--------------------------------------------------------------------------
        */

        $data = $response->json();

        if (!is_array($data)) {
            throw new RuntimeException(
                'La réponse de LigdiCash est invalide.'
            );
        }

        /*
        |--------------------------------------------------------------------------
        | Code LigdiCash
        |--------------------------------------------------------------------------
        */

        if (($data['response_code'] ?? null) !== '00') {

            $message = $data['response_text']
                ?? 'La création de la facture LigdiCash a échoué.';

            throw new RuntimeException(
                $message
            );
        }

        /*
        |--------------------------------------------------------------------------
        | Token LigdiCash
        |--------------------------------------------------------------------------
        */

        $token = $data['token'] ?? null;

        /*
        |--------------------------------------------------------------------------
        | URL de paiement
        |--------------------------------------------------------------------------
        */

        $paymentUrl = $data['response_text'] ?? null;

        if (!$token) {
            throw new RuntimeException(
                'LigdiCash n\'a pas retourné le token de paiement.'
            );
        }

        if (!$paymentUrl) {
            throw new RuntimeException(
                'LigdiCash n\'a pas retourné l\'URL de paiement.'
            );
        }

        /*
        |--------------------------------------------------------------------------
        | Sauvegarde en base
        |--------------------------------------------------------------------------
        */

        $payment->update([
            'ligdicash_token' => $token,

            'ligdicash_status' => 'pending',

            'ligdicash_payment_url' => $paymentUrl,

            'ligdicash_response' => $data,
        ]);

        /*
        |--------------------------------------------------------------------------
        | Résultat
        |--------------------------------------------------------------------------
        */

        return [
            'success' => true,

            'token' => $token,

            'payment_url' => $paymentUrl,

            'response' => $data,
        ];
    }

    /**
     * Vérifie le statut réel d'un paiement auprès de LigdiCash.
     *
     * IMPORTANT :
     * On ne considère jamais un paiement comme payé uniquement
     * à partir du retour navigateur ou du callback.
     *
     * Le statut doit être confirmé auprès de LigdiCash.
     */
    public function confirmPayment(Payment $payment): array
    {
        $token = $payment->ligdicash_token;

        if (!$token) {
            throw new RuntimeException(
                'Le paiement ne possède pas de token LigdiCash.'
            );
        }

        /*
        |--------------------------------------------------------------------------
        | Endpoint de confirmation
        |--------------------------------------------------------------------------
        */

        $url =
            $this->baseUrl .
            '/pay/v01/redirect/checkout-invoice/confirm/' .
            '?invoiceToken=' .
            urlencode($token);

        /*
        |--------------------------------------------------------------------------
        | Appel LigdiCash
        |--------------------------------------------------------------------------
        */
        $response = Http::timeout(30)
            ->acceptJson()
            ->withHeaders([
                'Apikey' => $this->apiKey,

                'Authorization' =>
                    'Bearer ' . $this->apiToken,
            ])
            ->get($url);

        /*
        |--------------------------------------------------------------------------
        | Erreur HTTP
        |--------------------------------------------------------------------------
        */
        if (!$response->successful()) {

            throw new RuntimeException(
                'Erreur HTTP lors de la vérification LigdiCash : ' .
                $response->status()
            );
        }
        $data = $response->json();

        if (!is_array($data)) {
            throw new RuntimeException(
                'La réponse de confirmation LigdiCash est invalide.'
            );
        }
        /*
        |--------------------------------------------------------------------------
        | Mise à jour du statut LigdiCash
        |--------------------------------------------------------------------------
        */

        $ligdiStatus = strtolower(
            (string) (
                $data['status']
                ?? $data['response_status']
                ?? ''
            )
        );
        /*
        |--------------------------------------------------------------------------
        | Sauvegarde de la réponse
        |--------------------------------------------------------------------------
        */
        $payment->update([
            'ligdicash_status' => $ligdiStatus ?: null,

            'ligdicash_response' => $data,
        ]);

        /*
        |--------------------------------------------------------------------------
        | Paiement terminé
        |--------------------------------------------------------------------------
        */

        if ($ligdiStatus === 'completed') {

            $payment->update([
                'status' => 'paid',

                'paid_at' => now(),

                'failure_reason' => null,
            ]);
        }
        /*
        |--------------------------------------------------------------------------
        | Paiement non terminé
        |--------------------------------------------------------------------------
        */

        elseif ($ligdiStatus === 'notcompleted') {

            $payment->update([
                'status' => 'failed',

                'failure_reason' =>
                    $data['response_text']
                    ?? 'Le paiement LigdiCash n\'a pas été effectué.',
            ]);
        }
        /*
        |--------------------------------------------------------------------------
        | Paiement encore en attente
        |--------------------------------------------------------------------------
        */
        else {

            $payment->update([
                'status' => 'pending',
            ]);
        }
        /*
        |--------------------------------------------------------------------------
        | Rafraîchir le modèle
        |--------------------------------------------------------------------------
        */
        $payment->refresh();

        return [
            'success' => true,

            'status' => $payment->status,

            'ligdicash_status' =>
                $payment->ligdicash_status,

            'paid' =>
                $payment->isPaid(),

            'response' => $data,
        ];
    }
}