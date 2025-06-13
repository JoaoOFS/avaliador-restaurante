@extends('layouts.app')

@section('title', 'Erro 503 - Serviço Indisponível')

@section('content')
<div class="min-h-screen flex items-center justify-center py-12 px-4 sm:px-6 lg:px-8">
    <div class="max-w-md w-full space-y-8 text-center">
        <div class="card">
            <div class="mb-8">
                <i class="fas fa-tools text-6xl text-primary mb-4"></i>
                <h1 class="text-4xl font-bold mb-4">503</h1>
                <h2 class="text-2xl font-semibold mb-4">Serviço Indisponível</h2>
                <p class="text-gray-400 mb-8">
                    Desculpe, estamos realizando manutenção no momento. Por favor, tente novamente em alguns minutos.
                </p>
                <div class="flex flex-col sm:flex-row gap-4 justify-center">
                    <button onclick="window.location.reload()" class="btn btn-primary">
                        <i class="fas fa-sync-alt mr-2"></i> Tentar Novamente
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
