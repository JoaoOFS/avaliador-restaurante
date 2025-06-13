@extends('layouts.guest')

@section('content')
    <div class="w-full sm:max-w-md mt-6 px-6 py-4 bg-white shadow-md overflow-hidden sm:rounded-lg">
        <div class="mb-8 text-center">
            <div class="w-16 h-16 bg-primary/10 rounded-full flex items-center justify-center mx-auto mb-4">
                <i class="fas fa-envelope text-3xl text-primary"></i>
            </div>
            <h3 class="text-lg font-semibold text-gray-900">Verificação Necessária</h3>
            <p class="mt-2 text-sm text-gray-600">
                Obrigado por se registrar! Antes de começar, você poderia verificar seu endereço de email clicando no link que acabamos de enviar para você? Se você não recebeu o email, podemos enviar outro.
            </p>
        </div>

        @if (session('status') == 'verification-link-sent')
            <div class="mb-4 p-4 bg-green-50 border border-green-200 rounded-lg">
                <p class="text-sm text-green-600">
                    Um novo link de verificação foi enviado para o endereço de email que você forneceu durante o registro.
                </p>
            </div>
        @endif

        <div class="space-y-6">
            <!-- Formulário de Reenvio -->
            <form method="POST" action="{{ route('verification.send') }}">
                @csrf
                <button type="submit" class="w-full btn-primary">
                    <i class="fas fa-paper-plane mr-2"></i> Reenviar Email de Verificação
                </button>
            </form>

            <!-- Formulário de Logout -->
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="w-full btn-secondary">
                    <i class="fas fa-sign-out-alt mr-2"></i> Sair
                </button>
            </form>
        </div>
    </div>
@endsection
