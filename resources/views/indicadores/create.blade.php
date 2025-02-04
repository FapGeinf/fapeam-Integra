@extends('layouts.app')

@section('content')
<div class="container">
	<h1>Criar Indicador</h1>
	<form action="{{ route('indicadores.store') }}" method="POST">
		@csrf
		<div class="form-group">
			<label for="nomeIndicador">nomeIndicador</label>
			<input type="text" class="form-control" id="nomeIndicador" name="nomeIndicador" required>
		</div>
		<div class="form-group">
			<label for="descricaoIndicador">Descrição</label>
			<textarea class="form-control" id="descricaoIndicador" name="descricaoIndicador" rows="3" required></textarea>
		</div>
		<div class="form-group">
			<label for="eixo">Eixo</label>
			<select class="form-control" id="eixo" name="eixo" required>
				@foreach($eixos as $eixo)
					<option value="{{ $eixo->id }}">{{ $eixo->nome }}</option>
				@endforeach
			</select>
		</div>
		<button type="submit" class="btn btn-primary">Salvar</button>
	</form>
</div>
@endsection</form></div>