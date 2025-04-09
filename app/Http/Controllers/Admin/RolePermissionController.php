<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RolePermissionController extends Controller
{
    // === ROLES ===

    // public function indexRoles()
    // {
    //     $roles = Role::all();
    //     return view('admin.roles.index', compact('roles'));
    // }

    public function indexRoles(Request $request)
    {
        $search = $request->input('search');

        $roles = Role::with('permissions')
            ->when($search, function ($query, $search) {
                $query->where('name', 'like', '%' . $search . '%')
                    ->orWhereHas('permissions', function ($q) use ($search) {
                        $q->where('name', 'like', '%' . $search . '%');
                    });
            })
            ->get();

        return view('admin.roles.index', compact('roles', 'search'));
    }



    public function createRole()
    {
        $permissions = Permission::all();
        return view('admin.roles.create', compact('permissions'));
    }

    public function storeRole(Request $request)
    {
        $request->validate([
            'name' => 'required|unique:roles,name',
            'permissions' => 'array',
        ]);

        $role = Role::create(['name' => $request->name]);

        // if ($request->has('permissions')) {
        //     $role->syncPermissions($request->permissions);
        // }

        if ($request->has('permissions')) {
            $permissionIds = $request->permissions;
            $permissionNames = Permission::whereIn('id', $permissionIds)->pluck('name')->toArray();
            $role->syncPermissions($permissionNames);
        }

        return redirect()->route('admin.roles.index')->with('success', 'Cargo criado com sucesso.');
    }

    public function editRole(Role $role)
    {
        $permissions = Permission::all();
        return view('admin.roles.edit', compact('role', 'permissions'));
    }

    public function updateRole(Request $request, Role $role)
    {
        $request->validate([
            'name' => 'required|unique:roles,name,' . $role->id,
            'permissions' => 'array',
        ]);

        $role->update(['name' => $request->name]);

        // if ($request->has('permissions')) {
        //     $role->syncPermissions($request->permissions);
        // }

        if ($request->has('permissions')) {
            $permissionIds = $request->permissions;
            $permissionNames = Permission::whereIn('id', $permissionIds)->pluck('name')->toArray();
            $role->syncPermissions($permissionNames);
        }

        return redirect()->route('admin.roles.index')->with('success', 'Cargo atualizado com sucesso.');
    }

    public function destroyRole(Role $role)
    {
        $role->delete();
        return redirect()->route('admin.roles.index')->with('success', 'Cargo removido com sucesso.');
    }

    // === PERMISSIONS ===

    // public function indexPermissions()
    // {
    //     $permissions = Permission::all();
    //     return view('admin.permissions.index', compact('permissions'));
    // }

    public function indexPermissions(Request $request)
    {
        $search = $request->input('search');

        $permissions = Permission::with('roles')
            ->when($search, function ($query, $search) {
                $query->where('name', 'like', '%' . $search . '%')
                    ->orWhereHas('roles', function ($q) use ($search) {
                        $q->where('name', 'like', '%' . $search . '%');
                    });
            })
            ->get();

        return view('admin.permissions.index', compact('permissions', 'search'));
    }



    public function createPermission()
    {
        return view('admin.permissions.create');
    }

    public function storePermission(Request $request)
    {
        $request->validate(['name' => 'required|unique:permissions,name']);
        Permission::create(['name' => $request->name]);
        return redirect()->route('admin.permissions.index')->with('success', 'Permissão criada com sucesso.');
    }

    // public function showPermission(Permission $permission)
    // {
    //     return view('admin.permissions.show', compact('permission'));
    // }

    public function editPermission(Permission $permission)
    {
        return view('admin.permissions.edit', compact('permission'));
    }

    public function updatePermission(Request $request, Permission $permission)
    {
        $request->validate(['name' => 'required|unique:permissions,name,' . $permission->id]);
        $permission->update(['name' => $request->name]);
        return redirect()->route('admin.permissions.index')->with('success', 'Permissão atualizada com sucesso.');
    }

    public function destroyPermission(Permission $permission)
    {
        $permission->delete();
        return redirect()->route('admin.permissions.index')->with('success', 'Permissão removida com sucesso.');
    }
}
