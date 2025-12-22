<?php

namespace App\Http\Controllers\Users;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Document;
use Illuminate\Support\Facades\Storage;

class JournalistController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'role:journalist']);
    }

    /**
     * Dashboard journaliste
     */
    public function dashboard()
    {
        $user = auth()->user();

        // Récupérer les documents du journaliste connecté
        $documents = $user->documents()->get();

        // Données pour les graphiques
        $chartLabels = $documents->pluck('title');
        $chartData   = $documents->pluck('views');

        // Statistiques
        $totalDocuments = $documents->count();
        $totalViews     = $documents->sum('views');
        $totalPremium   = $documents->where('access_type','premium')->count();
        $totalFree      = $documents->where('access_type','free')->count(); // ✅ ajouté

        return view('dashboard.journaliste_dashboard', compact(
            'documents', 'chartLabels', 'chartData',
            'totalDocuments', 'totalViews', 'totalPremium', 'totalFree'
        ));
    }

    /**
     * Liste des utilisateurs (lecture seule)
     */
    public function users()
    {
        $users = User::with('roles')->paginate(10);
        return view('journalist.users.index', compact('users'));
    }

    /**
     * Ajouter un document
     */
    public function createDocument(Request $request)
    {
        $validated = $request->validate([
            'title'       => 'required|string|max:255',
            'description' => 'nullable|string|max:1000',
            'type'        => 'required|in:document,article',
            'access_type' => 'required|in:free,premium',
            'price'       => 'nullable|numeric|min:0',
            'file'        => 'nullable|file|mimes:pdf,docx',
            'content'     => 'nullable|string',
        ]);

        $path = null;
        if ($request->hasFile('file')) {
            $path = $request->file('file')->store('documents', 'public');
        }

        $document = auth()->user()->documents()->create([
            'title'       => $validated['title'],
            'description' => $validated['description'] ?? null,
            'type'        => $validated['type'],
            'access_type' => $validated['access_type'],
            'price'       => $validated['access_type'] === 'premium' ? $validated['price'] : 0,
            'content'     => $path ?? $validated['content'] ?? '',
        ]);

        return redirect()->route('journalist.dashboard')->with('success', 'Document publié avec succès.');
    }

    /**
     * Voir un document
     */
    public function showDocument(Document $document)
    {
        // Augmenter le compteur de vues
        $document->increment('views');

        return view('journalist.documents.show', compact('document'));
    }
}
