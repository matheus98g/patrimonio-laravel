<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ 'Controle de Acesso' }}
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <!-- Formulário de busca -->
                    <div class="mb-6">
                        <form method="GET" action="{{ route('admin.users.index') }}" class="flex gap-2">
                            <input 
                                type="text" 
                                name="search" 
                                class="w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-100 focus:border-indigo-500 focus:ring-indigo-500" 
                                placeholder="Buscar usuários por nome, email..." 
                                value="{{ request('search') }}"
                            >
                            <x-primary-button type="submit" class="shrink-0">
                                Buscar
                            </x-primary-button>
                        </form>
                    </div>

                    <!-- Tabela de usuários -->
                    <div class="hidden md:block">
                        <table class="w-full border-collapse">
                            <thead class="bg-gray-100 dark:bg-gray-700">
                                <tr>
                                    <th class="p-3 text-left text-sm">Nome</th>
                                    <th class="p-3 text-left text-sm">Email</th>
                                    <th class="p-3 text-left text-sm">Cargo</th>
                                    <th class="p-3 text-left text-sm">Permissões</th>
                                    <th class="p-3 text-left text-sm">Ações</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($usuarios as $usuario)
                                    <tr class="bg-white dark:bg-gray-800 hover:bg-gray-100 dark:hover:bg-gray-700" id="row-{{ $usuario->id }}">
                                        <td class="border border-gray-300 dark:border-gray-600 px-4 py-2">
                                            {{ $usuario->name ?? 'N/A' }}
                                        </td>
                                        <td class="border border-gray-300 dark:border-gray-600 px-4 py-2">
                                            {{ $usuario->email ?? 'N/A' }}
                                        </td>
                                        <td class="border border-gray-300 dark:border-gray-600 px-4 py-2">
                                            @foreach ($usuario->roles as $role)
                                                <span class="bg-blue-100 text-blue-800 dark:bg-blue-600 dark:text-blue-200 px-2 py-1 rounded-full text-xs">
                                                    {{ $role->name }}
                                                </span>
                                            @endforeach
                                        </td>
                                        <td class="border border-gray-300 dark:border-gray-600 px-4 py-2">
                                            @foreach ($usuario->permissions as $permission)
                                                <span class="bg-blue-100 text-blue-800 dark:bg-blue-600 dark:text-blue-200 px-2 py-1 rounded-full text-xs">
                                                    {{ $permission->name }}
                                                </span>
                                            @endforeach
                                        </td>
                                        <td class="border border-gray-300 dark:border-gray-600 px-4 py-2">
                                            <div class="flex gap-3 items-center justify-center">
                                                <a href="{{ route('admin.users.edit', $usuario->id) }}" 
                                                    class="inline-block bg-gray-200 dark:bg-gray-700 text-gray-800 dark:text-gray-200 hover:bg-gray-300 dark:hover:bg-gray-600 rounded px-4 py-2">
                                                    <i data-feather="edit" width="20"></i>
                                                </a>
                                                <!-- Botão de excluir -->
                                                <form action="{{ route('admin.users.destroy', $usuario->id) }}" method="POST" class="inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <x-danger-button type="submit" 
                                                        class="bg-red-500 dark:bg-red-600 text-white hover:bg-red-600 dark:hover:bg-red-700 rounded">
                                                        <i data-feather="x" width="20"></i>
                                                    </x-danger-button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

</x-app-layout>
