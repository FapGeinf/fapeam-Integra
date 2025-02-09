@extends('layouts.app')
@section('content')
@section('title') {{ 'Lista de Indicadores' }} @endsection

<link rel="stylesheet" href="{{ asset('css/index.css') }}">
<link rel="stylesheet" href="{{ asset('css/atividades.css') }}">

<style>
	.form-label {
		margin-bottom: 0 !important;
	}

	.liDP {
		margin-left: 0 !important;
	}
</style>

<div class="container-fluid mt-5 px__custom">
  <div class="col-12 border main-datatable">
    <div class="d-flex justify-content-center text-center p-2" style="flex-direction: column;">
      <span style="font-size:22px;">Indicadores</span>
    </div>
  </div>
</div>

<div class="container-fluid p-30">
  <div class="col-12 border main-datatable">
		<div class="container-fluid pt-4 pb-4">
			<div class="mb-4 text-end">
				<a href="{{ route('indicadores.create') }}" class="primary">Adicionar Indicador</a>
			</div>
			
			<table class="table table-bordered table-striped">
				<thead>
					<tr>
						<th class="text-center">N°</th>
						{{-- <th class="text-center">Nome</th> --}}
						<th class="text-center">Descrição</th>
						<th class="text-center">Eixo</th>
						<th class="text-center">Ações</th>
					</tr>
				</thead>
				<tbody>
					@foreach($indicadores as $indicador)
					<tr>
						<td>{{ $indicador->id }}</td>
						{{-- <td>{{ $indicador->nomeIndicador }}</td> --}}
						<td>{{ $indicador->descricaoIndicador }}</td>
						<td>EIXO {{$indicador->eixo->id}} - {{ $indicador->eixo->nome}}</td>
						<td>
							<a href="{{ route('indicadores.edit', $indicador->id) }}" class="btn btn-warning btn-sm">Editar</a>
						</td>
					</tr>
					@endforeach
				</tbody>
			</table>
			
		</div>
	</div>
</div>


@endsection