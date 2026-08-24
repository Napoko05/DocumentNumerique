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
        'position',
        'is_active',
    ];

    protected $casts = [
        'position'  => 'integer',
        'is_active' => 'boolean',
    ];

    /*
    |--------------------------------------------------------------------------
    | FORMATION
    |--------------------------------------------------------------------------
    |
    | ENS → Programme
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
    | SPÉCIALITÉS
    |--------------------------------------------------------------------------
    |
    | ENS :
    |
    | Programme
    |      ↓
    | Spécialité
    |
    */

    public function specialites()
    {
        return $this->hasMany(
            Specialite::class,
            'program_id'
        );
    }

    /*
    |--------------------------------------------------------------------------
    | NIVEAUX
    |--------------------------------------------------------------------------
    |
    | Les niveaux ENS passent par les spécialités.
    |
    */

    public function levels()
    {
        return $this->hasManyThrough(
            Level::class,
            Specialite::class,
            'program_id',
            'specialite_id',
            'id',
            'id'
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
            'program_id'
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