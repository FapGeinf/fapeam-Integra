@extends('layouts.app')

@section('content')
<div class="container">
	<h1>Editar Indicador</h1>
	<h2>Indicador: {{ $indicador->nomeIndicador }}</h2>
	<p>Descrição: {{ $indicador->descricaoIndicador }}</p>
	<p>Valor: {{ $indicador->eixo->nome }}</p>
	<form action="{{ route('indicadores.update', $indicador->id) }}" method="POST">
		@csrf
		@method('PUT')
		
		<div class="form-group">
			<label for="nome">Nome do Indicador</label>
			<input type="text" class="form-control" id="nome" name="nome" value="{{ $indicador->nomeIndicador }}" required>
		</div>

		<div class="form-group">
			<label for="descricao">Descrição</label>
			<textarea class="form-control" id="descricao" name="descricao" rows="3" required>{{ $indicador->descricaoIndicador }}</textarea>
		</div>



		<button type="submit" class="btn btn-primary">Salvar</button>
		<a href="{{ route('indicadores.index') }}" class="btn btn-secondary">Cancelar</a>
	</form>
</div>
@endsection