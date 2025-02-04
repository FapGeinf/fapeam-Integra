<!DOCTYPE html>
@extends('layouts.app')
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
					<th>ID</th>
					<th>Nome</th>
					<th>Descrição</th>
				</tr>
			</thead>
			<tbody>
				@foreach($indicadores as $indicador)
				<tr>
					<td>{{ $indicador->id }}</td>
					<td>{{ $indicador->nomeIndicador }}</td>
					<td>{{ $indicador->descricaoIndicador }}</td>
				</tr>
				@endforeach
			</tbody>
		</table>
	</div>
</body>
</html>