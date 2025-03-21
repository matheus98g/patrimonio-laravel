<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ ('Gerenciar Permissões') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <h3 class="text-lg font-semibold mb-4">{{ ('Lista de Permissões') }}</h3>

                    <!-- Tabela de permissões -->
                    <div class="hidden md:block">
                        <table class="w-full border-collapse">
                            <thead class="bg-gray-100 dark:bg-gray-700">
                                <tr>
                                    <th class="p-3 text-left text-sm">{{ ('Nome') }}</th>
                                    <th class="p-3 text-left text-sm">{{ ('Descrição') }}</th>
                                    <th class="p-3 text-left text-sm">{{ ('Ações') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($permissions as $permission)
                                    <tr class="bg-white dark:bg-gray-800 hover:bg-gray-100 dark:hover:bg-gray-700">
                                        <td class="border border-gray-300 dark:border-gray-600 px-4 py-2">
                                            {{ $permission->name }}
                                        </td>
                                        <td class="border border-gray-300 dark:border-gray-600 px-4 py-2">
                                            {{ $permission->description ?? ('Sem descrição') }}
                                        </td>
                                        <td class="border border-gray-300 dark:border-gray-600 px-4 py-2 text-center">
                                            <!-- Ações -->
                                            <a href="{{ route('admin.permissions.show', $permission->id) }}" class="text-blue-500 hover:text-blue-700">{{ ('Detalhes') }}</a>
                                            <span class="mx-2">|</span>
                                            <a href="{{ route('admin.permissions.edit', $permission->id) }}" class="text-yellow-500 hover:text-yellow-700">{{ ('Editar') }}</a>
                                            <span class="mx-2">|</span>
                                            <form action="{{ route('admin.permissions.destroy', $permission->id) }}" method="POST" style="display: inline;" onsubmit="return confirm('{{ ('Tem certeza que deseja excluir esta permissão?') }}');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="text-red-500 hover:text-red-700">{{ ('Excluir') }}</button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <!-- Tabela mobile -->
                    <div class="md:hidden">
                        @foreach($permissions as $permission)
                            <div class="bg-white dark:bg-gray-800 p-4 rounded-lg shadow-sm mb-4">
                                <div class="flex justify-between items-center">
                                    <h4 class="text-sm font-semibold text-gray-900 dark:text-gray-100">{{ $permission->name }}</h4>
                                    <div class="space-x-2">
                                        <a href="{{ route('admin.permissions.show', $permission->id) }}" class="text-blue-500 hover:text-blue-700">{{ ('Detalhes') }}</a>
                                        <span class="mx-2">|</span>
                                        <a href="{{ route('admin.permissions.edit', $permission->id) }}" class="text-yellow-500 hover:text-yellow-700">{{ ('Editar') }}</a>
                                        <span class="mx-2">|</span>
                                        <form action="{{ route('admin.permissions.destroy', $permission->id) }}" method="POST" style="display: inline;" onsubmit="return confirm('{{ ('Tem certeza que deseja excluir esta permissão?') }}');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-red-500 hover:text-red-700">{{ ('Excluir') }}</button>
                                        </form>
                                    </div>
                                </div>
                                <p class="text-sm text-gray-700 dark:text-gray-300 mt-2">{{ $permission->description ?? ('Sem descrição') }}</p>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
