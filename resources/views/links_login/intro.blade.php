@extends('layouts.app')

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <link rel="stylesheet" href="{{asset('css/home.css')}}">
  <link rel="shortcut icon" href="{{ asset('img/logoDeconWhiteMin.png') }}">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.3.0/font/bootstrap-icons.css">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
  <title>Íntegra | Início</title>
</head>

<body class="login-page">

  <div class="grid">
    <div class="order__right centered no__overflow borderRadius">

      {{-- <a href="{{ route('documentos.eixos') }}" class="arrowButton">
        <i class="bi bi-arrow-90deg-right"></i> Ir para pagina de Eixos
      </a> --}}
  
      <img src="{{asset('img/Decon/bloco3.png')}}" class="imgBloco" alt="">

      <div class="links">
        
        <a class="fw-bold" href="{{ route('apresentacao') }}">
          <div class="linksChild">
            Apresentação
          </div>
        </a>
        
        <a class="fw-bold" href="{{ route('legislacao') }}">
          <div class="linksChild">
            Legislação
          </div>
        </a>
  
        <a class="fw-bold" href="{{ route('manual') }}">
          <div class="linksChild">
            Manual
          </div>
        </a>
      </div>
      
    </div>
  </div>

</body>
</html>