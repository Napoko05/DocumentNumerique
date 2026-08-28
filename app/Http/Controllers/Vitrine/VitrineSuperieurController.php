<?php

namespace App\Http\Controllers\Vitrine;

use App\Http\Controllers\Controller;
use App\Models\AcademicDomain;
use App\Models\Document;
use App\Models\Filiere;
use App\Models\Level;
use App\Models\Subject;
use App\Models\TeachingCategory;

class VitrineSuperieurController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | CATÉGORIE SUPÉRIEUR
    |--------------------------------------------------------------------------
    */

    private function superiorCategory()
    {
        return TeachingCategory::query()
            ->whereIn('slug', [
                'superieur',
                'higher',
            ])
            ->where('is_active', true)
            ->firstOrFail();
    }

    /*
    |--------------------------------------------------------------------------
    | DOMAINE ACADÉMIQUE
    |--------------------------------------------------------------------------
    */

    private function getDomaine($domaineSlug)
    {
        return AcademicDomain::query()
            ->where('slug', $domaineSlug)
            ->where('is_active', true)
            ->firstOrFail();
    }

    /*
    |--------------------------------------------------------------------------
    | FILIÈRE
    |--------------------------------------------------------------------------
    */

    private function getFiliere(
        $domaine,
        $filiereSlug
    ) {
        return Filiere::query()
            ->where('slug', $filiereSlug)
            ->where('academic_domain_id', $domaine->id)
            ->where('is_active', true)
            ->firstOrFail();
    }

    /*
    |--------------------------------------------------------------------------
    | NIVEAU
    |--------------------------------------------------------------------------
    */

    private function getNiveau(
        $filiere,
        $niveauSlug
    ) {
        return Level::query()
            ->where('slug', $niveauSlug)
            ->where('filiere_id', $filiere->id)
            ->whereNull('formation_id')
            ->whereNull('specialite_id')
            ->where('is_active', true)
            ->firstOrFail();
    }

    /*
    |--------------------------------------------------------------------------
    | MODULE / MATIÈRE
    |--------------------------------------------------------------------------
    */

    private function getSubject(
        $niveau,
        $subjectSlug
    ) {
        return Subject::query()
            ->where('slug', $subjectSlug)
            ->where('level_id', $niveau->id)
            ->where('is_active', true)
            ->firstOrFail();
    }

    /*
    |--------------------------------------------------------------------------
    | DOMAINES
    |--------------------------------------------------------------------------
    |
    | /superieur
    |
    */

    public function domaines()
    {
        $domaines = AcademicDomain::query()
            ->where('is_active', true)
            ->orderBy('name')
            ->get();

        return view(
            'niveau.superieur.domaines',
            compact('domaines')
        );
    }

    /*
    |--------------------------------------------------------------------------
    | FILIÈRES D'UN DOMAINE
    |--------------------------------------------------------------------------
    |
    | Domaine → Filière
    |
    | /superieur/{domaineSlug}/filieres
    |
    */

    public function filieres($domaineSlug)
    {
        $domaine = $this->getDomaine($domaineSlug);

        $filieres = Filiere::query()
            ->where(
                'academic_domain_id',
                $domaine->id
            )
            ->where('is_active', true)
            ->orderBy('name')
            ->get();

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
    | Filière → Niveau
    |
    | /superieur/{domaineSlug}/{filiereSlug}/niveaux
    |
    */

    public function niveaux(
        $domaineSlug,
        $filiereSlug
    ) {
        $domaine = $this->getDomaine($domaineSlug);

        $filiere = $this->getFiliere(
            $domaine,
            $filiereSlug
        );

        $niveaux = Level::query()
            ->where(
                'filiere_id',
                $filiere->id
            )
            ->whereNull('formation_id')
            ->whereNull('specialite_id')
            ->where('is_active', true)
            ->orderBy('order')
            ->orderBy('name')
            ->get();

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
    | MODULES / MATIÈRES
    |--------------------------------------------------------------------------
    |
    | Niveau → Module / Matière
    |
    | /superieur/{domaineSlug}/{filiereSlug}/{niveauSlug}/modules
    |
    */

    public function modules(
        $domaineSlug,
        $filiereSlug,
        $niveauSlug
    ) {
        $domaine = $this->getDomaine($domaineSlug);

        $filiere = $this->getFiliere(
            $domaine,
            $filiereSlug
        );

        $niveau = $this->getNiveau(
            $filiere,
            $niveauSlug
        );

        $subjects = Subject::query()
            ->where(
                'level_id',
                $niveau->id
            )
            ->where('is_active', true)
            ->orderBy('position')
            ->orderBy('name')
            ->get();

        return view(
            'niveau.superieur.modules',
            compact(
                'domaine',
                'filiere',
                'niveau',
                'subjects'
            )
        );
    }

    /*
    |--------------------------------------------------------------------------
    | DOCUMENTS D'UNE MATIÈRE
    |--------------------------------------------------------------------------
    |
    | Matière → Documents
    |
    | /superieur/{domaineSlug}/{filiereSlug}/{niveauSlug}/{subjectSlug}/documents
    |
    */

    public function documents(
        $domaineSlug,
        $filiereSlug,
        $niveauSlug,
        $subjectSlug
    ) {
        $domaine = $this->getDomaine($domaineSlug);

        $filiere = $this->getFiliere(
            $domaine,
            $filiereSlug
        );

        $niveau = $this->getNiveau(
            $filiere,
            $niveauSlug
        );

        $subject = $this->getSubject(
            $niveau,
            $subjectSlug
        );

        $category = $this->superiorCategory();

        $documents = Document::query()
            ->where(
                'teaching_category_id',
                $category->id
            )
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
                'subject_id',
                $subject->id
            )
            ->where(
                'status',
                'published'
            )
            ->with([
                'documentType',
                'tags',
            ])
            ->latest('published_at')
            ->latest('id')
            ->get();

        return view(
            'niveau.superieur.documents',
            compact(
                'domaine',
                'filiere',
                'niveau',
                'subject',
                'documents'
            )
        );
    }

    /*
    |--------------------------------------------------------------------------
    | DOCUMENT INDIVIDUEL
    |--------------------------------------------------------------------------
    |
    | /superieur/{domaineSlug}/{filiereSlug}/{niveauSlug}/{subjectSlug}/document/{documentSlug}
    |
    */

    public function show(
        $domaineSlug,
        $filiereSlug,
        $niveauSlug,
        $subjectSlug,
        $documentSlug
    ) {
        $domaine = $this->getDomaine($domaineSlug);

        $filiere = $this->getFiliere(
            $domaine,
            $filiereSlug
        );

        $niveau = $this->getNiveau(
            $filiere,
            $niveauSlug
        );

        $subject = $this->getSubject(
            $niveau,
            $subjectSlug
        );

        $category = $this->superiorCategory();

        $document = Document::query()
            ->where(
                'slug',
                $documentSlug
            )
            ->where(
                'teaching_category_id',
                $category->id
            )
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
                'subject_id',
                $subject->id
            )
            ->where(
                'status',
                'published'
            )
            ->with([
                'formation',
                'filiere',
                'level',
                'subject',
                'documentType',
                'tags',
            ])
            ->firstOrFail();

        return view(
            'niveau.superieur.show',
            compact(
                'domaine',
                'filiere',
                'niveau',
                'subject',
                'document'
            )
        );
    }
}
