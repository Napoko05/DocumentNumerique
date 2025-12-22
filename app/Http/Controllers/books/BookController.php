<?php

namespace App\Http\Controllers\Books;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Book; // Assure-toi d'avoir un modèle Book
use Illuminate\Support\Facades\Auth;

class BookController extends Controller
{
    public function __construct()
    {
        // Toutes les méthodes nécessitent d'être connecté sauf index
        $this->middleware('auth')->only(['show', 'buy']);
    }

    // Page principale des livres (menu)
    public function index()
    {
        // Récupère tous les documents gratuits pour les visiteurs
        $books = Book::where('is_premium', false)->paginate(10);

        // Si l'utilisateur est connecté, on peut lui afficher aussi les premium achetés
        if (Auth::check()) {
            $premiumBooks = Book::where('is_premium', true)
                ->whereHas('purchases', fn($q) => $q->where('user_id', Auth::id()))
                ->get();
        } else {
            $premiumBooks = collect(); // vide pour les visiteurs
        }

        return view('books.livres', compact('books', 'premiumBooks'));
    }

    // Afficher un document (lecture)
    public function show(Book $book)
    {
        // Si document premium
        if ($book->is_premium) {
            // Vérifie si l'utilisateur est connecté
            if (!Auth::check()) {
                return redirect()->route('login')->with('warning', 'Connectez-vous pour lire ce document premium.');
            }

            // Vérifie si l'utilisateur a payé ou est journaliste/admin
            if (!Auth::user()->hasPaid($book) && !Auth::user()->hasAnyRole(['admin', 'journalist'])) {
                return redirect()->route('books.index')->with('warning', 'Vous devez acheter ce document pour le lire.');
            }
        }

        return view('books.show', compact('book'));
    }

    // Acheter un document premium
    public function buy(Book $book)
    {
        // Vérifie si c'est un document premium
        if (!$book->is_premium) {
            return redirect()->route('books.show', $book)->with('info', 'Ce document est gratuit.');
        }

        $user = Auth::user();

        // Vérifie si déjà acheté
        if ($user->hasPaid($book)) {
            return redirect()->route('books.show', $book)->with('info', 'Vous avez déjà acheté ce document.');
        }

        // Logique d'achat (à remplacer par ton système de paiement)
        $user->purchases()->attach($book->id);

        return redirect()->route('books.show', $book)->with('success', 'Achat effectué. Vous pouvez maintenant lire le document.');
    }

    // ===========================
    // ENSEIGNEMENT SECONDAIRE
    // ===========================

    public function secondary()
    {
        return view('books.secondary');
    }

    public function secondaryGeneral($cycle)
    {
        return view('books.secondary_general', compact('cycle'));
    }

    public function secondaryTechnique($level)
    {
        return view('books.secondary_technique', compact('level'));
    }

    // ===========================
    // ENSEIGNEMENT SUPERIEUR
    // ===========================

    public function superior()
    {
        return view('books.superior');
    }

    public function superiorGeneral($level)
    {
        return view('books.superior_general', compact('level'));
    }

    public function superiorTechnique($level)
    {
        return view('books.superior_technique', compact('level'));
    }
}
