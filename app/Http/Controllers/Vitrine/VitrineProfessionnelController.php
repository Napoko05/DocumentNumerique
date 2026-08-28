<?php

namespace App\Http\Controllers\Vitrine;

use App\Http\Controllers\Controller;
use App\Models\Document;
use App\Models\DocumentType;
use App\Models\Formation;
use App\Models\Level;
use App\Models\Program;
use App\Models\Specialite;
use App\Models\Subject;

class VitrineProfessionnelController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | FORMATIONS
    |--------------------------------------------------------------------------
    */

    public function formations()
    {
        $formations = Formation::query()
            ->where('is_active', true)
            ->whereHas('teachingCategory', function ($query) {
                $query->where('slug', 'professionnel')
                    ->where('is_active', true);
            })
            ->with('teachingCategory')
            ->orderBy('position')
            ->orderBy('name')
            ->get();

        return view(
            'niveau.professionnel.formation',
            compact('formations')
        );
    }

    /*
    |--------------------------------------------------------------------------
    | FORMATION
    |--------------------------------------------------------------------------
    */

    public function niveaux(string $formationSlug)
    {
        $formation = Formation::query()
            ->where('slug', $formationSlug)
            ->where('is_active', true)
            ->whereHas('teachingCategory', function ($query) {
                $query->where('slug', 'professionnel')
                    ->where('is_active', true);
            })
            ->firstOrFail();

        /*
        | ENS
        */

        if ($formation->slug === 'ens') {
            return redirect()->route(
                'vitrine.professionnel.ens.programmes'
            );
        }

        /*
        | ENEP
        */

        if ($formation->slug === 'enep') {
            $niveaux = Level::query()
                ->where('formation_id', $formation->id)
                ->whereNull('filiere_id')
                ->whereNull('specialite_id')
                ->where('is_active', true)
                ->orderBy('order')
                ->orderBy('name')
                ->get();

            return view(
                'niveau.professionnel.enep.niveaux',
                compact('formation', 'niveaux')
            );
        }

        /*
        | ENSP / IDS / UIT
        */

        if (in_array($formation->slug, ['ensp', 'ids', 'uit'])) {
            return $this->specialitesFormation($formationSlug);
        }

        abort(404);
    }

    /*
    |--------------------------------------------------------------------------
    | ENEP
    | FORMATION → NIVEAU → MODULE
    |--------------------------------------------------------------------------
    */

    public function modules(
        string $formationSlug,
        string $niveauSlug
    ) {
        $formation = Formation::query()
            ->where('slug', $formationSlug)
            ->where('slug', 'enep')
            ->where('is_active', true)
            ->whereHas('teachingCategory', function ($query) {
                $query->where('slug', 'professionnel')
                    ->where('is_active', true);
            })
            ->firstOrFail();

        $niveau = Level::query()
            ->where('slug', $niveauSlug)
            ->where('formation_id', $formation->id)
            ->whereNull('filiere_id')
            ->whereNull('specialite_id')
            ->where('is_active', true)
            ->firstOrFail();

        $subjects = Subject::query()
            ->where('level_id', $niveau->id)
            ->where('is_active', true)
            ->whereHas('documents', function ($query) use ($formation, $niveau) {
                $query->where('status', 'published')
                    ->where('formation_id', $formation->id)
                    ->where('level_id', $niveau->id);
            })
            ->orderBy('position')
            ->orderBy('name')
            ->get();

        return view(
            'niveau.professionnel.enep.modules',
            compact(
                'formation',
                'niveau',
                'subjects'
            )
        );
    }

    /*
    |--------------------------------------------------------------------------
    | ENEP
    | NIVEAU → MODULE → TYPES
    |--------------------------------------------------------------------------
    */

    public function typeDocumentsModule(
        string $formationSlug,
        string $niveauSlug,
        string $moduleSlug
    ) {
        $formation = Formation::query()
            ->where('slug', $formationSlug)
            ->where('slug', 'enep')
            ->where('is_active', true)
            ->whereHas('teachingCategory', function ($query) {
                $query->where('slug', 'professionnel')
                    ->where('is_active', true);
            })
            ->firstOrFail();

        $niveau = Level::query()
            ->where('slug', $niveauSlug)
            ->where('formation_id', $formation->id)
            ->whereNull('filiere_id')
            ->whereNull('specialite_id')
            ->where('is_active', true)
            ->firstOrFail();

        $module = Subject::query()
            ->where('slug', $moduleSlug)
            ->where('level_id', $niveau->id)
            ->where('is_active', true)
            ->firstOrFail();

        $types = DocumentType::query()
            ->where('is_active', true)
            ->whereHas('documents', function ($query) use (
                $formation,
                $niveau,
                $module
            ) {
                $query->where('status', 'published')
                    ->where('formation_id', $formation->id)
                    ->where('level_id', $niveau->id)
                    ->where('subject_id', $module->id);
            })
            ->orderBy('name')
            ->get();

        return view(
            'niveau.professionnel.enep.type_doc',
            compact(
                'formation',
                'niveau',
                'module',
                'types'
            )
        );
    }

    /*
    |--------------------------------------------------------------------------
    | ENEP
    | MODULE → TYPE → DOCUMENTS
    |--------------------------------------------------------------------------
    */

    public function documentsModule(
        string $formationSlug,
        string $niveauSlug,
        string $moduleSlug,
        string $typeSlug
    ) {
        $formation = Formation::query()
            ->where('slug', $formationSlug)
            ->where('slug', 'enep')
            ->where('is_active', true)
            ->whereHas('teachingCategory', function ($query) {
                $query->where('slug', 'professionnel')
                    ->where('is_active', true);
            })
            ->firstOrFail();

        $niveau = Level::query()
            ->where('slug', $niveauSlug)
            ->where('formation_id', $formation->id)
            ->whereNull('filiere_id')
            ->whereNull('specialite_id')
            ->where('is_active', true)
            ->firstOrFail();

        $module = Subject::query()
            ->where('slug', $moduleSlug)
            ->where('level_id', $niveau->id)
            ->where('is_active', true)
            ->firstOrFail();

        $documentType = DocumentType::query()
            ->where('slug', $typeSlug)
            ->where('is_active', true)
            ->firstOrFail();

        $documents = Document::query()
            ->where('status', 'published')
            ->where('formation_id', $formation->id)
            ->where('level_id', $niveau->id)
            ->where('subject_id', $module->id)
            ->where('document_type_id', $documentType->id)
            ->with([
                'formation',
                'level',
                'subject',
                'documentType',
                'staff',
            ])
            ->latest('published_at')
            ->paginate(12)
            ->withQueryString();

        return view(
            'niveau.professionnel.enep.documents',
            compact(
                'formation',
                'niveau',
                'module',
                'documentType',
                'documents'
            )
        );
    }

    /*
    |--------------------------------------------------------------------------
    | ENEP
    | MODULE → TYPE → DOCUMENT
    |--------------------------------------------------------------------------
    */

    public function showDocumentModule(
        string $formationSlug,
        string $niveauSlug,
        string $moduleSlug,
        string $typeSlug,
        string $documentSlug
    ) {
        $formation = Formation::query()
            ->where('slug', $formationSlug)
            ->where('slug', 'enep')
            ->where('is_active', true)
            ->whereHas('teachingCategory', function ($query) {
                $query->where('slug', 'professionnel')
                    ->where('is_active', true);
            })
            ->firstOrFail();

        $niveau = Level::query()
            ->where('slug', $niveauSlug)
            ->where('formation_id', $formation->id)
            ->whereNull('filiere_id')
            ->whereNull('specialite_id')
            ->where('is_active', true)
            ->firstOrFail();

        $module = Subject::query()
            ->where('slug', $moduleSlug)
            ->where('level_id', $niveau->id)
            ->where('is_active', true)
            ->firstOrFail();

        $documentType = DocumentType::query()
            ->where('slug', $typeSlug)
            ->where('is_active', true)
            ->firstOrFail();

        $document = Document::query()
            ->with([
                'formation',
                'level',
                'subject',
                'documentType',
                'staff',
            ])
            ->where('slug', $documentSlug)
            ->where('status', 'published')
            ->where('formation_id', $formation->id)
            ->where('level_id', $niveau->id)
            ->where('subject_id', $module->id)
            ->where('document_type_id', $documentType->id)
            ->firstOrFail();

        $document->increment('views');

        return view(
            'niveau.professionnel.enep.show',
            compact(
                'formation',
                'niveau',
                'module',
                'documentType',
                'document'
            )
        );
    }

    /*
    |--------------------------------------------------------------------------
    | ENSP / IDS / UIT
    | FORMATION → SPÉCIALITÉS
    |--------------------------------------------------------------------------
    */

    public function specialitesFormation(
        string $formationSlug
    ) {
        $formation = Formation::query()
            ->where('slug', $formationSlug)
            ->whereIn('slug', ['ensp', 'ids', 'uit'])
            ->where('is_active', true)
            ->whereHas('teachingCategory', function ($query) {
                $query->where('slug', 'professionnel')
                    ->where('is_active', true);
            })
            ->firstOrFail();

        $specialites = Specialite::query()
            ->where('formation_id', $formation->id)
            ->where('is_active', true)
            ->orderBy('position')
            ->orderBy('name')
            ->get();

        return view(
            'niveau.professionnel.specialites',
            compact(
                'formation',
                'specialites'
            )
        );
    }

    /*
    |--------------------------------------------------------------------------
    | SPÉCIALITÉ → NIVEAUX
    |--------------------------------------------------------------------------
    */

    public function niveauxSpecialite(
        string $formationSlug,
        string $specialiteSlug
    ) {
        $formation = Formation::query()
            ->where('slug', $formationSlug)
            ->whereIn('slug', ['ensp', 'ids', 'uit'])
            ->where('is_active', true)
            ->whereHas('teachingCategory', function ($query) {
                $query->where('slug', 'professionnel')
                    ->where('is_active', true);
            })
            ->firstOrFail();

        $specialite = Specialite::query()
            ->where('slug', $specialiteSlug)
            ->where('formation_id', $formation->id)
            ->where('is_active', true)
            ->firstOrFail();

        $niveaux = Level::query()
            ->where('specialite_id', $specialite->id)
            ->where('is_active', true)
            ->orderBy('order')
            ->orderBy('name')
            ->get();

        return view(
            'niveau.professionnel.niveaux',
            compact(
                'formation',
                'specialite',
                'niveaux'
            )
        );
    }

    /*
    |--------------------------------------------------------------------------
    | SPÉCIALITÉ → NIVEAU → MODULE
    |--------------------------------------------------------------------------
    */

    public function modulesSpecialite(
        string $formationSlug,
        string $specialiteSlug,
        string $niveauSlug
    ) {
        $formation = Formation::query()
            ->where('slug', $formationSlug)
            ->whereIn('slug', ['ensp', 'ids', 'uit'])
            ->where('is_active', true)
            ->whereHas('teachingCategory', function ($query) {
                $query->where('slug', 'professionnel')
                    ->where('is_active', true);
            })
            ->firstOrFail();

        $specialite = Specialite::query()
            ->where('slug', $specialiteSlug)
            ->where('formation_id', $formation->id)
            ->where('is_active', true)
            ->firstOrFail();

        $niveau = Level::query()
            ->where('slug', $niveauSlug)
            ->where('specialite_id', $specialite->id)
            ->where('is_active', true)
            ->firstOrFail();

        $subjects = Subject::query()
            ->where('level_id', $niveau->id)
            ->where('is_active', true)
            ->whereHas('documents', function ($query) use (
                $formation,
                $specialite,
                $niveau
            ) {
                $query->where('status', 'published')
                    ->where('formation_id', $formation->id)
                    ->where('specialite_id', $specialite->id)
                    ->where('level_id', $niveau->id);
            })
            ->orderBy('position')
            ->orderBy('name')
            ->get();

        return view(
            'niveau.professionnel.modules',
            compact(
                'formation',
                'specialite',
                'niveau',
                'subjects'
            )
        );
    }

    /*
    |--------------------------------------------------------------------------
    | SPÉCIALITÉ → NIVEAU → MODULE → TYPES
    |--------------------------------------------------------------------------
    */

    public function typeDocumentsSpecialiteModule(
        string $formationSlug,
        string $specialiteSlug,
        string $niveauSlug,
        string $moduleSlug
    ) {
        $formation = Formation::query()
            ->where('slug', $formationSlug)
            ->whereIn('slug', ['ensp', 'ids', 'uit'])
            ->where('is_active', true)
            ->whereHas('teachingCategory', function ($query) {
                $query->where('slug', 'professionnel')
                    ->where('is_active', true);
            })
            ->firstOrFail();

        $specialite = Specialite::query()
            ->where('slug', $specialiteSlug)
            ->where('formation_id', $formation->id)
            ->where('is_active', true)
            ->firstOrFail();

        $niveau = Level::query()
            ->where('slug', $niveauSlug)
            ->where('specialite_id', $specialite->id)
            ->where('is_active', true)
            ->firstOrFail();

        $module = Subject::query()
            ->where('slug', $moduleSlug)
            ->where('level_id', $niveau->id)
            ->where('is_active', true)
            ->firstOrFail();

        $types = DocumentType::query()
            ->where('is_active', true)
            ->whereHas('documents', function ($query) use (
                $formation,
                $specialite,
                $niveau,
                $module
            ) {
                $query->where('status', 'published')
                    ->where('formation_id', $formation->id)
                    ->where('specialite_id', $specialite->id)
                    ->where('level_id', $niveau->id)
                    ->where('subject_id', $module->id);
            })
            ->orderBy('name')
            ->get();

        return view(
            'niveau.professionnel.type_doc',
            compact(
                'formation',
                'specialite',
                'niveau',
                'module',
                'types'
            )
        );
    }

    /*
    |--------------------------------------------------------------------------
    | SPÉCIALITÉ → MODULE → TYPE → DOCUMENTS
    |--------------------------------------------------------------------------
    */

    public function documentsSpecialiteModule(
        string $formationSlug,
        string $specialiteSlug,
        string $niveauSlug,
        string $moduleSlug,
        string $typeSlug
    ) {
        $formation = Formation::query()
            ->where('slug', $formationSlug)
            ->whereIn('slug', ['ensp', 'ids', 'uit'])
            ->where('is_active', true)
            ->whereHas('teachingCategory', function ($query) {
                $query->where('slug', 'professionnel')
                    ->where('is_active', true);
            })
            ->firstOrFail();

        $specialite = Specialite::query()
            ->where('slug', $specialiteSlug)
            ->where('formation_id', $formation->id)
            ->where('is_active', true)
            ->firstOrFail();

        $niveau = Level::query()
            ->where('slug', $niveauSlug)
            ->where('specialite_id', $specialite->id)
            ->where('is_active', true)
            ->firstOrFail();

        $module = Subject::query()
            ->where('slug', $moduleSlug)
            ->where('level_id', $niveau->id)
            ->where('is_active', true)
            ->firstOrFail();

        $documentType = DocumentType::query()
            ->where('slug', $typeSlug)
            ->where('is_active', true)
            ->firstOrFail();

        $documents = Document::query()
            ->where('status', 'published')
            ->where('formation_id', $formation->id)
            ->where('specialite_id', $specialite->id)
            ->where('level_id', $niveau->id)
            ->where('subject_id', $module->id)
            ->where('document_type_id', $documentType->id)
            ->with([
                'formation',
                'specialite',
                'level',
                'subject',
                'documentType',
                'staff',
            ])
            ->latest('published_at')
            ->paginate(12)
            ->withQueryString();

        return view(
            'niveau.professionnel.documents',
            compact(
                'formation',
                'specialite',
                'niveau',
                'module',
                'documentType',
                'documents'
            )
        );
    }

    /*
    |--------------------------------------------------------------------------
    | SPÉCIALITÉ → MODULE → TYPE → DOCUMENT
    |--------------------------------------------------------------------------
    */

    public function showDocumentSpecialiteModule(
        string $formationSlug,
        string $specialiteSlug,
        string $niveauSlug,
        string $moduleSlug,
        string $typeSlug,
        string $documentSlug
    ) {
        $formation = Formation::query()
            ->where('slug', $formationSlug)
            ->whereIn('slug', ['ensp', 'ids', 'uit'])
            ->where('is_active', true)
            ->whereHas('teachingCategory', function ($query) {
                $query->where('slug', 'professionnel')
                    ->where('is_active', true);
            })
            ->firstOrFail();

        $specialite = Specialite::query()
            ->where('slug', $specialiteSlug)
            ->where('formation_id', $formation->id)
            ->where('is_active', true)
            ->firstOrFail();

        $niveau = Level::query()
            ->where('slug', $niveauSlug)
            ->where('specialite_id', $specialite->id)
            ->where('is_active', true)
            ->firstOrFail();

        $module = Subject::query()
            ->where('slug', $moduleSlug)
            ->where('level_id', $niveau->id)
            ->where('is_active', true)
            ->firstOrFail();

        $documentType = DocumentType::query()
            ->where('slug', $typeSlug)
            ->where('is_active', true)
            ->firstOrFail();

        $document = Document::query()
            ->with([
                'formation',
                'specialite',
                'level',
                'subject',
                'documentType',
                'staff',
            ])
            ->where('slug', $documentSlug)
            ->where('status', 'published')
            ->where('formation_id', $formation->id)
            ->where('specialite_id', $specialite->id)
            ->where('level_id', $niveau->id)
            ->where('subject_id', $module->id)
            ->where('document_type_id', $documentType->id)
            ->firstOrFail();

        $document->increment('views');

        return view(
            'niveau.professionnel.show',
            compact(
                'formation',
                'specialite',
                'niveau',
                'module',
                'documentType',
                'document'
            )
        );
    }

    /*
    |--------------------------------------------------------------------------
    | ENS
    | FORMATION → PROGRAMMES
    |--------------------------------------------------------------------------
    */

    public function programmes()
    {
        $formation = Formation::query()
            ->where('slug', 'ens')
            ->where('is_active', true)
            ->whereHas('teachingCategory', function ($query) {
                $query->where('slug', 'professionnel')
                    ->where('is_active', true);
            })
            ->firstOrFail();

        $programmes = Program::query()
            ->where('formation_id', $formation->id)
            ->where('is_active', true)
            ->orderBy('position')
            ->orderBy('name')
            ->get();

        return view(
            'niveau.professionnel.ens.programmes',
            compact(
                'formation',
                'programmes'
            )
        );
    }

    /*
    |--------------------------------------------------------------------------
    | ENS
    | PROGRAMME → SPÉCIALITÉS
    |--------------------------------------------------------------------------
    */

    public function specialites(string $programmeSlug)
    {
        $programme = Program::query()
            ->where('slug', $programmeSlug)
            ->where('is_active', true)
            ->whereHas('formation', function ($query) {
                $query->where('slug', 'ens')
                    ->where('is_active', true);
            })
            ->firstOrFail();

        $formation = Formation::query()
            ->whereKey($programme->formation_id)
            ->firstOrFail();

        $specialites = Specialite::query()
            ->where('program_id', $programme->id)
            ->where('is_active', true)
            ->orderBy('position')
            ->orderBy('name')
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

    /*
    |--------------------------------------------------------------------------
    | ENS
    | SPÉCIALITÉ → NIVEAUX
    |--------------------------------------------------------------------------
    */

    public function niveauxEns(
        string $programmeSlug,
        string $specialiteSlug
    ) {
        $programme = Program::query()
            ->where('slug', $programmeSlug)
            ->where('is_active', true)
            ->whereHas('formation', function ($query) {
                $query->where('slug', 'ens')
                    ->where('is_active', true);
            })
            ->firstOrFail();

        $formation = Formation::query()
            ->whereKey($programme->formation_id)
            ->firstOrFail();

        $specialite = Specialite::query()
            ->where('slug', $specialiteSlug)
            ->where('program_id', $programme->id)
            ->where('is_active', true)
            ->firstOrFail();

        $niveaux = Level::query()
            ->where('specialite_id', $specialite->id)
            ->where('is_active', true)
            ->orderBy('order')
            ->orderBy('name')
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

    /*
    |--------------------------------------------------------------------------
    | ENS
    | NIVEAU → MODULE
    |--------------------------------------------------------------------------
    */

    public function modulesEns(
        string $programmeSlug,
        string $specialiteSlug,
        string $niveauSlug
    ) {
        $programme = Program::query()
            ->where('slug', $programmeSlug)
            ->where('is_active', true)
            ->whereHas('formation', function ($query) {
                $query->where('slug', 'ens')
                    ->where('is_active', true);
            })
            ->firstOrFail();

        $formation = Formation::query()
            ->whereKey($programme->formation_id)
            ->firstOrFail();

        $specialite = Specialite::query()
            ->where('slug', $specialiteSlug)
            ->where('program_id', $programme->id)
            ->where('is_active', true)
            ->firstOrFail();

        $niveau = Level::query()
            ->where('slug', $niveauSlug)
            ->where('specialite_id', $specialite->id)
            ->where('is_active', true)
            ->firstOrFail();

        $subjects = Subject::query()
            ->where('level_id', $niveau->id)
            ->where('is_active', true)
            ->whereHas('documents', function ($query) use (
                $formation,
                $programme,
                $specialite,
                $niveau
            ) {
                $query->where('status', 'published')
                    ->where('formation_id', $formation->id)
                    ->where('program_id', $programme->id)
                    ->where('specialite_id', $specialite->id)
                    ->where('level_id', $niveau->id);
            })
            ->orderBy('position')
            ->orderBy('name')
            ->get();

        return view(
            'niveau.professionnel.ens.modules',
            compact(
                'formation',
                'programme',
                'specialite',
                'niveau',
                'subjects'
            )
        );
    }

    /*
    |--------------------------------------------------------------------------
    | ENS
    | MODULE → TYPES
    |--------------------------------------------------------------------------
    */

    public function typeDocumentsEnsModule(
        string $programmeSlug,
        string $specialiteSlug,
        string $niveauSlug,
        string $moduleSlug
    ) {
        $programme = Program::query()
            ->where('slug', $programmeSlug)
            ->where('is_active', true)
            ->whereHas('formation', function ($query) {
                $query->where('slug', 'ens')
                    ->where('is_active', true);
            })
            ->firstOrFail();

        $formation = Formation::query()
            ->whereKey($programme->formation_id)
            ->firstOrFail();

        $specialite = Specialite::query()
            ->where('slug', $specialiteSlug)
            ->where('program_id', $programme->id)
            ->where('is_active', true)
            ->firstOrFail();

        $niveau = Level::query()
            ->where('slug', $niveauSlug)
            ->where('specialite_id', $specialite->id)
            ->where('is_active', true)
            ->firstOrFail();

        $module = Subject::query()
            ->where('slug', $moduleSlug)
            ->where('level_id', $niveau->id)
            ->where('is_active', true)
            ->firstOrFail();

        $types = DocumentType::query()
            ->where('is_active', true)
            ->whereHas('documents', function ($query) use (
                $formation,
                $programme,
                $specialite,
                $niveau,
                $module
            ) {
                $query->where('status', 'published')
                    ->where('formation_id', $formation->id)
                    ->where('program_id', $programme->id)
                    ->where('specialite_id', $specialite->id)
                    ->where('level_id', $niveau->id)
                    ->where('subject_id', $module->id);
            })
            ->orderBy('name')
            ->get();

        return view(
            'niveau.professionnel.ens.type_doc',
            compact(
                'formation',
                'programme',
                'specialite',
                'niveau',
                'module',
                'types'
            )
        );
    }

    /*
    |--------------------------------------------------------------------------
    | ENS
    | MODULE → TYPE → DOCUMENTS
    |--------------------------------------------------------------------------
    */

    public function documentsEnsModule(
        string $programmeSlug,
        string $specialiteSlug,
        string $niveauSlug,
        string $moduleSlug,
        string $typeSlug
    ) {
        $programme = Program::query()
            ->where('slug', $programmeSlug)
            ->where('is_active', true)
            ->whereHas('formation', function ($query) {
                $query->where('slug', 'ens')
                    ->where('is_active', true);
            })
            ->firstOrFail();

        $formation = Formation::query()
            ->whereKey($programme->formation_id)
            ->firstOrFail();

        $specialite = Specialite::query()
            ->where('slug', $specialiteSlug)
            ->where('program_id', $programme->id)
            ->where('is_active', true)
            ->firstOrFail();

        $niveau = Level::query()
            ->where('slug', $niveauSlug)
            ->where('specialite_id', $specialite->id)
            ->where('is_active', true)
            ->firstOrFail();

        $module = Subject::query()
            ->where('slug', $moduleSlug)
            ->where('level_id', $niveau->id)
            ->where('is_active', true)
            ->firstOrFail();

        $documentType = DocumentType::query()
            ->where('slug', $typeSlug)
            ->where('is_active', true)
            ->firstOrFail();

        $documents = Document::query()
            ->where('status', 'published')
            ->where('formation_id', $formation->id)
            ->where('program_id', $programme->id)
            ->where('specialite_id', $specialite->id)
            ->where('level_id', $niveau->id)
            ->where('subject_id', $module->id)
            ->where('document_type_id', $documentType->id)
            ->with([
                'formation',
                'program',
                'specialite',
                'level',
                'subject',
                'documentType',
                'staff',
            ])
            ->latest('published_at')
            ->paginate(12)
            ->withQueryString();

        return view(
            'niveau.professionnel.ens.documents',
            compact(
                'formation',
                'programme',
                'specialite',
                'niveau',
                'module',
                'documentType',
                'documents'
            )
        );
    }

    /*
    |--------------------------------------------------------------------------
    | ENS
    | MODULE → TYPE → DOCUMENT
    |--------------------------------------------------------------------------
    */

    public function showDocumentEnsModule(
        string $programmeSlug,
        string $specialiteSlug,
        string $niveauSlug,
        string $moduleSlug,
        string $typeSlug,
        string $documentSlug
    ) {
        $formation = Formation::query()
            ->where('slug', 'ens')
            ->where('is_active', true)
            ->whereHas('teachingCategory', function ($query) {
                $query->where('slug', 'professionnel')
                    ->where('is_active', true);
            })
            ->firstOrFail();

        $programme = Program::query()
            ->where('slug', $programmeSlug)
            ->where('formation_id', $formation->id)
            ->where('is_active', true)
            ->firstOrFail();

        $specialite = Specialite::query()
            ->where('slug', $specialiteSlug)
            ->where('program_id', $programme->id)
            ->where('is_active', true)
            ->firstOrFail();

        $niveau = Level::query()
            ->where('slug', $niveauSlug)
            ->where('specialite_id', $specialite->id)
            ->where('is_active', true)
            ->firstOrFail();

        $module = Subject::query()
            ->where('slug', $moduleSlug)
            ->where('level_id', $niveau->id)
            ->where('is_active', true)
            ->firstOrFail();

        $documentType = DocumentType::query()
            ->where('slug', $typeSlug)
            ->where('is_active', true)
            ->firstOrFail();

        $document = Document::query()
            ->with([
                'formation',
                'program',
                'specialite',
                'level',
                'subject',
                'documentType',
                'staff',
            ])
            ->where('slug', $documentSlug)
            ->where('status', 'published')
            ->where('formation_id', $formation->id)
            ->where('program_id', $programme->id)
            ->where('specialite_id', $specialite->id)
            ->where('level_id', $niveau->id)
            ->where('subject_id', $module->id)
            ->where('document_type_id', $documentType->id)
            ->firstOrFail();

        $document->increment('views');

        return view(
            'niveau.professionnel.ens.show',
            compact(
                'formation',
                'programme',
                'specialite',
                'niveau',
                'module',
                'documentType',
                'document'
            )
        );
    }
}