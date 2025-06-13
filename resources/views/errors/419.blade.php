@extends('layouts.app')

@section('title', 'Erro 419 - Página Expirada')

@section('content')
<div class="min-h-screen flex items-center justify-center py-12 px-4 sm:px-6 lg:px-8">
    <div class="max-w-md w-full space-y-8 text-center">
        <div class="card">
            <div class="mb-8">
                <i class="fas fa-clock text-6xl text-primary mb-4"></i>
                <h1 class="text-4xl font-bold mb-4">419</h1>
                <h2 class="text-2xl font-semibold mb-4">Página Expirada</h2>
                <p class="text-gray-400 mb-8">
                    Desculpe, sua sessão expirou. Por favor, atualize a página e tente novamente.
                </p>
                <div class="flex flex-col sm:flex-row gap-4 justify-center">
                    <button onclick="window.location.reload()" class="btn btn-primary">
                        <i class="fas fa-sync-alt mr-2"></i> Atualizar Página
                    </button>
                    <a href="{{ route('home') }}" class="btn btn-secondary">
                        <i class="fas fa-home mr-2"></i> Voltar ao Início
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
