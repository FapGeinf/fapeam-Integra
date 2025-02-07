@extends('layouts.app')

@section('content')
<div class="container">
	<h1>Detalhes da Atividade</h1>
	{{dd($atividade)}}
	<div class="card">
		<div class="card-header">
			{{ $atividade->atividade_descricao }}
		</div>
		<div class="card-body">
			<p><strong>Atividade:</strong> {!! $atividade->atividade_descricao !!}</p>
			<p><strong>Descrição:</strong> {!!$atividade->objetivo !!}</p>
			<p><strong>Data de Início:</strong> {{ $atividade->data_prevista }}</p>
			<p><strong>Data de Término:</strong> {{ $atividade->data_realizada }}</p>
			<p><strong>Meta:</strong> {{ $atividade->meta }}</p>
			<p><strong>Realizado:</strong> {{ $atividade->realizado }}</p>

			<p><strong>Status:</strong> {{ $atividade->status }}</p>
		</div>
	</div>
	<a href="{{ route('atividades.index') }}" class="btn btn-primary mt-3">Voltar</a>
</div>
@endsection