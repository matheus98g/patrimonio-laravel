<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('Criar Cargo') }}
            </h2>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100 space-y-6">

                    <form action="{{ route('admin.roles.store') }}" method="POST" class="space-y-6">
                        @csrf

                        {{-- Nome do Cargo --}}
                        <div>
                            <label for="name" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Nome do Cargo</label>
                            <input type="text" name="name" id="name" value="{{ old('name') }}"
                                   class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white shadow-sm focus:ring focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                            @error('name')
                                <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Permissões --}}
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Permissões</label>
                            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-2">
                                @foreach ($permissions as $permission)
                                    <label class="flex items-center space-x-2 text-sm text-gray-700 dark:text-gray-300">
                                        <input
                                            type="checkbox"
                                            name="permissions[]"
                                            value="{{ $permission->id }}"
                                            class="rounded border-gray-300 dark:border-gray-600 dark:bg-gray-700 text-indigo-600 focus:ring-indigo-500">
                                        <span>{{ $permission->name }}</span>
                                    </label>
                                @endforeach
                            </div>
                        </div>

                        {{-- Botões --}}
                        <div class="flex justify-end gap-4 pt-4">
                            <x-secondary-button>
                                <a href="{{ route('admin.roles.index') }}">
                                    Cancelar
                                </a>
                            </x-secondary-button>
                            <x-primary-button type="submit"
                                    class="inline-flex items-center px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-medium rounded-lg transition">
                                Criar Cargo
                            </x-primary-button>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>
