<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Program extends Model
{
    use HasFactory;


    protected $fillable = [

        'formation_id',

        'name',

        'slug',

        'description',

        'is_active',

    ];



    protected $casts = [

        'is_active' => 'boolean',

    ];



    /*
    |--------------------------------------------------------------------------
    | FORMATION ENS
    |--------------------------------------------------------------------------
    |
    | Exemple :
    |
    | ENS
    |   ↓
    | CAPES
    |
    */

    public function formation()
    {
        return $this->belongsTo(
            Formation::class
        );
    }



    /*
    |--------------------------------------------------------------------------
    | SPECIALITES
    |--------------------------------------------------------------------------
    |
    | CAPES
    |    ↓
    | Mathématiques
    |    ↓
    | Physique-Chimie
    |
    */

    public function specialites()
    {
        return $this->hasMany(
            Specialite::class
        );
    }



    /*
    |--------------------------------------------------------------------------
    | NIVEAUX
    |--------------------------------------------------------------------------
    |
    | Accès aux niveaux via les spécialités
    |
    */

    public function levels()
    {
        return $this->hasManyThrough(
            Level::class,
            Specialite::class
        );
    }



    /*
    |--------------------------------------------------------------------------
    | DOCUMENTS
    |--------------------------------------------------------------------------
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
