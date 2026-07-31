<?php

namespace App\Http\Controllers\Vitrine;

use App\Http\Controllers\Controller;

use App\Models\Document;
use App\Models\DocumentType;
use App\Models\Formation;
use App\Models\Level;
use App\Models\Subject;


class VitrineTechniqueController extends Controller
{


    /**
     * LISTE DES CLASSES DU SECONDAIRE TECHNIQUE
     */
    public function classes()
    {

        $formation = Formation::where(
            'slug',
            'secondaire-technique'
        )
        ->where(
            'is_active',
            true
        )
        ->firstOrFail();



        $classes = Level::where(
            'formation_id',
            $formation->id
        )
        ->where(
            'is_active',
            true
        )
        ->orderBy('order')
        ->get();



        foreach($classes as $classe)
        {

            $classe->documents_count = Document::where(
                'level_id',
                $classe->id
            )
            ->where(
                'status',
                'published'
            )
            ->count();

        }



        return view(
            'niveau.technique.classes',
            compact(
                'formation',
                'classes'
            )
        );

    }





    /**
     * MATIERES
     */
    public function matieres(
        string $classeSlug
    )
    {


        $classe = Level::where(
            'slug',
            $classeSlug
        )
        ->where(
            'is_active',
            true
        )
        ->firstOrFail();



        $matieres = Subject::where(
            'level_id',
            $classe->id
        )
        ->where(
            'is_active',
            true
        )
        ->orderBy('name')
        ->get();



        foreach($matieres as $matiere)
        {

            $matiere->documents_count = Document::where(
                'level_id',
                $classe->id
            )
            ->where(
                'subject_id',
                $matiere->id
            )
            ->where(
                'status',
                'published'
            )
            ->count();

        }



        return view(
            'niveau.technique.matieres',
            compact(
                'classe',
                'matieres'
            )
        );

    }





    /**
     * TYPES DOCUMENTS
     */
    public function typeDocuments(
        string $classeSlug,
        string $matiereSlug
    )
    {


        $classe = Level::where(
            'slug',
            $classeSlug
        )
        ->where(
            'is_active',
            true
        )
        ->firstOrFail();



        $matiere = Subject::where(
            'slug',
            $matiereSlug
        )
        ->where(
            'level_id',
            $classe->id
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
        ->orderBy('name')
        ->get();



        foreach($types as $type)
        {

            $type->documents_count = Document::where(
                'level_id',
                $classe->id
            )
            ->where(
                'subject_id',
                $matiere->id
            )
            ->where(
                'document_type_id',
                $type->id
            )
            ->where(
                'status',
                'published'
            )
            ->count();

        }



        return view(
            'niveau.technique.type_doc',
            compact(
                'classe',
                'matiere',
                'types'
            )
        );

    }





    /**
     * DOCUMENTS
     */
    public function documents(
        string $classeSlug,
        string $matiereSlug,
        string $typeSlug
    )
    {


        $classe = Level::where(
            'slug',
            $classeSlug
        )
        ->where(
            'is_active',
            true
        )
        ->firstOrFail();



        $matiere = Subject::where(
            'slug',
            $matiereSlug
        )
        ->where(
            'level_id',
            $classe->id
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



        $documents = Document::with([

            'staff',
            'level',
            'subject',
            'documentType',
            'ratings'

        ])
        ->where(
            'level_id',
            $classe->id
        )
        ->where(
            'subject_id',
            $matiere->id
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
            'niveau.technique.documents',
            compact(
                'classe',
                'matiere',
                'type',
                'documents'
            )
        );

    }


}