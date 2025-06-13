@extends('layouts.app')

@section('header', 'Excluir Conta')
@section('subheader', 'Exclua permanentemente sua conta e todos os seus dados')

@section('content')
    <div class="max-w-3xl mx-auto">
        <div class="card bg-red-50 border-red-200">
            <div class="p-6">
                <div class="flex items-center mb-4">
                    <div class="flex-shrink-0">
                        <i class="fas fa-exclamation-triangle text-2xl text-red-500"></i>
                    </div>
                    <div class="ml-3">
                        <h3 class="text-lg font-semibold text-red-800">Atenção!</h3>
                        <p class="text-sm text-red-600">
                            Esta ação não pode ser desfeita. Todos os seus dados serão permanentemente excluídos.
                        </p>
                    </div>
                </div>

                <div class="mt-4 space-y-4">
                    <p class="text-sm text-red-600">
                        Ao excluir sua conta, você perderá permanentemente:
                    </p>

                    <ul class="list-disc list-inside text-sm text-red-600 space-y-2">
                        <li>Todas as suas avaliações e comentários</li>
                        <li>Seus restaurantes cadastrados</li>
                        <li>Suas fotos e mídias</li>
                        <li>Seu histórico de atividades</li>
                        <li>Todas as suas configurações e preferências</li>
                    </ul>

                    <form action="{{ route('profile.destroy') }}" method="POST" class="mt-6">
                        @csrf
                        @method('DELETE')

                        <div class="space-y-4">
                            <!-- Confirmação -->
                            <div>
                                <label for="password" class="block text-sm font-medium text-red-700 mb-1">
                                    Digite sua senha para confirmar
                                </label>
                                <input type="password" name="password" id="password" required
                                       class="w-full @error('password') border-red-500 @enderror">
                                @error('password')
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Botões -->
                            <div class="flex justify-end space-x-4">
                                <a href="{{ route('profile.edit') }}" class="btn-secondary">
                                    Cancelar
                                </a>
                                <button type="submit" class="btn-danger">
                                    <i class="fas fa-trash-alt mr-2"></i> Excluir Minha Conta
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
