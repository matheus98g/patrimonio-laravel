<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Spatie\Permission\Models\Role;
use Illuminate\Http\Request;

class RoleController extends Controller
{
    public function index()
    {
        $roles = Role::all();
        return response()->json($roles);
    }

    public function show($roleId)
    {
        $role = Role::findOrFail($roleId);
        return response()->json($role);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        $role = Role::create($request->all());
        return response()->json($role, 201);
    }

    public function update(Request $request, $roleId)
    {
        $role = Role::findOrFail($roleId);
        $role->update($request->all());
        return response()->json($role);
    }

    public function destroy($roleId)
    {
        $role = Role::findOrFail($roleId);
        $role->delete();
        return response()->json(null, 204);
    }

    public function createAlunoRole()
    {
        $role = Role::firstOrCreate([
            'name' => 'aluno',
        ], [
            'description' => 'Role for students',
        ]);
        return response()->json($role);
    }
}
