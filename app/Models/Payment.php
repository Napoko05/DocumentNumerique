<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Payment extends Model
{
    use HasFactory;
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
    protected $casts = [

        'paid_at' => 'datetime',

        'amount' => 'decimal:2',

    ];
    /*
    |--------------------------------------------------------------------------
    | Relations
    |--------------------------------------------------------------------------
    */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function document()
    {
        return $this->belongsTo(Document::class);
    }
}