<x-app-layout>

    <script src="https://code.jquery.com/jquery-3.7.1.js" integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4="
        crossorigin="anonymous"></script>
    <link href="https://cdn.datatables.net/v/bs5/dt-2.2.1/datatables.min.css" rel="stylesheet">

    <script src="https://cdn.datatables.net/v/bs5/dt-2.2.1/datatables.min.js"></script>



    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ 'Lista de Locais' }}
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">

                    <table id="myTable">
                        <thead>
                            <tr>

                                <th>Descrição</th>
                                <th>Tipo</th>
                                <th>Marca</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($ativos as $ativo)
                                <tr class="bg-white dark:bg-gray-800 hover:bg-gray-100 dark:hover:bg-gray-700">
                                    <td class="border border-gray-300 dark:border-gray-600 px-4 py-2">
                                        {{ $ativo->descricao ?? 'Não encontrado' }}
                                    </td>
                                    <td class="border border-gray-300 dark:border-gray-600 px-4 py-2">
                                        {{ $ativo->tipo->descricao ?? 'Não encontrado' }}
                                    </td>
                                    <td class="border border-gray-300 dark:border-gray-600 px-4 py-2">
                                        {{ $ativo->marca->descricao ?? 'Não encontrado' }}
                                    </td>


                                    </td>

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


    <script>
        $(document).ready(function() {
            $('#myTable').DataTable();
        });
    </script>


</x-app-layout>
