<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Spatie\Permission\PermissionRegistrar;

class RolePermissionSeeder extends Seeder
{
    public function run(): void
    {
        /*
        |--------------------------------------------------------------------------
        | VIDER LE CACHE SPATIE
        |--------------------------------------------------------------------------
        */
        app(PermissionRegistrar::class)
            ->forgetCachedPermissions();

        /*
        |--------------------------------------------------------------------------
        | GUARDS
        |--------------------------------------------------------------------------
        */
        $staffGuard = 'staff';

        $webGuard = 'web';

        /*
        |--------------------------------------------------------------------------
        | PERMISSIONS ADMIN
        |--------------------------------------------------------------------------
        */

        $adminPermissions = [

            /*
            |--------------------------------------------------------------------------
            | UTILISATEURS
            |--------------------------------------------------------------------------
            */
            'users.view',
            'users.create',
            'users.edit',
            'users.delete',

            'users.block',
            'users.unblock',

            'users.assign.roles',

            'users.activity.view',

            /*
            |--------------------------------------------------------------------------
            | TABLEAU DE BORD
            |--------------------------------------------------------------------------
            */
            'dashboard.view',

            /*
            |--------------------------------------------------------------------------
            | RAPPORTS
            |--------------------------------------------------------------------------
            */

            'reports.users',

            'reports.documents',

            'reports.revenue',

            'view.reports',

            /*
            |--------------------------------------------------------------------------
            | JOURNAUX
            |--------------------------------------------------------------------------
            */
            'logs.system.view',

            /*
            |--------------------------------------------------------------------------
            | DOCUMENTS
            |--------------------------------------------------------------------------
            */
            'manage.documents',

            'approve.publications',

            /*
            |--------------------------------------------------------------------------
            | PAIEMENTS
            |--------------------------------------------------------------------------
            */
            'manage.payments',

            /*
            |--------------------------------------------------------------------------
            | FORMATIONS
            |--------------------------------------------------------------------------
            */
            'formation.create',

            'formation.edit',

            'formation.delete',

            /*
            |--------------------------------------------------------------------------
            | FILIÈRES
            |--------------------------------------------------------------------------
            */

            'filiere.create',

            'filiere.edit',

            'filiere.delete',

            /*
            |--------------------------------------------------------------------------
            | NIVEAUX
            |--------------------------------------------------------------------------
            */

            'level.create',

            'level.edit',

            'level.delete',

            /*
            |--------------------------------------------------------------------------
            | MATIÈRES / MODULES
            |--------------------------------------------------------------------------
            */

            'subject.create',

            'subject.edit',

            'subject.delete',

        ];
        /*
        |--------------------------------------------------------------------------
        | PERMISSIONS JOURNALISTE
        |--------------------------------------------------------------------------
        */
        $journalistPermissions = [

            /*
            |--------------------------------------------------------------------------
            | DOCUMENTS
            |--------------------------------------------------------------------------
            */
            'documents.create',

            'documents.publish',

            'documents.edit.own',

            'documents.delete.own',

            'documents.schedule',

            'documents.set.premium',
            /*
            |--------------------------------------------------------------------------
            | STATISTIQUES
            |--------------------------------------------------------------------------
            */

            'documents.stats.view',

            'documents.views.track',

            'documents.engagement.view',

        ];
        /*
        |--------------------------------------------------------------------------
        | PERMISSIONS UTILISATEUR PUBLIC
        |--------------------------------------------------------------------------
        */

        $userPermissions = [

            'documents.free',

            'documents.premium',

            'documents.download.purchased',

        ];
        /*
        |--------------------------------------------------------------------------
        | CRÉATION DES PERMISSIONS STAFF
        |--------------------------------------------------------------------------
        */
        foreach (
            array_unique(
                array_merge(
                    $adminPermissions,
                    $journalistPermissions
                )
            ) as $permission
        ) {

            Permission::firstOrCreate([

                'name' => trim($permission),

                'guard_name' => $staffGuard,

            ]);
        }

        /*
        |--------------------------------------------------------------------------
        | CRÉATION DES PERMISSIONS WEB
        |--------------------------------------------------------------------------
        */

        foreach ($userPermissions as $permission) {

            Permission::firstOrCreate([

                'name' => trim($permission),

                'guard_name' => $webGuard,

            ]);

        }


        /*
        |--------------------------------------------------------------------------
        | CRÉATION DES RÔLES STAFF
        |--------------------------------------------------------------------------
        */

        $superAdmin = Role::firstOrCreate([

            'name' => 'super_admin',

            'guard_name' => $staffGuard,

        ]);


        $admin = Role::firstOrCreate([

            'name' => 'admin',

            'guard_name' => $staffGuard,

        ]);


        $journalist = Role::firstOrCreate([

            'name' => 'journalist',

            'guard_name' => $staffGuard,

        ]);


        /*
        |--------------------------------------------------------------------------
        | CRÉATION DU RÔLE UTILISATEUR PUBLIC
        |--------------------------------------------------------------------------
        */

        $user = Role::firstOrCreate([

            'name' => 'user',

            'guard_name' => $webGuard,

        ]);


        /*
        |--------------------------------------------------------------------------
        | ATTRIBUTION DES PERMISSIONS ADMIN
        |--------------------------------------------------------------------------
        */

        $admin->syncPermissions(

            Permission::query()

                ->where(
                    'guard_name',
                    $staffGuard
                )

                ->whereIn(
                    'name',
                    array_map(
                        'trim',
                        $adminPermissions
                    )
                )

                ->get()

        );


        /*
        |--------------------------------------------------------------------------
        | ATTRIBUTION DES PERMISSIONS JOURNALISTE
        |--------------------------------------------------------------------------
        */

        $journalist->syncPermissions(

            Permission::query()

                ->where(
                    'guard_name',
                    $staffGuard
                )

                ->whereIn(
                    'name',
                    array_map(
                        'trim',
                        $journalistPermissions
                    )
                )

                ->get()

        );


        /*
        |--------------------------------------------------------------------------
        | SUPER ADMIN
        |--------------------------------------------------------------------------
        |
        | Le Super Administrateur reçoit toutes les
        | permissions du guard staff.
        |
        */

        $superAdmin->syncPermissions(

            Permission::query()

                ->where(
                    'guard_name',
                    $staffGuard
                )

                ->get()

        );


        /*
        |--------------------------------------------------------------------------
        | UTILISATEUR PUBLIC
        |--------------------------------------------------------------------------
        */

        $user->syncPermissions(

            Permission::query()

                ->where(
                    'guard_name',
                    $webGuard
                )

                ->whereIn(
                    'name',
                    $userPermissions
                )

                ->get()

        );


        /*
        |--------------------------------------------------------------------------
        | VIDER À NOUVEAU LE CACHE
        |--------------------------------------------------------------------------
        */

        app(PermissionRegistrar::class)
            ->forgetCachedPermissions();

    }
}
