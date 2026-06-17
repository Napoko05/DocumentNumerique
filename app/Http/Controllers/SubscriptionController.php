<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SubscriptionController extends Controller
{
    public function create()
    {
        return view('subscribe'); // la vue Blade
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'  => 'required|string|max:255',
            'email' => 'required|email|unique:subscriptions,email',
        ]);

        Subscription::create($validated);

        return redirect()->back()->with('success', 'Merci pour votre abonnement !');
    }
}


