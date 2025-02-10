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
                    <!-- Botão para abrir o modal de criação -->
                    <div class="py-4">
                        <x-primary-button onclick="openCreateModal()" class="px-3 py-2 bg-green-500 text-white rounded">
                            Adicionar Ativo
                        </x-primary-button>
                    </div>

                    <!-- Tabela de Ativos -->
                    <table class="table-auto w-full border-collapse border border-gray-300 dark:border-gray-700">
                        <thead class="bg-gray-200 dark:bg-gray-700 text-gray-700 dark:text-gray-200">
                            <tr>
                                <th class="border border-gray-300 dark:border-gray-600 px-4 py-2 text-left">Imagem</th>
                                <th class="border border-gray-300 dark:border-gray-600 px-4 py-2 text-left">Descrição
                                </th>
                                <th class="border border-gray-300 dark:border-gray-600 px-4 py-2 text-left">Marca</th>
                                <th class="border border-gray-300 dark:border-gray-600 px-4 py-2 text-left">Tipo</th>
                                <th class="border border-gray-300 dark:border-gray-600 px-4 py-2 text-left">Quantidade
                                </th>
                                <th class="border border-gray-300 dark:border-gray-600 px-4 py-2 text-left">Disponível
                                </th>
                                <th class="border border-gray-300 dark:border-gray-600 px-4 py-2 text-left">Status</th>
                                <th class="border border-gray-300 dark:border-gray-600 px-4 py-2 text-left">Cadastrado
                                    Em</th>
                                <th class="border border-gray-300 dark:border-gray-600 px-4 py-2 text-left">Observação
                                </th>
                                <th class="border border-gray-300 dark:border-gray-600 px-4 py-2 text-left">Ações</th>
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
                                        {{ $ativo->quantidade_total }}
                                    </td>
                                    <td class="border border-gray-300 dark:border-gray-600 px-4 py-2">
                                        {{ $ativo->quantidade_disp }}
                                    </td>
                                    <td class="border border-gray-300 dark:border-gray-600 px-4 py-2">
                                        <span class="{{ $ativo->status ? 'text-green-600' : 'text-red-600' }}">
                                            {{ $ativo->status ? 'Ativo' : 'Inativo' }}
                                        </span>
                                    </td>
                                    <td class="border border-gray-300 dark:border-gray-600 px-4 py-2">
                                        {{ $ativo->created_at->format('d/m/Y H:i') }}
                                    </td>
                                    <td class="border border-gray-300 dark:border-gray-600 px-4 py-2">
                                        {{ $ativo->observacao ?? 'N/A' }}
                                    </td>
                                    <td class="border border-gray-300 dark:border-gray-600 px-4 py-2">
                                        <div class="flex gap-2 items-center">
                                            <x-secondary-button
                                                onclick="openEditModal({{ json_encode([
                                                    'id' => $ativo->id,
                                                    'descricao' => $ativo->descricao,
                                                    'id_marca' => $ativo->id_marca,
                                                    'id_tipo' => $ativo->id_tipo,
                                                    'quantidade_total' => $ativo->quantidade_total,
                                                    'observacao' => $ativo->observacao,
                                                    'status' => $ativo->status,
                                                    'imagem_url' => $ativo->imagem ? Storage::url($ativo->imagem) : null,
                                                ]) }})"
                                                class="text-white rounded">
                                                <i data-feather="edit" width="20"></i>
                                            </x-secondary-button>

                                            <x-danger-button onclick="deleteAtivo('{{ $ativo->id }}')"
                                                class="bg-red-500 rounded">
                                                <i data-feather="x" width="20"></i>
                                            </x-danger-button>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="10" class="text-center py-4">Nenhum ativo encontrado.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
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

        // Funções do Modal de Edição
        function openEditModal(data) {
            const form = document.getElementById('editForm');
            form.action = `/ativos/${data.id}`;

            // Preencher campos do formulário
            document.getElementById('descricao-edit').value = data.descricao;
            document.getElementById('id_marca-edit').value = data.id_marca;
            document.getElementById('id_tipo-edit').value = data.id_tipo;
            document.getElementById('quantidade_total-edit').value = data.quantidade_total;
            document.getElementById('observacao-edit').value = data.observacao;
            document.getElementById('status-edit').value = data.status;

            // Exibir imagem atual
            const imgPreview = document.getElementById('imagem-preview');
            if (data.imagem_url) {
                imgPreview.src = data.imagem_url;
                imgPreview.classList.remove('hidden');
            } else {
                imgPreview.classList.add('hidden');
            }

            document.getElementById('editar-ativo-modal').classList.remove('hidden');
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
    </script>
</x-app-layout>
