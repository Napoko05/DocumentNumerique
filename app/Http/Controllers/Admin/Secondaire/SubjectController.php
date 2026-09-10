<?php

namespace App\Http\Controllers\Admin\Secondaire;

use App\Http\Controllers\Controller;
use App\Models\Formation;
use App\Models\Level;
use App\Models\Subject;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class SubjectController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | LISTE DES MATIÈRES
    |--------------------------------------------------------------------------
    */

    public function index()
    {
        $formationGeneral = Formation::where(
            'slug',
            'secondaire-general'
        )->first();

        $formationTechnique = Formation::where(
            'slug',
            'secondaire-technique'
        )->first();

        $formationIds = array_filter([
            $formationGeneral?->id,
            $formationTechnique?->id,
        ]);

        $levels = Level::whereIn(
            'formation_id',
            $formationIds
        )
            ->where('is_active', true)
            ->with([
                'subjects' => function ($query) {
                    $query
                        ->where('is_active', true)
                        ->orderBy('position');
                }
            ])
            ->orderBy('order')
            ->get();

        return view(
            'admin.secondaire.matieres.index',
            compact('levels')
        );
    }

    /*
    |--------------------------------------------------------------------------
    | FORMULAIRE D'AJOUT
    |--------------------------------------------------------------------------
    */

    public function create()
    {
        $levels = Level::whereHas(
            'formation',
            function ($query) {
                $query->whereIn('slug', [
                    'secondaire-general',
                    'secondaire-technique',
                ]);
            }
        )
            ->where('is_active', true)
            ->orderBy('order')
            ->get();

        return view(
            'admin.secondaire.matieres.create',
            compact('levels')
        );
    }

    /*
    |--------------------------------------------------------------------------
    | ENREGISTRER UNE MATIÈRE
    |--------------------------------------------------------------------------
    */

    public function store(Request $request)
    {
        $validated = $request->validate([

            'level_id' => [
                'required',
                'exists:levels,id',
            ],

            'name' => [
                'required',
                'string',
                'max:150',
            ],

            'position' => [
                'nullable',
                'integer',
                'min:0',
            ],

        ]);

        $slug = Str::slug(
            $validated['name']
        );

        $originalSlug = $slug;
        $numero = 2;

        while (
            Subject::where(
                'level_id',
                $validated['level_id']
            )
                ->where(
                    'slug',
                    $slug
                )
                ->exists()
        ) {
            $slug = $originalSlug . '-' . $numero;

            $numero++;
        }

        Subject::create([

            'level_id' =>
                $validated['level_id'],

            'name' =>
                $validated['name'],

            'slug' =>
                $slug,

            'position' =>
                $validated['position'] ?? 0,

            'is_active' =>
                true,

        ]);

        return redirect()
            ->route(
                'admin.secondaire.matieres.index'
            )
            ->with(
                'success',
                'Matière ajoutée avec succès.'
            );
    }

    /*
    |--------------------------------------------------------------------------
    | FORMULAIRE DE MODIFICATION
    |--------------------------------------------------------------------------
    */

    public function edit(
        Subject $matiere
    ) {
        $levels = Level::whereHas(
            'formation',
            function ($query) {
                $query->whereIn('slug', [
                    'secondaire-general',
                    'secondaire-technique',
                ]);
            }
        )
            ->where('is_active', true)
            ->orderBy('order')
            ->get();

        return view(
            'admin.secondaire.matieres.edit',
            compact(
                'matiere',
                'levels'
            )
        );
    }

    /*
    |--------------------------------------------------------------------------
    | MODIFIER UNE MATIÈRE
    |--------------------------------------------------------------------------
    */

    public function update(
        Request $request,
        Subject $matiere
    ) {
        $validated = $request->validate([

            'level_id' => [
                'required',
                'exists:levels,id',
            ],

            'name' => [
                'required',
                'string',
                'max:150',
            ],

            'position' => [
                'nullable',
                'integer',
                'min:0',
            ],

        ]);

        $slug = Str::slug(
            $validated['name']
        );

        $originalSlug = $slug;
        $numero = 2;

        while (
            Subject::where(
                'level_id',
                $validated['level_id']
            )
                ->where(
                    'slug',
                    $slug
                )
                ->where(
                    'id',
                    '!=',
                    $matiere->id
                )
                ->exists()
        ) {
            $slug = $originalSlug . '-' . $numero;

            $numero++;
        }

        $matiere->update([

            'level_id' =>
                $validated['level_id'],

            'name' =>
                $validated['name'],

            'slug' =>
                $slug,

            'position' =>
                $validated['position'] ?? 0,

        ]);

        return redirect()
            ->route(
                'admin.secondaire.matieres.index'
            )
            ->with(
                'success',
                'Matière modifiée avec succès.'
            );
    }

    /*
    |--------------------------------------------------------------------------
    | ACTIVER / DÉSACTIVER
    |--------------------------------------------------------------------------
    */

    public function toggle(
        Subject $matiere
    ) {
        $matiere->update([

            'is_active' =>
                ! $matiere->is_active,

        ]);

        return back()
            ->with(
                'success',
                $matiere->is_active
                    ? 'Matière activée.'
                    : 'Matière désactivée.'
            );
    }

    /*
    |--------------------------------------------------------------------------
    | SUPPRIMER
    |--------------------------------------------------------------------------
    */

    public function destroy(
        Subject $matiere
    ) {
        if (
            $matiere->documents()->exists()
        ) {
            return back()
                ->with(
                    'error',
                    'Impossible de supprimer cette matière : elle possède des documents.'
                );
        }

        $matiere->delete();

        return back()
            ->with(
                'success',
                'Matière supprimée avec succès.'
            );
    }
}