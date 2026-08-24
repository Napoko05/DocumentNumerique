<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Formation extends Model
{
    use HasFactory;

    protected $fillable = [
        'teaching_category_id',
        'name',
        'slug',
        'description',
        'icon',
        'position',
        'is_active',
    ];

    protected $casts = [
        'position'  => 'integer',
        'is_active' => 'boolean',
    ];

    /*
    |--------------------------------------------------------------------------
    | CATÉGORIE D'ENSEIGNEMENT
    |--------------------------------------------------------------------------
    */

    public function teachingCategory()
    {
        return $this->belongsTo(
            TeachingCategory::class,
            'teaching_category_id'
        );
    }

    /*
    |--------------------------------------------------------------------------
    | NIVEAUX
    |--------------------------------------------------------------------------
    |
    | Secondaire :
    | Formation → Niveau
    |
    | Professionnel :
    | Formation → Niveau
    |
    | ENS :
    | Formation → Programme → Spécialité → Niveau
    |
    */

    public function levels()
    {
        return $this->hasMany(
            Level::class,
            'formation_id'
        );
    }

    /*
    |--------------------------------------------------------------------------
    | PROGRAMMES
    |--------------------------------------------------------------------------
    |
    | Utilisé principalement par ENS.
    |
    | ENS → Programme
    |
    */

    public function programs()
    {
        return $this->hasMany(
            Program::class,
            'formation_id'
        );
    }

    /*
    |--------------------------------------------------------------------------
    | SPÉCIALITÉS DIRECTES
    |--------------------------------------------------------------------------
    |
    | Utilisé pour :
    |
    | IDS → Spécialité
    | UIT → Spécialité
    |
    */

    public function specialites()
    {
        return $this->hasMany(
            Specialite::class,
            'formation_id'
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
            'formation_id'
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