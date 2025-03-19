@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Gerenciar Roles e Permissões dos Usuários</h1>

    <!-- Mensagem de sucesso -->
    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <div class="card">
        <div class="card-header">
            <h3>Usuários</h3>
        </div>
        <div class="card-body">
            <table class="table">
                <thead>
                    <tr>
                        <th>Nome do Usuário</th>
                        <th>Roles</th>
                        <th>Permissões</th>
                        <th>Ações</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($users as $user)
                        <tr>
                            <td>{{ $user->name }}</td>
                            <td>
                                @foreach ($user->roles as $role)
                                    <span class="badge badge-info">{{ $role->name }}</span>
                                @endforeach
                            </td>
                            <td>
                                @foreach ($user->permissions as $permission)
                                    <span class="badge badge-secondary">{{ $permission->name }}</span>
                                @endforeach
                            </td>
                            <td>
                                <!-- Atribuir Role -->
                                <form action="{{ route('admin.assignRole', $user->id) }}" method="POST" style="display:inline;">
                                    @csrf
                                    <div class="form-group">
                                        <select name="roles[]" class="form-control" multiple>
                                            @foreach ($roles as $role)
                                                <option value="{{ $role->id }}" 
                                                    @if($user->hasRole($role->name)) selected @endif>
                                                    {{ $role->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <button type="submit" class="btn btn-primary">Atribuir Role</button>
                                </form>

                                <!-- Atribuir Permissão -->
                                <form action="{{ route('admin.assignPermission', $user->id) }}" method="POST" style="display:inline;">
                                    @csrf
                                    <div class="form-group">
                                        <select name="permissions[]" class="form-control" multiple>
                                            @foreach ($permissions as $permission)
                                                <option value="{{ $permission->id }}" 
                                                    @if($user->hasPermissionTo($permission->name)) selected @endif>
                                                    {{ $permission->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <button type="submit" class="btn btn-success">Atribuir Permissão</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
