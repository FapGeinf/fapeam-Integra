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
  <script src="/ckeditor/ckeditor.js"></script>
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

		<div class="col-sm-12 col-md-4 mQuery">
            <label for="name">Numero do Risco:</label>
            <input type="text" id="riscoNum" name="riscoNum" class="form-control dataValue" value="{{$risco->riscoNum}}">
        </div>

        <div class="col-sm-12 col-md-4 mQuery">
            <label for="name">Responsável do Risco:</label>
            <input type="text" id="responsavelRisco" name="responsavelRisco" class="form-control dataValue" value="{{$risco->responsavelRisco ?? old('responsavelRisco')}}">
        </div>

        <label id="first" for="riscoEvento">Evento:</label>
        <textarea name="riscoEvento" class="textInput" required>{{ $risco->riscoEvento ?? old('riscoEvento') }}</textarea>

        <label for="riscoCausa">Causa:</label>
        <textarea name="riscoCausa" class="textInput" required>{{ $risco->riscoCausa ?? old('riscoCausa') }}</textarea>

        <label for="riscoConsequencia">Consequência:</label>
        <textarea name="riscoConsequencia" class="textInput" required>{{ $risco->riscoConsequencia ?? old('riscoConsequencia') }}</textarea>

        <div class="row g-3 mt-1">
          <div class="col-sm-12 col-md-4 mQuery">
            <label for="name">Insira o Ano:</label>
            <input type="text" id="riscoAno" name="riscoAno" class="form-control dataValue" value="{{$risco->riscoAno}}">
          </div>

          <div class="col-sm-12 col-md-8 mQuery">
            <label for="probabilidade_risco">Probabilidade de Risco:</label>
            <select name="probabilidade_risco" id="probabilidade_risco" required onchange="calculateRiscoAvaliacao()">
              <option value="1" {{ $risco->probabilidade_risco == 1 ? 'selected' : '' }}>Baixo</option>
              <option value="3" {{ $risco->probabilidade_risco == 3 ? 'selected' : '' }}>Médio</option>
              <option value="5" {{ $risco->probabilidade_risco == 5 ? 'selected' : '' }}>Alto</option>
            </select>
          </div>
        </div>

        <div class="row g-3 mt-1">
          <div class="col-sm-12 col-md-8 mQuery">
          <label for="unidadeId">Unidade:</label>
          <select name="unidadeId" required>
            <option selected disabled>Selecione uma unidade</option>
            @foreach($unidades as $unidade)
              <option value="{{ $unidade->id }}" {{ isset($risco) && $risco->unidadeId == $unidade->id ? 'selected' : '' }}>{{ $unidade->unidadeNome }}</option>
            @endforeach
          </select>
          </div>

          <input type="hidden" name="riscoAvaliacao" id="riscoAvaliacao" value="{{ $risco->riscoAvaliacao }}">

          <div class="col-sm-12 col-md-4 mQuery">
            <label style="white-space: nowrap" for="impacto_risco">Impacto do Risco:</label>
            <select name="impacto_risco" id="impacto_risco" required onchange="calculateRiscoAvaliacao()">
              <option value="1" {{ $risco->impacto_risco == 1 ? 'selected' : '' }}>Baixo</option>
              <option value="3" {{ $risco->impacto_risco == 3 ? 'selected' : '' }}>Médio</option>
              <option value="5" {{ $risco->impacto_risco == 5 ? 'selected' : '' }}>Alto</option>
            </select>
          </div>
        </div>

        {{-- <hr id="hr2">

        <div>
          <span>Monitoramentos adicionados: </span>
          <span id="monitoramentoCounter">{{ count($risco->monitoramentos) }}</span>
        </div>


        <div id="monitoramentosDiv" class="monitoramento">

        </div>

        <div class="buttons">
          <button type="button" class="add-btn" onclick="addMonitoramentos()">Adicionar Monitoramento</button>
          <button type="button" class="close-btn" onclick="fecharFormulario()">Fechar</button>
        </div>--}}

        <hr id="hr4">

        <span id="tip">
          <i class="bi bi-exclamation-circle-fill"></i>
          Dica: Revise sua edição antes de salvar
        </span>
        <div class="mt-3 text-center mb-3">
          <a href="{{ route('riscos.edit-monitoramentos', ['id' => $risco->id]) }}" class="btn btn-primary">Editar Monitoramentos</a>
        </div>

        <div id="btnSave">
          <button type="submit" class="submit-btn">Salvar Edição</button>
        </div>
      </form>
    </div>
  </div>

  <script>
    // let cont = {{ count($risco->monitoramentos) }};
    // let monitoramentoCounter = document.getElementById('monitoramentoCounter');

    // function updateCounter() {
    //   monitoramentoCounter.textContent = cont;
    // }

    // function addMonitoramentos() {
    //   let monitoramentosDiv = document.getElementById('monitoramentosDiv');

    //   let monitoramentoDiv = document.createElement('div');
    //   monitoramentoDiv.classList.add('monitoramento');

    //   let numeration = document.createElement('span');
    //   numeration.classList.add('numeration');
    //   numeration.textContent = `Monitoramento Nº ${cont + 1}`;
    //   monitoramentoDiv.appendChild(numeration);

    //   let controleSugerido = document.createElement('textarea');
    //   controleSugerido.name = `monitoramentos[${cont}][monitoramentoControleSugerido]`;
    //   controleSugerido.placeholder = 'Monitoramento';
    //   controleSugerido.classList.add('textInput');
    //   controleSugerido.id = `monitoramentoControleSugerido${cont}`;

    //   let statusMonitoramento = document.createElement('input');
    //   statusMonitoramento.type = 'text';
    //   statusMonitoramento.name = `monitoramentos[${cont}][statusMonitoramento]`;
    //   statusMonitoramento.placeholder = 'Status do Monitoramento';
    //   statusMonitoramento.classList.add('textInput');

    //   let execucaoMonitoramento = document.createElement('input');
    //   execucaoMonitoramento.type = 'text';
    //   execucaoMonitoramento.name = `monitoramentos[${cont}][execucaoMonitoramento]`;
    //   execucaoMonitoramento.placeholder = 'Execução do Monitoramento';
    //   execucaoMonitoramento.classList.add('textInput');

    //   let inicioMonitoramento = document.createElement('input');
    //   inicioMonitoramento.type = 'date';
    //   inicioMonitoramento.name = `monitoramentos[${cont}][inicioMonitoramento]`;
    //   inicioMonitoramento.classList.add('textInput');

    //   let fimMonitoramento = document.createElement('input');
    //   fimMonitoramento.type = 'date';
    //   fimMonitoramento.name = `monitoramentos[${cont}][fimMonitoramento]`;
    //   fimMonitoramento.classList.add('textInput');

    //   monitoramentoDiv.appendChild(controleSugerido);
    //   monitoramentoDiv.appendChild(statusMonitoramento);
    //   monitoramentoDiv.appendChild(execucaoMonitoramento);
    //   monitoramentoDiv.appendChild(inicioMonitoramento);
    //   monitoramentoDiv.appendChild(fimMonitoramento);

    //   monitoramentosDiv.appendChild(monitoramentoDiv);

    //   CKEDITOR.replace(`monitoramentoControleSugerido${cont}`);
    //   cont++;
    //   updateCounter();
    // }

    // function fecharFormulario() {
    //   document.getElementById('monitoramentosDiv').innerHTML = '';
    //   cont = 0;
    //   updateCounter();
    // }

    // updateCounter();

    function calculateRiscoAvaliacao() {
      const probabilidade = document.getElementById('probabilidade_risco').value;
      const impacto = document.getElementById('impacto_risco').value;
      const avaliacao = probabilidade * impacto;
      document.getElementById('riscoAvaliacao').value = avaliacao;
    }

    CKEDITOR.replace('riscoEvento');
    CKEDITOR.replace('riscoCausa');
    CKEDITOR.replace('riscoConsequencia');
    // @foreach ($risco->monitoramentos as $index => $monitoramento)
    //   CKEDITOR.replace(`monitoramentoControleSugerido${index}`);
    // @endforeach
  </script>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
@endsection
