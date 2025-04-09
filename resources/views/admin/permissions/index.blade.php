<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ ('Permissões') }}
            </h2>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100 space-y-6">
                    <!-- Formulário de busca -->
                    <div class="flex flex-col sm:flex-row gap-4">
                        <form method="GET" action="{{ route('admin.permissions.index') }}"
                            class="flex w-full sm:w-auto flex-grow gap-2">
                            <input type="text" name="search"
                                class="w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-100 focus:border-indigo-500 focus:ring-indigo-500 text-sm py-2"
                                placeholder="Buscar por nome da permissão..." value="{{ request('search') }}">
                            <x-primary-button type="submit" class="shrink-0 px-4 py-2">
                                {{ ('Buscar') }}
                            </x-primary-button>
                            <a href="{{ route('admin.permissions.index') }}">
                                <x-secondary-button class="px-4 py-2">
                                    {{ ('Limpar Pesquisa') }}
                                </x-secondary-button>
                            </a>
                        </form>
                        {{-- <div>
                            <a href="{{ route('admin.permissions.create') }}">
                                <x-primary-button class="px-4 py-2">
                                    {{ ('Nova Permissão') }}
                                </x-primary-button>
                            </a>
                        </div> --}}
                    </div>

                    <!-- Tabela para Desktop -->
                    <div class="hidden md:block overflow-x-auto">
                        <table class="w-full border-collapse bg-white dark:bg-gray-800 rounded-lg shadow-sm">
                            <thead class="bg-gray-100 dark:bg-gray-700">
                                <tr>
                                    <th class="p-4 text-left text-xs font-semibold text-gray-700 dark:text-gray-300 uppercase tracking-wider">
                                        {{ ('Nome') }}
                                    </th>
                                    <th class="p-4 text-left text-xs font-semibold text-gray-700 dark:text-gray-300 uppercase tracking-wider">
                                        {{ ('Cargos Vinculados') }}
                                    </th>
                                    <th class="p-4 text-left text-xs font-semibold text-gray-700 dark:text-gray-300 uppercase tracking-wider">
                                        {{ ('Ações') }}
                                    </th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                                @forelse ($permissions as $permission)
                                    <tr class="hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors duration-150">
                                        <td class="p-4 text-sm text-gray-900 dark:text-gray-100">{{ $permission->name }}</td>
                                        <td class="p-4 text-sm text-gray-700 dark:text-gray-300">
                                            @if($permission->roles->count())
                                                {{ $permission->roles->pluck('name')->implode(', ') }}
                                            @else
                                                <span class="text-gray-400 italic">-</span>
                                            @endif
                                        </td>
                                        <td class="p-4">
                                            <div class="flex gap-2 justify-center">
                                                {{-- <a href="{{ route('admin.permissions.edit', $permission->id) }}">
                                                    <x-secondary-button class="p-2">
                                                        <i data-feather="edit" class="w-4 h-4"></i>
                                                    </x-secondary-button>
                                                </a> --}}
                                                <form method="POST" action="{{ route('admin.permissions.destroy', $permission->id) }}"
                                                    onsubmit="return confirm('Tem certeza que deseja excluir esta permissão?');">
                                                    @csrf
                                                    @method('DELETE')
                                                    <x-danger-button class="p-2 bg-red-500 dark:bg-red-600 hover:bg-red-600 dark:hover:bg-red-700">
                                                        <i data-feather="trash" class="w-4 h-4"></i>
                                                    </x-danger-button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="3" class="p-4 text-center text-gray-500 dark:text-gray-400">
                                            {{ ('Nenhuma permissão encontrada.') }}
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                            
                        </table>
                    </div>

                    <!-- Cards para Mobile -->
                    <div class="md:hidden space-y-4">
                        @forelse ($permissions as $permission)
                            <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm border border-gray-200 dark:border-gray-600 p-4 space-y-2">
                                <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100">{{ $permission->name }}</h3>
                                <div class="flex justify-end gap-2">
                                    {{-- <a href="{{ route('admin.permissions.edit', $permission->id) }}">
                                        <x-secondary-button class="p-2">
                                            {{ ('Editar') }}
                                        </x-secondary-button>
                                    </a> --}}
                                    <form method="POST" action="{{ route('admin.permissions.destroy', $permission->id) }}"
                                        onsubmit="return confirm('Tem certeza que deseja excluir esta permissão?');">
                                        @csrf
                                        @method('DELETE')
                                        <x-danger-button class="p-2">
                                            {{ ('Excluir') }}
                                        </x-danger-button>
                                    </form>
                                </div>
                            </div>
                        @empty
                            <div class="text-center p-4 text-gray-500 dark:text-gray-400">
                                {{ ('Nenhuma permissão encontrada.') }}
                            </div>
                        @endforelse
                    </div>

                    <!-- Paginação -->
                    {{-- <div class="mt-6 flex justify-center">
                        {{ $permissions->links() }}
                    </div> --}}
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
