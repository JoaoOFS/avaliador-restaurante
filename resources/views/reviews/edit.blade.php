@extends('layouts.app')

@section('header', 'Editar Avaliação')
@section('subheader', $review->restaurant->name)

@section('content')
<div class="min-h-screen py-8">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-8">
            <h1 class="text-3xl font-bold text-light mb-2">Editar Avaliação</h1>
            <p class="text-gray-400">Atualize sua avaliação para {{ $review->restaurant->name }}</p>
        </div>

        <form action="{{ route('reviews.update', $review) }}" method="POST" enctype="multipart/form-data" class="space-y-8">
            @csrf
            @method('PUT')

            <!-- Avaliações Específicas -->
            <div class="card hover-3d animate-on-scroll">
                <h2 class="text-xl font-semibold mb-6 text-light">Avaliações Específicas</h2>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <!-- Comida -->
                    <div>
                        <label class="block text-sm font-medium text-gray-400 mb-2">Comida</label>
                        <div class="flex items-center gap-2">
                            @for($i = 1; $i <= 5; $i++)
                                <button type="button"
                                        class="star-button text-2xl {{ $i <= old('food_rating', $review->food_rating) ? 'text-yellow-400' : 'text-gray-400' }}"
                                        data-rating="{{ $i }}"
                                        data-target="food_rating">
                                    <i class="fas fa-star"></i>
                                </button>
                            @endfor
                        </div>
                        <input type="hidden"
                               name="food_rating"
                               value="{{ old('food_rating', $review->food_rating) }}"
                               required>
                        @error('food_rating')
                            <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Serviço -->
                    <div>
                        <label class="block text-sm font-medium text-gray-400 mb-2">Serviço</label>
                        <div class="flex items-center gap-2">
                            @for($i = 1; $i <= 5; $i++)
                                <button type="button"
                                        class="star-button text-2xl {{ $i <= old('service_rating', $review->service_rating) ? 'text-yellow-400' : 'text-gray-400' }}"
                                        data-rating="{{ $i }}"
                                        data-target="service_rating">
                                    <i class="fas fa-star"></i>
                                </button>
                            @endfor
                        </div>
                        <input type="hidden"
                               name="service_rating"
                               value="{{ old('service_rating', $review->service_rating) }}"
                               required>
                        @error('service_rating')
                            <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Ambiente -->
                    <div>
                        <label class="block text-sm font-medium text-gray-400 mb-2">Ambiente</label>
                        <div class="flex items-center gap-2">
                            @for($i = 1; $i <= 5; $i++)
                                <button type="button"
                                        class="star-button text-2xl {{ $i <= old('ambiance_rating', $review->ambiance_rating) ? 'text-yellow-400' : 'text-gray-400' }}"
                                        data-rating="{{ $i }}"
                                        data-target="ambiance_rating">
                                    <i class="fas fa-star"></i>
                                </button>
                            @endfor
                        </div>
                        <input type="hidden"
                               name="ambiance_rating"
                               value="{{ old('ambiance_rating', $review->ambiance_rating) }}"
                               required>
                        @error('ambiance_rating')
                            <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>

            <!-- Comentário -->
            <div class="card hover-3d animate-on-scroll">
                <h2 class="text-xl font-semibold mb-6 text-light">Comentário</h2>

                <div class="mb-6">
                    <label for="comment" class="block text-sm font-medium text-gray-400 mb-2">Sua Avaliação</label>
                    <textarea name="comment"
                              id="comment"
                              rows="4"
                              class="w-full px-4 py-2 rounded-lg bg-input-bg border border-card-border text-light focus:ring-2 focus:ring-primary focus:border-primary transition-all duration-200"
                              required>{{ old('comment', $review->comment) }}</textarea>
                    @error('comment')
                        <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <!-- Fotos -->
            <div class="card hover-3d animate-on-scroll">
                <h2 class="text-xl font-semibold mb-6 text-light">Fotos</h2>

                <div class="space-y-4">
                    <!-- Fotos Existentes -->
                    @if($review->photos->isNotEmpty())
                        <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                            @foreach($review->photos as $photo)
                                <div class="relative group">
                                    <img src="{{ $photo->url }}"
                                         alt="Foto da avaliação"
                                         class="w-full h-32 object-cover rounded-lg">
                                    <button type="button"
                                            onclick="deletePhoto({{ $photo->id }})"
                                            class="absolute top-2 right-2 p-1 bg-red-500 text-white rounded-full opacity-0 group-hover:opacity-100 transition-opacity">
                                        <i class="fas fa-times"></i>
                                    </button>
                                </div>
                            @endforeach
                        </div>
                    @endif

                    <!-- Upload de Novas Fotos -->
                    <div class="grid grid-cols-2 md:grid-cols-4 gap-4" id="photo-preview">
                        <!-- Preview das novas fotos será inserido aqui -->
                    </div>

                    <div class="flex items-center justify-center w-full">
                        <label class="flex flex-col items-center justify-center w-full h-32 border-2 border-dashed border-card-border rounded-lg cursor-pointer bg-input-bg hover:bg-surface-color transition-colors">
                            <div class="flex flex-col items-center justify-center pt-5 pb-6">
                                <i class="fas fa-cloud-upload-alt text-3xl text-gray-400 mb-2"></i>
                                <p class="mb-2 text-sm text-gray-400">
                                    <span class="font-semibold">Clique para fazer upload</span> ou arraste e solte
                                </p>
                                <p class="text-xs text-gray-400">PNG, JPG ou JPEG (MAX. 5MB)</p>
                            </div>
                            <input type="file"
                                   name="photos[]"
                                   class="hidden"
                                   accept="image/*"
                                   multiple
                                   onchange="previewPhotos(this)">
                        </label>
                    </div>
                    @error('photos')
                        <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <!-- Botões -->
            <div class="flex justify-end gap-4">
                <a href="{{ route('reviews.show', $review) }}"
                   class="btn-secondary hover-lift px-6 py-3 rounded-lg">
                    Cancelar
                </a>
                <button type="submit"
                        class="btn-primary hover-glow hover-lift px-6 py-3 rounded-lg">
                    <i class="fas fa-save mr-2"></i> Salvar Alterações
                </button>
            </div>
        </form>
    </div>
</div>

@push('scripts')
<script>
// Sistema de Estrelas
document.querySelectorAll('.star-button').forEach(button => {
    button.addEventListener('click', function() {
        const rating = this.dataset.rating;
        const target = this.dataset.target;
        const container = this.parentElement;

        // Atualiza o input hidden
        container.nextElementSibling.value = rating;

        // Atualiza as estrelas
        container.querySelectorAll('.star-button').forEach(star => {
            if (star.dataset.target === target) {
                star.classList.toggle('text-yellow-400', star.dataset.rating <= rating);
                star.classList.toggle('text-gray-400', star.dataset.rating > rating);
            }
        });
    });

    button.addEventListener('mouseover', function() {
        const rating = this.dataset.rating;
        const target = this.dataset.target;
        const container = this.parentElement;

        container.querySelectorAll('.star-button').forEach(star => {
            if (star.dataset.target === target) {
                star.classList.toggle('text-yellow-400', star.dataset.rating <= rating);
                star.classList.toggle('text-gray-400', star.dataset.rating > rating);
            }
        });
    });

    button.addEventListener('mouseout', function() {
        const target = this.dataset.target;
        const container = this.parentElement;
        const currentRating = container.nextElementSibling.value;

        container.querySelectorAll('.star-button').forEach(star => {
            if (star.dataset.target === target) {
                star.classList.toggle('text-yellow-400', star.dataset.rating <= currentRating);
                star.classList.toggle('text-gray-400', star.dataset.rating > currentRating);
            }
        });
    });
});

// Preview de fotos
function previewPhotos(input) {
    const preview = document.getElementById('photo-preview');
    preview.innerHTML = '';

    if (input.files) {
        Array.from(input.files).forEach((file, index) => {
            const reader = new FileReader();
            reader.onload = function(e) {
                const div = document.createElement('div');
                div.className = 'relative group';
                div.innerHTML = `
                    <img src="${e.target.result}"
                         class="w-full h-32 object-cover rounded-lg">
                    <button type="button"
                            onclick="removePhoto(${index})"
                            class="absolute top-2 right-2 p-1 bg-red-500 text-white rounded-full opacity-0 group-hover:opacity-100 transition-opacity">
                        <i class="fas fa-times"></i>
                    </button>
                `;
                preview.appendChild(div);
            }
            reader.readAsDataURL(file);
        });
    }
}

// Remover foto
function removePhoto(index) {
    const input = document.querySelector('input[type="file"]');
    const dt = new DataTransfer();
    const files = input.files;

    for (let i = 0; i < files.length; i++) {
        if (i !== index) {
            dt.items.add(files[i]);
        }
    }

    input.files = dt.files;
    previewPhotos(input);
}

// Deletar foto existente
function deletePhoto(photoId) {
    if (confirm('Tem certeza que deseja excluir esta foto?')) {
        fetch(`/photos/${photoId}`, {
            method: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Accept': 'application/json'
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                location.reload();
            }
        })
        .catch(error => {
            console.error('Erro ao deletar foto:', error);
        });
    }
}

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
