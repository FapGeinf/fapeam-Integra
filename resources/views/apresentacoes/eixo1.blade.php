@extends('layouts.app')
@section('title') {{ 'Eixo I - Comprometimento e Apoio da Alta Direção' }} @endsection
@section('content')

  <link rel="stylesheet" href="{{asset('css/main.css')}}">
  <link rel="stylesheet" href="{{asset('css/buttons.css')}}">

  <main class="container my-4 pt-5" style="max-width: 800px;">
    <h1 class="h5 mb-3 text-center">Eixo I - Comprometimento e Apoio da Alta Direção</h1>

    <div class="card box-shadow" style="margin-bottom: 15px;">
      <div class="card-body p-2">
        <div class="mb-0">
          <p class="lh-lg">Apoiar o Programa de Integridade é um compromisso da alta direção da FAPEAM no combate à
            corrupção, na prestação de serviços públicos com mais qualidade e para a conduta ética em todas as operações e
            relações institucionais. </p>

          <p class="lh-lg">Este é um eixo essencial para a implementação eficaz do Programa de Integridade da FAPEAM, e
            garante que os princípios de transparência, responsabilidade e conformidade sejam incorporados à cultura
            organizacional, fortalecendo a governança e consolidando empenho em assegurar que os recursos públicos sejam
            geridos com responsabilidade e eficiência, de acordo com as normas legais, regulatórias e os valores
            institucionais.</p>
        </div>
      </div>
    </div>
  </main>

  @if(auth()->user()->unidade->unidadeTipoFK == 1 || auth()->user()->unidade->unidadeTipoFK == 3 || auth()->user()->unidade->unidadeTipoFK == 4)
    <div class="d-flex justify-content-center gap-2 flex-wrap">
      {{-- Relatório --}}
      <a href="{{ route('relatorios.eixos', ['id' => 1]) }}" class="highlighted-btn-sm highlight-blue text-decoration-none">
        <i class="bi bi-list-columns-reverse"></i>
        Relatório
      </a>

      
      <form action="{{ route('atividades.index') }}" method="POST" class="d-inline">
        @csrf
        <input type="hidden" name="eixo_id" value="1">
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
              href="{{ route('atividades.executadas', ['eixo_id' => $eixo_id ?? 1]) }}">
              <i class="bi bi-check-circle-fill text-success"></i>
              Executadas
            </a>
          </li>
          <li>
            <a class="dropdown-item d-flex align-items-center gap-2"
              href="{{ route('atividades.acompanhamento', ['eixo_id' => $eixo_id ?? 1]) }}">
              <i class="bi bi-arrow-repeat text-info"></i>
              Em Acompanhamento
            </a>
          </li>
          <li>
            <a class="dropdown-item d-flex align-items-center gap-2"
              href="{{ route('atividades.nao-executadas', ['eixo_id' => $eixo_id ?? 1]) }}">
              <i class="bi bi-x-circle-fill text-warning"></i>
              Não Executadas
            </a>
          </li>
        </ul>
      </div>

    
      <form action="{{ route('indicadores.index') }}" method="POST" class="d-inline">
        @csrf
        <input type="hidden" name="eixo_id" value="1">
        <button type="submit" class="highlighted-btn-sm highlight-blue">
          <i class="bi bi-reception-4"></i>
          Indicadores
        </button>
      </form>
    </div>
  @endif
@endsection