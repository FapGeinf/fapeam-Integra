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
    .pb__dropdown {
      padding-bottom: 4rem;
    }

    .bi-key,
    .bi-door-open {
      margin-left: 0 !important;
    }
  </style>
</head>

<body>
  <div class="form-wrapper pt-5">
    <div class="form_create border">
      <div class="titleDP text-center fw-bold">
        <span>
          Eixo I - COMPROMETIMENTO E APOIO DA ALTA DIREÇÃO
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
    <form action="{{ route('atividades.index') }}" method="POST" class="d-inline">
      @csrf
      <input type="hidden" name="eixo_id" value="1">
      <button type="submit" class="btn__bg btn__bg_color shadow-sm fw-bold text-decoration-none text-center">
        Atividades
      </button>
    </form>
    <button class="btn__bg btn__bg_color shadow-sm fw-bold text-decoration-none text-center">Relatório</button>
  </div>


</body>

</html>

@endsection