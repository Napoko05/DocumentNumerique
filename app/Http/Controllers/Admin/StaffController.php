<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Staff;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
use Spatie\Permission\Models\Role;

class StaffController extends Controller
{
    /**
     * STEP 1 - FORM CREATE STAFF
     */
    public function create()
    {
        return view('admin.create_agent_step1');
    }

    /**
     * STEP 1 - VALIDATION STAFF
     */
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
            'num_cnib' => 'nullable|string|max:30',
            'ville' => 'nullable|string|max:255',
            'password' => 'required|string|min:8|confirmed',
        ]);

        $files = [];

        $fileFields = [
            'cnib_file',
            'attestation_travail_file',
            'diplome_file',
            'signature_file',
        ];

        foreach ($fileFields as $file) {
            if ($request->hasFile($file)) {
                $files[$file] = $request->file($file)
                    ->store('staff_temp', 'public');
            }
        }

        session([
            'staff_data' => $validated,
            'staff_files' => $files,
        ]);

        return redirect()->route('admin.staff.step2.view');
    }

    /**
     * STEP 2 - RECAP
     */
    public function step2View()
    {
        if (!session()->has('staff_data')) {
            return redirect()->route('admin.staff.create');
        }

        $data = session('staff_data');
        $files = session('staff_files', []);

        $roles = Role::whereIn('name', [
            'admin',
            'journalist',
        ])->get();

        return view(
            'admin.create_agent_step2',
            compact('data', 'files', 'roles')
        );
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

        $staff = Staff::create([
            'user_id' => auth()->id(),

            'nom' => $data['nom'],
            'prenom' => $data['prenom'],
            'sexe' => $data['sexe'],
            'date_naissance' => $data['date_naissance'],
            'lieu_naissance' => $data['lieu_naissance'],

            'num_cnib' => $data['num_cnib'] ?? null,

            'matricule' => $data['matricule'],
            'email' => $data['email'],

            'tel' => $data['tel'] ?? null,
            'ville' => $data['ville'] ?? null,

            'service' => $data['service'],
            'specialite' => $data['specialite'] ?? null,

            'password' => Hash::make($data['password']),

            'role_alias' => $request->role_alias ?? 'journalist',
            'role_label' => $request->role_label ?? 'Journaliste',

            'is_active' => 1,
        ]);

        $staff->assignRole(
            $request->role ?? 'journalist'
        );

        $finalFiles = [];

        $fileMap = [
            'cnib_file',
            'attestation_travail_file',
            'diplome_file',
            'signature_file',
        ];

        foreach ($fileMap as $field) {

            if ($request->hasFile($field)) {

                $path = $request->file($field)
                    ->store("staff/$field", 'public');

                $finalFiles[$field] = $path;

            } elseif (!empty($sessionFiles[$field])) {

                $tempPath = $sessionFiles[$field];

                if (Storage::disk('public')->exists($tempPath)) {

                    $newPath = "staff/$field/" . basename($tempPath);

                    Storage::disk('public')->move(
                        $tempPath,
                        $newPath
                    );

                    $finalFiles[$field] = $newPath;
                }
            }
        }

        if (!empty($finalFiles)) {
            $staff->update($finalFiles);
        }

        session()->forget([
            'staff_data',
            'staff_files',
        ]);

        return redirect()
            ->route('admin.staff.index')
            ->with(
                'success',
                'Staff créé avec succès !'
            );
    }

    /**
     * LISTE DES JOURNALISTES
     */
    public function index()
    {
        $journalistes = Staff::role('journalist')
            ->latest()
            ->get();

        return view(
            'admin.journaliste_liste',
            compact('journalistes')
        );
    }

    /**
     * FORMULAIRE MODIFICATION PROFIL
     *
     * L'admin utilise directement le layout admin.
     */
    public function edit(Staff $journaliste)
    {
        return view(
            'admin.edit_journaliste',
            compact('journaliste')
        );
    }

    /**
     * MODIFICATION DU PROFIL
     */
    public function update(
        Request $request,
        Staff $journaliste
    ) {
        $validated = $request->validate([
            'nom' => [
                'required',
                'string',
                'max:100',
            ],

            'prenom' => [
                'required',
                'string',
                'max:100',
            ],

            'sexe' => [
                'required',
                'in:Masculin,Féminin',
            ],

            'date_naissance' => [
                'nullable',
                'date',
            ],

            'lieu_naissance' => [
                'nullable',
                'string',
                'max:150',
            ],

            'email' => [
                'required',
                'email',
                'max:255',
                Rule::unique('staff', 'email')
                    ->ignore($journaliste->id),
            ],

            'tel' => [
                'nullable',
                'string',
                'max:30',
            ],

            'ville' => [
                'nullable',
                'string',
                'max:100',
            ],
        ]);

        $journaliste->update($validated);

        return redirect()
            ->route(
                'admin.staff.journalistes.edit',
                $journaliste
            )
            ->with(
                'success',
                'Profil du journaliste modifié avec succès.'
            );
    }

    /**
     * MODIFICATION DU MOT DE PASSE
     */
    public function updatePassword(
        Request $request,
        Staff $journaliste
    ) {
        $validated = $request->validate([
            'password' => [
                'required',
                'string',
                'min:8',
                'confirmed',
            ],
        ]);

        $journaliste->update([
            'password' => Hash::make(
                $validated['password']
            ),
        ]);

        return redirect()
            ->route(
                'admin.staff.journalistes.edit',
                $journaliste
            )
            ->with(
                'success',
                'Mot de passe du journaliste modifié avec succès.'
            );
    }

    /**
     * SUPPRESSION DU JOURNALISTE
     */
    public function destroy(Staff $journaliste)
    {
        /*
         * Suppression des fichiers associés.
         */
        $fileFields = [
            'cnib_file',
            'attestation_travail_file',
            'diplome_file',
            'signature_file',
        ];

        foreach ($fileFields as $field) {

            if (
                !empty($journaliste->$field) &&
                Storage::disk('public')->exists(
                    $journaliste->$field
                )
            ) {
                Storage::disk('public')->delete(
                    $journaliste->$field
                );
            }
        }

        /*
         * Suppression du rôle Spatie.
         */
        $journaliste->removeRole('journalist');

        /*
         * Suppression du staff.
         */
        $journaliste->delete();

        return redirect()
            ->route('admin.staff.index')
            ->with(
                'success',
                'Le journaliste a été supprimé avec succès.'
            );
    }
}