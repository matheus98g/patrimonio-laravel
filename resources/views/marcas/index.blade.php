<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ 'Lista de Marcas' }}
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">

                    <!-- Botão para abrir o modal -->
                    <div class="py-4">
                        <x-primary-button class="px-4 py-2 bg-blue-500 text-white rounded-md"
                            data-modal-target="marca-modal" data-modal-toggle="marca-modal">
                            Adicionar Marca
                        </x-primary-button>

                    </div>



                    <!-- Tabela de Marcas -->
                    <table class="w-full border-collapse bg-white dark:bg-gray-800 rounded-lg shadow-sm">
                        <thead class="bg-gray-100 dark:bg-gray-700">
                            <tr>
                                <th class="p-4 text-left text-xs font-semibold text-gray-700 dark:text-gray-300 uppercase tracking-wider">ID</th>
                                <th class="p-4 text-left text-xs font-semibold text-gray-700 dark:text-gray-300 uppercase tracking-wider">Descrição
                                </th>
                                <th class="p-4 text-left text-xs font-semibold text-gray-700 dark:text-gray-300 uppercase tracking-wider">Status</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                            @forelse ($marcas as $marca)
                                <tr class="hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors duration-150">
                                    <td class="p-4 text-sm text-gray-900 dark:text-gray-100">
                                        {{ $marca->id }}</td>
                                    <td class="p-4 text-sm text-gray-900 dark:text-gray-100">
                                        {{ $marca->descricao }}</td>
                                    <td class="p-4 text-sm text-gray-900 dark:text-gray-100">
                                        <span
                                            class="{{ $marca->status == 1 ? 'text-green-600 dark:text-green-400' : 'text-red-600 dark:text-red-400' }}">
                                            {{ $marca->status == 1 ? 'Ativo' : 'Inativo' }}
                                        </span>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="3"
                                        class="text-center p-4 text-sm text-gray-900 dark:text-gray-100">
                                        Nenhuma marca encontrada.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal para adicionar marca -->
    <div id="marca-modal" class="fixed inset-0 z-50 flex justify-center items-center hidden"
        onclick="closeModal(event)">
        <div class="bg-white dark:bg-gray-800 p-6 rounded-lg shadow-lg w-96" onclick="event.stopPropagation()">
            <h3 class="text-lg font-semibold text-gray-800 dark:text-gray-200 mb-4">Adicionar Marca</h3>
            <form action="{{ route('marcas.store') }}" method="POST">
                @csrf
                <div class="mb-4">
                    <label for="descricao"
                        class="block text-sm font-medium text-gray-700 dark:text-gray-300">Descrição</label>
                    <input type="text" id="descricao" name="descricao"
                        class="mt-1 block w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500"
                        required>
                </div>

                <div class="flex justify-end">
                    <x-primary-button type="submit" class="px-4 py-2">Cadastrar</x-primary-button>
                    <x-secondary-button type="button" class="ml-2 px-4 py-2"
                        data-modal-toggle="marca-modal">Cancelar</x-secondary-button>
                </div>
            </form>
        </div>
    </div>

    </div>
    <script>
        document.querySelectorAll('[data-modal-toggle="marca-modal"]').forEach(button => {
            button.addEventListener('click', () => {
                document.getElementById('marca-modal').classList.toggle('hidden');
            });
        });
    </script>

</x-app-layout>
