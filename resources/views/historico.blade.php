@extends('layouts.app')

@section('title')
    Histórico
@endsection

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
                box-shadow: 0px 8px 16px 0px rgba(0, 0, 0, 0.2);
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

            @if(Auth::user()->usuario_tipo_fk == 1 || Auth::user()->usuario_tipo_fk == 2 || Auth::user()->usuario_tipo_fk == 4)
                <div class="d-flex justify-content-center gap-3 mb-4">
                    <a href="{{ route('documentos.create') }}"
                        class="btn btn-outline-secondary rounded-pill d-flex align-items-center gap-2">
                        <i class="bi bi-plus-circle"></i> Inserir Documento
                    </a>
                </div>
            @endif


            <div class="accordion" id="accordionDocumentos">
                @foreach ($tiposDocumentos as $tipo)
                    <div class="accordion-item">
                        <h2 class="accordion-header" id="heading{{ $tipo->id }}">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                data-bs-target="#collapse{{ $tipo->id }}" aria-expanded="false"
                                aria-controls="collapse{{ $tipo->id }}">
                                {{ $tipo->nome }}
                            </button>
                        </h2>
                        <div id="collapse{{ $tipo->id }}" class="accordion-collapse collapse"
                            aria-labelledby="heading{{ $tipo->id }}" data-bs-parent="#accordionDocumentos">
                            <div class="accordion-body">
                                @if (isset($documentosAgrupados[$tipo->id]))
                                    @foreach ($documentosAgrupados[$tipo->id] as $ano => $docsPorAno)
                                        <div class="mb-2 fw-bold">{{ $ano }}</div>
                                        @foreach ($docsPorAno as $documento)
                                            <div class="d-flex align-items-center mb-2">
                                                <a href="{{ asset('storage/' . $documento->path) }}" target="_blank"
                                                    class="flex-grow-1 text-decoration-none text-dark text-truncate"
                                                    title="{{ basename($documento->path) }}">
                                                    {{ basename($documento->path) }}
                                                </a>
                                                @if (Auth::user()->usuario_tipo_fk == 1 || Auth::user()->usuario_tipo_fk == 4)
                                                    <a href="{{ route('documentos.edit', ['id' => $documento->id]) }}" class="ms-2 text-muted"
                                                        style="font-size: 0.9rem;" title="Editar">
                                                        <i class="bi bi-pencil-square"></i>
                                                    </a>
                                                @endif
                                            </div>
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




            <x-back-button />

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