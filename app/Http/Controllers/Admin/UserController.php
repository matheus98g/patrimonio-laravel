<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Facades\Log;
use Exception;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;

class UserController extends Controller
{


    public function index()
    {
        $usuarios = User::with(['roles', 'permissions'])->get();
        
        return view('admin.users.index', compact('usuarios'));
    }

    public function edit($id)
    {
        $usuario = User::findOrFail($id);
        
        $roles = Role::all();
        $permissions = Permission::all();
        
        return view('admin.users.edit', compact('usuario', 'roles', 'permissions'));
    }

    public function update(Request $request, $id)
    {
        try {
            $usuario = User::findOrFail($id);

            $request->validate([
                'roles' => 'array|exists:roles,name',
                'permissions' => 'array|exists:permissions,id',
            ]);

            Log::info('Iniciando a atualização de acessos do usuário', ['user_id' => $usuario->id]);

            $usuario->syncRoles($request->input('roles', []));
            Log::info('Cargos sincronizados com sucesso', ['user_id' => $usuario->id, 'roles' => $request->input('roles', [])]);

            $permissionIds = $request->input('permissions', []);
            $permissionNames = Permission::whereIn('id', $permissionIds)->pluck('name')->toArray();
            $usuario->syncPermissions($permissionNames);
            Log::info('Permissões sincronizadas com sucesso', ['user_id' => $usuario->id, 'permissions' => $permissionNames]);

            return redirect()->route('admin.users.index')->with('success', 'Acessos do usuário atualizados com sucesso!');
        } catch (Exception $e) {
            Log::error('Erro ao atualizar acessos do usuário', [
                'user_id' => $id,
                'error_message' => $e->getMessage(),
                'stack_trace' => $e->getTraceAsString()
            ]);

            return redirect()->route('admin.users.index')->with('error', 'Ocorreu um erro ao atualizar os acessos do usuário. Tente novamente mais tarde.');
        }
    }

    public function createUser(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        $role = Role::where('name', 'aluno')->first();
        $user->assignRole($role);

        event(new Registered($user));

        return redirect(route('admin.users.index', absolute: false));
    }







}
