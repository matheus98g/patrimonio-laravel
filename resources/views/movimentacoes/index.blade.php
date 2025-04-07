<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ 'Lista de Movimentações' }}
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <div class="bg-white dark:bg-gray-800 shadow-md rounded-lg p-6 mb-6">
                <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-200 mb-4">Filtrar Movimentações</h3>

                <form action="{{ route('movimentacoes.search') }}" method="GET">
                    @csrf

                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        <div>
                            <label for="local_origem"
                                class="block text-sm font-medium text-gray-700 dark:text-gray-300">Origem</label>
                            <select name="local_origem"
                                class="w-full px-4 py-2 mt-1 border rounded-md bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500">
                                <option value="">Selecione...</option>
                                @foreach ($locais as $local)
                                    <option value="{{ $local->id }}"
                                        {{ request('local_origem') == $local->id ? 'selected' : '' }}>
                                        {{ $local->descricao }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div>
                            <label for="local_destino"
                                class="block text-sm font-medium text-gray-700 dark:text-gray-300">Destino</label>
                            <select name="local_destino"
                                class="w-full px-4 py-2 mt-1 border rounded-md bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500">
                                <option value="">Selecione...</option>
                                @foreach ($locais as $local)
                                    <option value="{{ $local->id }}"
                                        {{ request('local_destino') == $local->id ? 'selected' : '' }}>
                                        {{ $local->descricao }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div>
                            <label for="search"
                                class="block text-sm font-medium text-gray-700 dark:text-gray-300">Buscar</label>
                            <input type="text" id="search" name="search" placeholder="Digite para buscar..."
                                value="{{ request('search') }}"
                                class="w-full px-4 py-2 mt-1 border rounded-md bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500">
                        </div>
                    </div>

                    <div class="flex justify-end mt-4 gap-3">
                        <a href="{{ route('movimentacoes.index') }}">
                            <x-secondary-button class="px-4 py-2">
                                Limpar Filtros
                            </x-secondary-button>
                        </a>
                        <x-primary-button type="submit" class="px-5 py-2">
                            Pesquisar
                        </x-primary-button>

                    </div>

                </form>
            </div>

            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <div class="flex justify-between items-center py-4">
                        <h3 class="text-lg font-semibold">Ultimas Movimentações</h3>
                        <a href="{{ route('movimentacoes.create') }}">
                            <x-primary-button class="px-4 py-2">
                                Movimentar Ativo
                            </x-primary-button>
                            
                        </a>
                    </div>

                    {{-- <div class="block md:hidden">
                        @forelse ($movimentacoes as $movimentacao)
                            <div class="bg-white dark:bg-gray-800 shadow-md rounded-lg p-4 mb-4">
                                <p><span class="font-semibold">Data:</span> {{ $movimentacao->created_at->format('d/m/Y H:i') }}</p>
                                <p><span class="font-semibold">Ativo:</span> {{ $movimentacao->ativo->descricao ?? 'N/A' }}</p>
                                <p><span class="font-semibold">Quantidade:</span> {{ $movimentacao->quantidade_mov ?? '0' }}</p>
                                <p><span class="font-semibold">Origem:</span> {{ $movimentacao->origem->descricao ?? 'Local não encontrado' }}</p>
                                <p><span class="font-semibold">Destino:</span> {{ $movimentacao->destino->descricao ?? 'Local não encontrado' }}</p>
                                <p><span class="font-semibold">Observação:</span> {{ $movimentacao->observacao ?? '-' }}</p>
                                <p><span class="font-semibold">Usuário:</span> {{ $movimentacao->user->name ?? 'N/A' }}</p>
                                <p>
                                    <span class="font-semibold">Status:</span>
                                    <span class="{{ $movimentacao->status == 'concluido' ? 'text-green-600' : ($movimentacao->status == 'pendente' ? 'text-orange-500' : 'text-red-600') }}">
                                        {{ ucfirst($movimentacao->status) }}
                                    </span>
                                </p>
                            </div>
                        @empty
                            <div class="bg-white dark:bg-gray-800 shadow-md rounded-lg p-4">
                                <p class="text-center">Nenhuma movimentação encontrada.</p>
                            </div>
                        @endforelse
                    </div> --}}


                    <div class="block md:hidden space-y-4">
                        @forelse ($movimentacoes as $movimentacao)
                            <div x-data="{ open: false }" class="bg-white dark:bg-gray-800 rounded-lg shadow-sm border border-gray-200 dark:border-gray-600">
                                <!-- Cabeçalho resumido -->
                                <div @click="open = !open" class="p-4 flex justify-between items-center cursor-pointer hover:bg-gray-50 dark:hover:bg-gray-600 transition-colors">
                                    <div class="space-y-1">
                                        <h3 class="font-medium text-gray-900 dark:text-gray-100">
                                            {{ $movimentacao->ativo->descricao ?? 'Ativo' }}
                                        </h3>
                                        <p class="text-sm text-gray-500 dark:text-gray-400">
                                            {{ $movimentacao->created_at->format('d/m/Y H:i') }}
                                        </p>
                                        <p class="text-sm">
                                            <span class="font-semibold text-gray-600 dark:text-gray-400">Quantidade:</span>
                                            <span class="text-gray-800 dark:text-gray-100">{{ $movimentacao->quantidade_mov ?? '0' }}</span>
                                        </p>
                                    </div>
                                    <i data-feather="chevron-down" class="w-5 h-5 text-gray-500 transition-transform" :class="{'rotate-180': open}"></i>
                                </div>
                    
                                <!-- Conteúdo expandido -->
                                <div x-show="open" x-transition class="p-4 border-t border-gray-200 dark:border-gray-600 text-sm space-y-2">
                                    <div class="grid grid-cols-2 gap-2">
                                        <span class="text-gray-600 dark:text-gray-400 font-medium">Origem:</span>
                                        <span class="text-gray-900 dark:text-gray-100">
                                            {{ $movimentacao->origem->descricao ?? 'Local não encontrado' }}
                                        </span>
                    
                                        <span class="text-gray-600 dark:text-gray-400 font-medium">Destino:</span>
                                        <span class="text-gray-900 dark:text-gray-100">
                                            {{ $movimentacao->destino->descricao ?? 'Local não encontrado' }}
                                        </span>
                    
                                        <span class="text-gray-600 dark:text-gray-400 font-medium">Usuário:</span>
                                        <span class="text-gray-900 dark:text-gray-100">
                                            {{ $movimentacao->user->name ?? 'N/A' }}
                                        </span>
                    
                                        <span class="text-gray-600 dark:text-gray-400 font-medium">Status:</span>
                                        <span class="{{ $movimentacao->status == 'concluido' ? 'text-green-600' : ($movimentacao->status == 'pendente' ? 'text-orange-500' : 'text-red-600') }}">
                                            {{ ucfirst($movimentacao->status) }}
                                        </span>
                                    </div>
                    
                                    @if (!empty($movimentacao->observacao))
                                        <div class="pt-2">
                                            <span class="block text-gray-600 dark:text-gray-400 font-medium">Observação:</span>
                                            <p class="text-gray-900 dark:text-gray-100">{{ $movimentacao->observacao }}</p>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        @empty
                            <div class="bg-white dark:bg-gray-800 shadow-sm rounded-lg border border-gray-200 dark:border-gray-600 p-4 text-center text-gray-500 dark:text-gray-400">
                                {{ ('Nenhuma movimentação encontrada.') }}
                            </div>
                        @endforelse
                    </div>
                    
                    


                    <div class="hidden md:block">
                        
                        <table class="table-auto w-full border-collapse border border-gray-300 dark:border-gray-700">
                            <thead class="bg-gray-200 dark:bg-gray-700 text-gray-700 dark:text-gray-200">
                                <tr>
                                    <th class="border border-gray-300 dark:border-gray-600 px-4 py-2 text-left">Data</th>
                                    <th class="border border-gray-300 dark:border-gray-600 px-4 py-2 text-left">Ativo</th>
                                    <th class="border border-gray-300 dark:border-gray-600 px-4 py-2 text-left">Quantidade Mov</th>
                                    <th class="border border-gray-300 dark:border-gray-600 px-4 py-2 text-left">Origem</th>
                                    <th class="border border-gray-300 dark:border-gray-600 px-4 py-2 text-left">Destino</th>
                                    <th class="border border-gray-300 dark:border-gray-600 px-4 py-2 text-left">Observação</th>
                                    <th class="border border-gray-300 dark:border-gray-600 px-4 py-2 text-left">Usuário</th>
                                    <th class="border border-gray-300 dark:border-gray-600 px-4 py-2 text-left">Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($movimentacoes as $movimentacao)
                                    <tr class="bg-white dark:bg-gray-800 hover:bg-gray-100 dark:hover:bg-gray-700">
                                        <td class="border border-gray-300 dark:border-gray-600 px-4 py-2">
                                            {{ $movimentacao->created_at->format('d/m/Y H:i') }}
                                        </td>
                                        <td class="border border-gray-300 dark:border-gray-600 px-4 py-2">
                                            {{ $movimentacao->ativo->descricao ?? 'N/A' }}
                                        </td>
                                        <td class="border border-gray-300 dark:border-gray-600 px-4 py-2">
                                            {{ $movimentacao->quantidade_mov ?? '0' }}
                                        </td>
                                        <td class="border border-gray-300 dark:border-gray-600 px-4 py-2">
                                            {{ $movimentacao->origem->descricao ?? 'Local não encontrado' }}
                                        </td>
                                        <td class="border border-gray-300 dark:border-gray-600 px-4 py-2">
                                            {{ $movimentacao->destino->descricao ?? 'Local não encontrado' }}
                                        </td>
                                        <td class="border border-gray-300 dark:border-gray-600 px-4 py-2">
                                            {{ $movimentacao->observacao ?? '-' }}
                                        </td>
                                        <td class="border border-gray-300 dark:border-gray-600 px-4 py-2">
                                            {{ $movimentacao->user->name ?? 'N/A' }}
                                        </td>
                                        <td class="border border-gray-300 dark:border-gray-600 px-4 py-2">
                                            <span
                                                class="{{ $movimentacao->status == 'concluido' ? 'text-green-600' : ($movimentacao->status == 'pendente' ? 'text-orange-500' : 'text-red-600') }}">
                                                {{ ucfirst($movimentacao->status) }}
                                            </span>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="8"
                                            class="text-center border border-gray-300 dark:border-gray-600 px-4 py-2">
                                            Nenhuma movimentação encontrada.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>

