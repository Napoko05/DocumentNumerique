<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Document extends Model
{
    use HasFactory;


    protected $fillable = [

        'staff_id',

        // Supérieur
        'formation_id',
        'filiere_id',

        // ENS
        'program_id',
        'specialite_id',

        // Commun
        'level_id',
        'subject_id',
        'document_type_id',

        // Informations
        'title',
        'slug',
        'description',
        'content',

        // Fichiers
        'file_path',
        'cover_image',
        'file_size',
        'file_extension',

        // Publication
        'published_at',
        'status',

        // Accès
        'access_type',
        'price',

        // Statistiques
        'views',
        'downloads',

    ];



    protected $casts = [

        'published_at' => 'datetime',
        'price' => 'decimal:2',

    ];



    /*
    |--------------------------------------------------------------------------
    | AUTEUR
    |--------------------------------------------------------------------------
    */

    public function staff()
    {
        return $this->belongsTo(
            Staff::class
        );
    }



    /*
    |--------------------------------------------------------------------------
    | SUPERIEUR
    |--------------------------------------------------------------------------
    */

    public function formation()
    {
        return $this->belongsTo(
            Formation::class
        );
    }



    public function filiere()
    {
        return $this->belongsTo(
            Filiere::class
        );
    }



    /*
    |--------------------------------------------------------------------------
    | ENS
    |--------------------------------------------------------------------------
    */

    public function program()
    {
        return $this->belongsTo(
            Program::class
        );
    }



    public function specialite()
    {
        return $this->belongsTo(
            Specialite::class
        );
    }



    /*
    |--------------------------------------------------------------------------
    | NIVEAU
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
    | SECONDAIRE
    |--------------------------------------------------------------------------
    */

    public function subject()
    {
        return $this->belongsTo(
            Subject::class
        );
    }



    /*
    |--------------------------------------------------------------------------
    | TYPE DOCUMENT
    |--------------------------------------------------------------------------
    */

    public function documentType()
    {
        return $this->belongsTo(
            DocumentType::class
        );
    }



    /*
    |--------------------------------------------------------------------------
    | INTERACTIONS
    |--------------------------------------------------------------------------
    */

    public function comments()
    {
        return $this->hasMany(
            Comment::class
        );
    }



    public function payments()
    {
        return $this->hasMany(
            Payment::class
        );
    }



    public function documentViews()
    {
        return $this->hasMany(
            DocumentView::class
        );
    }



    public function tags()
    {
        return $this->belongsToMany(
            Tag::class
        );
    }

    public function scopePublished($query)
    {
        return $query->where(
            'status',
            'published'
        );
    }

    public function ratings()
    {
        return $this->hasMany(
            Rating::class
        );
    }
}
