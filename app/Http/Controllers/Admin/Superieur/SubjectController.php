<?php

namespace App\Http\Controllers\Admin\Superieur;

use App\Http\Controllers\Controller;
use App\Models\AcademicDomain;
use App\Models\Level;
use App\Models\Subject;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class SubjectController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | LISTE DES MODULES
    |--------------------------------------------------------------------------
    |
    | Structure :
    |
    | Domaine
    |    ↓
    | Filière
    |    ↓
    | Niveau
    |    ↓
    | Module
    |
    */

    public function index()
    {
        $domaines = AcademicDomain::with([
            'filieres.levels.subjects' => function ($query) {
                $query->orderBy('order');
            }
        ])
        ->where(
            'is_active',
            true
        )
        ->orderBy('position')
        ->get();

        return view(
            'admin.superieur.modules.index',
            compact('domaines')
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
            'filiere.academicDomain',
            function ($query) {

                $query->where(
                    'is_active',
                    true
                );

            }
        )
        ->where(
            'is_active',
            true
        )
        ->with([
            'filiere.academicDomain'
        ])
        ->orderBy('name')
        ->get();

        return view(
            'admin.superieur.modules.create',
            compact('levels')
        );
    }


    /*
    |--------------------------------------------------------------------------
    | ENREGISTRER UN MODULE
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

            'order' => [
                'nullable',
                'integer',
                'min:0',
            ],

        ]);


        /*
        |--------------------------------------------------------------------------
        | GÉNÉRATION DU SLUG
        |--------------------------------------------------------------------------
        */

        $slug = Str::slug(
            $validated['name']
        );

        $originalSlug = $slug;

        $numero = 2;


        /*
        |--------------------------------------------------------------------------
        | ÉVITER LES DOUBLONS DANS LE MÊME NIVEAU
        |--------------------------------------------------------------------------
        */

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
            $slug = $originalSlug
                . '-'
                . $numero;

            $numero++;
        }


        /*
        |--------------------------------------------------------------------------
        | CRÉATION
        |--------------------------------------------------------------------------
        */

        Subject::create([

            'level_id' =>
                $validated['level_id'],

            'name' =>
                $validated['name'],

            'slug' =>
                $slug,

            'order' =>
                $validated['order'] ?? 0,

            'is_active' =>
                true,

        ]);


        return redirect()
            ->route(
                'admin.superieur.modules.index'
            )
            ->with(
                'success',
                'Module ajouté avec succès.'
            );
    }


    /*
    |--------------------------------------------------------------------------
    | FORMULAIRE DE MODIFICATION
    |--------------------------------------------------------------------------
    */

    public function edit(Subject $subject)
    {
        $levels = Level::whereHas(
            'filiere.academicDomain',
            function ($query) {

                $query->where(
                    'is_active',
                    true
                );

            }
        )
        ->where(
            'is_active',
            true
        )
        ->with([
            'filiere.academicDomain'
        ])
        ->orderBy('name')
        ->get();

        return view(
            'admin.superieur.modules.edit',
            compact(
                'subject',
                'levels'
            )
        );
    }


    /*
    |--------------------------------------------------------------------------
    | MODIFIER UN MODULE
    |--------------------------------------------------------------------------
    */

    public function update(
        Request $request,
        Subject $subject
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

            'order' => [
                'nullable',
                'integer',
                'min:0',
            ],

            'is_active' => [
                'required',
                'boolean',
            ],

        ]);


        /*
        |--------------------------------------------------------------------------
        | GÉNÉRATION DU SLUG
        |--------------------------------------------------------------------------
        */

        $slug = Str::slug(
            $validated['name']
        );

        $originalSlug = $slug;

        $numero = 2;


        /*
        |--------------------------------------------------------------------------
        | ÉVITER LES DOUBLONS
        |--------------------------------------------------------------------------
        */

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
                $subject->id
            )
            ->exists()
        ) {
            $slug = $originalSlug
                . '-'
                . $numero;

            $numero++;
        }


        /*
        |--------------------------------------------------------------------------
        | MISE À JOUR
        |--------------------------------------------------------------------------
        */

        $subject->update([

            'level_id' =>
                $validated['level_id'],

            'name' =>
                $validated['name'],

            'slug' =>
                $slug,

            'order' =>
                $validated['order'] ?? 0,

            'is_active' =>
                $validated['is_active'],

        ]);


        return redirect()
            ->route(
                'admin.superieur.modules.index'
            )
            ->with(
                'success',
                'Module modifié avec succès.'
            );
    }


    /*
    |--------------------------------------------------------------------------
    | ACTIVER / DÉSACTIVER
    |--------------------------------------------------------------------------
    */

    public function toggle(Subject $subject)
    {
        $subject->update([

            'is_active' =>
                ! $subject->is_active,

        ]);


        return back()
            ->with(
                'success',
                $subject->is_active
                    ? 'Module activé.'
                    : 'Module désactivé.'
            );
    }
    /*
    |--------------------------------------------------------------------------
    | SUPPRIMER
    |--------------------------------------------------------------------------
    */

    public function destroy(Subject $subject)
    {
        /*
        |--------------------------------------------------------------------------
        | VÉRIFICATION DES DOCUMENTS
        |--------------------------------------------------------------------------
        */

        if (
            $subject
                ->documents()
                ->exists()
        ) {
            return back()
                ->with(
                    'error',
                    'Impossible de supprimer ce module : il possède des documents.'
                );
        }

        $subject->delete();


        return back()
            ->with(
                'success',
                'Module supprimé avec succès.'
            );
    }
}
