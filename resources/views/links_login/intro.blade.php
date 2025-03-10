@extends('layouts.app')
@section('content')

@section('title') {{ 'Início' }} @endsection

<link rel="stylesheet" href="{{asset('css/home.css')}}">
<link rel="shortcut icon" href="{{ asset('img/logoDeconWhiteMin.png') }}">

<body class="login-page">

  <div class="grid">
    <div class="order__right centered no__overflow borderRadius">

      {{-- <a href="{{ route('documentos.eixos') }}" class="arrowButton">
        <i class="bi bi-arrow-90deg-right"></i> Ir para pagina de Eixos
      </a> --}}
  
      {{-- <img src="{{asset('img/Decon/bloco4.png')}}" class="imgBloco" alt=""> --}}

      <div class="links">
        
        <a class="" href="{{ route('apresentacao') }}">
          <div class="linksChild">
            Apresentação
          </div>
        </a>
        
        <a class="" href="{{ route('legislacao') }}">
          <div class="linksChild">
            Legislação
          </div>
        </a>
  
        <a class="" href="{{ route('manual') }}">
          <div class="linksChild">
            Manual
          </div>
        </a>
      </div>

      <div class="links__a">
        <div class="linksChild__a">
          <a href="{{ route('documentos.intro') }}">Home</a>

          <span style="color: #fff">/</span>

          <a href="{{ route('documentos.eixos') }}">Eixos de Integridade</a>
        </div>

        <div class="linksChild__a">
          <a href="{{ route('historico') }}">Documentos</a>

          <span style="color: #fff">/</span>

          <a href="{{ route('relatorios.download') }}">Relatório Geral</a>
        </div>
      </div>
    </div>
  </div>

</body>
</html>
@endsection