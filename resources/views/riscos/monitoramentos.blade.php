@extends('layouts.app')

@section('content')

@section('title') {{'Editar Monitoramentos'}} @endsection
<head>
  <link rel="stylesheet" href="{{ asset('css/edit.css') }}">
  <script src="/ckeditor/ckeditor.js"></script>
</head>

  <div class="form-wrapper pt-4">
    <div class="form_create">
      <h3 style="text-align: center; margin-bottom: 10px;"> Formulário de Monitoramentos</h3>
      
      @if (session('error'))
        <script>
          alert('{{ session(' error ') }}');
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
            <input type="text" name="monitoramentos[{{ $index }}][statusMonitoramento]" placeholder="Status do Monitoramento" class="textInput" value="{{ $monitoramento->statusMonitoramento }}">

            <label>Execução do Monitoramento:</label>
            <input type="text" name="monitoramentos[{{ $index }}][execucaoMonitoramento]" placeholder="Execução do Monitoramento" class="textInput" value="{{ $monitoramento->execucaoMonitoramento }}">

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

          </div>

          <script>
            CKEDITOR.replace(`monitoramentoControleSugerido{{ $index }}`);
            CKEDITOR.replace(`monitoramentos[{{ $index }}][statusMonitoramento]`)
            CKEDITOR.replace(`monitoramentos[{{ $index }}][execucaoMonitoramento]`)
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

    let statusMonitoramento = document.createElement('input');
    statusMonitoramento.type = 'text';
    statusMonitoramento.name = `monitoramentos[${cont}][statusMonitoramento]`;
    statusMonitoramento.placeholder = 'Status do Monitoramento';
    statusMonitoramento.classList.add('textInput');

    let execucaoMonitoramento = document.createElement('input');
    execucaoMonitoramento.type = 'text';
    execucaoMonitoramento.name = `monitoramentos[${cont}][execucaoMonitoramento]`;
    execucaoMonitoramento.placeholder = 'Execução do Monitoramento';
    execucaoMonitoramento.classList.add('textInput');

    let inicioMonitoramento = document.createElement('input');
    inicioMonitoramento.type = 'date';
    inicioMonitoramento.name = `monitoramentos[${cont}][inicioMonitoramento]`;
    inicioMonitoramento.classList.add('textInput');

    let fimMonitoramento = document.createElement('input');
    fimMonitoramento.type = 'date';
    fimMonitoramento.name = `monitoramentos[${cont}][fimMonitoramento]`;
    fimMonitoramento.classList.add('textInput');

    monitoramentoDiv.appendChild(controleSugerido);
    monitoramentoDiv.appendChild(statusMonitoramento);
    monitoramentoDiv.appendChild(execucaoMonitoramento);
    monitoramentoDiv.appendChild(inicioMonitoramento);
    monitoramentoDiv.appendChild(fimMonitoramento);
    monitoramentosDiv.appendChild(monitoramentoDiv);

    CKEDITOR.replace(`monitoramentoControleSugerido${cont}`);
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
  @endforeach

</script>
@endsection
