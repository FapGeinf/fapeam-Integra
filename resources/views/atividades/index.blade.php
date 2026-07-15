@extends('layouts.app')
@section('title') {{ 'Lista de Atividades' }} @endsection
@section('content')

<link rel="stylesheet" href="{{ asset('css/show.css') }}">
<link rel="stylesheet" href="{{ asset('css/buttons.css') }}">
<link rel="stylesheet" href="{{ asset('css/tables.css') }}">
<script src="{{ asset('js/jquery-3.6.0.min.js') }}"></script>
<script src="{{ asset('js/dataTables.min.js') }}"></script>
<link rel="stylesheet" href="{{ asset('css/dataTables.dataTables.min.css') }}">
<script src="{{ asset('js/tables/atividadesTable.js') }}"></script>

<style>
  div.dt-container div.dt-layout-row {
    font-size: 13px;
  }
</style>

<x-alert-toast/>
<x-back-to-top/>
<x-back-to-bottom/>

<div class="container-xxl pt-5" style="max-width: 1500px !important;">
  <div class="col-12 border box-shadow">
    <div class="justify-content-center">
      <h5 class="text-center mb-1">Lista de Atividades</h5>

      <div class="text-center">
        @if(isset($eixo_id) && $eixo_id)
          <span class="fw-bold">
            <a class="hover" href="{{ route('eixo.mostrar', ['eixo_id' => $eixo_id]) }}">
              EIXO {{$eixo_id}} - {{$eixoNome}} <i class="bi bi-arrow-return-left"></i>
            </a>
          </span>
        @endif
      </div>

      <div class="row g-3 mt-3 align-items-end">
        <div class="col-12 col-sm-6 col-md-2">
          <label for="filter-publico" class="f-size">Tipo de público:</label>
          <select name="filter-publico" id="filter-publico" class="form-select input-enabled f-size border-grey">
            <option selected disabled>Escolha um tipo</option>
            <option value="">Todos</option>
            @foreach ($publicos as $publico)
              <option value="{{ $publico->nome }}">{{ $publico->nome }}</option>
            @endforeach
          </select>
        </div>

        <div class="col-12 col-sm-6 col-md-2">
          <label for="filter-canal" class="f-size">Tipo de canal de divulgação:</label>
          <select name="filter-canal" id="filter-canal" class="form-select input-enabled f-size border-grey">
            <option disabled>Escolha um tipo</option>
            <option value="">Todos</option>
            @foreach ($canais as $canal)
              <option value="{{ $canal->nome }}">{{ $canal->nome }}</option>
            @endforeach
          </select>
        </div>

        <div class="col-12 col-sm-6 col-md-2">
          <label for="filter-status" class="f-size">Status da atividade:</label>
          <select name="filter-status" id="filter-status" class="form-select input-enabled f-size border-grey">
            <option selected disabled>Escolha uma opção</option>
            <option value="">Todos</option>
            @foreach ($statusAtividades as $status)
              <option value="{{ $status->nome }}">{{ $status->nome }}</option>
            @endforeach
          </select>
        </div>

        <div class="col-12 col-sm-6 col-md-2">
          <label for="filter-evento" class="f-size">Tipo de evento:</label>
          <select name="filter-evento" id="filter-evento" class="form-select input-enabled f-size border-grey">
            <option selected disabled>Escolha uma opção</option>
            <option value="">Todos</option>
            <option value="Presencial">Presencial</option>
            <option value="Online">Online</option>
            <option value="Presencial e Online">Presencial e Online</option>
          </select>
        </div>

        <div class="col-12 col-sm-6 col-md-2">
          <label for="filter-data" class="f-size">Ordenar por data prevista:</label>
          <select name="filter-data" id="filter-data" class="form-select input-enabled f-size border-grey">
            <option selected disabled>Escolha uma opção</option>
            <option value="">Todos</option>
            <option value="asc">Mais Antiga</option>
            <option value="desc">Mais Recente</option>
          </select>
        </div>


      </div>
      
      <div class="table-responsive pt-4">
        @if(Auth::user()->unidadeIdFK == 1)
          <div class="col-12 d-flex justify-content-start pb-2">
            <a href="{{ route('atividades.create') }}" class="highlighted-btn-sm highlight-blue text-decoration-none">
              <i class="bi bi-plus-lg"></i>
              Inserir Atividade
            </a>
          </div>
        @endif

        <button type="button" class="highlighted-btn-sm highlight-blue bg-secondary border-secondary text-decoration-none" data-bs-toggle="modal" data-bs-target="#modalRelatorioStatus">
            <i class="bi bi-file-earmark-pdf-fill"></i>
            Gerar Relatório por Status
        </button>

        <div class="modal fade" id="modalRelatorioStatus" tabindex="-1" aria-labelledby="modalRelatorioStatusLabel" aria-hidden="true">
          <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title" id="modalRelatorioStatusLabel">
                  <i class="bi bi-file-earmark-pdf text-danger me-2"></i>Gerar Relatório de Atividades
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
              </div>
              
              <form id="formRelatorioStatus" action="" method="GET" target="_blank" data-route-url="{{ route('relatorios.atividades-status', ':id') }}">
                <div class="modal-body text-start">
                  <p class="text-muted text13">Selecione o status desejado para gerar o arquivo PDF consolidado de todas as atividades correspondentes:</p>
                  
                  <div class="mb-3">
                    <label for="select-relatorio-status" class="fw-bold mb-2">Status da Atividade:</label>
                    <select id="select-relatorio-status" class="form-select border-grey" required>
                      <option value="" selected disabled>Selecione um status...</option>
                      @foreach ($statusAtividades as $status)
                        <option value="{{ $status->id }}">{{ $status->nome }}</option>
                      @endforeach
                    </select>
                  </div>
                </div>
                
                <div class="modal-footer">
                  <button type="button" class="footer-btn footer-secondary" data-bs-dismiss="modal">Fechar</button>
                  <button type="submit" class="footer-btn footer-primary bg-primary text-white border-0">
                    <i class="bi bi-download me-1"></i> Gerar PDF
                  </button>
                </div>
              </form>
            </div>
          </div>
        </div>

        <script src="{{ asset('js/tables/relatorioStatus.js') }}"></script>

        <table id="tableHome2" class="table table-striped cust-datatable mb-2">
          <thead>
            <tr style="white-space: nowrap;">
              <th scope="col" style="width: 280px;" class="{{ request()->query('eixo_id') == 8 ? '' : 'd-none' }}">Eixos</th>
              <th scope="col" class="text-center text-light">Atividade</th>
              <th scope="col" class="text-center text-light">Objetivo</th>
              <th scope="col" class="text-center text-light">Responsável</th>
              <th scope="col" class="text-center text-light">Público Alvo</th>
              <th scope="col" class="text-center text-light">Tipo de Evento</th>
              <th scope="col" class="text-center text-light">Canal de Divulgação</th>
              <th scope="col" class="text-center text-light">Datas</th>
              <th scope="col" class="text-center text-light">Ano</th>
              <th scope="col" class="text-center text-light">Meta</th>
              <th scope="col" class="text-center text-light">Status</th>
              <th scope="col" class="text-center text-light">Ações</th>
            </tr>
          </thead>

          <tbody>
            @foreach ($atividades as $atividade)
              <tr class="text13">
                <td style="text-align:center;"
                  class="{{ request()->query('eixo_id') == 8 ? '' : 'd-none' }}">
                  @foreach ($atividade->eixos as $eixo)
                    <span class="badge bg-primary">{{ $eixo->nome }}</span>
                  @endforeach
                </td>

                <td style="text-align: center">{!! $atividade->atividade_descricao !!}</td>
                <td class="text-center">{!! $atividade->objetivo !!}</td>
                <td style="text-align: center;">{!! $atividade->responsavel !!}</td>

                <td class="text-center">{{ $atividade->publico->nome ?? 'Não informado' }}</td>

                <td class="text-center">
                  @if($atividade->tipo_evento == 1)
                    Presencial
                  @elseif($atividade->tipo_evento == 2)
                    Online
                  @elseif($atividade->tipo_evento == 3)
                    Presencial e Online
                  @elseif($atividade->tipo_evento == 0 || $atividade->tipo_evento === null)
                    Sem evento
                  @endif
                </td>

                <td class="text-center">
                  @foreach ($atividade->canais as $canal)
                    <span class="">{{ $canal->nome }}</span>
                  @endforeach
                </td>

                <td class="text-center"
                  data-order="{{ \Carbon\Carbon::parse($atividade->data_realizada ?? $atividade->data_prevista)->format('Y-m-d') }}">
                  <div class="">
                    <div class="">Data Prevista:</div>
                    <div>{{ \Carbon\Carbon::parse($atividade->data_prevista)->format('d/m') }}</div>
                  </div>

                  <hr>

                  <div class="">
                    <div class="">Data Realizada:</div>
                    <div>
                      {{ $atividade->data_realizada ? \Carbon\Carbon::parse($atividade->data_realizada)->format('d/m') : 'Não realizada' }}
                    </div>
                  </div>
                </td>

                <td class="text-center">{{ \Carbon\Carbon::parse($atividade->data_prevista)->format('Y') }}</td>

                <td class="text-center">
                  <div class="">
                    <div class="">Previsto:</div>
                    <div>{{$atividade->meta}} {{$atividade->medida->nome ?? 'N/A'}}</div>
                  </div>

                  <hr>

                  <div class="">
                    <div class="">Realizado:</div>
                    <div>{{$atividade->realizado}} {{$atividade->medida->nome ?? 'N/A'}}</div>
                  </div>
                </td>

                <td class="text-center">
                    @switch($atividade->statusAtividade->nome ?? '')
                        @case('Acompanhamento')
                            <div class="badge bg-warning text-dark">
                                {{ $atividade->statusAtividade->nome }}
                                <i class="bi bi-clock-history ms-1"></i>
                            </div>
                            @break

                        @case('Executado')
                            <div class="badge bg-success">
                                {{ $atividade->statusAtividade->nome }}
                                <i class="bi bi-check-circle ms-1"></i>
                            </div>
                            @break

                        @case('Não Executado')
                            <div class="badge bg-danger">
                                {{ $atividade->statusAtividade->nome }}
                                <i class="bi bi-x-circle ms-1"></i>
                            </div>
                            @break

                        @default
                            <div class="badge bg-secondary">
                                {{ $atividade->statusAtividade->nome ?? 'N/A' }}
                                <i class="bi bi-question-circle ms-1"></i>
                            </div>
                    @endswitch
                </td>

                <td class="text-center">
                  @if(Auth::user()->unidade->unidadeTipoFK == 1 || Auth::user()->usuario_tipo_fk == 1  || Auth::user()->usuario_tipo_fk == 4)
                    <div class="d-flex flex-column gap-2">
                      <a href="{{ route('atividades.show', $atividade->id) }}"
                        class="footer-btn footer-primary w-100 text-start d-inline-block text-decoration-none text-nowrap">
                        <i class="bi bi-eye me-2"></i>
                        Visualizar
                      </a>

                      <a href="{{ route('atividades.edit', $atividade->id) }}"
                      class="footer-btn footer-warning w-100 text-start d-inline-block text-decoration-none text-nowrap">
                        <i class="bi bi-pencil me-2"></i>
                        Editar
                      </a>

                      <a href="#" class="footer-btn footer-danger w-100 text-start d-inline-block text-decoration-none text-nowrap"
                        data-bs-toggle="modal"
                        data-bs-target="#deleteModal{{ $atividade->id }}">
                        <i class="bi bi-trash me-2"></i>
                        Excluir
                      </a>
                    </div>
                  @endif
                </td>

                {{-- <td>
                  @if(Auth::user()->unidade->unidadeTipoFK == 1 || Auth::user()->usuario_tipo_fk == 1)
                  <div class="d-flex justify-content-center gap-1">
                      <a href="{{ route('atividades.edit', $atividade->id) }}" class="warning"
                          style="font-size: 13px;"><i class="bi bi-pencil"></i></a>
                      <a href="{{ route('atividades.show', $atividade->id) }}" class="primary">
                          <i class="bi bi-eye"></i>
                      </a>
                      <button type="button" class="danger" data-bs-toggle="modal"
                          data-bs-target="#deleteModal{{ $atividade->id }}"><i
                              class="bi bi-trash"></i></button>
                  </div>
                  @endif
                </td> --}}
              </tr>

              <div class="modal fade" id="deleteModal{{ $atividade->id }}" tabindex="-1"
                aria-labelledby="deleteModalLabel{{ $atividade->id }}" aria-hidden="true">
                <div class="modal-dialog">
                  <div class="modal-content">
                    <div class="modal-header">
                      <h5 class="modal-title" id="deleteModalLabel{{ $atividade->id }}">Confirmar Exclusão</h5>
                      <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>

                    <div class="modal-body">Tem certeza que deseja excluir esta atividade?</div>

                    <div class="modal-footer">
                      <button type="button" class="footer-btn footer-secondary" data-bs-dismiss="modal">Cancelar</button>

                      <form action="{{ route('atividades.delete', $atividade->id) }}" method="POST" class="m-0 p-0">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="footer-btn footer-danger">Excluir</button>
                      </form>
                    </div>
                  </div>
                </div>
              </div>
            @endforeach
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>

<x-back-button/>
@endsection