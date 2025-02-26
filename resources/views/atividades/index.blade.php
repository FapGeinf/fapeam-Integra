@extends('layouts.app')
<link rel="stylesheet" href="{{ asset('css/index.css') }}">
<link rel="stylesheet" href="{{ asset('css/atividades.css') }}">
<script src="{{ asset('js/jquery-3.6.0.min.js') }}"></script>
<script src="{{ asset('js/dataTables.min.js') }}"></script>
<link rel="stylesheet" href="{{ asset('css/dataTables.dataTables.min.css') }}">
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
@section('title') {{ 'Lista de Atividades' }} @endsection
@section('content')
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

<div class="container-fluid px__custom pt-4">
  <div class="col-12 border main-datatable">
    <div class="d-flex justify-content-center text-center p-2" style="flex-direction: column;">
      <span style="font-size:22px;">Lista de Atividades</span>
      
      <span style="font-size:20px;">
      @if(isset($eixo_id) && $eixo_id)
			<a class="hover" href="{{ route('eixo.mostrar', ['eixo_id' => $eixo_id]) }}">EIXO {{$eixo_id}} - 
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
          <div class="row g-3 align-items-end">
          <div class="col-md-3">
              <label for="filter-publico" class="fw-bold">Tipo de Público</label>
              <select name="filter-publico" id="filter-publico" class="form-select pointer">
                  <option value="">Escolha um Tipo</option>
                  @foreach ($publicos as $publico)
                      <option value="{{ $publico->nome }}">{{ $publico->nome }}</option>
                  @endforeach
              </select>
          </div>

          <div class="col-md-3">
              <label for="filter-canal" class="fw-bold">Tipo de Canal de Divulgação</label>
              <select name="filter-canal" id="filter-canal" class="form-select pointer">
                  <option value="">Escolha um Tipo</option>
                  @foreach ($canais as $canal)
                      <option value="{{ $canal->nome }}">{{ $canal->nome }}</option>
                  @endforeach
              </select>
          </div>

          <div class="col-md-3">
               <label for="filter-evento" class="fw-bold">Tipo de Evento:</label>
               <select name="filter-evento" id="filter-evento" class="form-select pointer">
                       <option value="">Escolha uma opção</option>
                       <option value="Presencial">Presencial</option>
                       <option value="Online">Online</option>
                       <option value="Presencial e Online">Presencial e Online</option>
               </select>
          </div>

          @if(Auth::user()->unidadeIdFK == 1)
              <div class="col-md-3 d-flex align-items-end">
                  <a href="{{ route('atividades.create') }}" class="blue-btn">Inserir Atividade</a>
              </div>
          @endif
      </div>
      <div class="table-responsive">
        <table id="tableHome2" class="table cust-datatable">
          <thead>
            <tr style="white-space: nowrap; text-align:center;">
              <th scope="col" style="width: 280px;" class="{{ request()->query('eixo_id') == 8 ? '' : 'd-none' }}">Eixos</th>


              <th scope="col">Atividade</th>
              <th scope="col">Objetivo</th>
							<th scope="col">Responsável</th>
              <th scope="col">Público Alvo</th>
              <th scope="col">Tipo de Evento</th>
              <th scope="col">Canal de Divulgação</th>
              <th scope="col">Datas</th>
              <!-- <th scope="col">Data Realizada</th> -->
              <th scope="col">Meta</th>
              <!-- <th scope="col">Realizado</th> -->
              <th scope="col">Ações</th>
            </tr>
          </thead>
          <tbody>
            @foreach ($atividades as $atividade)
              <tr>
                <td style="text-align:center;" class="{{ request()->query('eixo_id') == 8 ? '' : 'd-none' }}">
                @foreach ($atividade->eixos as $eixo)
                  <span class="badge bg-primary">{{ $eixo->nome }}</span>
                @endforeach
                </td>
                <td style="text-align: center">{!! $atividade->atividade_descricao !!}</td>
                <td class="text-center">{!! $atividade->objetivo !!}</td>
                      <td style="text-align: center;">{!! $atividade->responsavel !!}</td>
                <!-- Exibe o nome correspondente ao id do público alvo -->
                <td class="text-center">
                {{ $atividade->publico->nome ?? 'Não informado' }}
                </td>
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

                <td class="text-center">
                <div class="mt-2">
                <div class="text-muted">Data Prevista</div>
                <div>{{ \Carbon\Carbon::parse($atividade->data_prevista)->format('d/m/Y') }}</div>
                </div>
                  <hr>
                <div class="mt-2">
                <div class="text-muted">Data Realizada</div>
                <div>{{ $atividade->data_realizada ? \Carbon\Carbon::parse($atividade->data_realizada)->format('d/m/Y') : 'Não realizada' }}</div>
                </div>
                </td>

                <td class="text-center">
                <div class="mt-2">
                    <div class="text-muted">Previsto</div>
                <div>{{$atividade->meta}} {{$atividade->medida->nome ?? 'N/A'}}</div>
                </div>
                  <hr>
                <div class="mt-2">
                <div class="text-muted">Realizado</div>
                <div>{{$atividade->realizado}} {{$atividade->medida->nome ?? 'N/A'}}</div>
                </div>
                </td>


                <td>
                @if(Auth::user()->unidade->unidadeTipoFK == 1)
                  <div class="d-flex justify-content-center gap-1">
                    <a href="{{ route('atividades.edit', $atividade->id) }}" class="warning" style="font-size: 13px;"><i class="bi bi-pencil"></i></a>
                    <a href="{{ route('atividades.show', $atividade->id) }}" class="primary">
                      <i class="bi bi-eye"></i>
                    </a>
                    <button type="button" class="danger" data-bs-toggle="modal" data-bs-target="#deleteModal{{ $atividade->id }}"><i class="bi bi-trash"></i></button>
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
  $(document).ready(function(){
      let table = $('#tableHome2').DataTable({
          order: [[6, "asc"]],
          autoWidth: false,  
          columnDefs: [
              { targets: "_all", defaultContent: "" } 
          ],
          language: {
              url: '{{ asset('js/pt_br-datatable.json') }}',
              search: "Procurar:",
              info: 'Mostrando página _PAGE_ de _PAGES_',
              infoEmpty: 'Sem monitoramentos disponíveis no momento',
              infoFiltered: '(Filtrados do total de _MAX_ monitoramentos)',
              zeroRecords: 'Nada encontrado. Se achar que isso é um erro, contate o suporte.',
              paginate: { next: "Próximo", previous: "Anterior" },
              responsive: true
          }
      });

      $('#filter-canal').on('change', function () {
          let canal = $(this).val();
          table.column(6).search(canal).draw(); 
      });

      $('#filter-publico').on('change',function(){
         let publico = $(this).val();
         table.column(4).search(publico).draw();
      });

      $('#filter-evento').on('change',function(){
        let evento = $(this).val();
        table.column(5).search(evento).draw();
      })
  });
</script>
@endsection