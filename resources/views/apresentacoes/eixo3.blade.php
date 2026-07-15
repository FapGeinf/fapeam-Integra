@extends('layouts.app')
@section('title') {{ 'Eixo III - Avaliação de Riscos' }} @endsection
@section('content')

  <link rel="stylesheet" href="{{asset('css/main.css')}}">
  <link rel="stylesheet" href="{{asset('css/buttons.css')}}">

  <main class="container my-4 pt-5" style="max-width: 800px;">
    <h1 class="h5 mb-3 text-center">Eixo III - Avaliação de Riscos</h1>

    <div class="card box-shadow" style="margin-bottom: 15px;">
      <div class="card-body p-2">
        <div class="mb-0">
          <p class="lh-lg">
            A avaliação de riscos é um dos eixos do Programa de Integridade da FAPEAM. O diagnóstico e tratamento desses
            riscos é realizado com base nas recomendações da Controladoria Geral da União <span>(CGU e da ISO
              31.000/2009)</span>.
          </p>

          <p class="lh-lg">
            Ações ou omissões que possam favorecer a ocorrência de fraudes ou atos de corrupção, podendo se configurar em
            causa, evento ou consequência de outros riscos, tais como financeiros, operacionais ou de imagem são riscos à
            integridade <span>(Portaria CGU nº 1089/2018)</span>.
          </p>
        </div>
      </div>
    </div>
  </main>

  <div class="d-flex justify-content-center gap-2">
    @if(auth()->user()->unidade->unidadeTipoFK == 1 || auth()->user()->unidade->unidadeTipoFK == 3 || auth()->user()->unidade->unidadeTipoFK == 4)
      <a href="{{ route('relatorios.eixos', ['id' => 3]) }}" class="highlighted-btn-sm highlight-blue text-decoration-none">
        <i class="bi bi-list-columns-reverse"></i>
        Relatório
      </a>

      <form action="{{ route('atividades.index') }}" method="POST" class="d-inline">
        @csrf

        <input type="hidden" name="eixo_id" value="3">
        <button type="submit" class="highlighted-btn-sm highlight-blue">
          <i class="bi bi-file-text"></i>
           Todas Atividades do Eixo
        </button>
      </form>

      <div class="dropdown d-inline-block">
        <button class="highlighted-btn-sm highlight-blue dropdown-toggle text-decoration-none border-0" type="button"
          id="dropdownStatusEixo" data-bs-toggle="dropdown" aria-expanded="false">
          <i class="bi bi-filter-square me-1"></i> Atividades do Eixo por Status
        </button>

        <ul class="dropdown-menu dropdown-menu-end shadow" aria-labelledby="dropdownStatusEixo">
          <li>
            <a class="dropdown-item d-flex align-items-center gap-2"
              href="{{ route('atividades.executadas', ['eixo_id' => $eixo_id ?? 3]) }}">
              <i class="bi bi-check-circle-fill text-success"></i>
              Executadas
            </a>
          </li>
          <li>
            <a class="dropdown-item d-flex align-items-center gap-2"
              href="{{ route('atividades.acompanhamento', ['eixo_id' => $eixo_id ?? 3]) }}">
              <i class="bi bi-arrow-repeat text-info"></i>
              Acompanhamento
            </a>
          </li>
          <li>
            <a class="dropdown-item d-flex align-items-center gap-2"
              href="{{ route('atividades.nao-executadas', ['eixo_id' => $eixo_id ?? 3]) }}">
              <i class="bi bi-x-circle-fill text-warning"></i>
              Não Executadas
            </a>
          </li>
        </ul>
      </div>

      <form action="{{ route('indicadores.index') }}" method="POST" class="d-inline">
        @csrf
        <input type="hidden" name="eixo_id" value="3">
        <button type="submit" class="highlighted-btn-sm highlight-blue">
          <i class="bi bi-reception-4"></i>
          Indicadores
        </button>
      </form>

      <a href="{{ route('avaliacao') }}" class="highlighted-btn-sm highlight-blue text-decoration-none">
        <i class="bi bi-download"></i>
        Diagnóstico de Riscos
      </a>
    @endif

    <a href="{{ route('riscos.analise') }}">
      <button class="highlighted-btn-sm highlight-blue">
        <i class="bi bi-box-arrow-in-up-right"></i>
        Análise do Risco
      </button>
    </a>
  </div>
@endsection