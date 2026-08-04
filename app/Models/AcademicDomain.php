<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AcademicDomain extends Model
{
    use HasFactory;


    /*
    |--------------------------------------------------------------------------
    | CHAMPS AUTORISÉS
    |--------------------------------------------------------------------------
    */

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
    | CASTS
    |--------------------------------------------------------------------------
    */

    protected $casts = [

        'position' => 'integer',

        'is_active' => 'boolean',

    ];


    /*
    |--------------------------------------------------------------------------
    | FORMATIONS DU DOMAINE
    |--------------------------------------------------------------------------
    |
    | Cette relation est conservée uniquement si la table
    | formations possède encore la colonne academic_domain_id.
    |
    | Exemple :
    |
    | Sciences exactes
    |        ↓
    | Formation
    |
    */

    public function formations()
    {
        return $this->hasMany(
            Formation::class,
            'academic_domain_id'
        );
    }


    /*
    |--------------------------------------------------------------------------
    | FILIÈRES DU DOMAINE
    |--------------------------------------------------------------------------
    |
    | Structure actuelle du supérieur :
    |
    | AcademicDomain
    |       ↓
    | Filiere
    |
    | La table filieres possède directement :
    |
    | academic_domain_id
    |
    */

    public function filieres()
    {
        return $this->hasMany(
            Filiere::class,
            'academic_domain_id'
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
