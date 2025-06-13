@extends('layouts.app')

@section('title', $restaurant->name)

@section('content')
<div class="min-h-screen">
    <!-- Hero Section -->
    <div class="relative h-[400px] overflow-hidden">
        <div class="absolute inset-0">
            <img src="{{ $restaurant->photo_url }}"
                 alt="{{ $restaurant->name }}"
                 class="w-full h-full object-cover">
            <div class="absolute inset-0 bg-gradient-to-t from-background-color to-transparent"></div>
        </div>

        <div class="relative h-full flex items-end">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 w-full pb-8">
                <div class="flex flex-col md:flex-row items-end justify-between gap-4">
                    <div>
                        <h1 class="text-4xl font-bold text-light mb-2">{{ $restaurant->name }}</h1>
                        <div class="flex items-center gap-4 text-light">
                            <div class="flex items-center">
                                <i class="fas fa-star text-yellow-400 mr-1"></i>
                                <span class="font-semibold">{{ number_format($restaurant->average_rating, 1) }}</span>
                                <span class="text-gray-300 ml-1">({{ $restaurant->reviews_count }} avaliações)</span>
                            </div>
                            <div class="flex items-center">
                                <i class="fas fa-map-marker-alt text-gray-300 mr-1"></i>
                                <span>{{ $restaurant->address }}</span>
                            </div>
                        </div>
                    </div>

                    <div class="flex gap-4">
                        <button class="btn-secondary hover-lift px-6 py-3 rounded-lg">
                            <i class="fas fa-share-alt mr-2"></i> Compartilhar
                        </button>
                        <button class="btn-primary hover-glow hover-lift px-6 py-3 rounded-lg">
                            <i class="fas fa-utensils mr-2"></i> Avaliar
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Conteúdo Principal -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Coluna Principal -->
            <div class="lg:col-span-2 space-y-8">
                <!-- Sobre -->
                <div class="card hover-3d animate-on-scroll">
                    <h2 class="text-2xl font-semibold mb-4 text-light">Sobre</h2>
                    <p class="text-gray-400">{{ $restaurant->description }}</p>

                    <div class="mt-6 grid grid-cols-2 gap-4">
                        <div class="flex items-center text-gray-400">
                            <i class="fas fa-clock w-6"></i>
                            <span class="ml-2">{{ $restaurant->opening_hours }}</span>
                        </div>
                        <div class="flex items-center text-gray-400">
                            <i class="fas fa-phone w-6"></i>
                            <span class="ml-2">{{ $restaurant->phone }}</span>
                        </div>
                        <div class="flex items-center text-gray-400">
                            <i class="fas fa-globe w-6"></i>
                            <a href="{{ $restaurant->website }}" target="_blank" class="ml-2 hover:text-primary transition-colors">
                                {{ $restaurant->website }}
                            </a>
                        </div>
                        <div class="flex items-center text-gray-400">
                            <i class="fas fa-dollar-sign w-6"></i>
                            <span class="ml-2">{{ str_repeat('$', $restaurant->price_range) }}</span>
                        </div>
                    </div>
                </div>

                <!-- Avaliações -->
                <div class="card hover-3d animate-on-scroll">
                    <div class="flex items-center justify-between mb-6">
                        <h2 class="text-2xl font-semibold text-light">Avaliações</h2>
                        <div class="flex items-center gap-2">
                            <span class="text-3xl font-bold text-light">{{ number_format($restaurant->average_rating, 1) }}</span>
                            <div class="flex flex-col">
                                <div class="flex text-yellow-400">
                                    @for($i = 1; $i <= 5; $i++)
                                        <i class="fas fa-star {{ $i <= round($restaurant->average_rating) ? 'text-yellow-400' : 'text-gray-600' }}"></i>
                                    @endfor
                                </div>
                                <span class="text-sm text-gray-400">{{ $restaurant->reviews_count }} avaliações</span>
                            </div>
                        </div>
                    </div>

                    <div class="space-y-6">
                        @forelse($restaurant->reviews as $review)
                            <div class="border-b border-card-border pb-6 last:border-0 last:pb-0">
                                <div class="flex items-start justify-between mb-4">
                                    <div>
                                        <h3 class="font-semibold text-light">{{ $review->user->name }}</h3>
                                        <div class="flex items-center text-sm text-gray-400">
                                            <span>{{ $review->created_at->format('d/m/Y') }}</span>
                                            <span class="mx-2">•</span>
                                            <div class="flex text-yellow-400">
                                                @for($i = 1; $i <= 5; $i++)
                                                    <i class="fas fa-star {{ $i <= $review->rating ? 'text-yellow-400' : 'text-gray-600' }}"></i>
                                                @endfor
                                            </div>
                                        </div>
                                    </div>
                                    @if($review->photos->isNotEmpty())
                                        <div class="flex gap-2">
                                            @foreach($review->photos->take(3) as $photo)
                                                <img src="{{ $photo->url }}"
                                                     alt="Foto da avaliação"
                                                     class="w-12 h-12 object-cover rounded-lg cursor-pointer hover:scale-110 transition-transform">
                                            @endforeach
                                        </div>
                                    @endif
                                </div>
                                <p class="text-gray-400">{{ $review->comment }}</p>
                            </div>
                        @empty
                            <div class="text-center py-8">
                                <i class="fas fa-comments text-4xl text-gray-600 mb-4"></i>
                                <p class="text-gray-400">Nenhuma avaliação ainda. Seja o primeiro a avaliar!</p>
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>

            <!-- Sidebar -->
            <div class="space-y-8">
                <!-- Categorias -->
                <div class="card hover-3d animate-on-scroll">
                    <h2 class="text-xl font-semibold mb-4 text-light">Categorias</h2>
                    <div class="flex flex-wrap gap-2">
                        @foreach($restaurant->categories as $category)
                            <span class="badge bg-primary-color bg-opacity-20 text-primary-color">
                                {{ $category->name }}
                            </span>
                        @endforeach
                    </div>
                </div>

                <!-- Mapa -->
                <div class="card hover-3d animate-on-scroll">
                    <h2 class="text-xl font-semibold mb-4 text-light">Localização</h2>
                    <div class="aspect-w-16 aspect-h-9 rounded-lg overflow-hidden">
                        <iframe
                            src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3657.1975844550987!2d-46.6521909!3d-23.5636399!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x0%3A0x0!2zMjPCsDMzJzQ5LjEiUyA0NsKwMzknMDcuOSJX!5e0!3m2!1spt-BR!2sbr!4v1625761234567!5m2!1spt-BR!2sbr"
                            width="100%"
                            height="100%"
                            style="border:0;"
                            allowfullscreen=""
                            loading="lazy">
                        </iframe>
                    </div>
                </div>

                <!-- Horário de Funcionamento -->
                <div class="card hover-3d animate-on-scroll">
                    <h2 class="text-xl font-semibold mb-4 text-light">Horário de Funcionamento</h2>
                    <div class="space-y-2">
                        @foreach($restaurant->opening_hours as $day => $hours)
                            <div class="flex justify-between items-center">
                                <span class="text-gray-400">{{ $day }}</span>
                                <span class="text-light">{{ $hours }}</span>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
// Animação de hover nos cards
document.querySelectorAll('.card').forEach(card => {
    card.addEventListener('mousemove', (e) => {
        const rect = card.getBoundingClientRect();
        const x = e.clientX - rect.left;
        const y = e.clientY - rect.top;

        const centerX = rect.width / 2;
        const centerY = rect.height / 2;

        const rotateX = (y - centerY) / 20;
        const rotateY = (centerX - x) / 20;

        card.style.transform = `perspective(1000px) rotateX(${rotateX}deg) rotateY(${rotateY}deg)`;
    });

    card.addEventListener('mouseleave', () => {
        card.style.transform = 'perspective(1000px) rotateX(0) rotateY(0)';
    });
});

// Compartilhar
document.querySelector('.btn-secondary').addEventListener('click', async () => {
    try {
        await navigator.share({
            title: '{{ $restaurant->name }}',
            text: 'Confira este restaurante incrível!',
            url: window.location.href
        });
    } catch (err) {
        console.log('Erro ao compartilhar:', err);
    }
});
</script>
@endpush
@endsection
