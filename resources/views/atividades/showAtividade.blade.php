@extends('layouts.app')
@section('title') {{ 'Detalhes da Atividade' }} @endsection

@section('content')
@php
    \Carbon\Carbon::setLocale('pt_BR');
@endphp

{{-- <link rel="stylesheet" href="{{ asset('css/detalhesAtividade.css') }}"> --}}
<link rel="stylesheet" href="{{ asset('css/edit.css') }}">

<div class="form-wrapper pt-4 paddingLeft">
	<div class="form_create border">
		<h3 class="text-center">Detalhes da Atividade</h3>

		<h5 class="col-12 text-center fw-bold" style="color: #6f7983">
			{!! $atividade->atividade_descricao !!}
		</h5>

		<div class="row g-3">
			<div class="col-12">
				<label class="">Eixos:</label>

				<div class="form-control input-disabled">
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

			<div class="col-12">
				<label class="">Responsável:</label>

				<div class="form-control input-disabled">
					{{ $atividade->responsavel }}
				</div>
			</div>

			<div class="col-12">
				<label class="">Objetivo:</label>

				<div class="form-control input-disabled pb-0">
					{!! $atividade->objetivo !!}
				</div>
			</div>

			<div class="col-12 col-sm-6">
				<label class="">Público Alvo:</label>

				<div class="form-control input-disabled">
					{{ $atividade->publico ? $atividade->publico->nome : 'Não informado' }}
				</div>
			</div>

			<div class="col-12 col-sm-6">
				<label class="">Tipo de evento:</label>

				<div class="form-control input-disabled">
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

			<div class="col-12">
				<label class="">Canais:</label>

				<div class="form-control input-disabled">
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

			<div class="col-12">
				<label class="">Indicadores:</label>

				<div class="form-control input-disabled">
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

			<div class="col-12 col-sm-6">
				<label class="">Previsto:</label>

				<div class="form-control input-disabled">
					{{ $atividade->meta }} {{ $atividade->medida->nome ?? 'N/A' }}
				</div>
			</div>

			<div class="col-12 col-sm-6">
				<label class="">Realizado:</label>
				<div class="form-control input-disabled">
					{{ $atividade->realizado }} {{ $atividade->medida->nome ?? 'N/A' }}
				</div>
			</div>

			<div class="col-12 col-sm-6">
				<label class="">Data Término:</label>
				<div class="form-control input-disabled">
					{{ \Carbon\Carbon::parse($atividade->data_realizada)->translatedFormat('d \d\e F \d\e Y') }}
				</div>
			</div>

		</div>
	</div>
</div>

<x-back-button/>
@endsection
