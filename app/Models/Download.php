<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Download extends Model
{
    use HasFactory;


    protected $fillable = [

        'user_id',
        'document_id',
        'ip_address',
        'device',

    ];



    /*
    |--------------------------------------------------------------------------
    | RELATIONS
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



    /*
    |--------------------------------------------------------------------------
    | SCOPES
    |--------------------------------------------------------------------------
    */

    public function scopeForDocument($query, $documentId)
    {
        return $query->where('document_id', $documentId);
    }


    public function scopeRecent($query)
    {
        return $query->latest();
    }

}