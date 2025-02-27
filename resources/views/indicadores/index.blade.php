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

<div class="px__custom pt-5">
  <div class="col-12 border__custom main-datatable" style="border-bottom: 0 !important; border-top-left-radius: 10px; border-top-right-radius: 10px">
    <div class="d-flex justify-content-center text-center p-2" 
		style="
				flex-direction: column;
				background-color: #f1f3f5;
        border-top-left-radius: 10px;
        border-top-right-radius: 10px;">
      <h3 class="fw-bold my-2">Indicadores</h3>
    </div>
  </div>
	
	<div class="">
		<div class="col-12 border__custom main-datatable">
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

</div>




@endsection