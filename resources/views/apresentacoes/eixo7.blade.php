@extends('layouts.app')
@section('content')

@section('title') {{ 'Investigações Internas' }}
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
          EIXO VII - INVESTIGAÇÕES INTERNAS
        </span>
      </div>
    </div>
  </div>

  <div class="form-wrapper pt-3">
    <div class="form_create border">
      <div class="textDP text__justify">
        <p>
          As investigações internas são indispensáveis para construção de uma cultura de integridade, objetivando verificar a ocorrência de materialidade e autoria de casos de conduta ilegal ou contra as políticas da FAPEAM, identificar as partes envolvidas e aplicar sanções cabíveis e adotar medidas de remediação para evitar a ocorrência de atos similares, em atenção ao disposto na IN N° 02/2022-CGE/AM.
        </p>

        <p>
          A FAPEAM aprovou, por meio da Resolução 034/2023-CD/FAPEAM, o Manual Prático de Sindicância Disciplinar, que é um documento orientador, elaborado com base nos preceitos constitucionais, nas Leis Estaduais Nº 1.762/1986 e Nº 8.112/1990 e no Manual de Processo Administrativo Disciplinar da Controladoria Geral da União (CGU, Ed. 2021).
        </p>
      </div>
    </div>
  </div>

  <div class="d-flex justify-content-center mt-4">
  @if(auth()->user()->unidade->unidadeTipoFK == 1 || auth()->user()->unidade->unidadeTipoFK == 5 || auth()->user()->unidadeTipoFK == 2)
    <a href="{{ route('atividades.index', ['eixo_id' => 7]) }}">
      <button class="btn__bg btn__bg_color shadow-sm fw-bold text-decoration-none text-center">Atividades</button>
    </a>
  @endif
	<form action="{{ route('indicadores.index') }}" method="POST" class="d-inline">
			@csrf
			<input type="hidden" name="eixo_id" value="7">
			<button type="submit" class="btn__bg btn__bg_color shadow-sm fw-bold">
					Indicadores
			</button>
		</form>
		<button class="btn__bg btn__bg_color shadow-sm fw-bold text-decoration-none text-center">Relatório</button>
  </div>
</body>

</html>

@endsection