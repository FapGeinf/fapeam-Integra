@extends('layouts.app')
@section('title') {{ 'Editar Atividade' }} @endsection
<link rel="stylesheet" href="{{ asset('css/edit.css') }}">
<link href="{{ asset('css/choices.min.css') }}" rel="stylesheet">
<script src="{{ asset('js/choices.min.js') }}"></script>
<link rel="stylesheet" href="{{ asset('css/flatpickr.min.css') }}">
<script src="{{ asset('js/flatpickr.js') }}"></script>
<script src="{{ asset('js/pt.js') }}"></script>
<style>
  .cke_top {
    background-color: #f8f8f8 !important;
  }
</style>
@section('content')
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
      <ul style="list-style:none;">
        @foreach ($errors->all() as $error)
          <li>{{ $error }}</li>
        @endforeach
      </ul>
    </div>
  @endif
</div>

<div class="form-wrapper pt-4 paddingLeft">
  <div class="form_create border">
    <h3 class="text-center">Edite sua Atividade</h3>

    <div class="tipWarning mb-3">
      <span class="asteriscoTop">*</span>
      Campos obrigatórios
    </div>

    <form action="{{ route('atividades.update', $atividade->id) }}" method="POST">
      @csrf
      @method('PUT')

      <div class="row g-3">
        <div class="col-12">
          <label for="eixo_ids" class=""><span class="asteriscoTop">*</span>Eixos:</label>

          <select name="eixo_ids[]" id="eixo_ids" class="form-select" required multiple>
            <option value="">Selecione os Eixos</option>
            @foreach ($eixos as $eixo)
              <option value="{{ $eixo->id }}" {{ in_array($eixo->id, old('eixo_ids', $atividade->eixos->pluck('id')->toArray())) ? 'selected' : '' }}>
                {{ 'Eixo ' . $loop->iteration . ' - ' . $eixo->nome }}
              </option>
            @endforeach
          </select>
        </div>
      </div>


      <div class="col-12">
        <label for="responsavel" class="">Responsável:</label>
        <input name="responsavel" id="responsavel" class="form-control insert-resp" value="{{ old('responsavel', $atividade->responsavel) }}">
        </input>
      </div>

      <div class="row g-3">
        <div class="col-12">
          <label for="atividade_descricao" class=""><span class="asteriscoTop">*</span>Atividade:</label>

          <textarea name="atividade_descricao" id="atividade_descricao" class="form-control" required>
            {{ old('atividade_descricao', $atividade->atividade_descricao) }}
          </textarea>
        </div>

        <div class="col-12">
          <label for="objetivo" class=""> <span class="asteriscoTop">*</span>Objetivo:</label>

          <textarea name="objetivo" id="objetivo" class="form-control" required>
            {{ old('objetivo', $atividade->objetivo) }}
          </textarea>
        </div>

        <div class="col-12">
          <label for="publico_id" class="">Público Alvo:</label>
          
          <select name="publico_id" id="publico_id" class="form-select">
            <option value="">Selecione o Público Alvo</option>
              @foreach ($publicos as $publico)
                <option value="{{ $publico->id }}" {{ old('publico_id', $atividade->publico_id) == $publico->id ? 'selected' : '' }}>
                  {{ $publico->nome }}
                </option>
              @endforeach
            <option value="outros" {{ old('publico_id') == 'outros' ? 'selected' : '' }}>Outros</option>
          </select>
        </div>

        <div class="col-12" id="outro-publico-container" style="display: none;">
          <label for="novo_publico" class="form-label">Especifique o Público:</label>
          <input type="text" name="novo_publico" id="novo_publico" class="form-control" value="{{ old('novo_publico') }}">
        </div>

        <div class="col-12">
          <label for="canal_id" class="form-label">Canal de Divulgação:</label>

          <select name="canal_id[]" id="canal_id" class="form-select" multiple onchange="toggleOtherField()">
            <option value="">Selecione o Canal de Divulgação</option>
              @foreach ($canais as $canal)
                <option value="{{ $canal->id }}" {{ in_array($canal->id, old('canal_id', $atividade->canais->pluck('id')->toArray())) ? 'selected' : '' }}>
                  {{ $canal->nome }}
                </option>
              @endforeach
          </select>
        </div>

        <script src="{{ asset('js/choicesCanal.js') }}"></script>

        <div class="row g-3">
          <div class="col-12 col-md-6">
            <label for="tipo_evento" class="">Tipo de Evento:</label>
            <select name="tipo_evento" id="tipo_evento" class="form-select" >
              <option value="0" {{ old('tipo_evento', $atividade->tipo_evento) == '0' || old('tipo_evento') == null ? 'selected' : '' }}>Sem evento</option>

              <option value="1" {{ old('tipo_evento', $atividade->tipo_evento) == '1' ? 'selected' : '' }}>Presencial</option>

              <option value="2" {{ old('tipo_evento', $atividade->tipo_evento) == '2' ? 'selected' : '' }}>Online</option>

              <option value="3" {{ old('tipo_evento', $atividade->tipo_evento) == '3' ? 'selected' : '' }}>Presencial e Online</option>
            </select>
          </div>
        </div>

        <hr>

        <div class="row g-3">
          <div class="col-12">
            <label for="indicador_ids">Indicadores:</label>
            <select name="indicador_ids[]" id="indicador_ids" class="form-select" required multiple>
              <option value="">Selecione os Indicadores</optio>
              @foreach ($indicadores as $indicador)
                <option value="{{ $indicador->id }}" {{ in_array($indicador->id, old('indicador_ids', $atividade->indicadores->pluck('id')->toArray())) ? 'selected' : '' }}>
                  {{ $indicador->descricaoIndicador }}
                </option>
              @endforeach
            </select>
          </div>

          <div class="col-12 col-md-6">
            <label for="data_realizada" class="">Data Realizada:</label>
            <input type="date" name="data_realizada" id="data_realizada" class="form-control" value="{{ old('data_realizada', $atividade->data_realizada) }}">
          </div>

          <div class="col-12 col-md-6">
            <label for="data_prevista" class="">Data Prevista:</label>
            <input type="date" name="data_prevista" id="data_prevista" class="form-control" value="{{ old('data_prevista', $atividade->data_prevista) }}">
          </div>

          <div class="col-12 col-md-6">
            <label for="meta" class="">Previsto:</label>
            <input type="number" name="meta" id="meta" class="form-control"  min="0" value="{{ old('meta', $atividade->meta) }}" oninput="mostrarUnidade()">
          </div>

          <div class="col-12 col-md-6">
            <label for="realizado" class="">Realizado:</label>
            <input type="number" name="realizado" id="realizado" class="form-control"  min="0" value="{{ old('realizado', $atividade->realizado) }}" oninput="mostrarUnidade()">
          </div>

          <div class="col-12 col-md-6" id="unidade-container" style="display: none;">
            <label for="medida_id" class="form-label"> <span class="asteriscoTop">*</span>Tipo de Unidade:</label>
            <select name="medida_id" id="medida_id" class="form-control" >
              <option value="">Selecione o Tipo de Unidade</option>
              @foreach ($medidas as $medida)
                <option value="{{ $medida->id }}" {{ old('medida_id', $atividade->medida_id) == $medida->id ? 'selected' : '' }}>
                  {{ $medida->nome }}
                </option>
              @endforeach
            </select>
          </div>
        </div>

      <div class="d-flex justify-content-end pt-5">
        <button type="submit" class="btn btn-md btn-primary">Enviar a Atividade</button>
      </div>
    </form>
  </div>
</div>
</div>
<script src="{{ asset('ckeditor/ckeditor.js') }}"></script>
<script src="{{ asset('js/editAtividade.js') }}"></script>
<script src="{{asset('js/indicadoresChoices.js')}}"></script>
@endsection