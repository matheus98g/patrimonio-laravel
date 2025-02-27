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
                    <!-- Formulário de busca -->
                        <div class="mb-6">
                            <form method="GET" action="{{ route('ativos.index') }}" class="flex gap-2">
                                <input 
                                    type="text" 
                                    name="search" 
                                    class="w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-100 focus:border-indigo-500 focus:ring-indigo-500" 
                                    placeholder="Buscar ativos por descrição, observação, status..." 
                                    value="{{ request('search') }}"
                                >
                                <x-primary-button type="submit" class="shrink-0">
                                    Buscar
                                </x-primary-button>
                            </form>
                        </div>

                    <!-- Botão para abrir o modal de criação -->
                    <div class="py-6">
                        <x-primary-button onclick="openCreateModal()" class="px-4 bg-green-500 text-white rounded-lg">
                            Adicionar Ativo
                        </x-primary-button>
                    </div>

                    <!-- Tabela para Desktop -->
                    <div class="hidden md:block">
                        <table class="w-full border-collapse">
                            <thead class="bg-gray-100 dark:bg-gray-700">
                                <tr>
                                    <th class="p-3 text-left text-sm">Imagem</th>
                                    <th class="p-3 text-left text-sm">Descrição</th>
                                    <th class="p-3 text-left text-sm">Marca</th>
                                    <th class="p-3 text-left text-sm">Tipo</th>
                                    <th class="p-3 text-left text-sm">Disponivel</th>
                                    <th class="p-3 text-left text-sm">Total</th>
                                    <th class="p-3 text-left text-sm">Mínimo</th>
                                    <th class="p-3 text-left text-sm">Status</th>
                                    <th class="p-3 text-left text-sm">Ações</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($ativos as $ativo)
                                    <tr class="bg-white dark:bg-gray-800 hover:bg-gray-100 dark:hover:bg-gray-700"
                                        id="row-{{ $ativo->id }}">
                                        <td class="border border-gray-300 dark:border-gray-600 px-4 py-2">
                                            @if ($ativo->imagem)
                                                <div class="flex justify-center">
                                                    <div
                                                        class="relative w-20 h-20 md:w-24 md:h-24 overflow-hidden rounded-lg shadow-sm hover:shadow-md transition-shadow">
                                                        <img src="{{ Storage::url($ativo->imagem) }}"
                                                            alt="Imagem do ativo {{ $ativo->descricao }}"
                                                            class="w-full h-full object-cover hover:scale-105 transition-transform duration-200">
                                                    </div>
                                                </div>
                                            @endif
                                        </td>
                                        <td class="border border-gray-300 dark:border-gray-600 px-4 py-2">
                                            {{ $ativo->descricao ?? 'N/A' }}
                                        </td>
                                        <td class="border border-gray-300 dark:border-gray-600 px-4 py-2">
                                            {{ optional($ativo->marca)->descricao ?? 'N/A' }}
                                        </td>
                                        <td class="border border-gray-300 dark:border-gray-600 px-4 py-2">
                                            {{ optional($ativo->tipo)->descricao ?? 'N/A' }}
                                        </td>
                                        <td class="border border-gray-300 dark:border-gray-600 px-4 py-2">
                                            @php
                                                $quantidadeDisp =
                                                    optional($ativosDisp->firstWhere('id_ativo', $ativo->id))
                                                        ->quantidade_disp ?? 0;
                                            @endphp
                                            {{ $quantidadeDisp }}
                                        </td>
                                        <td class="border border-gray-300 dark:border-gray-600 px-4 py-2">
                                            {{ $ativo->quantidade }}
                                        </td>
                                        <td class="border border-gray-300 dark:border-gray-600 px-4 py-2">
                                            {{ $ativo->quantidade_min }}
                                        </td>
                                        <td class="border border-gray-300 dark:border-gray-600 px-4 py-2">
                                            <div class="flex justify-start items-center space-x-2">
                                                <span class="{{ $ativo->status ? 'text-green-600' : 'text-red-600' }}">
                                                </span>
                                                <div class="relative group inline-block">
                                                    <i data-feather="{{ $ativo->status ? 'check-circle' : 'x-circle' }}"
                                                        class="{{ $ativo->status ? 'text-green-600' : 'text-red-600' }}"></i>
                                                    <div class="absolute left-1/2 transform -translate-x-1/2 bottom-full mb-2 hidden group-hover:block px-2 py-1 text-sm text-gray-500 bg-black rounded-md">
                                                        {{ $ativo->status ? 'Ativo' : 'Inativo' }}
                                                    </div>
                                                </div>
                                                @if ($quantidadeDisp <= $ativo->quantidade_min)
                                                    <div class="relative group">
                                                        <i data-feather="alert-circle" class="text-red-500"></i>
                                                        <div class="absolute left-1/2 transform -translate-x-1/2 bottom-full mb-2 hidden group-hover:block px-2 py-1 text-sm text-gray-500 bg-black rounded-md">
                                                            Estoque abaixo do mínimo!
                                                        </div>
                                                    </div>
                                                @endif
                                            </div>
                                        </td>
                                        <td class="border border-gray-300 dark:border-gray-600 px-4 py-2">
                                            <div class="flex gap-2 items-center justify-center">
                                                <!-- Botão de busca de produtos -->
                                                <form method="GET" action="{{ route('produtos.index') }}" class="flex space-x-2 w-full max-w-lg">
                                                    <input type="hidden" name="search" value="{{ $ativo->descricao }}">
                                                    <x-secondary-button type="submit" class="bg-gray-200 dark:bg-gray-700 text-gray-800 dark:text-gray-200 hover:bg-gray-300 dark:hover:bg-gray-600">
                                                        <i data-feather="dollar-sign" width="20"></i>
                                                    </x-secondary-button>
                                                </form>

                                                <!-- Botão de editar -->
                                                <x-secondary-button onclick="openEditModal({{ $ativo->id }})" 
                                                    class="bg-gray-200 dark:bg-gray-700 text-gray-800 dark:text-gray-200 hover:bg-gray-300 dark:hover:bg-gray-600 rounded">
                                                    <i data-feather="edit" width="20"></i>
                                                </x-secondary-button>

                                                <!-- Botão de excluir -->
                                                <x-danger-button onclick="deleteAtivo('{{ $ativo->id }}')" 
                                                    class="bg-red-500 dark:bg-red-600 text-white hover:bg-red-600 dark:hover:bg-red-700 rounded">
                                                    <i data-feather="x" width="20"></i>
                                                </x-danger-button>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="9" class="text-center p-4">Nenhum ativo encontrado.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <!-- Cards para Mobile -->
                    <div class="md:hidden space-y-4">
                        @forelse ($ativos as $ativo)
                            <div x-data="{ open: false }"
                                class="bg-white dark:bg-gray-700 rounded-lg shadow-sm border border-gray-200 dark:border-gray-600">
                                <div @click="open = !open"
                                    class="p-4 flex items-center cursor-pointer hover:bg-gray-50 dark:hover:bg-gray-600 transition-colors">
                                    <div class="flex-shrink-0 w-16 h-16 mr-4">
                                        @if ($ativo->imagem)
                                            <img src="{{ Storage::url($ativo->imagem) }}" alt="Imagem do ativo"
                                                class="w-full h-full object-cover rounded-lg">
                                        @endif
                                    </div>
                                    <div class="flex-grow">
                                        <h3 class="font-medium text-gray-900 dark:text-gray-100">
                                            {{ $ativo->descricao }}
                                        </h3>
                                        <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">
                                            {{ optional($ativo->marca)->descricao ?? 'Sem marca' }}
                                        </p>
                                    </div>
                                </div>
                                <div x-show="open" x-transition:enter="transition ease-out duration-150"
                                    x-transition:enter-start="opacity-0 transform -translate-y-2"
                                    x-transition:enter-end="opacity-100 transform translate-y-0"
                                    x-transition:leave="transition ease-in duration-150"
                                    x-transition:leave-start="opacity-100 transform translate-y-0"
                                    x-transition:leave-end="opacity-0 transform -translate-y-2"
                                    class="p-4 border-t border-gray-200 dark:border-gray-600">
                                    <div class="space-y-3 text-sm">
                                        <div class="flex justify-between">
                                            <span class="text-gray-600 dark:text-gray-400">Tipo:</span>
                                            <span class="text-gray-900 dark:text-gray-100">
                                                {{ optional($ativo->tipo)->descricao ?? 'N/A' }}
                                            </span>
                                        </div>
                                        <div class="flex justify-between">
                                            <span class="text-gray-600 dark:text-gray-400">Quantidade Total:</span>
                                            <span class="text-gray-900 dark:text-gray-100">
                                                {{ $ativo->quantidade }}
                                            </span>
                                        </div>
                                        <div class="flex justify-between">
                                            <span class="text-gray-600 dark:text-gray-400">Quantidade Disponivel:</span>
                                            <span class="text-gray-900 dark:text-gray-100">
                                                @php
                                                    $quantidadeDisp =
                                                        optional($ativosDisp->firstWhere('id_ativo', $ativo->id))
                                                            ->quantidade_disp ?? 0;
                                                @endphp
                                                {{ $quantidadeDisp }}
                                            </span>
                                        </div>
                                        <div class="flex justify-between">
                                            <span class="text-gray-600 dark:text-gray-400">Quantidade Mínima:</span>
                                            <span class="text-gray-900 dark:text-gray-100">
                                                {{ $ativo->quantidade_min }}
                                            </span>
                                        </div>
                                        <div class="flex justify-between">
                                            <span class="text-gray-600 dark:text-gray-400">Status:</span>
                                            <span class="{{ $ativo->status ? 'text-green-600' : 'text-red-600' }}">
                                                {{ $ativo->status ? 'Ativo' : 'Inativo' }}
                                            </span>
                                            @if ($quantidadeDisp <= $ativo->quantidade_min)
                                                <br>
                                                <span class="text-red-600">
                                                    {{ 'Estoque Abaixo do Mínimo!' }}
                                                </span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="flex justify-end gap-2 mt-4">
                                        <x-secondary-button
                                            onclick="openEditModal({{ json_encode([
                                                'id' => $ativo->id,
                                                'descricao' => $ativo->descricao,
                                                'id_marca' => $ativo->id_marca,
                                                'id_tipo' => $ativo->id_tipo,
                                                'quantidade' => $ativo->quantidade,
                                                'quantidade_min' => $ativo->quantidade_min,
                                                'observacao' => $ativo->observacao,
                                                'status' => $ativo->status,
                                                'imagem_url' => $ativo->imagem ? Storage::url($ativo->imagem) : null,
                                            ]) }})"
                                            class="text-gray-900 rounded">
                                            Editar
                                        </x-secondary-button>
                                        <x-danger-button onclick="deleteAtivo('{{ $ativo->id }}')"
                                            class="text-sm px-3 py-1.5">
                                            Excluir
                                        </x-danger-button>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <div class="text-center p-4 text-gray-500">
                                Nenhum ativo encontrado.
                            </div>
                        @endforelse
                    </div>

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
        // Funções do Modal de Criação
        function openCreateModal() {
            document.getElementById('ativo-modal').classList.remove('hidden');
        }

       function openEditModal(id) {
        const form = document.getElementById('editForm');
        form.action = `/ativos/${id}`;  

        fetch(`/ativos/${id}`)  
            .then(response => response.json()) 
            .then(data => {
                console.log(data); 

                // Preencher campos do formulário com os dados da resposta
                document.getElementById('descricao-edit').value = data.descricao || '';
                document.getElementById('imagem-preview').value = data.imagem_url || '';
                document.getElementById('id_marca-edit').value = data.id_marca || '';
                document.getElementById('id_tipo-edit').value = data.id_tipo || '';
                document.getElementById('quantidade-edit').value = data.quantidade || '';
                document.getElementById('quantidade_min-edit').value = data.quantidade_min || '';
                document.getElementById('observacao-edit').value = data.observacao || '';
                document.getElementById('status-edit').value = data.status || '';

                // Exibir imagem se houver
                const imgPreview = document.getElementById('imagem-preview');
                if (data.imagem_url) {
                    imgPreview.src = data.imagem_url;
                    imgPreview.classList.remove('hidden');
                    console.log("Imagem renderizada com src:", imgPreview.src);
                } else {
                    imgPreview.classList.add('hidden');
                }

                // Exibir o modal
                document.getElementById('editar-ativo-modal').classList.remove('hidden');
            })
            .catch(error => {
                console.error('Erro ao buscar os dados:', error);
                // Pode tratar um erro aqui, mostrando uma mensagem ao usuário se necessário
            });
         }



        function closeModal(modalId) {
            document.getElementById(modalId).classList.add('hidden');
        }

        // Função para deletar
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

        // Preview de imagem no edit
        document.getElementById('imagem-edit').addEventListener('change', function(e) {
            const reader = new FileReader();
            reader.onload = function() {
                document.getElementById('imagem-preview').src = reader.result;
                document.getElementById('imagem-preview').classList.remove('hidden');
            }
            reader.readAsDataURL(e.target.files[0]);
        });

        function toggleMarcaForm() {
            document.getElementById('nova-marca-form').classList.toggle('hidden');
            document.getElementById('id_marca').disabled = !document.getElementById('nova-marca-form').classList.contains(
                'hidden');
        }

        function toggleTipoForm() {
            document.getElementById('novo-tipo-form').classList.toggle('hidden');
            document.getElementById('id_tipo').disabled = !document.getElementById('novo-tipo-form').classList.contains(
                'hidden');
        }

        function previewImagem(event) {
            const preview = document.getElementById('imagem-preview');
            const file = event.target.files[0];

            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    preview.src = e.target.result;
                    preview.classList.remove('hidden'); // Exibe a imagem
                };
                reader.readAsDataURL(file);
            }
        }

        
    </script>

</x-app-layout>
