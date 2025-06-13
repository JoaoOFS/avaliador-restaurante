@extends('layouts.guest')

@section('content')
    <div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0 bg-gray-100">
        <div class="w-full sm:max-w-md mt-6 px-6 py-4 bg-white shadow-md overflow-hidden sm:rounded-lg">
            <div class="mb-8 text-center">
                <h2 class="text-2xl font-bold text-gray-900">Criar Conta</h2>
                <p class="mt-2 text-sm text-gray-600">
                    Junte-se à nossa comunidade de amantes da gastronomia
                </p>
            </div>

            <form method="POST" action="{{ route('register') }}" class="space-y-6">
                @csrf

                <!-- Nome -->
                <div>
                    <label for="name" class="block text-sm font-medium text-gray-700">Nome</label>
                    <div class="mt-1">
                        <input type="text" name="name" id="name" value="{{ old('name') }}" required autofocus
                               class="w-full @error('name') border-red-500 @enderror">
                        @error('name')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Email -->
                <div>
                    <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
                    <div class="mt-1">
                        <input type="email" name="email" id="email" value="{{ old('email') }}" required
                               class="w-full @error('email') border-red-500 @enderror">
                        @error('email')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Telefone -->
                <div>
                    <label for="phone" class="block text-sm font-medium text-gray-700">Telefone</label>
                    <div class="mt-1">
                        <input type="tel" name="phone" id="phone" value="{{ old('phone') }}"
                               class="w-full @error('phone') border-red-500 @enderror">
                        @error('phone')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

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

                <!-- Confirmar Senha -->
                <div>
                    <label for="password_confirmation" class="block text-sm font-medium text-gray-700">Confirmar Senha</label>
                    <div class="mt-1">
                        <input type="password" name="password_confirmation" id="password_confirmation" required
                               class="w-full">
                    </div>
                </div>

                <!-- Termos de Uso -->
                <div class="flex items-center">
                    <input type="checkbox" name="terms" id="terms" required
                           class="rounded border-gray-300 text-primary focus:ring-primary">
                    <label for="terms" class="ml-2 text-sm text-gray-600">
                        Eu concordo com os <a href="#" class="text-primary hover:underline">Termos de Uso</a> e
                        <a href="#" class="text-primary hover:underline">Política de Privacidade</a>
                    </label>
                </div>

                <!-- Botão de Registro -->
                <div>
                    <button type="submit" class="w-full btn-primary">
                        <i class="fas fa-user-plus mr-2"></i> Criar Conta
                    </button>
                </div>
            </form>

            <!-- Link para Login -->
            <div class="mt-6 text-center">
                <p class="text-sm text-gray-600">
                    Já tem uma conta?
                    <a href="{{ route('login') }}" class="text-primary hover:underline">
                        Faça login
                    </a>
                </p>
            </div>
        </div>
    </div>
@endsection
