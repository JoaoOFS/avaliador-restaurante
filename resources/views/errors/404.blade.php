@extends('layouts.app')

@section('title', 'Erro 404 - Página Não Encontrada')

@section('content')
<div class="min-h-screen flex items-center justify-center py-12 px-4 sm:px-6 lg:px-8">
    <div class="max-w-md w-full space-y-8 text-center">
        <div class="card">
            <div class="mb-8">
                <i class="fas fa-search text-6xl text-primary mb-4"></i>
                <h1 class="text-4xl font-bold mb-4">404</h1>
                <h2 class="text-2xl font-semibold mb-4">Página Não Encontrada</h2>
                <p class="text-gray-400 mb-8">
                    Desculpe, a página que você está procurando não existe ou foi movida.
                </p>
                <div class="flex flex-col sm:flex-row gap-4 justify-center">
                    <a href="{{ route('home') }}" class="btn btn-primary">
                        <i class="fas fa-home mr-2"></i> Voltar ao Início
                    </a>
                    <button onclick="window.history.back()" class="btn btn-secondary">
                        <i class="fas fa-arrow-left mr-2"></i> Voltar
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
