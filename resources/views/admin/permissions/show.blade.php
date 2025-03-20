<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ ('Detalhes da Permissão') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <div class="mb-4">
                        <a href="{{ route('admin.permissions.index') }}" class="text-blue-500 hover:text-blue-700">{{ ('Voltar para a lista de permissões') }}</a>
                    </div>

                    <div class="space-y-6">
                        <div>
                            <h3 class="text-xl font-semibold">{{ ('Nome da Permissão') }}</h3>
                            <p class="text-gray-700 dark:text-gray-300">{{ $permission->name }}</p>
                        </div>

                        <div>
                            <h3 class="text-xl font-semibold">{{ ('Descrição') }}</h3>
                            <p class="text-gray-700 dark:text-gray-300">{{ $permission->description ?? ('Sem descrição') }}</p>
                        </div>

                        <div class="flex items-center justify-start space-x-4">
                            <a href="{{ route('admin.permissions.edit', $permission->id) }}" class="text-yellow-500 hover:text-yellow-700">{{ ('Editar') }}</a>
                            <form action="{{ route('admin.permissions.destroy', $permission->id) }}" method="POST" onsubmit="return confirm('{{ ('Tem certeza que deseja excluir esta permissão?') }}');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-500 hover:text-red-700">{{ ('Excluir') }}</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
