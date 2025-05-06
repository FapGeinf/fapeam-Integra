@extends('layouts.app')

@section('title') {{ 'Editar Indicador' }} @endsection

@section('content')

<link rel="stylesheet" href="{{ asset('css/edit.css') }}">

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
		min-height: 60vh; /* Altura mínima total da viewport */
		padding: 0 10px; /* Adiciona espaçamento à esquerda e à direita */
	}
</style>

<div class="form-wrapper3 paddingLeft">
	<div class="form_create border">
		<h3 style="text-align: center; margin-bottom: 5px;">
      Editar Indicador
    </h3>

		<form action="{{ route('indicadores.update', $indicador->id) }}" method="POST">
			@csrf
			@method('PUT')

			<div class="row">
				<div class="col-12">
					<label for="eixo_fk" class="form-label">Eixo:</label>
					<select class="form-select" id="eixo_fk" name="eixo_fk" required>
						@foreach($eixos as $eixo)
							<option value="{{ $eixo->id }}"{{ $eixo->id }} - {{ $eixo->id == $indicador->eixo_fk ? 'selected' : '' }}>
								{{ $eixo->nome }}
							</option>
						@endforeach
					</select>
				</div>

				{{-- <div class="col-12">
					<label for="nome" class="form-label">Nome do Indicador:</label>
					<input type="text" class="form-control" id="nome" name="nome" value="{{ $indicador->nomeIndicador }}" required>
				</div> --}}

				<div class="col-12">
					<label for="descricaoIndicador">Descrição</label>
					<textarea class="form-control" id="descricaoIndicador" name="descricaoIndicador" rows="3" required>{{ $indicador->descricaoIndicador }}</textarea>
				</div>
			</div>

			<div class="d-flex justify-content-end mt-3">
				<button type="submit" class="blue-btn">Salvar</button>
				<a href="{{ route('indicadores.index') }}" class="grey-btn me-0">Cancelar</a>
			</div>
			
		</form>
	</div>
</div>

<x-back-button/>
@endsection