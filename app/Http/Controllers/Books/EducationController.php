<?php

namespace App\Http\Controllers\Books;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;

class EducationController extends Controller
{
    // PAGE PRINCIPALE
    public function index()
    {
        return view('books.niveau_professionnelles');
    }
    // =========================
    // ENS
    // =========================
    public function ens($annee)
    {
        return view('education.ens', compact('annee'));
    }
    public function capceg($matiere)
    {
        return view('education.capceg', compact('matiere'));
    }
    public function inspecteur($type)
    {
        return view('education.inspecteur', compact('type'));
    }
    // =========================
    // ENSP
    // =========================
    public function ensp($niveau)
    {
        return view('education.ensp', compact('niveau'));
    }
    // =========================
    // IDS
    // =========================
    public function ids($specialite)
    {
        return view('education.ids', compact('specialite'));
    }

    // =========================
    // ENEP
    // =========================
    public function enep($niveau)
    {
        return view('education.enep', compact('niveau'));
    }

    // =========================
    // UIT
    // =========================
    public function uit($filiere)
    {
        return view('education.uit', compact('filiere'));
    }

    // =========================
    // SUPERIEUR TECHNIQUE
    // =========================
    public function superieurTechnique($niveau)
    {
        return view('education.superieur_technique', compact('niveau'));
    }
}
