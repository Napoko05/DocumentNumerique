<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Staff;
use App\Models\Document;
use App\Models\Payment;
use App\Models\DocumentView;

class AdminController extends Controller
{
    public function dashboard()
    {
        return view('dashboard.admin_dashboard', [

            /*
            |--------------------------------------------------------------------------
            | UTILISATEURS
            |--------------------------------------------------------------------------
            */

            'totalUsers' => User::count(),

            'totalJournalists' => Staff::where('role_alias', 'journalist')
                ->count(),

            /*
            |--------------------------------------------------------------------------
            | DOCUMENTS
            |--------------------------------------------------------------------------
            */

            'totalDocuments' => Document::count(),

            'publishedDocs' => Document::where('status', 'published')
                ->count(),

            'pendingDocs' => Document::where('status', 'pending')
                ->count(),

            'draftDocs' => Document::where('status', 'draft')
                ->count(),

            'rejectedDocs' => Document::where('status', 'rejected')
                ->count(),

            'freeDocs' => Document::where('access_type', 'free')
                ->count(),

            'premiumDocs' => Document::where('access_type', 'premium')
                ->count(),

            /*
            |--------------------------------------------------------------------------
            | CONSULTATIONS
            |--------------------------------------------------------------------------
            */

            'totalViews' => DocumentView::count(),

            /*
            |--------------------------------------------------------------------------
            | PAIEMENTS
            |--------------------------------------------------------------------------
            */

            'totalRevenue' => Payment::where('status', 'paid')
                ->sum('amount'),

            'totalTransactions' => Payment::where('status', 'paid')
                ->count(),

            'todaySales' => Payment::where('status', 'paid')
                ->whereDate('created_at', today())
                ->sum('amount'),

        ]);
    }
}