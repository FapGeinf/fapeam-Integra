@extends('layouts.app')
@section('title') {{ 'Lista de Providências' }} @endsection
@section('content')

<script src="{{asset('js/jquery-3.6.0.min.js') }}"></script>
<script src="{{ asset('js/dataTables.min.js') }}"></script>
<link rel="stylesheet" href="{{ asset('css/dataTables.dataTables.min.css')}}">
<link rel="stylesheet" href="{{ asset('css/index.css') }}">

<link rel="stylesheet" href="{{ asset('css/show.css') }}">
<link rel="stylesheet" href="{{ asset('css/buttons.css') }}">
<link rel="stylesheet" href="{{ asset('css/dropdown.css') }}">
<script src="{{ asset('js/actionsDropdown.js') }}"></script>
<script defer src="{{ asset('js/respostas/tableFilters.js') }}"></script>
<script src="{{ asset('js/bootstrap.bundle.min.js') }}"></script>
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

			<div class="d-flex justify-content-center mt-2">
				<button id="btnHomologarMultipla" class="footer-btn-pres" disabled>
					<i class="fas fa-check-square me-2"></i><span id="textoBotaoHomologar">Marque para selecionar
						providências</span>
				</button>
			</div>
		</div>
	</div>
</div>

<div class="container-xxl" style="max-width: 1500px !important;">
	<div class="col-12 border box-shadow">
		<div class="container-xxl mb-4" style="max-width: 1500px !important;">
			{{-- <div class="d-flex justify-content-end">
				<button id="btnHomologarMultipla" class="btn btn-success" disabled>
					<i class="fas fa-check-circle me-2"></i>Homologar Selecionadas
				</button>
			</div> --}}
			<button id="selecionarTodasCheckbox" class="btn btn-outline-primary btn-sm">
				<i class="bi bi-check2-square me-1"></i> Selecionar Todas
			</button>
		</div>

		<div class="justify-content-center" id="respostasTableWrapper" data-unidades='@json($unidades)'>
			<table id="respostasTable" class="table table-striped cust-datatable mb-5">
				<thead>
					<tr class="text-center fw-bold" style="white-space: nowrap;">
						<th style="
							min-width: 70px;
							background-color: #fdf3ce !important;
							color: #3f3f3f !important;
							">Selecionar itens
						</th>

						<th scope="col" class="text-center">Usuário</th>
						<th scope="col" class="text-center">Diretoria</th>
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
						<tr>
							<td class="text-center">
								@if (is_null($resposta->homologadaPresidencia))
									<input type="checkbox" class="resposta-checkbox" value="{{ $resposta->id }}">
								@endif
							</td>

							<td class="text-center">{{ $resposta->user->name }}</td>
							<td class="text-center">
								{{ $resposta->monitoramento->risco->unidade->diretoria->diretoriaSigla ?? '' }}
							</td>
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

									<button type="button" class="footer-btn footer-success mt-2 w-100"
										style="white-space: nowrap" ; data-bs-toggle="modal"
										data-bs-target="#homologacaoPresidenciaModal{{ $resposta->id }}">

										<i class="bi bi-check-circle me-1"></i>
										<span>Homologar</span>
									</button>
								@endif
							</td>
						</tr>

						<div class="modal fade" id="homologacaoPresidenciaModal{{ $resposta->id }}" tabindex="-1"
							aria-labelledby="homologacaoPresidenciaModalLabel{{ $resposta->id }}" aria-hidden="true">
							<div class="modal-dialog modal-dialog-centered">
								<div class="modal-content">
									<div class="modal-header">
										<h5 class="modal-title" id="homologacaoPresidenciaModalLabel{{ $resposta->id }}">
											Homologar pela Presidência</h5>
										<button type="button" class="btn-close" data-bs-dismiss="modal"
											aria-label="Fechar"></button>
									</div>

									<div class="modal-body">
										Tem certeza que deseja homologar esta resposta como Presidente?
									</div>

									<div class="modal-footer">
										<button type="button" class="footer-btn footer-secondary"
											data-bs-dismiss="modal">Cancelar</button>
										<form action="{{ route('riscos.homologar', $resposta->id) }}" method="POST"
											class="m-0 p-0">
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

<div class="modal fade" id="confirmarHomologacaoModal" tabindex="-1" aria-labelledby="confirmarHomologacaoLabel"
	aria-hidden="true">
	<div class="modal-dialog modal-dialog-centered">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="confirmarHomologacaoLabel">Confirmar Homologação</h5>
				<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fechar"></button>
			</div>

			<div class="modal-body">
				<p class="mb-3">Tem certeza que deseja homologar as seguintes respostas?</p>
				<div id="listaConfirmarHomologacao"></div>
			</div>

			<div class="modal-footer">
				<button type="button" class="footer-btn footer-secondary" data-bs-dismiss="modal">Cancelar</button>
				<button type="button" id="btnConfirmarHomologacao" class="footer-btn footer-success">Confirmar</button>
			</div>
		</div>
	</div>
</div>

<div class="modal fade" id="resultadoHomologacaoModal" tabindex="-1" aria-labelledby="resultadoHomologacaoLabel"
	aria-hidden="true">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-header bg-primary text-white">
				<h5 class="modal-title" id="resultadoHomologacaoLabel">Resultado da Homologação</h5>
				<button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
					aria-label="Fechar"></button>
			</div>

			<div class="modal-body">
				<div id="listaHomologadas"></div>
				<div id="listaNaoHomologadas" class="mt-4"></div>
			</div>

			<div class="modal-footer">
				<button type="button" class="btn btn-primary" data-bs-dismiss="modal">Fechar</button>
			</div>
		</div>
	</div>
</div>

<script>
	document.addEventListener('DOMContentLoaded', () => {
		const btnHomologar = document.getElementById('btnHomologarMultipla');
		const confirmarModalEl = document.getElementById('confirmarHomologacaoModal');
		const confirmarModal = new bootstrap.Modal(confirmarModalEl);
		const resultadoModalEl = document.getElementById('resultadoHomologacaoModal');
		const resultadoModal = resultadoModalEl ? new bootstrap.Modal(resultadoModalEl) : null;

		let btnConfirmar = document.getElementById('btnConfirmarHomologacao');
		const listaConfirmar = document.getElementById('listaConfirmarHomologacao');

		function toggleButton() {
			const checkboxes = document.querySelectorAll('.resposta-checkbox:checked');
			const textoBotao = document.getElementById('textoBotaoHomologar');
			const btnHomologar = document.getElementById('btnHomologarMultipla');

			if (checkboxes.length === 0) {
				btnHomologar.disabled = true;
				btnHomologar.classList.remove('footer-success');
				textoBotao.textContent = 'Marque a caixa para selecionar providências';
			} else {
				btnHomologar.disabled = false;
				btnHomologar.classList.add('footer-success');
				textoBotao.textContent = 'Homologar selecionadas';
			}
		}

		function getRowData(checkbox) {
			const row = checkbox.closest('tr');
			return {
				id: checkbox.value,
				usuario: row.cells[1].textContent.trim(),
				unidade: row.cells[2].textContent.trim(),
				monitoramento: row.cells[3].textContent.trim().substring(0, 50) + '...',
				providencia: row.cells[4].textContent.trim().substring(0, 50) + '...'
			};
		}

		document.addEventListener('change', (event) => {
			if (event.target.classList.contains('resposta-checkbox')) {
				toggleButton();
			}
		});

		toggleButton();

		btnHomologar.addEventListener('click', (event) => {
			event.preventDefault();

			const checkboxes = document.querySelectorAll('.resposta-checkbox:checked');
			const selectedItems = Array.from(checkboxes).map(checkbox => getRowData(checkbox));

			if (selectedItems.length === 0) {
				alert('Selecione ao menos uma resposta para homologar.');
				return;
			}

			listaConfirmar.innerHTML = `
					<div class="list-group">
						${selectedItems.map((item, index) => `
							<div class="list-group-item" style="background-color: ${index % 2 === 0 ? '#f2f2f2' : '#fff'};">
								<div><strong>Usuário:</strong> ${item.usuario}</div>
								<div><strong>Unidade:</strong> ${item.unidade}</div>
								<div><strong>Monitoramento:</strong> ${item.monitoramento}</div>
							</div>
						`).join('')}
					</div>
					<div class="mt-3 text-center"><strong>Total:</strong> ${selectedItems.length} item(s) selecionado(s)</div>
				`;

			confirmarModal.show();

			const newBtnConfirmar = btnConfirmar.cloneNode(true);
			btnConfirmar.replaceWith(newBtnConfirmar);
			btnConfirmar = newBtnConfirmar;

			btnConfirmar.addEventListener('click', async () => {
				confirmarModal.hide();

				try {
					const token = document.querySelector('meta[name="csrf-token"]').content;
					const selectedIds = selectedItems.map(item => item.id);

					const response = await fetch(@json(route('riscos.homologar.multipla')), {
						method: 'POST',
						headers: {
							'Content-Type': 'application/json',
							'X-CSRF-TOKEN': token,
							'Accept': 'application/json'
						},
						body: JSON.stringify({ respostas_ids: selectedIds })
					});

					if (!response.ok) {
						throw new Error(`Erro HTTP: ${response.status}`);
					}

					const data = await response.json();

					if (resultadoModal) {
						let homologadasHTML = '<h5 class="text-success">Homologadas com sucesso</h5>';
						let naoHomologadasHTML = '<h5 class="text-danger mt-4">Não homologadas</h5>';

						if (data.homologadas && data.homologadas.length > 0) {
							homologadasHTML += `
								<div class="list-group">
									${data.homologadas.map(id => {
								const item = selectedItems.find(i => i.id == id);

								return item ? `
										<div class="list-group-item list-group-item-success">
											<div><strong>Usuário:</strong> ${item.usuario}</div>
											<div><strong>Unidade:</strong> ${item.unidade}</div>
										</div>
									` : '';
							}).join('')}
								</div>

								<div class="text-end mt-2">Total: ${data.homologadas.length}</div>
								`;
						} else {
							homologadasHTML += '<p>Nenhuma resposta foi homologada.</p>';
						}

						if (data.nao_homologadas && data.nao_homologadas.length > 0) {
							naoHomologadasHTML += `
									<div class="list-group">
										${data.nao_homologadas.map(item => {
								const originalItem = selectedItems.find(i => i.id == item.id);
								return originalItem ? `
										<div class="list-group-item list-group-item-danger">
											<div><strong>Usuário:</strong> ${originalItem.usuario}</div>
											<div><strong>Unidade:</strong> ${originalItem.unidade}</div>
											<div class="text-danger"><strong>Motivo:</strong> ${item.motivo || 'Não especificado'}</div>
										</div>
									` : '';
							}).join('')}
									</div>

									<div class="text-end mt-2">Total: ${data.nao_homologadas.length}</div>
									`;
						} else {
							naoHomologadasHTML = '';
						}

						const listaHomologadas = document.getElementById('listaHomologadas');
						const listaNaoHomologadas = document.getElementById('listaNaoHomologadas');

						if (listaHomologadas) listaHomologadas.innerHTML = homologadasHTML;
						if (listaNaoHomologadas) listaNaoHomologadas.innerHTML = naoHomologadasHTML;

						resultadoModal.show();
					}

					checkboxes.forEach(cb => cb.checked = false);
					toggleButton();

					setTimeout(() => window.location.reload(), 3000);

				} catch (error) {
					console.error('Erro na homologação:', error);
					alert(`Falha na homologação: ${error.message}`);
				}
			});
		});

		document.getElementById('selecionarTodasCheckbox').addEventListener('click', () => {
			const allCheckboxes = document.querySelectorAll('.resposta-checkbox');
			const allChecked = Array.from(allCheckboxes).every(checkbox => checkbox.checked);

			allCheckboxes.forEach(checkbox => {
				if (!checkbox.disabled) {
					checkbox.checked = !allChecked;
				}
			});

			toggleButton();
		});

		const selectAllCheckbox = document.getElementById('selectAllCheckbox');
		selectAllCheckbox.addEventListener('change', () => {
			const allCheckboxes = document.querySelectorAll('.resposta-checkbox');
			allCheckboxes.forEach(checkbox => {
				if (!checkbox.disabled) {
					checkbox.checked = selectAllCheckbox.checked;
				}
			});
			toggleButton();
		});
		
	});
</script>
@endsection