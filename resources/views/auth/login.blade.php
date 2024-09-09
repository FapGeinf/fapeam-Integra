@extends('layouts.app')

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
	<link href="https://fonts.googleapis.com/css2?family=Poppins&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="{{asset('css/login.css')}}">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">

	<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.16/jquery.mask.min.js"></script>

	<script>
    $(document).ready(function(){
      $('#cpf').mask('000.000.000-00', {reverse: true});
      $('form').submit(function() {
        let cpf = $('#cpf').val().replace(/\D/g,'');
        $('#cpf').val(cpf);
      });
    });
  </script>
</head>

@section('title') {{'Login'}} @endsection

@section('content')
<body class="login-page">

 <div class="grid">
  <div class="order__right centered no__overflow borderRadius">

    <div class="links">
      <div class="linksChild">
        <i class="fas fa-tv"></i>
        <a href="{{ route('apresentacao') }}">Apresentação</a>
      </div>
      
      <div class="linksChild">
        <i class="fas fa-balance-scale"></i>
        <a href="{{ route('legislacao') }}">Legislação</a>
      </div>

      <div class="linksChild">
        <i class="fas fa-book"></i>
        <a href="{{ route('tutorial') }}">Tutorial</a>
      </div>
    </div>

     <img class="img" src="{{ asset('img/login/background-7.png') }}" alt="picture">
  </div>
  
  <div class="order__left centered">
     <div class="form" style="width: 380px;">
      <form method="POST" action="{{ route('login') }}">
        @csrf
        <div class="logo">
          <img src="{{ asset('img/logoDecon-nobg.png') }}" alt="Banner Íntegra" style="margin-bottom: 3rem;">
        </div>

        <div class="input-icon">
          <input id="cpf" type="tel" class="inputImp @error('cpf') is-invalid @enderror" name="cpf" value="{{ old('cpf') }}" placeholder="Insira seu CPF" autocomplete="cpf" autofocus required>
          <i class="fas fa-user"></i>

          @error('cpf')
          <span class="invalid-feedback" role="alert">
            <strong>Usuário não encontrado</strong>
          </span>
          @enderror
        </div>

        <div class="input-icon">
          <input id="password" type="password" class="inputImp inputSenha @error('password') is-invalid @enderror " name="password" required autocomplete="current-password" placeholder="Senha">
          <i class="fas fa-lock"></i>

          @error('password')
          <span class="invalid-feedback" role="alert">
            <strong>Senha incorreta</strong>
          </span>
          @enderror
        </div>

        <div class="rememberMeDiv">
          <input type="checkbox" id="" name="remember_me" value="remember_me" style="margin-right: 3px">
          <label for="remember_me" class="rememberMe">Lembrar-me</label>
        </div>

        <div class="loginButton">
          <input class="inputLogin" type="submit" value="Entrar">
        </div>
      </form>

      <div class="loginFooter">
        <div class="helpButtons">
          <a href="http://10.10.3.252/glpi/">Esqueceu a senha?</a>
          <a href="http://10.10.3.252/glpi/">Primeiro Acesso?</a>
        </div> 
      </div>
      
      <div class="footerLogo">
        <span>&copy;2024 FAPEAM</span>
      </div>
    </div>
  </div>
</body>
@endsection