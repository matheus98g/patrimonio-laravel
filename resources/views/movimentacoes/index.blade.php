<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ 'Lista de Movimentações' }}
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <!-- Botão para abrir o modal -->
                    <div class="py-4">
                        <x-primary-button class="px-4 py-2 bg-blue-500 text-white rounded-md"
                            data-modal-target="movimentacao-modal" data-modal-toggle="movimentacao-modal">
                            Adicionar Movimentação
                        </x-primary-button>
                    </div>

                    <!-- Tabela de Movimentações -->
                    <table class="table-auto w-full border-collapse border border-gray-300 dark:border-gray-700">
                        <thead class="bg-gray-200 dark:bg-gray-700 text-gray-700 dark:text-gray-200">
                            <tr>
                                <th class="border border-gray-300 dark:border-gray-600 px-4 py-2 text-left">ID</th>
                                <th class="border border-gray-300 dark:border-gray-600 px-4 py-2 text-left">Ativo</th>
                                <th class="border border-gray-300 dark:border-gray-600 px-4 py-2 text-left">Descrição
                                </th>
                                <th class="border border-gray-300 dark:border-gray-600 px-4 py-2 text-left">Origem</th>
                                <th class="border border-gray-300 dark:border-gray-600 px-4 py-2 text-left">Destino</th>
                                <th class="border border-gray-300 dark:border-gray-600 px-4 py-2 text-left">Quantidade
                                </th>
                                <th class="border border-gray-300 dark:border-gray-600 px-4 py-2 text-left">Tipo</th>
                                <th class="border border-gray-300 dark:border-gray-600 px-4 py-2 text-left">Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($movimentacoes as $movimentacao)
                                <tr class="bg-white dark:bg-gray-800 hover:bg-gray-100 dark:hover:bg-gray-700">
                                    <td class="border border-gray-300 dark:border-gray-600 px-4 py-2">
                                        {{ $movimentacao->id }}</td>
                                    <td class="border border-gray-300 dark:border-gray-600 px-4 py-2">
                                        {{ $movimentacao->ativo->descricao }}</td>
                                    <td class="border border-gray-300 dark:border-gray-600 px-4 py-2">
                                        {{ $movimentacao->descricao }}</td>
                                    <td class="border border-gray-300 dark:border-gray-600 px-4 py-2">
                                        {{ $movimentacao->origem }}</td>
                                    <td class="border border-gray-300 dark:border-gray-600 px-4 py-2">
                                        {{ $movimentacao->destino }}</td>
                                    <td class="border border-gray-300 dark:border-gray-600 px-4 py-2">
                                        {{ $movimentacao->qntUso }}</td>
                                    <td class="border border-gray-300 dark:border-gray-600 px-4 py-2">
                                        {{ $movimentacao->tipo }}</td>
                                    <td class="border border-gray-300 dark:border-gray-600 px-4 py-2">
                                        <span
                                            class="{{ $movimentacao->status == 1 ? 'text-green-600 dark:text-green-400' : 'text-red-600 dark:text-red-400' }}">
                                            {{ $movimentacao->status == 1 ? 'Ativo' : 'Inativo' }}
                                        </span>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="8"
                                        class="text-center border border-gray-300 dark:border-gray-600 px-4 py-2">
                                        Nenhuma movimentação encontrada.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal para adicionar movimentação -->
    <div id="movimentacao-modal" class="fixed inset-0 z-50 flex justify-center items-center hidden"
        onclick="closeModal(event)">
        <div class="bg-white dark:bg-gray-800 p-6 rounded-lg shadow-lg w-96" onclick="event.stopPropagation()">
            <h3 class="text-lg font-semibold text-gray-800 dark:text-gray-200 mb-4">Adicionar Movimentação</h3>
            <form action="{{ route('movimentacoes.store') }}" method="POST">
                @csrf
                <div class="mb-4">
                    <label for="ativo_id"
                        class="block text-sm font-medium text-gray-700 dark:text-gray-300">Ativo</label>
                    <select id="ativo_id" name="ativo_id"
                        class="mt-1 block w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                        @foreach ($ativos as $ativo)
                            <option value="{{ $ativo->id }}">{{ $ativo->descricao }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-4">
                    <label for="descricao"
                        class="block text-sm font-medium text-gray-700 dark:text-gray-300">Descrição</label>
                    <input type="text" id="descricao" name="descricao"
                        class="mt-1 block w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500"
                        required>
                </div>

                <div class="mb-4">
                    <label for="origem"
                        class="block text-sm font-medium text-gray-700 dark:text-gray-300">Origem</label>
                    <input type="text" id="origem" name="origem"
                        class="mt-1 block w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500"
                        required>
                </div>

                <div class="mb-4">
                    <label for="destino"
                        class="block text-sm font-medium text-gray-700 dark:text-gray-300">Destino</label>
                    <input type="text" id="destino" name="destino"
                        class="mt-1 block w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500"
                        required>
                </div>

                <div class="mb-4">
                    <label for="qntUso"
                        class="block text-sm font-medium text-gray-700 dark:text-gray-300">Quantidade</label>
                    <input type="number" id="qntUso" name="qntUso"
                        class="mt-1 block w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500"
                        required>
                </div>

                <div class="mb-4">
                    <label for="tipo"
                        class="block text-sm font-medium text-gray-700 dark:text-gray-300">Tipo</label>
                    <select id="tipo" name="tipo"
                        class="mt-1 block w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500"
                        required>
                        <option value="Adicionar">Adicionar</option>
                        <option value="Realocar">Realocar</option>
                        <option value="Remover">Remover</option>
                    </select>
                </div>

                <div class="flex justify-end">
                    <x-primary-button type="submit"
                        class="px-4 py-2 bg-blue-500 text-white rounded-md">Cadastrar</x-primary-button>
                    <x-secondary-button type="button" class="ml-2 px-4 py-2 bg-gray-300 text-black rounded-md"
                        data-modal-toggle="movimentacao-modal">Cancelar</x-secondary-button>
                </div>
            </form>
        </div>
    </div>

    <script>
        document.querySelectorAll('[data-modal-toggle="movimentacao-modal"]').forEach(button => {
            button.addEventListener('click', () => {
                document.getElementById('movimentacao-modal').classList.toggle('hidden');
            });
        });
    </script>

</x-app-layout>
