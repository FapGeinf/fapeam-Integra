@extends('layouts.app')

@section('content')
@php
    \Carbon\Carbon::setLocale('pt_BR'); // Define a localidade para português do Brasil
@endphp

<link rel="stylesheet" href="{{ asset('css/detalhesAtividade.css') }}">

@section('title') {{ 'Detalhes da Atividade' }} @endsection

<div class="margin-30">
	<div class="box margin-top-4 bg-white border-bottom-none mx-auto">
		<div class="row mt-3">
			<div class="text-center">
				<h3>Detalhes da Atividade</h3>
			</div>
			<div class="col-12 text-center fs-18">
				{!! $atividade->atividade_descricao !!}
			</div>
		</div>
	</div>

<div class="box mx-auto">
	<div class="p-30 bg-white border-top-none box-shadow">

		<div class="row g-3">
			<div class="col-12">
				<label class="fw-bold">Objetivo:</label>
				<div class="form-control pb-0">
					{!! $atividade->objetivo !!}
				</div>
			</div>
		</div>

		<div class="row g-3 mt-1">
			<div class="col-12">
				<label class="fw-bold">Eixos:</label>

				<div class="form-control">
					@if($atividade->eixos->count() > 0)
					<ul>
						@foreach($atividade->eixos as $eixo)
							<li>EIXO {{$eixo->id}} - {{ $eixo->nome }}</li>
						@endforeach
					</ul>

					@else
						Nenhum eixo associado
					@endif
				</div>
			</div>
		</div>

		<div class="row g-3 mt-1">
			<div class="col-12">
				<label class="fw-bold">Responsável:</label>
				<div class="form-control">
					{{ $atividade->responsavel }}
				</div>
			</div>
		</div>

		<div class="row g-3 mt-1">

			<div class="col-12 col-sm-4">
				<label class="fw-bold">Tipo de evento:</label>
				<div class="form-control">
					@if($atividade->tipo_evento == 1)
						Presencial
					@elseif($atividade->tipo_evento == 2)
						Online
					@elseif($atividade->tipo_evento == 3)
						Presencial e Online
					@else
						Sem evento
					@endif
				</div>
			</div>

			<div class="col-12 col-sm-4">
				<label class="fw-bold">Público Alvo:</label>

				<div class="form-control">
					{{ $atividade->publico ? $atividade->publico->nome : 'Não informado' }}
				</div>
			</div>

			<div class="col-12 col-sm-4">
				<label class="fw-bold">Canais:</label>

				<div class="form-control">
					@if($atividade->canais->count() > 0)
						<ul>
							@foreach($atividade->canais as $canal)
								<li>{{ $canal->nome }}</li>
							@endforeach
						</ul>
					@else
						Nenhum canal associado
					@endif
				</div>
			</div>
		</div>

		<div class="row g-3 mt-1">
			<div class="col-12 col-sm-6">
				<label class="fw-bold">Data Início:</label>

				<div class="form-control">
					{{ \Carbon\Carbon::parse($atividade->data_prevista)->translatedFormat('d \d\e F \d\e Y') }}
				</div>
			</div>

			<div class="col-12 col-sm-6">
				<label class="fw-bold">Data Término:</label>
				<div class="form-control">
					{{ \Carbon\Carbon::parse($atividade->data_realizada)->translatedFormat('d \d\e F \d\e Y') }}
				</div>
			</div>
		</div>

		<div class="row g-3 mt-1">
			<div class="col-12">
				<label for="" class="fw-bold">Indicadores:</label>

				<div class="form-control">
					@if($atividade->indicadores->count() > 0)
						<ul>
							@foreach($atividade->indicadores as $indicador)
								<li>{{ $indicador->nomeIndicador }}</li>
							@endforeach
						</ul>
					@else
						Nenhum indicador associado
					@endif
				</div>
			</div>
		</div>

		<div class="row g-3 mt-1">
			<div class="col-12 col-sm-6">
				<label for="" class="fw-bold">Previsto:</label>

				<div class="form-control">
					{{ $atividade->meta }} {{ $atividade->medida->nome ?? 'N/A' }}
				</div>
			</div>

			<div class="col-12 col-sm-6">
				<label for="" class="fw-bold">Realizado:</label>
				<div class="form-control">
					{{ $atividade->realizado }} {{ $atividade->medida->nome ?? 'N/A' }}
				</div>
			</div>
		</div>

	</div>
</div>

</div>





<div class="text-center mt-4">
	<a href="{{ url()->previous() }}" class="btn btn-secondary"><i class="bi bi-arrow-left"></i></a>
</div>
@endsection
