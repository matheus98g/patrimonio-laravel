<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-700 dark:text-gray-300 leading-tight">
            {{ 'Adicionar Movimentação' }}
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

                    <form action="{{ route('movimentacoes.store') }}" method="POST">
                        @csrf

                        <div class="mb-4">
                            <label for="ativo_id" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Ativo</label>
                            <select id="ativo_id" name="ativo_id"
                                class="w-full px-4 py-2 mt-1 border rounded-md bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500"
                                required>
                                <option value="">Selecione...</option>
                                @foreach ($ativos as $ativo)
                                    <option value="{{ $ativo->id }}">{{ $ativo->descricao }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="mb-4">
                            <label for="observacao" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                Observação (opcional)
                            </label>
                            <input type="text" id="observacao" name="observacao"
                                class="w-full px-4 py-2 mt-1 border rounded-md bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500">
                        </div>

                        <div class="flex space-x-4">
                            <div class="mb-4 flex-1">
                                <label for="local_origem" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Origem</label>
                                <select id="local_origem" name="local_origem"
                                    class="w-full px-4 py-2 mt-1 border rounded-md bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500"
                                    required>
                                    <option value="">Selecione um ativo para carregar locais</option>
                                </select>
                            </div>

                            <div class="mb-4 flex-1">
                                <label for="local_destino" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Destino</label>
                                <select id="local_destino" name="local_destino"
                                    class="w-full px-4 py-2 mt-1 border rounded-md bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500"
                                    required>
                                    <option value="">Selecione...</option>
                                    @foreach ($locais as $local)
                                        <option value="{{ $local->id }}">{{ $local->descricao }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="mb-4">
                            <label for="quantidade_mov" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                Quantidade
                            </label>
                            <input type="number" id="quantidade_mov" name="quantidade_mov"
                                class="w-full px-4 py-2 mt-1 border rounded-md bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500"
                                required>
                        </div>

                        <input type="hidden" name="status" value="concluido">

                        <div class="flex justify-between items-center space-x-4 mt-6">
                            <x-secondary-button type="button" onclick="window.history.back();" class="px-6 py-3">
                                Cancelar
                            </x-secondary-button>
                            <x-primary-button type="submit" class="px-6 py-3">
                                Adicionar Movimentação
                            </x-primary-button>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>

<script>
    document.getElementById('ativo_id').addEventListener('change', function () {
        let ativoId = this.value;
        console.log('Ativo selecionado:', ativoId); // Log para ver o valor do ativo selecionado

        if (ativoId) {
            console.log('Buscando locais disponíveis para o ativo ID:', ativoId); // Log para indicar que estamos buscando os locais
            fetch(`/ativos/${ativoId}/locais-disponiveis`) // Corrige a URL para corresponder à rota correta
                .then(response => {
                    console.log('Resposta recebida:', response); // Log para verificar a resposta
                    if (!response.ok) {
                        console.error('Erro na requisição:', response.statusText);
                        throw new Error('Erro ao buscar locais');
                    }
                    return response.json();
                })
                .then(data => {
                    console.log('Dados recebidos:', data); // Log para verificar os dados recebidos
                    let localSelect = document.getElementById('local_origem');
                    localSelect.innerHTML = '<option value="">Selecione...</option>';

                    if (data.length > 0) {
                        data.forEach(local => {
                            let option = document.createElement('option');
                            option.value = local.id;
                            option.textContent = local.descricao;
                            localSelect.appendChild(option);
                        });
                    } else {
                        let option = document.createElement('option');
                        option.value = '';
                        option.textContent = 'Nenhum local disponível para este ativo';
                        localSelect.appendChild(option);
                    }
                })
                .catch(error => {
                    console.error('Erro ao carregar locais:', error); // Log de erro
                });
        } else {
            console.log('Nenhum ativo selecionado. Limpando opções de local origem.');
            document.getElementById('local_origem').innerHTML = '<option value="">Selecione um ativo para carregar locais</option>';
        }
    });
</script>



