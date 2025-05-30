@extends('layouts.app')

@section('title') Histórico @endsection

@section('content')

<head>
  <link rel="stylesheet" href="{{ asset('css/historico.css') }}">

  <style>
    .liDP {
      margin-left: 0 !important;
    }
    .dropdown-content1 {
      display: none;
      position: absolute;
      background-color: white;
      min-width: 160px;
      box-shadow: 0px 8px 16px 0px rgba(0,0,0,0.2);
      z-index: 1;
    }
    .dropdown-content1.show {
      display: block;
    }
    .dropdown-container {
      position: relative;
      display: inline-block;
    }
  </style>
</head>


<div class="form-wrapper pt-5">
  <div class="form_create border p-4"> <!-- padding interno no container -->

    <h5 class="text-center mb-5">Documentos do Programa de Integridade</h5>

    @if (session('success'))
        <div class="alert alert-success text-center auto-dismiss">
             {{ session('success') }}
        </div>
    @endif

    @if (session('error'))
        <div class="alert alert-danger text-center auto-dismiss">
             {{ session('error') }}
        </div>
    @endif

    <div class="d-flex justify-content-center gap-3 mb-4">
        <a href="{{ route('documentos.create') }}" class="btn btn-primary">
          Inserir Documento
        </a>
    </div>


    @foreach($tiposDocumentos as $tipo)
      <div class="dropdown-container mt-4">
        <button class="dropdown-button form-select" onclick="toggleDropdown('dropdownMenu{{ $tipo->id }}')">
          {{ $tipo->nome }}
        </button>
        <div class="dropdown-content1 p-3" id="dropdownMenu{{ $tipo->id }}"> <!-- padding interno -->
          @if(isset($documentosAgrupados[$tipo->id]))
            @foreach($documentosAgrupados[$tipo->id] as $ano => $docsPorAno)
              <div class="mb-2"><strong>{{ $ano }}</strong></div> <!-- margem embaixo do ano -->

             @foreach($docsPorAno as $documento)
                  <div class="d-flex align-items-center justify-content-center mb-1">
                    <a href="{{ asset('storage/' . $documento->path) }}" target="_blank" class="flex-grow-1 text-decoration-none">
                      Documento de {{ $documento->ano }}
                    </a>

                    @if(Auth::user()->usuario_tipo_fk == 1 || Auth::user()->usuario_tipo_fk == 4)
                      <a href="{{ route('documentos.edit', ['id' => $documento->id]) }}" 
                        class="text-muted mt-2 small text-decoration-none" 
                        style="font-size: 0.75rem; line-height: 1; display: flex; align-items: center;">
                        Editar
                      </a>
                    @endif
                  </div>
              @endforeach


            @endforeach
          @else
            <span class="text-muted px-3">Nenhum documento</span>
          @endif
        </div>
      </div>
    @endforeach
  </div>
</div>



<x-back-button/>

<script>
  function toggleDropdown(menuId) {
    var dropdown = document.getElementById(menuId);
    dropdown.classList.toggle("show");
  }

  // Fecha todos os dropdowns se o usuário clicar fora
  window.onclick = function(event) {
    if (!event.target.matches('.dropdown-button')) {
      var dropdowns = document.getElementsByClassName("dropdown-content1");
      for (var i = 0; i < dropdowns.length; i++) {
        dropdowns[i].classList.remove('show');
      }
    }
  }
</script>

@endsection
