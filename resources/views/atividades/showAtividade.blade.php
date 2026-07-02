@extends('layouts.app')
@section('title') {{ 'Detalhes da Atividade' }} @endsection
@section('content')

<link rel="stylesheet" href="{{ asset('css/edit.css') }}">
<link rel="stylesheet" href="{{ asset('css/main.css') }}">
<link rel="stylesheet" href="{{ asset('css/buttons.css') }}">
<style>
    .form-control:disabled, .form-select:disabled {
        background-color: #f8f9fa;
        cursor: not-allowed;
        opacity: 1; /* Mantém a cor do texto nítida */
    }
    .ck-editor__main { cursor: not-allowed; }
</style>

<div class="container pt-5" style="max-width: 800px;">
    <div class="col-12 border box-shadow p-4 bg-white">
        <h5 class="text-center mb-4">Detalhes da Atividade</h5>

        <div class="row g-3">
            <div class="col-12">
                <label class="fw-bold">Eixos:</label>
                <div class="form-control" style="background: #f8f9fa; min-height: 45px;">
                    @forelse($atividade->eixos as $eixo)
                        <span class="badge bg-secondary me-1">Eixo {{ $eixo->id }} - {{ $eixo->nome }}</span>
                    @empty
                        <span class="text-muted">Nenhum eixo associado</span>
                    @endforelse
                </div>
            </div>

            <div class="col-12 mt-2">
                <label class="fw-bold">Responsável:</label>
                <input class="form-control" value="{{ $atividade->responsavel ?? 'Não informado' }}" disabled>
            </div>

            <div class="col-12 mt-4">
                <label class="fw-bold">Atividade:</label>
                <div class="form-control" style="background: #f8f9fa; height: auto; min-height: 100px;">
                    {!! $atividade->atividade_descricao !!}
                </div>
            </div>

            <div class="col-12">
                <label class="fw-bold">Objetivo:</label>
                <div class="form-control" style="background: #f8f9fa; height: auto; min-height: 100px;">
                    {!! $atividade->objetivo !!}
                </div>
            </div>

            <div class="col-12 col-md-6">
                <label class="fw-bold">Público Alvo:</label>
                <input class="form-control" value="{{ $atividade->publico->nome ?? 'Não informado' }}" disabled>
            </div>

            <div class="col-12 col-md-6">
                <label class="fw-bold">Tipo de Evento:</label>
                @php
                    $tipos = [0 => 'Sem evento', 1 => 'Presencial', 2 => 'Online', 3 => 'Presencial e Online'];
                @endphp
                <input class="form-control" value="{{ $tipos[$atividade->tipo_evento] ?? 'Não informado' }}" disabled>
            </div>

            <div class="col-12 mt-1">
                <label class="fw-bold">Canal de Divulgação:</label>
                <div class="form-control" style="background: #f8f9fa; min-height: 45px;">
                    @forelse($atividade->canais as $canal)
                        <span class="badge bg-info text-dark me-1">{{ $canal->nome }}</span>
                    @empty
                        <span class="text-muted">Nenhum canal associado</span>
                    @endforelse
                </div>
            </div>

            <div class="col-12 mt-1">
                <label class="fw-bold">Indicadores:</label>
                <div class="form-control" style="background: #f8f9fa; min-height: 45px;">
                    @forelse($atividade->indicadores as $indicador)
                        <span class="badge bg-primary me-1">{{ $indicador->nomeIndicador }}</span>
                    @empty
                        <span class="text-muted">Nenhum indicador associado</span>
                    @endforelse
                </div>
            </div>

            <div class="col-12">
                <label class="fw-bold">Status da Atividade:</label>
                <input class="form-control" value="{{ $atividade->statusAtividade->nome ?? 'Não informado' }}" disabled>
            </div>

            <div class="col-12 col-md-6">
                <label class="fw-bold">Data Realizada:</label>
                <input class="form-control" value="{{ $atividade->data_realizada ? \Carbon\Carbon::parse($atividade->data_realizada)->format('d/m/Y') : 'N/A' }}" disabled>
            </div>

            <div class="col-12 col-md-6">
                <label class="fw-bold">Data Prevista:</label>
                <input class="form-control" value="{{ $atividade->data_prevista ? \Carbon\Carbon::parse($atividade->data_prevista)->format('d/m/Y') : 'N/A' }}" disabled>
            </div>

            <div class="col-12 col-md-6">
                <label class="fw-bold">Previsto:</label>
                <div class="input-group">
                    <input class="form-control" value="{{ $atividade->meta }}" disabled>
                    <span class="input-group-text">{{ $atividade->medida->nome ?? '' }}</span>
                </div>
            </div>

            <div class="col-12 col-md-6">
                <label class="fw-bold">Realizado:</label>
                <div class="input-group">
                    <input class="form-control" value="{{ $atividade->realizado }}" disabled>
                    <span class="input-group-text">{{ $atividade->medida->nome ?? '' }}</span>
                </div>
            </div>
        </div>
    </div>
</div>

<x-back-button/>
@endsection