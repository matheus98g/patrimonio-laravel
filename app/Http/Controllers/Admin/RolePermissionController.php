<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Http\Request;

class RolePermissionController extends Controller
{
    public function assignPermission(Request $request, $roleId)
    {
        $role = Role::findOrFail($roleId);
        $permission = Permission::findOrFail($request->permission_id); 

        $role->permissions()->attach($permission);
        return response()->json($role->permissions);
    }

    public function removePermission(Request $request, $roleId)
    {
        $role = Role::findOrFail($roleId);
        $permission = Permission::findOrFail($request->permission_id);

        $role->permissions()->detach($permission);
        return response()->json($role->permissions);
    }
}
