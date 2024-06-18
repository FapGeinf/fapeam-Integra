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
      <div class="loginTitle">
        <span>Login</span>
      </div>
      

      <div class="login-content">
        <form method="POST" action="{{ route('login') }}">
          @csrf

        <div class="input-icon">
          <input id="email" class="inputImp @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" placeholder="Insira seu Email" required autocomplete="email" autofocus>
          <i class="fas fa-user"></i>

          @error('email')
          <span class="invalid-feedback" role="alert">
            <strong>{{ $message }}</strong>
          </span>
          @enderror
        </div>
        

        <div class="input-icon">
          <input id="password" type="password" class="inputImp inputSenha @error('password') is-invalid @enderror " name="password" required autocomplete="current-password" placeholder="Senha">
          <i class="fas fa-lock"></i>

          @error('password')
          <span class="invalid-feedback" role="alert">
            <strong>{{ $message }}</strong>
          </span>
          @enderror
        </div>

        <span>
          <input type="checkbox" id="" name="remember_me" value="remember_me">
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
