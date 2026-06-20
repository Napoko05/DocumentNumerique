<?php

namespace App\Http\Controllers;

use App\Models\Document;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DocumentController extends Controller
{
    public function index()
    {
        $documents = Document::latest()->paginate(10);

        return view(
            'Documents.index',
            compact('documents')
        );
    }

    public function create()
    {
        return view('Documents.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|max:255',
            'description' => 'required',
            'category' => 'required',
            'level' => 'required',
            'access_type' => 'required',
            'document' => 'required|mimes:pdf|max:20480'
        ]);

        $pdf = $request->file('document')
            ->store('documents', 'public');

        $cover = null;

        if ($request->hasFile('cover_image')) {
            $cover = $request->file('cover_image')
                ->store('covers', 'public');
        }

        Document::create([
            'staff_id' => auth('staff')->id(),
            'title' => $request->title,
            'description' => $request->description,
            'content' => $request->content,
            'category' => $request->category,
            'level' => $request->level,
            'cycle' => $request->cycle,
            'file_path' => $pdf,
            'cover_image' => $cover,
            'access_type' => $request->access_type,
            'price' => $request->price,
            'status' => 'published'
        ]);

        return redirect()
            ->route('journaliste.documents.index')
            ->with('success', 'Document publié avec succès');
    }

    public function show(Document $document)
    {
        return view(
            'Documents.show',
            compact('document')
        );
    }

    public function edit(Document $document)
    {
        return view(
            'Documents.edit',
            compact('document')
        );
    }

    public function update(Request $request, Document $document)
    {
        $document->update([
            'title' => $request->title,
            'description' => $request->description,
            'content' => $request->content,
            'category' => $request->category,
            'level' => $request->level,
            'cycle' => $request->cycle,
            'access_type' => $request->access_type,
            'price' => $request->price,
        ]);

        return redirect()
            ->route('journaliste.documents.index')
            ->with('success', 'Document modifié');
    }

    public function destroy(Document $document)
    {
        $document->delete();

        return redirect()
            ->route('journaliste.documents.index')
            ->with('success', 'Document supprimé');
    }
}
