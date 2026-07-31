<?php

namespace App\Http\Controllers\Vitrine;

use App\Http\Controllers\Controller;

use App\Models\Document;
use App\Models\DocumentType;
use App\Models\Formation;
use App\Models\Level;
use App\Models\Program;
use App\Models\Specialite;
use App\Models\TeachingCategory;

class VitrineProfessionnelController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | FORMATIONS PROFESSIONNELLES
    |--------------------------------------------------------------------------
    |
    | ENSP / ENEP / IDS / ATE
    |
    | Formation
    |     ↓
    | Niveau
    |     ↓
    | Type de document
    |     ↓
    | Document
    |
    */


    /**
     * Afficher les formations professionnelles hors ENS.
     */
    public function formations()
    {
        $categorie = TeachingCategory::where(
            'slug',
            'professionnel'
        )
            ->where(
                'is_active',
                true
            )
            ->firstOrFail();

        $formations = Formation::where(
            'teaching_category_id',
            $categorie->id
        )
            ->where(
                'is_active',
                true
            )
            ->orderBy(
                'position'
            )
            ->orderBy(
                'name'
            )
            ->get();


        return view(
            'niveau.professionnel.formations',
            compact(
                'categorie',
                'formations'
            )
        );
    }



    /**
     * Afficher les niveaux d'une formation simple.
     *
     * ENSP → Niveau
     * ENEP → Niveau
     * IDS  → Niveau
     * ATE  → Niveau
     */
    public function niveaux(
        $formationSlug
    ) {
        $formation = Formation::where(
            'slug',
            $formationSlug
        )
            ->where(
                'slug',
                '!=',
                'ens'
            )
            ->where(
                'is_active',
                true
            )
            ->firstOrFail();


        $niveaux = Level::where(
            'formation_id',
            $formation->id
        )
            ->where(
                'is_active',
                true
            )
            ->orderBy(
                'order'
            )
            ->get();


        return view(
            'niveau.professionnel.ecoles.niveaux',
            compact(
                'formation',
                'niveaux'
            )
        );
    }


    /**
     * Afficher les types de documents
     * d'un niveau de formation simple.
     */
    public function typeDocuments(
        $formationSlug,
        $niveauSlug
    ) {
        $formation = Formation::where(
            'slug',
            $formationSlug
        )
            ->where(
                'slug',
                '!=',
                'ens'
            )
            ->where(
                'is_active',
                true
            )
            ->firstOrFail();


        $niveau = Level::where(
            'formation_id',
            $formation->id
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
            ->orderBy(
                'name'
            )
            ->get();


        return view(
            'niveau.professionnel.ecoles.type_doc',
            compact(
                'formation',
                'niveau',
                'types'
            )
        );
    }


    /**
     * Afficher les documents
     * d'une formation professionnelle simple.
     */
    public function documents(
        $formationSlug,
        $niveauSlug,
        $typeSlug
    ) {
        $formation = Formation::where(
            'slug',
            $formationSlug
        )
            ->where(
                'slug',
                '!=',
                'ens'
            )
            ->where(
                'is_active',
                true
            )
            ->firstOrFail();


        $niveau = Level::where(
            'formation_id',
            $formation->id
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


        $documents = Document::where(
            'formation_id',
            $formation->id
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
            'niveau.professionnel.ecoles.documents',
            compact(
                'formation',
                'niveau',
                'type',
                'documents'
            )
        );
    }


    /*
    |--------------------------------------------------------------------------
    | ENS
    |--------------------------------------------------------------------------
    |
    | ENS
    |     ↓
    | Programme
    |     ↓
    | Spécialité
    |     ↓
    | Niveau
    |     ↓
    | Type de document
    |     ↓
    | Document
    |
    */


    /**
     * Afficher les programmes de l'ENS.
     */
    public function programmes()
    {
        $formation = Formation::where(
            'slug',
            'ens'
        )
            ->where(
                'is_active',
                true
            )
            ->firstOrFail();


        $programmes = Program::where(
            'formation_id',
            $formation->id
        )
            ->where(
                'is_active',
                true
            )
            ->orderBy(
                'name'
            )
            ->get();


        return view(
            'niveau.professionnel.ens.programmes',
            compact(
                'formation',
                'programmes'
            )
        );
    }


    /**
     * Afficher les spécialités
     * d'un programme ENS.
     */
    public function specialites(
        $programmeSlug
    ) {
        $formation = Formation::where(
            'slug',
            'ens'
        )
            ->where(
                'is_active',
                true
            )
            ->firstOrFail();


        $programme = Program::where(
            'formation_id',
            $formation->id
        )
            ->where(
                'slug',
                $programmeSlug
            )
            ->where(
                'is_active',
                true
            )
            ->firstOrFail();


        $specialites = Specialite::where(
            'program_id',
            $programme->id
        )
            ->where(
                'is_active',
                true
            )
            ->orderBy(
                'name'
            )
            ->get();


        return view(
            'niveau.professionnel.ens.specialites',
            compact(
                'formation',
                'programme',
                'specialites'
            )
        );
    }


    /**
     * Afficher les niveaux
     * d'une spécialité ENS.
     */
    public function niveauxEns(
        $programmeSlug,
        $specialiteSlug
    ) {
        $formation = Formation::where(
            'slug',
            'ens'
        )
            ->where(
                'is_active',
                true
            )
            ->firstOrFail();


        $programme = Program::where(
            'formation_id',
            $formation->id
        )
            ->where(
                'slug',
                $programmeSlug
            )
            ->where(
                'is_active',
                true
            )
            ->firstOrFail();


        $specialite = Specialite::where(
            'program_id',
            $programme->id
        )
            ->where(
                'slug',
                $specialiteSlug
            )
            ->where(
                'is_active',
                true
            )
            ->firstOrFail();


        $niveaux = Level::where(
            'specialite_id',
            $specialite->id
        )
            ->where(
                'is_active',
                true
            )
            ->orderBy(
                'order'
            )
            ->get();


        return view(
            'niveau.professionnel.ens.niveaux',
            compact(
                'formation',
                'programme',
                'specialite',
                'niveaux'
            )
        );
    }


    /**
     * Afficher les types de documents
     * d'un niveau ENS.
     */
    public function typeDocumentsEns(
        $programmeSlug,
        $specialiteSlug,
        $niveauSlug
    ) {
        $formation = Formation::where(
            'slug',
            'ens'
        )
            ->where(
                'is_active',
                true
            )
            ->firstOrFail();


        $programme = Program::where(
            'formation_id',
            $formation->id
        )
            ->where(
                'slug',
                $programmeSlug
            )
            ->where(
                'is_active',
                true
            )
            ->firstOrFail();


        $specialite = Specialite::where(
            'program_id',
            $programme->id
        )
            ->where(
                'slug',
                $specialiteSlug
            )
            ->where(
                'is_active',
                true
            )
            ->firstOrFail();


        $niveau = Level::where(
            'specialite_id',
            $specialite->id
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
            ->orderBy(
                'name'
            )
            ->get();


        return view(
            'niveau.professionnel.ens.type_doc',
            compact(
                'formation',
                'programme',
                'specialite',
                'niveau',
                'types'
            )
        );
    }


    /**
     * Afficher les documents ENS.
     */
    public function documentsEns(
        $programmeSlug,
        $specialiteSlug,
        $niveauSlug,
        $typeSlug
    ) {
        $formation = Formation::where(
            'slug',
            'ens'
        )
            ->where(
                'is_active',
                true
            )
            ->firstOrFail();


        $programme = Program::where(
            'formation_id',
            $formation->id
        )
            ->where(
                'slug',
                $programmeSlug
            )
            ->where(
                'is_active',
                true
            )
            ->firstOrFail();


        $specialite = Specialite::where(
            'program_id',
            $programme->id
        )
            ->where(
                'slug',
                $specialiteSlug
            )
            ->where(
                'is_active',
                true
            )
            ->firstOrFail();


        $niveau = Level::where(
            'specialite_id',
            $specialite->id
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


        $documents = Document::where(
            'formation_id',
            $formation->id
        )
            ->where(
                'program_id',
                $programme->id
            )
            ->where(
                'specialite_id',
                $specialite->id
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
            'niveau.professionnel.ens.documents',
            compact(
                'formation',
                'programme',
                'specialite',
                'niveau',
                'type',
                'documents'
            )
        );
    }
}
