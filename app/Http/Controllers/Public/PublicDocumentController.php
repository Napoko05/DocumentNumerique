<?php

namespace App\Http\Controllers\Public;

use App\Models\Document;

use App\Models\Payment;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;

class PublicDocumentController extends Controller
{
    /**
     * Liste des documents publiés
     */
    public function index()
    {
        $documents = Document::with('staff')
            ->where('status', 'published')
            ->latest()
            ->paginate(12);

        return view('PublicDoc.index', compact('documents'));
    }

    /**
     * Détail d'un document
     */
    public function show(Document $document)
    {
        abort_if($document->status !== 'published', 404);

        return view('PublicDoc.show', compact('document'));
    }

    /**
     * Lecture d'un document
     */
    public function read(Document $document)
    {
        abort_if($document->status !== 'published', 404);

        /*
    |--------------------------------------------------------------------------
    | DOCUMENT GRATUIT
    |--------------------------------------------------------------------------
    */
        if ($document->access_type === 'free') {

            $path = storage_path('app/public/' . $document->file_path);

            if (!file_exists($path)) {
                abort(404, 'Fichier introuvable.');
            }

            $document->increment('views');

            return response()->file($path);
        }

        /*
    |--------------------------------------------------------------------------
    | DOCUMENT PREMIUM
    |--------------------------------------------------------------------------
    */

        if (!Auth::check()) {

            return redirect()
                ->route('login')
                ->with('error', 'Veuillez vous connecter.');
        }

        $paid = Payment::where('user_id', Auth::id())
            ->where('document_id', $document->id)
            ->where('status', 'paid')
            ->exists();

        if (!$paid) {

            return redirect()
                ->route('payments.create', $document)
                ->with('warning', 'Paiement requis.');
        }

        $path = storage_path('app/public/' . $document->file_path);

        if (!file_exists($path)) {
            abort(404, 'Fichier introuvable.');
        }

        $document->increment('views');

        return response()->file($path);
    }
}
