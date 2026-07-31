<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

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

        'is_active' => 'boolean',

    ];



    /*
    |--------------------------------------------------------------------------
    | CATEGORIE D'ENSEIGNEMENT
    |--------------------------------------------------------------------------
    |
    | Secondaire
    | Supérieur
    | Professionnel
    |
    */

    public function teachingCategory()
    {
        return $this->belongsTo(
            TeachingCategory::class
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
    | NIVEAUX
    |--------------------------------------------------------------------------
    |
    | Secondaire :
    |
    | Formation
    |    ↓
    | Niveau
    |
    */

    public function levels()
    {
        return $this->hasMany(
            Level::class
        );
    }




    /*
    |--------------------------------------------------------------------------
    | PROGRAMMES ENS
    |--------------------------------------------------------------------------
    |
    | ENS uniquement
    |
    */

    public function programs()
    {
        return $this->hasMany(
            Program::class
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