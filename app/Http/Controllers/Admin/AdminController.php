<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Staff;
use App\Models\Book;

class AdminController extends Controller
{
    public function dashboard()
    {
        return view('dashboard.admin_dashboard', [

            // USERS
            'totalUsers' => User::count(),
            'totalJournalists' => Staff::where('role_alias', 'journalist')->count(),

            // BOOKS
            'totalDocuments' => Book::count(),

            // VUES
            'totalViews' => 0,

            // STATUS BOOKS
            'publishedDocs' => Book::where('status', 'published')->count(),
            'pendingDocs'   => Book::where('status', 'pending')->count(),
            'premiumDocs'   => Book::where('access_type', 'premium')->count(),
            // PAYMENTS
            'totalRevenue' => 0,
            'totalTransactions' => 0,
            'todaySales' => 0,
        ]);
    }
}