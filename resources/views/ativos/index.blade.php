<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('Lista de Ativos') }}
            </h2>
        </div>
    </x-slot>

    <div class="py-16"> <!-- Ajustado para compensar navbar fixa -->
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100 space-y-6">
                    <!-- Formulário de busca -->
                    <div class="flex flex-col sm:flex-row gap-4">
                        <form method="GET" action="{{ route('ativos.index') }}" class="flex w-full sm:w-auto flex-grow gap-2">
                            <input type="text" name="search"
                                   class="w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-100 focus:border-indigo-500 focus:ring-indigo-500 text-sm py-2"
                                   placeholder="Buscar por descrição, observação, status..."
                                   value="{{ request('search') }}">
                            <x-primary-button type="submit" class="shrink-0 px-4 py-2">
                                {{ __('Buscar') }}
                            </x-primary-button>
                        </form>
                        <div>
                            <a href="{{ route('ativos.create') }}">
                                <x-primary-button class="px-4 py-2">
                                    {{ __('Adicionar Ativo') }}
                                </x-primary-button>
                            </a>
                        </div>
                    </div>

                    <!-- Tabela para Desktop -->
                    <div class="hidden md:block overflow-x-auto">
                        <table class="w-full border-collapse bg-white dark:bg-gray-800 rounded-lg shadow-sm">
                            <thead class="bg-gray-100 dark:bg-gray-700">
                                <tr>
                                    <th class="p-4 text-left text-xs font-semibold text-gray-700 dark:text-gray-300 uppercase tracking-wider">{{ __('Imagem') }}</th>
                                    <th class="p-4 text-left text-xs font-semibold text-gray-700 dark:text-gray-300 uppercase tracking-wider">{{ __('Descrição') }}</th>
                                    <th class="p-4 text-left text-xs font-semibold text-gray-700 dark:text-gray-300 uppercase tracking-wider">{{ __('Disponível') }}</th>
                                    <th class="p-4 text-left text-xs font-semibold text-gray-700 dark:text-gray-300 uppercase tracking-wider">{{ __('Total') }}</th>
                                    <th class="p-4 text-left text-xs font-semibold text-gray-700 dark:text-gray-300 uppercase tracking-wider">{{ __('Mínimo') }}</th>
                                    <th class="p-4 text-left text-xs font-semibold text-gray-700 dark:text-gray-300 uppercase tracking-wider">{{ __('Status') }}</th>
                                    <th class="p-4 text-left text-xs font-semibold text-gray-700 dark:text-gray-300 uppercase tracking-wider">{{ __('Ações') }}</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                                @forelse ($ativos as $ativo)
                                    <tr class="hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors duration-150" id="row-{{ $ativo->id }}">
                                        <td class="p-4">
                                            @if ($ativo->imagem)
                                                <div class="w-16 h-16 overflow-hidden rounded-lg shadow-sm hover:shadow-md transition-shadow duration-200">
                                                    <img src="{{ Storage::url($ativo->imagem) }}"
                                                         alt="Imagem do ativo {{ $ativo->descricao }}"
                                                         class="w-full h-full object-cover hover:scale-105 transition-transform duration-200">
                                                </div>
                                            @else
                                                <div class="w-16 h-16 bg-gray-100 dark:bg-gray-700 rounded-lg flex items-center justify-center text-gray-500 dark:text-gray-400 text-xs">
                                                    {{ __('Sem imagem') }}
                                                </div>
                                            @endif
                                        </td>
                                        <td class="p-4 text-sm text-gray-900 dark:text-gray-100">{{ $ativo->descricao ?? 'N/A' }}</td>
                                        <td class="p-4 text-sm text-gray-900 dark:text-gray-100">
                                            {{ optional($ativosDisp->firstWhere('ativo_id', $ativo->id))->quantidade_disp ?? 0 }}
                                        </td>
                                        <td class="p-4 text-sm text-gray-900 dark:text-gray-100">{{ $ativo->quantidade }}</td>
                                        <td class="p-4 text-sm text-gray-900 dark:text-gray-100">{{ $ativo->quantidade_min }}</td>
                                        <td class="p-4 text-sm text-gray-900 dark:text-gray-100">
                                            <div class="flex items-center space-x-2">
                                                <i data-feather="{{ $ativo->status ? 'check-circle' : 'x-circle' }}"
                                                   class="{{ $ativo->status ? 'text-green-600' : 'text-red-600' }} w-5 h-5"></i>
                                                @if (optional($ativosDisp->firstWhere('ativo_id', $ativo->id))->quantidade_disp <= $ativo->quantidade_min)
                                                    <i data-feather="alert-circle" class="text-red-500 w-5 h-5"></i>
                                                @endif
                                            </div>
                                        </td>
                                        <td class="p-4">
                                            <div class="flex gap-2 justify-center">
                                                {{-- <x-secondary-button onclick="searchProdutos('{{ $ativo->descricao }}')"
                                                                   class="p-2 bg-gray-200 dark:bg-gray-700 hover:bg-gray-300 dark:hover:bg-gray-600">
                                                    <i data-feather="dollar-sign" class="w-4 h-4"></i>
                                                </x-secondary-button> --}}
                                                {{-- <x-secondary-button onclick="openEditModal({{ $ativo->id }})"
                                                                   class="p-2 bg-gray-200 dark:bg-gray-700 hover:bg-gray-300 dark:hover:bg-gray-600">
                                                    <i data-feather="edit" class="w-4 h-4"></i>
                                                </x-secondary-button> --}}
                                                <x-secondary-button onclick="openDetailsAtivo({{ $ativo->id }})"
                                                    class="p-2 bg-gray-200 dark:bg-gray-700 hover:bg-gray-300 dark:hover:bg-gray-600">
                                                    <i data-feather="more-vertical" class="w-4 h-4"></i>
                                                </x-secondary-button>
                                                <x-danger-button onclick="deleteAtivo('{{ $ativo->id }}')"
                                                                class="p-2 bg-red-500 dark:bg-red-600 hover:bg-red-600 dark:hover:bg-red-700">
                                                    <i data-feather="x" class="w-4 h-4"></i>
                                                </x-danger-button>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="7" class="p-4 text-center text-gray-500 dark:text-gray-400">{{ __('Nenhum ativo encontrado.') }}</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <!-- Cards para Mobile -->
                    <div class="md:hidden space-y-4">
                        @forelse ($ativos as $ativo)
                            <div x-data="{ open: false }" class="bg-white dark:bg-gray-800 rounded-lg shadow-sm border border-gray-200 dark:border-gray-600">
                                <div @click="open = !open" class="p-4 flex items-center cursor-pointer hover:bg-gray-50 dark:hover:bg-gray-600 transition-colors">
                                    <div class="flex-shrink-0 w-16 h-16 mr-4">
                                        @if ($ativo->imagem)
                                            <img src="{{ Storage::url($ativo->imagem) }}" alt="Imagem do ativo"
                                                 class="w-full h-full object-cover rounded-lg">
                                        @else
                                            <div class="w-full h-full bg-gray-100 dark:bg-gray-700 rounded-lg flex items-center justify-center text-gray-500 dark:text-gray-400 text-xs">
                                                {{ __('Sem imagem') }}
                                            </div>
                                        @endif
                                    </div>
                                    <div class="flex-grow">
                                        <h3 class="font-medium text-gray-900 dark:text-gray-100">{{ $ativo->descricao }}</h3>
                                        <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">
                                            {{ optional($ativo->marca)->descricao ?? 'Sem marca' }}
                                        </p>
                                    </div>
                                    <i data-feather="chevron-down" class="w-5 h-5 text-gray-500" :class="{'rotate-180': open}"></i>
                                </div>
                                <div x-show="open" x-transition class="p-4 border-t border-gray-200 dark:border-gray-600 space-y-3 text-sm">
                                    <div class="grid grid-cols-2 gap-2">
                                        <span class="text-gray-600 dark:text-gray-400">{{ __('Tipo:') }}</span>
                                        <span class="text-gray-900 dark:text-gray-100">{{ optional($ativo->tipo)->descricao ?? 'N/A' }}</span>
                                        <span class="text-gray-600 dark:text-gray-400">{{ __('Total:') }}</span>
                                        <span class="text-gray-900 dark:text-gray-100">{{ $ativo->quantidade }}</span>
                                        <span class="text-gray-600 dark:text-gray-400">{{ __('Disponível:') }}</span>
                                        <span class="text-gray-900 dark:text-gray-100">
                                            {{ optional($ativosDisp->firstWhere('ativo_id', $ativo->id))->quantidade_disp ?? 0 }}
                                        </span>
                                        <span class="text-gray-600 dark:text-gray-400">{{ __('Mínimo:') }}</span>
                                        <span class="text-gray-900 dark:text-gray-100">{{ $ativo->quantidade_min }}</span>
                                        <span class="text-gray-600 dark:text-gray-400">{{ __('Status:') }}</span>
                                        <span class="{{ $ativo->status ? 'text-green-600' : 'text-red-600' }}">
                                            {{ $ativo->status ? 'Ativo' : 'Inativo' }}
                                            @if (optional($ativosDisp->firstWhere('ativo_id', $ativo->id))->quantidade_disp <= $ativo->quantidade_min)
                                                <i data-feather="alert-circle" class="text-red-500 w-4 h-4 inline"></i>
                                            @endif
                                        </span>
                                    </div>
                                    <div class="flex justify-end gap-2">
                                        <a href="{{ route('ativos.show', ['id' => $ativo->id]) }}">
                                            <x-secondary-button class="p-2">
                                                {{ __('Ver mais') }}
                                            </x-secondary-button>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <div class="text-center p-4 text-gray-500 dark:text-gray-400">{{ __('Nenhum ativo encontrado.') }}</div>
                        @endforelse
                    </div>

                    <!-- Paginação -->
                    <div class="mt-6 flex justify-center">
                        {{ $ativos->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modais -->
    @include('ativos.partials.create-modal')
    @include('ativos.partials.edit-modal')

    <script>
        function openCreateModal() {
            document.getElementById('ativo-modal').classList.remove('hidden');
        }

        function toggleMarcaForm() {
            document.getElementById('nova-marca-form').classList.toggle('hidden');
            document.getElementById('id_marca').disabled = !document.getElementById('nova-marca-form').classList.contains('hidden');
        }

        function toggleTipoForm() {
            document.getElementById('novo-tipo-form').classList.toggle('hidden');
            document.getElementById('id_tipo').disabled = !document.getElementById('novo-tipo-form').classList.contains('hidden');
        }

        function previewImagem(event) {
            const preview = document.getElementById('imagem-preview');
            const file = event.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function (e) {
                    preview.src = e.target.result;
                    preview.classList.remove('hidden');
                };
                reader.readAsDataURL(file);
            }
        }

        function openEditModal(id) {
            const form = document.getElementById('editForm');
            form.action = `/ativos/${id}`;
            fetch(`/ativos/${id}`)
                .then(response => response.json())
                .then(data => {
                    document.getElementById('descricao-edit').value = data.descricao || '';
                    document.getElementById('marca_id-edit').value = data.id_marca || '';
                    document.getElementById('tipo_id-edit').value = data.id_tipo || '';
                    document.getElementById('quantidade-edit').value = data.quantidade || '';
                    document.getElementById('quantidade_min-edit').value = data.quantidade_min || '';
                    document.getElementById('observacao-edit').value = data.observacao || '';
                    document.getElementById('status-edit').value = data.status || '';
                    const imgPreview = document.getElementById('imagem-preview-edit');
                    const imgMessage = document.getElementById('imagem-message-edit');
                    if (data.imagem) {
                        imgPreview.src = `${window.location.origin}/storage/${data.imagem}`;
                        imgPreview.classList.remove('hidden');
                        imgMessage.classList.add('hidden');
                    } else {
                        imgPreview.classList.add('hidden');
                        imgMessage.classList.remove('hidden');
                        imgMessage.textContent = "Nenhuma imagem disponível.";
                    }
                    document.getElementById('editar-ativo-modal').classList.remove('hidden');
                })
                .catch(error => console.error('Erro ao buscar os dados:', error));
        }

        function closeModal(modalId) {
            document.getElementById(modalId).classList.add('hidden');
        }

        async function deleteAtivo(id) {
            if (!confirm('Tem certeza que deseja excluir este ativo?')) return;
            try {
                const response = await fetch(`/ativos/${id}`, {
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
                    alert(result.message || 'Erro ao excluir ativo');
                }
            } catch (error) {
                console.error('Erro:', error);
                alert('Erro na requisição');
            }
        }

        function openDetailsAtivo(id) {
            window.location.href = `/ativos/${id}`;
        }

        function searchProdutos(descricao) {
            const url = new URL('{{ route('produtos.index') }}');
            url.searchParams.append('search', encodeURIComponent(descricao));
            window.location.href = url.toString();
        }

        document.addEventListener('DOMContentLoaded', function () {
            feather.replace();
        });
    </script>
</x-app-layout>