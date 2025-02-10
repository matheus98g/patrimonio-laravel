<div id="ativo-modal" class="fixed inset-0 z-50 hidden bg-black bg-opacity-50">
    <div class="bg-white dark:bg-gray-800 p-6 rounded-lg shadow-lg w-96 max-h-[90vh] overflow-y-auto"
        onclick="event.stopPropagation()">
        <h3 class="text-lg font-semibold mb-4">Cadastrar Novo Ativo</h3>

        <form action="{{ route('ativos.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="space-y-4">
                <!-- Campos ocultos -->
                <input type="hidden" name="id_local" value="1">
                <input type="hidden" name="status" value="1">

                <!-- Descrição -->
                <div>
                    <label class="block mb-1">Descrição*</label>
                    <input type="text" name="descricao" id="descricao" class="w-full px-3 py-2 border rounded"
                        required>
                </div>

                <!-- Marca -->
                <div>
                    <label class="block mb-1">Marca</label>
                    <div class="flex gap-2">
                        <select name="id_marca" id="id_marca" class="flex-1 px-3 py-2 border rounded">
                            <option value="">Selecione</option>
                            @foreach ($marcas as $marca)
                                <option value="{{ $marca->id }}">{{ $marca->descricao }}</option>
                            @endforeach
                        </select>
                        <button type="button" onclick="toggleMarcaForm()"
                            class="px-2 text-blue-500 hover:text-blue-700">
                            +
                        </button>
                    </div>
                    <div id="nova-marca-form" class="hidden mt-2">
                        <input type="text" name="nova_marca" placeholder="Nova Marca"
                            class="w-full px-3 py-2 border rounded">
                    </div>
                </div>

                <!-- Tipo -->
                <div>
                    <label class="block mb-1">Tipo</label>
                    <div class="flex gap-2">
                        <select name="id_tipo" id="id_tipo" class="flex-1 px-3 py-2 border rounded">
                            <option value="">Selecione</option>
                            @foreach ($tipos as $tipo)
                                <option value="{{ $tipo->id }}">{{ $tipo->descricao }}</option>
                            @endforeach
                        </select>
                        <button type="button" onclick="toggleTipoForm()"
                            class="px-2 text-blue-500 hover:text-blue-700">
                            +
                        </button>
                    </div>
                    <div id="novo-tipo-form" class="hidden mt-2">
                        <input type="text" name="novo_tipo" placeholder="Novo Tipo"
                            class="w-full px-3 py-2 border rounded">
                    </div>
                </div>

                <!-- Quantidade -->
                <div>
                    <label class="block mb-1">Quantidade*</label>
                    <input type="number" name="quantidade_total" id="quantidade"
                        class="w-full px-3 py-2 border rounded" min="1" value="1" required>
                </div>

                <!-- Observação -->
                <div>
                    <label class="block mb-1">Observação</label>
                    <textarea name="observacao" class="w-full px-3 py-2 border rounded"></textarea>
                </div>

                <!-- Imagem -->
                <div>
                    <label class="block mb-1">Imagem</label>
                    <input type="file" name="imagem" class="w-full px-3 py-2 border rounded" accept="image/*">
                </div>
            </div>

            <div class="flex justify-end gap-2 mt-6">
                <x-primary-button type="submit">Cadastrar</x-primary-button>
                <x-secondary-button type="button" onclick="closeModal('ativo-modal')">
                    Cancelar
                </x-secondary-button>
            </div>
        </form>
    </div>
</div>

<script>
    // Adicionar ao script principal
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
</script>
