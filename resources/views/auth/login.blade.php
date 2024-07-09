@extends('layouts.app')
@section('content')

@section('title') {{'Login'}} @endsection

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
	<link href="https://fonts.googleapis.com/css2?family=Poppins&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="{{asset('css/login.css')}}">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
</head>
<body>
    
<div class="mainContainer">
  <div class="">
    
  </div>

  <div class="secContainer">
    
    <div class="login">
      <div class="logoLogin">
        <img src="img/logoDecon.png" alt="">
      </div>
      
      <div class="login-content">
        <form method="POST" action="{{ route('login') }}">
          @csrf

          <!-- <div class="input-icon">
            <input id="email" class="inputImp @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" placeholder="Insira seu Email" required autocomplete="email" autofocus>
            <i class="fas fa-user"></i>

            @error('email')
            <span class="invalid-feedback" role="alert">
              <strong>{{ $message }}</strong>
            </span>
            @enderror
          </div> -->

					<div class="input-icon">
            <input id="cpf" maxlength="11" minlength="11" class="inputImp @error('cpf') is-invalid @enderror" name="cpf" value="{{ old('cpf') }}" placeholder="Insira seu CPF" required autocomplete="cpf" autofocus>
            <i class="fas fa-user"></i>

            @error('cpf')
            <span class="invalid-feedback" role="alert">
              <strong>{{ $message }}</strong>
            </span>
            @enderror
          </div>

					<!-- <label>CPF:</label>
        	<input id="cpf" maxlength="11" minlength="11" type="text" class="form-control inputField @error('cpf') is-invalid @enderror" name="cpf" value="{{ old('cpf') }}" required autocomplete="cpf" placeholder="Insira seu CPF">
        	@error('cpf')
         	 <span class="invalid-feedback" role="alert">
            	<strong>{{ $message }}</strong>
          	</span>
        	@enderror -->

          <div class="input-icon">
            <input id="password" type="password" class="inputImp inputSenha @error('password') is-invalid @enderror " name="password" required autocomplete="current-password" placeholder="Senha">
            <i class="fas fa-lock"></i>

            @error('password')
            <span class="invalid-feedback" role="alert">
              <strong>{{ $message }}</strong>
            </span>
            @enderror
          </div>

          <div class="rememberMeDiv">
            <input type="checkbox" id="" name="remember_me" value="remember_me" style="margin-right: 3px">
            <label for="remember_me" class="rememberMe">Lembrar-me</label>
          </span>
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
</div>
</body>
</html>
@endsection
