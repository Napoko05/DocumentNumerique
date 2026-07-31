<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Level extends Model
{
    use HasFactory;

    protected $fillable = [

        'filiere_id',
        'name',
        'slug',
        'order',
        'is_active',

    ];
    protected $casts = [

        'is_active' => 'boolean',

    ];
    /*
    |--------------------------------------------------------------------------
    | FILIERE
    |--------------------------------------------------------------------------
    |
    | Exemple :
    |
    | Informatique
    |       |
    |       + Licence 1
    |       + Licence 2
    |       + Licence 3
    |
    */

    public function filiere()
    {
        return $this->belongsTo(
            Filiere::class
        );
    }
    /*
    |--------------------------------------------------------------------------
    | MATIERES
    |--------------------------------------------------------------------------
    |
    | Licence 1
    |      |
    |      + Algorithmique
    |      + Base de données
    |
    */
    public function subjects()
    {
        return $this->hasMany(
            Subject::class
        );
    }
    /*
    |--------------------------------------------------------------------------
    | DOCUMENTS
    |--------------------------------------------------------------------------
    |
    | Documents du niveau
    |
    */

    public function documents()
    {
        return $this->hasMany(
            Document::class
        );
    }
    /*
    |--------------------------------------------------------------------------
    | SCOPE ACTIF
    |--------------------------------------------------------------------------
    */

    public function scopeActive($query)
    {
        return $query->where(
            'is_active',
            true
        );
    }

}