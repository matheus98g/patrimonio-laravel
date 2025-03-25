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
                    <h3 class="text-lg font-semibold mb-4">{{ ('Adicionar Novas Permissões') }}</h3>

                    <form method="POST" action="{{ route('admin.permissions.store') }}" class="space-y-6">
                        @csrf

                        <div>
                            <label for="permissions" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Nome das Permissões</label>
                            <input type="text" name="permissions" required class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-100 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" placeholder="Digite as permissões separadas por vírgula">
                        </div>

                        <div class="flex items-center justify-end space-x-4 mt-6">
                            <x-primary-button type="submit">Criar Permissões</x-primary-button>
                            <a href="{{ route('admin.permissions.index') }}" class="text-gray-500 hover:text-gray-700 dark:text-gray-300 dark:hover:text-gray-400">
                                Cancelar
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
