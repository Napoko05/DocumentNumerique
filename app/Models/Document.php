<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Document extends Model
{
    use HasFactory;
    /*
    |--------------------------------------------------------------------------
    | CHAMPS AUTORISÉS
    |--------------------------------------------------------------------------
    */

    protected $fillable = [


        'staff_id',
        'teaching_category_id',
        'academic_domain_id',

        'formation_id',

        'filiere_id',

        'program_id',

        'specialite_id',

        'level_id',

        'subject_id',

        'document_type_id',

        'title',

        'slug',

        'description',

        'content',

        'file_path',

        'cover_image',

        'file_size',

        'file_extension',

        'published_at',

        'status',

        'access_type',

        'price',

        'views',

        'downloads',

    ];
    /*
    |--------------------------------------------------------------------------
    | CASTS
    |--------------------------------------------------------------------------
    */
    protected $casts = [

        'published_at' => 'datetime',

        'price' => 'decimal:2',

        'file_size' => 'integer',

        'views' => 'integer',

        'downloads' => 'integer',

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

    public function teachingCategory()
    {
        return $this->belongsTo(
            TeachingCategory::class
        );
    }
    public function academicDomain()
    {
        return $this->belongsTo(
            AcademicDomain::class
        );
    }
    /*
    |--------------------------------------------------------------------------
    | FORMATION
    |--------------------------------------------------------------------------
    */

    public function formation()
    {
        return $this->belongsTo(
            Formation::class
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
            Filiere::class
        );
    }

    /*
    |--------------------------------------------------------------------------
    | PROGRAMME
    |--------------------------------------------------------------------------
    */
    public function program()
    {
        return $this->belongsTo(
            Program::class
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
    | MATIÈRE / MODULE
    |--------------------------------------------------------------------------
    |
    | Secondaire :
    | Niveau → Matière
    |
    | Supérieur :
    | Niveau → Module
    |
    | Professionnel :
    | Niveau → Module
    |
    */

    public function subject()
    {
        return $this->belongsTo(
            Subject::class
        );
    }
    /*
    |--------------------------------------------------------------------------
    | TYPE DE DOCUMENT
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
    | TAGS
    |--------------------------------------------------------------------------
    */
    public function tags()
    {
        return $this->belongsToMany(
            Tag::class
        );
    }
    /*
    |--------------------------------------------------------------------------
    | COMMENTAIRES
    |--------------------------------------------------------------------------
    */
    public function comments()
    {
        return $this->hasMany(
            Comment::class
        );
    }
    /*
    |--------------------------------------------------------------------------
    | PAIEMENTS
    |--------------------------------------------------------------------------
    */
    public function payments()
    {
        return $this->hasMany(
            Payment::class
        );
    }
    /*
    |--------------------------------------------------------------------------
    | VUES DÉTAILLÉES
    |--------------------------------------------------------------------------
    */
    public function documentViews()
    {
        return $this->hasMany(
            DocumentView::class
        );
    }
    /*
    |--------------------------------------------------------------------------
    | NOTES
    |--------------------------------------------------------------------------
    */
    public function ratings()
    {
        return $this->hasMany(
            Rating::class
        );
    }
    /*
    |--------------------------------------------------------------------------
    | SCOPE : DOCUMENTS PUBLIÉS
    |--------------------------------------------------------------------------
    */
    public function scopePublished(
        $query
    ) {
        return $query->where(
            'status',
            'published'
        );
    }
    /*
    |--------------------------------------------------------------------------
    | VÉRIFICATION : DOCUMENT GRATUIT
    |--------------------------------------------------------------------------
    */
    public function isFree(): bool
    {
        return $this->access_type === 'free';
    }
    /*
    |--------------------------------------------------------------------------
    | VÉRIFICATION : DOCUMENT PREMIUM
    |--------------------------------------------------------------------------
    */

    public function isPremium(): bool
    {
        return $this->access_type === 'premium';
    }
}
