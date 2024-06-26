@extends('layouts.app')

@section('content')

@section('title') {{ 'Editar Monitoramentos' }} @endsection

<head>
  <link rel="stylesheet" href="{{ asset('css/edit.css') }}">
  <script src="/ckeditor/ckeditor.js"></script>
</head>

<div class="form-wrapper pt-4">
  <div class="form_create">
    <h3 style="text-align: center; margin-bottom: 10px;"> Formulário de Monitoramentos</h3>

    @if (session('error'))
      <script>
        alert('{{ session('error') }}');
      </script>
    @endif

    <form action="{{ route('riscos.update-monitoramentos', ['id' => $risco->id]) }}" method="POST" id="formCreate">
      @csrf
      @method('PUT')

      <div class="text-center">
        <span>Monitoramentos adicionados: </span>
        <span id="monitoramentoCounter">{{ count($risco->monitoramentos) }}</span>
      </div>

      <hr>

      @foreach($risco->monitoramentos as $index => $monitoramento)
        <div class="monitoramento">
          <span class="numeration">Monitoramento Nº {{ $index + 1 }}</span>

          <textarea name="monitoramentos[{{ $index }}][monitoramentoControleSugerido]" placeholder="Monitoramento" class="textInput" id="monitoramentoControleSugerido{{ $index }}">
            {{ $monitoramento->monitoramentoControleSugerido }}
          </textarea>

          <label>Status do Monitoramento:</label>
          <textarea name="monitoramentos[{{ $index }}][statusMonitoramento]" placeholder="Status do Monitoramento" class="textInput" id="statusMonitoramento{{ $index }}">{{ $monitoramento->statusMonitoramento }}</textarea>

          <label>Execução do Monitoramento:</label>
          <textarea name="monitoramentos[{{ $index }}][execucaoMonitoramento]" placeholder="Execução do Monitoramento" class="textInput" id="execucaoMonitoramento{{ $index }}">{{ $monitoramento->execucaoMonitoramento }}</textarea>

          <div class="row g-3">
            <div class="col-sm-12 col-md-6">
              <label>Início do Monitoramento:</label>
              <input type="date" name="monitoramentos[{{ $index }}][inicioMonitoramento]" class="textInput dateInput" value="{{ $monitoramento->inicioMonitoramento }}">
            </div>

            <div class="col-sm-12 col-md-6 mQuery2">
              <label>Fim do Monitoramento:</label>
              <input type="date" name="monitoramentos[{{ $index }}][fimMonitoramento]" class="textInput dateInput" value="{{ $monitoramento->fimMonitoramento }}">
            </div>
          </div>

          <!-- Adicionar campo hidden para isContinuo -->
          <input type="hidden" name="monitoramentos[{{ $index }}][isContinuo]" id="isContinuo{{ $index }}" value="{{ ($monitoramento->fimMonitoramento) ? 'true' : 'false' }}">
        </div>

        <script>
          CKEDITOR.replace(`monitoramentoControleSugerido{{ $index }}`);
          CKEDITOR.replace(`statusMonitoramento{{ $index }}`);
          CKEDITOR.replace(`execucaoMonitoramento{{ $index }}`);
        </script>
      @endforeach

      <div id="monitoramentosDiv" class="monitoramento">
          <!-- Aqui serão adicionados os monitoramentos dinamicamente -->
      </div>

      <div class="buttons">
        <button type="button" class="add-btn" onclick="addMonitoramento()">Adicionar Monitoramento</button>
        <button type="button" class="close-btn" onclick="fecharFormulario()">Fechar</button>
      </div>

      <hr id="hr3">

      <span id="tip">
        <i class="bi bi-exclamation-circle-fill"></i>
        Dica: Revise sua edição antes de salvar
      </span>

      <div id="btnSave">
        <button type="submit" class="submit-btn">Salvar Edição</button>
      </div>
    </form>
  </div>
</div>

<script>
  let cont = {{ count($risco->monitoramentos) }};
  let monitoramentoCounter = document.getElementById('monitoramentoCounter');

  function updateCounter() {
    monitoramentoCounter.textContent = cont;
  }

  function addMonitoramento() {
    let monitoramentosDiv = document.getElementById('monitoramentosDiv');
    let monitoramentoDiv = document.createElement('div');
    monitoramentoDiv.classList.add('monitoramento');

    let numeration = document.createElement('span');
    numeration.classList.add('numeration');
    numeration.textContent = `Monitoramento Nº ${cont + 1}`;
    monitoramentoDiv.appendChild(numeration);

    let controleSugerido = document.createElement('textarea');
    controleSugerido.name = `monitoramentos[${cont}][monitoramentoControleSugerido]`;
    controleSugerido.placeholder = 'Monitoramento';
    controleSugerido.classList.add('textInput');
    controleSugerido.id = `monitoramentoControleSugerido${cont}`;

    let statusMonitoramentoLabel = document.createElement('label');
    statusMonitoramentoLabel.textContent = 'Status do Monitoramento:';
    let statusMonitoramento = document.createElement('textarea');
    statusMonitoramento.name = `monitoramentos[${cont}][statusMonitoramento]`;
    statusMonitoramento.placeholder = 'Status do Monitoramento';
    statusMonitoramento.classList.add('textInput');
    statusMonitoramento.id = `statusMonitoramento${cont}`;

    let execucaoMonitoramentoLabel = document.createElement('label');
    execucaoMonitoramentoLabel.textContent = 'Execução do Monitoramento:';
    let execucaoMonitoramento = document.createElement('textarea');
    execucaoMonitoramento.name = `monitoramentos[${cont}][execucaoMonitoramento]`;
    execucaoMonitoramento.placeholder = 'Execução do Monitoramento';
    execucaoMonitoramento.classList.add('textInput');
    execucaoMonitoramento.id = `execucaoMonitoramento${cont}`;

    let rowDiv = document.createElement('div');
    rowDiv.classList.add('row', 'g-3');

    let colDiv1 = document.createElement('div');
    colDiv1.classList.add('col-sm-12', 'col-md-6');
    let inicioMonitoramentoLabel = document.createElement('label');
    inicioMonitoramentoLabel.textContent = 'Início do Monitoramento:';
    let inicioMonitoramento = document.createElement('input');
    inicioMonitoramento.type = 'date';
    inicioMonitoramento.name = `monitoramentos[${cont}][inicioMonitoramento]`;
    inicioMonitoramento.classList.add('textInput', 'dateInput');
    colDiv1.appendChild(inicioMonitoramentoLabel);
    colDiv1.appendChild(inicioMonitoramento);

    let colDiv2 = document.createElement('div');
    colDiv2.classList.add('col-sm-12', 'col-md-6', 'mQuery2');
    let fimMonitoramentoLabel = document.createElement('label');
    fimMonitoramentoLabel.textContent = 'Fim do Monitoramento:';
    let fimMonitoramento = document.createElement('input');
    fimMonitoramento.type = 'date';
    fimMonitoramento.name = `monitoramentos[${cont}][fimMonitoramento]`;
    fimMonitoramento.classList.add('textInput', 'dateInput');
    colDiv2.appendChild(fimMonitoramentoLabel);
    colDiv2.appendChild(fimMonitoramento);

    rowDiv.appendChild(colDiv1);
    rowDiv.appendChild(colDiv2);

    // Adicionar campo hidden para isContinuo
    let isContinuoHidden = document.createElement('input');
    isContinuoHidden.type = 'hidden';
    isContinuoHidden.name = `monitoramentos[${cont}][isContinuo]`;
    isContinuoHidden.id = `isContinuo${cont}`;
    monitoramentoDiv.appendChild(isContinuoHidden);

    monitoramentoDiv.appendChild(controleSugerido);
    monitoramentoDiv.appendChild(statusMonitoramentoLabel);
    monitoramentoDiv.appendChild(statusMonitoramento);
    monitoramentoDiv.appendChild(execucaoMonitoramentoLabel);
    monitoramentoDiv.appendChild(execucaoMonitoramento);
    monitoramentoDiv.appendChild(rowDiv);
    monitoramentosDiv.appendChild(monitoramentoDiv);

    CKEDITOR.replace(`monitoramentoControleSugerido${cont}`);
    CKEDITOR.replace(`statusMonitoramento${cont}`);
    CKEDITOR.replace(`execucaoMonitoramento${cont}`);

    cont++;
    updateCounter();
  }

  function fecharFormulario() {
    document.getElementById('monitoramentosDiv').innerHTML = '';
    cont = 0;
    updateCounter();
  }

  updateCounter();
  CKEDITOR.replace('riscoEvento');
  CKEDITOR.replace('riscoCausa');
  CKEDITOR.replace('riscoConsequencia');

  @foreach($risco->monitoramentos as $index => $monitoramento)
    CKEDITOR.replace(`monitoramentoControleSugerido{{ $index }}`);
    CKEDITOR.replace(`statusMonitoramento{{ $index }}`);
    CKEDITOR.replace(`execucaoMonitoramento{{ $index }}`);
  @endforeach

</script>
@endsection
