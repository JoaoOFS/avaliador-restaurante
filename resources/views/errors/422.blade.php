@extends('layouts.guest')

@section('content')
    <div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0 bg-gray-100">
        <div class="w-full sm:max-w-md mt-6 px-6 py-4 bg-white shadow-md overflow-hidden sm:rounded-lg text-center">
            <div class="mb-8">
                <div class="w-24 h-24 bg-primary/10 rounded-full flex items-center justify-center mx-auto mb-4">
                    <i class="fas fa-exclamation text-5xl text-primary"></i>
                </div>
                <h1 class="text-6xl font-bold text-gray-900 mb-4">422</h1>
                <h2 class="text-2xl font-semibold text-gray-900 mb-2">Entidade Não Processável</h2>
                <p class="text-gray-600">
                    Desculpe, a requisição não pôde ser processada devido a dados inválidos.
                </p>
            </div>

            <div class="space-y-4">
                <a href="{{ route('home') }}" class="btn-primary inline-block">
                    <i class="fas fa-home mr-2"></i> Voltar para a página inicial
                </a>

                <p class="text-sm text-gray-500">
                    Se você acredita que isso é um erro, por favor entre em contato com o suporte.
                </p>
            </div>
        </div>
    </div>
@endsection
