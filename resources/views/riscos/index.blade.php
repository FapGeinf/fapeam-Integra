@extends('layouts.app')

@section('content')
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Document</title>

	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">

	<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.25/css/jquery.dataTables.css">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
	<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.10.25/js/jquery.dataTables.js"></script>

	<style>
		 body {
        font-size: 0.875rem; /* Ajuste este valor conforme necessário */
    }
	</style>
</head>
<body>
	@if(session('error'))
		<script>alert('{{ session('error') }}');</script>
	@endif
	<br>
	@if (Auth::user()->unidade->unidadeTipoFK == 1)
		<a href="{{route('riscos.create')}}" class="btn btn-primary mb-3">Novo</a>
	@endif
	<table id="tableHome" class="table table-striped table-bordered ">
		<thead class="thead-dark">
			<tr>
				<th>Unidade</th>
				<th>Evento de Risco</th>
				<th>Causa</th>
				<th>Consequência</th>
				<th>Avaliação</th>
			</tr>
		</thead>
		<tbody>
			@foreach ($riscos as $risco)
				<tr style="cursor: pointer;" onclick="window.location='{{ route('riscos.show', $risco->id) }}';">
					<td>{{$risco->unidade->unidadeNome}}</td>
					<td>{!!$risco->riscoEvento!!}</td>
					<td>{!!$risco->riscoCausa!!}</td>
					<td>{!!$risco->riscoConsequencia!!}</td>
					<td>{{$risco->riscoAvaliacao}}</td>
				</tr>
			@endforeach
		</tbody>
	</table>

	<script>
		$(document).ready(function(){
			$('#tableHome').DataTable();
		})
	</script>

</body>
</html>
@endsection
