@extends('layouts.app')

@section('title') {{ 'Editar Indicador' }} @endsection

@section('content')

	<link rel="stylesheet" href="{{ asset('css/edit.css') }}">
	<link rel="stylesheet" href="{{ asset('css/buttons.css') }}">
	<script src="{{ asset('ckeditor/ckeditor.js') }}"></script>
	<script src="{{ asset('js/indicadores/editorIndicador.js') }}"></script>
	<script src="{{ asset('js/modais/editIndicador.js') }}"></script>
	<script src="{{ asset('js/bootstrap.bundle.min.js') }}"></script>
	<style>
		.form-label {
			margin-bottom: 0 !important;
		}

		.liDP {
			margin-left: 0 !important;
		}

		.form-wrapper3 {
			display: flex;
			justify-content: center;
			/* Centraliza horizontalmente */
			align-items: center;
			/* Centraliza verticalmente */
			/* min-height: 60vh;  Altura mínima total da viewport */
			padding: 0 10px;
			/* Adiciona espaçamento à esquerda e à direita */
			padding-top: 2rem;
		}
	</style>

	<div class="form-wrapper3 paddingLeft">
		<div class="form_create border">
			<h3 style="text-align: center; margin-bottom: 5px;">
				Editar Indicador
			</h3>

			<form action="{{ route('indicadores.update', $indicador->id) }}" method="POST" id="formEditIndicador">
				@csrf
				@method('PUT')

				<div class="row">
					<div class="col-12">
						<label for="eixo" class="form-label">Eixo:</label>
						<select class="form-select" id="eixo_fk" name="eixo_fk" required>
							@foreach($eixos as $eixo)
								<option value="{{ $eixo->id }}" {{ $eixo->id }} - {{ $eixo->id == $indicador->eixo_fk ? 'selected' : '' }}>
									{{ $eixo->nome }}
								</option>
							@endforeach
						</select>
					</div>

					<div class="col-12">
						<label for="nome" class="form-label">Nome do Indicador:</label>
						<input type="text" class="form-control" id="nomeIndicador" name="nomeIndicador"
							value="{{ $indicador->nomeIndicador }}" required>
					</div>

					<div class="col-12 mb-3">
						<label for="descricao">Descrição:</label>
						<textarea class="form-control input-enabled" id="descricaoIndicador" name="descricaoIndicador"
							rows="3" required>{{ $indicador->descricaoIndicador }}</textarea>
					</div>
				</div>

				<hr>

				<div class="d-flex justify-content-end mt-4">
					<a href="{{ route('indicadores.index') }}"
						class="highlighted-btn-sm highlight-btn-lg highlight-grey text-decoration-none me-2">Cancelar</a>
					<button type="button" onclick="showConfirmationModal()" class="highlighted-btn-sm highlight-success me-0">Salvar Edição</button>
				</div>
			</form>
		</div>
	</div>
	<div class="modal fade" id="confirmationModal" tabindex="-1" aria-labelledby="confirmationModalLabel"
		aria-hidden="true">
		<div class="modal-dialog modal-lg modal-dialog-centered">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title" id="confirmationModalLabel">Confirmação de Edição</h5>
					<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
				</div>

				<div class="modal-body">
					<div id="modalContent">
						{{-- DADOS DO MODAL SERÃO GERADOS DINAMICAMENTE AQUI --}}
					</div>
				</div>

				<div class="modal-footer">
					<button type="button" class="highlighted-btn-sm highlight-grey" data-bs-dismiss="modal">Voltar e
						corrigir</button>
					<button type="button" onclick="formSubmit()" class="highlighted-btn-sm highlight-success">Confirmar
						Edição</button>
				</div>
			</div>
		</div>
	</div>

	<x-back-button />
@endsection