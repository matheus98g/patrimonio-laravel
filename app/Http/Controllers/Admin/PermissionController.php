<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;

class PermissionController extends Controller
{
    // Método para exibir a lista de permissões
    public function index()
    {
        // Obtém todas as permissões
        $permissions = Permission::all();

        // Retorna a view com as permissões
        return view('admin.permissions.index', compact('permissions'));
    }

    // Método para exibir os detalhes de uma permissão
    public function show($permissionId)
    {
        // Encontra a permissão pelo ID
        $permission = Permission::findOrFail($permissionId);

        // Retorna a view com a permissão encontrada
        return view('admin.permissions.show', compact('permission'));
    }

    // Método para criar uma nova permissão
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|unique:permissions,name',
            'description' => 'nullable|string',
        ]);

        // Cria uma nova permissão
        Permission::create($request->all());

        // Redireciona para a lista de permissões
        return redirect()->route('permissions.index');
    }

    // Método para atualizar uma permissão existente
    public function update(Request $request, $permissionId)
    {
        $request->validate([
            'name' => 'required|string|unique:permissions,name,' . $permissionId,
            'description' => 'nullable|string',
        ]);

        // Encontra a permissão
        $permission = Permission::findOrFail($permissionId);

        // Atualiza a permissão com os novos dados
        $permission->update($request->all());

        // Redireciona de volta para a lista de permissões
        return redirect()->route('permissions.index');
    }

    // Método para excluir uma permissão
    public function destroy($permissionId)
    {
        // Encontra a permissão
        $permission = Permission::findOrFail($permissionId);

        // Exclui a permissão
        $permission->delete();

        // Redireciona de volta para a lista de permissões
        return redirect()->route('permissions.index');
    }
}