<?php

namespace App\Http\Controllers\Vitrine;

use App\Http\Controllers\Controller;
use App\Models\Document;
use App\Models\Formation;
use App\Models\Level;
use App\Models\Subject;
use App\Models\TeachingCategory;
use Illuminate\Http\Request;

class VitrineSecondaireController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | PAGE D'ACCUEIL SECONDAIRE
    |--------------------------------------------------------------------------
    */

    public function index()
    {
        $category = TeachingCategory::query()
            ->whereIn('slug', ['secondaire', 'secondary'])
            ->where('is_active', true)
            ->firstOrFail();

        $formations = Formation::query()
            ->where('teaching_category_id', $category->id)
            ->where('is_active', true)
            ->withCount([
                'levels' => function ($query) {
                    $query->where('is_active', true)
                        ->whereNull('filiere_id')
                        ->whereNull('specialite_id');
                }
            ])
            ->orderBy('position')
            ->orderBy('name')
            ->get();

        return view(
            'niveau.secondaire.index',
            compact(
                'category',
                'formations'
            )
        );
    }

    /*
    |--------------------------------------------------------------------------
    | FORMATION
    |--------------------------------------------------------------------------
    | Secondaire
    |
    | Formation
    |     ↓
    | Niveau
    |--------------------------------------------------------------------------
    */

    public function formation(string $formation)
    {
        $category = TeachingCategory::query()
            ->whereIn('slug', ['secondaire', 'secondary'])
            ->where('is_active', true)
            ->firstOrFail();

        $formationModel = Formation::query()
            ->where('slug', $formation)
            ->where('teaching_category_id', $category->id)
            ->where('is_active', true)
            ->firstOrFail();

        $levels = Level::query()
            ->where('formation_id', $formationModel->id)
            ->whereNull('filiere_id')
            ->whereNull('specialite_id')
            ->where('is_active', true)
            ->withCount([
                'subjects' => function ($query) {
                    $query->where('is_active', true);
                }
            ])
            ->orderBy('order')
            ->orderBy('name')
            ->get();

        return view(
            'niveau.secondaire.formation',
            compact(
                'category',
                'formationModel',
                'levels'
            )
        );
    }

    /*
    |--------------------------------------------------------------------------
    | NIVEAU
    |--------------------------------------------------------------------------
    | Formation
    |     ↓
    | Niveau
    |     ↓
    | Matière / Module
    |--------------------------------------------------------------------------
    */

    public function niveau(
        string $formation,
        string $niveau
    ) {
        $category = TeachingCategory::query()
            ->whereIn('slug', ['secondaire', 'secondary'])
            ->where('is_active', true)
            ->firstOrFail();

        $formationModel = Formation::query()
            ->where('slug', $formation)
            ->where('teaching_category_id', $category->id)
            ->where('is_active', true)
            ->firstOrFail();

        $level = Level::query()
            ->where('slug', $niveau)
            ->where('formation_id', $formationModel->id)
            ->whereNull('filiere_id')
            ->whereNull('specialite_id')
            ->where('is_active', true)
            ->firstOrFail();

        $subjects = Subject::query()
            ->where('level_id', $level->id)
            ->where('is_active', true)
            ->withCount([
                'documents' => function ($query) {
                    $query->where('status', 'published');
                }
            ])
            ->orderBy('position')
            ->orderBy('name')
            ->get();

        return view(
            'niveau.secondaire.classes',
            compact(
                'category',
                'formationModel',
                'level',
                'subjects'
            )
        );
    }

    /*
    |--------------------------------------------------------------------------
    | MATIÈRE / MODULE
    |--------------------------------------------------------------------------
    | Formation
    |     ↓
    | Niveau
    |     ↓
    | Matière
    |     ↓
    | Documents
    |--------------------------------------------------------------------------
    */

    public function subject(
        string $formation,
        string $niveau,
        string $matiere
    ) {
        $category = TeachingCategory::query()
            ->whereIn('slug', ['secondaire', 'secondary'])
            ->where('is_active', true)
            ->firstOrFail();

        $formationModel = Formation::query()
            ->where('slug', $formation)
            ->where('teaching_category_id', $category->id)
            ->where('is_active', true)
            ->firstOrFail();

        $level = Level::query()
            ->where('slug', $niveau)
            ->where('formation_id', $formationModel->id)
            ->whereNull('filiere_id')
            ->whereNull('specialite_id')
            ->where('is_active', true)
            ->firstOrFail();

        $subject = Subject::query()
            ->where('slug', $matiere)
            ->where('level_id', $level->id)
            ->where('is_active', true)
            ->firstOrFail();

        $documents = Document::query()
            ->where('teaching_category_id', $category->id)
            ->where('formation_id', $formationModel->id)
            ->where('level_id', $level->id)
            ->where('subject_id', $subject->id)
            ->where('status', 'published')
            ->with([
                'formation',
                'level',
                'subject',
                'documentType',
                'tags',
            ])
            ->latest('published_at')
            ->latest('id')
            ->get();

        return view(
            'niveau.secondaire.documents',
            compact(
                'category',
                'formationModel',
                'level',
                'subject',
                'documents'
            )
        );
    }

    /*
    |--------------------------------------------------------------------------
    | DOCUMENT
    |--------------------------------------------------------------------------
    | URL finale :
    |
    | /secondaire/{formation}/{niveau}/{matiere}/document/{slug}
    |--------------------------------------------------------------------------
    */

    public function document(
        string $formation,
        string $niveau,
        string $matiere,
        string $slug
    ) {
        $category = TeachingCategory::query()
            ->whereIn('slug', ['secondaire', 'secondary'])
            ->where('is_active', true)
            ->firstOrFail();

        $formationModel = Formation::query()
            ->where('slug', $formation)
            ->where('teaching_category_id', $category->id)
            ->where('is_active', true)
            ->firstOrFail();

        $level = Level::query()
            ->where('slug', $niveau)
            ->where('formation_id', $formationModel->id)
            ->whereNull('filiere_id')
            ->whereNull('specialite_id')
            ->where('is_active', true)
            ->firstOrFail();

        $subject = Subject::query()
            ->where('slug', $matiere)
            ->where('level_id', $level->id)
            ->where('is_active', true)
            ->firstOrFail();

        $document = Document::query()
            ->where('slug', $slug)
            ->where('teaching_category_id', $category->id)
            ->where('formation_id', $formationModel->id)
            ->whereNull('academic_domain_id')
            ->whereNull('filiere_id')
            ->whereNull('program_id')
            ->whereNull('specialite_id')
            ->where('level_id', $level->id)
            ->where('subject_id', $subject->id)
            ->where('status', 'published')
            ->with([
                'formation',
                'level',
                'subject',
                'documentType',
                'tags',
            ])
            ->firstOrFail();

        return view(
            'niveau.secondaire.show',
            compact(
                'category',
                'formationModel',
                'level',
                'subject',
                'document'
            )
        );
    }
}