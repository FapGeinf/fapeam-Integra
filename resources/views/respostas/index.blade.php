@extends('layouts.app')
@section('title') {{ 'Lista de Providências' }} @endsection
@section('content')

<script src="{{asset('js/jquery-3.6.0.min.js') }}"></script>
<script src="{{ asset('js/dataTables.min.js') }}"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<link rel="stylesheet" href="{{ asset('css/dataTables.dataTables.min.css')}}">
<link rel="stylesheet" href="{{ asset('css/index.css') }}">

<link rel="stylesheet" href="{{ asset('css/show.css') }}">
<link rel="stylesheet" href="{{ asset('css/buttons.css') }}">
<link rel="stylesheet" href="{{ asset('css/dropdown.css') }}">
<script src="{{ asset('js/actionsDropdown.js') }}"></script>
<script defer src="{{ asset('js/respostas/tableFilters.js') }}"></script>

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
			<h5 class="text-center mb-1">Lista de Providências</h5>
		</div>
	</div>
</div>

<div class="container-xxl" style="max-width: 1500px !important;">
	<div class="col-12 border box-shadow">
		<div class="justify-content-center" id="respostasTableWrapper" data-unidades='@json($unidades)'>
			<button id="btnHomologarSelecionados" class="btn btn-success my-3">
  			<i class="bi bi-check-circle"></i> Homologar Selecionados
			</button>

			<table id="respostasTable" class="table table-striped cust-datatable mb-5">
				<thead>
					<tr class="text-center fw-bold" style="white-space: nowrap;">
						<th><input type="checkbox" id="select-all"></th>
						<th scope="col" class="text-center">Usuário</th>
						<th scope="col" class="text-center">Unidade</th>
						<th scope="col" class="text-center">Monitoramento</th>
						<th scope="col" class="text-center">Providência</th>
						<th scope="col" class="text-center">Status</th>
						<th scope="col" class="text-center">Anexo</th>
						<th scope="col" class="text-center">Ações</th>
					</tr>
				</thead>


				<tbody>
					@foreach ($respostas as $resposta)
						<tr data-id="{{ $resposta->id }}">
							<td class="text-center">
								@if (is_null($resposta->homologadaPresidencia))
									<input type="checkbox" class="resposta-checkbox" name="respostas[]" value="{{ $resposta->id }}">
								@endif
							</td>
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
									<a href="{{ route('riscos.respostas', $resposta->monitoramento->id) }}"
										class="footer-btn footer-primary text-decoration-none w-100 d-inline-block"
										role="button">
										<i class="bi bi-eye me-1"></i>
										<span>Visualizar</span>
									</a>

									<button type="button"
										class="footer-btn footer-success mt-2 w-100"
										style="white-space: nowrap";
										data-bs-toggle="modal"
										data-bs-target="#homologacaoPresidenciaModal{{ $resposta->id }}">
										<i class="bi bi-check-circle me-1"></i>
										<span>Homologar</span>
									</button>
								@endif
							</td>

						</tr>

						<div class="modal fade" id="homologacaoPresidenciaModal{{ $resposta->id }}" tabindex="-1" aria-labelledby="homologacaoPresidenciaModalLabel{{ $resposta->id }}" aria-hidden="true">
							<div class="modal-dialog modal-dialog-centered">
								<div class="modal-content">
									<div class="modal-header">
										<h5 class="modal-title" id="homologacaoPresidenciaModalLabel{{ $resposta->id }}">Homologar Providência</h5>
										<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fechar"></button>
									</div>

									<div class="modal-body">
										Tem certeza que deseja homologar esta providência ?
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

			<div class="modal fade" id="modalHomologar" tabindex="-1" aria-labelledby="modalHomologarLabel" aria-hidden="true">
				<div class="modal-dialog">
					<div class="modal-content">
						<div class="modal-header">
							<h5 class="modal-title" id="modalHomologarLabel">Confirmar Homologação</h5>
							<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fechar"></button>
						</div>
						<div class="modal-body">
							<p>Você está prestes a homologar as seguintes providências:</p>
							<ul id="listaIdsSelecionados" style="max-height: 200px; overflow-y: auto;"></ul>
						</div>
						<div class="modal-footer">
							<form id="formHomologarSelecionados" method="POST" action="{{ route('respostas.homologarMultiplas') }}">
								@csrf
								@method('PUT')
								<input type="hidden" name="respostasSelecionadas" id="inputRespostasSelecionadas" value="">
								<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
								<button type="submit" class="btn btn-success">Confirmar Homologação</button>
							</form>
						</div>
					</div>
				</div>
			</div>

		</div>
	</div>
</div>




@endsection