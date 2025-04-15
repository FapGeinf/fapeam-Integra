@extends('layouts.app')
@section('content')
@section('title') {{ 'Lista de Indicadores' }} @endsection

<link rel="stylesheet" href="{{ asset('css/show.css') }}">
<link rel="stylesheet" href="{{ asset('css/buttons.css') }}">
<link rel="stylesheet" href="{{ asset('css/dropdown.css') }}">
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

<div class="container-xxl pt-5">
	<div class="col-12 border box-shadow">

		<div class="justify-content-center">
			<h5 class="text-center mb-1">Indicadores</h5>
			<a class="justify-content-center align-items-center d-flex text-decoration-none highlighted-btn-sm highlight-blue mx-auto" href="{{ route('indicadores.create') }}" style="width: 18%;">
				<i class="bi bi-plus-circle me-1"></i>Adicionar Indicador</a>
		</div>
		
		<div>
			<table id="indicadores-table" class="table table-bordered table-striped">
				<thead>
					<tr class="text13">
						<th class="text-center text-light">N°</th>
						<th class="text-center text-light">Descrição</th>
						<th class="text-center text-light">Eixo</th>
						<th class="text-center text-light">Ações</th>
					</tr>
				</thead>

				<tbody>
					@foreach($indicadores as $indicador)
					<tr class="text13">
						<td class="text-center">{{ $indicador->id }}</td>

						<td class="text-center">{{ $indicador->descricaoIndicador }}</td>

						<td>EIXO {{$indicador->eixo->id}} - {{ $indicador->eixo->nome}}</td>

						<td class="d-flex justify-content-center" style="border-left: none; border-bottom: none;">
							<div class="custom-actions-wrapper" id="actionsWrapper{{ $indicador->id }}">

								<button type="button" onclick="toggleActionsMenu({{ $indicador->id }})" class="custom-actions-btn">
									<i class="bi bi-three-dots-vertical"></i>
								</button>

								<div class="custom-actions-menu">
									<ul>
										<li>
											<a href="{{ route('indicadores.edit', $indicador->id) }}">
												<i class="bi bi-pencil me-2"></i>Editar
											</a>
										</li>
									</ul>
								</div>
							</div>
						</td>
					
					</tr>
					@endforeach
				</tbody>
			</table>
		</div>

	</div>
</div>

<x-back-button/>

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
	});
</script>

<script>
	function toggleActionsMenu(id) {
		const wrapper = document.getElementById(`actionsWrapper${id}`);
		wrapper.classList.toggle('open');

		// Fecha outros menus abertos
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