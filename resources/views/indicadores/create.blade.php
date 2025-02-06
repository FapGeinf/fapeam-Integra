@extends('layouts.app')

@section('content')
<div class="container">
	<h1>Criar Indicador</h1>
	<form action="{{ route('indicadores.store') }}" method="POST">
		@csrf
		<div class="form-group">
			<label for="eixo">Eixo</label>
			<select class="form-control" id="eixo" name="eixo" required>
				@foreach($eixos as $eixo)
					<option value="{{ $eixo->id }}">{{ $eixo->nome }}</option>
				@endforeach
			</select>
		</div>
		<div class="form-group">
			<label for="nome">Titulo</label>
			<input type="text" class="form-control" id="nome" name="nome" required>
		</div>
		<div class="form-group">
			<label for="descricao">Descrição</label>
			<textarea class="form-control" id="descricao" name="descricao" rows="3" required></textarea>
		</div>
		<button type="submit" class="btn btn-primary">Salvar</button>
	</form>
</div>
</div>
@endsection