@extends('layouts.app')
@section('content')

@section('title') {{ 'Avaliação de Riscos' }}
@endsection

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  @vite(['resources/sass/app.scss', 'resources/js/app.js'])
  <link rel="stylesheet" href="{{ asset('css/eixosPages.css') }}">
  
  <style>
    @import url('https://fonts.googleapis.com/css2?family=Poppins&display=swap');

    a {
      color: #2272b9;
    }

    .poppins-regular {
      font-family: "Poppins", serif;
      font-weight: 400;
      font-style: normal;
    }

    .pb__dropdown {
      padding-bottom: 4rem;
    }

    .bi-key,
    .bi-door-open {
      margin-left: 0 !important;
    }
  </style>
</head>

<body class="poppins-regular">
  <div class="form-wrapper pt-5">
    <div class="form_create border">
      <div class="titleDP text-center fw-bold">
        <span>
          EIXO III - AVALIAÇÃO DE RISCOS
        </span>
      </div>
    </div>
  </div>

  <div class="form-wrapper pt-3">
    <div class="form_create border">
      <div class="textDP text__justify">
        <p>
          A avaliação de riscos é um dos eixos do Programa de Integridade da FAPEAM. O diagnóstico e tratamento desses riscos é realizado com base nas recomendações da Controladoria Geral da União <span class="">(CGU e da ISO 31.000/2009)</span>.
        </p>

        <p>
          Ações ou omissões que possam favorecer a ocorrência de fraudes ou atos de corrupção, podendo se configurar em causa, evento ou consequência de outros riscos, tais como financeiros, operacionais ou de imagem são riscos à integridade <span class="">(Portaria CGU nº 1089/2018)</span>.
        </p>
      </div>
    </div>
  </div>

  <div class="d-flex justify-content-center mt-4">
  @if(auth()->user()->unidade->unidadeTipoFK == 1 || auth()->user()->unidade->unidadeTipoFK == 5 || auth()->user()->unidadeTipoFK == 2)
  <form action="{{ route('atividades.index') }}" method="POST" class="d-inline">
      @csrf
      <input type="hidden" name="eixo_id" value="3">
      <button type="submit" class="btn__bg btn__bg_color shadow-sm fw-bold text-decoration-none text-center">
        Atividades
      </button>
    </form>
    @endif
		<button class="btn__bg btn__bg_color shadow-sm fw-bold text-decoration-none text-center">Relatório</button>
  </div>

</body>

</html>

@endsection