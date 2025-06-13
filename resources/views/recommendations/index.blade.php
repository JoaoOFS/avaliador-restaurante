@extends('layouts.app')

@section('title', 'Recomendações Personalizadas')

@section('content')
    <!-- Hero Section -->
    <div class="card mb-8">
        <div class="text-center">
            <h1 class="text-3xl font-bold mb-4">Recomendações para Você</h1>
            <p class="text-gray-400 max-w-2xl mx-auto">
                Descubra restaurantes selecionados especialmente para você, baseados em suas preferências e avaliações anteriores.
            </p>
        </div>
    </div>

    <!-- Recomendações Personalizadas -->
    <div class="mb-12">
        <h2 class="text-2xl font-semibold mb-6">Recomendados para Você</h2>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @forelse($recommendations as $restaurant)
                <div class="card group hover-lift">
                    <div class="relative overflow-hidden rounded-lg mb-4">
                        @if($restaurant->photos->isNotEmpty())
                            <img src="{{ $restaurant->photos->first()->url }}"
                                 alt="{{ $restaurant->name }}"
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
                    <div class="flex flex-wrap gap-2 mb-4">
                        @if($restaurant->category)
                            <span class="badge badge-secondary">
                                <i class="{{ $restaurant->category->icon }} mr-1"></i>
                                {{ $restaurant->category->name }}
                            </span>
                        @endif
                        @if($restaurant->cuisine)
                            <span class="badge badge-secondary">
                                <i class="{{ $restaurant->cuisine->icon }} mr-1"></i>
                                {{ $restaurant->cuisine->name }}
                            </span>
                        @endif
                    </div>
                    <div class="flex items-center justify-between">
                        <div class="flex items-center text-sm text-gray-400">
                            <i class="fas fa-map-marker-alt mr-2"></i>
                            {{ $restaurant->city }}, {{ $restaurant->state }}
                        </div>
                        <a href="{{ route('restaurants.show', $restaurant) }}"
                           class="text-primary hover:text-primary-light transition-colors">
                            Ver detalhes <i class="fas fa-arrow-right ml-1"></i>
                        </a>
                    </div>
                </div>
            @empty
                <div class="col-span-3 text-center py-12">
                    <i class="fas fa-utensils text-4xl text-gray-600 mb-4"></i>
                    <p class="text-gray-400">Faça algumas avaliações para receber recomendações personalizadas.</p>
                    <a href="{{ route('restaurants.index') }}" class="btn btn-primary mt-4">
                        <i class="fas fa-search mr-2"></i> Explorar Restaurantes
                    </a>
                </div>
            @endforelse
        </div>
    </div>

    <!-- Restaurantes Populares -->
    <div>
        <h2 class="text-2xl font-semibold mb-6">Restaurantes Populares</h2>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach($popularRestaurants as $restaurant)
                <div class="card group hover-lift">
                    <div class="relative overflow-hidden rounded-lg mb-4">
                        @if($restaurant->photos->isNotEmpty())
                            <img src="{{ $restaurant->photos->first()->url }}"
                                 alt="{{ $restaurant->name }}"
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
                    <div class="flex flex-wrap gap-2 mb-4">
                        @if($restaurant->category)
                            <span class="badge badge-secondary">
                                <i class="{{ $restaurant->category->icon }} mr-1"></i>
                                {{ $restaurant->category->name }}
                            </span>
                        @endif
                        @if($restaurant->cuisine)
                            <span class="badge badge-secondary">
                                <i class="{{ $restaurant->cuisine->icon }} mr-1"></i>
                                {{ $restaurant->cuisine->name }}
                            </span>
                        @endif
                    </div>
                    <div class="flex items-center justify-between">
                        <div class="flex items-center text-sm text-gray-400">
                            <i class="fas fa-map-marker-alt mr-2"></i>
                            {{ $restaurant->city }}, {{ $restaurant->state }}
                        </div>
                        <a href="{{ route('restaurants.show', $restaurant) }}"
                           class="text-primary hover:text-primary-light transition-colors">
                            Ver detalhes <i class="fas fa-arrow-right ml-1"></i>
                        </a>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
@endsection
