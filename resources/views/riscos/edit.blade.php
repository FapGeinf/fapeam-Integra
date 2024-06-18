@extends('layouts.app')

@section('content')

@section('title') {{'Editar Formulário'}} @endsection
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Formulário de Risco</title>
  <link rel="stylesheet" href="{{asset('css/edit.css')}}">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
  <script src="/ckeditor/ckeditor.js" ></script>
</head>

<body>
  @if(session('error'))
    <script>alert('{{ session('error') }}');</script>
  @endif

  <div class="form-wrapper pt-4">
    <div class="form_create">
      <h3 style="text-align: center; margin-bottom: 20px;">
        Editar Formulário de Risco
      </h3>
      <hr>

      <form action="{{ route('riscos.update', ['id' => $risco->id]) }}" method="post" id="formCreate">
        @csrf
        @method('PUT')
        <input type="hidden" name="risco_id" value="{{ $risco->id }}">
        <label id="first" for="riscoEvento">Evento:</label>
        <textarea type="text" name="riscoEvento" class="textInput" required>{{ $risco->riscoEvento ?? old('riscoEvento') }}</textarea>

        <label for="riscoCausa">Causa:</label>
        <textarea type="text" name="riscoCausa" class="textInput" required>{{ $risco->riscoCausa ?? old('riscoCausa') }}</textarea>

        <label for="riscoConsequencia">Consequência:</label>
        <textarea type="text" name="riscoConsequencia" class="textInput" required>{{ $risco->riscoConsequencia ?? old('riscoConsequencia') }}</textarea>

        <label for="riscoAvaliacao">Avaliação:</label>
        <input type="number" name="riscoAvaliacao" class="textInput" value="{{ $risco->riscoAvaliacao ?? old('riscoAvaliacao') }}" required>

        <label for="unidadeId">Unidade:</label>
        <select name="unidadeId" required>
          <option selected disabled>Selecione uma unidade</option>
          @foreach($unidades as $unidade)
            <option value="{{ $unidade->id }}" {{ isset($risco) && $risco->unidadeId == $unidade->id ? 'selected' : '' }}>{{ $unidade->unidadeNome }}</option>
          @endforeach
        </select>

        <hr id="hr2">

        <div>
          <span>Monitoramentos adicionados: </span>
          <span id="monitoramentoCounter">{{ count($risco->monitoramentos) }}</span>
        </div>

        <div id="monitoramentosDiv" class="monitoramento"></div>

        <div class="buttons">
          <button type="button" class="add-btn" onclick="addMonitoramentos()">Adicionar Monitoramento</button>
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

    function addMonitoramentos() {
      let controleSugerido = document.createElement('input');
      controleSugerido.type = 'text';
      controleSugerido.name = `monitoramentos[${cont}][monitoramentoControleSugerido]`;
      controleSugerido.placeholder = 'Monitoramento';
      controleSugerido.classList = 'textInput';
      controleSugerido.value = ''; // Defina o valor padrão aqui se necessário

      let statusMonitoramento = document.createElement('input');
      statusMonitoramento.type = 'text';
      statusMonitoramento.name = `monitoramentos[${cont}][statusMonitoramento]`;
      statusMonitoramento.placeholder = 'Status do Monitoramento';
      statusMonitoramento.classList = 'textInput';
      statusMonitoramento.value = ''; // Defina o valor padrão aqui se necessário

      let execucaoMonitoramento = document.createElement('input');
      execucaoMonitoramento.type = 'text';
      execucaoMonitoramento.name = `monitoramentos[${cont}][execucaoMonitoramento]`;
      execucaoMonitoramento.placeholder = 'Execução do Monitoramento';
      execucaoMonitoramento.classList = 'textInput';
      execucaoMonitoramento.value = '';

      let monitoramentosDiv = document.getElementById('monitoramentosDiv');
      monitoramentosDiv.appendChild(controleSugerido);
      monitoramentosDiv.appendChild(statusMonitoramento);
      monitoramentosDiv.appendChild(execucaoMonitoramento);

      let monitoramentoDiv = document.createElement('div');
      monitoramentoDiv.classList.add('monitoramento');
      let numeration = document.createElement('span');
      numeration.classList.add('numeration');
      numeration.textContent = `Monitoramento Nº ${cont + 1}`;
      monitoramentoDiv.appendChild(numeration);
      document.getElementById('monitoramentosDiv').appendChild(monitoramentoDiv);
      cont++;
      updateCounter();
    }

    function fecharFormulario() {
      document.getElementById('monitoramentosDiv').innerHTML = ''; // Limpa o conteúdo dos monitoramentos
      cont = 0; // Reseta o contador
      updateCounter(); // Atual
    }
    updateCounter();
  </script>

<script>
  CKEDITOR.replace('riscoEvento');
  CKEDITOR.replace('riscoCausa');
  CKEDITOR.replace('riscoConsequencia');
</script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js"></script>

</body>
</html>
@endsection
