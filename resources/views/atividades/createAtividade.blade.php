@extends('layouts.app')

@section('content')
<link href="https://cdn.jsdelivr.net/npm/choices.js/public/assets/styles/choices.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/choices.js/public/assets/scripts/choices.min.js"></script>
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
      <ul style = "list-style:none;">
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
          <label for="eixo_ids" class="form-label"> <span class="asteriscoTop">*</span>Eixos:</label>
          <select name="eixo_ids[]" id="eixo_ids" class="form-select" required multiple>
            <option value="">Selecione os Eixos</option>
            @foreach ($eixos as $eixo)
              <option value="{{ $eixo->id }}" {{ in_array($eixo->id, old('eixo_ids', [])) ? 'selected' : '' }}>
                {{ 'Eixo ' . $loop->iteration . ' - ' . $eixo->nome }}
              </option>
            @endforeach
          </select>
        </div>

        <script>
          document.addEventListener('DOMContentLoaded', function () {
            let elemento = document.getElementById('eixo_ids');

            if (elemento) {
              let choices = new Choices(elemento, {
                removeItemButton: true,
                placeholder: true,
                searchEnabled: false,
                itemSelectText: '',
                allowHTML: true
              });
            }
          });
        </script>

        <div class="col-12">
          <label for="atividade_descricao" class="form-label"> <span class="asteriscoTop">*</span>Atividade:</label>
          <textarea name="atividade_descricao" id="atividade_descricao" class="form-control" required>
            {{ old('atividade_descricao') }}
          </textarea>
        </div>

        <div class="col-12">
          <label for="objetivo" class="form-label"> <span class="asteriscoTop">*</span>Objetivo:</label>
          <textarea name="objetivo" id="objetivo" class="form-control" required>
            {{ old('objetivo') }}
          </textarea>
        </div>

        <div class="col-12 col-md-6">
          <label for="publico_id" class="form-label"> <span class="asteriscoTop">*</span>Público Alvo:</label>
          <select name="publico_id" id="publico_id" class="form-select" required>
            <option value="">Selecione o Público Alvo</option>
            @foreach ($publicos as $publico)
              <option value="{{ $publico->id }}" {{ old('publico_id') == $publico->id ? 'selected' : '' }}>
                {{ $publico->nome }}
              </option>
            @endforeach
            <option value="outros">Outros</option>
          </select>

          <div id="outros-input-container" style="display: none; margin-top: 10px;">
            <label for="novo_publico" class="form-label">Insira o novo público:</label>
            <input type="text" name="novo_publico" id="novo_publico" class="form-control">
          </div>
        </div>

        <div class="col-12 col-md-6">
          <label for="tipo_evento" class="form-label"> <span class="asteriscoTop">*</span>Tipo de Evento:</label>
          <select name="tipo_evento" id="tipo_evento" class="form-select" required>
            <option value="1" {{ old('tipo_evento') == '1' ? 'selected' : '' }}>
              Presencial</option>
                
            <option value="2" {{ old('tipo_evento') == '2' ? 'selected' : '' }}>
              Online</option>
          </select>
        </div>

        <div class="col-12">
          <label for="canal_id" class="form-label"> <span class="asteriscoTop">*</span>Canal de Divulgação:</label>
          <select name="canal_id" id="canal_id" class="form-select" required onchange="toggleOtherField()">
              <option value="">Selecione o Canal de Divulgação</option>
              @foreach ($canais as $canal)
                  <option value="{{ $canal->id }}" {{ old('canal_id') == $canal->id ? 'selected' : '' }}>
                      {{ $canal->nome }}
                  </option>
              @endforeach
              <option value="outros">Outros</option>
          </select>
          <input type="text" name="outro_canal" id="outro_canal" class="form-control mt-2" style="display: none;" placeholder="Digite o outro canal">
      </div>
        
        <div class="col-12 col-md-6">
            <label for="data_prevista" class="form-label"> <span class="asteriscoTop">*</span>Data Prevista:</label>
            <input type="date" name="data_prevista" id="data_prevista" class="form-control" required
              value="{{ old('data_prevista') }}">
          </div>

          <div class="col-12 col-md-6">
            <label for="data_realizada" class="form-label"> <span class="asteriscoTop">*</span>Data Realizada:</label>
            <input type="date" name="data_realizada" id="data_realizada" class="form-control"
              min="{{ \Carbon\Carbon::today()->toDateString() }}" value="{{ old('data_realizada') }}">
          </div>

          <div class="col-12 col-md-6">
            <label for="meta" class="form-label"> <span class="asteriscoTop">*</span>Meta:</label>
            <input type="number" name="meta" id="meta" class="form-control" required min="0"
              value="{{ old('meta') }}" oninput="mostrarUnidade()">
          </div>

          <div class="col-12 col-md-6">
            <label for="realizado" class="form-label"> <span class="asteriscoTop">*</span>Realizado:</label>
            <input type="number" name="realizado" id="realizado" class="form-control" required min="0"
              value="{{ old('realizado') }}" oninput="mostrarUnidade()">
          </div>

          <div class="col-12 col-md-6" id="unidade-container" style="display: none;">
            <label for="medida_id" class="form-label"> <span class="asteriscoTop">*</span>Tipo de Unidade:</label>
            <select name="medida_id" id="medida_id" class="form-control" required>
              <option value="">Selecione o Tipo de Unidade</option>
              @foreach ($medidas as $medida)
                <option value="{{ $medida->id }}" {{ old('medida_id') == $medida->id ? 'selected' : '' }}>
                  {{ $medida->nome }}
                </option>
              @endforeach
            </select>
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
  function toggleOtherField() {
      var select = document.getElementById('canal_id');
      var otherField = document.getElementById('outro_canal');
      if (select.value === 'outros') {
          otherField.style.display = 'block';
      } else {
          otherField.style.display = 'none';
      }
  }
</script>

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

  function mostrarUnidade() {
    var meta = document.getElementById('meta').value;
    var realizado = document.getElementById('realizado').value;
    var unidadeContainer = document.getElementById('unidade-container');

    if (meta > 0 || realizado > 0) {
      unidadeContainer.style.display = 'block';
    } else {
      unidadeContainer.style.display = 'none';
    }
  }

  document.addEventListener('DOMContentLoaded', function () {
    const publicoSelect = document.getElementById('publico_id');
    const outrosInputContainer = document.getElementById('outros-input-container');
    const novoPublicoInput = document.getElementById('novo_publico');

    publicoSelect.addEventListener('change', function () {
      if (this.value === 'outros') {
        outrosInputContainer.style.display = 'block';
        novoPublicoInput.required = true; 

      } else {
        outrosInputContainer.style.display = 'none';
        novoPublicoInput.required = false; 
      }
    });
  });
</script>
@endsection