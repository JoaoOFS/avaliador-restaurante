@extends('layouts.app')

@section('content')
<div class="min-h-screen py-8">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Cabeçalho -->
        <div class="text-center mb-8">
            <h1 class="text-3xl font-bold text-light mb-2">Detalhes da Avaliação</h1>
            <p class="text-gray-400">Veja todos os detalhes desta avaliação</p>
        </div>

        <!-- Avaliação -->
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

        <!-- Comentários -->
        <div class="card hover-3d animate-on-scroll mt-8">
            <h2 class="text-xl font-semibold mb-6 text-light">Comentários</h2>

            <div class="space-y-6">
                @forelse($review->comments as $comment)
                    <div class="border-b border-card-border pb-6 last:border-0 last:pb-0">
                        <div class="flex items-start justify-between mb-4">
                            <div>
                                <h3 class="font-semibold text-light">{{ $comment->user->name }}</h3>
                                <div class="flex items-center text-sm text-gray-400">
                                    <span>{{ $comment->created_at->format('d/m/Y') }}</span>
                                </div>
                            </div>

                            <div class="flex items-center gap-2">
                                <button class="btn-secondary hover-lift px-4 py-2 rounded-lg">
                                    <i class="fas fa-thumbs-up mr-2"></i>
                                    <span>{{ $comment->helpful_count }}</span>
                                </button>
                            </div>
                        </div>
                        <p class="text-gray-400">{{ $comment->content }}</p>
                    </div>
                @empty
                    <div class="text-center py-8">
                        <i class="fas fa-comments text-4xl text-gray-600 mb-4"></i>
                        <p class="text-gray-400">Nenhum comentário ainda. Seja o primeiro a comentar!</p>
                    </div>
                @endforelse
            </div>

            <!-- Formulário de Comentário -->
            @auth
                <form action="{{ route('reviews.comments.store', $review) }}" method="POST" class="mt-6">
                    @csrf
                    <div class="mb-4">
                        <label for="content" class="block text-sm font-medium text-gray-400 mb-2">Seu Comentário</label>
                        <textarea name="content"
                                  id="content"
                                  rows="3"
                                  class="w-full px-4 py-2 rounded-lg bg-input-bg border border-card-border text-light focus:ring-2 focus:ring-primary focus:border-primary transition-all duration-200"
                                  required></textarea>
                        @error('content')
                            <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="flex justify-end">
                        <button type="submit" class="btn-primary hover-glow hover-lift px-6 py-3 rounded-lg">
                            <i class="fas fa-paper-plane mr-2"></i> Enviar Comentário
                        </button>
                    </div>
                </form>
            @else
                <div class="mt-6 text-center">
                    <p class="text-gray-400 mb-4">Faça login para deixar um comentário</p>
                    <a href="{{ route('login') }}" class="btn-primary hover-glow hover-lift px-6 py-3 rounded-lg">
                        <i class="fas fa-sign-in-alt mr-2"></i> Fazer Login
                    </a>
                </div>
            @endauth
        </div>

        <!-- Botões -->
        <div class="flex justify-end gap-4 mt-8">
            <a href="{{ route('reviews.index') }}"
               class="btn-secondary hover-lift px-6 py-3 rounded-lg">
                <i class="fas fa-arrow-left mr-2"></i> Voltar
            </a>
            @if(auth()->check() && auth()->id() === $review->user_id)
                <a href="{{ route('reviews.edit', $review) }}"
                   class="btn-primary hover-glow hover-lift px-6 py-3 rounded-lg">
                    <i class="fas fa-edit mr-2"></i> Editar
                </a>
                <form action="{{ route('reviews.destroy', $review) }}" method="POST" class="inline">
                    @csrf
                    @method('DELETE')
                    <button type="submit"
                            class="btn-danger hover-glow hover-lift px-6 py-3 rounded-lg"
                            onclick="return confirm('Tem certeza que deseja excluir esta avaliação?')">
                        <i class="fas fa-trash mr-2"></i> Excluir
                    </button>
                </form>
            @endif
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
            title: 'Avaliação de Restaurante',
            text: 'Confira esta avaliação incrível!',
            url: window.location.href
        });
    } catch (err) {
        console.log('Erro ao compartilhar:', err);
    }
});
</script>
@endpush
@endsection
