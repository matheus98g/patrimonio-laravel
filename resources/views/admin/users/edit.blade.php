<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ 'Editar Usuário' }}
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <form method="POST" action="{{ route('admin.users.update', $usuario->id) }}" class="space-y-6">
                        @csrf
                        @method('PUT')
                        <div>
                            <h1 class="mt-1 block text-xl font-semibold text-gray-900 dark:text-gray-100">
                                {{ old('name', $usuario->name) }}
                            </h1>
                        </div>

                        @if (!$usuario->hasRole('admin'))
                            <div>
                                <label for="roles" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Cargos</label>
                                <select name="roles[]" id="roles" multiple class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-100 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                                    @foreach ($roles as $role)
                                        <option value="{{ $role->name }}" 
                                            {{ $usuario->hasRole($role->name) ? 'selected' : '' }}>
                                            {{ $role->name }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('roles')
                                    <span class="text-sm text-red-600">{{ $message }}</span>
                                @enderror
                            </div>
                        @else
                            <div>
                                <label for="roles" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Cargos</label>
                                <input type="text" disabled value="Admin - Acesso total" class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-100 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                            </div>
                        @endif

                        @if (!$usuario->hasRole('admin'))
                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Permissões</label>
                                <div class="space-y-2">
                                    @foreach ($permissions as $permission)
                                        <div class="flex items-center">
                                            <input type="checkbox" name="permissions[]" value="{{ $permission->id }}"
                                                id="permission_{{ $permission->id }}"
                                                class="h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-100"
                                                {{ $usuario->hasPermissionTo($permission->id) ? 'checked' : '' }}>
                                            <label for="permission_{{ $permission->id }}" class="ml-2 text-sm text-gray-700 dark:text-gray-300">{{ $permission->name }}</label>
                                        </div>
                                    @endforeach
                                </div>
                                @error('permissions')
                                    <span class="text-sm text-red-600">{{ $message }}</span>
                                @enderror
                            </div>
                        @else
                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Permissões</label>
                                <input type="text" disabled value="Admin - Acesso total" class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-100 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                            </div>
                        @endif

                        <div class="flex items-center justify-end space-x-4">
                            <x-primary-button type="submit">Salvar</x-primary-button>
                            <a href="{{ route('admin.users.index') }}" class="text-gray-500 hover:text-gray-700 dark:text-gray-300 dark:hover:text-gray-400">
                                Cancelar
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
