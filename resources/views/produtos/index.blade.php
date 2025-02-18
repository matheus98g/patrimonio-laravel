<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight text-center">
            Lista de Produtos
        </h2>
    </x-slot>

    <div class="py-6 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Campo de Pesquisa -->
            <div class="flex justify-center mb-6">
                <form method="GET" action="{{ route('produtos.index') }}" class="flex space-x-2 w-full max-w-lg">
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Buscar produto..."
                        class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-500 dark:bg-gray-700 dark:text-white dark:border-gray-600">
                    <x-primary-button type="submit">Pesquisar</x-primary-button>
                </form>
            </div>

            <!-- Lista de Produtos -->
            <div class="bg-white dark:bg-gray-900  sm:rounded-lg p-0">
                @if (isset($produtosList['error']))
                    <div class="text-red-500 bg-red-100 p-3 rounded-md text-center">
                        {{ $produtosList['error'] }}
                    </div>
                @elseif (is_array($produtosList) && count($produtosList) > 0)
                    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
                        @foreach ($produtosList as $produto)
                            <div
                                class="bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-lg shadow-md overflow-hidden p-4">
                                <a href="{{ $produto['permalink'] }}" target="_blank">
                                    <img class="w-full h-48 sm:h-64 object-contain p-2 bg-white dark:bg-gray-700 rounded-lg"
                                        src="{{ $produto['thumbnail'] }}" alt="{{ $produto['title'] }}" />
                                </a>
                                <div class="p-3">
                                    <a href="{{ $produto['permalink'] }}" target="_blank">
                                        <h5
                                            class="text-base sm:text-lg font-semibold tracking-tight text-gray-900 dark:text-white">
                                            {{ $produto['title'] }}</h5>
                                    </a>

                                    <div class="mt-3">
                                        <!-- Vendedor e Condição -->
                                        <div
                                            class="flex justify-between text-xs sm:text-sm mb-2 text-gray-600 dark:text-gray-300">
                                            <span>Vendido por {{ $produto['seller']['nickname'] }}</span>
                                            <span
                                                class="bg-green-500 text-green-800 text-xs font-medium px-2 py-0.5 rounded-md">
                                                {{ ucfirst($produto['condition']) }}
                                            </span>
                                        </div>

                                        <!-- Preço -->
                                        <div class="my-2 sm:my-3">
                                            <p class="text-sm sm:text-2xl text-gray-400 line-through">
                                                R$ {{ number_format($produto['original_price'], 2, ',', '.') }}
                                            </p>



                                            <p class="text-xl sm:text-2xl font-bold text-gray-900 dark:text-white">
                                                R$ {{ number_format($produto['price'], 2, ',', '.') }}
                                            </p>
                                            @if (isset($produto['installments']))
                                                <p class="text-gray-500 dark:text-gray-300 text-xs sm:text-sm">
                                                    em {{ $produto['installments']['quantity'] }}x de
                                                    R$
                                                    {{ number_format($produto['installments']['amount'], 2, ',', '.') }}
                                                </p>
                                            @endif
                                        </div>

                                        <!-- Frete Grátis -->
                                        @if ($produto['shipping']['free_shipping'])
                                            <div class="mb-2 sm:my-3">
                                                <span
                                                    class="bg-blue-100 text-blue-800 text-xs font-semibold  py-0.5 rounded-sm">
                                                    Frete Grátis
                                                </span>
                                            </div>
                                        @endif

                                        {{-- <!-- Especificações -->
                                        <div class="space-y-1 text-xs sm:text-sm text-gray-600 dark:text-gray-300">
                                            @php
                                                $specs = [
                                                    'Marca' => optional(
                                                        collect($produto['attributes'])->firstWhere('id', 'BRAND'),
                                                    )['value_name'],
                                                    'Modelo' => optional(
                                                        collect($produto['attributes'])->firstWhere('id', 'MODEL'),
                                                    )['value_name'],
                                                    'CPU' => optional(
                                                        collect($produto['attributes'])->firstWhere('id', 'CPU_MODEL'),
                                                    )['value_name'],
                                                ];
                                            @endphp

                                            @foreach ($specs as $key => $value)
                                                @if ($value)
                                                    <div class="flex justify-between">
                                                        <span>{{ $key }}:</span>
                                                        <span
                                                            class="text-gray-900 dark:text-gray-200">{{ $value }}</span>
                                                    </div>
                                                @endif
                                            @endforeach
                                        </div> --}}
                                    </div>

                                    <!-- Botão -->
                                    <div class="flex items-center justify-center mt-4">
                                        <a href="{{ $produto['permalink'] }}" target="_blank"
                                            class="w-full text-white bg-green-700 hover:bg-green-800 focus:ring-4 focus:outline-none focus:ring-green-500 
        font-medium rounded-lg text-sm px-4 py-2 sm:px-5 sm:py-2.5 text-center dark:bg-green-700 dark:hover:bg-green-800 
        dark:focus:ring-green-500 transition-all">
                                            Ver no Mercado Livre
                                        </a>
                                    </div>


                                </div>
                            </div>
                        @endforeach
                    </div>

                    <!-- Paginação -->
                    @if ($produtosList instanceof \Illuminate\Pagination\LengthAwarePaginator)
                        <div class="mt-6 flex justify-center">
                            {{ $produtosList->links() }}
                        </div>
                    @endif
                @else
                    <p class="text-center text-gray-600 dark:text-gray-300">Nenhum produto encontrado.</p>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>
