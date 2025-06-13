@extends('layouts.app')

@section('title', 'Cozinhas')
@section('header', 'Cozinhas')
@section('subheader', 'Descubra restaurantes por tipo de cozinha')

@section('content')
    <div class="max-w-7xl mx-auto">
        <!-- Filtros -->
        <div class="card mb-6">
            <div class="p-6">
                <form action="{{ route('cuisines.index') }}" method="GET" class="space-y-4">
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        <div>
                            <label for="search" class="block text-sm font-medium text-gray-300 mb-1">Buscar</label>
                            <div class="relative">
                                <input type="text" name="search" id="search" value="{{ request('search') }}"
                                       class="w-full pl-10" placeholder="Nome da cozinha...">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <i class="fas fa-search text-gray-400"></i>
                                </div>
                            </div>
                        </div>

                        <div>
                            <label for="sort" class="block text-sm font-medium text-gray-300 mb-1">Ordenar por</label>
                            <div class="relative">
                                <select name="sort" id="sort" class="w-full pl-10 appearance-none">
                                    <option value="name" {{ request('sort') == 'name' ? 'selected' : '' }}>Nome</option>
                                    <option value="restaurants_count" {{ request('sort') == 'restaurants_count' ? 'selected' : '' }}>Quantidade de Restaurantes</option>
                                </select>
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <i class="fas fa-sort text-gray-400"></i>
                                </div>
                                <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                                    <i class="fas fa-chevron-down text-gray-400"></i>
                                </div>
                            </div>
                        </div>

                        <div>
                            <label for="order" class="block text-sm font-medium text-gray-300 mb-1">Ordem</label>
                            <div class="relative">
                                <select name="order" id="order" class="w-full pl-10 appearance-none">
                                    <option value="asc" {{ request('order') == 'asc' ? 'selected' : '' }}>Crescente</option>
                                    <option value="desc" {{ request('order') == 'desc' ? 'selected' : '' }}>Decrescente</option>
                                </select>
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <i class="fas fa-arrow-up-arrow-down text-gray-400"></i>
                                </div>
                                <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                                    <i class="fas fa-chevron-down text-gray-400"></i>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="flex justify-end">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-search mr-2"></i> Filtrar
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Lista de Cozinhas -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @forelse($cuisines as $cuisine)
                <div class="card hover:shadow-lg transition-shadow group">
                    <a href="{{ route('cuisines.show', $cuisine) }}" class="block">
                        <div class="p-6">
                            <div class="flex items-center justify-between mb-4">
                                <div class="flex items-center space-x-3">
                                    <div class="w-12 h-12 bg-primary/10 rounded-lg flex items-center justify-center group-hover:bg-primary/20 transition-colors">
                                        <i class="{{ $cuisine->icon }} text-2xl text-primary"></i>
                                    </div>
                                    <h3 class="text-lg font-semibold group-hover:text-primary transition-colors">{{ $cuisine->name }}</h3>
                                </div>
                                <span class="text-sm text-gray-400">
                                    {{ $cuisine->restaurants_count }} restaurantes
                                </span>
                            </div>

                            <p class="text-gray-400 mb-4">{{ $cuisine->description }}</p>

                            <div class="flex items-center justify-between">
                                <span class="text-sm text-gray-400">
                                    <i class="fas fa-star text-yellow-400 mr-1"></i>
                                    {{ number_format($cuisine->restaurants->avg('average_rating'), 1) }}
                                </span>
                                <span class="text-primary group-hover:underline">
                                    Ver restaurantes
                                    <i class="fas fa-arrow-right ml-1 group-hover:translate-x-1 transition-transform"></i>
                                </span>
                            </div>
                        </div>
                    </a>
                </div>
            @empty
                <div class="col-span-full">
                    <div class="card">
                        <div class="p-6 text-center">
                            <i class="fas fa-utensils text-4xl text-gray-400 mb-4"></i>
                            <p class="text-gray-400">Nenhuma cozinha encontrada.</p>
                            @if(request('search'))
                                <p class="text-sm text-gray-500 mt-2">
                                    Tente ajustar os filtros ou <a href="{{ route('cuisines.index') }}" class="text-primary hover:underline">limpar a busca</a>.
                                </p>
                            @endif
                        </div>
                    </div>
                </div>
            @endforelse
        </div>

        <!-- Paginação -->
        @if($cuisines->hasPages())
            <div class="mt-6">
                {{ $cuisines->links() }}
            </div>
        @endif
    </div>
@endsection
