@extends('layouts.app')

<link rel="stylesheet" href="{{ asset('css/edit.css') }}">
<link rel="stylesheet" href="{{ asset('css/buttons.css') }}">

<script src="{{ asset('js/jquery-3.6.0.min.js') }}"></script>
<script src="{{ asset('js/mascaras/jquery.mask.min.js') }}"></script>
<script src="{{ asset('ckeditor/ckeditor.js') }}"></script>
<script src="{{ asset('js/auto-dismiss.js') }}"></script>
<script src="{{ asset('js/mascaras/cpfMascara.js') }}"></script>
<script src="{{ asset('js/users/insertUser.js') }}"></script>
<script src="{{ asset('js/bootstrap.bundle.min.js') }}"></script>

@section('content')

@if (session('error'))
    <script>
        alert('{{ session('error') }}');
    </script>
@endif

<div class="error-message alertShow pt-4">
    @if ($errors->any())
        <div class="alert alert-danger text-center auto-dismiss">
            @foreach ($errors->all() as $error)
                <span class="text-center">Houve um erro ao editar esse controle sugerido</span>
            @endforeach
        </div>
    @endif
</div>

<div class="form-wrapper1">
    <div class="form_create border">
        <h3 class="mb-4 text-center">
            Edição de Usuário
        </h3>

        <form action="{{ route('user.update', $user->id) }}" method="post" enctype="multipart/form-data" id="formInsertUser">
            @csrf
            @method('PUT')

            <div class="row g-3">
                <div class="col-12 col-sm-6">
                    <label for="name">Nome:</label>
                    <input type="text" class="form-control input-enabled" name="name" value="{{ old('name', $user->name) }}" required>
                    @error('name')
                        <p class="alert alert-danger">{{ $message }}</p>
                    @enderror
                </div>

                <div class="col-12 col-sm-6">
                    <label for="email">Email:</label>
                    <input type="email" class="form-control input-enabled" name="email" value="{{ old('email', $user->email) }}" required>
                    @error('email')
                        <p class="alert alert-danger">{{ $message }}</p>
                    @enderror
                </div>

                <div class="col-12 col-sm-6">
                    <label for="cpf">CPF:</label>
                    <input type="text" class="form-control input-enabled cpf" name="cpf" value="{{ old('cpf', $user->cpf) }}" required>
                    @error('cpf')
                        <p class="alert alert-danger">{{ $message }}</p>
                    @enderror
                </div>

                <div class="col-12 col-sm-6">
                    <label for="unidadeIdFK">Unidade:</label>
                    <select class="form-select input-enabled" name="unidadeIdFK" required>
                        <option value="" disabled>Selecione uma unidade</option>
                        @foreach ($unidades as $unidade)
                            <option value="{{ $unidade->id }}" {{ old('unidadeIdFK', $user->unidadeIdFK) == $unidade->id ? 'selected' : '' }}>
                                {{ $unidade->unidadeNome }}
                            </option>
                        @endforeach
                    </select>
                    @error('unidadeIdFK')
                        <p class="alert alert-danger">{{ $message }}</p>
                    @enderror
                </div>

                <div class="col-12 col-sm-6">
                    <label for="password">Senha: <small>(deixe em branco para não alterar)</small></label>
                    <input type="password" class="form-control input-enabled" name="password" autocomplete="new-password">
                    @error('password')
                        <p class="alert alert-danger">{{ $message }}</p>
                    @enderror
                </div>

                <div class="col-12 col-sm-6">
                    <label for="password_confirmation">Confirme a Senha:</label>
                    <input type="password" class="form-control input-enabled" name="password_confirmation" autocomplete="new-password">
                </div>
            </div>

            <hr class="mt-4 mx-auto">

            <div class="d-flex justify-content-end pt-2">
                <a href="{{ route('usuarios.index') }}" class="highlighted-btn-sm highlight-grey text-decoration-none me-2">Voltar</a>
                <button type="button" onclick="showConfirmationModal()" class="highlighted-btn-sm highlight-success">Salvar Alterações</button>
            </div>

            <!-- Modal de confirmação -->
            <div class="modal fade" id="confirmationModal" tabindex="-1" aria-labelledby="confirmationModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-lg modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="confirmationModalLabel">Confirmação de Edição</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>

                        <div class="modal-body">
                            <div id="modalContent">
                                {{-- Conteúdo gerado dinamicamente via JS --}}
                            </div>
                        </div>

                        <div class="modal-footer">
                            <button type="button" class="highlighted-btn-sm highlight-grey" data-bs-dismiss="modal">Voltar e corrigir</button>
                            <button type="button" id="btnConfirmSubmit" class="highlighted-btn-sm highlight-success" onclick="formSubmit()">Confirmar</button>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>

@endsection
