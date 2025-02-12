@extends('layouts.app')

@section('content')
@php
    \Carbon\Carbon::setLocale('pt_BR'); // Define a localidade para português do Brasil
@endphp
<br>
<div class="container mt-4">
    <h1 class="mb-4 text-center">Detalhes da Atividade</h1>

    <div class="card shadow-sm">
        <div class="card-header bg-primary text-white">
            <h5 class="mb-0">{!! $atividade->atividade_descricao !!}</h5>
        </div>
				
        <div class="card-body">
            <div class="row mb-3">
                <label class="col-sm-3 fw-bold">Objetivo:</label>
                <div class="col-sm-9">{!! $atividade->objetivo !!}</div>
            </div>

						<div class="row mb-3">
							<label class="col-sm-3 fw-bold">Eixos:</label>
							<div class="col-sm-9">
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
					
						<div class="row mb-3">
							<label class="col-sm-3 fw-bold">Responsável:</label>
							<div class="col-sm-9">{{ $atividade->responsavel }}</div>
						</div>

						<div class="row mb-3">
							<label class="col-sm-3 fw-bold">Tipo de Evento:</label>
							<div class="col-sm-9">
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


            <div class="row mb-3">
                <label class="col-sm-3 fw-bold">Público Alvo:</label>
                <div class="col-sm-9">{{ $atividade->publico ? $atividade->publico->nome : 'Não informado' }}</div>
            </div>
            <div class="row mb-3">
                <label class="col-sm-3 fw-bold">Canais:</label>
                <div class="col-sm-9">
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

						<div class="row mb-3">
							<label class="col-sm-3 fw-bold">Data de Início:</label>
							{{ \Carbon\Carbon::parse($atividade->data_prevista)->translatedFormat('d \d\e F \d\e Y') }}
						</div>

						<div class="row mb-3">
							<label class="col-sm-3 fw-bold">Data de Término:</label>
							{{ \Carbon\Carbon::parse($atividade->data_realizada)->translatedFormat('d \d\e F \d\e Y') }}
						</div>

            <div class="row mb-3">
                <label class="col-sm-3 fw-bold">Indicadores:</label>
                <div class="col-sm-9">
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


						<div class="row mb-3">
							<label class="col-sm-3 fw-bold">Previsto:</label>
							<div class="col-sm-9">
									{{ $atividade->meta }} {{ $atividade->medida->nome ?? 'N/A' }}
							</div>
					</div>

					<div class="row mb-3">
						<label class="col-sm-3 fw-bold">Realizado:</label>
						<div class="col-sm-9">
								{{ $atividade->realizado }} {{ $atividade->medida->nome ?? 'N/A' }}
						</div>
					</div>

        </div>
    </div>

		<div class="text-center mt-4">
			<a href="{{ url()->previous() }}" class="btn btn-secondary"><i class="bi bi-arrow-left"></i></a>
	</div>
</div>
@endsection
