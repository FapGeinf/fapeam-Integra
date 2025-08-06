@extends('layouts.app')
@section('title') {{ 'Lista de Atividades' }} @endsection
@section('content')

<script src="{{asset('js/jquery-3.6.0.min.js') }}"></script>
<script src="{{ asset('js/dataTables.min.js') }}"></script>
<link rel="stylesheet" href="{{ asset('css/dataTables.dataTables.min.css')}}">
<link rel="stylesheet" href="{{ asset('css/index.css') }}">

<link rel="stylesheet" href="{{ asset('css/show.css') }}">
<link rel="stylesheet" href="{{ asset('css/buttons.css') }}">
<link rel="stylesheet" href="{{ asset('css/dropdown.css') }}">
<script src="{{ asset('js/actionsDropdown.js') }}"></script>

<script src="{{ asset('js/respostas/tableRespostas.js') }}"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

<style>
	body {
		font-family: 'Poppins', sans-serif;
	}

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
		background-color: #f8fafc !important;
	}

	.input-disabled {
		background-color: #f0f0f0 !important;
	}

	.border-grey {
		border: 1px solid #ccc !important;
	}

	div.dt-container div.dt-layout-row {
		font-size: 13px;
	}
</style>

<div class="alert-container pt-5">
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
			<h5 class="text-center mb-1">Painel de Providências</h5>

			<div class="row g-3 mt-3">
				<div class="col-12 col-sm-6 col-md-3">
					<label for="filter-unidade" class="fw-bold">Unidades:</label>
					<select name="filter-unidade" id="filter-unidade" class="form-select pointer">
						<option value="" selected disabled>Selecione uma unidade</option>
						@foreach ($unidades as $unidade)
							<option value="{{ $unidade->unidadeSigla }}">{{ $unidade->unidadeSigla }}</option>
						@endforeach
					</select>
				</div>
			</div>
		</div>
	</div>
</div>

<div class="container-xxl" style="max-width: 1500px !important;">
	<div class="col-12 border box-shadow">
		<div class="justify-content-center">
			<table id="respostasTable" class="table table-striped cust-datatable mb-5">
				<thead>
					<tr class="text-center fw-bold" style="white-space: nowrap;">
						<th scope="col" class="text-center">Usuário</th>
						<th scope="col" class="text-center">Unidade</th>
						<th scope="col" class="text-center">Monitoramento</th>
						<th scope="col" class="text-center">Providência</th>
						<th scope="col" class="text-center">Status</th>
						<th scope="col" class="text-center">Anexo</th>
						<th scope="col" class="text-center">Homologação Presidência</th>
						<th scope="col" class="text-center">Ações</th>
					</tr>
				</thead>

				<tbody>
					@foreach ($respostas as $resposta)
						<tr>
							<td class="text-center">{{ $resposta->user->name }}</td>
							<td class="text-center">{{ $resposta->monitoramento->risco->unidade->unidadeSigla ?? '' }}</td>
							<td>{!! $resposta->monitoramento->monitoramentoControleSugerido!!}</td>
							<td>{!! $resposta->respostaRisco !!}</td>
							<td class="text-center">{{ $resposta->monitoramento->statusMonitoramento }}</td>

							<td class="text-center">
								@if ($resposta->anexo)
										<a href="{{ asset('storage/' . $resposta->anexo) }}" target="_blank" title="Abrir anexo">
												<i class="fas fa-file-lines fs-5 text-primary"></i>
										</a>
								@else
										<span class="text-muted">Sem anexo</span>
								@endif
							</td>

							<td class="text-center">
								@if ($resposta->homologadaPresidencia === null)
								<button type="button" class="footer-btn footer-success"
									data-bs-toggle="modal"
									data-bs-target="#homologacaoPresidenciaModal{{ $resposta->id }}">
									
									<i class="bi bi-check-circle me-1"></i>
									<span>Homologar</span>
								</button>

								@else
									<i class="bi bi-check-circle-fill text-success" title="Homologada"></i>
								@endif
							</td>

							<td class="text-center">
								<div class="custom-actions-wrapper" id="actionsWrapper{{ $resposta->id }}">
									<button type="button" onclick="toggleActionsMenu({{ $resposta->id }})" class="custom-actions-btn">
										<i class="bi bi-three-dots-vertical"></i>
									</button>

									<div class="custom-actions-menu">
										<ul>
											<li>
												<a href="{{ route('riscos.respostas', $resposta->monitoramento->id) }}">
													<i class="bi bi-eye me-2"></i>Visualizar
												</a>
											</li>
										</ul>
									</div>
								</div>
							</td>
						</tr>

						<div class="modal fade" id="homologacaoPresidenciaModal{{ $resposta->id }}" tabindex="-1" aria-labelledby="homologacaoPresidenciaModalLabel{{ $resposta->id }}" aria-hidden="true">
							<div class="modal-dialog modal-dialog-centered">
								<div class="modal-content">
									<div class="modal-header">
										<h5 class="modal-title" id="homologacaoPresidenciaModalLabel{{ $resposta->id }}">Homologar pela Presidência</h5>
										<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fechar"></button>
									</div>

									<div class="modal-body">
										Tem certeza que deseja homologar esta resposta como presidente?
									</div>

									<div class="modal-footer">
										<button type="button" class="footer-btn footer-secondary" data-bs-dismiss="modal">Cancelar</button>
										<form action="{{ route('riscos.homologar', $resposta->id) }}" method="POST" class="m-0 p-0">
											@csrf
											@method('PUT')
											<button type="submit" class="footer-btn footer-success">Homologar</button>
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
@endsection