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

    /*
    |--------------------------------------------------------------------------
    | CATÉGORIE D'ENSEIGNEMENT
    |--------------------------------------------------------------------------
    */

    public function teachingCategory()
    {
        return $this->belongsTo(
            TeachingCategory::class
        );
    }

    /*
    |--------------------------------------------------------------------------
    | DOMAINE ACADÉMIQUE
    |--------------------------------------------------------------------------
    */

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
    |
    | Un document peut posséder plusieurs tentatives de paiement.
    |
    */

    public function payments()
    {
        return $this->hasMany(
            Payment::class
        );
    }

    /*
    |--------------------------------------------------------------------------
    | UTILISATEUR AYANT PAYÉ
    |--------------------------------------------------------------------------
    |
    | Retourne true uniquement lorsqu'un paiement :
    |
    | - appartient au document
    | - appartient à l'utilisateur
    | - possède le statut "paid"
    |
    */

    public function isPaidBy(int $userId): bool
    {
        return $this->payments()
            ->where('user_id', $userId)
            ->where('status', 'paid')
            ->exists();
    }

    /*
    |--------------------------------------------------------------------------
    | PAIEMENT PAYÉ
    |--------------------------------------------------------------------------
    */

    public function paidPayments()
    {
        return $this->hasMany(
            Payment::class
        )->where(
            'status',
            'paid'
        );
    }

    /*
    |--------------------------------------------------------------------------
    | UTILISATEUR AYANT ACCÈS
    |--------------------------------------------------------------------------
    */

    public function userHasAccess(?int $userId): bool
    {
        /*
        |--------------------------------------------------------------
        | Pas d'utilisateur connecté
        |--------------------------------------------------------------
        */

        if (!$userId) {
            return false;
        }

        /*
        |--------------------------------------------------------------
        | Document gratuit
        |--------------------------------------------------------------
        */

        if ($this->isFree()) {
            return true;
        }

        /*
        |--------------------------------------------------------------
        | Document premium
        |--------------------------------------------------------------
        */

        if ($this->isPremium()) {
            return $this->isPaidBy($userId);
        }

        return false;
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

    public function scopePublished($query)
    {
        return $query->where(
            'status',
            'published'
        );
    }

    /*
    |--------------------------------------------------------------------------
    | DOCUMENT GRATUIT
    |--------------------------------------------------------------------------
    */

    public function isFree(): bool
    {
        return $this->access_type === 'free';
    }

    /*
    |--------------------------------------------------------------------------
    | DOCUMENT PREMIUM
    |--------------------------------------------------------------------------
    |
    | Un document est réellement premium uniquement si :
    |
    | access_type = premium
    | ET
    | price > 0
    |
    */

    public function isPremium(): bool
    {
        return $this->access_type === 'premium'
            && $this->price !== null
            && (float) $this->price > 0;
    }
}
