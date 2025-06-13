<nav class="navbar">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex">
                <!-- Logo -->
                <div class="shrink-0 flex items-center">
                    <a href="{{ route('home') }}" class="flex items-center space-x-2 hover:scale-105 transition-transform duration-300">
                        <i class="fas fa-utensils text-primary-600 brand-icon"></i>
                        <span class="brand-name">Critério Gourmet</span>
                    </a>
                </div>

                <!-- Navigation Links -->
                <div class="hidden space-x-8 sm:-my-px sm:ml-10 sm:flex">
                    <a href="{{ route('home') }}" class="nav-link {{ request()->routeIs('home') ? 'active' : '' }}">
                        <i class="fas fa-home mr-2"></i> Início
                    </a>
                    <a href="{{ route('restaurants.index') }}" class="nav-link {{ request()->routeIs('restaurants.*') ? 'active' : '' }}">
                        <i class="fas fa-store mr-2"></i> Restaurantes
                    </a>
                    <a href="{{ route('restaurants.map') }}" class="nav-link {{ request()->routeIs('restaurants.map') ? 'active' : '' }}">
                        <i class="fas fa-map-marked-alt mr-2"></i> Mapa
                    </a>
                    <a href="{{ route('recommendations.index') }}" class="nav-link {{ request()->routeIs('recommendations.index') ? 'active' : '' }}">
                        <i class="fas fa-star mr-2"></i> Recomendações
                    </a>
                    <a href="{{ route('categories.index') }}" class="nav-link {{ request()->routeIs('categories.*') ? 'active' : '' }}">
                        <i class="fas fa-tags mr-2"></i> Categorias
                    </a>
                    <a href="{{ route('cuisines.index') }}" class="nav-link {{ request()->routeIs('cuisines.*') ? 'active' : '' }}">
                        <i class="fas fa-utensils mr-2"></i> Cozinhas
                    </a>
                </div>
            </div>

            <div class="hidden sm:flex sm:items-center sm:ml-6">
                <!-- Settings Dropdown -->
                <div class="ml-3 relative" x-data="{ open: false }">
                    @auth
                        <button @click="open = !open" class="flex items-center text-white hover:text-primary transition-colors duration-200">
                            <span class="mr-2">{{ Auth::user()->name }}</span>
                            <i class="fas fa-chevron-down text-sm transition-transform duration-200" :class="{ 'transform rotate-180': open }"></i>
                        </button>

                        <div x-show="open"
                             @click.away="open = false"
                             x-transition:enter="transition ease-out duration-200"
                             x-transition:enter-start="transform opacity-0 scale-95"
                             x-transition:enter-end="transform opacity-100 scale-100"
                             x-transition:leave="transition ease-in duration-75"
                             x-transition:leave-start="transform opacity-100 scale-100"
                             x-transition:leave-end="transform opacity-0 scale-95"
                             class="absolute right-0 mt-2 w-48 rounded-md shadow-lg bg-glass-bg backdrop-blur-lg border border-card-border">
                            <div class="py-1">
                                @if (Auth::user()->isAdmin())
                                    <a href="{{ route('admin.dashboard') }}" class="dropdown-item">
                                        <i class="fas fa-tachometer-alt mr-2"></i> Dashboard
                                    </a>
                                @endif
                                <a href="{{ route('profile.edit') }}" class="dropdown-item">
                                    <i class="fas fa-user mr-2"></i> Perfil
                                </a>
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit" class="dropdown-item w-full text-left">
                                        <i class="fas fa-sign-out-alt mr-2"></i> Sair
                                    </button>
                                </form>
                            </div>
                        </div>
                    @else
                        <a href="{{ route('login') }}" class="nav-link">
                            <i class="fas fa-sign-in-alt mr-2"></i> Entrar
                        </a>
                        <a href="{{ route('register') }}" class="nav-link ml-4">
                            <i class="fas fa-user-plus mr-2"></i> Registrar
                        </a>
                    @endauth
                </div>
            </div>

            <!-- Hamburger -->
            <div class="-mr-2 flex items-center sm:hidden">
                <button @click="open = !open" class="inline-flex items-center justify-center p-2 rounded-md text-white hover:text-primary focus:outline-none transition-colors duration-200">
                    <i class="fas fa-bars" :class="{ 'hidden': open, 'block': !open }"></i>
                    <i class="fas fa-times" :class="{ 'block': open, 'hidden': !open }"></i>
                </button>
            </div>
        </div>
    </div>

    <!-- Responsive Navigation Menu -->
    <div :class="{'block': open, 'hidden': !open}"
         class="sm:hidden"
         x-transition:enter="transition ease-out duration-200"
         x-transition:enter-start="opacity-0 transform -translate-y-2"
         x-transition:enter-end="opacity-100 transform translate-y-0"
         x-transition:leave="transition ease-in duration-150"
         x-transition:leave-start="opacity-100 transform translate-y-0"
         x-transition:leave-end="opacity-0 transform -translate-y-2">
        <div class="pt-2 pb-3 space-y-1">
            <a href="{{ route('home') }}" class="nav-link block pl-3 pr-4 py-2 {{ request()->routeIs('home') ? 'active' : '' }}">
                <i class="fas fa-home mr-2"></i> Início
            </a>
            <a href="{{ route('restaurants.index') }}" class="nav-link block pl-3 pr-4 py-2 {{ request()->routeIs('restaurants.*') ? 'active' : '' }}">
                <i class="fas fa-store mr-2"></i> Restaurantes
            </a>
            <a href="{{ route('restaurants.map') }}" class="nav-link block pl-3 pr-4 py-2 {{ request()->routeIs('restaurants.map') ? 'active' : '' }}">
                <i class="fas fa-map-marked-alt mr-2"></i> Mapa
            </a>
            <a href="{{ route('recommendations.index') }}" class="nav-link block pl-3 pr-4 py-2 {{ request()->routeIs('recommendations.index') ? 'active' : '' }}">
                <i class="fas fa-star mr-2"></i> Recomendações
            </a>
            <a href="{{ route('categories.index') }}" class="nav-link block pl-3 pr-4 py-2 {{ request()->routeIs('categories.*') ? 'active' : '' }}">
                <i class="fas fa-tags mr-2"></i> Categorias
            </a>
            <a href="{{ route('cuisines.index') }}" class="nav-link block pl-3 pr-4 py-2 {{ request()->routeIs('cuisines.*') ? 'active' : '' }}">
                <i class="fas fa-utensils mr-2"></i> Cozinhas
            </a>
        </div>

        <!-- Responsive Settings Options -->
        <div class="pt-4 pb-1 border-t border-gray-200">
            @auth
                <div class="px-4">
                    <div class="font-medium text-base text-white">{{ Auth::user()->name }}</div>
                    <div class="font-medium text-sm text-gray-300">{{ Auth::user()->email }}</div>
                </div>

                <div class="mt-3 space-y-1">
                    @if (Auth::user()->isAdmin())
                        <a href="{{ route('admin.dashboard') }}" class="nav-link block pl-3 pr-4 py-2">
                            <i class="fas fa-tachometer-alt mr-2"></i> Dashboard
                        </a>
                    @endif
                    <a href="{{ route('profile.edit') }}" class="nav-link block pl-3 pr-4 py-2">
                        <i class="fas fa-user mr-2"></i> Perfil
                    </a>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="nav-link block w-full text-left pl-3 pr-4 py-2">
                            <i class="fas fa-sign-out-alt mr-2"></i> Sair
                        </button>
                    </form>
                </div>
            @else
                <div class="mt-3 space-y-1">
                    <a href="{{ route('login') }}" class="nav-link block pl-3 pr-4 py-2">
                        <i class="fas fa-sign-in-alt mr-2"></i> Entrar
                    </a>
                    <a href="{{ route('register') }}" class="nav-link block pl-3 pr-4 py-2">
                        <i class="fas fa-user-plus mr-2"></i> Registrar
                    </a>
                </div>
            @endauth
        </div>
    </div>
</nav>

<style>
    .dropdown-item {
        display: block;
        padding: 0.75rem 1rem;
        color: var(--text-color);
        transition: all 0.2s;
    }
    .dropdown-item:hover {
        background: rgba(212,175,55,0.1);
        color: var(--primary-color);
    }
    .dropdown-item i {
        width: 1.25rem;
        text-align: center;
    }
</style>
