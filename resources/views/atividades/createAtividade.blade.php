@extends('layouts.app')

@section('title') {{ 'Nova Atividade' }} @endsection

@section('content')
<link href="https://cdn.jsdelivr.net/npm/choices.js/public/assets/styles/choices.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/choices.js/public/assets/scripts/choices.min.js"></script>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
<script src="{{ asset('js/auto-dismiss.js') }}"></script>
<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
<script src="https://cdn.jsdelivr.net/npm/flatpickr/dist/l10n/pt.js"></script>
@section('title') {{ 'Nova Atividade' }} @endsection

<link rel="stylesheet" href="{{ asset('css/edit.css') }}">
<link rel="stylesheet" href="{{ asset('css/buttons.css') }}">

<style>
  .liDP {
    margin-left: 0 !important;
  }

  .choices__inner {
    border: 1px solid #ccc;
    padding: 0.375rem 0.75rem;
  }
</style>

<div class="alert-container pt-5">
  @if (session('success'))
  <div class="alert alert-success text-center auto-dismiss">
    {{ session('success') }}
  </div>

  @elseif (session('error'))
    <div class="alert alert-danger text-center auto-dismiss">
      {{ session('error') }}
    </div>
  @endif

  @if ($errors->any())
    <div class="alert alert-danger text-center auto-dismiss">
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

    <h3 style="text-align: center; margin-bottom: 5px;">
      Insira sua Atividade
    </h3>

    <div class="tipWarning mb-3">
      <span class="asteriscoTop">*</span> Campos obrigatórios
    </div>

    <form action="{{ route('atividades.store') }}" method="POST">
    @csrf

    <div class="row g-3">
      <div class="col-12">

        <label for="eixo_ids" class=""> <span class="asteriscoTop">*</span>Eixos:</label>
        <select name="eixo_ids[]" id="eixo_ids" class="form-select" multiple>

          <option disabled>Selecione os Eixos</option>
          @foreach ($eixos as $eixo)
            <option value="{{ $eixo->id }}" {{ in_array($eixo->id, old('eixo_ids', [])) ? 'selected' : '' }}>
              {{ 'Eixo ' . $loop->iteration . ' - ' . $eixo->nome }}
            </option>
          @endforeach
        </select>
      </div>

      <div class="col-12">
        <label for="responsavel" class="">Responsável:</label>
        <input name="responsavel" id="responsavel" class="form-control input-enabled">
          {{ old('responsavel') }}
        </input>
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
        <label for="atividade_descricao" class=""><span class="asteriscoTop">*</span>Atividade:</label>
        <textarea name="atividade_descricao" id="atividade_descricao" class="form-control" required>
          {{ old('atividade_descricao') }}
        </textarea>
      </div>

      <div class="col-12">
        <label for="objetivo" class=""><span class="asteriscoTop">*</span>Objetivo:</label>
        <textarea name="objetivo" id="objetivo" class="form-control" required>
          {{ old('objetivo') }}
        </textarea>
      </div>

      <div class="col-12 d-none" >
        <label for="justificativa" class="">Justificativa (Opcional) :</label>
        <textarea name="justificativa" id="justificativa" class="form-control">{{ old('justificativa') }}</textarea>
      </div>

      <div class="col-12 col-md-6">

        <label>Público alvo:</label>

        <select name="publico_id" id="publico_id" class="form-select">
        <option value="">Selecione o Público Alvo</option>
          @foreach ($publicos as $publico)
          <option value="{{ $publico->id }}" {{ old('publico_id') == $publico->id ? 'selected' : '' }}>
            {{ $publico->nome }}</option>
          @endforeach
          <option value="outros">Outros</option>
        </select>

        <div id="outros-input-container" style="display: none; margin-top: 10px;">
          <label for="novo_publico" class="">Insira o novo público:</label>
          <input type="text" name="novo_publico" id="novo_publico" class="form-control">
        </div>
      </div>

      <div class="col-12 col-md-6">
        <label>Evento:</label>

        <select name="tipo_evento" id="tipo_evento" class="form-select">
        <option value="0" {{ old('tipo_evento') == '0' || old('tipo_evento') === null ? 'selected' : '' }}>Sem evento
        </option>

        <option value="1" {{ old('tipo_evento') == '1' ? 'selected' : '' }}>Presencial</option>
        <option value="2" {{ old('tipo_evento') == '2' ? 'selected' : '' }}>Online</option>
        <option value="2" {{ old('tipo_evento') == '3' ? 'selected' : '' }}>Presencial e Online</option>
        </select>
      </div>

    <div class="col-12">
      <label for="canal_id" class="">Canal de Divulgação:</label>

      <select name="canal_id[]" id="canal_id" class="form-select" multiple onchange="toggleOtherField()">
      <option value="" disabled>Selecione o canal de divulgação</option>
        @foreach ($canais as $canal)
          <option value="{{ $canal->id }}" {{ in_array($canal->id, old('canal_id', [])) ? 'selected' : '' }}>
            {{ $canal->nome }}
          </option>
        @endforeach
      <option value="outros">Novo Canal Divulgação (digite abaixo)</option>
      </select>
    </div>


    <div class="col-12" id="novo_canal_div" style="display: none;">
      <label for="novo_canal" class="">
        Novo Canal de Divulgação:
      </label>

      <input type="text" id="novo_canal" name="novo_canal" class="form-control" placeholder="Digite o novo canal">
      <button type="button" class="btn btn-primary mt-2" onclick="criarCanal()">Criar Novo Canal</button>
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

    <script>
      document.addEventListener('DOMContentLoaded', function () {
      let elemento = document.getElementById('canal_id');

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

    <script>
      function toggleOtherField() {
      var select = document.getElementById('canal_id');
      var novoCanalDiv = document.getElementById('novo_canal_div');

      if (select.value == 'outros') {
        novoCanalDiv.style.display = 'block';
      } else {
        novoCanalDiv.style.display = 'none';
      }
      }

      function criarCanal() {
      let novoCanal = document.getElementById('novo_canal').value;

      if (novoCanal.trim() !== "") {
        fetch('{{ route('canal.criar') }}', {
        method: 'POST',
        headers: {
          'Content-Type': 'application/json',
          'X-CSRF-TOKEN': '{{ csrf_token() }}'
        },

        body: JSON.stringify({ nome: novoCanal })
        })
        .then(response => response.json())
        .then(data => {
          let modalContent = document.getElementById('modalMessageContent');
          if (data.success) {
          let select = document.getElementById('canal_id');
          let option = document.createElement('option');
          option.value = data.canal.id;
          option.text = data.canal.nome;
          select.appendChild(option);

          let selectedOptions = Array.from(select.options).map(option => option.value);
          select.value = selectedOptions.includes(data.canal.id.toString()) ? data.canal.id : select.value;

          document.getElementById('novo_canal').value = '';
          document.getElementById('novo_canal_div').style.display = 'none';

          modalContent.innerHTML = 'Canal criado com sucesso!';
          } else {
          modalContent.innerHTML = 'Erro ao criar o canal: ' + data.message;
          }

          let myModal = new bootstrap.Modal(document.getElementById('modalMessage'));
          myModal.show();
        })
        .catch(error => {
          let modalContent = document.getElementById('modalMessageContent');
          modalContent.innerHTML = 'Ocorreu um erro ao criar o canal';


          let myModal = new bootstrap.Modal(document.getElementById('modalMessage'));
          myModal.show();
          console.error('Erro:', error);
        });
      } else {
        let modalContent = document.getElementById('modalMessageContent');
        modalContent.innerHTML = 'Por favor, insira o nome do canal.';


        let myModal = new bootstrap.Modal(document.getElementById('modalMessage'));
        myModal.show();
      }
      }

    </script>


    <div id="modalMessage" class="modal" tabindex="-1" aria-labelledby="modalMessageLabel" aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="modalMessageLabel">Mensagem</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>

          <div class="modal-body" id="modalMessageContent">
          <!-- Mensagem será inserida aqui -->
          </div>

          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>
          </div>
        </div>
      </div>
    </div>

    <div class="col-12 col-md-6">
      <label for="data_prevista" class="">Data Prevista:</label>
      <input type="date" name="data_prevista" id="data_prevista" class="form-control input-enabled"
      value="{{ old('data_prevista') }}">
    </div>

    <div class="col-12 col-md-6">
      <label for="data_realizada" class="">Data Realizada:</label>

      <input type="date" name="data_realizada" id="data_realizada" class="form-control input-enabled"
      value="{{ old('data_realizada') }}">
    </div>

    <div class="col-12">
      <label for="indicador_ids[]">Indicadores:</label>
      <select name="indicador_ids[]" id="indicador_ids" class="form-select" multiple>

      <option value="" disabled>Selecione os Indicadores</option>
        @foreach ($indicadores as $indicador)
          <option value="{{ $indicador->id }}" {{ in_array($indicador->id, old('indicador_ids', [])) ? 'selected' : '' }}>
            {{ $indicador->nomeIndicador }}
          </option>
        @endforeach
      </select>
    </div>

    <div class="col-12 col-md-6">
      <label for="meta" class="">Previsto:</label>
      <input type="number" name="meta" id="meta" class="form-control input-enabled" min="0" value="{{ old('meta') }}"
      oninput="mostrarUnidade()">
    </div>

    <div class="col-12 col-md-6">
      <label for="realizado" class="">Realizado:</label>
      <input type="number" name="realizado" id="realizado" class="form-control input-enabled" min="0"
      value="{{ old('realizado') }}" oninput="mostrarUnidade()">
    </div>

    <div class="col-12 col-md-6" id="unidade-container" style="display: none;">
      <label for="medida_id" class=""> <span class="asteriscoTop">*</span>Tipo de Unidade:</label>

      <select name="medida_id" id="medida_id" class="form-control form-select">

      <option value="">Selecione o tipo de unidade</option>
      @foreach ($medidas as $medida)
        <option value="{{ $medida->id }}" {{ old('medida_id') == $medida->id ? 'selected' : '' }}>
          {{ $medida->nome }}
        </option>
      @endforeach
      </select>
    </div>

    <div class="d-flex justify-content-end pt-3">
      <button type="submit" class="highlighted-btn-lg highlight-blue me-0">Enviar a Atividade</button>
    </div>

    </div>
  </form>
  </div>
</div>

<x-back-button />

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
  if (document.getElementById('justificativa')) {
    CKEDITOR.replace('justificativa', ckeditorConfig);
  }

  flatpickr("#data_prevista", {
    dateFormat: "Y-m-d",
    altInput: true,
    altFormat: "d/m/Y",
  });

  flatpickr("#data_realizada", {
    dateFormat: "Y-m-d",
    altInput: true,
    altFormat: "d/m/Y",
  });


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

<script>
  document.addEventListener('DOMContentLoaded', function () {
  let elementoIndicadores = document.getElementById('indicador_ids');

  if (elementoIndicadores) {
    let choices = new Choices(elementoIndicadores, {
    removeItemButton: true,
    placeholder: true,
    searchEnabled: false,
    itemSelectText: '',
    allowHTML: true
    });
  }
  });
</script>
@endsection