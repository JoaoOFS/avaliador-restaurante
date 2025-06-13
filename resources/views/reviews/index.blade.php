@extends('layouts.app')

@section('content')
<div class="min-h-screen py-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Cabeçalho -->
        <div class="text-center mb-8">
            <h1 class="text-3xl font-bold text-light mb-2">Avaliações</h1>
            <p class="text-gray-400">Veja o que as pessoas estão dizendo sobre os restaurantes</p>
        </div>

        <!-- Filtros -->
        <div class="bg-surface-color rounded-lg p-6 mb-8 sticky top-0 z-30 shadow-lg">
            <div class="flex flex-col md:flex-row gap-4 items-center justify-between">
                <!-- Barra de Busca -->
                <div class="w-full md:w-96">
                    <form action="{{ route('reviews.index') }}" method="GET" class="relative">
                        <input type="text"
                               name="search"
                               value="{{ request('search') }}"
                               placeholder="Buscar avaliações..."
                               class="w-full pl-10 pr-4 py-2 rounded-lg bg-input-bg border border-card-border text-light focus:ring-2 focus:ring-primary focus:border-primary transition-all duration-200">
                        <i class="fas fa-search absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
                    </form>
                </div>

                <!-- Filtros -->
                <div class="flex flex-wrap gap-4">
                    <select name="rating"
                            class="bg-input-bg border border-card-border text-light rounded-lg px-4 py-2 focus:ring-2 focus:ring-primary focus:border-primary transition-all duration-200">
                        <option value="">Todas as Avaliações</option>
                        <option value="5" {{ request('rating') == '5' ? 'selected' : '' }}>5 estrelas</option>
                        <option value="4" {{ request('rating') == '4' ? 'selected' : '' }}>4 estrelas</option>
                        <option value="3" {{ request('rating') == '3' ? 'selected' : '' }}>3 estrelas</option>
                        <option value="2" {{ request('rating') == '2' ? 'selected' : '' }}>2 estrelas</option>
                        <option value="1" {{ request('rating') == '1' ? 'selected' : '' }}>1 estrela</option>
                    </select>

                    <select name="sort"
                            class="bg-input-bg border border-card-border text-light rounded-lg px-4 py-2 focus:ring-2 focus:ring-primary focus:border-primary transition-all duration-200">
                        <option value="recent" {{ request('sort') == 'recent' ? 'selected' : '' }}>Mais Recentes</option>
                        <option value="rating" {{ request('sort') == 'rating' ? 'selected' : '' }}>Melhor Avaliadas</option>
                        <option value="helpful" {{ request('sort') == 'helpful' ? 'selected' : '' }}>Mais Úteis</option>
                    </select>
                </div>
            </div>
        </div>

        <!-- Lista de Avaliações -->
        <div class="grid grid-cols-1 gap-8">
            @forelse($reviews as $review)
                <div class="card hover-3d animate-on-scroll">
                    <div class="flex flex-col md:flex-row gap-6">
                        <!-- Restaurante -->
                        <div class="md:w-1/3">
                            <a href="{{ route('restaurants.show', $review->restaurant) }}" class="block">
                                <div class="relative aspect-w-16 aspect-h-9 rounded-lg overflow-hidden mb-4">
                                    <img src="{{ $review->restaurant->photo_url }}"
                                         alt="{{ $review->restaurant->name }}"
                                         class="w-full h-full object-cover">
                                </div>
                                <h3 class="text-xl font-semibold text-light mb-2">{{ $review->restaurant->name }}</h3>
                                <div class="flex items-center text-gray-400">
                                    <i class="fas fa-map-marker-alt mr-2"></i>
                                    <span>{{ $review->restaurant->address }}</span>
                                </div>
                            </a>
                        </div>

                        <!-- Avaliação -->
                        <div class="md:w-2/3">
                            <div class="flex items-start justify-between mb-4">
                                <div>
                                    <div class="flex items-center gap-4 mb-2">
                                        <div class="flex items-center">
                                            <i class="fas fa-star text-yellow-400 mr-1"></i>
                                            <span class="font-semibold text-light">{{ number_format($review->rating, 1) }}</span>
                                        </div>
                                        <span class="text-gray-400">{{ $review->created_at->format('d/m/Y') }}</span>
                                    </div>
                                    <h4 class="text-lg font-semibold text-light">{{ $review->user->name }}</h4>
                                </div>

                                <div class="flex items-center gap-2">
                                    <button class="btn-secondary hover-lift px-4 py-2 rounded-lg">
                                        <i class="fas fa-thumbs-up mr-2"></i>
                                        <span>{{ $review->helpful_count }}</span>
                                    </button>
                                    <button class="btn-secondary hover-lift px-4 py-2 rounded-lg">
                                        <i class="fas fa-share-alt"></i>
                                    </button>
                                </div>
                            </div>

                            <div class="space-y-4">
                                <!-- Comentário -->
                                <p class="text-gray-400">{{ $review->comment }}</p>

                                <!-- Fotos -->
                                @if($review->photos->isNotEmpty())
                                    <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                                        @foreach($review->photos as $photo)
                                            <div class="relative group">
                                                <img src="{{ $photo->url }}"
                                                     alt="Foto da avaliação"
                                                     class="w-full h-24 object-cover rounded-lg cursor-pointer hover:scale-110 transition-transform">
                                                <div class="absolute inset-0 bg-black bg-opacity-0 group-hover:bg-opacity-20 transition-opacity rounded-lg"></div>
                                            </div>
                                        @endforeach
                                    </div>
                                @endif

                                <!-- Avaliações Específicas -->
                                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                                    <div class="flex items-center justify-between p-4 rounded-lg bg-input-bg">
                                        <span class="text-gray-400">Comida</span>
                                        <div class="flex text-yellow-400">
                                            @for($i = 1; $i <= 5; $i++)
                                                <i class="fas fa-star {{ $i <= $review->food_rating ? 'text-yellow-400' : 'text-gray-600' }}"></i>
                                            @endfor
                                        </div>
                                    </div>
                                    <div class="flex items-center justify-between p-4 rounded-lg bg-input-bg">
                                        <span class="text-gray-400">Serviço</span>
                                        <div class="flex text-yellow-400">
                                            @for($i = 1; $i <= 5; $i++)
                                                <i class="fas fa-star {{ $i <= $review->service_rating ? 'text-yellow-400' : 'text-gray-600' }}"></i>
                                            @endfor
                                        </div>
                                    </div>
                                    <div class="flex items-center justify-between p-4 rounded-lg bg-input-bg">
                                        <span class="text-gray-400">Ambiente</span>
                                        <div class="flex text-yellow-400">
                                            @for($i = 1; $i <= 5; $i++)
                                                <i class="fas fa-star {{ $i <= $review->ambiance_rating ? 'text-yellow-400' : 'text-gray-600' }}"></i>
                                            @endfor
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <div class="text-center py-12">
                    <div class="text-6xl mb-4 text-gray-400">
                        <i class="fas fa-comments"></i>
                    </div>
                    <h3 class="text-2xl font-semibold text-light mb-2">Nenhuma avaliação encontrada</h3>
                    <p class="text-gray-400 mb-6">Tente ajustar seus filtros ou adicione uma nova avaliação.</p>
                    <a href="{{ route('reviews.create') }}" class="btn-primary hover-glow hover-lift px-6 py-3 rounded-lg">
                        <i class="fas fa-plus mr-2"></i> Adicionar Avaliação
                    </a>
                </div>
            @endforelse
        </div>

        <!-- Paginação -->
        @if($reviews->hasPages())
            <div class="mt-8">
                {{ $reviews->links() }}
            </div>
        @endif
    </div>
</div>

@push('scripts')
<script>
// Atualiza a URL quando os filtros mudam
document.querySelectorAll('select[name]').forEach(select => {
    select.addEventListener('change', () => {
        const form = document.createElement('form');
        form.method = 'GET';
        form.action = '{{ route('reviews.index') }}';

        // Adiciona todos os selects ao form
        document.querySelectorAll('select[name]').forEach(s => {
            if (s.value) {
                const input = document.createElement('input');
                input.type = 'hidden';
                input.name = s.name;
                input.value = s.value;
                form.appendChild(input);
            }
        });

        // Adiciona o termo de busca se existir
        const searchInput = document.querySelector('input[name="search"]');
        if (searchInput.value) {
            const input = document.createElement('input');
            input.type = 'hidden';
            input.name = 'search';
            input.value = searchInput.value;
            form.appendChild(input);
        }

        document.body.appendChild(form);
        form.submit();
    });
});

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
document.querySelectorAll('.btn-secondary').forEach(button => {
    if (button.querySelector('.fa-share-alt')) {
        button.addEventListener('click', async () => {
            try {
                await navigator.share({
                    title: 'Avaliação de Restaurante',
                    text: 'Confira esta avaliação incrível!',
                    url: window.location.href
                });
            } catch (err) {
                console.log('Erro ao compartilhar:', err);
            }
        });
    }
});
</script>
@endpush
@endsection
