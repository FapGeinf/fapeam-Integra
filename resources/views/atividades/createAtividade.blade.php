@extends('layouts.app')

@section('content')

@section('title') {{ 'Nova Atividade' }} @endsection

<head>
    <link rel="stylesheet" href="{{ asset('css/edit.css') }}">
</head>
<div class="alert-container mt-5">
    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @elseif (session('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
    @endif
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
</div>
<div class="form-wrapper pt-4 paddingLeft">
    <div class="form_create border">
        <h3 style="text-align: center; margin-bottom: 5px;">
            Insira sua Atividade
        </h3>
        <div class="tipWarning mb-3">
            <span class="asteriscoTop">*</span>
            Campos obrigatórios
        </div>
        <form action="{{ route('atividades.store') }}" method="POST">
            @csrf
            <div class="row g-3">
                <div class="col-12">
                    <label for="eixo_id" class="form-label">Eixo:</label>
                    <select name="eixo_id" id="eixo_id" class="form-select" required>
                        <option value="">Selecione o Eixo</option>
                        @foreach ($eixos as $eixo)
														<option value="{{$eixo->id}}" {{old('eixo_id')==$eixo->id ? 'selected' : ''}}>
																{{'Eixo ' . $loop->iteration. ' - ' .$eixo->nome}}
														</option>
                            <!-- @if (in_array($eixo->id, [1, 2, 5]))
                                <option value="{{ $eixo->id }}" {{ old('eixo_id') == $eixo->id ? 'selected' : '' }}>
                                    {{ 'Eixo ' . $loop->iteration . ' - ' . $eixo->nome }}
                                </option>
                            @endif -->
                        @endforeach
                    </select>
                </div>
                <div class="col-12">
                    <label for="atividade_descricao" class="form-label">Atividade:</label>
                    <textarea name="atividade_descricao" id="atividade_descricao" class="form-control" required>
                        {{ old('atividade_descricao') }}
                    </textarea>
                </div>
                <div class="col-12">
                    <label for="objetivo" class="form-label">Objetivo:</label>
                    <textarea name="objetivo" id="objetivo" class="form-control" required>
                        {{ old('objetivo') }}
                    </textarea>
                </div>
                <div class="mb-5">
                    <label for="publico_alvo" class="form-label">Público Alvo:</label>
                    <textarea name="publico_alvo" id="publico_alvo" class="form-control"
                        required>{{ old('publico_alvo') }}</textarea>
                </div>
                <div class="mb-5">
                    <label for="tipo_evento" class="form-label">Tipo de Evento:</label>
                    <select name="tipo_evento" id="tipo_evento" class="form-select" required>
                        <option value="Presencial" {{ old('tipo_evento') == 'Presencial' ? 'selected' : '' }}>
                            Presencial</option>
                        <option value="TeleConferência" {{ old('tipo_evento') == 'TeleConferência' ? 'selected' : '' }}>
                            TeleConferência</option>
                    </select>
                </div>

                <div class="mb-5">
                    <label for="canal_divulgacao" class="form-label">Canal de Divulgação:</label>
                    <textarea name="canal_divulgacao" id="canal_divulgacao" class="form-control"
                        required>{{ old('canal_divulgacao') }}</textarea>
                </div>
                <div class="col-12 col-md-6">
                    <label for="data_prevista" class="form-label">Data Prevista:</label>
                    <input type="date" name="data_prevista" id="data_prevista" class="form-control" required
                        value="{{ old('data_prevista') }}">
                </div>
                <div class="col-12 col-md-6">
                    <label for="data_realizada" class="form-label">Data Realizada:</label>
                    <input type="date" name="data_realizada" id="data_realizada" class="form-control"
                        min="{{ \Carbon\Carbon::today()->toDateString() }}" value="{{ old('data_realizada') }}">
                </div>
                <div class="col-12 col-md-6">
                    <label for="meta" class="form-label">Meta:</label>
                    <input type="number" name="meta" id="meta" class="form-control" required min="0"
                        value="{{ old('meta') }}">
                </div>
                <div class="col-12 col-md-6">
                    <label for="realizado" class="form-label">Realizado:</label>
                    <input type="number" name="realizado" id="realizado" class="form-control" required min="0"
                        value="{{ old('realizado') }}">
                </div>
                <div class="d-flex justify-content-end pt-3">
                    <button type="submit" class="btn btn-md btn-primary">Enviar a Atividade</button>
                </div>
            </div>
        </form>
    </div>
</div>

<script src="{{asset('ckeditor/ckeditor.js')}}"></script>

<script>
    document.addEventListener("DOMContentLoaded", function () {
        let ckeditorConfig = {
            extraPlugins: 'wordcount',
            wordcount: {
                showCharCount: true,
                maxCharCount: 10000,
                charCountMsg: 'Caracteres restantes: {0}',
                maxCharCountMsg: 'Você atingiu o limite máximo de caracteres permitidos.'
            }
        };

        let ckeditorConfig2 = {
            extraPlugins: 'wordcount',
            wordcount: {
                showCharCount: true,
                maxCharCount: 255,
                charCountMsg: 'Caracteres restantes: {0}',
                maxCharCountMsg: 'Você atingiu o limite máximo de caracteres permitidos.'
            }
        };

        if (document.getElementById('atividade_descricao')) {
            CKEDITOR.replace('atividade_descricao', ckeditorConfig);
        }
        if (document.getElementById('objetivo')) {
            CKEDITOR.replace('objetivo', ckeditorConfig);
        }
        if (document.getElementById('publico_alvo')) {
            CKEDITOR.replace('publico_alvo', ckeditorConfig2);
        }
        if (document.getElementById('canal_divulgacao')) {
            CKEDITOR.replace('canal_divulgacao', ckeditorConfig2);
        }
    });
</script>
@endsection