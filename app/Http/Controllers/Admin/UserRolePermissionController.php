<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class UserRolePermissionController extends Controller
{
    public function index()
    {
        $users = User::all();
        $roles = Role::all();
        $permissions = Permission::all();

        return view('admin.user-role-permission.index', compact('users', 'roles', 'permissions'));
    }

    public function assignRole(Request $request, $userId)
    {
        $user = User::findOrFail($userId);

        $validated = $request->validate([
            'roles' => 'required|array',
            'roles.*' => 'exists:roles,id',
        ]);

        $user->syncRoles($validated['roles']);

        return redirect()->back()->with('success', 'Role(s) atribuída(s) com sucesso!');
    }

    public function assignPermission(Request $request, $userId)
    {
        $user = User::findOrFail($userId);

        $validated = $request->validate([
            'permissions' => 'required|array',
            'permissions.*' => 'exists:permissions,id',
        ]);

        $user->syncPermissions($validated['permissions']);

        return redirect()->back()->with('success', 'Permissão(ões) atribuída(s) com sucesso!');
    }
}
