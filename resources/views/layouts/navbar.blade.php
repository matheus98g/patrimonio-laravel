<nav x-data="{ open: false }" class="bg-white dark:bg-gray-800 border-b border-gray-100 dark:border-gray-700">
    <!-- Primary Navigation Menu -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex">
                <!-- Logo -->
                <div class="shrink-0 flex items-center">
                    <a href="{{ route('dashboard') }}">
                        <x-application-logo class="block h-9 w-auto fill-current text-gray-800 dark:text-gray-200" />
                    </a>
                </div>
                
                <!-- Botão de alternância -->
                <div class="shrink-0 flex items-center ms-6 sm:ms-8">
                    <button id="theme-toggle" class="p-2 rounded-full bg-gray-100 dark:bg-gray-700 text-gray-800 dark:text-gray-200 hover:bg-gray-300 dark:hover:bg-gray-600">
                        <svg id="theme-icon" class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                            <!-- Ícone de sol (light mode) -->
                            <path id="sun-icon" class="hidden dark:block" d="M10 2a1 1 0 011 1v1a1 1 0 11-2 0V3a1 1 0 011-1zm4 8a4 4 0 11-8 0 4 4 0 018 0zm-.464 4.95l.707.707a1 1 0 001.414-1.414l-.707-.707a1 1 0 00-1.414 1.414zm2.12-10.607a1 1 0 010 1.414l-.706.707a1 1 0 11-1.414-1.414l.707-.707a1 1 0 011.414 0zM17 11a1 1 0 100-2h-1a1 1 0 100 2h1zm-7 4a1 1 0 011 1v1a1 1 0 11-2 0v-1a1 1 0 011-1zM5.05 6.464A1 1 0 106.465 5.05l-.708-.707a1 1 0 00-1.414 1.414l.707.707zm1.414 8.486l-.707.707a1 1 0 01-1.414-1.414l.707-.707a1 1 0 011.414 1.414zM4 11a1 1 0 100-2H3a1 1 0 000 2h1z" />
                            <!-- Ícone de lua (dark mode) -->
                            <path id="moon-icon" class="block dark:hidden" d="M17.293 13.293A8 8 0 016.707 2.707a8.001 8.001 0 1010.586 10.586z" />
                        </svg>
                    </button>
                </div>

                <!-- Navigation Links -->

                {{-- Admin Dropdown --}}
                
                    <div class="hidden sm:flex sm:items-center sm:ms-6">
                        <x-dropdown align="right" width="48">
                            <x-slot name="trigger">
                                <button
                                    class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 dark:text-gray-400 bg-white dark:bg-gray-800 hover:text-gray-700 dark:hover:text-gray-300 focus:outline-none transition ease-in-out duration-150">
                                    <div><span>Admin</span></div>
                                    <div class="ms-1">
                                        <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg"
                                            viewBox="0 0 20 20">
                                            <path fill-rule="evenodd"
                                                d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                                clip-rule="evenodd" />
                                        </svg>
                                    </div>
                                </button>
                            </x-slot>

                            <x-slot name="content">
                                <x-dropdown-link :href="route('admin.dashboard')" :active="request()->routeIs('admin.dashboard')">
                                    {{ ('Admin Dashboard') }}
                                </x-dropdown-link>
                                <x-dropdown-link :href="route('admin.users.index')" :active="request()->routeIs('admin.users.index')">
                                    {{ ('Controle de Acesso') }}
                                </x-dropdown-link>
                                <x-dropdown-link :href="route('admin.roles.index')" :active="request()->routeIs('admin.roles.index')">
                                    {{ ('Cargos') }}
                                </x-dropdown-link>
                                 <x-dropdown-link :href="route('admin.permissions.index')" :active="request()->routeIs('admin.permissions.index')">
                                    {{ ('Permissões') }}
                                </x-dropdown-link>
                            </x-slot>
                        </x-dropdown>
                    </div>


                {{-- Usuarios Dropdown --}}
                <div class="hidden sm:flex sm:items-center sm:ms-6">
                    <x-dropdown align="right" width="48">
                        <x-slot name="trigger">
                            <button
                                class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 dark:text-gray-400 bg-white dark:bg-gray-800 hover:text-gray-700 dark:hover:text-gray-300 focus:outline-none transition ease-in-out duration-150">
                                <div><span>Usuarios</span></div>
                                <div class="ms-1">
                                    <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg"
                                        viewBox="0 0 20 20">
                                        <path fill-rule="evenodd"
                                            d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                            clip-rule="evenodd" />
                                    </svg>
                                </div>
                            </button>
                        </x-slot>

                        <x-slot name="content">
                            {{-- <x-dropdown-link :href="route('usuarios.index')" :active="request()->routeIs('usuarios.index')">
                                {{ ('Listar Usuarios') }}
                            </x-dropdown-link> --}}
                            <x-dropdown-link :href="route('register')" :active="request()->routeIs('register')">
                                {{ ('Cadastrar Novo') }}
                            </x-dropdown-link>
                        </x-slot>
                    </x-dropdown>
                </div>


                {{-- <!-- Ativos Dropdown -->
                <div class="hidden sm:flex sm:items-center sm:ms-6">
                    <x-dropdown align="right" width="48">
                        <x-slot name="trigger">
                            <button
                                class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 dark:text-gray-400 bg-white dark:bg-gray-800 hover:text-gray-700 dark:hover:text-gray-300 focus:outline-none transition ease-in-out duration-150">
                                <div><span>Gerenciar</span></div>
                                <div class="ms-1">
                                    <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg"
                                        viewBox="0 0 20 20">
                                        <path fill-rule="evenodd"
                                            d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                            clip-rule="evenodd" />
                                    </svg>
                                </div>
                            </button>
                        </x-slot>

                        <x-slot name="content">
                            <x-dropdown-link :href="route('ativos.index')" :active="request()->routeIs('ativos.index')" 
                                @if (auth()->user()->hasRole('admin') || auth()->user()->can('view-ativos'))>
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
                        </x-slot>
                    </x-dropdown>
                </div> --}}

                <!-- Ativos Dropdown -->
                <div class="hidden sm:flex sm:items-center sm:ms-6">
                        <x-dropdown align="right" width="48">
                            <x-slot name="trigger">
                                <button
                                    class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 dark:text-gray-400 bg-white dark:bg-gray-800 hover:text-gray-700 dark:hover:text-gray-300 focus:outline-none transition ease-in-out duration-150">
                                    <div><span>Gerenciar</span></div>
                                    <div class="ms-1">
                                        <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg"
                                            viewBox="0 0 20 20">
                                            <path fill-rule="evenodd"
                                                d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                                clip-rule="evenodd" />
                                        </svg>
                                    </div>
                                </button>
                            </x-slot>

                            <x-slot name="content">
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
                            </x-slot>
                        </x-dropdown>
                </div>




                <div class="hidden space-x-8 sm:-my-px sm:ms-10 sm:flex">
                    <x-nav-link :href="route('movimentacoes.index')" :active="request()->routeIs('movimentacoes.index')">
                        {{ ('Movimentações') }}
                    </x-nav-link>
                </div>

                <div class="hidden space-x-8 sm:-my-px sm:ms-10 sm:flex">
                    <x-nav-link :href="route('produtos.index')" :active="request()->routeIs('produtos.index')">
                        {{ ('Produtos') }}
                    </x-nav-link>
                </div>

            </div>
            

            <!-- Settings Dropdown -->
            <div class="hidden sm:flex sm:items-center sm:ms-6">
                <x-dropdown align="right" width="48">
                    <x-slot name="trigger">
                        <button class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 dark:text-gray-400 bg-white dark:bg-gray-800 hover:text-gray-700 dark:hover:text-gray-300 focus:outline-none transition ease-in-out duration-150">
                            <div>{{ Auth::user()->name }}</div>

                            <div class="ms-1">
                                <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                </svg>
                            </div>
                        </button>
                    </x-slot>

                    <x-slot name="content">
                        <x-dropdown-link :href="route('profile.edit')">
                            {{ ('Profile') }}
                        </x-dropdown-link>

                        <!-- Authentication -->
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf

                            <x-dropdown-link :href="route('logout')"
                                    onclick="event.preventDefault();
                                                this.closest('form').submit();">
                                {{ ('Log Out') }}
                            </x-dropdown-link>
                        </form>
                    </x-slot>
                </x-dropdown>
            </div>

            <!-- Hamburger -->
            <div class="-me-2 flex items-center sm:hidden">
                <button @click="open = ! open" class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 dark:text-gray-500 hover:text-gray-500 dark:hover:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-900 focus:outline-none focus:bg-gray-100 dark:focus:bg-gray-900 focus:text-gray-500 dark:focus:text-gray-400 transition duration-150 ease-in-out">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Responsive Navigation Menu -->
    <div :class="{'block': open, 'hidden': ! open}" class="hidden sm:hidden">
        <div class="pt-2 pb-3 space-y-1">
            <x-responsive-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                {{ ('Dashboard') }}
            </x-responsive-nav-link>
            <x-responsive-nav-link :href="route('register')" :active="request()->routeIs('register')">
                {{ ('Cadastrar Usuario') }}
            </x-responsive-nav-link>
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
            <x-responsive-nav-link :href="route('produtos.index')" :active="request()->routeIs('produtos.index')">
                {{ ('Produtos') }}
            </x-responsive-nav-link>
        </div>

        <!-- Responsive Settings Options -->
        <div class="pt-4 pb-1 border-t border-gray-200 dark:border-gray-600">
            <div class="px-4">
                <div class="font-medium text-base text-gray-800 dark:text-gray-200">{{ Auth::user()->name }}</div>
                <div class="font-medium text-sm text-gray-500">{{ Auth::user()->email }}</div>
            </div>

            <div class="mt-3 space-y-1">
                <x-responsive-nav-link :href="route('profile.edit')">
                    {{ ('Profile') }}
                </x-responsive-nav-link>

                <!-- Authentication -->
                <form method="POST" action="{{ route('logout') }}">
                    @csrf

                    <x-responsive-nav-link :href="route('logout')"
                            onclick="event.preventDefault();
                                        this.closest('form').submit();">
                        {{ ('Log Out') }}
                    </x-responsive-nav-link>
                </form>
            </div>
        </div>
    </div>
</nav>
