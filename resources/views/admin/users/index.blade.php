<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ 'Controle de Acesso' }}
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <div class="mb-6">
                        <form method="GET" action="{{ route('admin.users.index') }}" class="flex gap-2">
                            <input 
                                type="text" 
                                name="search" 
                                class="w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-100 focus:border-indigo-500 focus:ring-indigo-500" 
                                placeholder="Buscar usuários por nome, email..." 
                                value="{{ request('search') }}"/>
                            <x-primary-button type="submit" class="shrink-0">
                                Buscar
                            </x-primary-button>
                        </form>
                    </div>

                    <div class="mb-4">
                        <x-primary-button id="openModalButton" class="w-full sm:w-auto">
                            Criar Novo Usuário
                        </x-primary-button>
                    </div>

                    <div class="hidden md:block">
                        <table class="w-full border-collapse">
                            <thead class="bg-gray-100 dark:bg-gray-700">
                                <tr>
                                    <th class="p-3 text-left text-sm">Nome</th>
                                    <th class="p-3 text-left text-sm">Email</th>
                                    <th class="p-3 text-left text-sm">Cargo</th>
                                    <th class="p-3 text-left text-sm">Permissões</th>
                                    <th class="p-3 text-left text-sm">Ações</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($usuarios as $usuario)
                                    <tr class="bg-white dark:bg-gray-800 hover:bg-gray-100 dark:hover:bg-gray-700" id="row-{{ $usuario->id }}">
                                        <td class="border border-gray-300 dark:border-gray-600 px-4 py-2">
                                            {{ $usuario->name ?? 'N/A' }}
                                        </td>
                                        <td class="border border-gray-300 dark:border-gray-600 px-4 py-2">
                                            {{ $usuario->email ?? 'N/A' }}
                                        </td>
                                        <td class="border border-gray-300 dark:border-gray-600 px-4 py-2">
                                            @foreach ($usuario->roles as $role)
                                                <span class="bg-blue-100 text-blue-800 dark:bg-blue-600 dark:text-blue-200 px-2 py-1 rounded-full text-xs">
                                                    {{ $role->name }}
                                                </span>
                                            @endforeach
                                        </td>
                                        <td class="border border-gray-300 dark:border-gray-600 px-4 py-2">
                                            @foreach ($usuario->permissions as $permission)
                                                <span class="bg-blue-100 text-blue-800 dark:bg-blue-600 dark:text-blue-200 px-2 py-1 rounded-full text-xs">
                                                    {{ $permission->name }}
                                                </span>
                                            @endforeach
                                        </td>
                                        <td class="border border-gray-300 dark:border-gray-600 px-4 py-2">
                                            <div class="flex gap-3 items-center justify-center">
                                                <a href="{{ route('admin.users.edit', $usuario->id) }}" 
                                                    class="inline-block bg-gray-200 dark:bg-gray-700 text-gray-800 dark:text-gray-200 hover:bg-gray-300 dark:hover:bg-gray-600 rounded px-4 py-2">
                                                    <i data-feather="edit" width="20"></i>
                                                </a>
                                                <form action="{{ route('admin.users.destroy', $usuario->id) }}" method="POST" class="inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <x-danger-button type="submit" 
                                                        class="bg-red-500 dark:bg-red-600 text-white hover:bg-red-600 dark:hover:bg-red-700 rounded">
                                                        <i data-feather="x" width="20"></i>
                                                    </x-danger-button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div id="createUserModal" class="fixed inset-0 bg-gray-500 bg-opacity-50 flex justify-center items-center hidden">
        <div class="bg-white dark:bg-gray-800 p-6 rounded-lg shadow-xl w-1/3">
            <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100">Criar Novo Usuário</h3>

            <form method="POST" action="{{ route('admin.users.create') }}" class="space-y-6 mt-4">
                @csrf

                <div>
                    <label for="name" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Nome</label>
                    <input type="text" id="name" name="name" required class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-100 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" placeholder="Nome do usuário">
                </div>

                <div>
                    <label for="email" class="block text-sm font-medium text-gray-700 dark:text-gray-300">E-mail</label>
                    <input type="email" id="email" name="email" required class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-100 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" placeholder="E-mail do usuário">
                </div>

                <div>
                    <label for="password" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Senha</label>
                    <input type="password" id="password" name="password" required class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-100 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" placeholder="Senha">
                </div>

                <div>
                    <label for="password_confirmation" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Confirmar Senha</label>
                    <input type="password" id="password_confirmation" name="password_confirmation" required class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-100 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" placeholder="Confirme a senha">
                </div>

                <div class="flex items-center justify-end space-x-4 mt-6">
                    <x-primary-button type="submit">Criar Usuário</x-primary-button>
                    <button type="button" id="closeModalButton" class="text-gray-500 hover:text-gray-700 dark:text-gray-300 dark:hover:text-gray-400">
                        Cancelar
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script>
        const openModalButton = document.getElementById('openModalButton');
        const createUserModal = document.getElementById('createUserModal');
        const closeModalButton = document.getElementById('closeModalButton');

        openModalButton.addEventListener('click', () => {
            createUserModal.classList.remove('hidden');
        });

        closeModalButton.addEventListener('click', () => {
            createUserModal.classList.add('hidden');
        });

        window.addEventListener('click', (e) => {
            if (e.target === createUserModal) {
                createUserModal.classList.add('hidden');
            }
        });
    </script>
</x-app-layout>
