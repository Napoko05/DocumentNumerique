<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Specialite extends Model
{
    use HasFactory;

    protected $fillable = [
        'formation_id',
        'program_id',
        'position',
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
    | FORMATION DIRECTE
    |--------------------------------------------------------------------------
    |
    | IDS :
    | Formation → Spécialité
    |
    | UIT :
    | Formation → Spécialité
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
    | PROGRAMME
    |--------------------------------------------------------------------------
    |
    | ENS :
    |
    | Formation
    |    ↓
    | Programme
    |    ↓
    | Spécialité
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
    | NIVEAUX
    |--------------------------------------------------------------------------
    |
    | Spécialité
    |      ↓
    | Niveau
    |
    */

    public function levels()
    {
        return $this->hasMany(
            Level::class,
            'specialite_id'
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
            'specialite_id'
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