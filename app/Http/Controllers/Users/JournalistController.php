<?php

namespace App\Http\Controllers\Users;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Document;
use Illuminate\Support\Facades\Auth;

class JournalistController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth:staff', 'role:journalist']);
    }

    /**
     * Tableau de bord du journaliste
     */
    public function dashboard()
    {
        $staff = Auth::guard('staff')->user();

        $documents = Document::where('staff_id', $staff->id)
            ->latest()
            ->take(10)
            ->get();

        $totalDocuments = Document::where('staff_id', $staff->id)->count();

        $publishedDocuments = Document::where('staff_id', $staff->id)
            ->where('status', 'published')
            ->count();

        $pendingDocuments = Document::where('staff_id', $staff->id)
            ->where('status', 'pending')
            ->count();

        $draftDocuments = Document::where('staff_id', $staff->id)
            ->where('status', 'draft')
            ->count();

        $rejectedDocuments = Document::where('staff_id', $staff->id)
            ->where('status', 'rejected')
            ->count();

        $freeDocuments = Document::where('staff_id', $staff->id)
            ->where('access_type', 'free')
            ->count();

        $premiumDocuments = Document::where('staff_id', $staff->id)
            ->where('access_type', 'premium')
            ->count();

        $totalViews = Document::where('staff_id', $staff->id)
            ->sum('views');

        $totalDownloads = Document::where('staff_id', $staff->id)
            ->sum('downloads');

        $recentDocuments = Document::where('staff_id', $staff->id)
            ->latest()
            ->take(5)
            ->get();

        return view('dashboard.journaliste_dashboard', compact(
            'staff',
            'documents',
            'recentDocuments',
            'totalDocuments',
            'publishedDocuments',
            'pendingDocuments',
            'draftDocuments',
            'rejectedDocuments',
            'freeDocuments',
            'premiumDocuments',
            'totalViews',
            'totalDownloads'
        ));
    }

    /**
     * Liste des utilisateurs (lecture seule)
     */
    public function users()
    {
        $users = User::with('roles')
            ->latest()
            ->paginate(15);

        return view('journalist.users.index', compact('users'));
    }
}