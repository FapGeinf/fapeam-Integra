@extends('layouts.app')
@section('title') {{ 'Eixo VI - Canais de Denúncia' }} @endsection
@section('content')

  <link rel="stylesheet" href="{{asset('css/main.css')}}">
  <link rel="stylesheet" href="{{asset('css/buttons.css')}}">

  <main class="container my-4 pt-5" style="max-width: 800px;">
    <h1 class="h5 mb-3 text-center">Eixo VI - Canais de Denúncia</h1>

    <div class="card box-shadow" style="margin-bottom: 15px;">
      <div class="card-body p-2">
        <div class="mb-0">
          <p class="lh-lg">
            A FAPEAM disponibiliza canais de denúncia para acesso da sociedade em geral para relatar atos ou fatos que
            envolvam desvios éticos e de integridade de agentes públicos e insatisfações institucionais.
          </p>

          <p class="lh-lg">
            A Ouvidoria é o canal de relacionamento direto, não burocrático, que recebe, analisa, seleciona e encaminha
            aos setores competentes, pedidos de informações, dúvidas, denúncias, reclamações, críticas, opiniões,
            sugestões e elogios, respondendo-os em tempo hábil e sugerindo mudanças nos procedimentos e ações da FAPEAM.
          </p>
        </div>
      </div>
    </div>
  </main>

  <div class="d-flex justify-content-center gap-2">
    @if(auth()->user()->unidade->unidadeTipoFK == 1 || auth()->user()->unidade->unidadeTipoFK == 3 || auth()->user()->unidade->unidadeTipoFK == 4)
      <a href="{{ route('relatorios.eixos', ['id' => 6]) }}" class="highlighted-btn-sm highlight-blue text-decoration-none">
        <i class="bi bi-list-columns-reverse"></i>
        Relatório
      </a>

      <a href="{{ route('atividades.index', ['eixo_id' => 6]) }}">
        <button class="highlighted-btn-sm highlight-blue">
          <i class="bi bi-file-text"></i>
          Todas Atividades do Eixo
        </button>
      </a>

      <div class="dropdown d-inline-block">
        <button class="highlighted-btn-sm highlight-blue dropdown-toggle text-decoration-none border-0" type="button"
          id="dropdownStatusEixo" data-bs-toggle="dropdown" aria-expanded="false">
          <i class="bi bi-filter-square me-1"></i> Atividades do Eixo por Status
        </button>

        <ul class="dropdown-menu dropdown-menu-end shadow" aria-labelledby="dropdownStatusEixo">
          <li>
            <a class="dropdown-item d-flex align-items-center gap-2"
              href="{{ route('atividades.executadas', ['eixo_id' => $eixo_id ?? 6]) }}">
              <i class="bi bi-check-circle-fill text-success"></i>
              Executadas
            </a>
          </li>
          <li>
            <a class="dropdown-item d-flex align-items-center gap-2"
              href="{{ route('atividades.acompanhamento', ['eixo_id' => $eixo_id ?? 6]) }}">
              <i class="bi bi-arrow-repeat text-info"></i>
              Em Acompanhamento
            </a>
          </li>
          <li>
            <a class="dropdown-item d-flex align-items-center gap-2"
              href="{{ route('atividades.nao-executadas', ['eixo_id' => $eixo_id ?? 6]) }}">
              <i class="bi bi-x-circle-fill text-warning"></i>
              Não Executadas
            </a>
          </li>
        </ul>
      </div>

      <form action="{{ route('indicadores.index') }}" method="POST" class="d-inline">
        @csrf

        <input type="hidden" name="eixo_id" value="6">
        <button type="submit" class="highlighted-btn-sm highlight-blue">
          <i class="bi bi-reception-4"></i>
          Indicadores
        </button>
      </form>
    @endif
  </div>
@endsection