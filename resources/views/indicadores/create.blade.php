@extends('layouts.app')

@section('title') {{ 'Criar Indicador' }} @endsection

@section('content')

<link rel="stylesheet" href="{{ asset('css/edit.css') }}">
<link rel="stylesheet" href="{{ asset('css/buttons.css') }}">
<script src="{{ asset('ckeditor/ckeditor.js') }}"></script>
<script src="{{ asset('js/indicadores/editorIndicador.js') }}"></script>
<style>
	.form-label {
		margin-bottom: 0 !important;
	}

	.liDP {
		margin-left: 0 !important;
	}

	.form-wrapper3 {
		display: flex;
		justify-content: center; /* Centraliza horizontalmente */
		align-items: center; /* Centraliza verticalmente */
		/* min-height: 60vh;  Altura mínima total da viewport */
		padding: 0 10px; /* Adiciona espaçamento à esquerda e à direita */
		padding-top: 2rem;
	}
</style>

<div class="form-wrapper3 paddingLeft">
	<div class="form_create border">
		<h3 style="text-align: center; margin-bottom: 5px;">
      Criar Indicador
    </h3>

		<div class="tipWarning mb-3">
      <span class="asteriscoTop">*</span>
      Campos obrigatórios
    </div>

		<form action="{{ route('indicadores.store') }}" method="POST">
			@csrf

			<div class="row">
				<div class="col-12">
					<label for="eixo"><span class="asteriscoTop">*</span>Eixo:</label>

					<select class="form-select input-enabled" id="eixo_fk" name="eixo_fk" required>
						@foreach($eixos as $eixo)
							<option value="{{ $eixo->id }}">{{ $eixo->nome }}</option>
						@endforeach
					</select>
				</div>

				{{-- <div class="col-12">
					<label for="nome" class="form-label"><span class="asteriscoTop">*</span>Título:</label>
					<input type="text" class="form-control" id="nome" name="nome" required>
				</div> --}}

				<div class="col-12 mb-3">
					<label for="descricao"><span class="asteriscoTop">*</span>Descrição:</label>
					<textarea	textarea class="form-control input-enabled" id="descricaoIndicador" name="descricaoIndicador" rows="3" required></textarea>
				</div>
			</div>

			<hr>

			<div class="d-flex justify-content-end mt-3">
				<button type="submit" class="highlighted-btn-sm highlight-success me-0">Salvar Indicador</button>
			</div>
		</form>
	</div>
</div>

<x-back-button/>
@endsection