<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ ('Detalhes do Ativo') }}
            </h2>
            <div class="md:hidden">
                <!-- O menu hamburger será renderizado aqui pelo layout padrão -->
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <!-- Botão Voltar -->
            <div class="flex justify-start">
                <a href="{{ route('ativos.index') }}">
                    <x-secondary-button class="px-4 py-2">
                        {{ ('Voltar aos Ativos') }}
                    </x-secondary-button>
                </a>
            </div>

            <!-- Detalhes do Ativo -->
            <div class="bg-white dark:bg-gray-800 shadow-sm sm:rounded-lg p-6">
                <div class="flex flex-col md:flex-row gap-6">
                    <!-- Imagem do Ativo -->
                    <div class="flex-shrink-0 w-full md:w-1/3 flex justify-center">
                        @if ($ativo->imagem)
                            <div class="relative w-32 h-32 md:w-48 md:h-48 overflow-hidden rounded-lg shadow-sm hover:shadow-md transition-shadow duration-200">
                                <img src="{{ Storage::url($ativo->imagem) }}" 
                                     alt="Imagem do ativo {{ $ativo->descricao }}"
                                     class="w-full h-full object-cover hover:scale-105 transition-transform duration-200 -z-10">
                            </div>
                        @else
                            <div class="w-32 h-32 md:w-48 md:h-48 bg-gray-100 dark:bg-gray-700 rounded-lg flex items-center justify-center text-gray-500 dark:text-gray-400">
                                {{ ('Sem imagem') }}
                            </div>
                        @endif
                    </div>

                    <!-- Informações do Ativo -->
                    <div class="flex-1 space-y-3">
                        <h3 class="text-2xl font-bold text-gray-900 dark:text-gray-100">{{ $ativo->descricao }}</h3>
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-2">
                            <p class="text-gray-700 dark:text-gray-300">
                                <strong>{{ ('Observação:') }}</strong> {{ $ativo->observacao ?? '' }}
                            </p>
                            <p class="text-gray-700 dark:text-gray-300">
                                <strong>{{ ('Marca:') }}</strong> {{ $ativo->marca->descricao ?? 'N/A' }}
                            </p>
                            <p class="text-gray-700 dark:text-gray-300">
                                <strong>{{ ('Tipo:') }}</strong> {{ $ativo->tipo->descricao ?? 'N/A' }}
                            </p>
                            <p class="text-gray-700 dark:text-gray-300">
                                <strong>{{ ('Quantidade Total:') }}</strong> {{ $ativo->quantidade }}
                            </p>
                            <p class="text-gray-700 dark:text-gray-300">
                                <strong>{{ ('Quantidade Mínima:') }}</strong> {{ $ativo->quantidade_min }}
                            </p>
                            <p class="text-gray-700 dark:text-gray-300">
                                <strong>{{ ('Quantidade Disponível:') }}</strong> {{ optional($ativosDisp->firstWhere('ativo_id', $ativo->id))->quantidade_disp ?? 0 }}
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Movimentações -->
            <div class="bg-white dark:bg-gray-800 shadow-sm sm:rounded-lg p-6">
                <div class="flex items-center justify-between mb-4">
                    <div>
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100">{{ ('Movimentações') }}</h3>
                        <p class="text-sm text-gray-600 dark:text-gray-400">Movimentações com este ativo.</p>
                    </div>
                </div>
                <div class="overflow-x-auto">
                    <table class="w-full border-collapse">
                        <thead>
                            <tr class="bg-gray-100 dark:bg-gray-700 text-gray-900 dark:text-gray-200">
                                <th class="p-3 text-left text-sm font-medium">{{ ('Data') }}</th>
                                <th class="p-3 text-left text-sm font-medium">{{ ('Origem') }}</th>
                                <th class="p-3 text-left text-sm font-medium">{{ ('Destino') }}</th>
                                <th class="p-3 text-left text-sm font-medium">{{ ('Quantidade') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($movimentacoes as $movimentacao)
                                <tr class="border-b border-gray-200 dark:border-gray-600 hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors duration-150">
                                    <td class="p-3 text-gray-700 dark:text-gray-300">{{ $movimentacao->created_at->format('d/m/Y') }}</td>
                                    <td class="p-3 text-gray-700 dark:text-gray-300">{{ $movimentacao->origem->descricao ?? 'N/A' }}</td>
                                    <td class="p-3 text-gray-700 dark:text-gray-300">{{ $movimentacao->destino->descricao ?? 'N/A' }}</td>
                                    <td class="p-3 text-gray-700 dark:text-gray-300">{{ $movimentacao->quantidade_mov }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="p-4 text-center text-gray-500 dark:text-gray-400">
                                        {{ ('Nenhuma movimentação até agora.') }}
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                    <div class="flex justify-end mt-4">
                        <a href="{{ route('movimentacoes.search', ['id' => $ativo->id]) }}">
                            <x-secondary-button class="px-4 py-2">
                                {{ ('Ver todas as movimentações') }}
                            </x-secondary-button>
                        </a>
                    </div>
                </div>
            </div>

            <!-- Locais do Ativo -->
            <div class="bg-white dark:bg-gray-800 shadow-sm sm:rounded-lg p-6">
                <div class="flex items-center justify-between mb-4">
                    <div>
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100">{{ ('Locais do Ativo') }}</h3>
                        <p class="text-sm text-gray-600 dark:text-gray-400">Locais com este ativo.</p>
                    </div>
                </div>
                <div class="overflow-x-auto">
                    <table class="w-full border-collapse">
                        <thead>
                            <tr class="bg-gray-100 dark:bg-gray-700 text-gray-900 dark:text-gray-200">
                                <th class="p-3 text-left text-sm font-medium">{{ ('Local') }}</th>
                                <th class="p-3 text-left text-sm font-medium">{{ ('Quantidade') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($locaisComQuantidade as $local)
                                <tr class="border-b border-gray-200 dark:border-gray-600 hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors duration-150">
                                    <td class="p-3 text-gray-700 dark:text-gray-300">{{ $local->descricao }}</td>
                                    <td class="p-3 text-gray-700 dark:text-gray-300">{{ $local->quantidade }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="2" class="p-4 text-center text-gray-500 dark:text-gray-400">
                                        Nenhum local registrado.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                        
                        
                    </table>
                    <div class="flex justify-end mt-4">
                        <a href="{{ route('movimentacoes.index') }}">
                            <x-secondary-button class="px-4 py-2">
                                {{ ('Ver todos os locais') }}
                            </x-secondary-button>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>