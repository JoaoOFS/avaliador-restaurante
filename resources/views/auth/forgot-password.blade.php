@extends('layouts.guest')

@section('content')
    <div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0 bg-gray-100">
        <div class="w-full sm:max-w-md mt-6 px-6 py-4 bg-white shadow-md overflow-hidden sm:rounded-lg">
            <div class="mb-8 text-center">
                <h2 class="text-2xl font-bold text-gray-900">Recuperar Senha</h2>
                <p class="mt-2 text-sm text-gray-600">
                    Digite seu email para receber um link de recuperação
                </p>
            </div>

            <!-- Status da Sessão -->
            @if (session('status'))
                <div class="mb-4 p-4 bg-green-50 border border-green-200 rounded-lg">
                    <p class="text-sm text-green-600">
                        {{ session('status') }}
                    </p>
                </div>
            @endif

            <form method="POST" action="{{ route('password.email') }}" class="space-y-6">
                @csrf

                <!-- Email -->
                <div>
                    <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
                    <div class="mt-1">
                        <input type="email" name="email" id="email" value="{{ old('email') }}" required autofocus
                               class="w-full @error('email') border-red-500 @enderror">
                        @error('email')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Botão de Envio -->
                <div>
                    <button type="submit" class="w-full btn-primary">
                        <i class="fas fa-paper-plane mr-2"></i> Enviar Link de Recuperação
                    </button>
                </div>
            </form>

            <!-- Link para Login -->
            <div class="mt-6 text-center">
                <p class="text-sm text-gray-600">
                    Lembrou sua senha?
                    <a href="{{ route('login') }}" class="text-primary hover:underline">
                        Voltar para o login
                    </a>
                </p>
            </div>
        </div>
    </div>
@endsection
