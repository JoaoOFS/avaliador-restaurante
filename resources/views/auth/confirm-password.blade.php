@extends('layouts.app')

@section('header', 'Confirmação de Senha')
@section('subheader', 'Por favor, confirme sua senha antes de continuar')

@section('content')
    <div class="max-w-3xl mx-auto">
        <div class="card">
            <div class="p-6">
                <div class="mb-8 text-center">
                    <div class="w-16 h-16 bg-primary/10 rounded-full flex items-center justify-center mx-auto mb-4">
                        <i class="fas fa-lock text-3xl text-primary"></i>
                    </div>
                    <h3 class="text-lg font-semibold text-gray-900">Confirmação de Segurança</h3>
                    <p class="mt-2 text-sm text-gray-600">
                        Esta é uma área segura da aplicação. Por favor, confirme sua senha antes de continuar.
                    </p>
                </div>

                <form method="POST" action="{{ route('password.confirm') }}" class="space-y-6">
                    @csrf

                    <!-- Senha -->
                    <div>
                        <label for="password" class="block text-sm font-medium text-gray-700">Senha</label>
                        <div class="mt-1">
                            <input type="password" name="password" id="password" required
                                   class="w-full @error('password') border-red-500 @enderror">
                            @error('password')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <!-- Botão de Confirmação -->
                    <div>
                        <button type="submit" class="w-full btn-primary">
                            <i class="fas fa-check mr-2"></i> Confirmar
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
