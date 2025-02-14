<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ 'Lista de Movimentações' }}
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <!-- Card de Filtros -->
            <div class="bg-white dark:bg-gray-800 shadow-md rounded-lg p-6 mb-6">
                <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-200 mb-4">Filtrar Movimentações</h3>

                <form action="{{ route('movimentacoes.search') }}" method="POST">
                    @csrf

                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        <!-- Origem -->
                        <div>
                            <label for="local_origem"
                                class="block text-sm font-medium text-gray-700 dark:text-gray-300">Origem</label>
                            <select name="local_origem"
                                class="w-full px-4 py-2 mt-1 border rounded-md bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500">
                                <option value="">Selecione...</option>
                                @foreach ($locais as $local)
                                    <option value="{{ $local->id }}"
                                        {{ request('local_origem') == $local->id ? 'selected' : '' }}>
                                        {{ $local->descricao }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Destino -->
                        <div>
                            <label for="local_destino"
                                class="block text-sm font-medium text-gray-700 dark:text-gray-300">Destino</label>
                            <select name="local_destino"
                                class="w-full px-4 py-2 mt-1 border rounded-md bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500">
                                <option value="">Selecione...</option>
                                @foreach ($locais as $local)
                                    <option value="{{ $local->id }}"
                                        {{ request('local_destino') == $local->id ? 'selected' : '' }}>
                                        {{ $local->descricao }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Campo de Pesquisa -->
                        <div>
                            <label for="search"
                                class="block text-sm font-medium text-gray-700 dark:text-gray-300">Buscar</label>
                            <input type="text" id="search" name="search" placeholder="Digite para buscar..."
                                value="{{ request('search') }}"
                                class="w-full px-4 py-2 mt-1 border rounded-md bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500">
                        </div>
                    </div>

                    <!-- Botões -->
                    <div class="flex justify-end mt-4 gap-3">
                        <x-primary-button type="submit" class="px-5 py-2">
                            Pesquisar
                        </x-primary-button>

                        <a href="{{ route('movimentacoes.index') }}">
                            <x-secondary-button class="px-5 py-2 bg-gray-500 text-white">
                                Limpar Filtros
                            </x-secondary-button>
                        </a>
                    </div>

                </form>
            </div>



            {{-- <!-- Card de Filtros -->
            <div class="bg-white dark:bg-gray-800 shadow-sm sm:rounded-lg mb-6 p-6">
                <h3 class="text-lg font-semibold text-gray-800 dark:text-gray-200 mb-4">Filtrar Movimentações</h3>
                <form action="{{ route('movimentacoes.search') }}" method="POST" class="flex flex-wrap gap-4">
                    @csrf

                    <div class="mb-4">
                        <label for="local_origem" class="block text-sm font-medium text-gray-400">Origem</label>
                        <select name="local_origem"
                            class="w-full px-4 py-2 mt-1 border rounded-md text-black focus:ring-2 focus:ring-blue-500">
                            <option value="">Selecione...</option>
                            @foreach ($locais as $local)
                                <option value="{{ $local->id }}"
                                    {{ request('local_origem') == $local->id ? 'selected' : '' }}>
                                    {{ $local->descricao }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-4">
                        <label for="local_destino" class="block text-sm font-medium text-gray-400">Destino</label>
                        <select name="local_destino"
                            class="w-full px-4 py-2 mt-1 border rounded-md text-black focus:ring-2 focus:ring-blue-500">
                            <option value="">Selecione...</option>
                            @foreach ($locais as $local)
                                <option value="{{ $local->id }}"
                                    {{ request('local_destino') == $local->id ? 'selected' : '' }}>
                                    {{ $local->descricao }}
                                </option>
                            @endforeach
                        </select>
                    </div>


                    <!-- Campo de Pesquisa e Botão de Limpar -->
                    <div class="flex items-center space-x-2">
                        <!-- Campo de pesquisa -->
                        <input type="text" name="search" placeholder="Buscar..." value="{{ request('search') }}"
                            class="border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">

                        <!-- Botão de Pesquisar -->
                        <x-primary-button type="submit" class="px-4 py-2 rounded-md">
                            Pesquisar
                        </x-primary-button>

                        <a href="{{ route('movimentacoes.index') }}">
                            <x-secondary-button class="px-4 py-2 bg-gray-500 text-white rounded-md">
                                Limpar Filtros
                            </x-secondary-button>
                        </a>
                    </div>

                </form>
            </div> --}}

            <!-- Card de Movimentações -->
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <div class="flex justify-between items-center py-4">
                        <h3 class="text-lg font-semibold">Movimentações</h3>
                        <x-primary-button class="px-4 py-2" data-modal-target="movimentacao-modal"
                            data-modal-toggle="movimentacao-modal">
                            Movimentar Ativo
                        </x-primary-button>
                    </div>

                    <!-- Tabela Desktop -->
                    <div class="hidden md:block">
                        <table class="table-auto w-full border-collapse border border-gray-300 dark:border-gray-700">
                            <thead class="bg-gray-200 dark:bg-gray-700 text-gray-700 dark:text-gray-200">
                                <tr>
                                    <th class="border border-gray-300 dark:border-gray-600 px-4 py-2 text-left">Data
                                    </th>
                                    <th class="border border-gray-300 dark:border-gray-600 px-4 py-2 text-left">Ativo
                                    </th>
                                    <th class="border border-gray-300 dark:border-gray-600 px-4 py-2 text-left">
                                        Quantidade Mov</th>
                                    <th class="border border-gray-300 dark:border-gray-600 px-4 py-2 text-left">Origem
                                    </th>
                                    <th class="border border-gray-300 dark:border-gray-600 px-4 py-2 text-left">Destino
                                    </th>
                                    <th class="border border-gray-300 dark:border-gray-600 px-4 py-2 text-left">
                                        Observação</th>
                                    <th class="border border-gray-300 dark:border-gray-600 px-4 py-2 text-left">Usuário
                                    </th>
                                    <th class="border border-gray-300 dark:border-gray-600 px-4 py-2 text-left">Status
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($movimentacoes as $movimentacao)
                                    <tr class="bg-white dark:bg-gray-800 hover:bg-gray-100 dark:hover:bg-gray-700">
                                        <td class="border border-gray-300 dark:border-gray-600 px-4 py-2">
                                            {{ $movimentacao->created_at->format('d/m/Y H:i') }}
                                        </td>
                                        <td class="border border-gray-300 dark:border-gray-600 px-4 py-2">
                                            {{ $movimentacao->ativo->descricao ?? 'N/A' }}
                                        </td>
                                        <td class="border border-gray-300 dark:border-gray-600 px-4 py-2">
                                            {{ $movimentacao->quantidade_mov ?? '0' }}
                                        </td>
                                        <td class="border border-gray-300 dark:border-gray-600 px-4 py-2">
                                            {{ $movimentacao->origem->descricao ?? 'Local não encontrado' }}
                                        </td>
                                        <td class="border border-gray-300 dark:border-gray-600 px-4 py-2">
                                            {{ $movimentacao->destino->descricao ?? 'Local não encontrado' }}
                                        </td>
                                        <td class="border border-gray-300 dark:border-gray-600 px-4 py-2">
                                            {{ $movimentacao->observacao ?? '-' }}
                                        </td>
                                        <td class="border border-gray-300 dark:border-gray-600 px-4 py-2">
                                            {{ $movimentacao->user->name ?? 'N/A' }}
                                        </td>
                                        <td class="border border-gray-300 dark:border-gray-600 px-4 py-2">
                                            <span
                                                class="{{ $movimentacao->status == 'concluido' ? 'text-green-600' : ($movimentacao->status == 'pendente' ? 'text-orange-500' : 'text-red-600') }}">
                                                {{ ucfirst($movimentacao->status) }}
                                            </span>
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
                    </div>

                    <!-- Tabela Mobile - Cards Expansíveis -->
                    <div class="md:hidden space-y-2">
                        @forelse ($movimentacoes as $movimentacao)
                            <div class="bg-white dark:bg-gray-800 shadow-md rounded-lg p-4">
                                <div class="flex justify-between items-center">
                                    <div>
                                        <p class="text-sm font-semibold text-gray-900 dark:text-white">
                                            {{ $movimentacao->ativo->descricao ?? 'N/A' }}
                                        </p>
                                        <p class="text-xs text-gray-500 dark:text-gray-400">
                                            {{ $movimentacao->created_at->format('d/m/Y H:i') }}
                                        </p>
                                    </div>
                                    <button class="toggle-btn text-blue-600 dark:text-blue-400 text-sm font-medium">
                                        Ver detalhes
                                    </button>
                                </div>

                                <div
                                    class="details hidden overflow-hidden transition-all duration-200 ease-in-out opacity-0 max-h-0">
                                    <div class="mt-2 text-sm text-gray-700 dark:text-gray-300 space-y-1">
                                        <p><strong>Quantidade:</strong> {{ $movimentacao->quantidade_mov ?? '0' }}</p>
                                        <p><strong>Origem:</strong>
                                            {{ $movimentacao->origem->descricao ?? 'Local não encontrado' }}</p>
                                        <p><strong>Destino:</strong>
                                            {{ $movimentacao->destino->descricao ?? 'Local não encontrado' }}</p>
                                        <p><strong>Observação:</strong> {{ $movimentacao->observacao ?? '-' }}</p>
                                        <p><strong>Usuário:</strong> {{ $movimentacao->user->name ?? 'N/A' }}</p>
                                        <p>
                                            <strong>Status:</strong>
                                            <span
                                                class="{{ $movimentacao->status == 'concluido' ? 'text-green-600' : ($movimentacao->status == 'pendente' ? 'text-orange-500' : 'text-red-600') }}">
                                                {{ ucfirst($movimentacao->status) }}
                                            </span>
                                        </p>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <p class="text-center text-gray-500 dark:text-gray-400">Nenhuma movimentação encontrada.</p>
                        @endforelse
                    </div>


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
                        Adicionar
                    </x-primary-button>
                </div>
            </form>
        </div>

        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const origemSelect = document.getElementById('local_origem');
                const destinoSelect = document.getElementById('local_destino');
                const ativoSelect = document.getElementById('id_ativo');
                const movimentacaoModal = document.getElementById('movimentacao-modal');

                /**
                 * Alterna a visibilidade do modal com animação
                 */
                function toggleModal() {
                    movimentacaoModal.classList.remove('hidden');
                    setTimeout(() => {
                        movimentacaoModal.classList.add('opacity-100', 'scale-100');
                        movimentacaoModal.classList.remove('opacity-0', 'scale-95');
                    }, 10); // Pequeno delay para ativar a animação
                }

                /**
                 * Fecha o modal ao clicar fora dele
                 */
                function closeModal(event) {
                    if (!event || event.target.id === "movimentacao-modal") {
                        movimentacaoModal.classList.add('opacity-0', 'scale-95');
                        movimentacaoModal.classList.remove('opacity-100', 'scale-100');

                        setTimeout(() => {
                            movimentacaoModal.classList.add('hidden');
                        }, 200); // Tempo para a animação de fechamento
                    }
                }

                /**
                 * Atualiza as opções do select, desativando a opção correspondente no outro select
                 */
                function updateSelectOptions(mainSelect, otherSelect) {
                    const selectedValue = mainSelect.value;
                    Array.from(otherSelect.options).forEach(option => option.disabled = false);

                    if (selectedValue) {
                        const optionToDisable = otherSelect.querySelector(`option[value="${selectedValue}"]`);
                        if (optionToDisable) {
                            optionToDisable.disabled = true;
                        }
                    }
                }

                /**
                 * Busca locais disponíveis para um ativo selecionado e popula o select de origem
                 */
                function fetchLocaisDisponiveis() {
                    const ativoId = ativoSelect.value;

                    if (!ativoId) {
                        origemSelect.innerHTML = '<option value="">Selecione...</option>';
                        return;
                    }

                    fetch(`/ativos/${ativoId}/locais-disponiveis`)
                        .then(response => response.json())
                        .then(locais => {
                            origemSelect.innerHTML = '<option value="">Selecione...</option>';
                            locais.forEach(local => {
                                origemSelect.innerHTML +=
                                    `<option value="${local.id}">${local.descricao}</option>`;
                            });
                        })
                        .catch(error => console.error("Erro ao buscar locais disponíveis:", error));
                }

                /**
                 * Alterna a visibilidade das opções nos selects de origem e destino
                 */
                function toggleSelectOptions(selectElement) {
                    const options = selectElement.querySelectorAll("option:not([value=''])");
                    if (ativoSelect.value) {
                        options.forEach(option => option.hidden = false);
                    } else {
                        options.forEach(option => option.hidden = true);
                        selectElement.value = "";
                    }
                }

                /**
                 * Evento ao trocar de ativo
                 */
                function handleAtivoChange() {
                    fetchLocaisDisponiveis();
                    toggleSelectOptions(origemSelect);
                    toggleSelectOptions(destinoSelect);
                }

                // Eventos
                ativoSelect.addEventListener("change", handleAtivoChange);
                origemSelect.addEventListener("change", () => updateSelectOptions(origemSelect, destinoSelect));
                destinoSelect.addEventListener("change", () => updateSelectOptions(destinoSelect, origemSelect));

                // Delegação de evento para botões de abrir modal
                document.addEventListener('click', function(event) {
                    if (event.target.matches('[data-modal-toggle="movimentacao-modal"]')) {
                        toggleModal();
                    }
                });

                // Fechar modal ao clicar fora
                movimentacaoModal.addEventListener('click', closeModal);

                // Inicializa os selects corretamente ao carregar a página
                handleAtivoChange();
            });
        </script>


</x-app-layout>
