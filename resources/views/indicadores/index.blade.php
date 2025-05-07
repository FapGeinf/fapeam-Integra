@extends('layouts.app')
@section('content')
	@section('title') {{ 'Lista de Indicadores' }} @endsection

	<link rel="stylesheet" href="{{ asset('css/show.css') }}">
	<link rel="stylesheet" href="{{ asset('css/buttons.css') }}">
	<link rel="stylesheet" href="{{ asset('css/dropdown.css') }}">
	<script src="{{ asset('js/jquery-3.6.0.min.js') }}"></script>
	<script src="{{ asset('js/dataTables.min.js') }}"></script>
	<link rel="stylesheet" href="{{ asset('css/dataTables.dataTables.min.css') }}">
	<script src="{{ asset('js/indicadores/indicadoresTable.js') }}"></script>
	<script src="{{ asset('js/actionsDropdown.js') }}"></script>

	<style>
		.form-label {
			margin-bottom: 0 !important;
		}

		.liDP {
			margin-left: 0 !important;
		}

		div.dt-container div.dt-layout-row {
			font-size: 13px;
		}
	</style>

	<div class="container-xxl pt-5">
		<div class="col-12 border box-shadow">
		
			@if(session('success'))
				<div class="alert alert-success alert-dismissible fade show" role="alert">
					{{ session('success') }}
					<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Fechar"></button>
				</div>
			@endif

			@if($errors->any())
				<div class="alert alert-danger alert-dismissible fade show" role="alert">
					@foreach($errors->all() as $error)
						<div>{{ $error }}</div>
					@endforeach
					<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Fechar"></button>
				</div>
			@endif


			<div class="justify-content-center">
				<h5 class="text-center mb-1">Indicadores</h5>
				<a class="justify-content-center align-items-center d-flex text-decoration-none highlighted-btn-sm highlight-blue mx-auto"
					href="{{ route('indicadores.create') }}" style="width: 200px;">
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

								<td class="d-flex justify-content-center" style="border: none !important;">
									<div class="custom-actions-wrapper" id="actionsWrapper{{ $indicador->id }}">

										<button type="button" onclick="toggleActionsMenu({{ $indicador->id }})"
											class="custom-actions-btn">
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
	<x-back-button />
@endsection