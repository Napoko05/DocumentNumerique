<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Document extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'title',
        'description',
        'content',
        'type',
        'access_type',
        'price',
        'views',
        'level',   // secondaire / supérieur
        'classe',  // classe ou cycle
    ];

    /**
     * Document appartient à un journaliste
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * Comptage des achats si tu veux suivre les ventes
     */
    public function buyers()
    {
        return $this->belongsToMany(User::class, 'document_user', 'document_id', 'user_id')
            ->withTimestamps();
    }
}
