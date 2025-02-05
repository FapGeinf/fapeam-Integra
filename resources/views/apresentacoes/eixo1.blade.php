@extends('layouts.app')
@section('content')

@section('title') {{ 'Comprometimento e Apoio da Alta Direção' }}
@endsection

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  @vite(['resources/sass/app.scss', 'resources/js/app.js'])
  <link rel="stylesheet" href="{{ asset('css/eixosPages.css') }}">
  <title>COMPROMETIMENTO E APOIO DA ALTA DIREÇÃO</title>

  <style>
    @import url('https://fonts.googleapis.com/css2?family=Poppins&display=swap');

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

    a {
      color: #2272b9;
    }
  </style>
</head>

<body class="poppins-regular">
  <div class="form-wrapper pt-5">
    <div class="form_create border">
      <div class="titleDP text-center fw-bold">
        <span>
          EIXO I - COMPROMETIMENTO E APOIO DA ALTA DIREÇÃO
      </div>
    </div>
  </div>

  <div class="form-wrapper pt-3">
    <div class="form_create border">
      <div class="textDP text__justify">
        <span>
          <p>Apoiar o Programa de Integridade é um compromisso da alta direção da FAPEAM no combate à corrupção, na prestação de serviços públicos com mais qualidade e para a conduta ética em todas as operações e relações institucionais. </p>

          <p>Este é um eixo essencial para a implementação eficaz do Programa de Integridade da FAPEAM, e garante que os princípios de transparência, responsabilidade e conformidade sejam incorporados à cultura organizacional, fortalecendo a governança e consolidando empenho em assegurar que os recursos públicos sejam geridos com responsabilidade e eficiência, de acordo com as normas legais, regulatórias e os valores institucionais.</p>
        </span>
      </div>
    </div>
  </div>

  <div class="d-flex justify-content-center mt-4">
		@if(auth()->user()->unidade->unidadeTipoFK == 1 || auth()->user()->unidade->unidadeTipoFK == 5 || auth()->user()->unidade->unidadeTipoFK == 2)
			<form action="{{ route('atividades.index') }}" method="POST" class="d-inline">
				@csrf
				<input type="hidden" name="eixo_id" value="1">
				<button type="submit" class="btn__bg btn__bg_color shadow-sm fw-bold">
					Atividades
				</button>
			</form>
		@endif

		<form action="{{ route('indicadores.index') }}" method="POST" class="d-inline">
			@csrf
			<input type="hidden" name="eixo_id" value="1">
			<button type="submit" class="btn__bg btn__bg_color shadow-sm fw-bold">
					Indicadores
			</button>
		</form>
    <button class="btn__bg btn__bg_color shadow-sm fw-bold text-decoration-none text-center">Relatório</button>
  </div>
</body>

</html>

@endsection