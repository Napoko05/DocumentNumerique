<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasFactory;

    /*
    |--------------------------------------------------------------------------
    | ATTRIBUTS MASS ASSIGNABLE
    |--------------------------------------------------------------------------
    */

    protected $fillable = [
        'user_id',
        'document_id',
        'amount',
        'currency',
        'payment_method',
        'transaction_id',
        'payment_reference',
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
        'amount'  => 'decimal:2',
        'paid_at' => 'datetime',
    ];


    /*
    |--------------------------------------------------------------------------
    | RELATIONS
    |--------------------------------------------------------------------------
    */

    /**
     * Utilisateur ayant effectué le paiement.
     */
    public function user()
    {
        return $this->belongsTo(
            User::class,
            'user_id'
        );
    }


    /**
     * Document concerné par le paiement.
     */
    public function document()
    {
        return $this->belongsTo(
            Document::class,
            'document_id'
        );
    }
}