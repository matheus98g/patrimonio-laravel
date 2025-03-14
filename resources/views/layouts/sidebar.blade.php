<div x-data="{ open: false }" class="flex h-screen bg-gray-100 dark:bg-gray-800">
    <!-- Sidebar -->
    <div class="w-64 bg-white dark:bg-gray-900 border-r border-gray-200 dark:border-gray-700 fixed h-full z-30">
        <!-- Logo -->
        <div class="flex items-center justify-center p-4">
            <a href="{{ route('dashboard') }}">
                <x-application-logo class="block h-9 w-auto fill-current text-gray-800 dark:text-gray-200" />
            </a>
        </div>

        <!-- Sidebar Menu -->
        <div class="flex flex-col p-4 space-y-2">
            <!-- Navigation Links -->
            <x-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')" class="text-gray-700 dark:text-gray-300 hover:text-gray-900 dark:hover:text-white">
                {{ ('Dashboard') }}
            </x-nav-link>

            <x-nav-link :href="route('register')" :active="request()->routeIs('register')" class="text-gray-700 dark:text-gray-300 hover:text-gray-900 dark:hover:text-white">
                {{ ('Cadastrar Novo') }}
            </x-nav-link>

            <!-- Dropdown: Usuarios -->
            <div x-data="{ open: false }">
                <button @click="open = !open" class="flex items-center text-gray-700 dark:text-gray-300 hover:text-gray-900 dark:hover:text-white">
                    <span>{{ ('Usuarios') }}</span>
                    <svg class="ml-2 h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="none" stroke="currentColor">
                        <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                    </svg>
                </button>
                
                <!-- Dropdown content -->
                <div x-show="open" x-transition:enter="transition-transform transform ease-out duration-300" x-transition:enter-start="translate-y-[-10px] opacity-0" x-transition:enter-end="translate-y-0 opacity-100" x-transition:leave="transition-transform transform ease-in duration-200" x-transition:leave-start="translate-y-0 opacity-100" x-transition:leave-end="translate-y-[-10px] opacity-0" class="pl-4 space-y-1">
                    <x-dropdown-link :href="route('register')" :active="request()->routeIs('register')">
                        {{ ('Cadastrar Novo') }}
                    </x-dropdown-link>
                </div>
            </div>

            <!-- Dropdown: Gerenciar -->
            <div x-data="{ open: false }">
                <button @click="open = !open" class="flex items-center text-gray-700 dark:text-gray-300 hover:text-gray-900 dark:hover:text-white">
                    <span>{{ ('Gerenciar') }}</span>
                    <svg class="ml-2 h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="none" stroke="currentColor">
                        <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                    </svg>
                </button>

                <!-- Dropdown content -->
                <div x-show="open" x-transition:enter="transition-transform transform ease-out duration-300" x-transition:enter-start="translate-y-[-10px] opacity-0" x-transition:enter-end="translate-y-0 opacity-100" x-transition:leave="transition-transform transform ease-in duration-200" x-transition:leave-start="translate-y-0 opacity-100" x-transition:leave-end="translate-y-[-10px] opacity-0" class="pl-4 space-y-1">
                    <x-dropdown-link :href="route('ativos.index')" :active="request()->routeIs('ativos.index')">
                        {{ ('Ativos') }}
                    </x-dropdown-link>
                    <x-dropdown-link :href="route('marcas.index')" :active="request()->routeIs('marcas.index')">
                        {{ ('Marcas') }}
                    </x-dropdown-link>
                    <x-dropdown-link :href="route('tipos.index')" :active="request()->routeIs('tipos.index')">
                        {{ ('Tipos') }}
                    </x-dropdown-link>
                    <x-dropdown-link :href="route('locais.index')" :active="request()->routeIs('locais.index')">
                        {{ ('Locais') }}
                    </x-dropdown-link>
                </div>
            </div>

            <x-nav-link :href="route('movimentacoes.index')" :active="request()->routeIs('movimentacoes.index')" class="text-gray-700 dark:text-gray-300 hover:text-gray-900 dark:hover:text-white">
                {{ ('Movimentações') }}
            </x-nav-link>

            <x-nav-link :href="route('produtos.index')" :active="request()->routeIs('produtos.index')" class="text-gray-700 dark:text-gray-300 hover:text-gray-900 dark:hover:text-white">
                {{ ('Produtos') }}
            </x-nav-link>
        </div>

        <!-- Theme Toggle Button -->
        <div class="absolute bottom-10 left-10">
            <button id="theme-toggle" class="p-2 rounded-full bg-gray-100 dark:bg-gray-700 text-gray-800 dark:text-gray-200 hover:bg-gray-300 dark:hover:bg-gray-600">
                <svg id="theme-icon" class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                    <!-- Ícone de sol (light mode) -->
                    <path id="sun-icon" class="hidden dark:block" d="M10 2a1 1 0 011 1v1a1 1 0 11-2 0V3a1 1 0 011-1zm4 8a4 4 0 11-8 0 4 4 0 018 0zm-.464 4.95l.707.707a1 1 0 001.414-1.414l-.707-.707a1 1 0 00-1.414 1.414zm2.12-10.607a1 1 0 010 1.414l-.706.707a1 1 0 11-1.414-1.414l.707-.707a1 1 0 011.414 0zM17 11a1 1 0 100-2h-1a1 1 0 100 2h1zm-7 4a1 1 0 011 1v1a1 1 0 11-2 0v-1a1 1 0 011-1zM5.05 6.464A1 1 0 106.465 5.05l-.708-.707a1 1 0 00-1.414 1.414l.707.707zm1.414 8.486l-.707.707a1 1 0 01-1.414-1.414l.707-.707a1 1 0 011.414 1.414zM4 11a1 1 0 100-2H3a1 1 0 000 2h1z" />
                    <!-- Ícone de lua (dark mode) -->
                    <path id="moon-icon" class="block dark:hidden" d="M17.293 13.293A8 8 0 016.707 2.707a8.001 8.001 0 1010.586 10.586z" />
                </svg>
            </button>
        </div>
    </div>

    <!-- Main Content -->
    <div class="flex-1 ml-64 p-6">
        <!-- Aqui entra o conteúdo principal da página -->
    </div>
</div>
