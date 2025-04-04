<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Lista de Usuários') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <!-- Mensagem de sucesso -->
                    @if (session('success'))
                        <div class="mb-6 p-4 bg-green-50 dark:bg-green-900/50 text-green-800 dark:text-green-200 rounded-lg border border-green-200 dark:border-green-700">
                            {{ session('success') }}
                        </div>
                    @endif

                    <!-- Cabeçalho -->
                    <div class="flex justify-end py-6">
                        <a href="{{ route('register') }}">
                            <x-primary-button>
                                {{ __('Criar Usuário') }}
                            </x-primary-button>
                        </a>
                    </div>

                    <!-- Cards para Mobile -->
                    <div class="md:hidden w-full p-4 bg-white border border-gray-200 rounded-lg shadow-sm sm:p-6 dark:bg-gray-700 dark:border-gray-600">
                        <div class="flow-root">
                            <ul role="list" class="divide-y divide-gray-200 dark:divide-gray-700">
                                @forelse($usuarios as $user)
                                    <li class="py-3 sm:py-4">
                                        <div class="flex items-center">
                                            <div class="shrink-0">
                                                @if($user->avatar)
                                                    <img class="w-8 h-8 rounded-full object-cover"
                                                         src="{{ Storage::url($user->avatar) }}"
                                                         alt="Foto de {{ $user->name }}">
                                                @else
                                                    <div class="w-8 h-8 rounded-full bg-gradient-to-br from-gray-300 to-gray-400 dark:from-gray-600 dark:to-gray-700 text-white font-semibold flex items-center justify-center">
                                                        {{ strtoupper(substr($user->name, 0, 1)) }}
                                                    </div>
                                                @endif
                                            </div>
                                            <div class="flex-1 min-w-0 ms-4">
                                                <p class="text-sm font-medium text-gray-900 truncate dark:text-white">
                                                    {{ $user->name }}
                                                </p>
                                                <p class="text-sm text-gray-500 truncate dark:text-gray-400">
                                                    {{ $user->email }}
                                                </p>
                                            </div>
                                           
                                        </div>
                                    </li>
                                @empty
                                    <li class="py-3 text-sm text-gray-500 dark:text-gray-400 text-center">
                                        {{ __('Nenhum usuário encontrado.') }}
                                    </li>
                                @endforelse
                            </ul>
                        </div>
                    </div>

                    <!-- Tabela para Desktop -->
                    <div class="hidden md:block overflow-x-auto">
                        <table class="w-full border-collapse bg-white dark:bg-gray-800 rounded-lg shadow-sm">
                            <thead class="bg-gray-100 dark:bg-gray-700">
                                <tr>
                                    <th class="p-4 text-left text-xs font-semibold text-gray-700 dark:text-gray-300 uppercase tracking-wider">
                                        {{ __('ID') }}
                                    </th>
                                    <th class="p-4 text-left text-xs font-semibold text-gray-700 dark:text-gray-300 uppercase tracking-wider">
                                        {{ __('Nome') }}
                                    </th>
                                    <th class="p-4 text-left text-xs font-semibold text-gray-700 dark:text-gray-300 uppercase tracking-wider">
                                        {{ __('Email') }}
                                    </th>
                                    <th class="p-4 text-left text-xs font-semibold text-gray-700 dark:text-gray-300 uppercase tracking-wider">
                                        {{ __('Data de Cadastro') }}
                                    </th>
                                    <th class="p-4 text-right text-xs font-semibold text-gray-700 dark:text-gray-300 uppercase tracking-wider">
                                        {{ __('Ações') }}
                                    </th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                                @forelse ($usuarios as $user)
                                    <tr class="hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors duration-150">
                                        <td class="p-4 text-sm text-gray-900 dark:text-gray-100">
                                            {{ $user->id }}
                                        </td>
                                        <td class="p-4 text-sm text-gray-900 dark:text-gray-100">
                                            {{ $user->name }}
                                        </td>
                                        <td class="p-4 text-sm text-gray-900 dark:text-gray-100">
                                            {{ $user->email }}
                                        </td>
                                        <td class="p-4 text-sm text-gray-900 dark:text-gray-100">
                                            {{ $user->created_at->format('d/m/Y H:i') }}
                                        </td>
                                        <td class="p-4 text-right text-sm font-medium space-x-3">
                                            <a href="{{ route('admin.users.edit', $user->id) }}"
                                               class="text-blue-600 dark:text-blue-400 hover:text-blue-800 dark:hover:text-blue-300">
                                                {{ __('Editar') }}
                                            </a>
                                            <form action="{{ route('admin.users.destroy', $user->id) }}" method="POST" class="inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit"
                                                        onclick="return confirm('{{ __('Tem certeza que deseja excluir este usuário?') }}')"
                                                        class="text-red-600 dark:text-red-400 hover:text-red-800 dark:hover:text-red-300">
                                                    {{ __('Excluir') }}
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="p-4 text-center text-sm text-gray-500 dark:text-gray-400">
                                            {{ __('Nenhum usuário encontrado.') }}
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