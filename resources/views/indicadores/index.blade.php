
@extends('layouts.app')
@section('content')
@section('title') {{ 'Lista de Atividades' }} @endsection
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Indicadores</title>
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
	<div class="container mt-5">
		<h2 class="mb-4">Indicadores</h2>
		<table class="table table-bordered">
			<thead>
				<tr>
					<th>N°</th>
					<th>Nome</th>
					<th>Descrição</th>
					<th>Eixo</th>
					<th>Edição</th>
				</tr>
			</thead>
			<tbody>
				@foreach($indicadores as $indicador)
				<tr>
					<td>{{ $indicador->id }}</td>
					<td>{{ $indicador->nomeIndicador }}</td>
					<td>{{ $indicador->descricaoIndicador }}</td>
					<td>EIXO {{$indicador->eixo->id}} - {{ $indicador->eixo->nome}}</td>
					<td>
						<a href="{{ route('indicadores.edit', $indicador->id) }}" class="btn btn-warning btn-sm">Editar</a>
					</td>
				</tr>
				@endforeach
			</tbody>
		</table>
		<a href="{{ route('indicadores.create') }}" class="btn btn-primary">Adicionar Indicador</a>
	</div>
</body>
</html>
@endsection