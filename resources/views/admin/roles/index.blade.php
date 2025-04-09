<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ ('Cargos') }}
            </h2>
        </div>
    </x-slot>


    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100 space-y-6">
                    <!-- Formulário de busca -->
                    <div class="flex flex-col sm:flex-row gap-4">
                        <form method="GET" action="{{ route('admin.roles.index') }}"
                            class="flex w-full sm:w-auto flex-grow gap-2">
                            <input type="text" name="search"
                                class="w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-100 focus:border-indigo-500 focus:ring-indigo-500 text-sm py-2"
                                placeholder="Buscar por nome da função..." value="{{ request('search') }}">
                            <x-primary-button type="submit" class="shrink-0 px-4 py-2">
                                {{ ('Buscar') }}
                            </x-primary-button>
                            <a href="{{ route('admin.roles.index') }}">
                                <x-secondary-button class="px-4 py-2">
                                    {{ ('Limpar') }}
                                </x-secondary-button>
                            </a>
                        </form>
                        <div>
                            <a href="{{ route('admin.roles.create') }}">
                                <x-primary-button class="px-4 py-2">
                                    {{ ('Novo Cargo') }}
                                </x-primary-button>
                            </a>
                        </div>
                    </div>

                    <!-- Tabela para Desktop -->
                    <div class="hidden md:block overflow-x-auto">
                        <table class="w-full border-collapse bg-white dark:bg-gray-800 rounded-lg shadow-sm">
                            <thead class="bg-gray-100 dark:bg-gray-700">
                                <tr>
                                    <th
                                        class="p-4 text-left text-xs font-semibold text-gray-700 dark:text-gray-300 uppercase tracking-wider">
                                        {{ ('Nome') }}</th>
                                    <th
                                        class="p-4 text-left text-xs font-semibold text-gray-700 dark:text-gray-300 uppercase tracking-wider">
                                        {{ ('Permissões') }}</th>
                                    <th
                                        class="p-4 text-left text-xs font-semibold text-gray-700 dark:text-gray-300 uppercase tracking-wider">
                                        {{ ('Ações') }}</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                                @forelse ($roles as $role)
                                    <tr class="hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors duration-150">
                                        <td class="p-4 text-sm text-gray-900 dark:text-gray-100">{{ $role->name }}</td>
                                        <td class="p-4 text-sm text-gray-900 dark:text-gray-100">
                                            @foreach($role->permissions as $permission)
                                                <span
                                                    class="inline-block bg-indigo-600 text-white text-xs px-2 py-1 rounded-full dark:bg-indigo-700 dark:text-white mr-1 mb-1">
                                                    {{ $permission->name }}
                                                </span>
                                            @endforeach
                                        </td>
                                        <td class="p-4">
                                            <div class="flex gap-2 justify-center">
                                                <a href="{{ route('admin.roles.edit', $role->id) }}">
                                                    <x-secondary-button class="p-2">
                                                        <i data-feather="edit" class="w-4 h-4"></i>
                                                    </x-secondary-button>
                                                </a>
                                                <form method="POST" action="{{ route('admin.roles.destroy', $role->id) }}"
                                                    onsubmit="return confirm('Tem certeza que deseja excluir esta função?');">
                                                    @csrf
                                                    @method('DELETE')
                                                    <x-danger-button
                                                        class="p-2 bg-red-500 dark:bg-red-600 hover:bg-red-600 dark:hover:bg-red-700">
                                                        <i data-feather="trash" class="w-4 h-4"></i>
                                                    </x-danger-button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="3" class="p-4 text-center text-gray-500 dark:text-gray-400">
                                            {{ ('Nenhuma função encontrada.') }}</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <!-- Cards para Mobile -->
                    <div class="md:hidden space-y-4">
                        @forelse ($roles as $role)
                            <div
                                class="bg-white dark:bg-gray-800 rounded-lg shadow-sm border border-gray-200 dark:border-gray-600 p-4 space-y-2">
                                <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100">{{ $role->name }}</h3>
                                <div class="text-sm text-gray-700 dark:text-gray-300">
                                    @foreach($role->permissions as $permission)
                                        <span
                                            class="inline-block bg-indigo-600 text-white text-xs px-2 py-1 rounded-full dark:bg-indigo-700 dark:text-white mr-1 mb-1">
                                            {{ $permission->name }}
                                        </span>
                                    @endforeach
                                </div>
                                <div class="flex justify-end gap-2">
                                    <a href="{{ route('admin.roles.edit', $role->id) }}">
                                        <x-secondary-button class="p-2">
                                            {{ ('Editar') }}
                                        </x-secondary-button>
                                    </a>
                                    <form method="POST" action="{{ route('admin.roles.destroy', $role->id) }}"
                                        onsubmit="return confirm('Tem certeza que deseja excluir esta função?');">
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
                                {{ ('Nenhuma função encontrada.') }}</div>
                        @endforelse
                    </div>

                    <!-- Paginação -->
                    {{-- <div class="mt-6 flex justify-center">
                        {{ $roles->links() }}
                    </div> --}}
                </div>
            </div>
        </div>
    </div>
</x-app-layout>