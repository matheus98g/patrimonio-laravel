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
                        <x-primary-button class="px-4 py-2" data-modal-target="movimentacao-modal"
                            data-modal-toggle="movimentacao-modal">
                            Adicionar Movimentação
                        </x-primary-button>
                    </div>

                    <!-- Tabela de Movimentações -->
                    <table class="table-auto w-full border-collapse border border-gray-300 dark:border-gray-700">
                        <thead class="bg-gray-200 dark:bg-gray-700 text-gray-700 dark:text-gray-200">
                            <tr>
                                <th class="border border-gray-300 dark:border-gray-600 px-4 py-2 text-left">ID</th>
                                <th class="border border-gray-300 dark:border-gray-600 px-4 py-2 text-left">Ativo</th>
                                <th class="border border-gray-300 dark:border-gray-600 px-4 py-2 text-left">Usuario</th>
                                <th class="border border-gray-300 dark:border-gray-600 px-4 py-2 text-left">Descrição
                                </th>
                                <th class="border border-gray-300 dark:border-gray-600 px-4 py-2 text-left">Origem</th>
                                <th class="border border-gray-300 dark:border-gray-600 px-4 py-2 text-left">Destino</th>
                                <th class="border border-gray-300 dark:border-gray-600 px-4 py-2 text-left">Quantidade
                                    Mov</th>
                                <th class="border border-gray-300 dark:border-gray-600 px-4 py-2 text-left">Quantidade
                                    Uso</th>
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
                                        {{ $movimentacao->user->name }}</td>
                                    <td class="border border-gray-300 dark:border-gray-600 px-4 py-2">
                                        {{ $movimentacao->descricao }}</td>
                                    <td class="border border-gray-300 dark:border-gray-600 px-4 py-2">
                                        {{ $movimentacao->origem }}</td>
                                    <td class="border border-gray-300 dark:border-gray-600 px-4 py-2">
                                        {{ $movimentacao->destino }}</td>
                                    <td class="border border-gray-300 dark:border-gray-600 px-4 py-2">
                                        {{ $movimentacao->qntMov }}</td>
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
    <div id="movimentacao-modal"
        class="fixed inset-0 z-50 flex justify-center items-center hidden bg-gray-900 bg-opacity-50"
        onclick="closeModal(event)">
        <div class="bg-white dark:bg-gray-800 p-6 rounded-lg shadow-lg w-96 max-w-full"
            onclick="event.stopPropagation()">
            <h3 class="text-lg font-semibold text-gray-800 dark:text-gray-200 mb-4">Adicionar Movimentação</h3>

            <!-- Exibir Erros de Validação -->
            @if ($errors->any())
                <div class="mb-4 p-3 bg-red-100 text-red-700 rounded">
                    <strong>Erros encontrados:</strong>
                    <ul class="list-disc list-inside">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('movimentacoes.store') }}" method="POST">
                @csrf

                <!-- Usuário (Preenchido automaticamente com o usuário logado) -->
                <div class="mb-4">

                    <input type="hidden" id="id_user" name="id_user" value="{{ auth()->user()->id }}">
                    <input type="hidden" value="{{ auth()->user()->name }}" disabled
                        class="mt-1 block w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>

                <!-- Ativo -->
                <div class="mb-4">
                    <label for="id_ativo"
                        class="block text-sm font-medium text-gray-700 dark:text-gray-300">Ativo</label>
                    <select id="id_ativo" name="id_ativo"
                        class="mt-1 block w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500"
                        required>
                        <option value="">Selecione um ativo</option>
                        @foreach ($ativos as $ativo)
                            <option value="{{ $ativo->id }}">{{ $ativo->descricao }}</option>
                        @endforeach
                    </select>
                </div>

                <!-- Descrição -->
                <div class="mb-4">
                    <label for="descricao"
                        class="block text-sm font-medium text-gray-700 dark:text-gray-300">Descrição</label>
                    <input type="text" id="descricao" name="descricao"
                        class="mt-1 block w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500"
                        required>
                </div>

                <div class="flex space-x-4">
                    <!-- Origem -->
                    <div class="mb-4 flex-1">
                        <label for="origem"
                            class="block text-sm font-medium text-gray-700 dark:text-gray-300">Origem</label>
                        <input type="text" id="origem" name="origem"
                            class="mt-1 block w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                    </div>

                    <!-- Destino -->
                    <div class="mb-4 flex-1">
                        <label for="destino"
                            class="block text-sm font-medium text-gray-700 dark:text-gray-300">Destino</label>
                        <input type="text" id="destino" name="destino"
                            class="mt-1 block w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                    </div>
                </div>


                <div class="flex space-x-4">
                    <!-- Quantidade de Uso -->
                    <div class="mb-4 flex-1">
                        <label for="qntMov"
                            class="block text-sm font-medium text-gray-700 dark:text-gray-300">Quantidade</label>
                        <input type="number" id="qntMov" name="qntMov"
                            class="mt-1 block w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500"
                            required min="1">
                    </div>

                    <!-- Tipo -->
                    <div class="mb-4 flex-1">
                        <label for="tipo"
                            class="block text-sm font-medium text-gray-700 dark:text-gray-300">Tipo</label>
                        <select id="tipo" name="tipo"
                            class="mt-1 block w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500"
                            required>
                            <option value="entrada">Entrada</option>
                            <option value="saida">Saída</option>
                            <option value="transferencia">Transferência</option>
                        </select>
                    </div>
                </div>


                <!-- Status -->
                <div class="mb-4">
                    <label for="status"
                        class="block text-sm font-medium text-gray-700 dark:text-gray-300">Status</label>
                    <select id="status" name="status"
                        class="mt-1 block w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500"
                        required>
                        <option value="pendente">Pendente</option>
                        <option value="concluido">Concluído</option>
                        <option value="cancelado">Cancelado</option>
                    </select>
                </div>

                <!-- Botões -->
                <div class="flex justify-end">

                    <x-primary-button class="ml-2 px-4 py-2" type="submit">Adicionar</x-primary-button>
                    <x-secondary-button class="ml-2 px-4 py-2" type="button"
                        onclick="closeModal()">Cancelar</x-secondary-button>
                </div>
            </form>
        </div>
    </div>

    <script>
        function closeModal(event) {
            if (!event || event.target.id === "movimentacao-modal") {
                document.getElementById('movimentacao-modal').classList.add('hidden');
            }
        }
    </script>

    <script>
        document.querySelectorAll('[data-modal-toggle="movimentacao-modal"]').forEach(button => {
            button.addEventListener('click', () => {
                document.getElementById('movimentacao-modal').classList.toggle('hidden');
            });
        });
    </script>

</x-app-layout>
