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
        'formation_id',
        'filiere_id',
        'specialite_id',
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
        'formation_id'  => 'integer',
        'filiere_id'    => 'integer',
        'specialite_id' => 'integer',
        'order'         => 'integer',
        'is_active'     => 'boolean',
    ];

    /*
    |--------------------------------------------------------------------------
    | FORMATION
    |--------------------------------------------------------------------------
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
        return $query->where('is_active', true);
    }

    /*
    |--------------------------------------------------------------------------
    | SECONDAIRE
    |--------------------------------------------------------------------------
    |
    | Formation → TeachingCategory
    |
    */

    public function scopeSecondary($query)
    {
        return $query->whereHas(
            'formation.teachingCategory',
            function ($q) {
                $q->where('slug', 'secondaire');
            }
        );
    }

    /*
    |--------------------------------------------------------------------------
    | SUPÉRIEUR
    |--------------------------------------------------------------------------
    |
    | Filière → AcademicDomain
    |
    | La catégorie "supérieur" n'est pas directement portée
    | par la filière dans la structure actuelle.
    |
    | Ce scope reste donc basé sur la structure du niveau.
    |
    */

    public function scopeHigher($query)
    {
        return $query
            ->whereNotNull('filiere_id')
            ->whereNull('formation_id')
            ->whereNull('specialite_id');
    }

    /*
    |--------------------------------------------------------------------------
    | PROFESSIONNEL
    |--------------------------------------------------------------------------
    |
    | Cas 1 :
    |
    | Formation → Level
    |
    | Exemple :
    | ENSP / ENEP / ATE
    |
    |
    | Cas 2 :
    |
    | Formation → Specialite → Level
    |
    | Exemple :
    | IDS / UIT
    |
    |
    | Cas 3 :
    |
    | Formation → Program → Specialite → Level
    |
    | Exemple :
    | ENS
    |
    */

    public function scopeProfessional($query)
    {
        return $query->where(function ($q) {

            /*
            |------------------------------------------------------------------
            | Formation → Level
            |------------------------------------------------------------------
            */

            $q->whereHas(
                'formation.teachingCategory',
                function ($category) {
                    $category->where('slug', 'professionnel');
                }
            );

            /*
            |------------------------------------------------------------------
            | Formation → Specialite → Level
            |------------------------------------------------------------------
            */

            $q->orWhereHas(
                'specialite.formation.teachingCategory',
                function ($category) {
                    $category->where('slug', 'professionnel');
                }
            );

            /*
            |------------------------------------------------------------------
            | Formation → Program → Specialite → Level
            |------------------------------------------------------------------
            */

            $q->orWhereHas(
                'specialite.program.formation.teachingCategory',
                function ($category) {
                    $category->where('slug', 'professionnel');
                }
            );
        });
    }

    /*
    |--------------------------------------------------------------------------
    | VÉRIFICATION : SECONDAIRE
    |--------------------------------------------------------------------------
    */

    public function isSecondary(): bool
    {
        return $this->formation_id !== null
            && $this->filiere_id === null
            && $this->specialite_id === null
            && $this->formation?->teachingCategory?->slug === 'secondaire';
    }

    /*
    |--------------------------------------------------------------------------
    | VÉRIFICATION : SUPÉRIEUR
    |--------------------------------------------------------------------------
    */

    public function isHigher(): bool
    {
        return $this->filiere_id !== null
            && $this->formation_id === null
            && $this->specialite_id === null;
    }

    /*
    |--------------------------------------------------------------------------
    | VÉRIFICATION : PROFESSIONNEL
    |--------------------------------------------------------------------------
    */

    public function isProfessional(): bool
    {
        if (
            $this->formation_id !== null &&
            $this->formation?->teachingCategory?->slug === 'professionnel'
        ) {
            return true;
        }

        if (
            $this->specialite?->formation?->teachingCategory?->slug === 'professionnel'
        ) {
            return true;
        }

        if (
            $this->specialite?->program?->formation?->teachingCategory?->slug === 'professionnel'
        ) {
            return true;
        }

        return false;
    }
}