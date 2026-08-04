<?php

namespace App\Http\Controllers\Documents;

use App\Http\Controllers\Controller;
use App\Models\Document;
use App\Models\DocumentType;
use App\Models\Filiere;
use App\Models\Formation;
use App\Models\Level;
use App\Models\Specialite;
use App\Models\Subject;
use App\Models\Tag;
use App\Models\TeachingCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class DocumentController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | LISTE DES DOCUMENTS
    |--------------------------------------------------------------------------
    */

    public function index()
    {
        $documents = Document::with([
            'staff',
            'teachingCategory',
            'formation',
            'filiere',
            'specialite',
            'level',
            'subject',
            'documentType',
        ])
            ->latest()
            ->paginate(10);

        return view(
            'Documents.index',
            compact('documents')
        );
    }


    /*
    |--------------------------------------------------------------------------
    | FORMULAIRE DE CRÉATION
    |--------------------------------------------------------------------------
    */

    public function create()
    {
        $categories = TeachingCategory::active()
            ->orderBy('name')
            ->get();

        /*
        |--------------------------------------------------------------------------
        | Formations
        |--------------------------------------------------------------------------
        |
        | Utilisées principalement pour :
        |
        | - Secondaire général
        | - Secondaire technique
        | - Professionnel
        |
        */

        $formations = Formation::active()
            ->orderBy('name')
            ->get();

        /*
        |--------------------------------------------------------------------------
        | Filières
        |--------------------------------------------------------------------------
        |
        | Utilisées principalement pour :
        |
        | Supérieur :
        |
        | Domaine académique
        |        ↓
        | Filière
        |        ↓
        | Niveau
        |        ↓
        | Module
        |
        */

        $filieres = Filiere::active()
            ->orderBy('name')
            ->get();

        $specialites = Specialite::active()
            ->orderBy('name')
            ->get();

        $levels = Level::active()
            ->orderBy('order')
            ->orderBy('name')
            ->get();

        $subjects = Subject::active()
            ->orderBy('order')
            ->orderBy('name')
            ->get();

        $documentTypes = DocumentType::active()
            ->orderBy('name')
            ->get();

        $tags = Tag::orderBy('name')
            ->get();

        return view(
            'Documents.create',
            compact(
                'categories',
                'formations',
                'filieres',
                'specialites',
                'levels',
                'subjects',
                'documentTypes',
                'tags'
            )
        );
    }


    /*
    |--------------------------------------------------------------------------
    | ENREGISTRER LE DOCUMENT
    |--------------------------------------------------------------------------
    */

    public function store(Request $request)
    {
        $validated = $request->validate([

            /*
            |--------------------------------------------------------------------------
            | Informations générales
            |--------------------------------------------------------------------------
            */

            'title' => [
                'required',
                'string',
                'max:255',
            ],

            'description' => [
                'nullable',
                'string',
            ],

            'content' => [
                'nullable',
                'string',
            ],


            /*
            |--------------------------------------------------------------------------
            | Hiérarchie pédagogique
            |--------------------------------------------------------------------------
            */

            'teaching_category_id' => [
                'required',
                'exists:teaching_categories,id',
            ],

            'formation_id' => [
                'nullable',
                'exists:formations,id',
            ],

            'filiere_id' => [
                'nullable',
                'exists:filieres,id',
            ],

            'specialite_id' => [
                'nullable',
                'exists:specialites,id',
            ],

            'level_id' => [
                'required',
                'exists:levels,id',
            ],

            'subject_id' => [
                'required',
                'exists:subjects,id',
            ],

            'document_type_id' => [
                'required',
                'exists:document_types,id',
            ],


            /*
            |--------------------------------------------------------------------------
            | Accès
            |--------------------------------------------------------------------------
            */

            'access_type' => [
                'required',
                'in:free,premium',
            ],

            'price' => [
                'nullable',
                'numeric',
                'min:0',
            ],


            /*
            |--------------------------------------------------------------------------
            | Fichiers
            |--------------------------------------------------------------------------
            */

            'cover_image' => [
                'nullable',
                'image',
                'mimes:jpg,jpeg,png,webp',
                'max:4096',
            ],

            'document_file' => [
                'required',
                'file',
                'mimes:pdf',
                'max:20480',
            ],


            /*
            |--------------------------------------------------------------------------
            | Tags
            |--------------------------------------------------------------------------
            */

            'tags' => [
                'nullable',
                'array',
            ],

            'tags.*' => [
                'exists:tags,id',
            ],

        ]);


        /*
        |--------------------------------------------------------------------------
        | Validation du prix premium
        |--------------------------------------------------------------------------
        */

        if (
            $validated['access_type'] === 'premium'
            &&
            (
                ! isset($validated['price'])
                ||
                $validated['price'] <= 0
            )
        ) {
            return back()
                ->withErrors([
                    'price' =>
                    'Le prix est obligatoire pour un document premium.',
                ])
                ->withInput();
        }


        /*
        |--------------------------------------------------------------------------
        | Upload du PDF
        |--------------------------------------------------------------------------
        */

        $pdf = $request->file(
            'document_file'
        );

        $pdfPath = $pdf->store(
            'documents',
            'public'
        );


        /*
        |--------------------------------------------------------------------------
        | Upload de la couverture
        |--------------------------------------------------------------------------
        */

        $coverPath = null;

        if (
            $request->hasFile(
                'cover_image'
            )
        ) {
            $coverPath = $request
                ->file('cover_image')
                ->store(
                    'covers',
                    'public'
                );
        }


        /*
        |--------------------------------------------------------------------------
        | Création du document
        |--------------------------------------------------------------------------
        */

        $document = Document::create([

            'staff_id' =>
            auth('staff')->id(),

            'teaching_category_id' =>
            $validated['teaching_category_id'],

            'formation_id' =>
            $validated['formation_id'] ?? null,

            'filiere_id' =>
            $validated['filiere_id'] ?? null,

            'specialite_id' =>
            $validated['specialite_id'] ?? null,

            'level_id' =>
            $validated['level_id'],

            'subject_id' =>
            $validated['subject_id'],

            'document_type_id' =>
            $validated['document_type_id'],

            'title' =>
            $validated['title'],

            'slug' =>
            Str::slug(
                $validated['title']
            )
                . '-'
                . Str::random(8),

            'description' =>
            $validated['description'] ?? null,

            'content' =>
            $validated['content'] ?? null,

            /*
            |--------------------------------------------------------------------------
            | Même nom de colonne partout
            |--------------------------------------------------------------------------
            */

            'file_path' =>
            $pdfPath,

            'cover_image' =>
            $coverPath,

            'file_size' =>
            $pdf->getSize(),

            'file_extension' =>
            $pdf
                ->getClientOriginalExtension(),

            'language' =>
            'Français',

            'keywords' =>
            null,

            'access_type' =>
            $validated['access_type'],

            'price' =>
            $validated['access_type'] === 'premium'
                ? $validated['price']
                : null,

            'status' =>
            'published',

            'views' =>
            0,

            'downloads' =>
            0,

            'published_at' =>
            now(),

            'is_featured' =>
            false,

        ]);


        /*
        |--------------------------------------------------------------------------
        | Enregistrement des tags
        |--------------------------------------------------------------------------
        */

        $document
            ->tags()
            ->sync(
                $validated['tags'] ?? []
            );


        return redirect()
            ->route(
                'journaliste.documents.index'
            )
            ->with(
                'success',
                'Document publié avec succès.'
            );
    }


    /*
    |--------------------------------------------------------------------------
    | AFFICHER UN DOCUMENT
    |--------------------------------------------------------------------------
    */

    public function show(
        Document $document
    ) {
        $document->load([

            'staff',

            'teachingCategory',

            'formation',

            'filiere',

            'specialite',

            'level',

            'subject',

            'documentType',

            'tags',

            'comments',

        ]);

        return view(
            'Documents.show',
            compact('document')
        );
    }


    /*
    |--------------------------------------------------------------------------
    | FORMULAIRE DE MODIFICATION
    |--------------------------------------------------------------------------
    */

    public function edit(
        Document $document
    ) {
        $categories = TeachingCategory::active()
            ->orderBy('name')
            ->get();

        $formations = Formation::active()
            ->orderBy('name')
            ->get();

        $filieres = Filiere::active()
            ->orderBy('name')
            ->get();

        $specialites = Specialite::active()
            ->orderBy('name')
            ->get();

        $levels = Level::active()
            ->orderBy('order')
            ->orderBy('name')
            ->get();

        $subjects = Subject::active()
            ->orderBy('order')
            ->orderBy('name')
            ->get();

        $documentTypes = DocumentType::active()
            ->orderBy('name')
            ->get();

        $tags = Tag::orderBy('name')
            ->get();

        $document->load(
            'tags'
        );

        return view(
            'Documents.edit',
            compact(

                'document',

                'categories',

                'formations',

                'filieres',

                'specialites',

                'levels',

                'subjects',

                'documentTypes',

                'tags'

            )
        );
    }


    /*
    |--------------------------------------------------------------------------
    | MODIFIER LE DOCUMENT
    |--------------------------------------------------------------------------
    */

    public function update(
        Request $request,
        Document $document
    ) {
        $validated = $request->validate([

            'title' => [
                'required',
                'string',
                'max:255',
            ],

            'description' => [
                'nullable',
                'string',
            ],

            'content' => [
                'nullable',
                'string',
            ],

            'teaching_category_id' => [
                'required',
                'exists:teaching_categories,id',
            ],

            'formation_id' => [
                'nullable',
                'exists:formations,id',
            ],

            'filiere_id' => [
                'nullable',
                'exists:filieres,id',
            ],

            'specialite_id' => [
                'nullable',
                'exists:specialites,id',
            ],

            'level_id' => [
                'required',
                'exists:levels,id',
            ],

            'subject_id' => [
                'required',
                'exists:subjects,id',
            ],

            'document_type_id' => [
                'required',
                'exists:document_types,id',
            ],

            'access_type' => [
                'required',
                'in:free,premium',
            ],

            'price' => [
                'nullable',
                'numeric',
                'min:0',
            ],

            'cover_image' => [
                'nullable',
                'image',
                'mimes:jpg,jpeg,png,webp',
                'max:4096',
            ],

            'document_file' => [
                'nullable',
                'file',
                'mimes:pdf',
                'max:20480',
            ],

            'tags' => [
                'nullable',
                'array',
            ],

            'tags.*' => [
                'exists:tags,id',
            ],

        ]);
        /*
        |--------------------------------------------------------------------------
        | Remplacement du PDF
        |--------------------------------------------------------------------------
        */

        if ($request->hasFile('file_path')) {

            if (
                $document->file_path &&
                Storage::disk('public')->exists($document->file_path)
            ) {
                Storage::disk('public')->delete($document->file_path);
            }

            $pdf = $request->file('file_path');

            $document->file_path = $pdf->store(
                'documents',
                'public'
            );

            $document->file_size = $pdf->getSize();

            $document->file_extension = $pdf->getClientOriginalExtension();

            $document->save();
        }

        /*
        |--------------------------------------------------------------------------
        | Remplacement de la couverture
        |--------------------------------------------------------------------------
        */

        if (
            $request->hasFile(
                'cover_image'
            )
        ) {

            if (
                $document->cover_image
                &&
                Storage::disk(
                    'public'
                )->exists(
                    $document->cover_image
                )
            ) {
                Storage::disk(
                    'public'
                )->delete(
                    $document->cover_image
                );
            }

            $document->cover_image =
                $request
                ->file('cover_image')
                ->store(
                    'covers',
                    'public'
                );

            $document->save();
        }


        /*
        |--------------------------------------------------------------------------
        | Mise à jour des données
        |--------------------------------------------------------------------------
        */

        $document->update([

            'teaching_category_id' =>
            $validated['teaching_category_id'],

            'formation_id' =>
            $validated['formation_id'] ?? null,

            'filiere_id' =>
            $validated['filiere_id'] ?? null,

            'specialite_id' =>
            $validated['specialite_id'] ?? null,

            'level_id' =>
            $validated['level_id'],

            'subject_id' =>
            $validated['subject_id'],

            'document_type_id' =>
            $validated['document_type_id'],

            'title' =>
            $validated['title'],

            'slug' =>
            Str::slug(
                $validated['title']
            )
                . '-'
                . $document->id,

            'description' =>
            $validated['description'] ?? null,

            'content' =>
            $validated['content'] ?? null,

            'access_type' =>
            $validated['access_type'],

            'price' =>
            $validated['access_type'] === 'premium'
                ? $validated['price']
                : null,

        ]);


        /*
        |--------------------------------------------------------------------------
        | Mise à jour des tags
        |--------------------------------------------------------------------------
        */

        $document
            ->tags()
            ->sync(
                $validated['tags'] ?? []
            );


        return redirect()
            ->route(
                'journaliste.documents.index'
            )
            ->with(
                'success',
                'Document modifié avec succès.'
            );
    }


    /*
    |--------------------------------------------------------------------------
    | SUPPRIMER LE DOCUMENT
    |--------------------------------------------------------------------------
    */

    public function destroy(
        Document $document
    ) {

        /*
        |--------------------------------------------------------------------------
        | Supprimer le PDF
        |--------------------------------------------------------------------------
        */

        if (
            $document->file_path
            &&
            Storage::disk(
                'public'
            )->exists(
                $document->file_path
            )
        ) {
            Storage::disk(
                'public'
            )->delete(
                $document->file_path
            );
        }


        /*
        |--------------------------------------------------------------------------
        | Supprimer la couverture
        |--------------------------------------------------------------------------
        */

        if (
            $document->cover_image
            &&
            Storage::disk(
                'public'
            )->exists(
                $document->cover_image
            )
        ) {
            Storage::disk(
                'public'
            )->delete(
                $document->cover_image
            );
        }


        /*
        |--------------------------------------------------------------------------
        | Supprimer les relations tags
        |--------------------------------------------------------------------------
        */

        $document
            ->tags()
            ->detach();


        /*
        |--------------------------------------------------------------------------
        | Supprimer le document
        |--------------------------------------------------------------------------
        */

        $document->delete();


        return redirect()
            ->route(
                'journaliste.documents.index'
            )
            ->with(
                'success',
                'Document supprimé avec succès.'
            );
    }
}
