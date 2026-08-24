<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Filiere extends Model
{
    use HasFactory;

    protected $fillable = [
        'academic_domain_id',
        'name',
        'slug',
        'description',
        'icon',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    /*
    |--------------------------------------------------------------------------
    | DOMAINE ACADÉMIQUE
    |--------------------------------------------------------------------------
    */

    public function academicDomain()
    {
        return $this->belongsTo(
            AcademicDomain::class,
            'academic_domain_id'
        );
    }

    /*
    |--------------------------------------------------------------------------
    | NIVEAUX
    |--------------------------------------------------------------------------
    |
    | Supérieur :
    |
    | Filière
    |    ↓
    | Niveau
    |
    */

    public function levels()
    {
        return $this->hasMany(
            Level::class,
            'filiere_id'
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
            Document::class,
            'filiere_id'
        );
    }

    /*
    |--------------------------------------------------------------------------
    | SCOPE ACTIF
    |--------------------------------------------------------------------------
    */

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }
}