{{-- 

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

                    <!-- Versão mobile: cards expansíveis para locais -->
<div class="block md:hidden space-y-4 mt-6">
    @forelse ($locais as $local)
        <div x-data="{ open: false }" class="bg-white dark:bg-gray-800 rounded-lg shadow-sm border border-gray-200 dark:border-gray-600">
            <!-- Cabeçalho do card -->
            <div @click="open = !open" class="p-4 flex justify-between items-center cursor-pointer hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors">
                <div class="space-y-1">
                    <h3 class="font-semibold text-gray-900 dark:text-white">
                        {{ $local->local_descricao }}
                    </h3>
                    <p class="text-sm text-gray-500 dark:text-gray-400">
                        {{ $local->local_observacao ?: 'Sem observação' }}
                    </p>
                </div>
                <i data-feather="chevron-down" class="w-5 h-5 text-gray-500 transition-transform" :class="{ 'rotate-180': open }"></i>
            </div>

            <!-- Conteúdo detalhado -->
            <div x-show="open" x-transition class="p-4 border-t border-gray-200 dark:border-gray-600 text-sm space-y-2">
                <div class="grid grid-cols-2 gap-2">
                    <span class="text-gray-600 dark:text-gray-400 font-medium">ID:</span>
                    <span class="text-gray-900 dark:text-white">{{ $local->local_id }}</span>

                    <span class="text-gray-600 dark:text-gray-400 font-medium">Ativos:</span>
                    <span class="text-gray-900 dark:text-white">{{ $local->ativos ?? '-- Local vazio --' }}</span>
                </div>

                <div class="flex justify-end pt-2">
                    <x-danger-button onclick="deleteLocal('{{ $local->local_id }}')" class="bg-red-500 rounded">
                        <i data-feather="x" width="20"></i>
                    </x-danger-button>
                </div>
            </div>
        </div>
    @empty
        <div class="bg-white dark:bg-gray-800 shadow-sm rounded-lg border border-gray-200 dark:border-gray-600 p-4 text-center text-gray-500 dark:text-gray-400">
            Nenhum local encontrado.
        </div>
    @endforelse
</div>


                    <!-- Tabela de Locais (mobile responsive) -->
                    <div class="overflow-x-auto">
                        <table class="table-auto w-full border-collapse border border-gray-300 dark:border-gray-700">
                            <thead class="bg-gray-200 dark:bg-gray-700 text-gray-700 dark:text-gray-200">
                                <tr>
                                    <th class="border border-gray-300 dark:border-gray-600 px-4 py-2 text-left">ID</th>
                                    <th class="border border-gray-300 dark:border-gray-600 px-4 py-2 text-left">Descrição</th>
                                    <th class="border border-gray-300 dark:border-gray-600 px-4 py-2 text-left">Ativos</th>
                                    <th class="border border-gray-300 dark:border-gray-600 px-4 py-2 text-left">Ações</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($locais as $local)
                                    <tr class="bg-white dark:bg-gray-800 hover:bg-gray-100 dark:hover:bg-gray-700">
                                        <td class="border border-gray-300 dark:border-gray-600 px-4 py-2">
                                            {{ $local->local_id }}
                                        </td>
                                        <td class="border border-gray-300 dark:border-gray-600 px-4 py-2">
                                            <div>{{ $local->local_descricao }}</div>
                                            <div><small class="text-gray-400">{{ $local->local_observacao }}</small></div>
                                        </td>

                                        <td class="border border-gray-300 dark:border-gray-600 px-4 py-2">
                                            {{ $local->ativos ?? '--Local vazio--' }}
                                        </td>
                                        
                                        <td class="border border-gray-300 dark:border-gray-600 px-4 py-2">
                                            <x-danger-button onclick="deleteLocal('{{ $local->local_id }}')"
                                                class="bg-red-500 rounded">
                                                <i data-feather="x" width="20"></i>
                                            </x-danger-button>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4"
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
                        Nome do Local
                    </label>
                    <input type="text" id="descricao" name="descricao"
                        class="mt-1 block w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500"
                        required>
                </div>

                <div class="mb-4">
                    <label for="observacao" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                        Observação
                    </label>
                    <input type="text" id="observacao" name="observacao"
                        class="mt-1 block w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
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

        async function deleteLocal(id) {
            if (!confirm('Tem certeza que deseja excluir este Local?')) return;

            try {
                const response = await fetch(`/locais/${id}`, {
                    method: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                        'Accept': 'application/json',
                    }
                });

                const result = await response.json();
                if (result.success) {
                    document.getElementById(`row-${id}`).remove();
                } else {
                    alert(result.message || 'Erro ao excluir local');
                }
            } catch (error) {
                console.error('Erro:', error);
                alert('Erro na requisição');
            }
        }
    </script>
</x-app-layout> --}}


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

                    <!-- Versão mobile: cards expansíveis para locais -->
                    <div class="block md:hidden space-y-4 mt-6">
                        @forelse ($locais as $local)
                            <div x-data="{ open: false }"
                                class="bg-white dark:bg-gray-800 rounded-lg shadow-sm border border-gray-200 dark:border-gray-600">
                                <div @click="open = !open"
                                    class="p-4 flex justify-between items-center cursor-pointer hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors">
                                    <div class="space-y-1">
                                        <h3 class="font-semibold text-gray-900 dark:text-white">
                                            {{ $local->local_descricao }}
                                        </h3>
                                        <p class="text-sm text-gray-500 dark:text-gray-400">
                                            {{ $local->local_observacao ?: 'Sem observação' }}
                                        </p>
                                    </div>
                                    <i data-feather="chevron-down"
                                        class="w-5 h-5 text-gray-500 transition-transform"
                                        :class="{ 'rotate-180': open }"></i>
                                </div>

                                <div x-show="open" x-transition
                                    class="p-4 border-t border-gray-200 dark:border-gray-600 text-sm space-y-2">
                                    <div class="grid grid-cols-2 gap-2">
                                        <span class="text-gray-600 dark:text-gray-400 font-medium">ID:</span>
                                        <span class="text-gray-900 dark:text-white">{{ $local->local_id }}</span>

                                        <span class="text-gray-600 dark:text-gray-400 font-medium">Ativos:</span>
                                        <span class="text-gray-900 dark:text-white">{{ $local->ativos ?? '-- Local vazio --' }}</span>
                                    </div>

                                    <td class="border border-gray-300 dark:border-gray-600 px-4 py-2">
                                        <x-danger-button onclick="deleteLocal('{{ $local->local_id }}')"
                                            class="bg-red-500 rounded">
                                            <i data-feather="x" width="20"></i>
                                        </x-danger-button>
                                    </td>
                                </div>
                            </div>
                        @empty
                            <div
                                class="bg-white dark:bg-gray-800 shadow-sm rounded-lg border border-gray-200 dark:border-gray-600 p-4 text-center text-gray-500 dark:text-gray-400">
                                Nenhum local encontrado.
                            </div>
                        @endforelse
                    </div>

                    <!-- Tabela de Locais: visível apenas em md ou superior -->
                    <div class="hidden md:block overflow-x-auto mt-6">
                        <table
                            class="table-auto w-full border-collapse border border-gray-300 dark:border-gray-700">
                            <thead class="bg-gray-200 dark:bg-gray-700 text-gray-700 dark:text-gray-200">
                                <tr>
                                    <th class="border border-gray-300 dark:border-gray-600 px-4 py-2 text-left">ID</th>
                                    <th class="border border-gray-300 dark:border-gray-600 px-4 py-2 text-left">Descrição</th>
                                    <th class="border border-gray-300 dark:border-gray-600 px-4 py-2 text-left">Ativos</th>
                                    <th class="border border-gray-300 dark:border-gray-600 px-4 py-2 text-left">Ações</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($locais as $local)
                                    <tr id="row-{{ $local->local_id }}"
                                        class="bg-white dark:bg-gray-800 hover:bg-gray-100 dark:hover:bg-gray-700">
                                        <td class="border border-gray-300 dark:border-gray-600 px-4 py-2">
                                            {{ $local->local_id }}
                                        </td>
                                        <td class="border border-gray-300 dark:border-gray-600 px-4 py-2">
                                            <div>{{ $local->local_descricao }}</div>
                                            <div><small class="text-gray-400">{{ $local->local_observacao }}</small></div>
                                        </td>
                                        <td class="border border-gray-300 dark:border-gray-600 px-4 py-2">
                                            {{ $local->ativos ?? '--Local vazio--' }}
                                        </td>
                                        <td class="border border-gray-300 dark:border-gray-600 px-4 py-2">
                                            <x-danger-button onclick="deleteLocal('{{ $local->local_id }}')"
                                                class="bg-red-500 rounded">
                                                <i data-feather="x" width="20"></i>
                                            </x-danger-button>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4"
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
                        Nome do Local
                    </label>
                    <input type="text" id="descricao" name="descricao"
                        class="mt-1 block w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500"
                        required>
                </div>

                <div class="mb-4">
                    <label for="observacao" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                        Observação
                    </label>
                    <input type="text" id="observacao" name="observacao"
                        class="mt-1 block w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
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

        async function deleteLocal(id) {
            if (!confirm('Tem certeza que deseja excluir este Local?')) return;

            try {
                const response = await fetch(`/locais/${id}`, {
                    method: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                        'Accept': 'application/json',
                    }
                });

                const result = await response.json();
                if (result.success) {
                    document.getElementById(`row-${id}`)?.remove();
                } else {
                    alert(result.message || 'Erro ao excluir local');
                }
            } catch (error) {
                console.error('Erro:', error);
                alert('Erro na requisição');
            }
        }
    </script>
</x-app-layout>
