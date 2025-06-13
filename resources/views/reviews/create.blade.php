@extends('layouts.app')

@section('header', 'Nova Avaliação')
@section('subheader', $restaurant->name)

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="max-w-2xl mx-auto">
        <h1 class="text-3xl font-bold mb-8 gradient-text animate-fade-in-down">Avaliar Restaurante</h1>

        <form action="{{ route('restaurants.reviews.store', $restaurant) }}" method="POST" enctype="multipart/form-data" class="space-y-6">
            @csrf

            <!-- Avaliação da Comida -->
            <div class="card hover-3d p-6 animate-on-scroll">
                <h2 class="text-xl font-semibold mb-4 text-light">Avaliação da Comida</h2>
                <div class="flex items-center space-x-2">
                    @for ($i = 1; $i <= 5; $i++)
                        <button type="button"
                                class="star-button text-2xl transition-all duration-300 transform hover:scale-110 {{ old('food_rating', 0) >= $i ? 'text-yellow-400' : 'text-gray-400' }}"
                                data-rating="{{ $i }}"
                                data-category="food">
                            ★
                        </button>
                    @endfor
                </div>
                <input type="hidden" name="food_rating" id="food_rating" value="{{ old('food_rating', 0) }}">
            </div>

            <!-- Avaliação do Serviço -->
            <div class="card hover-3d p-6 animate-on-scroll" style="animation-delay: 0.2s">
                <h2 class="text-xl font-semibold mb-4 text-light">Avaliação do Serviço</h2>
                <div class="flex items-center space-x-2">
                    @for ($i = 1; $i <= 5; $i++)
                        <button type="button"
                                class="star-button text-2xl transition-all duration-300 transform hover:scale-110 {{ old('service_rating', 0) >= $i ? 'text-yellow-400' : 'text-gray-400' }}"
                                data-rating="{{ $i }}"
                                data-category="service">
                            ★
                        </button>
                    @endfor
                </div>
                <input type="hidden" name="service_rating" id="service_rating" value="{{ old('service_rating', 0) }}">
            </div>

            <!-- Avaliação do Ambiente -->
            <div class="card hover-3d p-6 animate-on-scroll" style="animation-delay: 0.4s">
                <h2 class="text-xl font-semibold mb-4 text-light">Avaliação do Ambiente</h2>
                <div class="flex items-center space-x-2">
                    @for ($i = 1; $i <= 5; $i++)
                        <button type="button"
                                class="star-button text-2xl transition-all duration-300 transform hover:scale-110 {{ old('ambiance_rating', 0) >= $i ? 'text-yellow-400' : 'text-gray-400' }}"
                                data-rating="{{ $i }}"
                                data-category="ambiance">
                            ★
                        </button>
                    @endfor
                </div>
                <input type="hidden" name="ambiance_rating" id="ambiance_rating" value="{{ old('ambiance_rating', 0) }}">
            </div>

            <!-- Comentário -->
            <div class="card hover-3d p-6 animate-on-scroll" style="animation-delay: 0.6s">
                <h2 class="text-xl font-semibold mb-4 text-light">Seu Comentário</h2>
                <textarea name="comment"
                          class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-primary focus:border-primary transition-all duration-200 bg-input-bg text-light"
                          rows="4"
                          placeholder="Conte-nos sobre sua experiência...">{{ old('comment') }}</textarea>
            </div>

            <!-- Upload de Fotos -->
            <div class="card hover-3d p-6 animate-on-scroll" style="animation-delay: 0.8s">
                <h2 class="text-xl font-semibold mb-4 text-light">Fotos (opcional)</h2>
                <div class="space-y-4">
                    <div class="flex items-center justify-center w-full">
                        <label class="flex flex-col items-center justify-center w-full h-32 border-2 border-dashed rounded-lg cursor-pointer hover:bg-surface-color transition-all duration-300 transform hover:scale-105 border-card-border">
                            <div class="flex flex-col items-center justify-center pt-5 pb-6">
                                <svg class="w-8 h-8 mb-4 text-gray-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 16">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 13h3a3 3 0 0 0 0-6h-.025A5.56 5.56 0 0 0 16 6.5 5.5 5.5 0 0 0 5.207 5.021C5.137 5.017 5.071 5 5 5a4 4 0 0 0 0 8h2.167M10 15V6m0 0L8 8m2-2 2 2"/>
                                </svg>
                                <p class="mb-2 text-sm text-gray-400"><span class="font-semibold">Clique para fazer upload</span> ou arraste e solte</p>
                                <p class="text-xs text-gray-500">PNG, JPG ou JPEG (MAX. 5MB)</p>
                            </div>
                            <input type="file" name="photos[]" class="hidden" multiple accept="image/*">
                        </label>
                    </div>
                    <div id="preview" class="grid grid-cols-2 md:grid-cols-3 gap-4"></div>
                </div>
            </div>

            <!-- Botão de Envio -->
            <div class="flex justify-end animate-on-scroll" style="animation-delay: 1s">
                <button type="submit" class="btn-primary hover-glow hover-lift px-6 py-3 rounded-lg text-white font-semibold transition-all duration-300 transform hover:scale-105">
                    Enviar Avaliação
                </button>
            </div>
        </form>
    </div>
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Inicializa as estrelas com base nos valores salvos
    initializeStars();

    // Configura os botões de estrela
    document.querySelectorAll('.star-button').forEach(button => {
        button.addEventListener('click', function() {
            const rating = this.dataset.rating;
            const category = this.dataset.category;
            setRating(category, rating);

            // Adiciona efeito de ripple
            const ripple = document.createElement('div');
            ripple.className = 'ripple';
            this.appendChild(ripple);
            setTimeout(() => ripple.remove(), 1000);
        });

        button.addEventListener('mouseover', function() {
            const rating = this.dataset.rating;
            const category = this.dataset.category;
            highlightStars(category, rating);
        });

        button.addEventListener('mouseout', function() {
            const category = this.dataset.category;
            resetStars(category);
        });
    });

    // Configura o preview de imagens
    const fileInput = document.querySelector('input[type="file"]');
    const preview = document.getElementById('preview');

    fileInput.addEventListener('change', function() {
        preview.innerHTML = '';
        Array.from(this.files).forEach(file => {
            if (file.type.startsWith('image/')) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    const div = document.createElement('div');
                    div.className = 'relative group animate-fade-in';
                    div.innerHTML = `
                        <div class="relative overflow-hidden rounded-lg">
                            <img src="${e.target.result}" class="w-full h-32 object-cover transition-transform duration-300 group-hover:scale-110">
                            <div class="absolute inset-0 bg-black bg-opacity-0 group-hover:bg-opacity-30 transition-all duration-300 flex items-center justify-center">
                                <button type="button" class="text-white opacity-0 group-hover:opacity-100 transition-opacity duration-300 transform hover:scale-110">
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                    </svg>
                                </button>
                            </div>
                        </div>
                    `;
                    preview.appendChild(div);
                };
                reader.readAsDataURL(file);
            }
        });
    });

    // Adiciona efeito de ripple aos botões
    document.querySelectorAll('button').forEach(button => {
        button.addEventListener('click', function(e) {
            const ripple = document.createElement('div');
            ripple.className = 'ripple';
            this.appendChild(ripple);
            setTimeout(() => ripple.remove(), 1000);
        });
    });
});

function initializeStars() {
    const categories = ['food', 'service', 'ambiance'];
    categories.forEach(category => {
        const rating = document.getElementById(`${category}_rating`).value;
        if (rating > 0) {
            highlightStars(category, rating);
        }
    });
}

function setRating(category, rating) {
    document.getElementById(`${category}_rating`).value = rating;
    highlightStars(category, rating);
}

function highlightStars(category, rating) {
    document.querySelectorAll(`.star-button[data-category="${category}"]`).forEach(button => {
        const buttonRating = parseInt(button.dataset.rating);
        button.classList.toggle('text-yellow-400', buttonRating <= rating);
        button.classList.toggle('text-gray-400', buttonRating > rating);
    });
}

function resetStars(category) {
    const currentRating = document.getElementById(`${category}_rating`).value;
    highlightStars(category, currentRating);
}
</script>

<style>
.ripple {
    position: absolute;
    border-radius: 50%;
    background: rgba(255, 255, 255, 0.3);
    transform: scale(0);
    animation: ripple 0.6s linear;
    pointer-events: none;
}

@keyframes ripple {
    to {
        transform: scale(4);
        opacity: 0;
    }
}

.star-button {
    position: relative;
    overflow: hidden;
}

.star-button:hover {
    transform: scale(1.2);
}

#preview img {
    transition: transform 0.3s ease;
}

#preview img:hover {
    transform: scale(1.1);
}
</style>
@endpush
@endsection
