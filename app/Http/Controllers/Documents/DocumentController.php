<?php

namespace App\Http\Controllers\Documents;
use App\Models\Document;
use App\Models\Tag;
use App\Models\Level;
use App\Models\Filiere;
use App\Models\Subject;
use App\Models\Formation;
use App\Models\Specialite;
use App\Models\DocumentType;
use App\Models\TeachingCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use App\Http\Controllers\Controller;

class DocumentController extends Controller
{
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
            'documentType'
        ])
            ->latest()
            ->paginate(10);

        return view('Documents.index', compact('documents'));
    }

    public function create()
    {
        $categories = TeachingCategory::where('is_active', true)
            ->orderBy('name')
            ->get();

        $formations = Formation::where('is_active', true)
            ->orderBy('name')
            ->get();

        $filieres = Filiere::where('is_active', true)
            ->orderBy('name')
            ->get();

        $specialites = Specialite::where('is_active', true)
            ->orderBy('name')
            ->get();

        $levels = Level::where('is_active', true)
            ->orderBy('name')
            ->get();

        $subjects = Subject::where('is_active', true)
            ->orderBy('name')
            ->get();

        $documentTypes = DocumentType::where('is_active', true)
            ->orderBy('name')
            ->get();

        $tags = Tag::orderBy('name')->get();

        return view('Documents.create', compact(
            'categories',
            'formations',
            'filieres',
            'specialites',
            'levels',
            'subjects',
            'documentTypes',
            'tags'
        ));
    }
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'content' => 'nullable|string',

            'teaching_category_id' => 'required|exists:teaching_categories,id',
            'formation_id' => 'nullable|exists:formations,id',
            'filiere_id' => 'nullable|exists:filieres,id',
            'specialite_id' => 'nullable|exists:specialites,id',
            'level_id' => 'nullable|exists:levels,id',
            'subject_id' => 'nullable|exists:subjects,id',
            'document_type_id' => 'required|exists:document_types,id',

            'access_type' => 'required|in:free,premium',
            'price' => 'nullable|numeric|min:0',

            'cover_image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:4096',

            'document_file' => 'required|mimes:pdf|max:20480',

            'tags' => 'nullable|array',
            'tags.*' => 'exists:tags,id',
        ]);

        // Upload du PDF
        $pdf = $request->file('document_file');

        $pdfPath = $pdf->store('documents', 'public');

        // Upload de la couverture
        $cover = null;

        if ($request->hasFile('cover_image')) {

            $cover = $request->file('cover_image')
                ->store('covers', 'public');
        }

        // Création du document
        $document = Document::create([

            'staff_id' => auth('staff')->id(),

            'teaching_category_id' => $validated['teaching_category_id'],

            'formation_id' => $validated['formation_id'] ?? null,

            'filiere_id' => $validated['filiere_id'] ?? null,

            'specialite_id' => $validated['specialite_id'] ?? null,

            'level_id' => $validated['level_id'] ?? null,

            'subject_id' => $validated['subject_id'] ?? null,

            'document_type_id' => $validated['document_type_id'],

            'title' => $validated['title'],

            'slug' => Str::slug($validated['title']) . '-' . time(),

            'description' => $validated['description'] ?? null,

            'content' => $validated['content'] ?? null,

            'document_file' => $pdfPath,

            'cover_image' => $cover,

            'file_size' => $pdf->getSize(),

            'file_extension' => $pdf->getClientOriginalExtension(),

            'language' => 'Français',

            'keywords' => null,

            'access_type' => $validated['access_type'],

            'price' => $validated['access_type'] === 'premium'
                ? $validated['price']
                : null,

            'status' => 'published',

            'views' => 0,

            'downloads' => 0,

            'published_at' => now(),

            'is_featured' => false,

        ]);

        // Enregistrer les tags
        if ($request->filled('tags')) {

            $document->tags()->sync($request->tags);
        }

        return redirect()
            ->route('journaliste.documents.index')
            ->with('success', 'Document publié avec succès.');
    }
    public function show(Document $document)
    {
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
            'comments'
        ]);

        return view('Documents.show', compact('document'));
    }

    public function edit(Document $document)
    {
        $categories = TeachingCategory::orderBy('name')->get();
        $formations = Formation::orderBy('name')->get();
        $filieres = Filiere::orderBy('name')->get();
        $specialites = Specialite::orderBy('name')->get();
        $levels = Level::orderBy('name')->get();
        $subjects = Subject::orderBy('name')->get();
        $documentTypes = DocumentType::orderBy('name')->get();
        $tags = Tag::orderBy('name')->get();

        $document->load('tags');

        return view('Documents.edit', compact(
            'document',
            'categories',
            'formations',
            'filieres',
            'specialites',
            'levels',
            'subjects',
            'documentTypes',
            'tags'
        ));
    }

    public function update(Request $request, Document $document)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'content' => 'nullable|string',

            'teaching_category_id' => 'required|exists:teaching_categories,id',
            'formation_id' => 'nullable|exists:formations,id',
            'filiere_id' => 'nullable|exists:filieres,id',
            'specialite_id' => 'nullable|exists:specialites,id',
            'level_id' => 'nullable|exists:levels,id',
            'subject_id' => 'nullable|exists:subjects,id',
            'document_type_id' => 'required|exists:document_types,id',

            'access_type' => 'required|in:free,premium',
            'price' => 'nullable|numeric|min:0',

            'cover_image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:4096',
            'document_file' => 'nullable|mimes:pdf|max:20480',

            'tags' => 'nullable|array',
            'tags.*' => 'exists:tags,id',
        ]);

        if ($request->hasFile('document_file')) {

            if ($document->file_path && Storage::disk('public')->exists($document->file_path)) {
                Storage::disk('public')->delete($document->file_path);
            }

            $pdf = $request->file('document_file');

            $document->file_path = $pdf->store('documents', 'public');
            $document->file_size = $pdf->getSize();
            $document->file_extension = $pdf->getClientOriginalExtension();
        }

        if ($request->hasFile('cover_image')) {

            if ($document->cover_image && Storage::disk('public')->exists($document->cover_image)) {
                Storage::disk('public')->delete($document->cover_image);
            }

            $document->cover_image = $request->file('cover_image')
                ->store('covers', 'public');
        }

        $document->update([
            'teaching_category_id' => $validated['teaching_category_id'],
            'formation_id' => $validated['formation_id'] ?? null,
            'filiere_id' => $validated['filiere_id'] ?? null,
            'specialite_id' => $validated['specialite_id'] ?? null,
            'level_id' => $validated['level_id'] ?? null,
            'subject_id' => $validated['subject_id'] ?? null,
            'document_type_id' => $validated['document_type_id'],

            'title' => $validated['title'],
            'slug' => Str::slug($validated['title']) . '-' . $document->id,

            'description' => $validated['description'] ?? null,
            'content' => $validated['content'] ?? null,

            'access_type' => $validated['access_type'],
            'price' => $validated['access_type'] == 'premium'
                ? $validated['price']
                : null,
        ]);

        $document->tags()->sync($request->tags ?? []);

        return redirect()
            ->route('journaliste.documents.index')
            ->with('success', 'Document modifié avec succès.');
    }

    public function destroy(Document $document)
    {
        if ($document->file_path && Storage::disk('public')->exists($document->file_path)) {
            Storage::disk('public')->delete($document->file_path);
        }

        if ($document->cover_image && Storage::disk('public')->exists($document->cover_image)) {
            Storage::disk('public')->delete($document->cover_image);
        }

        $document->tags()->detach();

        $document->delete();

        return redirect()
            ->route('journaliste.documents.index')
            ->with('success', 'Document supprimé avec succès.');
    }
}
