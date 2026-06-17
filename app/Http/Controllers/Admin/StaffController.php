<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Staff;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Storage;

class StaffController extends Controller
{
    /**
     * STEP 1 - FORM CREATE STAFF
     */
    public function create()
    {
        return view('admin.create_agent_step1');
    }

    public function step1(Request $request)
    {
        $validated = $request->validate([
            'nom' => 'required|string|max:255',
            'prenom' => 'required|string|max:255',
            'sexe' => 'required|string',
            'date_naissance' => 'required|date',
            
            'lieu_naissance' => 'required|string|max:255',

            'matricule' => 'required|string|unique:staff,matricule',
            'email' => 'required|email|unique:staff,email',
            'tel' => 'nullable|string|max:20',

            'service' => 'required|string|max:255',
            'specialite' => 'nullable|string|max:255',

            // AJOUT IMPORTANT
            'num_cnib' => 'nullable|string|max:30',
            'ville' => 'nullable|string|max:255',

            'password' => 'required|string|min:8|confirmed',
        ]);

        // FILES TEMPORAIRES
        $files = [];

        $fileFields = [
            'cnib_file',
            'attestation_travail_file',
            'diplome_file',
            'signature_file'
        ];

        foreach ($fileFields as $file) {
            if ($request->hasFile($file)) {
                $files[$file] = $request->file($file)->store('staff_temp', 'public');
            }
        }

        // SESSION CLEAN & COMPLETE
        session([
            'staff_data' => $validated,
            'staff_files' => $files
        ]);

        return redirect()->route('admin.staff.step2.view');
    }
    /**
     * STEP 2 - VIEW RECAP
     */
    public function step2View()
    {
        if (!session()->has('staff_data')) {
            return redirect()->route('admin.staff.create');
        }

        $data = session('staff_data');
        $files = session('staff_files', []);
        $roles = Role::whereIn('name', ['admin', 'journalist'])->get();

        return view('admin.create_agent_step2', compact('data', 'files', 'roles'));
    }

    /**
     * STORE FINAL STAFF
     */
    public function store(Request $request)
    {
        if (!session()->has('staff_data')) {
            return redirect()->route('admin.staff.create');
        }

        $data = session('staff_data');
        $sessionFiles = session('staff_files', []);

        // CREATE STAFF
        $staff = Staff::create([
            'user_id' => auth()->id(), // 🔥 important

            'nom' => $data['nom'],
            'prenom' => $data['prenom'],
            'sexe' => $data['sexe'],
            'date_naissance' => $data['date_naissance'],
            'lieu_naissance' => $data['lieu_naissance'],

            'num_cnib' => $request->num_cnib ?? null,

            'matricule' => $data['matricule'],
            'email' => $data['email'],

            'tel' => $data['tel'] ?? null,
            'ville' => $request->ville ?? null,

            'service' => $data['service'],
            'specialite' => $data['specialite'] ?? null,

            'password' => Hash::make($data['password']),
            'is_active' => 1,
        ]);

        // ROLE (SPATIE)
        $staff->assignRole($request->role ?? 'journalist');

        // FILES FINAL SAVE
        $finalFiles = [];

        $fileMap = [
            'cnib_file',
            'attestation_travail_file',
            'diplome_file',
            'signature_file'
        ];

        foreach ($fileMap as $field) {

            if ($request->hasFile($field)) {

                $path = $request->file($field)->store("staff/$field", 'public');
                $finalFiles[$field] = $path;
            } elseif (!empty($sessionFiles[$field])) {

                $tempPath = $sessionFiles[$field];

                if (Storage::disk('public')->exists($tempPath)) {

                    $newPath = "staff/$field/" . basename($tempPath);

                    Storage::disk('public')->move($tempPath, $newPath);

                    $finalFiles[$field] = $newPath;
                }
            }
        }

        // UPDATE FILES
        $staff->update($finalFiles);

        // CLEAN SESSION
        session()->forget(['staff_data', 'staff_files']);

        return redirect()->route('admin.staff.index')
            ->with('success', 'Staff créé avec succès !');
    }

    public function index()
    {
        $journalistes = Staff::role('journalist')->get();

        return view('admin.index', compact('journalistes'));
    }
}
