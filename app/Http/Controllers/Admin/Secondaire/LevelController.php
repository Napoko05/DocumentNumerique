<?php

namespace App\Http\Controllers\Admin\Secondaire;

use App\Http\Controllers\Controller;
use App\Models\Formation;
use App\Models\Level;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class LevelController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | LISTE DES CLASSES
    |--------------------------------------------------------------------------
    */

    public function index()
    {
        $formations = Formation::whereIn('slug', [
            'secondaire-general',
            'secondaire-technique',
        ])
        ->where('is_active', true)
        ->with([
            'levels' => function ($query) {
                $query
                    ->orderBy('order')
                    ->orderBy('name');
            }
        ])
        ->get();

        return view(
            'admin.secondaire.classes.index',
            compact('formations')
        );
    }


    /*
    |--------------------------------------------------------------------------
    | FORMULAIRE DE CRÉATION
    |--------------------------------------------------------------------------
    */

    public function create()
    {
        $formations = Formation::whereIn('slug', [
            'secondaire-general',
            'secondaire-technique',
        ])
        ->where('is_active', true)
        ->get();

        return view(
            'admin.secondaire.classes.create',
            compact('formations')
        );
    }


    /*
    |--------------------------------------------------------------------------
    | ENREGISTREMENT
    |--------------------------------------------------------------------------
    */

    public function store(Request $request)
    {
        $validated = $request->validate([
            'formation_id' => [
                'required',
                'exists:formations,id',
            ],

            'section' => [
                'required',
                'in:general,technique',
            ],

            'name' => [
                'required',
                'string',
                'max:100',
            ],

            'order' => [
                'nullable',
                'integer',
                'min:0',
            ],
        ]);


        Level::create([
            'formation_id' => $validated['formation_id'],

            'section' => $validated['section'],

            'name' => $validated['name'],

            'slug' => Str::slug($validated['name']),

            'order' => $validated['order'] ?? 0,

            'is_active' => true,
        ]);


        return redirect()
            ->route('admin.secondaire.classes.index')
            ->with(
                'success',
                'Classe créée avec succès.'
            );
    }


    /*
    |--------------------------------------------------------------------------
    | FORMULAIRE DE MODIFICATION
    |--------------------------------------------------------------------------
    */

    public function edit(Level $class)
    {
        $formations = Formation::whereIn('slug', [
            'secondaire-general',
            'secondaire-technique',
        ])
        ->where('is_active', true)
        ->get();


        return view(
            'admin.secondaire.classes.edit',
            [
                'classe' => $class,
                'formations' => $formations,
            ]
        );
    }


    /*
    |--------------------------------------------------------------------------
    | MODIFICATION
    |--------------------------------------------------------------------------
    */

    public function update(
        Request $request,
        Level $class
    ) {
        $validated = $request->validate([
            'formation_id' => [
                'required',
                'exists:formations,id',
            ],

            'section' => [
                'required',
                'in:general,technique',
            ],

            'name' => [
                'required',
                'string',
                'max:100',
            ],

            'order' => [
                'nullable',
                'integer',
                'min:0',
            ],
        ]);


        $class->update([
            'formation_id' => $validated['formation_id'],

            'section' => $validated['section'],

            'name' => $validated['name'],

            'slug' => Str::slug($validated['name']),

            'order' => $validated['order'] ?? 0,
        ]);


        return redirect()
            ->route('admin.secondaire.classes.index')
            ->with(
                'success',
                'Classe modifiée avec succès.'
            );
    }


    /*
    |--------------------------------------------------------------------------
    | ACTIVER / DÉSACTIVER
    |--------------------------------------------------------------------------
    */

    public function toggle(Level $class)
    {
        $class->update([
            'is_active' => ! $class->is_active,
        ]);


        return back()
            ->with(
                'success',
                'Statut de la classe modifié.'
            );
    }


    /*
    |--------------------------------------------------------------------------
    | SUPPRESSION
    |--------------------------------------------------------------------------
    */

    public function destroy(Level $class)
    {
        if ($class->subjects()->exists()) {

            return back()
                ->with(
                    'error',
                    'Cette classe possède des matières et ne peut pas être supprimée.'
                );
        }


        $class->delete();


        return back()
            ->with(
                'success',
                'Classe supprimée avec succès.'
            );
    }
}
