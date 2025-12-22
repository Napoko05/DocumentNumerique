<?php

namespace App\Http\Controllers\users;
use Illuminate\Http\Request;
use App\Models\Contact;
use App\Http\Controllers\Controller;

class ContactController extends Controller
{
    public function showForm()
    {
        return view('contact');
    }

    public function submitForm(Request $request)
    {
        // Validation basique
        $request->validate([
            'nom' => 'required|string|max:255',
            'email' => 'required|email',
            'objet' => 'required|string|max:255',
            'message' => 'required|string',
        ]);

        // Sauvegarde dans la BDD
        Contact::create([
            'nom' => $request->nom,
            'email' => $request->email,
            'objet' => $request->objet,
            'message' => $request->message,
        ]);

        // Retourner une confirmation
        return redirect()->route('contact.form')->with('success', 'Votre message a été envoyé avec succès ✅');
    }
}
