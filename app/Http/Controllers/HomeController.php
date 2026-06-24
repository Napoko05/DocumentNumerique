<?php

namespace App\Http\Controllers;

use App\Models\Document;

class HomeController extends Controller
{
    public function index()
    {
        $latestDocuments = Document::where('status', 'published')
            ->latest()
            ->take(12)
            ->get();

        $premiumDocuments = Document::where('status', 'published')
            ->where('access_type', 'premium')
            ->latest()
            ->take(8)
            ->get();

        $freeDocuments = Document::where('status', 'published')
            ->where('access_type', 'free')
            ->latest()
            ->take(8)
            ->get();

        $popularDocuments = Document::where('status', 'published')
            ->orderByDesc('views')
            ->take(8)
            ->get();

        return view('index', compact(
            'latestDocuments',
            'premiumDocuments',
            'freeDocuments',
            'popularDocuments'
        ));
    }
}