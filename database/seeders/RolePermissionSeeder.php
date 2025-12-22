<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RolePermissionSeeder extends Seeder
{
    public function run()
    {
        $guard = 'web';

        // Permissions Admin
        $adminPermissions = [
            'manage users',
            'manage journalists',
            'manage documents',
            'manage payments',
            'approve publications',
            'view reports',
        ];

        // Permissions Journaliste
        $journalistPermissions = [
            'publish documents',
            'edit own documents',
            'delete own documents',
            'publish articles',
            'edit own articles',
            'delete own articles',
            'set document access',
        ];

        // Permissions Utilisateur
        $userPermissions = [
            'read free documents',
            'buy documents',
            'download purchased documents',
        ];

        // Création des permissions avec guard
        foreach (array_merge($adminPermissions, $journalistPermissions, $userPermissions) as $perm) {
            Permission::firstOrCreate([
                'name' => $perm,
                'guard_name' => $guard
            ]);
        }

        // Création des rôles avec guard
        $admin = Role::firstOrCreate([
            'name' => 'admin',
            'guard_name' => $guard
        ]);

        $journalist = Role::firstOrCreate([
            'name' => 'journalist',
            'guard_name' => $guard
        ]);

        $user = Role::firstOrCreate([
            'name' => 'user',
            'guard_name' => $guard
        ]);

        // Reset + attribution propre
        $admin->syncPermissions($adminPermissions);
        $journalist->syncPermissions($journalistPermissions);
        $user->syncPermissions($userPermissions);
    }
}
