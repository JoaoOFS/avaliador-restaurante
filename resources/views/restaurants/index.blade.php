@extends('layouts.app')

@section('title', 'Restaurantes')

@section('header', 'Restaurantes')
@section('subheader', 'Descubra os melhores restaurantes da sua cidade')

@section('content')
<div class="min-h-screen">
    <!-- Filtros e Busca -->
    <div class="bg-surface-color py-6 sticky top-0 z-30 shadow-lg">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex flex-col md:flex-row gap-4 items-center justify-between">
                <!-- Barra de Busca -->
                <div class="w-full md:w-96">
                    <form action="{{ route('restaurants.index') }}" method="GET" class="relative">
                        <input type="text"
                               name="search"
                               value="{{ request('search') }}"
                               placeholder="Buscar restaurantes..."
                               class="w-full pl-10 pr-4 py-2 rounded-lg bg-input-bg border border-card-border text-light focus:ring-2 focus:ring-primary focus:border-primary transition-all duration-200">
                        <i class="fas fa-search absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
                    </form>
                </div>

                <!-- Filtros -->
                <div class="flex flex-wrap gap-4">
                    <select name="category"
                            class="bg-input-bg border border-card-border text-light rounded-lg px-4 py-2 focus:ring-2 focus:ring-primary focus:border-primary transition-all duration-200">
                        <option value="">Todas as Categorias</option>
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}" {{ request('category') == $category->id ? 'selected' : '' }}>
                                {{ $category->name }}
                            </option>
                        @endforeach
                    </select>

                    <select name="cuisine"
                            class="bg-input-bg border border-card-border text-light rounded-lg px-4 py-2 focus:ring-2 focus:ring-primary focus:border-primary transition-all duration-200">
                        <option value="">Todas as Cozinhas</option>
                        @foreach($cuisines as $cuisine)
                            <option value="{{ $cuisine->id }}" {{ request('cuisine') == $cuisine->id ? 'selected' : '' }}>
                                {{ $cuisine->name }}
                            </option>
                        @endforeach
                    </select>

                    <select name="sort"
                            class="bg-input-bg border border-card-border text-light rounded-lg px-4 py-2 focus:ring-2 focus:ring-primary focus:border-primary transition-all duration-200">
                        <option value="rating" {{ request('sort') == 'rating' ? 'selected' : '' }}>Mais Avaliados</option>
                        <option value="recent" {{ request('sort') == 'recent' ? 'selected' : '' }}>Mais Recentes</option>
                        <option value="name" {{ request('sort') == 'name' ? 'selected' : '' }}>Nome A-Z</option>
                    </select>
                </div>
            </div>
        </div>
    </div>

    <!-- Lista de Restaurantes -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            @forelse($restaurants as $restaurant)
                <div class="card hover-3d animate-on-scroll">
                    <div class="relative overflow-hidden rounded-lg mb-4">
                        <img src="{{ $restaurant->photo_url }}"
                             alt="{{ $restaurant->name }}"
                             class="w-full h-48 object-cover transition-transform duration-300 hover:scale-110">

                        <!-- Badges -->
                        <div class="absolute top-4 right-4 flex flex-col gap-2">
                            <span class="badge badge-animated">
                                <i class="fas fa-star mr-1"></i> {{ number_format($restaurant->average_rating, 1) }}
                            </span>
                            @if($restaurant->is_featured)
                                <span class="badge bg-accent-color">
                                    <i class="fas fa-crown mr-1"></i> Destaque
                                </span>
                            @endif
                        </div>

                        <!-- Categorias -->
                        <div class="absolute bottom-4 left-4 flex flex-wrap gap-2">
                            @foreach($restaurant->categories as $category)
                                <span class="badge bg-primary-color bg-opacity-20 text-primary-color">
                                    {{ $category->name }}
                                </span>
                            @endforeach
                        </div>
                    </div>

                    <div class="p-4">
                        <h3 class="text-xl font-semibold mb-2 text-light">{{ $restaurant->name }}</h3>
                        <p class="text-gray-400 mb-4">{{ Str::limit($restaurant->description, 100) }}</p>

                        <div class="flex items-center justify-between">
                            <div class="flex items-center text-gray-400">
                                <i class="fas fa-map-marker-alt mr-2"></i>
                                <span>{{ Str::limit($restaurant->address, 30) }}</span>
                            </div>
                            <a href="{{ route('restaurants.show', $restaurant) }}"
                               class="btn-secondary hover-lift px-4 py-2 rounded-lg">
                                Ver Detalhes
                            </a>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-span-full text-center py-12">
                    <div class="text-6xl mb-4 text-gray-400">
                        <i class="fas fa-utensils"></i>
                    </div>
                    <h3 class="text-2xl font-semibold text-light mb-2">Nenhum restaurante encontrado</h3>
                    <p class="text-gray-400 mb-6">Tente ajustar seus filtros ou adicione um novo restaurante.</p>
                    <a href="{{ route('restaurants.create') }}" class="btn-primary hover-glow hover-lift px-6 py-3 rounded-lg">
                        <i class="fas fa-plus mr-2"></i> Adicionar Restaurante
                    </a>
                </div>
            @endforelse
        </div>

        <!-- Paginação -->
        @if($restaurants->hasPages())
            <div class="mt-8">
                {{ $restaurants->links() }}
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
        form.action = '{{ route('restaurants.index') }}';

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
</script>
@endpush
@endsection
