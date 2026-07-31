<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Specialite extends Model
{
    use HasFactory;


    protected $fillable = [

        'program_id',

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
    | PROGRAMME
    |--------------------------------------------------------------------------
    |
    | Exemple :
    |
    | CAPES
    |    ↓
    | Mathématiques
    |
    */

    public function program()
    {
        return $this->belongsTo(
            Program::class
        );
    }



    /*
    |--------------------------------------------------------------------------
    | NIVEAUX
    |--------------------------------------------------------------------------
    |
    | Exemple :
    |
    | CAPES
    |    ↓
    | Mathématiques
    |    ↓
    | 1ère année
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
    */

    public function documents()
    {
        return $this->hasMany(
            Document::class
        );
    }

    public function scopePublished($query)
    {
        return $query->where(
            'status',
            'published'
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
