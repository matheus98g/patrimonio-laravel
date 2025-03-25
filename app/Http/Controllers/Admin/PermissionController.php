<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;

class PermissionController extends Controller
{
    public function index()
    {
        $permissions = Permission::all();
        return view('admin.permissions.index', compact('permissions'));
    }

    public function show($permissionId)
    {
        $permission = Permission::findOrFail($permissionId);
        return view('admin.permissions.show', compact('permission'));
    }

    public function create()
    {
        return view('admin.permissions.create');
    }

    public function store(Request $request)
    {
        // Validação dos dados
        $request->validate([
            'permissions' => 'required|string',
        ]);

        // Separando as permissões por vírgula
        $permissions = explode(',', $request->permissions);

        // Criando as permissões no banco
        foreach ($permissions as $permission) {
            Permission::create([
                'name' => trim($permission),
            ]);
        }

        // Redirecionando de volta para a lista de permissões com uma mensagem de sucesso
        return redirect()->route('admin.permissions.index')->with('success', 'Permissões criadas com sucesso!');
    }


    public function update(Request $request, $permissionId)
    {
        $request->validate([
            'name' => 'required|string|unique:permissions,name,' . $permissionId,
            'description' => 'nullable|string',
        ]);

        $permission = Permission::findOrFail($permissionId);
        $permission->update($request->all());

        return redirect()->route('admin.permissions.index');
    }

    public function destroy($permissionId)
    {
        $permission = Permission::findOrFail($permissionId);

        $permission->users()->detach();

        $permission->delete();

        return redirect()->route('admin.permissions.index');
    }

}
