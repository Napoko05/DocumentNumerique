<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Subject extends Model
{
    use HasFactory;

    protected $fillable = [
        'level_id',
        'position',
        'name',
        'slug',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    /*
    |--------------------------------------------------------------------------
    | NIVEAU
    |--------------------------------------------------------------------------
    */

    public function level()
    {
        return $this->belongsTo(
            Level::class,
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
            'subject_id'
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
    */

    public function scopeSecondary($query)
    {
        return $query->whereHas(
            'level',
            fn ($q) => $q->secondary()
        );
    }

    /*
    |--------------------------------------------------------------------------
    | SUPÉRIEUR
    |--------------------------------------------------------------------------
    */

    public function scopeHigher($query)
    {
        return $query->whereHas(
            'level',
            fn ($q) => $q->higher()
        );
    }

    /*
    |--------------------------------------------------------------------------
    | PROFESSIONNEL
    |--------------------------------------------------------------------------
    */

    public function scopeProfessional($query)
    {
        return $query->whereHas(
            'level',
            fn ($q) => $q->professional()
        );
    }
}