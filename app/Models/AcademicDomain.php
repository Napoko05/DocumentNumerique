<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AcademicDomain extends Model
{
    use HasFactory;


    protected $fillable = [

        'name',
        'slug',
        'icon',
        'description',
        'position',
        'is_active',

    ];
    /*
    |--------------------------------------------------------------------------
    | FORMATIONS DU DOMAINE
    |--------------------------------------------------------------------------
    |
    | Sciences exactes
    |        ↓
    | Informatique
    |
    */

    public function formations()
    {
        return $this->hasMany(
            Formation::class
        );
    }
    /*
    |--------------------------------------------------------------------------
    | FILIERES DU DOMAINE
    |--------------------------------------------------------------------------
    |
    | Domaine
    |    ↓
    | Formation
    |    ↓
    | Filière
    |
    */

    public function filieres()
    {
        return $this->hasManyThrough(
            Filiere::class,
            Formation::class
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