@extends('layouts.app')
@section('content')

@section('title') {{ 'Implementação de Controles Internos' }}
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
          EIXO IV - IMPLEMENTAÇÃO DE CONTROLES INTERNOS
        </span>
      </div>
    </div>
  </div>

  <div class="form-wrapper pt-3">
    <div class="form_create border">
      <div class="textDP text__justify">
        <p>
          O controle interno visa assegurar o cumprimento das diretrizes e o fortalecimento da cultura de compliance e integridade, além de agregar valor e contribuir para a melhoria das operações da FAPEAM, auxiliando no alcance dos objetivos e metas institucionais, a partir da abordagem sistemática para avaliar e melhorar a eficácia dos processos de governança e gerenciamento de riscos.
        </p>
      </div>
    </div>
  </div>

  <div class="d-flex justify-content-center mt-4">
  @if(auth()->user()->unidade->unidadeTipoFK == 1 || auth()->user()->unidade->unidadeTipoFK == 5 || auth()->user()->unidadeTipoFK == 2)
    <form action="{{ route('atividades.index') }}" method="POST" class="d-inline">
      @csrf
      <input type="hidden" name="eixo_id" value="4">
      <button type="submit" class="btn__bg btn__bg_color shadow-sm fw-bold text-decoration-none text-center">
        Atividades
      </button>
    </form>
    @endif

		
		<form action="{{ route('indicadores.index') }}" method="POST" class="d-inline">
			@csrf
			<input type="hidden" name="eixo_id" value="4">
			<button type="submit" class="btn__bg btn__bg_color shadow-sm fw-bold">
					Indicadores
			</button>
		</form>

    <a href="{{ route('riscos.index') }}">
      <button class="btn__bg btn__bg_color shadow-sm fw-bold text-decoration-none text-center">
        Monitoramentos
      </button>
    </a>
    <button class="btn__bg btn__bg_color shadow-sm fw-bold text-decoration-none text-center">Relatório</button>
  </div>

</body>

</html>

@endsection