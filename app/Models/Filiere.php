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
    |
    | Exemple :
    |
    | Sciences exactes
    |        ↓
    | Informatique
    |
    */

    public function academicDomain()
    {
        return $this->belongsTo(
            AcademicDomain::class
        );
    }



    /*
    |--------------------------------------------------------------------------
    | NIVEAUX
    |--------------------------------------------------------------------------
    |
    | Exemple :
    |
    | Informatique
    |        ↓
    | Licence 1
    | Licence 2
    | Licence 3
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
    | DOCUMENTS
    |--------------------------------------------------------------------------
    |
    | Documents directement liés à la filière
    |
    */

    public function documents()
    {
        return $this->hasMany(
            Document::class
        );
    }



    /*
    |--------------------------------------------------------------------------
    | SCOPE ACTIVE
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