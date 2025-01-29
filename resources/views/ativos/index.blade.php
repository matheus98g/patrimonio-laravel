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
                        <x-primary-button class="px-4 py-2 bg-blue-500 text-white rounded-md"
                            data-modal-target="ativo-modal" data-modal-toggle="ativo-modal">
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
                                <th class="border border-gray-300 dark:border-gray-600 px-4 py-2 text-left">Quantidade
                                </th>
                                <th class="border border-gray-300 dark:border-gray-600 px-4 py-2 text-left">Status</th>
                                <th class="border border-gray-300 dark:border-gray-600 px-4 py-2 text-left">Cadastrado
                                    Em</th>
                                <th class="border border-gray-300 dark:border-gray-600 px-4 py-2 text-left">Observação
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

                <div class="flex justify-end">
                    <x-primary-button type="submit"
                        class="px-4 py-2 bg-blue-500 text-white rounded-md">Cadastrar</x-primary-button>
                    <x-secondary-button type="button" class="ml-2 px-4 py-2 bg-gray-300 text-black rounded-md"
                        data-modal-toggle="ativo-modal">Cancelar</x-secondary-button>
                </div>
            </form>
        </div>
    </div>

    <script>
        document.querySelectorAll('[data-modal-toggle="ativo-modal"]').forEach(button => {
            button.addEventListener('click', () => {
                document.getElementById('ativo-modal').classList.toggle('hidden');
            });
        });

        function closeModal(event) {
            if (event.target === document.getElementById('ativo-modal')) {
                document.getElementById('ativo-modal').classList.add('hidden');
            }
        }
    </script>

</x-app-layout>
