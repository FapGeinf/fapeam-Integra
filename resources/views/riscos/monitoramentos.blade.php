@extends('layouts.app')

@section('content')

@section('title', 'Editar Monitoramentos')

<head>
  <link rel="stylesheet" href="{{ asset('css/edit.css') }}">
  <script src="/ckeditor/ckeditor.js"></script>
</head>

<div class="form-wrapper pt-4">
  <div class="form_create">
    <h3 style="text-align: center; margin-bottom: 10px;">Formulário de Monitoramentos</h3>

    <div class="error-message">
        @if($errors->any())
             <div class="alert alert-danger">
                 <ul style="list-style-type:none;">
                     @foreach ($errors->all() as $error )
                         <li>{{$error}}</li>
                     @endforeach
                 </ul>
             </div>
         @endif
     </div>


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

          <textarea name="monitoramentos[{{ $index }}][monitoramentoControleSugerido]" placeholder="Monitoramento" class="textInput" id="monitoramentoControleSugerido{{ $index }}">{{ $monitoramento->monitoramentoControleSugerido }}</textarea>

          <label>Status do Monitoramento:</label>
          <select name="monitoramentos[{{ $index }}][statusMonitoramento]" class="textInput" id="statusMonitoramento{{ $index }}">
            <option value="NÃO IMPLEMENTADA" {{ $monitoramento->statusMonitoramento == 'NÃO IMPLEMENTADA' ? 'selected' : '' }}>NÃO IMPLEMENTADA</option>
            <option value="EM IMPLEMENTAÇÃO" {{ $monitoramento->statusMonitoramento == 'EM IMPLEMENTAÇÃO' ? 'selected' : '' }}>EM IMPLEMENTAÇÃO</option>
            <option value="IMPLEMENTADA PARCIALMENTE" {{ $monitoramento->statusMonitoramento == 'IMPLEMENTADA PARCIALMENTE' ? 'selected' : '' }}>IMPLEMENTADA PARCIALMENTE</option>
            <option value="IMPLEMENTADA" {{ $monitoramento->statusMonitoramento == 'IMPLEMENTADA' ? 'selected' : '' }}>IMPLEMENTADA</option>
          </select>

          <label>Execução do Monitoramento:</label>
          <textarea name="monitoramentos[{{ $index }}][execucaoMonitoramento]" placeholder="Execução do Monitoramento" class="textInput" id="execucaoMonitoramento{{ $index }}">{{ $monitoramento->execucaoMonitoramento }}</textarea>

          <div class="row g-3">
            <div class="col-sm-12 col-md-12">
              <label>Monitoramento Contínuo:</label>
              <select name="monitoramentos[{{ $index }}][isContinuo]" class="form-select" id="isContinuo{{ $index }}">
                <option value="1" {{ $monitoramento->isContinuo == 1 ? 'selected' : '' }}>Sim</option>
                <option value="0" {{ $monitoramento->isContinuo == 0 ? 'selected' : '' }}>Não</option>
              </select>
            </div>
          </div>

          <div class="row g-3">
            <div class="col-sm-12 col-md-6">
              <label>Início do Monitoramento:</label>
              <input type="date" name="monitoramentos[{{ $index }}][inicioMonitoramento]" class="textInput dateInput" value="{{ $monitoramento->inicioMonitoramento }}">
            </div>

            <div class="col-sm-12 col-md-6 mQuery2" id="fimMonitoramentoContainer{{ $index }}">
              <label>Fim do Monitoramento:</label>
              <input type="date" name="monitoramentos[{{ $index }}][fimMonitoramento]" class="textInput dateInput" id="fimMonitoramento{{ $index }}" value="{{ $monitoramento->fimMonitoramento }}">
            </div>
          </div>

        </div>

        <script>
          CKEDITOR.replace(`monitoramentoControleSugerido{{ $index }}`);
          CKEDITOR.replace(`execucaoMonitoramento{{ $index }}`);
        </script>
      @endforeach

      <div id="monitoramentosDiv" class="monitoramento">
          <!-- Aqui serão adicionados os monitoramentos dinamicamente -->
      </div>

      <div class="buttons">
        <button type="button" class="add-btn" onclick="addMonitoramento()">Adicionar Monitoramento</button>
        <button type="button" class="close-btn" onclick="fecharFormulario()">Excluir</button>
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
    let statusMonitoramento = document.createElement('select');
    statusMonitoramento.name = `monitoramentos[${cont}][statusMonitoramento]`;
    statusMonitoramento.classList.add('textInput');
    statusMonitoramento.id = `statusMonitoramento${cont}`;

    let options = [
      { value: "NÃO IMPLEMENTADA", text: "NÃO IMPLEMENTADA" },
      { value: "EM IMPLEMENTAÇÃO", text: "EM IMPLEMENTAÇÃO" },
      { value: "IMPLEMENTADA PARCIALMENTE", text: "IMPLEMENTADA PARCIALMENTE" },
      { value: "IMPLEMENTADA", text: "IMPLEMENTADA" }
    ];

    options.forEach(function(optionData) {
      let option = document.createElement('option');
      option.value = optionData.value;
      option.text = optionData.text;
      statusMonitoramento.appendChild(option);
    });

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

    monitoramentoDiv.appendChild(controleSugerido);
    monitoramentoDiv.appendChild(statusMonitoramentoLabel);
    monitoramentoDiv.appendChild(statusMonitoramento);
    monitoramentoDiv.appendChild(execucaoMonitoramentoLabel);
    monitoramentoDiv.appendChild(execucaoMonitoramento);
    monitoramentoDiv.appendChild(rowDiv);

    let divIsContinuo = document.createElement('div');
    divIsContinuo.classList.add('form-group');
    monitoramentoDiv.appendChild(divIsContinuo);

    let labelIsContinuo = document.createElement('label');
    labelIsContinuo.textContent = 'Monitoramento Contínuo:';
    divIsContinuo.appendChild(labelIsContinuo);

    let selectIsContinuo = document.createElement('select');
    selectIsContinuo.name = `monitoramentos[${cont}][isContinuo]`;
    selectIsContinuo.classList.add('form-select');
    selectIsContinuo.id = `isContinuo${cont}`;

    let optionNao = document.createElement('option');
    optionNao.value = 0;
    optionNao.textContent = 'Não';
    selectIsContinuo.appendChild(optionNao);

    let optionSim = document.createElement('option');
    optionSim.value = 1;
    optionSim.textContent = 'Sim';
    selectIsContinuo.appendChild(optionSim);

    let inputFimMonitoramento = fimMonitoramento;
    let labelFimMonitoramento = fimMonitoramentoLabel;

    selectIsContinuo.addEventListener('change', function() {
      if (this.value == 1) {
        inputFimMonitoramento.value = '';
        colDiv2.style.display = 'none';
      } else {
        colDiv2.style.display = 'block';
      }
    });

    divIsContinuo.appendChild(selectIsContinuo);

    monitoramentosDiv.appendChild(monitoramentoDiv);

    CKEDITOR.replace(`monitoramentoControleSugerido${cont}`);
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
    CKEDITOR.replace(`execucaoMonitoramento{{ $index }}`);

    let isContinuo{{ $index }} = document.getElementById(`isContinuo{{ $index }}`);
    let fimMonitoramento{{ $index }} = document.getElementById(`fimMonitoramentoContainer{{ $index }}`);

    isContinuo{{ $index }}.addEventListener('change', function() {
      if (this.value == 1) {
        fimMonitoramento{{ $index }}.style.display = 'none';
      } else {
        fimMonitoramento{{ $index }}.style.display = 'block';
      }
    });

  @endforeach

</script>

@endsection
