<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ ('Editar Usuário') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    
                    <!-- Mensagem de sucesso -->
                    @if (session('success'))
                        <div class="mb-4 p-4 bg-green-100 dark:bg-green-900 text-green-700 dark:text-green-200 rounded">
                            {{ session('success') }}
                        </div>
                    @endif

                    <!-- Formulário de edição -->
                    <form action="{{ route('admin.users.update', $user->id) }}" method="POST" class="space-y-6">
                        @csrf
                        @method('PUT')

                        <!-- Nome -->
                        <div>
                            <label for="name" class="block text-sm font-medium mb-1">{{ ('Nome') }}</label>
                            <input type="text" id="name" name="name" value="{{ old('name', $user->name) }}"
                                   class="w-full px-4 py-2 border rounded-md dark:bg-gray-900 dark:border-gray-700 focus:ring focus:ring-indigo-500">
                            @error('name')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Email -->
                        <div>
                            <label for="email" class="block text-sm font-medium mb-1">{{ ('E-mail') }}</label>
                            <input type="email" id="email" name="email" value="{{ old('email', $user->email) }}"
                                   class="w-full px-4 py-2 border rounded-md dark:bg-gray-900 dark:border-gray-700 focus:ring focus:ring-indigo-500">
                            @error('email')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Papéis (roles) -->
                        <div>
                            <label class="block text-sm font-medium mb-1">{{ ('Cargo') }}</label>
                            <div class="space-y-2 py-2">
                                @foreach ($roles as $role)
                                    <label class="flex items-center space-x-2">
                                        <input type="radio" name="roles[]" value="{{ $role->name }}"
                                               {{ $user->roles->pluck('name')->contains($role->name) ? 'checked' : '' }}
                                               class="text-indigo-600 focus:ring-indigo-500 border-gray-300 dark:bg-gray-900 dark:border-gray-700">
                                        <span class="text-sm text-gray-700 dark:text-gray-300">{{ $role->name }}</span>
                                    </label>
                                @endforeach
                            </div>
                            @error('roles')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                        

                        <!-- Botões -->
                        <div class="flex justify-between items-center">
                            <x-secondary-button>
                                <a href="{{ route('admin.users.index') }}" class="text-sm text-gray-500 hover:underline">
                                    ← {{ ('Voltar à lista') }}
                                </a>
                            </x-secondary-button>
                            <x-primary-button type="submit"
                                    class="bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2 rounded-md transition">
                                {{ ('Salvar Alterações') }}
                            </x-primary-button>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>
