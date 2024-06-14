@extends('layouts.app')

@section('content')
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="stylesheet" href="{{ asset('css/home.css')}}">
	<title>Document</title>
</head>
<body>
	
		<a href="{{route('riscos.create')}}">Novo</a>
		<table>
			<tr>
					<th>Evento de Risco</th>
					<th>Causa</th>
					<th>Consequência</th>
					<th>Avaliação</th>
					<th>Unidade</th>
			</tr>
			@foreach ($riscos as $risco)
				<tr>
					<td>{{$risco->riscoEvento}}</td>
					<td>{{$risco->riscoCausa}}</td>
					<td>{{$risco->riscoConsequencia}}</td>
					<td>{{$risco->riscoAvaliacao}}</td>
					<td>{{$risco->unidade->unidadeNome}}</td>
                    <td><a href="{{ route('riscos.show', $risco->id) }}">Detalhes</a></td>
				</tr>
			@endforeach
		</table>
</body>
</html>
@endsection
