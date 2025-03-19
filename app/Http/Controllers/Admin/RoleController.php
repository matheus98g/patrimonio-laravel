<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Role;
use Illuminate\Http\Request;

class RoleController extends Controller
{
    public function index()
    {
        $roles = Role::all(); // Obter todos os papéis
        return response()->json($roles); // Retorna todos os papéis
    }

    public function show($roleId)
    {
        $role = Role::findOrFail($roleId); // Encontra o papel pelo ID
        return response()->json($role); // Retorna o papel específico
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        $role = Role::create($request->all()); // Cria um novo papel
        return response()->json($role, 201); // Retorna o papel recém-criado
    }

    public function update(Request $request, $roleId)
    {
        $role = Role::findOrFail($roleId); // Encontra o papel pelo ID

        $role->update($request->all()); // Atualiza o papel com os dados recebidos
        return response()->json($role); // Retorna o papel atualizado
    }

    public function destroy($roleId)
    {
        $role = Role::findOrFail($roleId); // Encontra o papel pelo ID

        $role->delete(); // Deleta o papel
        return response()->json(null, 204); // Retorna uma resposta sem conteúdo (204)
    }
}

