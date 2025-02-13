<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            Lista de Produtos
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Campo de Pesquisa -->
            <form method="GET" action="{{ route('produtos.index') }}" class="mb-4 flex space-x-2">
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Buscar produto..."
                    class="border border-gray-300 rounded-md px-3 py-2">
                <x-primary-button type="submit">Pesquisar</x-primary-button>
            </form>

            <!-- Lista de Produtos -->
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6">
                @if (isset($produtosList['error']))
                    <div class="text-red-500 bg-red-100 p-3 rounded-md">
                        {{ $produtosList['error'] }}
                    </div>
                @elseif (is_array($produtosList) && count($produtosList) > 0)
                    <ul>
                        @foreach ($produtosList as $produto)
                            <li class="border-b py-2">
                                <a href="{{ $produto['permalink'] }}" target="_blank" class="text-blue-500">
                                    {{ $produto['title'] }} - R$ {{ number_format($produto['price'], 2, ',', '.') }}
                                </a>
                            </li>
                        @endforeach
                    </ul>

                    <!-- Paginação -->
                    @if ($produtosList instanceof \Illuminate\Pagination\LengthAwarePaginator)
                        <div class="mt-4">
                            {{ $produtosList->links() }}
                        </div>
                    @endif
                @else
                    <p>Nenhum produto encontrado.</p>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>
