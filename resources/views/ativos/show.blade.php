<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ 'Detalhes do Ativo' }}
        </h2>
        
    </x-slot>

<div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div id="main-ativo-detalhe" class="p-6 text-gray-900 dark:text-gray-100 flex">
                   <div id="imagem-ativo-detalhe">
                        @if ($ativo->imagem)
                            <div class="flex justify-center">
                                <div
                                    class="relative w-20 h-20 md:w-32 md:h-32 lg:w-48 lg:h-48 max-w-96 max-h-72 overflow-hidden rounded-lg shadow-sm hover:shadow-md transition-shadow">
                                    <img src="{{ Storage::url($ativo->imagem) }}"
                                        alt="Imagem do ativo {{ $ativo->descricao }}"
                                        class="w-full h-full object-cover hover:scale-105 transition-transform duration-200">
                                </div>
                            </div>
                        @endif
                    </div>


                    <div id="info-ativo-detalhe" class="ml-4">
                        <div>
                            <strong class="text-xl">{{ $ativo->descricao }}</strong>
                        </div>
                        <div>
                            <span>Observação: {{ $ativo->observacao }}</span>
                        </div>
                        <div>
                            <span>Quantidade Total: {{ $ativo->quanitdade }}</span>
                        </div>
                        <div>
                            <span>Quantidade Mínima: {{ $ativo->quanitdade_min }}</span>
                        </div>
                        <div>
                            @php
                                $quantidadeDisp = optional($ativosDisp->firstWhere('id_ativo', $ativo->id))->quantidade_disp ?? 0;
                            @endphp
                            <span>Quantidade Disponivel:  
                                {{ $quantidadeDisp }}
                            </span>
                        </div>
                    </div>
                </div>
                <div id="more-ativo-detalhe" class="p-6 text-gray-900 dark:text-gray-100 flex">
                    <div id="mov-ativo-detalhes">
                        <table  class="w-full border-collapse">
                            <thead class="bg-gray-100 dark:bg-gray-700">
                                <tr>
                                    <th>Data</th>
                                    <th>Origem</th>
                                    <th>Destino</th>
                                    <th>Quanitdade</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($movimentacoes as $movimentacao)
                                <tr class="bg-white dark:bg-gray-800 hover:bg-gray-100 dark:hover:bg-gray-700"
                                            id="row-{{ $movimentacao->id_ativo }}">
                                        <td>
                                            {{ $movimentacao->created_at }}
                                        </td>
                                        <td>
                                            {{ $movimentacao->local_origem }}
                                        </td>
                                        <td>
                                            {{ $movimentacao->local_destino }}
                                        </td>
                                        <td>
                                            {{ $movimentacao->quantidade_mov }}
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="9" class="text-center p-4">Nenhuma movimentação até agora.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    <div id="locais-ativo-detalhes">
                        <table  class="w-full border-collapse">
                            <thead class="bg-gray-100 dark:bg-gray-700">
                                <tr>
                                    <th>Local</th>
                                    <th>Quantidade</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr class="bg-white dark:bg-gray-800 hover:bg-gray-100 dark:hover:bg-gray-700"
                                        {{-- id="row-{{ $local->id }}"> --}}
                                    <td>
                                        {{-- local --}}
                                    </td>
                                    <td>
                                        {{-- quantidade --}}
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

</x-app-layout>