@extends('layouts.app')

@section('title', $cuisine->name)
@section('header', $cuisine->name)
@section('subheader', $cuisine->description)

@section('content')
    <div class="max-w-7xl mx-auto">
        <!-- Cabeçalho da Cozinha -->
        <div class="card mb-6">
            <div class="p-6">
                <div class="flex items-center justify-between">
                    <div class="flex items-center space-x-4">
                        <div class="w-16 h-16 bg-primary/10 rounded-lg flex items-center justify-center group-hover:bg-primary/20 transition-colors">
                            <i class="{{ $cuisine->icon }} text-3xl text-primary"></i>
                        </div>
                        <div>
                            <h2 class="text-2xl font-bold">{{ $cuisine->name }}</h2>
                            <p class="text-gray-400">{{ $cuisine->description }}</p>
                        </div>
                    </div>
                    @auth
                        @can('update', $cuisine)
                            <a href="{{ route('cuisines.edit', $cuisine) }}" class="btn btn-secondary">
                                <i class="fas fa-edit mr-2"></i> Editar
                            </a>
                        @endcan
                    @endauth
                </div>
            </div>
        </div>

        <!-- Filtros -->
        <div class="card mb-6">
            <div class="p-6">
                <form action="{{ route('cuisines.show', $cuisine) }}" method="GET" class="space-y-4">
                    <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                        <div>
                            <label for="search" class="block text-sm font-medium text-gray-300 mb-1">Buscar</label>
                            <div class="relative">
                                <input type="text" name="search" id="search" value="{{ request('search') }}"
                                       class="w-full pl-10" placeholder="Nome do restaurante...">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <i class="fas fa-search text-gray-400"></i>
                                </div>
                            </div>
                        </div>

                        <div>
                            <label for="category" class="block text-sm font-medium text-gray-300 mb-1">Categoria</label>
                            <div class="relative">
                                <select name="category" id="category" class="w-full pl-10 appearance-none">
                                    <option value="">Todas as categorias</option>
                                    @foreach($categories as $category)
                                        <option value="{{ $category->id }}" {{ request('category') == $category->id ? 'selected' : '' }}>
                                            {{ $category->name }}
                                        </option>
                                    @endforeach
                                </select>
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <i class="fas fa-tag text-gray-400"></i>
                                </div>
                                <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                                    <i class="fas fa-chevron-down text-gray-400"></i>
                                </div>
                            </div>
                        </div>

                        <div>
                            <label for="sort" class="block text-sm font-medium text-gray-300 mb-1">Ordenar por</label>
                            <div class="relative">
                                <select name="sort" id="sort" class="w-full pl-10 appearance-none">
                                    <option value="name" {{ request('sort') == 'name' ? 'selected' : '' }}>Nome</option>
                                    <option value="rating" {{ request('sort') == 'rating' ? 'selected' : '' }}>Avaliação</option>
                                    <option value="reviews" {{ request('sort') == 'reviews' ? 'selected' : '' }}>Quantidade de Avaliações</option>
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

        <!-- Lista de Restaurantes -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @forelse($restaurants as $restaurant)
                <div class="card hover:shadow-lg transition-shadow group">
                    <a href="{{ route('restaurants.show', $restaurant) }}" class="block">
                        <div class="relative">
                            @if($restaurant->photos->count() > 0)
                                <img src="{{ $restaurant->photos->first()->url }}" alt="{{ $restaurant->name }}" class="w-full h-48 object-cover rounded-t-lg">
                            @else
                                <div class="w-full h-48 bg-gray-700 rounded-t-lg flex items-center justify-center">
                                    <i class="fas fa-utensils text-4xl text-gray-400"></i>
                                </div>
                            @endif
                            <div class="absolute top-4 right-4">
                                <span class="bg-primary text-white px-2 py-1 rounded-full text-sm">
                                    <i class="fas fa-star mr-1"></i>
                                    {{ number_format($restaurant->average_rating, 1) }}
                                </span>
                            </div>
                        </div>

                        <div class="p-6">
                            <h3 class="text-lg font-semibold mb-2 group-hover:text-primary transition-colors">{{ $restaurant->name }}</h3>
                            <p class="text-gray-400 mb-4">{{ Str::limit($restaurant->description, 100) }}</p>

                            <div class="flex items-center justify-between">
                                <div class="flex items-center space-x-2">
                                    <span class="text-sm text-gray-400">
                                        <i class="fas fa-map-marker-alt mr-1"></i>
                                        {{ $restaurant->city }}
                                    </span>
                                    <span class="text-gray-500">•</span>
                                    <span class="text-sm text-gray-400">
                                        <i class="fas fa-utensils mr-1"></i>
                                        {{ $restaurant->category->name }}
                                    </span>
                                </div>
                                <span class="text-primary group-hover:underline">
                                    Ver detalhes
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
                            <p class="text-gray-400">Nenhum restaurante encontrado nesta cozinha.</p>
                            @if(request('search') || request('category'))
                                <p class="text-sm text-gray-500 mt-2">
                                    Tente ajustar os filtros ou <a href="{{ route('cuisines.show', $cuisine) }}" class="text-primary hover:underline">limpar a busca</a>.
                                </p>
                            @endif
                        </div>
                    </div>
                </div>
            @endforelse
        </div>

        <!-- Paginação -->
        @if($restaurants->hasPages())
            <div class="mt-6">
                {{ $restaurants->links() }}
            </div>
        @endif
    </div>
@endsection
