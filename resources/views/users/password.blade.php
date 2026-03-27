@extends('layouts.app')
@section('title') {{'Alterar Senha'}} @endsection
@section('content')

<link rel="stylesheet" href="{{ asset('css/main.css') }}">
<link rel="stylesheet" href="{{ asset('css/show.css') }}">
<link rel="stylesheet" href="{{ asset('css/buttons.css') }}">

<div class="container pt-5" style="max-width: 500px;">
  <div class="col-12 border box-shadow">
    <form action="{{ route('users.password') }}" method="POST">
      @csrf

      <fieldset>
        <h5 class="text-center">Alterar Senha</h5>

        <div class="form-group mb-4">
          <label for="oldPasswordInput">Senha Atual:</label>
          <input name="old_password" type="password" class="form-control input-enabled @error('old_password') is-invalid @enderror" id="oldPasswordInput">

          @error('old_password')
            <span class="text-danger">{{ $message }}</span>
          @enderror
        </div>

        <div class="form-group mb-4">
          <label for="newPasswordInput">Nova senha:</label>
          <input name="new_password" type="password" class="form-control input-enabled @error('new_password') is-invalid @enderror" id="newPasswordInput">

          @error('new_password')
            <span class="text-danger">{{ $message }}</span>
          @enderror
        </div>

        <div class="form-group mb-4">
          <label for="confirmNewPasswordInput" class="">Confirme a nova senha:</label>
          <input name="new_password_confirmation" type="password" class="form-control input-enabled" id="confirmNewPasswordInput">
        </div>

        <div class="form-group mt-4 text-end">
          <button class="highlighted-btn-sm highlight-success">
            <i class="bi bi-save2 me-1"></i>
            Salvar
          </button>
        </div>

      </fieldset>
    </form>
  </div>
</div>

<x-back-button/>
@endsection
