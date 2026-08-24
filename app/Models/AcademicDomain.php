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
    | FILIÈRES
    |--------------------------------------------------------------------------
    |
    | Supérieur :
    |
    | Domaine académique
    |        ↓
    | Filière
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
    | DOCUMENTS
    |--------------------------------------------------------------------------
    |
    | Relation utile pour les documents associés
    | au domaine académique.
    |
    */

    public function documents()
    {
        return $this->hasMany(
            Document::class,
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