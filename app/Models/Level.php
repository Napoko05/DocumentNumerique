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
        'section',
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
    | Utilisé pour :
    |
    | - Secondaire
    | - Professionnel
    | - ENS
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
    | FILIERE
    |--------------------------------------------------------------------------
    |
    | Utilisé pour le supérieur
    |
    | Informatique
    |    ↓
    | Licence 1
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
    | PROGRAMME
    |--------------------------------------------------------------------------
    |
    | ENS uniquement
    */

    public function program()
    {
        return $this->belongsTo(
            Program::class
        );
    }
    /*
    |--------------------------------------------------------------------------
    | SPECIALITE
    |--------------------------------------------------------------------------
    |
    | ENS uniquement
    |
    */

    public function specialite()
    {
        return $this->belongsTo(
            Specialite::class
        );
    }
    /*
    |--------------------------------------------------------------------------
    | MATIERES / MODULES
    |--------------------------------------------------------------------------
    |
    | Secondaire :
    | Classe → Matière
    |
    | Supérieur :
    | Niveau → Module
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
    */
    public function documents()
    {
        return $this->hasMany(
            Document::class
        );
    }
    /*
    |--------------------------------------------------------------------------
    | SCOPES GENERAUX
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
    | SECONDAIRE
    |--------------------------------------------------------------------------
    |
    | Exemple :
    |
    | Formation :
    | Secondaire Général
    |
    */

    public function scopeSecondary($query)
    {
        return $query->whereNotNull(
            'formation_id'
        )
        ->whereNull(
            'filiere_id'
        );
    }
    /*
    |--------------------------------------------------------------------------
    | SUPERIEUR
    |--------------------------------------------------------------------------
    |
    | Licence / Master
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
    | PROFESSIONNEL
    |--------------------------------------------------------------------------
    |
    | Formation professionnelle
    |
    */

    public function scopeProfessional($query)
    {
        return $query->whereNotNull(
            'formation_id'
        )
        ->whereNull(
            'filiere_id'
        )
        ->whereNotNull(
            'program_id'
        );
    }
    /*
    |--------------------------------------------------------------------------
    | SECTION SECONDAIRE
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
    | VERIFICATIONS
    |--------------------------------------------------------------------------
    */
    public function isSecondary(): bool
    {
        return !is_null($this->formation_id)
            && is_null($this->filiere_id);
    }

    public function isHigher(): bool
    {
        return !is_null($this->filiere_id);
    }

    public function isProfessional(): bool
    {
        return !is_null($this->program_id);
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