<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Subject extends Model
{
    use HasFactory;


    /*
    |--------------------------------------------------------------------------
    | CHAMPS AUTORISÉS
    |--------------------------------------------------------------------------
    */

    protected $fillable = [

        'level_id',

        'name',

        'slug',

        'is_active',

    ];


    /*
    |--------------------------------------------------------------------------
    | CASTS
    |--------------------------------------------------------------------------
    */

    protected $casts = [

        'is_active' => 'boolean',

    ];


    /*
    |--------------------------------------------------------------------------
    | CLASSE / NIVEAU
    |--------------------------------------------------------------------------
    */

    public function level()
    {
        return $this->belongsTo(
            Level::class
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
    | SCOPE : MATIÈRES ACTIVES
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
    | SCOPE : MATIÈRES DU SECONDAIRE
    |--------------------------------------------------------------------------
    */

    public function scopeSecondary($query)
    {
        return $query->whereHas(
            'level',
            function ($levelQuery) {

                $levelQuery->secondary();

            }
        );
    }


    /*
    |--------------------------------------------------------------------------
    | SCOPE : MATIÈRES DU SUPÉRIEUR
    |--------------------------------------------------------------------------
    */

    public function scopeHigher($query)
    {
        return $query->whereHas(
            'level',
            function ($levelQuery) {

                $levelQuery->higher();

            }
        );
    }


    /*
    |--------------------------------------------------------------------------
    | SCOPE : MATIÈRES DU PROFESSIONNEL
    |--------------------------------------------------------------------------
    */

    public function scopeProfessional($query)
    {
        return $query->whereHas(
            'level',
            function ($levelQuery) {

                $levelQuery->professional();

            }
        );
    }
}