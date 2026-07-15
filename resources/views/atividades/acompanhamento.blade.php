@extends('layouts.app')

@section('title') {{"Atividades em Acompanhamento"}} @endsection

@section('content')

    <link rel="stylesheet" href="{{ asset('css/show.css') }}">
    <link rel="stylesheet" href="{{ asset('css/buttons.css') }}">
    <link rel="stylesheet" href="{{ asset('css/tables.css') }}">
    <script src="{{ asset('js/jquery-3.6.0.min.js') }}"></script>
    <script src="{{ asset('js/dataTables.min.js') }}"></script>
    <link rel="stylesheet" href="{{ asset('css/dataTables.dataTables.min.css') }}">
    <script src="{{ asset('js/tables/atividadesTable.js') }}"></script>

    <x-alert-toast />
    <x-back-to-top />
    <x-back-to-bottom />

    <div class="container-xxl pt-4" style="max-width: 1500px !important;">

        <div class="card border-0 bg-info bg-gradient text-white shadow-sm mb-4 rounded-3 mt-4">
            <div class="card-body p-4 d-flex justify-content-between align-items-center flex-wrap gap-3">
                <div>
                    <span class="badge bg-white text-info fw-bold uppercase mb-2">Painel de Monitoramento</span>
                    <h3 class="h4 mb-1 fw-bold"><i class="bi bi-arrow-repeat me-2"></i>Atividades em Acompanhamento</h3>
                    <p class="mb-0 text-white-50 small">
                        Visualização e gestão das atividades que estão sob monitoramento e andamento constante.
                    </p>
                </div>

                @if(isset($eixo_id) && $eixo_id)
                    <div>
                        <a class="btn btn-light btn-sm text-info fw-bold rounded-pill shadow-sm"
                            href="{{ route('eixo.mostrar', ['eixo_id' => $eixo_id]) }}">
                            <i class="bi bi-arrow-left me-1"></i> EIXO {{$eixo_id}} - {{$eixoNome}}
                        </a>
                    </div>
                @endif
            </div>
        </div>

        <div class="card border-0 shadow-sm rounded-3">
            <div class="card-body p-4">

                <div class="row g-3 align-items-end mb-3">
                    <div class="col-12 col-sm-6 col-md-3">
                        <label for="filter-publico" class="form-label text-muted small fw-bold">Público-alvo:</label>
                        <select name="filter-publico" id="filter-publico" class="form-select form-select-sm border-grey">
                            <option selected disabled>Escolha um tipo</option>
                            <option value="">Todos</option>
                            @foreach ($publicos as $publico)
                                <option value="{{ $publico->nome }}">{{ $publico->nome }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-12 col-sm-6 col-md-3">
                        <label for="filter-canal" class="form-label text-muted small fw-bold">Canal de divulgação:</label>
                        <select name="filter-canal" id="filter-canal" class="form-select form-select-sm border-grey">
                            <option disabled selected>Escolha um tipo</option>
                            <option value="">Todos</option>
                            @foreach ($canais as $canal)
                                <option value="{{ $canal->nome }}">{{ $canal->nome }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-12 col-sm-6 col-md-3">
                        <label for="filter-evento" class="form-label text-muted small fw-bold">Tipo de evento:</label>
                        <select name="filter-evento" id="filter-evento" class="form-select form-select-sm border-grey">
                            <option selected disabled>Escolha uma opção</option>
                            <option value="">Todos</option>
                            <option value="Presencial">Presencial</option>
                            <option value="Online">Online</option>
                            <option value="Presencial e Online">Presencial e Online</option>
                        </select>
                    </div>

                    <div class="col-12 col-sm-6 col-md-3">
                        <label for="filter-data" class="form-label text-muted small fw-bold">Data de realização:</label>
                        <select name="filter-data" id="filter-data" class="form-select form-select-sm border-grey">
                            <option selected disabled>Ordenar por</option>
                            <option value="">Padrão</option>
                            <option value="asc">Mais Antigas</option>
                            <option value="desc">Mais Recentes</option>
                        </select>
                    </div>
                </div>

                <div class="d-flex mb-3">
                    <div class="dropdown">
                        <button class="btn btn-sm btn-primary dropdown-toggle d-flex align-items-center gap-2 shadow-sm"
                            type="button" id="dropdownAcoesPagina" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="bi bi-sliders"></i> Opções da Página
                        </button>

                        <ul class="dropdown-menu shadow" aria-labelledby="dropdownAcoesPagina">

                            @if(Auth::user()->unidadeIdFK == 1)
                                <li>
                                    <a class="dropdown-item d-flex align-items-center gap-2"
                                        href="{{ route('atividades.create') }}">
                                        <i class="bi bi-plus-lg text-success"></i>
                                        Nova Atividade
                                    </a>
                                </li>
                            @endif

                            @if(Auth::user()->unidadeIdFK == 1 && $atividades->isNotEmpty() && $atividades->first()->status_atividade_id)
                                <li>
                                    <hr class="dropdown-divider">
                                </li>
                            @endif

                            @if($atividades->isNotEmpty())
                                @php
                                    $statusId = $atividades->first()->status_atividade_id;
                                @endphp

                                @if($statusId)
                                    <li>
                                        <a class="dropdown-item d-flex align-items-center gap-2"
                                            href="{{ route('relatorios.atividades-status', $statusId) }}" target="_blank">
                                            <i class="bi bi-file-earmark-pdf-fill text-danger"></i>
                                            Imprimir Relatório Analítico
                                        </a>
                                    </li>
                                @endif
                            @endif

                        </ul>
                    </div>
                </div>

                <div class="table-responsive">
                    <table id="tableHome2" class="table table-hover align-middle mb-0">
                        <thead class="table-dark">
                            <tr style="white-space: nowrap;">
                                <th scope="col" style="width: 250px;"
                                    class="{{ request()->query('eixo_id') == 8 ? '' : 'd-none' }}">Eixos</th>
                                <th scope="col" class="text-center">Atividade</th>
                                <th scope="col" class="text-center">Objetivo</th>
                                <th scope="col" class="text-center">Responsável</th>
                                <th scope="col" class="text-center">Público Alvo</th>
                                <th scope="col" class="text-center">Tipo Evento</th>
                                <th scope="col" class="text-center">Canal Divulgação</th>
                                <th scope="col" class="text-center">Período / Datas</th>
                                <th scope="col" class="text-center">Metas (Prev. / Real.)</th>
                                <th scope="col" class="text-center">Status</th>
                                <th scope="col" class="text-center">Ações</th>
                            </tr>
                        </thead>

                        <tbody>
                            @foreach ($atividades as $atividade)
                                <tr class="text13">
                                    <td class="text-center {{ request()->query('eixo_id') == 8 ? '' : 'd-none' }}">
                                        @foreach ($atividade->eixos as $eixo)
                                            <span class="badge bg-secondary mb-1 d-inline-block">{{ $eixo->nome }}</span>
                                        @endforeach
                                    </td>

                                    <td class="text-center">{{ strip_tags($atividade->atividade_descricao) }}</td>
                                    <td class="text-center">{{ strip_tags($atividade->objetivo) }}</td>
                                    <td class="text-center">{{ strip_tags($atividade->responsavel) }}</td>

                                    <td class="text-center">{{ $atividade->publico->nome ?? 'Não informado' }}</td>
                                    <td class="text-center">
                                        @if($atividade->tipo_evento == 1) Presencial
                                        @elseif($atividade->tipo_evento == 2) Online
                                        @elseif($atividade->tipo_evento == 3) Presencial e Online
                                        @else Sem evento
                                        @endif
                                    </td>

                                    <td class="text-center">
                                        @foreach ($atividade->canais as $canal)
                                            <span class="badge bg-light text-dark border me-1">{{ $canal->nome }}</span>
                                        @endforeach
                                    </td>

                                    <td class="text-center"
                                        data-order="{{ \Carbon\Carbon::parse($atividade->data_realizada ?? $atividade->data_prevista)->format('Y-m-d') }}">
                                        <div class="small">
                                            <div class="text-muted">Previsto:
                                                {{ \Carbon\Carbon::parse($atividade->data_prevista)->format('d/m/Y') }}</div>
                                            <div class="text-info fw-bold">
                                                <i class="bi bi-calendar-check me-1"></i>
                                                Realizado:
                                                {{ $atividade->data_realizada ? \Carbon\Carbon::parse($atividade->data_realizada)->format('d/m/Y') : 'Em andamento' }}
                                            </div>
                                        </div>
                                    </td>

                                    <td class="text-center">
                                        <div class="small">
                                            <span class="text-muted">Meta: {{ $atividade->meta }}</span> /
                                            <span class="fw-bold text-info">Realiz: {{ $atividade->realizado }}</span>
                                            <div class="text-muted fs-7">({{ $atividade->medida->nome ?? 'N/A' }})</div>
                                        </div>
                                    </td>

                                    <td class="text-center">
                                        <span class="badge bg-info-subtle text-info border border-info px-3 py-2 rounded-pill">
                                            <i class="bi bi-arrow-repeat me-1"></i> Acompanhamento
                                        </span>
                                    </td>

                                    <td class="text-center">
                                        @if(Auth::user()->unidade->unidadeTipoFK == 1 || Auth::user()->usuario_tipo_fk == 1 || Auth::user()->usuario_tipo_fk == 4)
                                            <div class="dropdown">
                                                <button class="btn btn-sm btn-light border dropdown-toggle" type="button"
                                                    data-bs-toggle="dropdown" aria-expanded="false">
                                                    Ações
                                                </button>
                                                <ul class="dropdown-menu dropdown-menu-end shadow-sm">
                                                    <li>
                                                        <a class="dropdown-item"
                                                            href="{{ route('atividades.show', $atividade->id) }}">
                                                            <i class="bi bi-eye text-primary me-2"></i> Visualizar
                                                        </a>
                                                    </li>
                                                    <li>
                                                        <a class="dropdown-item"
                                                            href="{{ route('atividades.edit', $atividade->id) }}">
                                                            <i class="bi bi-pencil text-warning me-2"></i> Editar
                                                        </a>
                                                    </li>
                                                    <li>
                                                        <hr class="dropdown-divider">
                                                    </li>
                                                    <li>
                                                        <button type="button" class="dropdown-item text-danger"
                                                            data-bs-toggle="modal"
                                                            data-bs-target="#deleteModal{{ $atividade->id }}">
                                                            <i class="bi bi-trash me-2"></i> Excluir
                                                        </button>
                                                    </li>
                                                </ul>
                                            </div>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

            </div>
        </div>
    </div>

    @foreach ($atividades as $atividade)
        @if(Auth::user()->unidade->unidadeTipoFK == 1 || Auth::user()->usuario_tipo_fk == 1 || Auth::user()->usuario_tipo_fk == 4)
            <div class="modal fade" id="deleteModal{{ $atividade->id }}" tabindex="-1"
                aria-labelledby="deleteModalLabel{{ $atividade->id }}" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content border-0 shadow">
                        <div class="modal-header bg-danger text-white">
                            <h5 class="modal-title h6" id="deleteModalLabel{{ $atividade->id }}">
                                <i class="bi bi-exclamation-triangle-fill me-2"></i> Confirmar Exclusão
                            </h5>
                            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                                aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            Tem certeza de que deseja excluir permanentemente a atividade:
                            <strong class="d-block mt-2 text-dark">{{ strip_tags($atividade->atividade_descricao) }}</strong>
                        </div>
                        <div class="modal-footer bg-light">
                            <button type="button" class="btn btn-sm btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                            <form action="{{ route('atividades.delete', $atividade->id) }}" method="POST" class="m-0 p-0">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger">Excluir Registro</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        @endif
    @endforeach

    <x-back-button />

@endsection