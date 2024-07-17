@extends('layouts.app')
@section('content')
@section('title') {{ 'Registro' }} @endsection

<!DOCTYPE html>
<html lang="pt-BR">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <script src="/ckeditor/ckeditor.js"></script>
  <link rel="stylesheet" href="{{ asset('css/edit.css') }}">
  <link rel="stylesheet" href="{{ asset('css/removeGlobalConfig.css') }}">
  <link rel="stylesheet" href="{{ asset('css/removeConfigRegister.css') }}">
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-JzjS1k8F7FqhVfoJ6s5zjxuZkAdyjs2p8V3+OIcXwpjFgtVJ94k1tg4GfXoV6Ikv" crossorigin="anonymous">
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.16/jquery.mask.min.js"></script>
</head>

<div class="form-wrapper">
  <div class="form_create">
    <h3 style="text-align: center; margin-bottom:5px;">
      Registrar Novo Usuário
    </h3>

    <form method="POST" action="{{ route('register') }}">
      @csrf
      <div class="row g-3">
        <div class="col-sm-12 col-md-12">
          <label for="name">Nome:</label>
          <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required autocomplete="name" placeholder="ex: Julliany Souza de Lima" autofocus>

          @error('name')
            <span class="invalid-feedback" role="alert">
              <strong>{{ $message }}</strong>
            </span>
          @enderror
        </div>
      </div>

      <div class="row g-3">
        <div class="col-sm-6 col-md-6">
          <label for="cpf">CPF:</label>
          <input id="cpf" type="text" class="form-control @error('cpf') is-invalid @enderror" name="cpf" value="{{ old('cpf') }}" required autocomplete="cpf" placeholder="000.000.000-00">

          @error('cpf')
            <span class="invalid-feedback" role="alert">
              <strong>{{ $message }}</strong>
            </span>
          @enderror
        </div>

        <div class="col-sm-6 col-md-6">
          <label for="email">Email:</label>
          <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" placeholder="email@email.com">

          @error('email')
            <span class="invalid-feedback" role="alert">
              <strong>{{ $message }}</strong>
            </span>
          @enderror
        </div>
      </div>

      <div class="row g-3">
        <div class="col-sm-12 col-md-12">
          <label for="unidadeIdFK">Unidade:</label>
          <select name="unidadeIdFK" id="unidadeIdFK" class="form-control form-select @error('unidadeIdFK') is-invalid @enderror">
            @foreach($unidades as $unidade)
            <option value="{{ $unidade->id }}">{{ $unidade->unidadeNome }}</option>
            @endforeach
          </select>

          @error('unidadeIdFK')
            <span class="invalid-feedback" role="alert">
              <strong>{{ $message }}</strong>
            </span>
          @enderror
        </div>
      </div>

      <div class="row g-3">
        <div class="col-sm-6 col-md-6">
          <label for="password">Senha:</label>
          <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password" placeholder="Mínimo de 8 caracteres (letras e números)">

          @error('password')
            <span class="invalid-feedback" role="alert">
              <strong>{{ $message }}</strong>
            </span>
          @enderror
        </div>

        <div class="col-sm-6 col-md-6">
          <label for="password-confirm">Repita a senha:</label>
          <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password" placeholder="Repita a senha anterior">
        </div>
      </div>
      
      <div class="text-center mt-5">
       <button type="submit" class="green-btn">Registrar</button> 
      </div>
      
    </form>

  </div>
</div>
@endsection
