@extends('layouts.app')

@section('content')
<div class="min-h-screen py-8">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-8">
            <h1 class="text-3xl font-bold text-light mb-2">Editar Restaurante</h1>
            <p class="text-gray-400">Atualize as informações do restaurante</p>
        </div>

        <form action="{{ route('restaurants.update', $restaurant) }}" method="POST" enctype="multipart/form-data" class="space-y-8">
            @csrf
            @method('PUT')

            <!-- Informações Básicas -->
            <div class="card hover-3d animate-on-scroll">
                <h2 class="text-xl font-semibold mb-6 text-light">Informações Básicas</h2>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Nome -->
                    <div class="col-span-2">
                        <label for="name" class="block text-sm font-medium text-gray-400 mb-2">Nome do Restaurante</label>
                        <input type="text"
                               name="name"
                               id="name"
                               value="{{ old('name', $restaurant->name) }}"
                               class="w-full px-4 py-2 rounded-lg bg-input-bg border border-card-border text-light focus:ring-2 focus:ring-primary focus:border-primary transition-all duration-200"
                               required>
                        @error('name')
                            <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Descrição -->
                    <div class="col-span-2">
                        <label for="description" class="block text-sm font-medium text-gray-400 mb-2">Descrição</label>
                        <textarea name="description"
                                  id="description"
                                  rows="4"
                                  class="w-full px-4 py-2 rounded-lg bg-input-bg border border-card-border text-light focus:ring-2 focus:ring-primary focus:border-primary transition-all duration-200"
                                  required>{{ old('description', $restaurant->description) }}</textarea>
                        @error('description')
                            <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Categorias -->
                    <div>
                        <label class="block text-sm font-medium text-gray-400 mb-2">Categorias</label>
                        <div class="grid grid-cols-2 gap-2">
                            @foreach($categories as $category)
                                <label class="flex items-center space-x-2 p-2 rounded-lg bg-input-bg border border-card-border hover:border-primary transition-colors cursor-pointer">
                                    <input type="checkbox"
                                           name="categories[]"
                                           value="{{ $category->id }}"
                                           {{ in_array($category->id, old('categories', $restaurant->categories->pluck('id')->toArray())) ? 'checked' : '' }}
                                           class="form-checkbox text-primary">
                                    <span class="text-light">{{ $category->name }}</span>
                                </label>
                            @endforeach
                        </div>
                        @error('categories')
                            <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Tipo de Cozinha -->
                    <div>
                        <label for="cuisine" class="block text-sm font-medium text-gray-400 mb-2">Tipo de Cozinha</label>
                        <select name="cuisine_id"
                                id="cuisine"
                                class="w-full px-4 py-2 rounded-lg bg-input-bg border border-card-border text-light focus:ring-2 focus:ring-primary focus:border-primary transition-all duration-200"
                                required>
                            <option value="">Selecione uma opção</option>
                            @foreach($cuisines as $cuisine)
                                <option value="{{ $cuisine->id }}" {{ old('cuisine_id', $restaurant->cuisine_id) == $cuisine->id ? 'selected' : '' }}>
                                    {{ $cuisine->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('cuisine_id')
                            <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>

            <!-- Localização e Contato -->
            <div class="card hover-3d animate-on-scroll">
                <h2 class="text-xl font-semibold mb-6 text-light">Localização e Contato</h2>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- CEP -->
                    <div>
                        <label for="cep" class="block text-sm font-medium text-gray-400 mb-2">CEP *</label>
                        <div class="flex gap-2">
                            <input type="text"
                                   name="cep"
                                   id="cep"
                                   value="{{ old('cep', $restaurant->cep) }}"
                                   class="w-full px-4 py-2 rounded-lg bg-input-bg border border-card-border text-light focus:ring-2 focus:ring-primary focus:border-primary transition-all duration-200"
                                   placeholder="00000-000"
                                   required>
                            <button type="button"
                                    onclick="buscarCep()"
                                    class="btn-secondary hover-lift px-4 py-2 rounded-lg">
                                <i class="fas fa-search"></i>
                            </button>
                        </div>
                        @error('cep')
                            <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Endereço -->
                    <div>
                        <label for="address" class="block text-sm font-medium text-gray-400 mb-2">Endereço *</label>
                        <input type="text"
                               name="address"
                               id="address"
                               value="{{ old('address', $restaurant->address) }}"
                               class="w-full px-4 py-2 rounded-lg bg-input-bg border border-card-border text-light focus:ring-2 focus:ring-primary focus:border-primary transition-all duration-200"
                               required>
                        @error('address')
                            <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Número -->
                    <div>
                        <label for="number" class="block text-sm font-medium text-gray-400 mb-2">Número *</label>
                        <input type="text"
                               name="number"
                               id="number"
                               value="{{ old('number', $restaurant->number) }}"
                               class="w-full px-4 py-2 rounded-lg bg-input-bg border border-card-border text-light focus:ring-2 focus:ring-primary focus:border-primary transition-all duration-200"
                               required>
                        @error('number')
                            <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Complemento -->
                    <div>
                        <label for="complement" class="block text-sm font-medium text-gray-400 mb-2">Complemento</label>
                        <input type="text"
                               name="complement"
                               id="complement"
                               value="{{ old('complement', $restaurant->complement) }}"
                               class="w-full px-4 py-2 rounded-lg bg-input-bg border border-card-border text-light focus:ring-2 focus:ring-primary focus:border-primary transition-all duration-200">
                        @error('complement')
                            <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Bairro -->
                    <div>
                        <label for="neighborhood" class="block text-sm font-medium text-gray-400 mb-2">Bairro *</label>
                        <input type="text"
                               name="neighborhood"
                               id="neighborhood"
                               value="{{ old('neighborhood', $restaurant->neighborhood) }}"
                               class="w-full px-4 py-2 rounded-lg bg-input-bg border border-card-border text-light focus:ring-2 focus:ring-primary focus:border-primary transition-all duration-200"
                               required>
                        @error('neighborhood')
                            <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Cidade -->
                    <div>
                        <label for="city" class="block text-sm font-medium text-gray-400 mb-2">Cidade *</label>
                        <input type="text"
                               name="city"
                               id="city"
                               value="{{ old('city', $restaurant->city) }}"
                               class="w-full px-4 py-2 rounded-lg bg-input-bg border border-card-border text-light focus:ring-2 focus:ring-primary focus:border-primary transition-all duration-200"
                               required>
                        @error('city')
                            <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Estado -->
                    <div>
                        <label for="state" class="block text-sm font-medium text-gray-400 mb-2">Estado *</label>
                        <input type="text"
                               name="state"
                               id="state"
                               value="{{ old('state', $restaurant->state) }}"
                               class="w-full px-4 py-2 rounded-lg bg-input-bg border border-card-border text-light focus:ring-2 focus:ring-primary focus:border-primary transition-all duration-200"
                               required>
                        @error('state')
                            <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Telefone -->
                    <div>
                        <label for="phone" class="block text-sm font-medium text-gray-400 mb-2">Telefone *</label>
                        <input type="tel"
                               name="phone"
                               id="phone"
                               value="{{ old('phone', $restaurant->phone) }}"
                               class="w-full px-4 py-2 rounded-lg bg-input-bg border border-card-border text-light focus:ring-2 focus:ring-primary focus:border-primary transition-all duration-200"
                               placeholder="(00) 00000-0000"
                               required>
                        @error('phone')
                            <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Website -->
                    <div>
                        <label for="website" class="block text-sm font-medium text-gray-400 mb-2">Website</label>
                        <input type="url"
                               name="website"
                               id="website"
                               value="{{ old('website', $restaurant->website) }}"
                               class="w-full px-4 py-2 rounded-lg bg-input-bg border border-card-border text-light focus:ring-2 focus:ring-primary focus:border-primary transition-all duration-200"
                               placeholder="https://www.exemplo.com">
                        @error('website')
                            <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>

            <!-- Horário e Preços -->
            <div class="card hover-3d animate-on-scroll">
                <h2 class="text-xl font-semibold mb-6 text-light">Horário e Preços</h2>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Horário de Funcionamento -->
                    <div class="col-span-2">
                        <label class="block text-sm font-medium text-gray-400 mb-2">Horário de Funcionamento</label>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            @foreach(['Segunda a Sexta', 'Sábado', 'Domingo'] as $day)
                                <div class="flex items-center gap-4">
                                    <span class="text-light w-32">{{ $day }}</span>
                                    <div class="flex-1 grid grid-cols-2 gap-2">
                                        <input type="time"
                                               name="opening_hours[{{ $day }}][open]"
                                               value="{{ old("opening_hours.$day.open", $restaurant->opening_hours[$day]['open'] ?? '') }}"
                                               class="px-4 py-2 rounded-lg bg-input-bg border border-card-border text-light focus:ring-2 focus:ring-primary focus:border-primary transition-all duration-200">
                                        <input type="time"
                                               name="opening_hours[{{ $day }}][close]"
                                               value="{{ old("opening_hours.$day.close", $restaurant->opening_hours[$day]['close'] ?? '') }}"
                                               class="px-4 py-2 rounded-lg bg-input-bg border border-card-border text-light focus:ring-2 focus:ring-primary focus:border-primary transition-all duration-200">
                                    </div>
                                </div>
                            @endforeach
                        </div>
                        @error('opening_hours')
                            <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Faixa de Preço -->
                    <div>
                        <label for="price_range" class="block text-sm font-medium text-gray-400 mb-2">Faixa de Preço</label>
                        <select name="price_range"
                                id="price_range"
                                class="w-full px-4 py-2 rounded-lg bg-input-bg border border-card-border text-light focus:ring-2 focus:ring-primary focus:border-primary transition-all duration-200"
                                required>
                            <option value="">Selecione uma opção</option>
                            <option value="1" {{ old('price_range', $restaurant->price_range) == '1' ? 'selected' : '' }}>$ - Econômico</option>
                            <option value="2" {{ old('price_range', $restaurant->price_range) == '2' ? 'selected' : '' }}>$$ - Moderado</option>
                            <option value="3" {{ old('price_range', $restaurant->price_range) == '3' ? 'selected' : '' }}>$$$ - Alto</option>
                            <option value="4" {{ old('price_range', $restaurant->price_range) == '4' ? 'selected' : '' }}>$$$$ - Luxuoso</option>
                        </select>
                        @error('price_range')
                            <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>

            <!-- Fotos -->
            <div class="card hover-3d animate-on-scroll">
                <h2 class="text-xl font-semibold mb-6 text-light">Fotos</h2>

                <div class="space-y-4">
                    <!-- Fotos Existentes -->
                    @if($restaurant->photos->isNotEmpty())
                        <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                            @foreach($restaurant->photos as $photo)
                                <div class="relative group">
                                    <img src="{{ $photo->url }}"
                                         alt="Foto do restaurante"
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
                <a href="{{ route('restaurants.show', $restaurant) }}"
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

// Máscara para CEP
document.getElementById('cep').addEventListener('input', function (e) {
    let value = e.target.value.replace(/\D/g, '');
    if (value.length > 5) {
        value = value.substring(0, 5) + '-' + value.substring(5, 8);
    }
    e.target.value = value;
});

// Máscara para telefone
document.getElementById('phone').addEventListener('input', function (e) {
    let value = e.target.value.replace(/\D/g, '');
    if (value.length > 2) {
        value = '(' + value.substring(0, 2) + ') ' + value.substring(2);
    }
    if (value.length > 9) {
        value = value.substring(0, 10) + '-' + value.substring(10, 14);
    }
    e.target.value = value;
});

// Função para buscar CEP
function buscarCep() {
    const cep = document.getElementById('cep').value.replace(/\D/g, '');

    if (cep.length !== 8) {
        showNotification('CEP inválido', 'error');
        return;
    }

    // Mostra loading
    const loadingOverlay = document.querySelector('.loading-overlay');
    loadingOverlay.classList.add('active');

    fetch(`https://viacep.com.br/ws/${cep}/json/`)
        .then(response => response.json())
        .then(data => {
            if (data.erro) {
                showNotification('CEP não encontrado', 'error');
                return;
            }

            // Preenche os campos
            document.getElementById('address').value = data.logradouro;
            document.getElementById('neighborhood').value = data.bairro;
            document.getElementById('city').value = data.localidade;
            document.getElementById('state').value = data.uf;

            // Foca no campo número
            document.getElementById('number').focus();
        })
        .catch(error => {
            showNotification('Erro ao buscar CEP', 'error');
            console.error('Erro:', error);
        })
        .finally(() => {
            // Esconde loading
            loadingOverlay.classList.remove('active');
        });
}

// Função para mostrar notificações
function showNotification(message, type = 'success') {
    const notification = document.createElement('div');
    notification.className = `notification ${type}`;
    notification.textContent = message;
    document.body.appendChild(notification);

    setTimeout(() => {
        notification.classList.add('show');
    }, 100);

    setTimeout(() => {
        notification.classList.remove('show');
        setTimeout(() => notification.remove(), 300);
    }, 3000);
}
</script>
@endpush
@endsection
