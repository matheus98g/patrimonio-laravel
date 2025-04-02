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
                            <input type="text" name="search"
                                class="w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-100 focus:border-indigo-500 focus:ring-indigo-500"
                                placeholder="Buscar ativos por descrição, observação, status..."
                                value="{{ request('search') }}">
                            <x-primary-button type="submit" class="shrink-0">
                                Buscar
                            </x-primary-button>
                        </form>
                    </div>

                    <div class="py-6">
                            <a href="{{ route('ativos.create') }}">
                                <x-primary-button>
                                    Adicionar Ativo
                                </x-primary-button>
                            </a>
                    </div>
                    
                    

                    <!-- Tabela para Desktop -->
                    <div class="hidden md:block">
                        <div class="overflow-x-auto">
                            <table class="w-full border-collapse">
                                <thead class="bg-gray-100 dark:bg-gray-700">
                                    <tr>
                                        <th class="p-3 text-center text-sm font-medium text-gray-900 dark:text-gray-200">{{ ('Imagem') }}</th>
                                        <th class="p-3 text-center text-sm font-medium text-gray-900 dark:text-gray-200">{{ ('Descrição') }}</th>
                                        <th class="p-3 text-center text-sm font-medium text-gray-900 dark:text-gray-200">{{ ('Disponível') }}</th>
                                        <th class="p-3 text-center text-sm font-medium text-gray-900 dark:text-gray-200">{{ ('Total') }}</th>
                                        <th class="p-3 text-center text-sm font-medium text-gray-900 dark:text-gray-200">{{ ('Mínimo') }}</th>
                                        <th class="p-3 text-center text-sm font-medium text-gray-900 dark:text-gray-200">{{ ('Status') }}</th>
                                        <th class="p-3 text-center text-sm font-medium text-gray-900 dark:text-gray-200">{{ ('Ações') }}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($ativos as $ativo)
                                        <tr class="bg-white dark:bg-gray-800 hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors duration-150"
                                            id="row-{{ $ativo->id }}">
                                            <td class="border border-gray-200 dark:border-gray-600 px-4 py-2 text-center">
                                                @if ($ativo->imagem)
                                                    <div class="flex justify-center">
                                                        <div class="relative w-20 h-20 md:w-24 md:h-24 overflow-hidden rounded-lg shadow-sm hover:shadow-md transition-shadow">
                                                            <img src="{{ Storage::url($ativo->imagem) }}"
                                                                 alt="Imagem do ativo {{ $ativo->descricao }}"
                                                                 class="w-full h-full object-cover hover:scale-105 transition-transform duration-200">
                                                        </div>
                                                    </div>
                                                @else
                                                    <div class="w-20 h-20 md:w-24 md:h-24 bg-gray-100 dark:bg-gray-700 rounded-lg flex items-center justify-center text-gray-500 dark:text-gray-400">
                                                        {{ ('Sem imagem') }}
                                                    </div>
                                                @endif
                                            </td>
                                            <td class="border border-gray-200 dark:border-gray-600 px-4 py-2 text-center text-gray-700 dark:text-gray-300">
                                                {{ $ativo->descricao ?? 'N/A' }}
                                            </td>
                                            <td class="border border-gray-200 dark:border-gray-600 px-4 py-2 text-center text-gray-700 dark:text-gray-300">
                                                @php
                                                    $quantidadeDisp = optional($ativosDisp->firstWhere('ativo_id', $ativo->id))->quantidade_disp ?? 0;
                                                @endphp
                                                {{ $quantidadeDisp }}
                                            </td>
                                            <td class="border border-gray-200 dark:border-gray-600 px-4 py-2 text-center text-gray-700 dark:text-gray-300">
                                                {{ $ativo->quantidade }}
                                            </td>
                                            <td class="border border-gray-200 dark:border-gray-600 px-4 py-2 text-center text-gray-700 dark:text-gray-300">
                                                {{ $ativo->quantidade_min }}
                                            </td>
                                            <td class="border border-gray-200 dark:border-gray-600 px-4 py-2 text-center">
                                                <div class="flex justify-center items-center space-x-2">
                                                    <div class="relative group inline-block">
                                                        <i data-feather="{{ $ativo->status ? 'check-circle' : 'x-circle' }}"
                                                           class="{{ $ativo->status ? 'text-green-600' : 'text-red-600' }} w-5 h-5"></i>
                                                        <div class="absolute left-1/2 transform -translate-x-1/2 bottom-full mb-2 hidden group-hover:block px-2 py-1 text-sm text-gray-200 bg-gray-900 dark:bg-gray-800 rounded-md">
                                                            {{ $ativo->status ? 'Ativo' : 'Inativo' }}
                                                        </div>
                                                    </div>
                                                    @if ($quantidadeDisp <= $ativo->quantidade_min)
                                                        <div class="relative group">
                                                            <i data-feather="alert-circle" class="text-red-500 w-5 h-5"></i>
                                                            <div class="absolute left-1/2 transform -translate-x-1/2 bottom-full mb-2 hidden group-hover:block px-2 py-1 text-sm text-gray-200 bg-gray-900 dark:bg-gray-800 rounded-md">
                                                                {{ ('Estoque abaixo do mínimo!') }}
                                                            </div>
                                                        </div>
                                                    @endif
                                                </div>
                                            </td>
                                            <td class="border border-gray-200 dark:border-gray-600 px-4 py-2 text-center">
                                                <div class="flex gap-3 items-center justify-center">
                                                    <!-- Botão de busca de produtos -->
                                                    <x-secondary-button onclick="searchProdutos('{{ $ativo->descricao }}')"
                                                                       class="bg-gray-200 dark:bg-gray-700 text-gray-800 dark:text-gray-200 hover:bg-gray-300 dark:hover:bg-gray-600">
                                                        <i data-feather="dollar-sign" class="w-5 h-5"></i>
                                                    </x-secondary-button>
                    
                                                    <!-- Botão de editar -->
                                                    <x-secondary-button onclick="openEditModal({{ $ativo->id }})"
                                                                       class="bg-gray-200 dark:bg-gray-700 text-gray-800 dark:text-gray-200 hover:bg-gray-300 dark:hover:bg-gray-600">
                                                        <i data-feather="edit" class="w-5 h-5"></i>
                                                    </x-secondary-button>
                    
                                                    <!-- Botão de excluir -->
                                                    <x-danger-button onclick="deleteAtivo('{{ $ativo->id }}')"
                                                                    class="bg-red-500 dark:bg-red-600 text-white hover:bg-red-600 dark:hover:bg-red-700">
                                                        <i data-feather="x" class="w-5 h-5"></i>
                                                    </x-danger-button>
                    
                                                    <!-- Botão de detalhes -->
                                                    <x-secondary-button onclick="openDetailsAtivo({{ $ativo->id }})"
                                                                       class="bg-gray-200 dark:bg-gray-700 text-gray-800 dark:text-gray-200 hover:bg-gray-300 dark:hover:bg-gray-600">
                                                        <i data-feather="more-vertical" class="w-5 h-5"></i>
                                                    </x-secondary-button>
                                                </div>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="7" class="text-center p-4 text-gray-500 dark:text-gray-400">{{ ('Nenhum ativo encontrado.') }}</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
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
                                                            <x-secondary-button onclick="openEditModal({{ json_encode([
                                'id' => $ativo->id,
                                'descricao' => $ativo->descricao,
                                'marca_id' => $ativo->id_marca,
                                'tipo_id' => $ativo->id_tipo,
                                'quantidade' => $ativo->quantidade,
                                'quantidade_min' => $ativo->quantidade_min,
                                'observacao' => $ativo->observacao,
                                'status' => $ativo->status,
                                'imagem_url' => $ativo->imagem ? Storage::url($ativo->imagem) : null,
                            ]) }})" class="text-gray-900 rounded">
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
        // cadastrar ativo

        function openCreateModal() {
            document.getElementById('ativo-modal').classList.remove('hidden');
        }


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
                reader.onload = function (e) {
                    preview.src = e.target.result;
                    preview.classList.remove('hidden'); // Exibe a imagem
                };
                reader.readAsDataURL(file);
            }
        }

        // editar ativo

        function openEditModal(id) {
            const form = document.getElementById('editForm');
            form.action = `/ativos/${id}`;

            fetch(`/ativos/${id}`)
                .then(response => response.json())
                .then(data => {
                    console.log(data);

                    // Preencher campos do formulário com os dados da resposta
                    document.getElementById('descricao-edit').value = data.descricao || '';
                    document.getElementById('marca_id-edit').value = data.id_marca || '';
                    document.getElementById('tipo_id-edit').value = data.id_tipo || '';
                    document.getElementById('quantidade-edit').value = data.quantidade || '';
                    document.getElementById('quantidade_min-edit').value = data.quantidade_min || '';
                    document.getElementById('observacao-edit').value = data.observacao || '';
                    document.getElementById('status-edit').value = data.status || '';

                    const imgPreview = document.getElementById('imagem-preview-edit');
                    const imgMessage = document.getElementById('imagem-message-edit'); // Elemento de texto para a mensagem

                    if (data.imagem) {
                        imgPreview.setAttribute("src", `${window.location.origin}/storage/${data.imagem}`);
                        imgPreview.classList.remove('hidden');
                        imgMessage.classList.add('hidden'); // Esconde a mensagem
                        console.log("Imagem renderizada com src:", imgPreview.src);
                    } else {
                        imgPreview.classList.add('hidden'); // Esconde a imagem
                        imgMessage.classList.remove('hidden'); // Exibe a mensagem
                        imgMessage.textContent = "Nenhuma imagem disponível.";
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

        function openDetailsAtivo(id) {
            let url = `/ativos/details/${id}`; // Monta a URL da rota
            window.location.href = url; // Redireciona para a página de detalhes
        }

        // Função para redirecionar com o parâmetro de busca
        function searchProdutos(descricao) {
            const url = new URL('{{ route('produtos.index') }}');
            url.searchParams.append('search', encodeURIComponent(descricao));
            window.location.href = url.toString();
        }

        // Inicializar Feather Icons
        document.addEventListener('DOMContentLoaded', function () {
            feather.replace();
        });


    </script>

</x-app-layout>