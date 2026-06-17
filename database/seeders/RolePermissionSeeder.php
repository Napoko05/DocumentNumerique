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
            'users.view',
            'users.create',
            'users.edit',
            'users.delete',
            'users.block',
            'users.unblock',
            'users.assign.roles',
            'users.activity.view',
            'dashboard.view',
            'reports.users',
            'reports.documents',
            'reports.revenue',
            'logs.system.view',
            'mjournalists',
            'manage.documents',
            'manage.payments',
            'approve.publications',
            'view.reports',
        ];

        // Permissions Journaliste
        $journalistPermissions = [
            'documents.create',
            'documents.publish',
            'documents.edit.own',
            'documents.delete.own',
            'documents.schedule',
            'documents.set.premium',
            'documents.stats.view',
            'documents.stats.view',
            'documents.views.track',
            'documents.engagement.view',
        ];

        // Permissions Utilisateur
        $userPermissions = [
            'documents.free',
            'documents.premium',
            'documents.download.purchased',
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
