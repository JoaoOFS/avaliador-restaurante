@extends('layouts.app')

@section('title', 'Início')

@section('content')
    <!-- Hero Section -->
    <div class="cta-section relative overflow-hidden rounded-2xl mb-12">
        <div class="absolute inset-0 bg-gradient-to-r from-primary-dark to-accent-dark opacity-90"></div>
        <div class="relative z-10 py-16 px-4 sm:px-6 lg:px-8">
            <div class="max-w-3xl mx-auto text-center">
                <h1 class="text-4xl sm:text-5xl font-bold text-white mb-6">
                    Descubra os Melhores Restaurantes
                </h1>
                <p class="text-xl text-gray-200 mb-8">
                    Explore avaliações autênticas, compartilhe suas experiências e encontre os melhores lugares para comer.
                </p>
                <div class="flex flex-col sm:flex-row gap-4 justify-center">
                    <a href="{{ route('restaurants.index') }}" class="btn btn-primary">
                        <i class="fas fa-utensils mr-2"></i> Explorar Restaurantes
                    </a>
                    <a href="{{ route('restaurants.create') }}" class="btn btn-secondary">
                        <i class="fas fa-plus mr-2"></i> Adicionar Restaurante
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Features Section -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-8 mb-12">
        <div class="card text-center">
            <i class="fas fa-star text-4xl text-primary mb-4"></i>
            <h3 class="text-xl font-semibold mb-2">Avaliações Autênticas</h3>
            <p class="text-gray-400">Leia e compartilhe experiências reais com outros amantes da gastronomia.</p>
        </div>
        <div class="card text-center">
            <i class="fas fa-map-marker-alt text-4xl text-primary mb-4"></i>
            <h3 class="text-xl font-semibold mb-2">Encontre Fácil</h3>
            <p class="text-gray-400">Localize os melhores restaurantes próximos a você com nosso sistema de busca.</p>
        </div>
        <div class="card text-center">
            <i class="fas fa-users text-4xl text-primary mb-4"></i>
            <h3 class="text-xl font-semibold mb-2">Comunidade Ativa</h3>
            <p class="text-gray-400">Faça parte de uma comunidade apaixonada por boa comida e experiências.</p>
        </div>
    </div>

    <!-- Recent Restaurants -->
    <div class="mb-12">
        <div class="flex justify-between items-center mb-6">
            <h2 class="text-2xl font-bold">Restaurantes Recentes</h2>
            <a href="{{ route('restaurants.index') }}" class="text-primary hover:text-primary-light transition-colors">
                Ver todos <i class="fas fa-arrow-right ml-1"></i>
            </a>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @forelse($recentRestaurants as $restaurant)
                <div class="card group">
                    <div class="relative overflow-hidden rounded-lg mb-4">
                        @if($restaurant->photos->isNotEmpty())
                            <img src="{{ $restaurant->photos->first()->url }}" alt="{{ $restaurant->name }}"
                                 class="w-full h-48 object-cover transform group-hover:scale-105 transition-transform duration-300">
                        @else
                            <div class="w-full h-48 bg-gray-800 flex items-center justify-center">
                                <i class="fas fa-utensils text-4xl text-gray-600"></i>
                            </div>
                        @endif
                        <div class="absolute top-2 right-2">
                            <span class="badge">
                                <i class="fas fa-star mr-1"></i> {{ number_format($restaurant->average_rating ?? 0, 1) }}
                            </span>
                        </div>
                    </div>
                    <h3 class="text-xl font-semibold mb-2">{{ $restaurant->name }}</h3>
                    <p class="text-gray-400 mb-4 line-clamp-2">{{ $restaurant->description }}</p>
                    <div class="flex items-center justify-between">
                        <div class="flex items-center text-sm text-gray-400">
                            <i class="fas fa-map-marker-alt mr-2"></i>
                            {{ $restaurant->city }}, {{ $restaurant->state }}
                        </div>
                        <a href="{{ route('restaurants.show', $restaurant) }}" class="text-primary hover:text-primary-light transition-colors">
                            Ver detalhes <i class="fas fa-arrow-right ml-1"></i>
                        </a>
                    </div>
                </div>
            @empty
                <div class="col-span-3 text-center py-12">
                    <i class="fas fa-utensils text-4xl text-gray-600 mb-4"></i>
                    <p class="text-gray-400">Nenhum restaurante cadastrado ainda.</p>
                    <a href="{{ route('restaurants.create') }}" class="btn btn-primary mt-4">
                        <i class="fas fa-plus mr-2"></i> Adicionar Restaurante
                    </a>
                </div>
            @endforelse
        </div>
    </div>

    <!-- Categories Section -->
    <div class="mb-12">
        <div class="flex justify-between items-center mb-6">
            <h2 class="text-2xl font-bold">Categorias Populares</h2>
            <a href="{{ route('categories.index') }}" class="text-primary hover:text-primary-light transition-colors">
                Ver todas <i class="fas fa-arrow-right ml-1"></i>
            </a>
        </div>
        <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
            @forelse($popularCategories as $category)
                <a href="{{ route('categories.show', $category) }}" class="card group text-center hover:bg-primary-dark transition-colors">
                    <i class="{{ $category->icon }} text-3xl mb-3 text-primary group-hover:text-white transition-colors"></i>
                    <h3 class="font-semibold group-hover:text-white transition-colors">{{ $category->name }}</h3>
                    <p class="text-sm text-gray-400">{{ $category->restaurants_count }} restaurantes</p>
                </a>
            @empty
                <div class="col-span-4 text-center py-12">
                    <i class="fas fa-tags text-4xl text-gray-600 mb-4"></i>
                    <p class="text-gray-400">Nenhuma categoria cadastrada ainda.</p>
                </div>
            @endforelse
        </div>
    </div>

    <!-- Newsletter Section -->
    <div class="cta-section relative overflow-hidden rounded-2xl">
        <div class="absolute inset-0 bg-gradient-to-r from-primary-dark to-accent-dark opacity-90"></div>
        <div class="relative z-10 py-12 px-4 sm:px-6 lg:px-8">
            <div class="max-w-2xl mx-auto text-center">
                <h2 class="text-3xl font-bold text-white mb-4">
                    Receba as Melhores Recomendações
                </h2>
                <p class="text-gray-200 mb-6">
                    Inscreva-se em nossa newsletter para receber as melhores dicas e novidades sobre restaurantes.
                </p>
                <form class="flex flex-col sm:flex-row gap-4 max-w-md mx-auto">
                    <input type="email" placeholder="Seu melhor e-mail" class="input flex-1" required>
                    <button type="submit" class="btn btn-primary whitespace-nowrap">
                        <i class="fas fa-paper-plane mr-2"></i> Inscrever-se
                    </button>
                </form>
            </div>
        </div>
    </div>
@endsection
