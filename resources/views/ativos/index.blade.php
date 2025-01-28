<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ 'Lista de Ativos' }}
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <table class="table-auto w-full border-collapse border border-gray-300 dark:border-gray-700">
                        <thead class="bg-gray-200 dark:bg-gray-700 text-gray-700 dark:text-gray-200">
                            <tr>
                                <th class="border border-gray-300 dark:border-gray-600 px-4 py-2 text-left">ID</th>
                                <th class="border border-gray-300 dark:border-gray-600 px-4 py-2 text-left">Descrição
                                </th>
                                <th class="border border-gray-300 dark:border-gray-600 px-4 py-2 text-left">Quantidade
                                </th>
                                <th class="border border-gray-300 dark:border-gray-600 px-4 py-2 text-left">Status</th>
                                <th class="border border-gray-300 dark:border-gray-600 px-4 py-2 text-left">Observação
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($ativos as $ativo)
                                <tr class="bg-white dark:bg-gray-800 hover:bg-gray-100 dark:hover:bg-gray-700">
                                    <td class="border border-gray-300 dark:border-gray-600 px-4 py-2">
                                        {{ $ativo->id }}</td>
                                    <td class="border border-gray-300 dark:border-gray-600 px-4 py-2">
                                        {{ $ativo->descricao }}</td>
                                    <td class="border border-gray-300 dark:border-gray-600 px-4 py-2">
                                        {{ $ativo->quantidade }}</td>
                                    <td class="border border-gray-300 dark:border-gray-600 px-4 py-2">
                                        <span
                                            class="{{ $ativo->status == 1 ? 'text-green-600 dark:text-green-400' : 'text-red-600 dark:text-red-400' }}">
                                            {{ $ativo->status == 1 ? 'Ativo' : 'Inativo' }}
                                        </span>
                                    </td>
                                    <td class="border border-gray-300 dark:border-gray-600 px-4 py-2">
                                        {{ $ativo->observacao }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5"
                                        class="text-center border border-gray-300 dark:border-gray-600 px-4 py-2">Nenhum
                                        ativo encontrado.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>
