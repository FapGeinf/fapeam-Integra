@extends('layouts.app')
@section('content')
@section('title') {{ 'Lista de Indicadores' }} @endsection

<link rel="stylesheet" href="{{ asset('css/index.css') }}">
<link rel="stylesheet" href="{{ asset('css/atividades.css') }}">
<script src="{{ asset('js/jquery-3.6.0.min.js') }}"></script>
<script src="{{ asset('js/dataTables.min.js') }}"></script>
<link rel="stylesheet" href="{{ asset('css/dataTables.dataTables.min.css') }}">

<style>
	.form-label {
		margin-bottom: 0 !important;
	}

	.liDP {
		margin-left: 0 !important;
	}
</style>

<div class="px__custom pt-5">
	<div class="col-12 border__custom main-datatable" style="border-bottom: 0 !important; border-top-left-radius: 10px; border-top-right-radius: 10px">
	<div class="d-flex justify-content-center text-center p-2" 
			style="
				flex-direction: column;
				background-color: #f1f3f5;
		border-top-left-radius: 10px;
		border-top-right-radius: 10px;">
		<h3 class="fw-bold my-3">Indicadores</h3>
	</div>
	</div>
	
	<div class="">
		<div class="col-12 border__custom main-datatable">
			<div class="container-fluid pt-4 pb-4">
				<div class="mb-4 text-end">
					<a href="{{ route('indicadores.create') }}" class="blue-btn">Adicionar Indicador</a>
				</div>
				
				<table id="indicadores-table" class="table table-bordered table-striped">
					<thead>
						<tr>
							<th class="text-center">N°</th>
							{{-- <th class="text-center">Nome</th> --}}
							<th class="text-center">Descrição</th>
							<th class="text-center">Eixo</th>
							<th class="text-center">Ações</th>
						</tr>
					</thead>
					<tbody>
						@foreach($indicadores as $indicador)
						<tr>
							<td>{{ $indicador->id }}</td>
							{{-- <td>{{ $indicador->nomeIndicador }}</td> --}}
							<td>{{ $indicador->descricaoIndicador }}</td>
							<td>EIXO {{$indicador->eixo->id}} - {{ $indicador->eixo->nome}}</td>
							<td>
								<a href="{{ route('indicadores.edit', $indicador->id) }}" class="btn btn-warning btn-sm">Editar</a>
							</td>
						</tr>
						@endforeach
					</tbody>
				</table>
			</div>
		</div>
	</div>
</div>

<script>
	$(document).ready(function() {
			let table = $('#indicadores-table').DataTable({
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

			// $('#filter-data').on('change', function() {
			// 		let order = $(this).val();
			// 		table.order([7, order]).draw();
			// });

			// $('#filter-canal').on('change', function() {
			// 		let canal = $(this).val();
			// 		table.column(6).search(canal).draw();
			// });

			// $('#filter-publico').on('change', function() {
			// 		let publico = $(this).val();
			// 		table.column(4).search(publico).draw();
			// });

			// $('#filter-evento').on('change', function() {
			// 		let evento = $(this).val();
			// 		table.column(5).search(evento).draw();
			// })
	});
</script>
@endsection