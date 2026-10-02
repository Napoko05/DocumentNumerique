<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class PermissionController extends Controller
{
    /**
     * Liste de toutes les permissions web + staff.
     */
    public function index()
    {
        $permissions = Permission::with('roles')
            ->whereIn('guard_name', ['web', 'staff'])
            ->orderBy('name')
            ->get();

        return view('permissions.index', compact('permissions'));
    }

    /**
     * Formulaire de création.
     */
    public function create()
    {
        // Afficher tous les rôles web + staff
        $roles = Role::whereIn('guard_name', ['web', 'staff'])
            ->orderBy('guard_name')
            ->orderBy('name')
            ->get();

        return view('permissions.create', compact('roles'));
    }

    /**
     * Création d'une permission.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => [
                'required',
                'string',
                'max:255',
                Rule::unique('permissions', 'name')
                    ->where(function ($query) use ($request) {
                        $role = Role::find($request->role_id);

                        if ($role) {
                            $query->where('guard_name', $role->guard_name);
                        }

                        return $query;
                    }),
            ],

            'role_id' => [
                'required',
                'integer',
                'exists:roles,id',
            ],
        ], [
            'name.required' => 'Le nom de la permission est obligatoire.',
            'name.unique' => 'Cette permission existe déjà pour ce guard.',
            'role_id.required' => 'Veuillez choisir un rôle.',
            'role_id.exists' => 'Le rôle sélectionné est invalide.',
        ]);

        /*
        |--------------------------------------------------------------------------
        | Récupérer le rôle sélectionné
        |--------------------------------------------------------------------------
        */

        $role = Role::whereIn('guard_name', ['web', 'staff'])
            ->findOrFail($request->role_id);

        /*
        |--------------------------------------------------------------------------
        | Créer la permission avec le même guard que le rôle
        |--------------------------------------------------------------------------
        */

        $permission = Permission::create([
            'name' => $request->name,
            'guard_name' => $role->guard_name,
        ]);

        /*
        |--------------------------------------------------------------------------
        | Attribuer la permission au rôle
        |--------------------------------------------------------------------------
        */

        $role->givePermissionTo($permission);

        return redirect()
            ->route('admin.permissions.index')
            ->with(
                'success',
                'Permission créée et attribuée au rôle avec succès.'
            );
    }

    /**
     * Formulaire de modification.
     */
    public function edit($id)
    {
        /*
        |--------------------------------------------------------------------------
        | Permission web ou staff
        |--------------------------------------------------------------------------
        */

        $permission = Permission::with('roles')
            ->whereIn('guard_name', ['web', 'staff'])
            ->findOrFail($id);

        /*
        |--------------------------------------------------------------------------
        | Tous les rôles web + staff
        |--------------------------------------------------------------------------
        */

        $roles = Role::whereIn('guard_name', ['web', 'staff'])
            ->orderBy('guard_name')
            ->orderBy('name')
            ->get();

        /*
        |--------------------------------------------------------------------------
        | Rôle actuellement associé à la permission
        |--------------------------------------------------------------------------
        */

        $currentRole = $permission->roles
            ->whereIn('guard_name', ['web', 'staff'])
            ->first();

        return view(
            'permissions.edit',
            compact(
                'permission',
                'roles',
                'currentRole'
            )
        );
    }

    /**
     * Modification de la permission.
     */
    public function update(Request $request, $id)
    {
        /*
        |--------------------------------------------------------------------------
        | Récupérer la permission web ou staff
        |--------------------------------------------------------------------------
        */

        $permission = Permission::whereIn('guard_name', ['web', 'staff'])
            ->findOrFail($id);

        /*
        |--------------------------------------------------------------------------
        | Validation du rôle
        |--------------------------------------------------------------------------
        */

        $request->validate([
            'name' => [
                'required',
                'string',
                'max:255',
                Rule::unique('permissions', 'name')
                    ->where(function ($query) use ($request) {
                        $role = Role::find($request->role_id);

                        if ($role) {
                            $query->where('guard_name', $role->guard_name);
                        }

                        return $query;
                    })
                    ->ignore($permission->id),
            ],

            'role_id' => [
                'required',
                'integer',
                'exists:roles,id',
            ],
        ], [
            'name.required' => 'Le nom de la permission est obligatoire.',
            'name.unique' => 'Cette permission existe déjà pour ce guard.',
            'role_id.required' => 'Veuillez choisir un rôle.',
            'role_id.exists' => 'Le rôle sélectionné est invalide.',
        ]);

        /*
        |--------------------------------------------------------------------------
        | Récupérer le nouveau rôle
        |--------------------------------------------------------------------------
        */

        $role = Role::whereIn('guard_name', ['web', 'staff'])
            ->findOrFail($request->role_id);

        /*
        |--------------------------------------------------------------------------
        | Supprimer les anciennes associations
        |--------------------------------------------------------------------------
        */

        $permission->syncRoles([]);

        /*
        |--------------------------------------------------------------------------
        | Si le guard change
        |--------------------------------------------------------------------------
        |
        | Exemple :
        | Permission staff -> rôle web
        |
        */

        if ($permission->guard_name !== $role->guard_name) {
            $permission->guard_name = $role->guard_name;
            $permission->save();

            // Recharger le modèle avec son nouveau guard
            $permission->refresh();
        }

        /*
        |--------------------------------------------------------------------------
        | Modifier le nom
        |--------------------------------------------------------------------------
        */

        $permission->name = $request->name;
        $permission->save();

        /*
        |--------------------------------------------------------------------------
        | Attribuer la permission au nouveau rôle
        |--------------------------------------------------------------------------
        */

        $role->givePermissionTo($permission);

        return redirect()
            ->route('admin.permissions.index')
            ->with(
                'success',
                'Permission modifiée avec succès.'
            );
    }

    /**
     * Suppression d'une permission.
     */
    public function destroy($id)
    {
        /*
        |--------------------------------------------------------------------------
        | Permission web ou staff
        |--------------------------------------------------------------------------
        */

        $permission = Permission::whereIn('guard_name', ['web', 'staff'])
            ->findOrFail($id);

        /*
        |--------------------------------------------------------------------------
        | Retirer les associations avec les rôles
        |--------------------------------------------------------------------------
        */

        $permission->syncRoles([]);

        /*
        |--------------------------------------------------------------------------
        | Supprimer la permission
        |--------------------------------------------------------------------------
        */

        $permission->delete();

        return redirect()
            ->route('admin.permissions.index')
            ->with(
                'success',
                'Permission supprimée avec succès.'
            );
    }
}