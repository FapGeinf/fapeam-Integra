@extends('layouts.app')
@section('content')

@section('title') {{ 'Canais de Denúncia' }}
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

    /* .pb__dropdown {
      padding-bottom: 4rem;
    } */

    .bi-key,
    .bi-door-open {
      /* margin-left: 0 !important; */
    }
  </style>
</head>

<body class="poppins-regular">
  <div class="form-wrapper pt-5">
    <div class="form_create border">
      <div class="titleDP text-center fw-bold">
        <span>
          EIXO VI - CANAIS DE DENÚNCIA
        </span>
      </div>
    </div>
  </div>

  <div class="form-wrapper pt-3">
    <div class="form_create border">
      <div class="textDP text__justify">
        <p>
          A FAPEAM disponibiliza canais de denúncia para acesso da sociedade em geral para relatar atos ou fatos que envolvam desvios éticos e de integridade de agentes públicos e insatisfações institucionais.
        </p>

        <p>
          A Ouvidoria é o canal de relacionamento direto, não burocrático, que recebe, analisa, seleciona e encaminha aos setores competentes, pedidos de informações, dúvidas, denúncias, reclamações, críticas, opiniões, sugestões e elogios, respondendo-os em tempo hábil e sugerindo mudanças nos procedimentos e ações da FAPEAM. 
        </p>
      </div>
    </div>
  </div>

  <div class="d-flex justify-content-center mt-4">
  @if(auth()->user()->unidade->unidadeTipoFK == 1 || auth()->user()->unidade->unidadeTipoFK == 5 || auth()->user()->unidadeTipoFK == 2)
    <a href="{{ route('atividades.index', ['eixo_id' => 6]) }}">
      <button class="btn__bg btn__bg_color shadow-sm fw-bold text-decoration-none text-center">Atividades</button>
    </a>
 

	<form action="{{ route('indicadores.index') }}" method="POST" class="d-inline">
			@csrf
			<input type="hidden" name="eixo_id" value="6">
			<button type="submit" class="btn__bg btn__bg_color shadow-sm fw-bold">
					Indicadores
			</button>
		</form>
		<button class="btn__bg btn__bg_color shadow-sm fw-bold text-decoration-none text-center">Relatório</button>
  </div>
  @endif

</body>

</html>

@endsection