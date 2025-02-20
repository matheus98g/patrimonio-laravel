<div id="editar-ativo-modal"
    class="fixed inset-0 z-50 hidden bg-black bg-opacity-50 flex items-center justify-center p-4">
    <div class="bg-white dark:bg-gray-800 p-6 rounded-lg shadow-lg w-full max-w-md sm:max-w-lg max-h-[90vh] overflow-y-auto transform transition-all duration-300"
        onclick="event.stopPropagation()">
        <!-- Cabeçalho com título e botão de fechar -->
        <div class="flex justify-between items-center mb-4">
            <h3 class="text-lg font-semibold text-gray-800 dark:text-gray-100">Editar Ativo</h3>
            <button type="button" class="text-gray-500 hover:text-gray-700 focus:outline-none"
                onclick="closeModal('editar-ativo-modal')">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
        </div>

        <form id="editForm" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <!-- Layout dos campos em coluna; para desktop, mantemos um max-width e espaçamento adequado -->
            <div class="space-y-4">
                <!-- Campo Descrição -->
                <div>
                    <label for="descricao-edit"
                        class="block text-sm font-medium text-gray-700 dark:text-gray-300">Descrição</label>
                    <input type="text" name="descricao" id="descricao-edit"
                        class="w-full px-3 py-2 border border-gray-300 dark:border-gray-700 rounded-md focus:outline-none focus:ring focus:border-blue-300"
                        required>
                </div>



                <!-- Campo Marca -->
                <div>
                    <label for="id_marca-edit"
                        class="block text-sm font-medium text-gray-700 dark:text-gray-300">Marca</label>
                    <div class="relative">
                        <select name="id_marca" id="id_marca-edit"
                            class="w-full px-3 py-2 border border-gray-300 dark:border-gray-700 rounded-md focus:outline-none focus:ring focus:border-blue-300 appearance-none pr-8">
                            <option value="">Selecione</option>
                            @foreach ($marcas as $marca)
                                <option value="{{ $marca->id }}">{{ $marca->descricao }}</option>
                            @endforeach
                        </select>
                        <div class="absolute top-1/2 right-3 transform -translate-y-1/2 pointer-events-none">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-500" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M19 9l-7 7-7-7" />
                            </svg>
                        </div>
                    </div>
                </div>

                <!-- Campo Tipo -->
                <div>
                    <label for="id_tipo-edit"
                        class="block text-sm font-medium text-gray-700 dark:text-gray-300">Tipo</label>
                    <div class="relative">
                        <select name="id_tipo" id="id_tipo-edit"
                            class="w-full px-3 py-2 border border-gray-300 dark:border-gray-700 rounded-md focus:outline-none focus:ring focus:border-blue-300 appearance-none pr-8">
                            <option value="">Selecione</option>
                            @foreach ($tipos as $tipo)
                                <option value="{{ $tipo->id }}">{{ $tipo->descricao }}</option>
                            @endforeach
                        </select>
                        <div class="absolute top-1/2 right-3 transform -translate-y-1/2 pointer-events-none">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-500" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M19 9l-7 7-7-7" />
                            </svg>
                        </div>
                    </div>
                </div>


                <!-- Campo Quantidade -->
                <div>
                    <label for="quantidade"
                        class="block text-sm font-medium text-gray-700 dark:text-gray-300">Quantidade</label>
                    <input type="number" name="quantidade" id="quantidade-edit"
                        class="w-full px-3 py-2 border border-gray-300 dark:border-gray-700 rounded-md focus:outline-none focus:ring focus:border-blue-300"
                        min="1" required>
                </div>

                <!-- Campo Quantidade minima -->
                <div>
                    <label for="quantidade_min"
                        class="block text-sm font-medium text-gray-700 dark:text-gray-300">Quantidade Minima</label>
                    <input type="number" name="quantidade_min" id="quantidade_min-edit"
                        class="w-full px-3 py-2 border border-gray-300 dark:border-gray-700 rounded-md focus:outline-none focus:ring focus:border-blue-300"
                        min="1" required>
                </div>

                <!-- Campo Status -->
                <div>
                    <label for="status-edit"
                        class="block text-sm font-medium text-gray-700 dark:text-gray-300">Status</label>
                    <div class="relative">
                        <select name="status" id="status-edit"
                            class="w-full px-3 py-2 border border-gray-300 dark:border-gray-700 rounded-md focus:outline-none focus:ring focus:border-blue-300 appearance-none pr-8">
                            <option value="1">Ativo</option>
                            <option value="0">Inativo</option>
                        </select>
                        <div class="absolute top-1/2 right-3 transform -translate-y-1/2 pointer-events-none">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-500" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M19 9l-7 7-7-7" />
                            </svg>
                        </div>
                    </div>
                </div>

                <!-- Campo Observação -->
                <div>
                    <label for="observacao-edit"
                        class="block text-sm font-medium text-gray-700 dark:text-gray-300">Observação</label>
                    <textarea name="observacao" id="observacao-edit"
                        class="w-full px-3 py-2 border border-gray-300 dark:border-gray-700 rounded-md focus:outline-none focus:ring focus:border-blue-300"></textarea>
                </div>

                <!-- Campo Imagem com preview e botão estilizado -->
                <div class="mb-4">
                    <label for="imagem-edit"
                        class="block text-sm font-medium text-gray-700 dark:text-gray-300">Imagem</label>
                    <div class="flex flex-col items-center">
                        <!-- Pré-visualização da imagem -->
                        <img id="imagem-preview" class="mb-2 max-h-32 object-contain rounded-md hidden"
                            alt="Pré-visualização da imagem">
                        <!-- Input de arquivo oculto -->
                        <input type="file" name="imagem" id="imagem-edit" accept="image/*" class="hidden"
                            onchange="previewImagem(event)">
                        <!-- Botão estilizado para disparar o input -->
                        <x-primary-button type="button" onclick="document.getElementById('imagem-edit').click()"
                            class="w-32 sm:w-auto px-4 py-2 text-white rounded-md focus:outline-none focus:ring-2 focus:ring-blue-400 transition-colors">
                            Editar Imagem
                        </x-primary-button>
                    </div>
                </div>
            </div>

            <!-- Botões de Ação -->
            <div class="flex justify-between items-center space-x-4 mt-4">
                <x-secondary-button type="button"
                    onclick="closeModal('editar-ativo-modal')">Cancelar</x-secondary-button>
                <x-primary-button type="submit">Salvar</x-primary-button>
            </div>
        </form>
    </div>
</div>
