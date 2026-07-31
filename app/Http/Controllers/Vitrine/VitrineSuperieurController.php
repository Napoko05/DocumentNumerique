<?php

namespace App\Http\Controllers\Vitrine;

use App\Http\Controllers\Controller;
use App\Models\AcademicDomain;
use App\Models\Filiere;
use App\Models\Level;
use App\Models\Document;
use App\Models\DocumentType;

class VitrineSuperieurController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | DOMAINES ACADÉMIQUES
    |--------------------------------------------------------------------------
    |
    | Supérieur
    |     ↓
    | Domaine académique
    |
    */

    public function domaines()
    {
        $domaines = AcademicDomain::where(
            'is_active',
            true
        )
            ->orderBy('position')
            ->get();

        foreach ($domaines as $domaine) {

            $domaine->documents_count = Document::where(
                'academic_domain_id',
                $domaine->id
            )
                ->where(
                    'status',
                    'published'
                )
                ->count();
        }

        return view(
            'niveau.superieur.domaine',
            compact('domaines')
        );
    }


    /*
    |--------------------------------------------------------------------------
    | FILIÈRES D'UN DOMAINE
    |--------------------------------------------------------------------------
    |
    | Domaine
    |     ↓
    | Filière
    |
    | Exemple :
    |
    | Sciences exactes
    |     ↓
    | Informatique
    | Mathématiques
    | Physique
    |
    */

    public function filieres(
        string $domaineSlug
    ) {
        $domaine = AcademicDomain::where(
            'slug',
            $domaineSlug
        )
            ->where(
                'is_active',
                true
            )
            ->firstOrFail();

        $filieres = Filiere::where(
            'academic_domain_id',
            $domaine->id
        )
            ->where(
                'is_active',
                true
            )
            ->orderBy('name')
            ->get();

        foreach ($filieres as $filiere) {

            $filiere->documents_count = Document::where(
                'academic_domain_id',
                $domaine->id
            )
                ->where(
                    'filiere_id',
                    $filiere->id
                )
                ->where(
                    'status',
                    'published'
                )
                ->count();
        }

        return view(
            'niveau.superieur.filieres',
            compact(
                'domaine',
                'filieres'
            )
        );
    }


    /*
    |--------------------------------------------------------------------------
    | NIVEAUX D'UNE FILIÈRE
    |--------------------------------------------------------------------------
    |
    | Domaine
    |     ↓
    | Filière
    |     ↓
    | Niveau
    |
    */

    public function niveaux(
        string $domaineSlug,
        string $filiereSlug
    ) {
        $domaine = AcademicDomain::where(
            'slug',
            $domaineSlug
        )
            ->where(
                'is_active',
                true
            )
            ->firstOrFail();

        $filiere = Filiere::where(
            'academic_domain_id',
            $domaine->id
        )
            ->where(
                'slug',
                $filiereSlug
            )
            ->where(
                'is_active',
                true
            )
            ->firstOrFail();

        $niveaux = Level::where(
            'filiere_id',
            $filiere->id
        )
            ->where(
                'is_active',
                true
            )
            ->orderBy('order')
            ->get();

        foreach ($niveaux as $niveau) {

            $niveau->documents_count = Document::where(
                'academic_domain_id',
                $domaine->id
            )
                ->where(
                    'filiere_id',
                    $filiere->id
                )
                ->where(
                    'level_id',
                    $niveau->id
                )
                ->where(
                    'status',
                    'published'
                )
                ->count();
        }

        return view(
            'niveau.superieur.niveaux',
            compact(
                'domaine',
                'filiere',
                'niveaux'
            )
        );
    }


    /*
    |--------------------------------------------------------------------------
    | TYPES DE DOCUMENTS
    |--------------------------------------------------------------------------
    |
    | Domaine
    |     ↓
    | Filière
    |     ↓
    | Niveau
    |     ↓
    | Type de document
    |
    */

    public function typeDocuments(
        string $domaineSlug,
        string $filiereSlug,
        string $niveauSlug
    ) {
        $domaine = AcademicDomain::where(
            'slug',
            $domaineSlug
        )
            ->where(
                'is_active',
                true
            )
            ->firstOrFail();

        $filiere = Filiere::where(
            'academic_domain_id',
            $domaine->id
        )
            ->where(
                'slug',
                $filiereSlug
            )
            ->where(
                'is_active',
                true
            )
            ->firstOrFail();

        $niveau = Level::where(
            'filiere_id',
            $filiere->id
        )
            ->where(
                'slug',
                $niveauSlug
            )
            ->where(
                'is_active',
                true
            )
            ->firstOrFail();

        $types = DocumentType::where(
            'is_active',
            true
        )
            ->orderBy('name')
            ->get();

        foreach ($types as $type) {

            $type->documents_count = Document::where(
                'academic_domain_id',
                $domaine->id
            )
                ->where(
                    'filiere_id',
                    $filiere->id
                )
                ->where(
                    'level_id',
                    $niveau->id
                )
                ->where(
                    'document_type_id',
                    $type->id
                )
                ->where(
                    'status',
                    'published'
                )
                ->count();
        }

        return view(
            'niveau.superieur.type_doc',
            compact(
                'domaine',
                'filiere',
                'niveau',
                'types'
            )
        );
    }


    /*
    |--------------------------------------------------------------------------
    | DOCUMENTS
    |--------------------------------------------------------------------------
    |
    | Domaine
    |     ↓
    | Filière
    |     ↓
    | Niveau
    |     ↓
    | Type de document
    |     ↓
    | Documents
    |
    */

    public function documents(
        string $domaineSlug,
        string $filiereSlug,
        string $niveauSlug,
        string $typeSlug
    ) {
        $domaine = AcademicDomain::where(
            'slug',
            $domaineSlug
        )
            ->where(
                'is_active',
                true
            )
            ->firstOrFail();

        $filiere = Filiere::where(
            'academic_domain_id',
            $domaine->id
        )
            ->where(
                'slug',
                $filiereSlug
            )
            ->where(
                'is_active',
                true
            )
            ->firstOrFail();

        $niveau = Level::where(
            'filiere_id',
            $filiere->id
        )
            ->where(
                'slug',
                $niveauSlug
            )
            ->where(
                'is_active',
                true
            )
            ->firstOrFail();

        $type = DocumentType::where(
            'slug',
            $typeSlug
        )
            ->where(
                'is_active',
                true
            )
            ->firstOrFail();

        $documents = Document::with([

            'staff',
            'academicDomain',
            'formation',
            'filiere',
            'level',
            'documentType',
            'ratings'

        ])
            ->where(
                'academic_domain_id',
                $domaine->id
            )
            ->where(
                'filiere_id',
                $filiere->id
            )
            ->where(
                'level_id',
                $niveau->id
            )
            ->where(
                'document_type_id',
                $type->id
            )
            ->where(
                'status',
                'published'
            )
            ->latest()
            ->paginate(12);

        return view(
            'niveau.superieur.documents',
            compact(
                'domaine',
                'filiere',
                'niveau',
                'type',
                'documents'
            )
        );
    }
}
