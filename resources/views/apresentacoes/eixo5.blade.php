@extends('layouts.app')
@section('content')

@section('title') {{ 'Comunicação e Treinamentos Periódicos' }}
@endsection

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  @vite(['resources/sass/app.scss', 'resources/js/app.js'])
  <link rel="stylesheet" href="{{ asset('css/eixosPages.css') }}">

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
          Eixo V - COMUNICAÇÃO E TREINAMENTOS PERIÓDICOS
        </span>
      </div>
    </div>
  </div>

  <div class="form-wrapper pt-3">
    <div class="form_create border">
      <div class="textDP text__justify">
        <p>
          As ações de comunicação do Programa de Integridade abrangem todas as iniciativas destinadas a levar aos colaboradores e parceiros institucionais, os valores do órgão, comunicar as regras e padrões éticos, bem como estimular comportamentos alinhados à moral, ao respeito às leis e à integridade pública (IN Nº 02/2022-CGE/AM).
        </p>

        <p>
          Comunicação Interna: direcionada aos colaboradores da FAPEAM para disseminação de uma cultura da integridade e conduta ética e moral. Ferramentas de comunicação são utilizadas nessas atividades, tais como: e-mails, cartilhas, podcasts, palestras, capacitação, wallpapers, entre outras.
        </p>

        <p>
          Comunicação Público Externo: a FAPEAM disponibiliza no site institucional as plataformas de Acesso à Informação, Transparência Institucional e do Programa de Dados Abertos 2023-2025, bem como acompanha o cumprimento da Lei Estadual 4.730/2018.
        </p>
      </div>
    </div>
  </div>

  <div class="d-flex justify-content-center mt-4">
    <form action="{{ route('atividades.index') }}" method="POST" class="d-inline">
      @csrf
      <input type="hidden" name="eixo_id" value="5">

      <button type="submit" class="btn__bg btn__bg_color shadow-sm fw-bold text-decoration-none text-center">
        Atividades
      </button>
    </form>

		<button class="btn__bg btn__bg_color shadow-sm fw-bold text-decoration-none text-center">Relatório</button>
  </div>

</body>

</html>

@endsection