@extends('layouts.app')
@section('title') {{ 'Documentos do Programa de Integridade' }} @endsection
@section('content')

<link rel="stylesheet" href="{{ asset('css/historico.css') }}">
<link rel="stylesheet" href="{{ asset('css/buttons.css') }}">
<link rel="stylesheet" href="{{ asset('css/main.css') }}">

<x-alert-toast/>

<div class="container pt-5" style="max-width: 600px;">
  <div class="col-12 border box-shadow">
    <h5 class="text-center mb-3">Documentos do Programa de Integridade</h5>

    @if(Auth::user()->usuario_tipo_fk == 1 || Auth::user()->usuario_tipo_fk == 2 || Auth::user()->usuario_tipo_fk == 4)
      <div class="d-flex justify-content-center gap-3 mb-4">
        <a href="{{ route('documentos.create') }}"
          class="highlighted-btn-sm highlight-blue text-decoration-none d-flex align-items-center">
          <i class="bi bi-plus-lg me-1"></i>
          Inserir Documento
        </a>
      </div>
    @endif

    <div class="accordion" id="accordionDocumentos">
      @foreach ($tiposDocumentos as $tipo)
        <div class="accordion-item">
          <h2 class="accordion-header" id="heading{{ $tipo->id }}">
            <button class="accordion-button text13 collapsed" type="button" data-bs-toggle="collapse"
              data-bs-target="#collapse{{ $tipo->id }}" aria-expanded="false"
              aria-controls="collapse{{ $tipo->id }}">
              {{ $tipo->nome }}
            </button>
          </h2>

          <div id="collapse{{ $tipo->id }}" class="accordion-collapse collapse"
            aria-labelledby="heading{{ $tipo->id }}" data-bs-parent="#accordionDocumentos">
            <div class="accordion-body" style="background-color: #fff; font-size: 13px !important;">
              @if (isset($documentosAgrupados[$tipo->id]))
                @foreach ($documentosAgrupados[$tipo->id] as $ano => $docsPorAno)
                  <div class="mb-2">
                    {{ $ano }}
                  </div>

                  @foreach ($docsPorAno as $documento)
                    <ul class="list-group">
                      <li class="list-group-item d-flex justify-content-between align-items-center">
                        <a href="{{ asset('storage/' . $documento->path) }}" target="_blank"
                          class="text-decoration-none text-truncate text13"
                          title="{{ basename($documento->path) }}">
                          {{ basename($documento->path) }}
                        </a>
                      </li>
                    </ul>

                    @if (Auth::user()->usuario_tipo_fk == 1 || Auth::user()->usuario_tipo_fk == 4)
                      <div class="text-start mt-2 mb-3">
                        <a href="{{ route('documentos.edit', ['id' => $documento->id]) }}"
                          class="highlighted-btn-sm highlight-blue text-nowrap text-decoration-none">
                          <i class="bi bi-pencil-square"></i>
                          Editar
                        </a>                     
                      </div>
                    @endif  
                  @endforeach
                @endforeach

              @else
                <span class="text-muted">Nenhum documento</span>
              @endif
            </div>
          </div>
        </div>
      @endforeach
    </div>
  </div>
</div>

<x-back-button/>

<script>
  function toggleDropdown(menuId) {
    var dropdown = document.getElementById(menuId);
    dropdown.classList.toggle("show");
  }

  // Fecha todos os dropdowns se o usuário clicar fora
  window.onclick = function (event) {
    if (!event.target.matches('.dropdown-button')) {
      var dropdowns = document.getElementsByClassName("dropdown-content1");
      for (var i = 0; i < dropdowns.length; i++) {
        dropdowns[i].classList.remove('show');
      }
    }
  }
</script>
@endsection