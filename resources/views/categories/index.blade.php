@extends('layouts.app')

@section('title', 'Categorias')
@section('header', 'Categorias')
@section('subheader', 'Descubra restaurantes por categoria')

@section('headerAction')
    @can('create', App\Models\Category::class)
        <a href="{{ route('categories.create') }}" class="btn btn-primary">
            <i class="fas fa-plus mr-2"></i> Nova Categoria
        </a>
    @endcan
@endsection

@section('content')
    <div class="max-w-7xl mx-auto">
        <!-- Filtros -->
        <div class="card mb-6">
            <div class="p-6">
                <form action="{{ route('categories.index') }}" method="GET" class="space-y-4">
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        <div>
                            <label for="search" class="block text-sm font-medium text-gray-300 mb-1">Buscar</label>
                            <div class="relative">
                                <input type="text" name="search" id="search" value="{{ request('search') }}"
                                       class="w-full pl-10" placeholder="Nome da categoria...">
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
                                    <option value="average_rating" {{ request('sort') == 'average_rating' ? 'selected' : '' }}>Avaliação Média</option>
                                </select>
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <i class="fas fa-sort text-gray-400"></i>
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
                                    <i class="fas fa-sort-amount-down text-gray-400"></i>
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

        <!-- Lista de Categorias -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @forelse($categories as $category)
                <div class="card group">
                    <a href="{{ route('categories.show', $category) }}" class="block">
                        <div class="p-6">
                            <div class="flex items-center justify-between mb-4">
                                <div class="flex items-center space-x-3">
                                    <div class="w-12 h-12 bg-primary/10 rounded-lg flex items-center justify-center group-hover:bg-primary/20 transition-colors">
                                        <i class="{{ $category->icon }} text-2xl text-primary"></i>
                                    </div>
                                    <h3 class="text-lg font-semibold group-hover:text-primary transition-colors">{{ $category->name }}</h3>
                                </div>
                                <span class="badge">
                                    {{ $category->restaurants_count }} restaurantes
                                </span>
                            </div>

                            <p class="text-gray-400 mb-4">{{ $category->description }}</p>

                            <div class="flex items-center justify-between">
                                <div class="flex items-center">
                                    <div class="rating-stars">
                                        @for($i = 1; $i <= 5; $i++)
                                            <i class="fas fa-star {{ $i <= round($category->restaurants->avg('average_rating')) ? 'text-primary' : 'text-gray-600' }}"></i>
                                        @endfor
                                    </div>
                                    <span class="ml-2 text-sm text-gray-400">
                                        {{ number_format($category->restaurants->avg('average_rating'), 1) }}
                                    </span>
                                </div>
                                <span class="text-primary group-hover:translate-x-1 transition-transform">
                                    Ver restaurantes
                                    <i class="fas fa-arrow-right ml-1"></i>
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
                            <p class="text-gray-400">Nenhuma categoria encontrada.</p>
                            @if(request('search'))
                                <p class="text-sm text-gray-500 mt-2">
                                    Tente ajustar os filtros ou <a href="{{ route('categories.index') }}" class="text-primary hover:underline">limpar a busca</a>.
                                </p>
                            @endif
                        </div>
                    </div>
                </div>
            @endforelse
        </div>

        <!-- Paginação -->
        @if($categories->hasPages())
            <div class="mt-6">
                {{ $categories->links() }}
            </div>
        @endif
    </div>
@endsection
