<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-white leading-tight">
                {{ __('Dashboard') }}
            </h2>
            <a href="{{ route('restaurants.create') }}" class="btn-primary">
                <i class="fas fa-plus mr-2"></i> Novo Restaurante
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Estatísticas -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
                <div class="card p-6">
                    <div class="flex items-center">
                        <div class="p-3 rounded-full bg-[#D4AF37]/10 text-[#D4AF37]">
                            <i class="fas fa-utensils text-2xl"></i>
                        </div>
                        <div class="ml-4">
                            <h3 class="text-lg font-semibold text-gray-600">Total de Restaurantes</h3>
                            <p class="text-2xl font-bold text-gray-900">{{ $totalRestaurants ?? 0 }}</p>
                        </div>
                    </div>
                </div>

                <div class="card p-6">
                    <div class="flex items-center">
                        <div class="p-3 rounded-full bg-[#D4AF37]/10 text-[#D4AF37]">
                            <i class="fas fa-star text-2xl"></i>
                        </div>
                        <div class="ml-4">
                            <h3 class="text-lg font-semibold text-gray-600">Total de Avaliações</h3>
                            <p class="text-2xl font-bold text-gray-900">{{ $totalReviews ?? 0 }}</p>
                        </div>
                    </div>
                </div>

                <div class="card p-6">
                    <div class="flex items-center">
                        <div class="p-3 rounded-full bg-[#D4AF37]/10 text-[#D4AF37]">
                            <i class="fas fa-users text-2xl"></i>
                        </div>
                        <div class="ml-4">
                            <h3 class="text-lg font-semibold text-gray-600">Usuários Ativos</h3>
                            <p class="text-2xl font-bold text-gray-900">{{ $activeUsers ?? 0 }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Restaurantes em Destaque -->
            <div class="mb-8">
                <h3 class="text-xl font-bold text-gray-900 mb-4">Restaurantes em Destaque</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    @forelse($featuredRestaurants ?? [] as $restaurant)
                        <div class="card overflow-hidden">
                            <div class="relative h-48">
                                <img src="{{ $restaurant->image_url ?? 'https://via.placeholder.com/400x300' }}"
                                     alt="{{ $restaurant->name }}"
                                     class="w-full h-full object-cover">
                                <div class="absolute top-4 right-4 bg-[#D4AF37] text-white px-3 py-1 rounded-full text-sm font-semibold">
                                    <i class="fas fa-star mr-1"></i> {{ number_format($restaurant->average_rating, 1) }}
                                </div>
                            </div>
                            <div class="p-6">
                                <h4 class="text-xl font-bold text-gray-900 mb-2">{{ $restaurant->name }}</h4>
                                <p class="text-gray-600 mb-4">{{ Str::limit($restaurant->description, 100) }}</p>
                                <div class="flex justify-between items-center">
                                    <span class="text-sm text-gray-500">
                                        <i class="fas fa-map-marker-alt mr-1"></i> {{ $restaurant->location }}
                                    </span>
                                    <a href="{{ route('restaurants.show', $restaurant) }}" class="text-[#D4AF37] hover:text-[#B8860B] font-semibold">
                                        Ver Detalhes <i class="fas fa-arrow-right ml-1"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="col-span-3">
                            <div class="card p-6 text-center">
                                <i class="fas fa-utensils text-4xl text-gray-400 mb-4"></i>
                                <h4 class="text-xl font-semibold text-gray-600 mb-2">Nenhum restaurante cadastrado</h4>
                                <p class="text-gray-500 mb-4">Comece adicionando seu primeiro restaurante!</p>
                                <a href="{{ route('restaurants.create') }}" class="btn-primary inline-block">
                                    <i class="fas fa-plus mr-2"></i> Adicionar Restaurante
                                </a>
                            </div>
                        </div>
                    @endforelse
                </div>
            </div>

            <!-- Últimas Avaliações -->
            <div>
                <h3 class="text-xl font-bold text-gray-900 mb-4">Últimas Avaliações</h3>
                <div class="card overflow-hidden">
                    <div class="divide-y divide-gray-200">
                        @forelse($latestReviews ?? [] as $review)
                            <div class="p-6 hover:bg-gray-50 transition-colors duration-150">
                                <div class="flex items-start">
                                    <div class="flex-shrink-0">
                                        <img src="{{ $review->user->profile_photo_url }}"
                                             alt="{{ $review->user->name }}"
                                             class="h-10 w-10 rounded-full">
                                    </div>
                                    <div class="ml-4 flex-1">
                                        <div class="flex items-center justify-between">
                                            <div>
                                                <h4 class="text-sm font-semibold text-gray-900">{{ $review->user->name }}</h4>
                                                <p class="text-sm text-gray-500">{{ $review->restaurant->name }}</p>
                                            </div>
                                            <div class="flex items-center">
                                                <div class="flex items-center text-[#D4AF37]">
                                                    @for($i = 1; $i <= 5; $i++)
                                                        <i class="fas fa-star {{ $i <= $review->rating ? 'text-[#D4AF37]' : 'text-gray-300' }}"></i>
                                                    @endfor
                                                </div>
                                                <span class="ml-2 text-sm text-gray-500">{{ $review->created_at->diffForHumans() }}</span>
                                            </div>
                                        </div>
                                        <p class="mt-2 text-gray-600">{{ $review->comment }}</p>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <div class="p-6 text-center">
                                <i class="fas fa-star text-4xl text-gray-400 mb-4"></i>
                                <h4 class="text-xl font-semibold text-gray-600 mb-2">Nenhuma avaliação ainda</h4>
                                <p class="text-gray-500">Seja o primeiro a avaliar um restaurante!</p>
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
