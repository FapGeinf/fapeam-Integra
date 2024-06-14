@extends('layouts.app')
@section('content')

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>Document</title>
  <link rel="stylesheet" href="{{asset('css/login.css')}}">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
</head>
<body>
    
<div class="mainContainer">
  <div class="secContainer">
    
  </div>

  <div class="secContainer">
    
    <div class="login">
      <div class="loginTitle">
        <span>Login</span>
      </div>
      

      <div class="login-content">

        <div class="input-icon">
          <input class="inputImp" placeholder="Email ou CPF">
          <i class="fas fa-user"></i>
        </div>
        
        <div class="input-icon">
          <input class="inputImp" type="password" id="password" placeholder="Senha">
          <i class="fas fa-lock"></i>
        </div>
        
      </div>

      <div class="loginButton">
        <input class="" type="submit" value="Entrar">
      </div>
      

      <div class="helpButtons">
        <a href="#">Esqueceu sua senha?</a>
        
      </div>
      <span>Primeiro acesso? </span><a href="#">Abra um chamado</a>
      
    </div>
  </div>
</div>
</body>
</html>
  
@endsection
