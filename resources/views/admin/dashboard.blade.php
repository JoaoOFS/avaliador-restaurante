@extends('layouts.app')

@section('title', 'Painel Administrativo')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-8">
        <!-- Card de Restaurantes -->
        <div class="card">
            <div class="flex items-center justify-between">
                <div>
                    <h3 class="text-lg font-semibold mb-2">Total de Restaurantes</h3>
                    <p class="text-3xl font-bold text-primary">{{ $totalRestaurants }}</p>
                </div>
                <div class="p-3 bg-primary/10 rounded-full">
                    <i class="fas fa-utensils text-2xl text-primary"></i>
                </div>
            </div>
        </div>

        <!-- Card de Avaliações -->
        <div class="card">
            <div class="flex items-center justify-between">
                <div>
                    <h3 class="text-lg font-semibold mb-2">Total de Avaliações</h3>
                    <p class="text-3xl font-bold text-primary">{{ $totalReviews }}</p>
                </div>
                <div class="p-3 bg-primary/10 rounded-full">
                    <i class="fas fa-star text-2xl text-primary"></i>
                </div>
            </div>
        </div>

        <!-- Card de Usuários -->
        <div class="card">
            <div class="flex items-center justify-between">
                <div>
                    <h3 class="text-lg font-semibold mb-2">Total de Usuários</h3>
                    <p class="text-3xl font-bold text-primary">{{ $totalUsers }}</p>
                </div>
                <div class="p-3 bg-primary/10 rounded-full">
                    <i class="fas fa-users text-2xl text-primary"></i>
                </div>
            </div>
        </div>

        <!-- Card de Categorias -->
        <div class="card">
            <div class="flex items-center justify-between">
                <div>
                    <h3 class="text-lg font-semibold mb-2">Total de Categorias</h3>
                    <p class="text-3xl font-bold text-primary">{{ $totalCategories }}</p>
                </div>
                <div class="p-3 bg-primary/10 rounded-full">
                    <i class="fas fa-tags text-2xl text-primary"></i>
                </div>
            </div>
        </div>

        <!-- Card de Culinárias -->
        <div class="card">
            <div class="flex items-center justify-between">
                <div>
                    <h3 class="text-lg font-semibold mb-2">Total de Culinárias</h3>
                    <p class="text-3xl font-bold text-primary">{{ $totalCuisines }}</p>
                </div>
                <div class="p-3 bg-primary/10 rounded-full">
                    <i class="fas fa-globe text-2xl text-primary"></i>
                </div>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
        <!-- Últimos Restaurantes -->
        <div class="card">
            <h3 class="text-xl font-semibold mb-4">Últimos Restaurantes</h3>
            <div class="space-y-4">
                @foreach($recentRestaurants as $restaurant)
                <div class="flex items-center justify-between p-4 bg-surface rounded-lg">
                    <div>
                        <h4 class="font-medium">{{ $restaurant->name }}</h4>
                        <p class="text-sm text-muted">{{ $restaurant->category->name }} • {{ $restaurant->cuisine->name }}</p>
                    </div>
                    <a href="{{ route('restaurants.show', $restaurant) }}" class="btn btn-secondary btn-sm">
                        <i class="fas fa-eye"></i>
                    </a>
                </div>
                @endforeach
            </div>
        </div>

        <!-- Últimas Avaliações -->
        <div class="card">
            <h3 class="text-xl font-semibold mb-4">Últimas Avaliações</h3>
            <div class="space-y-4">
                @foreach($recentReviews as $review)
                <div class="flex items-center justify-between p-4 bg-surface rounded-lg">
                    <div>
                        <h4 class="font-medium">{{ $review->restaurant->name }}</h4>
                        <p class="text-sm text-muted">
                            {{ $review->user->name }} • {{ $review->rating }} estrelas
                        </p>
                    </div>
                    <a href="{{ route('restaurants.reviews.show', [$review->restaurant, $review]) }}" class="btn btn-secondary btn-sm">
                        <i class="fas fa-eye"></i>
                    </a>
                </div>
                @endforeach
            </div>
        </div>
    </div>
</div>
@endsection
