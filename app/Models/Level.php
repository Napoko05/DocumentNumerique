<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Level extends Model
{
    use HasFactory;


    /*
    |--------------------------------------------------------------------------
    | CHAMPS AUTORISÉS
    |--------------------------------------------------------------------------
    */

    protected $fillable = [

        /*
        |--------------------------------------------------------------------------
        | CONTEXTE
        |--------------------------------------------------------------------------
        */

        'formation_id',

        'filiere_id',

        'program_id',

        'specialite_id',

        /*
        |--------------------------------------------------------------------------
        | CLASSIFICATION
        |--------------------------------------------------------------------------
        */

        'section',

        /*
        |--------------------------------------------------------------------------
        | INFORMATIONS DU NIVEAU
        |--------------------------------------------------------------------------
        */

        'name',

        'slug',

        'order',

        'is_active',

    ];


    /*
    |--------------------------------------------------------------------------
    | CASTS
    |--------------------------------------------------------------------------
    */

    protected $casts = [

        'is_active' => 'boolean',

        'order' => 'integer',

    ];


    /*
    |--------------------------------------------------------------------------
    | FORMATION
    |--------------------------------------------------------------------------
    |
    | Utilisée pour :
    |
    | - Secondaire général
    | - Secondaire technique
    | - Professionnel
    | - ENS
    |
    */

    public function formation()
    {
        return $this->belongsTo(
            Formation::class,
            'formation_id'
        );
    }
    /*
    |--------------------------------------------------------------------------
    | FILIÈRE
    |--------------------------------------------------------------------------
    |
    | Utilisée pour le supérieur :
    |
    | Domaine académique
    |       ↓
    | Filière
    |       ↓
    | Niveau
    |
    */

    public function filiere()
    {
        return $this->belongsTo(
            Filiere::class,
            'filiere_id'
        );
    }

    /*
    |--------------------------------------------------------------------------
    | PROGRAMME
    |--------------------------------------------------------------------------
    |
    | Utilisé pour certaines formations professionnelles.
    |
    */

    public function program()
    {
        return $this->belongsTo(
            Program::class,
            'program_id'
        );
    }
    /*
    |--------------------------------------------------------------------------
    | SPÉCIALITÉ
    |--------------------------------------------------------------------------
    */

    public function specialite()
    {
        return $this->belongsTo(
            Specialite::class,
            'specialite_id'
        );
    }

    /*
    |--------------------------------------------------------------------------
    | MATIÈRES / MODULES
    |--------------------------------------------------------------------------
    |
    | Secondaire :
    |
    | Classe
    |    ↓
    | Matière
    |
    | Supérieur :
    |
    | Niveau
    |    ↓
    | Module
    |
    */

    public function subjects()
    {
        return $this->hasMany(
            Subject::class,
            'level_id'
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
            'level_id'
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
    /*
    |--------------------------------------------------------------------------
    | SCOPE SECONDAIRE
    |--------------------------------------------------------------------------
    |
    | Une classe du secondaire est liée à une formation
    | et n'est pas liée à une filière.
    |
    */

    public function scopeSecondary($query)
    {
        return $query
            ->whereNotNull(
                'formation_id'
            )
            ->whereNull(
                'filiere_id'
            )
            ->whereNull(
                'program_id'
            );
    }
    /*
    |--------------------------------------------------------------------------
    | SCOPE SUPÉRIEUR
    |--------------------------------------------------------------------------
    |
    | Une formation supérieure est liée à une filière.
    |
    */
    public function scopeHigher($query)
    {
        return $query->whereNotNull(
            'filiere_id'
        );
    }
    /*
    |--------------------------------------------------------------------------
    | SCOPE PROFESSIONNEL
    |--------------------------------------------------------------------------
    */

    public function scopeProfessional($query)
    {
        return $query
            ->whereNotNull(
                'formation_id'
            )
            ->whereNotNull(
                'program_id'
            );
    }
    /*
    |--------------------------------------------------------------------------
    | SECTION DU SECONDAIRE
    |--------------------------------------------------------------------------
    */
    public function scopeGeneral($query)
    {
        return $query->where(
            'section',
            'general'
        );
    }

    public function scopeTechnical($query)
    {
        return $query->where(
            'section',
            'technique'
        );
    }

    /*
    |--------------------------------------------------------------------------
    | VÉRIFICATIONS
    |--------------------------------------------------------------------------
    */

    public function isSecondary(): bool
    {
        return ! is_null(
            $this->formation_id
        )
            && is_null(
                $this->filiere_id
            )
            && is_null(
                $this->program_id
            );
    }

    public function isHigher(): bool
    {
        return ! is_null(
            $this->filiere_id
        );
    }

    public function isProfessional(): bool
    {
        return ! is_null(
            $this->program_id
        );
    }

    public function isGeneral(): bool
    {
        return $this->section === 'general';
    }

    public function isTechnical(): bool
    {
        return $this->section === 'technique';
    }
}
