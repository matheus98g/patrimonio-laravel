<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ 'Lista de Ativos' }}
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <!-- Botão para abrir o modal -->
                    <div class="py-4">
                        <x-primary-button onclick="openCreateModal()" class="px-3 py-2 bg-green-500 text-white rounded">
                            Adicionar Ativo
                        </x-primary-button>

                    </div>

                    <!-- Tabela de Ativos -->
                    <table class="table-auto w-full border-collapse border border-gray-300 dark:border-gray-700">
                        <thead class="bg-gray-200 dark:bg-gray-700 text-gray-700 dark:text-gray-200">
                            <tr>
                                <th class="border border-gray-300 dark:border-gray-600 px-4 py-2 text-left">ID</th>
                                <th class="border border-gray-300 dark:border-gray-600 px-4 py-2 text-left">Descrição
                                </th>
                                <th class="border border-gray-300 dark:border-gray-600 px-4 py-2 text-left">Marca
                                </th>
                                <th class="border border-gray-300 dark:border-gray-600 px-4 py-2 text-left">Tipo
                                </th>
                                <th class="border border-gray-300 dark:border-gray-600 px-4 py-2 text-left">Quantidade
                                </th>
                                <th class="border border-gray-300 dark:border-gray-600 px-4 py-2 text-left">Status</th>
                                <th class="border border-gray-300 dark:border-gray-600 px-4 py-2 text-left">Cadastrado
                                    Em</th>
                                <th class="border border-gray-300 dark:border-gray-600 px-4 py-2 text-left">Observação
                                </th>
                                <th class="border border-gray-300 dark:border-gray-600 px-4 py-2 text-left">Ações
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($ativos as $ativo)
                                <tr class="bg-white dark:bg-gray-800 hover:bg-gray-100 dark:hover:bg-gray-700">
                                    <td class="border border-gray-300 dark:border-gray-600 px-4 py-2">
                                        {{ $ativo->id }}</td>
                                    <td class="border border-gray-300 dark:border-gray-600 px-4 py-2">
                                        {{ $ativo->descricao }}</td>
                                    <td class="border border-gray-300 dark:border-gray-600 px-4 py-2">
                                        {{ $ativo->marca->descricao }}</td>
                                    <td class="border border-gray-300 dark:border-gray-600 px-4 py-2">
                                        {{ $ativo->tipo->descricao }}</td>
                                    <td class="border border-gray-300 dark:border-gray-600 px-4 py-2">
                                        {{ $ativo->quantidade }}</td>
                                    <td class="border border-gray-300 dark:border-gray-600 px-4 py-2">
                                        <span
                                            class="{{ $ativo->status == 1 ? 'text-green-600 dark:text-green-400' : 'text-red-600 dark:text-red-400' }}">
                                            {{ $ativo->status == 1 ? 'Ativo' : 'Inativo' }}
                                        </span>
                                    </td>
                                    <td class="border border-gray-300 dark:border-gray-600 px-4 py-2">
                                        {{ \Carbon\Carbon::parse($ativo->created_at)->format('d/m/Y H:i:s') }}
                                    </td>
                                    <td class="border border-gray-300 dark:border-gray-600 px-4 py-2">
                                        {{ $ativo->observacao }}</td>
                                    <td class="border border-gray-300 dark:border-gray-600 px-4 py-2">
                                        <!-- Botão para abrir o modal de edição -->
                                        <x-secondary-button
                                            onclick="openEditModal({ 
                                                    id: '{{ $ativo->id }}', 
                                                    descricao: '{{ $ativo->descricao }}', 
                                                    id_marca: '{{ $ativo->id_marca }}', 
                                                    id_tipo: '{{ $ativo->id_tipo }}', 
                                                    quantidade: '{{ $ativo->quantidade }}', 
                                                    observacao: '{{ $ativo->observacao }}' 
                                                })"
                                            class="px-3 py-2 bg-blue-500 text-white rounded">
                                            Editar
                                        </x-secondary-button>

                                    </td>

                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5"
                                        class="text-center border border-gray-300 dark:border-gray-600 px-4 py-2">Nenhum
                                        ativo encontrado.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>

                </div>
            </div>
        </div>
    </div>

    <!-- Modal para adicionar ativo -->
    <div id="ativo-modal" class="fixed inset-0 z-50 flex justify-center items-center hidden"
        onclick="closeModal(event)">
        <div class="bg-white dark:bg-gray-800 p-6 rounded-lg shadow-lg w-96" onclick="event.stopPropagation()">
            <h3 class="text-lg font-semibold text-gray-800 dark:text-gray-200 mb-4">Cadastrar Ativo</h3>
            <form action="{{ route('ativos.store') }}" method="POST">
                @csrf
                <div class="mb-4">
                    <label for="descricao"
                        class="block text-sm font-medium text-gray-700 dark:text-gray-300">Descrição</label>
                    <input type="text" id="descricao" name="descricao"
                        class="mt-1 block w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500"
                        required>
                </div>

                <div class="mb-4">
                    <label for="id_marca"
                        class="block text-sm font-medium text-gray-700 dark:text-gray-300">Marca</label>
                    <select name="id_marca" id="id_marca"
                        class="mt-1 block w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                        <option value="">Selecione uma Marca</option>
                        @foreach ($marcas as $marca)
                            <option value="{{ $marca->id }}">{{ $marca->descricao }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-4">
                    <label for="id_tipo"
                        class="block text-sm font-medium text-gray-700 dark:text-gray-300">Tipo</label>
                    <select name="id_tipo" id="id_tipo"
                        class="mt-1 block w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                        <option value="">Selecione um Tipo</option>
                        @foreach ($tipos as $tipo)
                            <option value="{{ $tipo->id }}">{{ $tipo->descricao }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-4">
                    <label for="quantidade"
                        class="block text-sm font-medium text-gray-700 dark:text-gray-300">Quantidade</label>
                    <input type="number" id="quantidade" name="quantidade" value="1"
                        class="mt-1 block w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500"
                        required>
                </div>

                <div class="mb-4">
                    <label for="observacao"
                        class="block text-sm font-medium text-gray-700 dark:text-gray-300">Observação</label>
                    <textarea id="observacao" name="observacao"
                        class="mt-1 block w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500"></textarea>
                </div>

                <div class="flex justify-end px-4">
                    <x-primary-button class="ml-2 px-4 py-2" type="submit">Cadastrar</x-primary-button>
                    <x-secondary-button class="ml-2 px-4 py-2" type="button"
                        onclick="closeModal('ativo-modal')">Cancelar</x-secondary-button>

                </div>
            </form>
        </div>
    </div>

    <!-- Modal para editar ativo -->
    <div id="editar-ativo-modal" class="fixed inset-0 z-50 flex justify-center items-center hidden"
        onclick="closeModal(event)">
        <div class="bg-white dark:bg-gray-800 p-6 rounded-lg shadow-lg w-96" onclick="event.stopPropagation()">
            <h3 class="text-lg font-semibold text-gray-800 dark:text-gray-200 mb-4">Editar Ativo</h3>
            <form id="editForm" action="" method="POST">
                @csrf
                @method('PUT')
                <div class="mb-4">
                    <label for="descricao"
                        class="block text-sm font-medium text-gray-700 dark:text-gray-300">Descrição</label>
                    <input type="text" id="descricao" name="descricao" value="{{ $ativo->descricao }}"
                        class="mt-1 block w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500"
                        required>
                </div>

                <div class="mb-4">
                    <label for="id_marca"
                        class="block text-sm font-medium text-gray-700 dark:text-gray-300">Marca</label>
                    <select name="id_marca" id="id_marca"
                        class="mt-1 block w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                        <option value="">Selecione uma Marca</option>
                        @foreach ($marcas as $marca)
                            <option value="{{ $marca->id }}"
                                {{ $ativo->id_marca == $marca->id ? 'selected' : '' }}>
                                {{ $marca->descricao }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-4">
                    <label for="id_tipo"
                        class="block text-sm font-medium text-gray-700 dark:text-gray-300">Tipo</label>
                    <select name="id_tipo" id="id_tipo"
                        class="mt-1 block w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                        <option value="">Selecione um Tipo</option>
                        @foreach ($tipos as $tipo)
                            <option value="{{ $tipo->id }}" {{ $ativo->id_tipo == $tipo->id ? 'selected' : '' }}>
                                {{ $tipo->descricao }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-4">
                    <label for="quantidade"
                        class="block text-sm font-medium text-gray-700 dark:text-gray-300">Quantidade</label>
                    <input type="number" id="quantidade" name="quantidade" value="{{ $ativo->quantidade }}"
                        class="mt-1 block w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500"
                        required>
                </div>

                <div class="mb-4">
                    <label for="observacao"
                        class="block text-sm font-medium text-gray-700 dark:text-gray-300">Observação</label>
                    <textarea id="observacao" name="observacao"
                        class="mt-1 block w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500">{{ $ativo->observacao }}</textarea>
                </div>

                <div class="flex justify-end">
                    <x-primary-button class="ml-2 px-4 py-2" type="submit">Atualizar</x-primary-button>
                    <!-- Botão de Cancelar ajustado para fechar o modal -->
                    <x-secondary-button class="ml-2 px-4 py-2" type="button"
                        onclick="closeModal('editar-ativo-modal')">Cancelar</x-secondary-button>
                </div>

            </form>
        </div>
    </div>
    <script>
        function openCreateModal() {
            // Limpa os campos do formulário antes de abrir o modal
            document.getElementById('descricao').value = '';
            document.getElementById('id_marca').value = '';
            document.getElementById('id_tipo').value = '';
            document.getElementById('quantidade').value = '1';
            document.getElementById('observacao').value = '';

            // Exibe o modal
            document.getElementById('ativo-modal').classList.remove('hidden');
        }

        function openEditModal(ativo) {
            // Define a URL do formulário com o ID do ativo
            document.getElementById('editForm').action = `/ativos/${ativo.id}`;

            // Preenche os campos do formulário com os dados do ativo
            document.getElementById('descricao').value = ativo.descricao;
            document.getElementById('id_marca').value = ativo.id_marca;
            document.getElementById('id_tipo').value = ativo.id_tipo;
            document.getElementById('quantidade').value = ativo.quantidade;
            document.getElementById('observacao').value = ativo.observacao || '';

            // Exibe o modal
            document.getElementById('editar-ativo-modal').classList.remove('hidden');
        }

        function closeModal(modalId) {
            document.getElementById(modalId).classList.add('hidden');
        }
    </script>


</x-app-layout>
