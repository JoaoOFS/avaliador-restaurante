@extends('layouts.guest')

@section('content')
    <div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0 bg-gray-100">
        <div class="w-full sm:max-w-md mt-6 px-6 py-4 bg-white shadow-md overflow-hidden sm:rounded-lg">
            <div class="mb-8 text-center">
                <h2 class="text-2xl font-bold text-gray-900">Redefinir Senha</h2>
                <p class="mt-2 text-sm text-gray-600">
                    Digite sua nova senha
                </p>
            </div>

            <form method="POST" action="{{ route('password.store') }}" class="space-y-6">
                @csrf

                <!-- Token de Redefinição -->
                <input type="hidden" name="token" value="{{ $request->route('token') }}">

                <!-- Email -->
                <div>
                    <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
                    <div class="mt-1">
                        <input type="email" name="email" id="email" value="{{ old('email', $request->email) }}" required autofocus
                               class="w-full @error('email') border-red-500 @enderror">
                        @error('email')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Nova Senha -->
                <div>
                    <label for="password" class="block text-sm font-medium text-gray-700">Nova Senha</label>
                    <div class="mt-1">
                        <input type="password" name="password" id="password" required
                               class="w-full @error('password') border-red-500 @enderror">
                        @error('password')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Confirmar Nova Senha -->
                <div>
                    <label for="password_confirmation" class="block text-sm font-medium text-gray-700">Confirmar Nova Senha</label>
                    <div class="mt-1">
                        <input type="password" name="password_confirmation" id="password_confirmation" required
                               class="w-full">
                    </div>
                </div>

                <!-- Botão de Redefinição -->
                <div>
                    <button type="submit" class="w-full btn-primary">
                        <i class="fas fa-key mr-2"></i> Redefinir Senha
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
