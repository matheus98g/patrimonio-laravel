<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-700 dark:text-gray-300 leading-tight">
            Cadastrar Novo Ativo
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    @if ($errors->any())
                        <div class="mb-4 p-3 bg-red-100 text-red-700 rounded">
                            <strong>Erros encontrados:</strong>
                            <ul class="list-disc list-inside">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form action="{{ route('ativos.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="id_local" value="1">
                        <input type="hidden" name="status" value="1">

                        <div class="mb-4">
                            <label for="descricao" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Descrição*</label>
                            <input type="text" name="descricao" id="descricao"
                                class="w-full px-4 py-2 mt-1 border rounded-md bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500"
                                required>
                        </div>

                        <div class="mb-4">
                            <label for="marca_id" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Marca</label>
                            <div class="flex gap-2">
                                <select name="marca_id" id="marca_id" class="w-full px-4 py-2 border rounded-md">
                                    <option value="">Selecione</option>
                                    @foreach ($marcas as $marca)
                                        <option value="{{ $marca->id }}">{{ $marca->descricao }}</option>
                                    @endforeach
                                </select>
                                <button type="button" onclick="toggleMarcaForm()" class="text-blue-500 hover:text-blue-700">
                                    <i data-feather="plus" width="20"></i>
                                </button>
                            </div>
                            <div id="nova-marca-form" class="hidden mt-2">
                                <input type="text" name="nova_marca" placeholder="Nova Marca" class="w-full px-4 py-2 border rounded-md">
                            </div>
                        </div>

                        <div class="mb-4">
                            <label for="tipo_id" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Tipo</label>
                            <div class="flex gap-2">
                                <select name="tipo_id" id="tipo_id" class="w-full px-4 py-2 border rounded-md">
                                    <option value="">Selecione</option>
                                    @foreach ($tipos as $tipo)
                                        <option value="{{ $tipo->id }}">{{ $tipo->descricao }}</option>
                                    @endforeach
                                </select>
                                <button type="button" onclick="toggleTipoForm()" class="text-blue-500 hover:text-blue-700">
                                    <i data-feather="plus" width="20"></i>
                                </button>
                            </div>
                            <div id="novo-tipo-form" class="hidden mt-2">
                                <input type="text" name="novo_tipo" placeholder="Novo Tipo" class="w-full px-4 py-2 border rounded-md">
                            </div>
                        </div>

                        <div class="mb-4">
                            <label for="quantidade" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Quantidade*</label>
                            <input type="number" name="quantidade" id="quantidade" min="1" required
                                class="w-full px-4 py-2 border rounded-md">
                        </div>

                        <div class="mb-4">
                            <label for="quantidade_min" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Quantidade Mínima</label>
                            <input type="number" name="quantidade_min" id="quantidade_min" min="1" required
                                class="w-full px-4 py-2 border rounded-md">
                        </div>

                        <div class="mb-4">
                            <label for="observacao" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Observação</label>
                            <textarea name="observacao" id="observacao" class="w-full px-4 py-2 border rounded-md"></textarea>
                        </div>

                        <div class="mb-4">
                            <label for="imagem" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Imagem</label>
                            <div class="flex flex-col items-center">
                                <img id="imagem-preview" class="mb-2 max-h-32 object-contain rounded-md hidden" alt="Pré-visualização">
                                <input type="file" name="imagem" id="imagem" accept="image/*" class="hidden" onchange="previewImagem(event)">
                                <button type="button" onclick="document.getElementById('imagem').click()"
                                    class="px-4 py-2 text-white bg-blue-500 rounded-md hover:bg-blue-600">
                                    Selecionar Imagem
                                </button>
                            </div>
                        </div>

                        <div class="flex justify-between items-center space-x-4 mt-6">
                            <x-secondary-button type="button" onclick="window.history.back();" class="px-6 py-3">
                                Cancelar
                            </x-secondary-button>
                            <x-primary-button type="submit" class="px-6 py-3">
                                Cadastrar
                            </x-primary-button>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>

<script>
    function toggleMarcaForm() {
        document.getElementById('nova-marca-form').classList.toggle('hidden');
    }

    function toggleTipoForm() {
        document.getElementById('novo-tipo-form').classList.toggle('hidden');
    }

    function previewImagem(event) {
        let reader = new FileReader();
        reader.onload = function () {
            let preview = document.getElementById('imagem-preview');
            preview.src = reader.result;
            preview.classList.remove('hidden');
        };
        reader.readAsDataURL(event.target.files[0]);
    }
</script>
