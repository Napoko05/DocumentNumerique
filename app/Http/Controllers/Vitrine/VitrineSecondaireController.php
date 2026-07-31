<?php

namespace App\Http\Controllers\Vitrine;

use App\Http\Controllers\Controller;
use App\Models\Document;
use App\Models\DocumentType;
use App\Models\Formation;
use App\Models\Level;
use App\Models\Subject;

class VitrineSecondaireController extends Controller
{
    protected function formation(): Formation
    {
        return Formation::where('slug', 'secondaire-general')
            ->where('is_active', true)
            ->firstOrFail();
    }

    public function classes()
    {
        $formation = $this->formation();

        $classes = Level::where('formation_id', $formation->id)
            ->where('is_active', true)
            ->orderBy('order')
            ->get();

        foreach ($classes as $classe) {
            $classe->documents_count = Document::where('formation_id', $formation->id)
                ->where('level_id', $classe->id)
                ->where('status', 'published')
                ->count();
        }

        return view(
            'niveau.secondaire.classes',
            compact('formation', 'classes')
        );
    }

    public function matieres(string $classeSlug)
    {
        $formation = $this->formation();

        $classe = Level::where('formation_id', $formation->id)
            ->where('slug', $classeSlug)
            ->where('is_active', true)
            ->firstOrFail();

        $matieres = Subject::where('level_id', $classe->id)
            ->where('is_active', true)
            ->orderBy('name')
            ->get();

        foreach ($matieres as $matiere) {
            $matiere->documents_count = Document::where('formation_id', $formation->id)
                ->where('level_id', $classe->id)
                ->where('subject_id', $matiere->id)
                ->where('status', 'published')
                ->count();
        }

        return view(
            'niveau.secondaire.matieres',
            compact(
                'formation',
                'classe',
                'matieres'
            )
        );
    }

    public function typeDocuments(
        string $classeSlug,
        string $matiereSlug
    ) {
        $formation = $this->formation();

        $classe = Level::where('formation_id', $formation->id)
            ->where('slug', $classeSlug)
            ->where('is_active', true)
            ->firstOrFail();

        $matiere = Subject::where('level_id', $classe->id)
            ->where('slug', $matiereSlug)
            ->where('is_active', true)
            ->firstOrFail();

        $types = DocumentType::where('is_active', true)
            ->orderBy('name')
            ->get();

        foreach ($types as $type) {
            $type->documents_count = Document::where('formation_id', $formation->id)
                ->where('level_id', $classe->id)
                ->where('subject_id', $matiere->id)
                ->where('document_type_id', $type->id)
                ->where('status', 'published')
                ->count();
        }

        return view(
            'niveau.secondaire.type_doc',
            compact(
                'formation',
                'classe',
                'matiere',
                'types'
            )
        );
    }

    public function documents(
        string $classeSlug,
        string $matiereSlug,
        string $typeSlug
    ) {
        $formation = $this->formation();

        $classe = Level::where('formation_id', $formation->id)
            ->where('slug', $classeSlug)
            ->where('is_active', true)
            ->firstOrFail();

        $matiere = Subject::where('level_id', $classe->id)
            ->where('slug', $matiereSlug)
            ->where('is_active', true)
            ->firstOrFail();

        $type = DocumentType::where('slug', $typeSlug)
            ->where('is_active', true)
            ->firstOrFail();

        $documents = Document::with([
                'staff',
                'formation',
                'level',
                'subject',
                'documentType',
                'ratings'
            ])
            ->where('formation_id', $formation->id)
            ->where('level_id', $classe->id)
            ->where('subject_id', $matiere->id)
            ->where('document_type_id', $type->id)
            ->where('status', 'published')
            ->latest()
            ->paginate(12);

        return view(
            'niveau.secondaire.documents',
            compact(
                'formation',
                'classe',
                'matiere',
                'type',
                'documents'
            )
        );
    }
}