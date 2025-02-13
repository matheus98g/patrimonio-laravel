<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ 'Lista de Locais' }}
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">

                    <!-- Botão para abrir o modal -->
                    <div class="py-4">
                        <x-primary-button class="px-4 py-2 bg-blue-500 text-white rounded-md"
                            data-modal-target="local-modal" data-modal-toggle="local-modal">
                            Adicionar Local
                        </x-primary-button>
                    </div>

                    <!-- Tabela de Locais -->
                    <table class="table-auto w-full border-collapse border border-gray-300 dark:border-gray-700">
                        <thead class="bg-gray-200 dark:bg-gray-700 text-gray-700 dark:text-gray-200">
                            <tr>
                                <th class="border border-gray-300 dark:border-gray-600 px-4 py-2 text-left">ID</th>
                                <th class="border border-gray-300 dark:border-gray-600 px-4 py-2 text-left">Descrição
                                </th>
                                <th class="border border-gray-300 dark:border-gray-600 px-4 py-2 text-left">Ativos</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($locais as $local)
                                <tr class="bg-white dark:bg-gray-800 hover:bg-gray-100 dark:hover:bg-gray-700">
                                    <td class="border border-gray-300 dark:border-gray-600 px-4 py-2">
                                        {{ $local->id_local }}
                                    </td>
                                    <td class="border border-gray-300 dark:border-gray-600 px-4 py-2">
                                        {{ $local->local_descricao }}
                                    </td>
                                    <td class="border border-gray-300 dark:border-gray-600 px-4 py-2">
                                        {{ $local->ativos ?? 'Nenhum ativo cadastrado' }}
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="3"
                                        class="text-center border border-gray-300 dark:border-gray-600 px-4 py-2">
                                        Nenhum local encontrado.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal para adicionar local -->
    <div id="local-modal" class="fixed inset-0 z-50 flex justify-center items-center hidden"
        onclick="closeModal(event)">
        <div class="bg-white dark:bg-gray-800 p-6 rounded-lg shadow-lg w-96" onclick="event.stopPropagation()">
            <h3 class="text-lg font-semibold text-gray-800 dark:text-gray-200 mb-4">Adicionar Local</h3>
            <form action="{{ route('locais.store') }}" method="POST">
                @csrf
                <div class="mb-4">
                    <label for="descricao" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                        Descrição
                    </label>
                    <input type="text" id="descricao" name="descricao"
                        class="mt-1 block w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500"
                        required>
                </div>

                <div class="flex justify-end">
                    <x-primary-button type="submit" class="px-4 py-2">Cadastrar</x-primary-button>
                    <x-secondary-button type="button" class="ml-2 px-4 py-2"
                        data-modal-toggle="local-modal">Cancelar</x-secondary-button>
                </div>
            </form>
        </div>
    </div>

    <script>
        document.querySelectorAll('[data-modal-toggle="local-modal"]').forEach(button => {
            button.addEventListener('click', () => {
                document.getElementById('local-modal').classList.toggle('hidden');
            });
        });
    </script>
</x-app-layout>
