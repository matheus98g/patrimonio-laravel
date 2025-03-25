<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ ('Gerenciar Cargos') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <h3 class="text-lg font-semibold mb-4">{{ ('Lista de Cargos') }}</h3>

                    <div class="mb-4">
                        <a href="{{ route('admin.permissions.create') }}">
                            <x-primary-button class="w-full sm:w-auto">
                                Criar Novo Cargo
                            </x-primary-button>
                        </a>
                    </div>

                    <div class="hidden md:block">
                        <table class="w-full border-collapse">
                            <thead class="bg-gray-100 dark:bg-gray-700">
                                <tr>
                                    <th class="p-3 text-left text-sm">Nome</th>
                                    <th class="p-3 text-left text-sm">Ações</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($roles as $role)
                                    <tr class="bg-white dark:bg-gray-800 hover:bg-gray-100 dark:hover:bg-gray-700" id="row-{{ $role->id }}">
                                        <td class="border border-gray-300 dark:border-gray-600 px-4 py-2">
                                            {{ $role->name ?? 'N/A' }}
                                        </td>
                                        <td class="border border-gray-300 dark:border-gray-600 px-4 py-2">
                                            <div class="flex gap-3 items-center justify-center">
                                                <a href="{{ route('admin.roles.edit', $role->id) }}" 
                                                    class="inline-block bg-gray-200 dark:bg-gray-700 text-gray-800 dark:text-gray-200 hover:bg-gray-300 dark:hover:bg-gray-600 rounded px-4 py-2">
                                                    <i data-feather="edit" width="20"></i>
                                                </a>
                                                <form action="{{ route('admin.roles.destroy', $role->id) }}" method="POST" class="inline">
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

                    <div class="md:hidden">
                        @foreach ($roles as $role)
                            <div class="bg-white dark:bg-gray-800 p-4 rounded-lg shadow-sm mb-4">
                                <div class="flex justify-between items-center">
                                    <h4 class="text-sm font-semibold text-gray-900 dark:text-gray-100">{{ $role->name }}</h4>
                                    <div class="space-x-2">
                                        <a href="{{ route('admin.roles.edit', $role->id) }}" class="text-yellow-500 hover:text-yellow-700">{{ ('Editar') }}</a>
                                        <span class="mx-2">|</span>
                                        <form action="{{ route('admin.roles.destroy', $role->id) }}" method="POST" style="display: inline;" onsubmit="return confirm('{{ ('Tem certeza que deseja excluir esta permissão?') }}');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-red-500 hover:text-red-700">{{ ('Excluir') }}</button>
                                        </form>
                                    </div>
                                </div>
                                <p class="text-sm text-gray-700 dark:text-gray-300 mt-2">{{ $role->description ?? 'Sem descrição' }}</p>
                            </div>
                        @endforeach
                    </div>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>
