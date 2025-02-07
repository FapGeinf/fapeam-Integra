@extends('layouts.app')

@section('title') {{ 'Criar Indicadores' }} @endsection

@section('content')

<link rel="stylesheet" href="{{ asset('css/edit.css') }}">

<style>
	.form-label {
		margin-bottom: 0 !important;
	}

	.liDP {
		margin-left: 0 !important;
	}
</style>

<div class="form-wrapper paddingLeft">
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
					<label for="eixo" class="form-label">Eixo:</label>
					<select class="form-select" id="eixo" name="eixo" required>
						@foreach($eixos as $eixo)
							<option value="{{ $eixo->id }}">{{ $eixo->nome }}</option>
						@endforeach
					</select>
				</div>

				<div class="col-12">
					<label for="nome" class="form-label">Título:</label>
					<input type="text" class="form-control" id="nome" name="nome" required>
				</div>

				<div class="col-12">
					<label for="descricao">Descrição:</label>
					<textarea	textarea class="form-control" id="descricao" name="descricao" rows="3" required></textarea>
				</div>
			</div>

			<div class="d-flex justify-content-end mt-3">
				<button type="submit" class="blue-btn me-0">Salvar</button>
			</div>
		</form>
	</div>
</div>
@endsection