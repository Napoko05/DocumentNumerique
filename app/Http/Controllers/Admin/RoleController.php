<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RoleController extends Controller
{
    /**
     * Liste des rôles web + staff.
     */
    public function index()
    {
        $roles = Role::with('permissions')
            ->whereIn('guard_name', ['web', 'staff'])
            ->orderBy('guard_name')
            ->orderBy('name')
            ->get();

        return view('role.index', compact('roles'));
    }

    /**
     * Formulaire de création d'un rôle.
     */
    public function create()
    {
        $permissions = Permission::whereIn('guard_name', ['web', 'staff'])
            ->orderBy('guard_name')
            ->orderBy('name')
            ->get();

        return view('role.create', compact('permissions'));
    }

    /**
     * Création d'un rôle.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => [
                'required',
                'string',
                'max:255',
            ],

            'guard_name' => [
                'required',
                'in:web,staff',
            ],

            'permissions' => [
                'nullable',
                'array',
            ],

            'permissions.*' => [
                'string',
            ],
        ]);

        /*
        |--------------------------------------------------------------------------
        | Vérifier que le nom n'existe pas déjà pour ce guard
        |--------------------------------------------------------------------------
        */
        $exists = Role::where('name', $validated['name'])
            ->where('guard_name', $validated['guard_name'])
            ->exists();

        if ($exists) {
            return back()
                ->withInput()
                ->withErrors([
                    'name' => 'Ce rôle existe déjà pour ce guard.',
                ]);
        }

        /*
        |--------------------------------------------------------------------------
        | Création du rôle
        |--------------------------------------------------------------------------
        */
        $role = Role::create([
            'name' => $validated['name'],
            'guard_name' => $validated['guard_name'],
        ]);

        /*
        |--------------------------------------------------------------------------
        | Permissions compatibles avec le guard du rôle
        |--------------------------------------------------------------------------
        */
        $permissionNames = $request->input('permissions', []);

        if (!empty($permissionNames)) {
            $permissions = Permission::whereIn('name', $permissionNames)
                ->where('guard_name', $role->guard_name)
                ->get();

            $role->syncPermissions($permissions);
        }

        return redirect()
            ->route('admin.roles.index')
            ->with('success', 'Rôle créé avec succès.');
    }

    /**
     * Formulaire de modification d'un rôle.
     */
    public function edit($id)
    {
        $role = Role::whereIn('guard_name', ['web', 'staff'])
            ->findOrFail($id);

        /*
        |--------------------------------------------------------------------------
        | On affiche uniquement les permissions du même guard
        |--------------------------------------------------------------------------
        */
        $permissions = Permission::where(
                'guard_name',
                $role->guard_name
            )
            ->orderBy('name')
            ->get();

        return view(
            'role.edit',
            compact('role', 'permissions')
        );
    }

    /**
     * Modification d'un rôle.
     */
    public function update(Request $request, $id)
    {
        $role = Role::whereIn('guard_name', ['web', 'staff'])
            ->findOrFail($id);

        $request->validate([
            'name' => [
                'required',
                'string',
                'max:255',

                Rule::unique('roles', 'name')
                    ->where(function ($query) use ($role) {
                        return $query->where(
                            'guard_name',
                            $role->guard_name
                        );
                    })
                    ->ignore($role->id),
            ],

            'permissions' => [
                'nullable',
                'array',
            ],

            'permissions.*' => [
                'string',
            ],
        ], [
            'name.required' => 'Le nom du rôle est obligatoire.',
            'name.unique' => 'Ce rôle existe déjà pour ce guard.',
        ]);

        /*
        |--------------------------------------------------------------------------
        | Modifier le nom
        |--------------------------------------------------------------------------
        */
        $role->update([
            'name' => $request->name,
        ]);

        /*
        |--------------------------------------------------------------------------
        | Récupérer les permissions sélectionnées
        | uniquement pour le même guard
        |--------------------------------------------------------------------------
        */
        $permissionNames = $request->input('permissions', []);

        $permissions = Permission::whereIn(
                'name',
                $permissionNames
            )
            ->where(
                'guard_name',
                $role->guard_name
            )
            ->get();

        /*
        |--------------------------------------------------------------------------
        | Synchroniser les permissions
        |--------------------------------------------------------------------------
        */
        $role->syncPermissions($permissions);

        return redirect()
            ->route('admin.roles.index')
            ->with(
                'success',
                'Rôle modifié avec succès.'
            );
    }

    /**
     * Suppression d'un rôle.
     */
    public function destroy($id)
    {
        $role = Role::whereIn('guard_name', ['web', 'staff'])
            ->findOrFail($id);

        $role->delete();

        return redirect()
            ->route('admin.roles.index')
            ->with(
                'success',
                'Rôle supprimé avec succès.'
            );
    }
}