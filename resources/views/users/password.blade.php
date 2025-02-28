@extends('layouts.app')

@section('title') {{'Alterar Senha'}} @endsection

@section('content')

<head>
  <link rel="stylesheet" href="{{ asset('css/store.css') }}">

  <style>
    body {
      background-image: url('/img/bg-white.jpg');
      background-size: cover;
    }
  </style>
</head>

<div class="container d-flex justify-content-center" style="margin-top: 5rem;">
  <div class="card col-6 border-1 shadow">
    <div class="card-body">
      <form action="{{ route('users.password') }}" method="POST">
        @csrf

        <fieldset>
          <h3 class="mb-4 text-center">Alterar Senha</h3>
            @if (session('status'))
              <div class="alert alert-success" role="alert">
                {{ session('status') }}
              </div>
            @elseif (session('error'))
              <div class="alert alert-danger" role="alert">
                {{ session('error') }}
              </div>
            @endif

          <div class="form-group mb-4">
            <label for="oldPasswordInput">Senha Atual:</label>
            <input name="old_password" type="password" class="form-control @error('old_password') is-invalid @enderror" id="oldPasswordInput">
              @error('old_password')
                <span class="text-danger">{{ $message }}</span>
              @enderror
          </div>

          <div class="form-group mb-4">
            <label for="newPasswordInput">Nova senha:</label>
            <input name="new_password" type="password" class="form-control @error('new_password') is-invalid @enderror" id="newPasswordInput">
              @error('new_password')
                <span class="text-danger">{{ $message }}</span>
              @enderror
          </div>

          <div class="form-group mb-4">
            <label for="confirmNewPasswordInput" class="">Confirme a nova senha:</label>
            <input name="new_password_confirmation" type="password" class="form-control" id="confirmNewPasswordInput">
          </div>

          <div class="form-group mt-4 text-center">
            <button class="btnAdd">Salvar</button>
          </div>

        </fieldset>
      </form>
    </div>
  </div>
</div>

<x-back-button/>
@endsection
