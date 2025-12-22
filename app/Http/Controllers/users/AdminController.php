<?php

namespace App\Http\Controllers\Users;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Document;
use Spatie\Permission\Models\Role;

class AdminController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'role:admin']);
    }

    /* =====================
       DASHBOARD ADMIN
    ===================== */
    public function dashboard()
{
    return view('dashboard.admin_dashboard', [
        'totalUsers'       => User::count(),
        'totalJournalists' => User::role('journalist')->count(),
        'totalDocuments'   => Document::count(),
        'totalPremium'     => Document::where('access_type', 'premium')->count(),
        'totalFree'        => Document::where('access_type', 'free')->count(),
        'totalViews'       => Document::sum('views'),
    ]);
}

}
