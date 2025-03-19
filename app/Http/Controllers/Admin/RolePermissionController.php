<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Role;
use App\Models\Permission;
use Illuminate\Http\Request;

class RolePermissionController extends Controller
{
    public function assignPermission(Request $request, $roleId)
    {
        $role = Role::findOrFail($roleId); // Encontra o papel pelo ID
        $permission = Permission::findOrFail($request->permission_id); // Encontra a permissão pelo ID

        // Atribui a permissão ao papel
        $role->permissions()->attach($permission);
        return response()->json($role->permissions); // Retorna as permissões do papel
    }

    public function removePermission(Request $request, $roleId)
    {
        $role = Role::findOrFail($roleId); // Encontra o papel pelo ID
        $permission = Permission::findOrFail($request->permission_id); // Encontra a permissão pelo ID

        // Remove a permissão do papel
        $role->permissions()->detach($permission);
        return response()->json($role->permissions); // Retorna as permissões restantes do papel
    }
}
