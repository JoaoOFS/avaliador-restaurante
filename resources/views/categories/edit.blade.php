@extends('layouts.app')

@section('title', 'Editar Categoria')
@section('header', 'Editar Categoria')
@section('subheader', $category->name)

@section('content')
    <div class="max-w-3xl mx-auto">
        <form action="{{ route('categories.update', $category) }}" method="POST" class="space-y-6">
            @csrf
            @method('PUT')

            <div class="card">
                <div class="p-6">
                    <h3 class="text-lg font-semibold mb-4">Informações da Categoria</h3>

                    <div class="space-y-6">
                        <!-- Nome -->
                        <div>
                            <label for="name" class="block text-sm font-medium text-gray-300 mb-1">Nome *</label>
                            <div class="relative">
                                <input type="text" name="name" id="name" value="{{ old('name', $category->name) }}" required
                                       class="w-full pl-10 @error('name') border-red-500 @enderror"
                                       placeholder="Ex: Restaurantes Italianos">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <i class="fas fa-tag text-gray-400"></i>
                                </div>
                            </div>
                            @error('name')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Descrição -->
                        <div>
                            <label for="description" class="block text-sm font-medium text-gray-300 mb-1">Descrição *</label>
                            <div class="relative">
                                <textarea name="description" id="description" rows="4" required
                                          class="w-full pl-10 @error('description') border-red-500 @enderror"
                                          placeholder="Descreva a categoria...">{{ old('description', $category->description) }}</textarea>
                                <div class="absolute top-3 left-0 pl-3 flex items-start pointer-events-none">
                                    <i class="fas fa-align-left text-gray-400"></i>
                                </div>
                            </div>
                            @error('description')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Ícone -->
                        <div>
                            <label for="icon" class="block text-sm font-medium text-gray-300 mb-1">Ícone *</label>
                            <div class="flex items-center space-x-4">
                                <div class="w-12 h-12 bg-primary/10 rounded-lg flex items-center justify-center group-hover:bg-primary/20 transition-colors">
                                    <i class="{{ old('icon', $category->icon) }} text-2xl text-primary" id="icon-preview"></i>
                                </div>
                                <div class="flex-1">
                                    <div class="relative">
                                        <input type="text" name="icon" id="icon" value="{{ old('icon', $category->icon) }}" required
                                               class="w-full pl-10 @error('icon') border-red-500 @enderror"
                                               placeholder="Ex: fas fa-utensils">
                                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                            <i class="fas fa-icons text-gray-400"></i>
                                        </div>
                                    </div>
                                    <p class="text-sm text-gray-400 mt-1">
                                        Use classes do <a href="https://fontawesome.com/icons" target="_blank" class="text-primary hover:underline">Font Awesome</a>
                                    </p>
                                </div>
                            </div>
                            @error('icon')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Status -->
                        <div>
                            <label class="block text-sm font-medium text-gray-300 mb-1">Status</label>
                            <div class="flex items-center">
                                <label class="relative inline-flex items-center cursor-pointer">
                                    <input type="checkbox" name="is_active" id="is_active" value="1"
                                           {{ old('is_active', $category->is_active) ? 'checked' : '' }}
                                           class="sr-only peer">
                                    <div class="w-11 h-6 bg-gray-700 peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-primary"></div>
                                    <span class="ml-3 text-sm text-gray-400">Categoria ativa</span>
                                </label>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Botões -->
            <div class="flex justify-end space-x-4">
                <a href="{{ route('categories.show', $category) }}" class="btn btn-secondary">
                    <i class="fas fa-times mr-2"></i> Cancelar
                </a>
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-save mr-2"></i> Salvar Alterações
                </button>
            </div>
        </form>
    </div>

    @push('scripts')
    <script>
        // Preview do ícone
        document.getElementById('icon').addEventListener('input', function(e) {
            document.getElementById('icon-preview').className = e.target.value + ' text-2xl text-primary';
        });

        // Validação em tempo real
        const form = document.querySelector('form');
        const inputs = form.querySelectorAll('input[required], textarea[required]');

        inputs.forEach(input => {
            input.addEventListener('input', function() {
                if (this.value.trim() === '') {
                    this.classList.add('border-red-500');
                } else {
                    this.classList.remove('border-red-500');
                }
            });
        });

        // Confirmação antes de sair com alterações
        let formChanged = false;
        const initialFormData = new FormData(form);

        form.addEventListener('change', () => {
            const currentFormData = new FormData(form);
            formChanged = !Array.from(initialFormData.entries()).every(([key, value]) => currentFormData.get(key) === value);
        });

        form.addEventListener('input', () => {
            const currentFormData = new FormData(form);
            formChanged = !Array.from(initialFormData.entries()).every(([key, value]) => currentFormData.get(key) === value);
        });

        window.addEventListener('beforeunload', (e) => {
            if (formChanged) {
                e.preventDefault();
                e.returnValue = '';
            }
        });
    </script>
    @endpush
@endsection
