<nav x-data="{ open: false }" class="border-b border-gray-200 bg-white transition-colors duration-200 dark:border-slate-700 dark:bg-slate-900">
    <!-- Primary Navigation Menu -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="relative flex h-16 items-center justify-between gap-6">
            <div class="flex min-w-0 items-center gap-8">
                <!-- Logo e nome do projeto -->
                <div class="shrink-0 flex items-center">
                    <a href="{{ route('dashboard') }}" class="flex items-center gap-3">
                        <div class="flex items-center">
                            <x-application-logo class="h-9 w-auto" />
                        </div>
                    </a>
                </div>

                <!-- links de navegação -->
                <div class="hidden items-center space-x-8 sm:flex">
                    <x-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                        Painel
                    </x-nav-link>
                    <x-nav-link :href="route('transactions.index')" :active="request()->routeIs('transactions.*')">
                        Transações
                    </x-nav-link>
                </div>

            </div>

            <!-- Brand central como no layout final do print -->
            <div class="hidden sm:flex items-center justify-center flex-1 px-6">
                <span class="text-base font-bold tracking-tight text-green-600 md:text-lg">Meu Saldo Certo</span>
            </div>

            <!-- Acoes globais: perfil -->
            <div class="hidden sm:flex sm:items-center sm:gap-3 sm:ms-6">
                <x-theme-toggle />

                <x-dropdown align="right" width="48">
                    <x-slot name="trigger">
                        <button class="inline-flex items-center rounded-md border border-transparent bg-white px-3 py-2 text-sm font-medium leading-4 text-gray-600 transition duration-150 ease-in-out hover:text-gray-800 focus:outline-none dark:bg-slate-900 dark:text-slate-300 dark:hover:text-white">
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
                            Perfil
                        </x-dropdown-link>

                        <!-- Authentication -->
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf

                            <x-dropdown-link :href="route('logout')"
                                    onclick="event.preventDefault();
                                                this.closest('form').submit();">
                                Sair
                            </x-dropdown-link>
                        </form>
                    </x-slot>
                </x-dropdown>
            </div>

            <!-- Hamburger -->
            <div class="-me-2 flex items-center gap-2 sm:hidden">
                <x-theme-toggle />

                <button @click="open = ! open" class="inline-flex items-center justify-center rounded-md p-2 text-gray-400 transition duration-150 ease-in-out hover:bg-gray-50 hover:text-gray-500 focus:bg-gray-50 focus:text-gray-500 focus:outline-none dark:text-slate-400 dark:hover:bg-slate-800 dark:hover:text-slate-200 dark:focus:bg-slate-800 dark:focus:text-slate-200">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Responsive Navigation Menu -->
    <div :class="{'block': open, 'hidden': ! open}" class="hidden bg-white transition-colors duration-200 dark:bg-slate-900 sm:hidden">
        <div class="pt-2 pb-3 space-y-1">
            <x-responsive-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                Painel
            </x-responsive-nav-link>
            <x-responsive-nav-link :href="route('transactions.index')" :active="request()->routeIs('transactions.*')">
                Transações
            </x-responsive-nav-link>
        </div>

        <!-- Responsive Settings Options -->
        <div class="border-t border-gray-200 pt-4 pb-1 dark:border-slate-700">
            <div class="px-4">
                <div class="text-base font-medium text-gray-800 dark:text-slate-100">{{ Auth::user()->name }}</div>
                <div class="text-sm font-medium text-gray-500 dark:text-slate-400">{{ Auth::user()->email }}</div>
            </div>

            <div class="mt-3 space-y-1">
                <x-responsive-nav-link :href="route('profile.edit')">
                    Perfil
                </x-responsive-nav-link>

                <!-- Authentication -->
                <form method="POST" action="{{ route('logout') }}">
                    @csrf

                    <x-responsive-nav-link :href="route('logout')"
                            onclick="event.preventDefault();
                                        this.closest('form').submit();">
                        Sair
                    </x-responsive-nav-link>
                </form>
            </div>
        </div>
    </div>
</nav>
