<nav x-data="{ open: false }" class="bg-white dark:bg-gray-800 border-b border-gray-100 dark:border-gray-700 z-50">
    <!-- Primary Navigation Menu -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between items-center h-16">
            <!-- Left Section: Logo and Theme Toggle -->
            <div class="flex items-center space-x-4">
                <!-- Logo -->
                <div class="flex-shrink-0">
                    <a href="{{ route('dashboard') }}">
                        <x-application-logo class="block h-9 w-auto fill-current text-gray-800 dark:text-gray-200" />
                    </a>
                </div>
                
                <!-- Theme Toggle -->
                <div>
                    <button id="theme-toggle" 
                            class="p-2 rounded-full bg-gray-100 dark:bg-gray-700 text-gray-800 dark:text-gray-200 hover:bg-gray-200 dark:hover:bg-gray-600 transition-colors duration-200">
                        <svg id="theme-icon" class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                            <path id="sun-icon" class="hidden dark:block" d="M10 2a1 1 0 011 1v1a1 1 0 11-2 0V3a1 1 0 011-1zm4 8a4 4 0 11-8 0 4 4 0 018 0zm-.464 4.95l.707.707a1 1 0 001.414-1.414l-.707-.707a1 1 0 00-1.414 1.414zm2.12-10.607a1 1 0 010 1.414l-.706.707a1 1 0 11-1.414-1.414l.707-.707a1 1 0 011.414 0zM17 11a1 1 0 100-2h-1a1 1 0 100 2h1zm-7 4a1 1 0 011 1v1a1 1 0 11-2 0v-1a1 1 0 011-1zM5.05 6.464A1 1 0 106.465 5.05l-.708-.707a1 1 0 00-1.414 1.414l.707.707zm1.414 8.486l-.707.707a1 1 0 01-1.414-1.414l.707-.707a1 1 0 011.414 1.414zM4 11a1 1 0 100-2H3a1 1 0 000 2h1z" />
                            <path id="moon-icon" class="block dark:hidden" d="M17.293 13.293A8 8 0 016.707 2.707a8.001 8.001 0 1010.586 10.586z" />
                        </svg>
                    </button>
                </div>
            </div>

            <!-- Center Section: Navigation -->
            <div class="hidden sm:flex sm:items-center sm:space-x-6 z-50">

                <x-responsive-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                    {{ ('Dashboard') }}
                </x-responsive-nav-link>
                <!-- Admin Dropdown -->
                <x-dropdown align="right" width="48">
                    <x-slot name="trigger">
                        <button class="inline-flex items-center px-3 py-2 text-sm font-medium text-gray-600 dark:text-gray-400 hover:text-gray-800 dark:hover:text-gray-200 bg-white dark:bg-gray-800 rounded-md hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors duration-200">
                            <span>Admin</span>
                            <svg class="ml-1 h-4 w-4 fill-current" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                            </svg>
                        </button>
                    </x-slot>
                    <x-slot name="content">
                        <x-dropdown-link :href="route('admin.dashboard')" :active="request()->routeIs('admin.dashboard')">
                            {{ ('Admin Dashboard') }}
                        </x-dropdown-link>
                        <x-dropdown-link :href="route('admin.users.index')" :active="request()->routeIs('admin.users.index')">
                            {{ ('Usuários') }}
                        </x-dropdown-link>
                        <x-dropdown-link :href="route('admin.roles.index')" :active="request()->routeIs('admin.roles.index')">
                            {{ ('Cargos') }}
                        </x-dropdown-link>
                        <x-dropdown-link :href="route('admin.permissions.index')" :active="request()->routeIs('admin.permissions.index')">
                            {{ ('Permissões') }}
                        </x-dropdown-link>
                    </x-slot>
                </x-dropdown>

                <!-- Usuarios Dropdown -->
                {{-- <x-dropdown align="right" width="48">
                    <x-slot name="trigger">
                        <button class="inline-flex items-center px-3 py-2 text-sm font-medium text-gray-600 dark:text-gray-400 hover:text-gray-800 dark:hover:text-gray-200 bg-white dark:bg-gray-800 rounded-md hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors duration-200">
                            <span>Usuários</span>
                            <svg class="ml-1 h-4 w-4 fill-current" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                            </svg>
                        </button>
                    </x-slot>
                    <x-slot name="content">
                        <x-dropdown-link :href="route('admin.users.index')" :active="request()->routeIs('admin.users.index')">
                            {{ ('Listar todos') }}
                        </x-dropdown-link>
                    </x-slot>
                </x-dropdown> --}}


                <!-- Usuarios Dropdown -->
                {{-- <x-dropdown align="right" width="48">
                    <x-slot name="trigger">
                        <button class="inline-flex items-center px-3 py-2 text-sm font-medium text-gray-600 dark:text-gray-400 hover:text-gray-800 dark:hover:text-gray-200 bg-white dark:bg-gray-800 rounded-md hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors duration-200">
                            <span>Usuários</span>
                            <svg class="ml-1 h-4 w-4 fill-current" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                            </svg>
                        </button>
                    </x-slot>
                    <x-slot name="content">
                        
                    </x-slot>
                </x-dropdown> --}}



                <!-- Gerenciar Dropdown -->
                <x-dropdown align="right" width="48">
                    <x-slot name="trigger">
                        <button class="inline-flex items-center px-3 py-2 text-sm font-medium text-gray-600 dark:text-gray-400 hover:text-gray-800 dark:hover:text-gray-200 bg-white dark:bg-gray-800 rounded-md hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors duration-200">
                            <span>Gerenciar</span>
                            <svg class="ml-1 h-4 w-4 fill-current" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                            </svg>
                        </button>
                    </x-slot>
                    <x-slot name="content">
                        <x-dropdown-link :href="route('ativos.index')" :active="request()->routeIs('ativos.index')">{{ ('Ativos') }}</x-dropdown-link>
                        <x-dropdown-link :href="route('marcas.index')" :active="request()->routeIs('marcas.index')">{{ ('Marcas') }}</x-dropdown-link>
                        <x-dropdown-link :href="route('tipos.index')" :active="request()->routeIs('tipos.index')">{{ ('Tipos') }}</x-dropdown-link>
                        <x-dropdown-link :href="route('locais.index')" :active="request()->routeIs('locais.index')">{{ ('Locais') }}</x-dropdown-link>
                        <x-dropdown-link :href="route('movimentacoes.index')" :active="request()->routeIs('movimentacoes.index')">
                            {{ ('Movimentações') }}
                        </x-dropdown-link>
                        {{-- <x-dropdown-link :href="route('produtos.index')" :active="request()->routeIs('produtos.index')">
                            {{ ('Produtos') }}
                        </x-dropdown-link> --}}
                    </x-slot>
                </x-dropdown>

                <!-- Single Links -->
            </div>

            <!-- Right Section: User Menu -->
            <div class="hidden sm:flex sm:items-center">
                <x-dropdown align="right" width="48">
                    <x-slot name="trigger">
                        <button class="inline-flex items-center px-3 py-2 text-sm font-medium text-gray-600 dark:text-gray-400 hover:text-gray-800 dark:hover:text-gray-200 bg-white dark:bg-gray-800 rounded-md hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors duration-200">
                            <span>{{ Auth::user()->name }}</span>
                            <svg class="ml-1 h-4 w-4 fill-current" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                            </svg>
                        </button>
                    </x-slot>
                    <x-slot name="content">
                        <x-dropdown-link :href="route('profile.edit')">{{ ('Perfil') }}</x-dropdown-link>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <x-dropdown-link :href="route('logout')" onclick="event.preventDefault(); this.closest('form').submit();">
                                {{ ('Sair') }}
                            </x-dropdown-link>
                        </form>
                    </x-slot>
                </x-dropdown>
            </div>

            <!-- Hamburger Menu -->
            <div class="flex items-center sm:hidden">
                <button @click="open = ! open" 
                        class="p-2 rounded-md text-gray-400 dark:text-gray-500 hover:text-gray-600 dark:hover:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors duration-200">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': !open}" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{'hidden': !open, 'inline-flex': open}" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Responsive Navigation Menu (Mobile) -->
    <div :class="{'block': open, 'hidden': !open}" 
    class="sm:hidden absolute top-full left-0 right-0 bg-white dark:bg-gray-800 border-t border-gray-200 dark:border-gray-600 shadow-lg z-50">
   <div class="pt-2 pb-3 space-y-1">

    <!-- Dashboard Link -->
    <x-responsive-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
        {{ ('Dashboard') }}
    </x-responsive-nav-link>

    <!-- Admin Links -->

    <div x-data="{ adminOpen: false }">
        <button @click="adminOpen = !adminOpen" 
                class="w-full flex items-center justify-between px-4 py-2 text-sm font-medium text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors duration-200">
            Admin
            <svg class="w-4 h-4 transform transition-transform" :class="{'rotate-180': adminOpen}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
            </svg>
        </button>
        <div x-show="adminOpen" x-transition class="pl-6 space-y-1">
            <x-responsive-nav-link :href="route('admin.dashboard')" :active="request()->routeIs('admin.dashboard')">
                {{ ('Admin Dashboard') }}
            </x-responsive-nav-link>
            <x-responsive-nav-link :href="route('admin.users.index')" :active="request()->routeIs('admin.users.index')">
                {{ ('Usuários') }}
            </x-responsive-nav-link>
            <x-responsive-nav-link :href="route('admin.roles.index')" :active="request()->routeIs('admin.roles.index')">
                {{ ('Cargos') }}
            </x-responsive-nav-link>
            <x-responsive-nav-link :href="route('admin.permissions.index')" :active="request()->routeIs('admin.permissions.index')">
                {{ ('Permissões') }}
            </x-responsive-nav-link>
        </div>
    </div>

    <!-- Gerenciar Links -->
    {{-- <div class="border-t border-gray-200 dark:border-gray-600 mt-2 pt-2">
        <div class="px-4 text-gray-500 dark:text-gray-400 text-xs uppercase tracking-wider">
            Gerenciar
        </div>
        <x-responsive-nav-link :href="route('ativos.index')" :active="request()->routeIs('ativos.index')">
            {{ ('Ativos') }}
        </x-responsive-nav-link>
        <x-responsive-nav-link :href="route('marcas.index')" :active="request()->routeIs('marcas.index')">
            {{ ('Marcas') }}
        </x-responsive-nav-link>
        <x-responsive-nav-link :href="route('tipos.index')" :active="request()->routeIs('tipos.index')">
            {{ ('Tipos') }}
        </x-responsive-nav-link>
        <x-responsive-nav-link :href="route('locais.index')" :active="request()->routeIs('locais.index')">
            {{ ('Locais') }}
        </x-responsive-nav-link>
        <x-responsive-nav-link :href="route('movimentacoes.index')" :active="request()->routeIs('movimentacoes.index')">
            {{ ('Movimentações') }}
        </x-responsive-nav-link>
        {{-- <x-responsive-nav-link :href="route('produtos.index')" :active="request()->routeIs('produtos.index')">
            {{ ('Produtos') }}
        </x-responsive-nav-link> --}}
    {{-- </div> --}}

    <div x-data="{ gerenciarOpen: false }">
        <button @click="gerenciarOpen = !gerenciarOpen" 
                class="w-full flex items-center justify-between px-4 py-2 text-sm font-medium text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors duration-200">
            Gerenciar
            <svg class="w-4 h-4 transform transition-transform" :class="{'rotate-180': gerenciarOpen}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
            </svg>
        </button>
        <div x-show="gerenciarOpen" x-transition class="pl-6 space-y-1">
            <x-responsive-nav-link :href="route('ativos.index')" :active="request()->routeIs('ativos.index')">
                {{ ('Ativos') }}
            </x-responsive-nav-link>
            <x-responsive-nav-link :href="route('marcas.index')" :active="request()->routeIs('marcas.index')">
                {{ ('Marcas') }}
            </x-responsive-nav-link>
            <x-responsive-nav-link :href="route('tipos.index')" :active="request()->routeIs('tipos.index')">
                {{ ('Tipos') }}
            </x-responsive-nav-link>
            <x-responsive-nav-link :href="route('locais.index')" :active="request()->routeIs('locais.index')">
                {{ ('Locais') }}
            </x-responsive-nav-link>
            <x-responsive-nav-link :href="route('movimentacoes.index')" :active="request()->routeIs('movimentacoes.index')">
                {{ ('Movimentações') }}
            </x-responsive-nav-link>
        </div>
    </div>

    <div class="pt-4 pb-3 border-t border-gray-200 dark:border-gray-600">
        <div class="px-4">
            <div class="font-medium text-base text-gray-800 dark:text-gray-200">{{ Auth::user()->name }}</div>
            <div class="font-medium text-sm text-gray-500 dark:text-gray-400">{{ Auth::user()->email }}</div>
        </div>
        <div class="mt-3 space-y-1">
            <x-responsive-nav-link :href="route('profile.edit')">{{ ('Perfil') }}</x-responsive-nav-link>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <x-responsive-nav-link :href="route('logout')" onclick="event.preventDefault(); this.closest('form').submit();">
                    {{ ('Sair') }}
                </x-responsive-nav-link>
            </form>
        </div>
    </div>

</div>


    <!-- Responsive Navigation Menu -->
    {{-- <div :class="{'block': open, 'hidden': !open}" 
         class="sm:hidden absolute top-full left-0 right-0 bg-white dark:bg-gray-800 border-t border-gray-200 dark:border-gray-600 shadow-lg z-50">
        <div class="pt-2 pb-3 space-y-1">
            <x-responsive-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                {{ ('Dashboard') }}
            </x-responsive-nav-link>

            <!-- Admin Dropdown -->
            <div x-data="{ adminOpen: false }">
                <button @click="adminOpen = !adminOpen" 
                        class="w-full flex items-center justify-between px-4 py-2 text-sm font-medium text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors duration-200">
                    Admin
                    <svg class="w-4 h-4 transform transition-transform" :class="{'rotate-180': adminOpen}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                    </svg>
                </button>
                <div x-show="adminOpen" x-transition class="pl-6 space-y-1">
                    <x-responsive-nav-link :href="route('admin.dashboard')" :active="request()->routeIs('admin.dashboard')">
                        {{ ('Admin Dashboard') }}
                    </x-responsive-nav-link>
                </div>
            </div>

            <!-- Usuarios Dropdown -->
            <div x-data="{ usuariosOpen: false }">
                <button @click="usuariosOpen = !usuariosOpen" 
                        class="w-full flex items-center justify-between px-4 py-2 text-sm font-medium text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors duration-200">
                    Usuários
                    <svg class="w-4 h-4 transform transition-transform" :class="{'rotate-180': usuariosOpen}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                    </svg>
                </button>
                <div x-show="usuariosOpen" x-transition class="pl-6 space-y-1">
                    <x-responsive-nav-link :href="route('admin.users.index')" :active="request()->routeIs('admin.users.index')">
                        {{ ('Listar todos') }}
                    </x-responsive-nav-link>
                </div>
            </div>

            <!-- Gerenciar Dropdown -->
            <div x-data="{ gerenciarOpen: false }">
                <button @click="gerenciarOpen = !gerenciarOpen" 
                        class="w-full flex items-center justify-between px-4 py-2 text-sm font-medium text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors duration-200">
                    Gerenciar
                    <svg class="w-4 h-4 transform transition-transform" :class="{'rotate-180': gerenciarOpen}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                    </svg>
                </button>
                <div x-show="gerenciarOpen" x-transition class="pl-6 space-y-1">
                    <x-responsive-nav-link :href="route('ativos.index')" :active="request()->routeIs('ativos.index')">{{ ('Ativos') }}</x-responsive-nav-link>
                    <x-responsive-nav-link :href="route('marcas.index')" :active="request()->routeIs('marcas.index')">{{ ('Marcas') }}</x-responsive-nav-link>
                    <x-responsive-nav-link :href="route('tipos.index')" :active="request()->routeIs('tipos.index')">{{ ('Tipos') }}</x-responsive-nav-link>
                    <x-responsive-nav-link :href="route('locais.index')" :active="request()->routeIs('locais.index')">{{ ('Locais') }}</x-responsive-nav-link>
                    <x-responsive-nav-link :href="route('movimentacoes.index')" :active="request()->routeIs('movimentacoes.index')">
                        {{ ('Movimentações') }}
                    </x-responsive-nav-link>
                    <x-responsive-nav-link :href="route('produtos.index')" :active="request()->routeIs('produtos.index')">
                        {{ ('Produtos') }}
                    </x-responsive-nav-link>
                </div>
            </div>
        </div>

        <!-- Responsive User Menu -->
        <div class="pt-4 pb-3 border-t border-gray-200 dark:border-gray-600">
            <div class="px-4">
                <div class="font-medium text-base text-gray-800 dark:text-gray-200">{{ Auth::user()->name }}</div>
                <div class="font-medium text-sm text-gray-500 dark:text-gray-400">{{ Auth::user()->email }}</div>
            </div>
            <div class="mt-3 space-y-1">
                <x-responsive-nav-link :href="route('profile.edit')">{{ ('Perfil') }}</x-responsive-nav-link>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <x-responsive-nav-link :href="route('logout')" onclick="event.preventDefault(); this.closest('form').submit();">
                        {{ ('Sair') }}
                    </x-responsive-nav-link>
                </form>
            </div>
        </div>
    </div> --}}
</nav>