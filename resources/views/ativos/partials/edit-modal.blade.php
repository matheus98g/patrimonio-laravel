<div id="editar-ativo-modal" class="fixed inset-0 z-50 hidden bg-black bg-opacity-50">
    <div class="bg-white dark:bg-gray-800 p-6 rounded-lg shadow-lg w-96 max-h-[90vh] overflow-y-auto"
        onclick="event.stopPropagation()">
        <h3 class="text-lg font-semibold mb-4">Editar Ativo</h3>

        <form id="editForm" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="space-y-4">
                <!-- Campos do formulário -->
                <div>
                    <label class="block mb-1">Descrição</label>
                    <input type="text" name="descricao" id="descricao-edit" class="w-full px-3 py-2 border rounded"
                        required>
                </div>

                <div>
                    <label class="block mb-1">Marca</label>
                    <select name="id_marca" id="id_marca-edit" class="w-full px-3 py-2 border rounded">
                        <option value="">Selecione</option>
                        @foreach ($marcas as $marca)
                            <option value="{{ $marca->id }}">{{ $marca->descricao }}</option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label class="block mb-1">Tipo</label>
                    <select name="id_tipo" id="id_tipo-edit" class="w-full px-3 py-2 border rounded">
                        <option value="">Selecione</option>
                        @foreach ($tipos as $tipo)
                            <option value="{{ $tipo->id }}">{{ $tipo->descricao }}</option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label class="block mb-1">Quantidade Total</label>
                    <input type="number" name="quantidade_total" id="quantidade_total-edit"
                        class="w-full px-3 py-2 border rounded" min="1" required>
                </div>

                <div>
                    <label class="block mb-1">Status</label>
                    <select name="status" id="status-edit" class="w-full px-3 py-2 border rounded">
                        <option value="1">Ativo</option>
                        <option value="0">Inativo</option>
                    </select>
                </div>

                <div>
                    <label class="block mb-1">Observação</label>
                    <textarea name="observacao" id="observacao-edit" class="w-full px-3 py-2 border rounded"></textarea>
                </div>

                <div>
                    <label class="block mb-1">Imagem</label>
                    <img id="imagem-preview" class="mb-2 max-h-32 hidden">
                    <input type="file" name="imagem" id="imagem-edit" class="w-full px-3 py-2 border rounded"
                        accept="image/*">
                </div>
            </div>

            <div class="flex justify-end gap-2 mt-6">
                <x-primary-button type="submit">Salvar</x-primary-button>
                <x-secondary-button type="button" onclick="closeModal('editar-ativo-modal')">
                    Cancelar
                </x-secondary-button>
            </div>
        </form>
    </div>
</div>
