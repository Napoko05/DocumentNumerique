<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Staff;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class CreateAdminSeeder extends Seeder
{
    public function run(): void
    {
        $guard = 'web';

        // =====================
        // PERMISSIONS
        // =====================
        $permissions = [
            'users.view',
            'users.create',
            'users.edit',
            'users.delete',
            'dashboard.view',
        ];

        foreach ($permissions as $permission) {

            Permission::firstOrCreate([
                'name' => $permission,
                'guard_name' => $guard,
            ]);
        }

        // =====================
        // ROLE ADMIN
        // =====================
        $adminRole = Role::firstOrCreate([
            'name' => 'admin',
            'guard_name' => $guard,
        ]);

        $adminRole->syncPermissions(Permission::all());

        // =====================
        // STAFF ADMIN
        // =====================
        $admin = Staff::updateOrCreate(
            [
                'email' => 'admin@system.com',
            ],
            [
                // identité
                'nom' => 'Admin',
                'prenom' => 'System',
                'sexe' => 'Masculin',
                'date_naissance' => '1990-01-01',
                'lieu_naissance' => 'Ouagadougou',

                // contact
                'email' => 'admin@system.com',
                'tel' => '70000000',

                // professionnel
                'matricule' => 'ADM0001',
                'service' => 'Administration centrale',
                'ville' => 'Ouagadougou',
                'specialite' => 'Administration système',

                // authentification
                'password' => Hash::make('Password1!'),

                // système alias
                'role_alias' => 'admin',
                'role_label' => 'Administrateur Système',

                // statut
                'is_active' => true,

                // documents
                'cnib_file' => null,
                'attestation_travail_file' => null,
                'diplome_file' => null,
                'signature_file' => null,
            ]
        );
        // =====================
        // ATTRIBUTION ROLE
        // =====================
        $admin->syncRoles([]);
        $admin->assignRole('admin');
    }
}
