<div id="ativo-modal" class="fixed inset-0 z-50 hidden bg-black bg-opacity-50 flex items-center justify-center p-4">
    <div class="bg-white dark:bg-gray-800 p-6 rounded-lg shadow-lg w-full max-w-md sm:max-w-lg max-h-[90vh] overflow-y-auto transform transition-all duration-300"
        onclick="event.stopPropagation()">
        <!-- Cabeçalho com título e botão de fechar -->
        <div class="flex justify-between items-center mb-4">
            <h3 class="text-lg font-semibold text-gray-800 dark:text-gray-100">Cadastrar Novo Ativo</h3>
            <button type="button" class="text-gray-500 hover:text-gray-700 focus:outline-none"
                onclick="closeModal('ativo-modal')">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
        </div>

        <form action="{{ route('ativos.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="space-y-4">
                <!-- Campos ocultos -->
                <input type="hidden" name="id_local" value="1">
                <input type="hidden" name="status" value="1">

                <!-- Descrição -->
                <div>
                    <label for="descricao"
                        class="block text-sm font-medium text-gray-700 dark:text-gray-300">Descrição*</label>
                    <input type="text" name="descricao" id="descricao"
                        class="w-full px-3 py-2 border border-gray-300 dark:border-gray-700 rounded-md focus:outline-none focus:ring focus:border-blue-300"
                        required>
                </div>

                <!-- Marca -->
                <div>
                    <label for="id_marca"
                        class="block text-sm font-medium text-gray-700 dark:text-gray-300">Marca</label>
                    <div class="flex gap-2">
                        <select name="id_marca" id="id_marca"
                            class="flex-1 px-3 py-2 border border-gray-300 dark:border-gray-700 rounded-md focus:outline-none focus:ring focus:border-blue-300">
                            <option value="">Selecione</option>
                            @foreach ($marcas as $marca)
                                <option value="{{ $marca->id }}">{{ $marca->descricao }}</option>
                            @endforeach
                        </select>
                        <button type="button" onclick="toggleMarcaForm()"
                            class="px-2 text-blue-500 hover:text-blue-700 focus:outline-none"><i data-feather="plus"
                                width="20"></i></button>
                    </div>
                    <div id="nova-marca-form" class="hidden mt-2">
                        <input type="text" name="nova_marca" placeholder="Nova Marca"
                            class="w-full px-3 py-2 border border-gray-300 dark:border-gray-700 rounded-md focus:outline-none focus:ring focus:border-blue-300">
                    </div>
                </div>

                <!-- Tipo -->
                <div>
                    <label for="id_tipo"
                        class="block text-sm font-medium text-gray-700 dark:text-gray-300">Tipo</label>
                    <div class="flex gap-2">
                        <select name="id_tipo" id="id_tipo"
                            class="flex-1 px-3 py-2 border border-gray-300 dark:border-gray-700 rounded-md focus:outline-none focus:ring focus:border-blue-300">
                            <option value="">Selecione</option>
                            @foreach ($tipos as $tipo)
                                <option value="{{ $tipo->id }}">{{ $tipo->descricao }}</option>
                            @endforeach
                        </select>
                        <button type="button" onclick="toggleTipoForm()"
                            class="px-2 text-blue-500 hover:text-blue-700 focus:outline-none"><i data-feather="plus"
                                width="20"></i></button>
                    </div>
                    <div id="novo-tipo-form" class="hidden mt-2">
                        <input type="text" name="novo_tipo" placeholder="Novo Tipo"
                            class="w-full px-3 py-2 border border-gray-300 dark:border-gray-700 rounded-md focus:outline-none focus:ring focus:border-blue-300">
                    </div>
                </div>

                <!-- Quantidade -->
                <div>
                    <label for="quantidade"
                        class="block text-sm font-medium text-gray-700 dark:text-gray-300">Quantidade*</label>
                    <input type="number" name="quantidade_total" id="quantidade"
                        class="w-full px-3 py-2 border border-gray-300 dark:border-gray-700 rounded-md focus:outline-none focus:ring focus:border-blue-300"
                        min="1" value="" required>
                </div>

                <!-- Observação -->
                <div>
                    <label for="observacao"
                        class="block text-sm font-medium text-gray-700 dark:text-gray-300">Observação</label>
                    <textarea name="observacao" id="observacao"
                        class="w-full px-3 py-2 border border-gray-300 dark:border-gray-700 rounded-md focus:outline-none focus:ring focus:border-blue-300"></textarea>
                </div>


                <div>
                    <label for="imagem"
                        class="block text-sm font-medium text-gray-700 dark:text-gray-300">Imagem</label>

                    <!-- Container para o input e a pré-visualização -->
                    <div class="flex flex-col items-center">
                        <!-- Pré-visualização da imagem -->
                        <img id="imagem-preview" class="mb-2 max-h-32 object-contain rounded-md hidden"
                            alt="Pré-visualização da imagem">

                        <!-- Input de arquivo oculto -->
                        <input type="file" name="imagem" id="imagem" accept="image/*" class="hidden"
                            onchange="previewImagem(event)">

                        <!-- Botão estilizado para disparar o input -->
                        <button type="button" onclick="document.getElementById('imagem').click()"
                            class="px-4 py-2 text-white bg-blue-500 rounded-md hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-400 transition-colors">
                            Selecionar Imagem
                        </button>
                    </div>
                </div>




                <!-- Imagem -->
                {{-- <div>
                    <label for="imagem"
                        class="block text-sm font-medium text-gray-700 dark:text-gray-300">Imagem</label>
                    <input type="file" name="imagem" id="imagem"
                        class="w-full px-3 py-2 border border-gray-300 dark:border-gray-700 rounded-md focus:outline-none focus:ring focus:border-blue-300"
                        accept="image/*">
                </div> --}}
            </div>

            <!-- Botões de Ação -->
            <div class="flex justify-end gap-2 mt-6">
                <x-primary-button type="submit">Cadastrar</x-primary-button>
                <x-secondary-button type="button" onclick="closeModal('ativo-modal')">Cancelar</x-secondary-button>
            </div>
        </form>
    </div>
</div>
