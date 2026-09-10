<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasFactory;

    /*
    |--------------------------------------------------------------------------
    | MASS ASSIGNMENT
    |--------------------------------------------------------------------------
    */

    protected $fillable = [

        /*
        |--------------------------------------------------------------------------
        | SCIENTIA
        |--------------------------------------------------------------------------
        */

        'user_id',

        'document_id',

        'amount',

        'currency',

        'transaction_id',

        'payment_reference',


        /*
        |--------------------------------------------------------------------------
        | ANCIENS CHAMPS CONSERVÉS
        |--------------------------------------------------------------------------
        |
        | Ces champs existent dans la base mais ne sont plus utilisés
        | par notre flux Hosted Payin.
        |
        */

        'payment_method',

        'phone',


        /*
        |--------------------------------------------------------------------------
        | LIGDICASH
        |--------------------------------------------------------------------------
        */

        'ligdicash_token',

        'ligdicash_request_id',

        'ligdicash_status',

        'ligdicash_payment_url',

        'ligdicash_response',


        /*
        |--------------------------------------------------------------------------
        | STATUT SCIENTIA
        |--------------------------------------------------------------------------
        */

        'status',

        'failure_reason',

        'paid_at',
    ];


    /*
    |--------------------------------------------------------------------------
    | CASTS
    |--------------------------------------------------------------------------
    */

    protected $casts = [

        /*
        |--------------------------------------------------------------------------
        | Montant
        |--------------------------------------------------------------------------
        */

        'amount' => 'decimal:2',


        /*
        |--------------------------------------------------------------------------
        | Date de paiement
        |--------------------------------------------------------------------------
        */

        'paid_at' => 'datetime',


        /*
        |--------------------------------------------------------------------------
        | Réponse API LigdiCash
        |--------------------------------------------------------------------------
        */

        'ligdicash_response' => 'array',
    ];


    /*
    |--------------------------------------------------------------------------
    | RELATION UTILISATEUR
    |--------------------------------------------------------------------------
    */

    public function user()
    {
        return $this->belongsTo(
            User::class,
            'user_id'
        );
    }


    /*
    |--------------------------------------------------------------------------
    | RELATION DOCUMENT
    |--------------------------------------------------------------------------
    */

    public function document()
    {
        return $this->belongsTo(
            Document::class,
            'document_id'
        );
    }


    /*
    |--------------------------------------------------------------------------
    | STATUTS SCIENTIA
    |--------------------------------------------------------------------------
    */

    public function isPending(): bool
    {
        return $this->status === 'pending';
    }


    public function isPaid(): bool
    {
        return $this->status === 'paid';
    }


    public function isFailed(): bool
    {
        return $this->status === 'failed';
    }


    public function isCancelled(): bool
    {
        return $this->status === 'cancelled';
    }


    /*
    |--------------------------------------------------------------------------
    | STATUTS LIGDICASH
    |--------------------------------------------------------------------------
    */

    public function isLigdiCashPending(): bool
    {
        return $this->ligdicash_status === 'pending';
    }


    public function isLigdiCashCompleted(): bool
    {
        return $this->ligdicash_status === 'completed';
    }


    public function isLigdiCashNotCompleted(): bool
    {
        return $this->ligdicash_status === 'notcompleted';
    }


    /*
    |--------------------------------------------------------------------------
    | ACCÈS DOCUMENT
    |--------------------------------------------------------------------------
    |
    | L'accès premium dépend uniquement du statut Scientia "paid".
    |
    */

    public function grantsDocumentAccess(): bool
    {
        return $this->isPaid();
    }
}
