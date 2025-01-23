@extends('layouts.app')

@section('content')

@section('title') {{ 'Lista de Atividades' }} @endsection

<head>
  <link rel="stylesheet" href="{{ asset('css/index.css') }}">
  <link rel="stylesheet" href="{{ asset('css/atividades.css') }}">
  {{-- <link rel="stylesheet" href="{{ asset('css/filterImplement.css') }}"> --}}
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/5.2.3/css/bootstrap.min.css">
  <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.25/css/jquery.dataTables.css">
  <style>
    .liDP {
      margin-left: 0 !important;
    }

    .hover {
      text-decoration: none;
    }

    .hover:hover {
      text-decoration: underline;
    }
  </style>

  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  <script type="text/javascript" charset="utf8"
    src="https://cdn.datatables.net/1.10.25/js/jquery.dataTables.js"></script>
</head>

<div class="alert-container mt-5">
  @if (session('success'))
    <div class="alert alert-success">
    {{ session('success') }}
    </div>

  @elseif (session('error'))
    <div class="alert alert-danger">
    {{ session('error') }}
    </div>
  @endif
</div>

<div class="container-fluid px__custom">
  <div class="col-12 border main-datatable">
    <div class="d-flex justify-content-center text-center p-2" style="flex-direction: column;">
      <span style="font-size:22px;">Lista de Atividades</span>
      
      <span style="font-size:20px;">
      @if(isset($eixo_id) && $eixo_id)
        <a class="hover" href="{{ route('eixo.mostrar', ['eixo_id' => $eixo_id]) }}">
          {{$eixoNome}} <i class="bi bi-arrow-return-left"></i>
        </a>
      </span>
      @endif
    </div>
  </div>
</div>

<div class="container-fluid p-30">
  <div class="col-12 border main-datatable">
    <div class="container-fluid">
      <div class="table-responsive">
        <table id="tableHome2" class="table cust-datatable">
          <thead>
            <tr style="white-space: nowrap; text-align:center;">
              <th scope="col" style="width: 280px;">Eixos</th>
              <th scope="col">Atividade</th>
              <th scope="col">Objetivo</th>
							<th scope="col">Responsável</th>
              <th scope="col">Público Alvo</th>
              <th scope="col">Tipo de Evento</th>
              <th scope="col">Canal de Divulgação</th>
              <th scope="col">Data Prevista</th>
              <th scope="col">Data Realizada</th>
              <th scope="col">Meta</th>
              <th scope="col">Realizado</th>
              <th scope="col">Ações</th>
            </tr>
          </thead>
          <tbody>
            @foreach ($atividades as $atividade)
            <tr>
              <td style="text-align:center;">
                @foreach ($atividade->eixos as $eixo)
                <span class="badge bg-primary">{{ $eixo->nome }}</span>
                @endforeach
              </td>
              <td style="text-align: center">{!! $atividade->atividade_descricao !!}</td>
							<td style="text-align: center;">{!! $atividade->responsavel !!}</td>
              <td class="text-center">{!! $atividade->objetivo !!}</td>
              <!-- Exibe o nome correspondente ao id do público alvo -->
              <td class="text-center">
                {{ $atividade->publico->nome ?? 'Não informado' }}
              </td>
              <td class="text-center">
								@if($atividade->tipo_evento == 1)
    							Presencial
								@elseif($atividade->tipo_evento == 0 || $atividade->tipo_evento === null)
    							Sem evento
								@else
    							Online
								@endif
              </td>
              <td class="text-center">
                @foreach ($atividade->canais as $canal)
                <span class="badge bg-primary">{{ $canal->nome }}</span>
                @endforeach
              </td>
              <td class="text-center">{{ \Carbon\Carbon::parse($atividade->data_prevista)->format('d/m/Y') }}</td>
              <td class="text-center">
                {{ $atividade->data_realizada ? \Carbon\Carbon::parse($atividade->data_realizada)->format('d/m/Y') : 'Não realizada' }}
              </td>
              <td class="text-center">
                {{$atividade->meta}} {{$atividade->medida->nome ?? 'N/A'}}
              </td>
              <td class="text-center">
                {{$atividade->realizado}} {{$atividade->medida->nome ?? 'N/A'}}
              </td>
              <td>
                @if(Auth::user()->unidade->unidadeTipoFK == 1)
                <div class="d-flex justify-content-start">
                  <a href="{{ route('atividades.edit', $atividade->id) }}" class="btn btn-sm btn-warning me-2"><i class="bi bi-pencil"></i></a>
                  <button type="button" class="btn btn-sm btn-danger" data-bs-toggle="modal" data-bs-target="#deleteModal{{ $atividade->id }}"><i class="bi bi-trash"></i></button>
                </div>
                @endif
              </td>
            </tr>
            <!-- Modal de Confirmação de Exclusão -->
            <div class="modal fade" id="deleteModal{{ $atividade->id }}" tabindex="-1" aria-labelledby="deleteModalLabel{{ $atividade->id }}" aria-hidden="true">
              <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                  <div class="modal-header">
                    <h5 class="modal-title" id="deleteModalLabel{{ $atividade->id }}">Confirmar Exclusão</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                  </div>
                  <div class="modal-body">
                    Tem certeza que deseja excluir esta atividade?
                  </div>
                  <div class="modal-footer">
                    <button type="button" class="secondary" data-bs-dismiss="modal">Cancelar</button>
                    <form action="{{ route('atividades.delete', $atividade->id) }}" method="POST">
                      @csrf
                      @method('DELETE')
                      <button type="submit" class="btn btn-danger">Excluir</button>
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

<script>
  $(document).ready(function () {
    let table = $('#tableHome2').DataTable({
      order: [[6, "asc"]],
      language: {
        url: '//cdn.datatables.net/plug-ins/1.13.6/i18n/pt-BR.json',
        search: "Procurar:",
        info: 'Mostrando página _PAGE_ de _PAGES_',
        infoEmpty: 'Sem monitoramentos disponíveis no momento',
        infoFiltered: '(Filtrados do total de _MAX_ monitoramentos)',
        zeroRecords: 'Nada encontrado. Se achar que isso é um erro, contate o suporte.',
        paginate: { next: "Próximo", previous: "Anterior" },
        responsive: true
      },
      initComplete: function () {
        let searchBox = $('#tableHome2_filter');

        let dropdownContainer = $(` 
          <div class="dropdown mt-3 d-none">
            <button class="btn btn-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
              Filtros
            </button>
            <div class="dropdown-menu p-3" id="filtersContent" style="min-width: 300px;">
              <div class="mb-3">
                <label for="filterUnidade" class="form-label">Filtrar por Eixo:</label>
                <select class="form-select form-select-sm mb-2" id="filterUnidade">
                  <option value="">TODOS</option>
                  @foreach ($atividades->unique('id') as $atividade)
                    @foreach ($atividade->eixos as $eixo)
                      <option value="{{ $eixo->nome }}">{{ $eixo->nome }}</option>
                    @endforeach
                  @endforeach
                </select>
              </div>
              <div class="mb-3" id="lengthMenuContainer"></div>
            </div>
          </div>
        `);

        let container = $(` 
          <div class="d-flex justify-content-between align-items-center mb-3">
            <div class="me-3" id="searchContainer"></div>
            ${dropdownContainer[0].outerHTML}
            <div>
              @if(Auth::user()->unidade->unidadeTipoFK == 1)
                <a href="{{ route('atividades.create') }}" class="primary">Adicionar Atividade</a>
              @endif
            </div>
          </div>
        `);

        searchBox.before(container);
        $('#searchContainer').append(searchBox);
        $('#lengthMenuContainer').append($('#tableHome2_length'));

        $('#filterUnidade').on('change', function () {
          let val = $.fn.dataTable.util.escapeRegex($(this).val());
          table.column(1).search(val ? '^' + val + '$' : '', true, false).draw();
        });
      }
    });
  });
</script>
@endsection