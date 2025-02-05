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
                            Movimentar Ativo
                        </x-primary-button>
                    </div>

                    <!-- Tabela de Movimentações -->
                    <table class="table-auto w-full border-collapse border border-gray-300 dark:border-gray-700">
                        <thead class="bg-gray-200 dark:bg-gray-700 text-gray-700 dark:text-gray-200">
                            <tr>
                                {{-- <th class="border border-gray-300 dark:border-gray-600 px-4 py-2 text-left">ID</th> --}}
                                <th class="border border-gray-300 dark:border-gray-600 px-4 py-2 text-left">Data</th>
                                <th class="border border-gray-300 dark:border-gray-600 px-4 py-2 text-left">Usuario</th>
                                <th class="border border-gray-300 dark:border-gray-600 px-4 py-2 text-left">Ativo</th>
                                <th class="border border-gray-300 dark:border-gray-600 px-4 py-2 text-left">Observação
                                </th>
                                <th class="border border-gray-300 dark:border-gray-600 px-4 py-2 text-left">Origem</th>
                                <th class="border border-gray-300 dark:border-gray-600 px-4 py-2 text-left">Destino</th>
                                <th class="border border-gray-300 dark:border-gray-600 px-4 py-2 text-left">Status</th>
                                <th class="border border-gray-300 dark:border-gray-600 px-4 py-2 text-left">Quantidade
                                    Mov</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($movimentacoes as $movimentacao)
                                <tr class="bg-white dark:bg-gray-800 hover:bg-gray-100 dark:hover:bg-gray-700">
                                    <td class="border border-gray-300 dark:border-gray-600 px-4 py-2">
                                        {{ $movimentacao->created_at }}</td>
                                    <td class="border border-gray-300 dark:border-gray-600 px-4 py-2">
                                        {{ $movimentacao->user->name ?? 'N/A' }}</td>
                                    <td class="border border-gray-300 dark:border-gray-600 px-4 py-2">
                                        {{ $movimentacao->ativo->descricao ?? 'N/A' }}</td>
                                    <td class="border border-gray-300 dark:border-gray-600 px-4 py-2">
                                        {{ $movimentacao->observacao }}</td>
                                    <td class="border border-gray-300 dark:border-gray-600 px-4 py-2">
                                        {{ $movimentacao->loca_origem }}</td>
                                    <td class="border border-gray-300 dark:border-gray-600 px-4 py-2">
                                        {{ $movimentacao->local_destino }}</td>
                                    <td class="border border-gray-300 dark:border-gray-600 px-4 py-2">
                                        <span
                                            class="{{ $movimentacao->status == 'concluido'
                                                ? 'text-green-600'
                                                : ($movimentacao->status == 'pendente'
                                                    ? 'text-orange-500'
                                                    : ($movimentacao->status == 'cancelado'
                                                        ? 'text-red-600'
                                                        : '')) }}">
                                            {{ ucfirst($movimentacao->status) }}
                                        </span>
                                    </td>
                                    <td class="border border-gray-300 dark:border-gray-600 px-4 py-2">
                                        {{ $movimentacao->quantidade_mov }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="8"
                                        class="text-center border border-gray-300 dark:border-gray-600 px-4 py-2">
                                        Nenhuma movimentação encontrada.
                                    </td>
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

                <!-- Ativo  - FUTURAMENTE SUBSTTUIR POR UM LIVE SEARCH   -->
                <div class="mb-4">
                    <label for="id_ativo"
                        class="block text-sm font-medium text-gray-700 dark:text-gray-300">Ativo</label>
                    <select id="id_ativo" name="id_ativo"
                        class="mt-1 block w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500"
                        required>
                        <option value="">Selecione...</option>
                        @foreach ($ativos as $ativo)
                            <option value="{{ $ativo->id }}">{{ $ativo->descricao }}</option>
                        @endforeach
                    </select>
                </div>

                <!-- Observação -->
                <div class="mb-4">
                    <label for="observacao"
                        class="block text-sm font-medium text-gray-700 dark:text-gray-300">{{ 'Observação (opcional)' }}</label>
                    <input type="text" id="observacao" name="observacao"
                        class="mt-1 block w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500"
                        required>
                </div>

                <div class="flex space-x-4">
                    <!-- Origem -->
                    <div class="mb-4 flex-1">
                        <label for="local_origem" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                            Origem
                        </label>
                        <select id="local_origem" name="local_origem"
                            class="mt-1 block w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500"
                            required>
                            <option value="">Selecione...</option>
                            @foreach ($locais as $local)
                                <option value="{{ $local->id }}">{{ $local->descricao }}</option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Destino -->
                    <div class="mb-4 flex-1">
                        <label for="local_destino" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                            Destino
                        </label>
                        <select id="local_destino" name="local_destino"
                            class="mt-1 block w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500"
                            required>
                            <option value="">Selecione...</option>
                            @foreach ($locais as $local)
                                <option value="{{ $local->id }}">{{ $local->descricao }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>



                {{-- <div class="flex space-x-4">
                    <!-- Origem -->
                    <div class="mb-4 flex-1">
                        <label for="local_origem" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                            Origem
                        </label>
                        <select id="local_origem" name="local_origem"
                            class="mt-1 block w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500"
                            required>
                            <option value="">Selecione...</option>
                            @foreach ($locais as $local)
                                <option value="{{ $local->id }}">{{ $local->descricao }}</option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Destino -->
                    <div class="mb-4 flex-1">
                        <label for="local_destino" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                            Destino
                        </label>
                        <select id="local_destino" name="local_destino"
                            class="mt-1 block w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500"
                            required>
                            <option value="">Selecione...</option>
                            @foreach ($locais as $local)
                                <option value="{{ $local->id }}">{{ $local->descricao }}</option>
                            @endforeach
                        </select>
                    </div>
                </div> --}}

                <!-- Quantidade de Uso -->
                <div class="mb-4 flex-1">
                    <label for="quantidade_mov"
                        class="block text-sm font-medium text-gray-700 dark:text-gray-300">Quantidade</label>
                    <input type="number" id="quantidade_mov" name="quantidade_mov"
                        class="mt-1 block w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500"
                        required min="1">
                </div>

                <!-- Status -->
                <div class="mb-4">
                    <label for="status"
                        class="block text-sm font-medium text-gray-700 dark:text-gray-300">Status</label>
                    <select id="status" name="status"
                        class="mt-1 block w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500"
                        required>
                        <option value="">Selecione...</option>
                        <option value="pendente">Pendente</option>
                        <option value="concluido">Concluído</option>
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

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const origemSelect = document.getElementById('local_origem');
            const destinoSelect = document.getElementById('local_destino');

            function updateDestinoOptions() {
                const selectedOrigem = origemSelect.value;

                // Primeiro, habilitar todas as opções no destino
                Array.from(destinoSelect.options).forEach(option => {
                    option.disabled = false;
                });

                // Se houver um local selecionado na origem, desabilitar essa opção no destino
                if (selectedOrigem) {
                    const optionToDisable = destinoSelect.querySelector(`option[value="${selectedOrigem}"]`);
                    if (optionToDisable) {
                        optionToDisable.disabled = true;
                    }
                }
            }

            function updateOrigemOptions() {
                const selectedDestino = destinoSelect.value;

                // Primeiro, habilitar todas as opções na origem
                Array.from(origemSelect.options).forEach(option => {
                    option.disabled = false;
                });

                // Se houver um local selecionado no destino, desabilitar essa opção na origem
                if (selectedDestino) {
                    const optionToDisable = origemSelect.querySelector(`option[value="${selectedDestino}"]`);
                    if (optionToDisable) {
                        optionToDisable.disabled = true;
                    }
                }
            }

            origemSelect.addEventListener('change', updateDestinoOptions);
            destinoSelect.addEventListener('change', updateOrigemOptions);
        });
    </script>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const ativoSelect = document.getElementById("id_ativo");
            const localOrigemSelect = document.getElementById("local_origem");

            ativoSelect.addEventListener("change", function() {
                const ativoId = this.value;

                if (ativoId) {
                    fetch(`/ativos/${ativoId}/locais-disponiveis`)
                        .then(response => response.json())
                        .then(locais => {
                            localOrigemSelect.innerHTML = '<option value="">Selecione...</option>';
                            locais.forEach(local => {
                                localOrigemSelect.innerHTML +=
                                    `<option value="${local.id}">${local.descricao}</option>`;
                            });
                        })
                        .catch(error => console.error("Erro ao buscar locais disponíveis:", error));
                } else {
                    localOrigemSelect.innerHTML = '<option value="">Selecione...</option>';
                }
            });
        });
    </script>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const ativoSelect = document.getElementById("id_ativo");
            const localOrigemSelect = document.getElementById("local_origem");
            const localDestinoSelect = document.getElementById("local_destino");

            function toggleOptions(selectElement) {
                const options = selectElement.querySelectorAll("option:not([value=''])");
                if (ativoSelect.value) {
                    options.forEach(option => option.hidden = false);
                } else {
                    options.forEach(option => option.hidden = true);
                    selectElement.value = "";
                }
            }

            function handleAtivoChange() {
                toggleOptions(localOrigemSelect);
                toggleOptions(localDestinoSelect);
            }

            ativoSelect.addEventListener("change", handleAtivoChange);

            // Executar ao carregar a página
            handleAtivoChange();
        });
    </script>




</x-app-layout>
