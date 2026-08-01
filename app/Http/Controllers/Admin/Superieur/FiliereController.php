<?php

namespace App\Http\Controllers\Admin\Superieur;

use App\Http\Controllers\Controller;
use App\Models\AcademicDomain;
use App\Models\Filiere;
use Illuminate\Http\Request;
use Illuminate\Support\Str;


class FiliereController extends Controller
{


    public function index()
    {

        $domaines = AcademicDomain::with([
            'filieres'
        ])
        ->where('is_active', true)
        ->get();


        return view(
            'admin.superieur.filieres.index',
            compact('domaines')
        );

    }




    public function create()
    {

        $domaines = AcademicDomain::where(
            'is_active',
            true
        )
        ->get();



        return view(
            'admin.superieur.filieres.create',
            compact('domaines')
        );

    }





    public function store(Request $request)
    {


        $validated = $request->validate([


            'academic_domain_id'=>[
                'required',
                'exists:academic_domains,id'
            ],


            'name'=>[
                'required',
                'string',
                'max:150'
            ],


            'description'=>[
                'nullable',
                'string'
            ],


        ]);



        Filiere::create([


            'academic_domain_id'=>
                $validated['academic_domain_id'],


            'name'=>
                $validated['name'],


            'slug'=>
                Str::slug($validated['name']),


            'description'=>
                $validated['description'] ?? null,


            'is_active'=>true,


        ]);



        return redirect()

            ->route(
                'admin.superieur.filieres.index'
            )

            ->with(
                'success',
                'Filière ajoutée avec succès.'
            );

    }






    public function edit(Filiere $filiere)
    {


        $domaines = AcademicDomain::where(
            'is_active',
            true
        )
        ->get();



        return view(
            'admin.superieur.filieres.edit',
            compact(
                'filiere',
                'domaines'
            )
        );

    }





    public function update(
        Request $request,
        Filiere $filiere
    )
    {


        $validated = $request->validate([


            'academic_domain_id'=>[
                'required',
                'exists:academic_domains,id'
            ],


            'name'=>[
                'required',
                'string',
                'max:150'
            ],


            'description'=>'nullable|string'


        ]);




        $filiere->update([


            'academic_domain_id'=>
                $validated['academic_domain_id'],


            'name'=>
                $validated['name'],


            'slug'=>
                Str::slug(
                    $validated['name']
                ),


            'description'=>
                $validated['description'] ?? null,


        ]);



        return redirect()

            ->route(
                'admin.superieur.filieres.index'
            )

            ->with(
                'success',
                'Filière modifiée.'
            );

    }





    public function toggle(Filiere $filiere)
    {


        $filiere->update([

            'is_active'=>
                !$filiere->is_active

        ]);



        return back();

    }





    public function destroy(Filiere $filiere)
    {


        if($filiere->levels()->exists())
        {

            return back()->with(
                'error',
                'Cette filière possède des niveaux.'
            );

        }



        $filiere->delete();



        return back()->with(
            'success',
            'Filière supprimée.'
        );

    }

}