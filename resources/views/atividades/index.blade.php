@extends('layouts.app')
@section('title') {{ 'Lista de Atividades' }} @endsection
@section('content')

<link rel="stylesheet" href="{{ asset('css/show.css') }}">
<link rel="stylesheet" href="{{ asset('css/buttons.css') }}">
<link rel="stylesheet" href="{{ asset('css/dropdown.css') }}">
<script src="{{ asset('js/jquery-3.6.0.min.js') }}"></script>
<script src="{{ asset('js/dataTables.min.js') }}"></script>
<script src="{{ asset('js/auto-dismiss') }}"></script>
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

    .f-size {
        font-size: 13px;
    }

    .input-enabled {
        background-color: #f9f9f9 !important;
    }

    .input-disabled {
        background-color: #f0f0f0 !important;
    }

    .border-grey {
        border: 1px solid #ccc !important;
    }

    
</style>

<div class="alert-container">
    @if (session('success'))
    <div class="alert alert-success text-center auto-dismiss">
        {{ session('success') }}
    </div>

    @elseif (session('error'))
    <div class="alert alert-danger text-center auto-dismiss">
        {{ session('error') }}
    </div>
    @endif
</div>

<div class="container-xxl pt-5" style="max-width: 1500px !important;">
	<div class="col-12 border box-shadow">
        <div class="justify-content-center">
             <h5 class="text-center mb-1">Lista de Atividades</h5>

            <div class="text-center">
                <span class="fw-bold">
                @if(isset($eixo_id) && $eixo_id)
                    <a class="hover" href="{{ route('eixo.mostrar', ['eixo_id' => $eixo_id]) }}">EIXO {{$eixo_id}} -
                        {{$eixoNome}} <i class="bi bi-arrow-return-left"></i>
                    </a>
                </span>
                @endif
            </div>

            <div class="row g-3 mt-3 align-items-end">

                <div class="col-12 col-sm-6 col-md-3">
                    <label for="filter-publico" class="f-size">Tipo de público:</label>
                    <select name="filter-publico" id="filter-publico" class="form-select input-enabled f-size border-grey">
                        <option disabled>Escolha um tipo</option>
                        @foreach ($publicos as $publico)
                            <option value="{{ $publico->nome }}">{{ $publico->nome }}</option>
                        @endforeach
                    </select>
                </div>
            
                <div class="col-12 col-sm-6 col-md-3">
                    <label for="filter-canal" class="f-size">Tipo de canal de divulgação:</label>
                    <select name="filter-canal" id="filter-canal" class="form-select input-enabled f-size border-grey">
                        <option disabled>Escolha um tipo</option>
                        @foreach ($canais as $canal)
                            <option value="{{ $canal->nome }}">{{ $canal->nome }}</option>
                        @endforeach
                    </select>
                </div>
            
                <div class="col-12 col-sm-6 col-md-3">
                    <label for="filter-evento" class="f-size">Tipo de evento:</label>
                    <select name="filter-evento" id="filter-evento" class="form-select input-enabled f-size border-grey">
                        <option disabled>Escolha uma opção</option>
                        <option value="Presencial">Presencial</option>
                        <option value="Online">Online</option>
                        <option value="Presencial e Online">Presencial e Online</option>
                    </select>
                </div>
            
                <div class="col-12 col-sm-6 col-md-3">
                    <label for="filter-data" class="f-size">Ordenar por data prevista:</label>
                    <select name="filter-data" id="filter-data" class="form-select input-enabled f-size border-grey">
                        <option disabled>Escolha uma opção</option>
                        <option value="asc">Mais Antiga</option>
                        <option value="desc">Mais Recente</option>
                    </select>
                </div>
            
                @if(Auth::user()->unidadeIdFK == 1)
                    <div class="col-12 d-flex justify-content-end mt-2">
                        <a href="{{ route('atividades.create') }}" class="btn btn-primary">
                            Inserir Atividade
                        </a>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>

<div class="container-xxl" style="max-width: 1500px !important;">
	<div class="col-12 border box-shadow">
        <div class="justify-content-center">
            <div class="table-responsive">
                <table id="tableHome2" class="table table-striped cust-datatable mb-5">
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
                            <th scope="col" class="text-center text-light">Meta</th>
                            <th scope="col" class="text-center text-light">Ações</th>
                        </tr>
                    </thead>

                    <tbody>
                        @foreach ($atividades as $atividade)
                        <tr class="text13">
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

                            <td class="text-center" data-order="{{ \Carbon\Carbon::parse($atividade->data_realizada ?? $atividade->data_prevista)->format('Y-m-d') }}">
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


                            <td class="text-center">
                                @if(Auth::user()->unidade->unidadeTipoFK == 1 || Auth::user()->usuario_tipo_fk == 1)
                                    <div class="custom-actions-wrapper" id="actionsWrapper{{ $atividade->id }}">
                                        <button type="button" onclick="toggleActionsMenu({{ $atividade->id }})" class="custom-actions-btn">
                                            <i class="bi bi-three-dots-vertical"></i>
                                        </button>
                                        
                                        <div class="custom-actions-menu">
                                            <ul>
                                                <li>
                                                    <a href="{{ route('atividades.edit', $atividade->id) }}">
                                                        <i class="bi bi-pencil me-2"></i>Editar
                                                    </a>
                                                </li>
                                                <li>
                                                    <a href="{{ route('atividades.show', $atividade->id) }}">
                                                        <i class="bi bi-eye me-2"></i>Visualizar
                                                    </a>
                                                </li>
                                                <li>
                                                    <a href="#" data-bs-toggle="modal" data-bs-target="#deleteModal{{ $atividade->id }}">
                                                        <i class="bi bi-trash me-2"></i>Excluir
                                                    </a>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                @endif
                            </td>
                            
                            
                            {{-- <td>
                                @if(Auth::user()->unidade->unidadeTipoFK == 1 || Auth::user()->usuario_tipo_fk == 1)
                                <div class="d-flex justify-content-center gap-1">
                                    <a href="{{ route('atividades.edit', $atividade->id) }}" class="warning" style="font-size: 13px;"><i class="bi bi-pencil"></i></a>
                                    <a href="{{ route('atividades.show', $atividade->id) }}" class="primary">
                                        <i class="bi bi-eye"></i>
                                    </a>
                                    <button type="button" class="danger" data-bs-toggle="modal" data-bs-target="#deleteModal{{ $atividade->id }}"><i class="bi bi-trash"></i></button>
                                </div>
                                @endif
                            </td> --}}

                        </tr>
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

<x-back-button/>

<script>
    $(document).ready(function() {
        let table = $('#tableHome2').DataTable({
            order: [
                [7, "asc"]
            ],
            autoWidth: false,
            columnDefs: [{
                targets: "_all",
                defaultContent: ""
            }],
            language: {
                url: '{{ asset('js/pt_br-datatable.json') }}',
                search: "Procurar:",
                info: 'Mostrando página _PAGE_ de _PAGES_',
                infoEmpty: 'Sem monitoramentos disponíveis no momento',
                infoFiltered: '(Filtrados do total de _MAX_ monitoramentos)',
                zeroRecords: 'Nada encontrado. Se achar que isso é um erro, contate o suporte.',
                paginate: {
                    next: "Próximo",
                    previous: "Anterior"
                },
                responsive: true
            }
        });

        $('#filter-data').on('change', function() {
            let order = $(this).val();
            table.order([7, order]).draw();
        });

        $('#filter-canal').on('change', function() {
            let canal = $(this).val();
            table.column(6).search(canal).draw();
        });

        $('#filter-publico').on('change', function() {
            let publico = $(this).val();
            table.column(4).search(publico).draw();
        });

        $('#filter-evento').on('change', function() {
            let evento = $(this).val();
            table.column(5).search(evento).draw();
        })
    });
</script>

<script>
	function toggleActionsMenu(id) {
		const wrapper = document.getElementById(`actionsWrapper${id}`);

		// Alterna o menu atual
		wrapper.classList.toggle('open');

		// Fecha os outros menus abertos
		document.querySelectorAll('.custom-actions-wrapper').forEach((el) => {
			if (el.id !== `actionsWrapper${id}`) {
				el.classList.remove('open');
			}
		});
	}

	// Fecha o dropdown ao clicar fora
	window.addEventListener('click', function (e) {
		document.querySelectorAll('.custom-actions-wrapper').forEach(wrapper => {
			if (!wrapper.contains(e.target)) {
				wrapper.classList.remove('open');
			}
		});
	});
</script>


@endsection