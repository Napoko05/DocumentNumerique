<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RolePermissionSeeder extends Seeder
{
    public function run()
    {
        // =========================
        // GUARDS
        // =========================
        $staffGuard = 'staff';
        $webGuard = 'web';

        // =========================
        // PERMISSIONS STAFF (BACKOFFICE)
        // =========================
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
            'manage.documents',
            'manage.payments',
            'approve.publications',
            'view.reports',
            ' formation.create',
            'formation.edit',
            'formation.delete',

            'filiere.create',
            'filiere.edit',
            'filiere.delete',
            'level.create',
            'level.edit',
            'level.delete',

            'subject.create',
            'subject.edit',
            'subject.delete',
        ];

        $journalistPermissions = [
            'documents.create',
            'documents.publish',
            'documents.edit.own',
            'documents.delete.own',
            'documents.schedule',
            'documents.set.premium',
            'documents.stats.view',
            'documents.views.track',
            'documents.engagement.view',
        ];

        // =========================
        // PERMISSIONS WEB (USER NORMAL)
        // =========================
        $userPermissions = [
            'documents.free',
            'documents.premium',
            'documents.download.purchased',
        ];

        // =========================
        // CREATE STAFF PERMISSIONS
        // =========================
        foreach (array_merge($adminPermissions, $journalistPermissions) as $perm) {
            Permission::firstOrCreate([
                'name' => $perm,
                'guard_name' => $staffGuard
            ]);
        }

        // =========================
        // CREATE WEB PERMISSIONS
        // =========================
        foreach ($userPermissions as $perm) {
            Permission::firstOrCreate([
                'name' => $perm,
                'guard_name' => $webGuard
            ]);
        }

        // =========================
        // ROLES STAFF
        // =========================
        $superAdmin = Role::firstOrCreate([
            'name' => 'super_admin',
            'guard_name' => $staffGuard
        ]);

        $admin = Role::firstOrCreate([
            'name' => 'admin',
            'guard_name' => $staffGuard
        ]);

        $journalist = Role::firstOrCreate([
            'name' => 'journalist',
            'guard_name' => $staffGuard
        ]);

        // =========================
        // ROLE WEB (USER PUBLIC)
        // =========================
        $user = Role::firstOrCreate([
            'name' => 'user',
            'guard_name' => $webGuard
        ]);

        // =========================
        // ASSIGN PERMISSIONS (SAFE)
        // =========================
        $admin->syncPermissions(
            Permission::where('guard_name', $staffGuard)
                ->whereIn('name', $adminPermissions)
                ->get()
        );

        $journalist->syncPermissions(
            Permission::where('guard_name', $staffGuard)
                ->whereIn('name', $journalistPermissions)
                ->get()
        );

        $superAdmin->syncPermissions(
            Permission::where('guard_name', $staffGuard)->get()
        );

        $user->syncPermissions(
            Permission::where('guard_name', $webGuard)
                ->whereIn('name', $userPermissions)
                ->get()
        );
    }
}
