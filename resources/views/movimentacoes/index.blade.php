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
                    <!-- Filtros e Botão para abrir o modal -->
                    <div class="flex justify-between items-center py-4">
                        <div class="flex space-x-4">
                            <!-- Filtro de Status -->
                            <select id="filter_status" name="filter_status" onchange="this.form.submit()"
                                class="px-4 py-2 border rounded-md text-black focus:outline-none focus:ring-2 focus:ring-blue-500">
                                <option value="">Filtrar por Status</option>
                                <option value="pendente"
                                    {{ request()->input('filter_status') == 'pendente' ? 'selected' : '' }}>
                                    Pendente
                                </option>
                                <option value="concluido"
                                    {{ request()->input('filter_status') == 'concluido' ? 'selected' : '' }}>
                                    Concluído
                                </option>
                                <option value="cancelado"
                                    {{ request()->input('filter_status') == 'cancelado' ? 'selected' : '' }}>
                                    Cancelado
                                </option>
                            </select>

                            <!-- Pesquisar -->
                            <form action="{{ route('movimentacoes.search') }}" method="GET"
                                class="flex items-center space-x-2">
                                <input type="text" name="search" placeholder="Buscar..."
                                    value="{{ request()->input('search', old('search')) }}"
                                    class="border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                                <x-primary-button type="submit" class="ml-2 px-4 py-2 rounded-md">
                                    Pesquisar
                                </x-primary-button>
                            </form>
                        </div>

                        <div class="py-4">
                            <x-primary-button class="px-4 py-2" data-modal-target="movimentacao-modal"
                                data-modal-toggle="movimentacao-modal">
                                Movimentar Ativo
                            </x-primary-button>
                        </div>
                    </div>

                    <!-- Tabela de Movimentações -->
                    <table class="table-auto w-full border-collapse border border-gray-300 dark:border-gray-700">
                        <thead class="bg-gray-200 dark:bg-gray-700 text-gray-700 dark:text-gray-200">
                            <tr>
                                <th class="border border-gray-300 dark:border-gray-600 px-4 py-2 text-left">Data</th>
                                <th class="border border-gray-300 dark:border-gray-600 px-4 py-2 text-left">Usuário</th>
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
                                        {{ $movimentacao->created_at->format('d/m/Y H:i') }}
                                    </td>
                                    <td class="border border-gray-300 dark:border-gray-600 px-4 py-2">
                                        {{ $movimentacao->user->name ?? 'N/A' }}
                                    </td>
                                    <td class="border border-gray-300 dark:border-gray-600 px-4 py-2">
                                        {{ $movimentacao->ativo->descricao ?? 'N/A' }}
                                    </td>
                                    <td class="border border-gray-300 dark:border-gray-600 px-4 py-2">
                                        {{ $movimentacao->observacao ?? '-' }}
                                    </td>
                                    <td class="border border-gray-300 dark:border-gray-600 px-4 py-2">
                                        {{ $locais[$movimentacao->local_origem]->descricao ?? 'Local não encontrado' }}
                                    </td>
                                    <td class="border border-gray-300 dark:border-gray-600 px-4 py-2">
                                        {{ $locais[$movimentacao->local_destino]->descricao ?? 'Local não encontrado' }}
                                    </td>

                                    <td class="border border-gray-300 dark:border-gray-600 px-4 py-2">
                                        <span
                                            class="{{ $movimentacao->status == 'concluido' ? 'text-green-600' : ($movimentacao->status == 'pendente' ? 'text-orange-500' : ($movimentacao->status == 'cancelado' ? 'text-red-600' : '')) }}">
                                            {{ ucfirst($movimentacao->status) }}
                                        </span>
                                    </td>
                                    <td class="border border-gray-300 dark:border-gray-600 px-4 py-2">
                                        {{ $movimentacao->quantidade_mov ?? '0' }}
                                    </td>
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


                    <!-- Paginação -->
                    <div class="pagination py-2">
                        {{ $movimentacoes->links() }}
                    </div>
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

                <!-- Ativo -->
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
                        class="mt-1 block w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>

                <!-- Origem e Destino -->
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

                <!-- Quantidade de Uso -->
                <div class="mb-4 flex-1">
                    <label for="quantidade_mov"
                        class="block text-sm font-medium text-gray-700 dark:text-gray-300">Quantidade</label>
                    <input type="number" id="quantidade_mov" name="quantidade_mov"
                        class="mt-1 block w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500"
                        required>
                </div>

                <!-- Campo Hidden para Status -->
                <input type="hidden" name="status" value="concluido">

                <div class="flex justify-between items-center space-x-4 mt-4">
                    <x-secondary-button type="button" onclick="closeModal()">
                        Cancelar
                    </x-secondary-button>
                    <x-primary-button type="submit">
                        Adicionar Movimentação
                    </x-primary-button>
                </div>
            </form>
        </div>

        <script>
            document.addEventListener('DOMContentLoaded', function() {
                // Gerenciamento das opções de 'Destino' e 'Origem'
                const origemSelect = document.getElementById('local_origem');
                const destinoSelect = document.getElementById('local_destino');
                const ativoSelect = document.getElementById("id_ativo");
                const localDestinoSelect = document.getElementById("local_destino");

                // Função para fechar o modal
                window.closeModal = function(event) {
                    // Verifica se o evento de clique foi no próprio modal ou no botão de cancelar
                    if (!event || event.target.id === "movimentacao-modal" || event.target.closest(
                            '#movimentacao-modal') === null) {
                        document.getElementById('movimentacao-modal').classList.add('hidden');
                        console.log('Modal fechado');
                    }
                }

                // Abertura e fechamento do modal
                document.querySelectorAll('[data-modal-toggle="movimentacao-modal"]').forEach(button => {
                    button.addEventListener('click', () => {
                        document.getElementById('movimentacao-modal').classList.toggle('hidden');
                        console.log('Modal alternado');
                    });
                });

                // Função para atualizar as opções de 'Destino' baseado na seleção de 'Origem'
                function updateDestinoOptions() {
                    const selectedOrigem = origemSelect.value;
                    console.log('Origem selecionada:', selectedOrigem);

                    // Habilita todas as opções de destino
                    Array.from(destinoSelect.options).forEach(option => {
                        option.disabled = false;
                    });

                    // Desabilita a opção de destino que já está selecionada em origem
                    if (selectedOrigem) {
                        const optionToDisable = destinoSelect.querySelector(`option[value="${selectedOrigem}"]`);
                        if (optionToDisable) {
                            optionToDisable.disabled = true;
                            console.log('Opção de destino desabilitada para:', selectedOrigem);
                        }
                    }
                }

                // Função para atualizar as opções de 'Origem' baseado na seleção de 'Destino'
                function updateOrigemOptions() {
                    const selectedDestino = destinoSelect.value;
                    console.log('Destino selecionado:', selectedDestino);

                    // Habilita todas as opções de origem
                    Array.from(origemSelect.options).forEach(option => {
                        option.disabled = false;
                    });

                    // Desabilita a opção de origem que já está selecionada em destino
                    if (selectedDestino) {
                        const optionToDisable = origemSelect.querySelector(`option[value="${selectedDestino}"]`);
                        if (optionToDisable) {
                            optionToDisable.disabled = true;
                            console.log('Opção de origem desabilitada para:', selectedDestino);
                        }
                    }
                }

                // Atualiza as opções ao alterar 'Origem' e 'Destino'
                origemSelect.addEventListener('change', updateDestinoOptions);
                destinoSelect.addEventListener('change', updateOrigemOptions);

                // Atualizar as opções de local de origem com base no ativo selecionado
                ativoSelect.addEventListener("change", function() {
                    const ativoId = this.value;
                    console.log('Ativo selecionado:', ativoId);

                    if (ativoId) {
                        console.log('Buscando locais disponíveis para o ativo:', ativoId);
                        fetch(`/ativos/${ativoId}/locais-disponiveis`)
                            .then(response => response.json())
                            .then(locais => {
                                origemSelect.innerHTML = '<option value="">Selecione...</option>';
                                locais.forEach(local => {
                                    origemSelect.innerHTML +=
                                        `<option value="${local.id}">${local.descricao}</option>`;
                                    console.log('Local adicionado ao select de origem:', local);
                                });
                            })
                            .catch(error => {
                                console.error("Erro ao buscar locais disponíveis:", error);
                                console.log("Erro ao tentar atualizar os locais de origem.");
                            });
                    } else {
                        origemSelect.innerHTML = '<option value="">Selecione...</option>';
                        console.log('Nenhum ativo selecionado, opções de origem resetadas');
                    }
                });

                // Função para alternar as opções nos selects de 'Origem' e 'Destino' dependendo do ativo selecionado
                function toggleOptions(selectElement) {
                    const options = selectElement.querySelectorAll("option:not([value=''])");
                    if (ativoSelect.value) {
                        options.forEach(option => option.hidden = false);
                        console.log('Opções visíveis para o select:', selectElement.id);
                    } else {
                        options.forEach(option => option.hidden = true);
                        selectElement.value = "";
                        console.log('Opções ocultas para o select:', selectElement.id);
                    }
                }

                function handleAtivoChange() {
                    toggleOptions(origemSelect);
                    toggleOptions(localDestinoSelect);
                }

                // Atualiza as opções ao alterar o ativo
                ativoSelect.addEventListener("change", handleAtivoChange);

                // Executa ao carregar a página
                handleAtivoChange();
                console.log('Página carregada e configurações de select inicializadas');
            });
        </script>

</x-app-layout>
