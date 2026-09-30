<?php

namespace App\Http\Controllers\Admin\Superieur;

use App\Http\Controllers\Controller;
use App\Models\AcademicDomain;
use App\Models\Filiere;
use App\Models\Level;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class SuperieurLevelController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | LISTE DES NIVEAUX
    |--------------------------------------------------------------------------
    */

    public function index(Request $request)
    {
        $search = trim($request->input('search', ''));

        $levels = Level::query()
            ->higher()
            ->with([
                'filiere',
                'filiere.academicDomain',
            ])
            ->withCount('subjects')
            ->when($search !== '', function ($query) use ($search) {

                $query->where(function ($q) use ($search) {

                    $q->where('name', 'like', '%' . $search . '%')

                        ->orWhere('slug', 'like', '%' . $search . '%')

                        ->orWhereHas('filiere', function ($filiere) use ($search) {

                            $filiere->where(
                                'name',
                                'like',
                                '%' . $search . '%'
                            );

                        })

                        ->orWhereHas(
                            'filiere.academicDomain',
                            function ($domain) use ($search) {

                                $domain->where(
                                    'name',
                                    'like',
                                    '%' . $search . '%'
                                );

                            }
                        );
                });
            })
            ->orderBy('order')
            ->orderBy('name')
            ->paginate(20)
            ->withQueryString();

        return view(
            'admin.superieur.levels.index',
            compact('levels', 'search')
        );
    }


    /*
    |--------------------------------------------------------------------------
    | FORMULAIRE AJOUT
    |--------------------------------------------------------------------------
    */

    public function create()
    {
        /*
        |----------------------------------------------------------------------
        | On charge les domaines avec leurs filières
        |----------------------------------------------------------------------
        */

        $domains = AcademicDomain::query()
            ->with([
                'filieres' => function ($query) {
                    $query
                        ->where('is_active', true)
                        ->orderBy('name');
                }
            ])
            ->orderBy('name')
            ->get();

        return view(
            'admin.superieur.levels.create',
            compact('domains')
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
            'academic_domain_id' => [
                'required',
                'exists:academic_domains,id',
            ],

            'filiere_id' => [
                'required',
                'exists:filieres,id',
            ],

            'name' => [
                'required',
                'string',
                'max:255',
            ],

            'order' => [
                'required',
                'integer',
                'min:1',
                'max:255',
            ],

            'is_active' => [
                'nullable',
                'boolean',
            ],
        ], [
            'academic_domain_id.required' =>
                'Veuillez sélectionner un domaine.',

            'academic_domain_id.exists' =>
                'Le domaine sélectionné est invalide.',

            'filiere_id.required' =>
                'Veuillez sélectionner une filière.',

            'filiere_id.exists' =>
                'La filière sélectionnée est invalide.',

            'name.required' =>
                'Le nom du niveau est obligatoire.',

            'order.required' =>
                'L’ordre du niveau est obligatoire.',

            'order.integer' =>
                'L’ordre doit être un nombre entier.',

            'order.min' =>
                'L’ordre doit être supérieur ou égal à 1.',
        ]);


        /*
        |----------------------------------------------------------------------
        | Vérifier que la filière appartient bien au domaine sélectionné
        |----------------------------------------------------------------------
        */

        $filiere = Filiere::query()
            ->where('id', $validated['filiere_id'])
            ->where(
                'academic_domain_id',
                $validated['academic_domain_id']
            )
            ->first();

        if (!$filiere) {
            return back()
                ->withInput()
                ->withErrors([
                    'filiere_id' =>
                        'La filière sélectionnée n’appartient pas au domaine choisi.',
                ]);
        }


        /*
        |----------------------------------------------------------------------
        | Génération du slug
        |----------------------------------------------------------------------
        */

        $slug = Str::slug($validated['name']);


        /*
        |----------------------------------------------------------------------
        | Vérifier les doublons dans la filière
        |----------------------------------------------------------------------
        */

        $exists = Level::query()
            ->where(
                'filiere_id',
                $validated['filiere_id']
            )
            ->where(
                'slug',
                $slug
            )
            ->exists();

        if ($exists) {
            return back()
                ->withInput()
                ->withErrors([
                    'name' =>
                        'Ce niveau existe déjà dans cette filière.',
                ]);
        }


        /*
        |----------------------------------------------------------------------
        | Création
        |----------------------------------------------------------------------
        */

        Level::create([
            'formation_id' => null,

            'filiere_id' =>
                $validated['filiere_id'],

            'section' => null,

            'specialite_id' => null,

            'name' =>
                $validated['name'],

            'slug' =>
                $slug,

            'order' =>
                $validated['order'],

            'is_active' =>
                $request->boolean('is_active'),
        ]);


        return redirect()
            ->route('admin.superieur.levels.index')
            ->with(
                'success',
                'Le niveau a été ajouté avec succès.'
            );
    }


    /*
    |--------------------------------------------------------------------------
    | FORMULAIRE MODIFICATION
    |--------------------------------------------------------------------------
    */

    public function edit(Level $level)
    {
        abort_unless(
            $level->isHigher(),
            404
        );


        $domains = AcademicDomain::query()
            ->with([
                'filieres' => function ($query) {
                    $query
                        ->where('is_active', true)
                        ->orderBy('name');
                }
            ])
            ->orderBy('name')
            ->get();


        return view(
            'admin.superieur.levels.edit',
            compact(
                'level',
                'domains'
            )
        );
    }


    /*
    |--------------------------------------------------------------------------
    | MODIFICATION
    |--------------------------------------------------------------------------
    */

    public function update(
        Request $request,
        Level $level
    ) {
        abort_unless(
            $level->isHigher(),
            404
        );


        $validated = $request->validate([
            'academic_domain_id' => [
                'required',
                'exists:academic_domains,id',
            ],

            'filiere_id' => [
                'required',
                'exists:filieres,id',
            ],

            'name' => [
                'required',
                'string',
                'max:255',
            ],

            'order' => [
                'required',
                'integer',
                'min:1',
                'max:255',
            ],

            'is_active' => [
                'nullable',
                'boolean',
            ],
        ], [
            'academic_domain_id.required' =>
                'Veuillez sélectionner un domaine.',

            'filiere_id.required' =>
                'Veuillez sélectionner une filière.',

            'name.required' =>
                'Le nom du niveau est obligatoire.',

            'order.required' =>
                'L’ordre du niveau est obligatoire.',
        ]);


        /*
        |----------------------------------------------------------------------
        | Vérification Domaine → Filière
        |----------------------------------------------------------------------
        */

        $filiere = Filiere::query()
            ->where('id', $validated['filiere_id'])
            ->where(
                'academic_domain_id',
                $validated['academic_domain_id']
            )
            ->first();

        if (!$filiere) {
            return back()
                ->withInput()
                ->withErrors([
                    'filiere_id' =>
                        'La filière sélectionnée n’appartient pas au domaine choisi.',
                ]);
        }


        /*
        |----------------------------------------------------------------------
        | Nouveau slug
        |----------------------------------------------------------------------
        */

        $slug = Str::slug(
            $validated['name']
        );


        /*
        |----------------------------------------------------------------------
        | Vérification doublon
        |---------------------------------------------------------------------- 
        */

        $exists = Level::query()
            ->where(
                'filiere_id',
                $validated['filiere_id']
            )
            ->where(
                'slug',
                $slug
            )
            ->where(
                'id',
                '!=',
                $level->id
            )
            ->exists();

        if ($exists) {
            return back()
                ->withInput()
                ->withErrors([
                    'name' =>
                        'Ce niveau existe déjà dans cette filière.',
                ]);
        }


        /*
        |----------------------------------------------------------------------
        | Mise à jour
        |---------------------------------------------------------------------- 
        */

        $level->update([
            'formation_id' => null,

            'filiere_id' =>
                $validated['filiere_id'],

            'section' => null,

            'specialite_id' => null,

            'name' =>
                $validated['name'],

            'slug' =>
                $slug,

            'order' =>
                $validated['order'],

            'is_active' =>
                $request->boolean('is_active'),
        ]);


        return redirect()
            ->route('admin.superieur.levels.index')
            ->with(
                'success',
                'Le niveau a été modifié avec succès.'
            );
    }


    /*
    |--------------------------------------------------------------------------
    | SUPPRESSION
    |--------------------------------------------------------------------------
    */

    public function destroy(Level $level)
    {
        abort_unless(
            $level->isHigher(),
            404
        );


        if ($level->subjects()->exists()) {

            return back()->with(
                'error',
                'Impossible de supprimer ce niveau car il contient encore des modules.'
            );
        }


        $level->delete();


        return redirect()
            ->route('admin.superieur.levels.index')
            ->with(
                'success',
                'Le niveau a été supprimé avec succès.'
            );
    }
}
