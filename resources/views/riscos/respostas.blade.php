@extends('layouts.app')
@section('content')

@section('title') {{'Tabela das Respostas'}} @endsection

<head>
  <link rel="stylesheet" href="{{asset('css/resp.css')}}">
</head>

<div class="container-fluid p-30">
  <div class="col-12 box-shadow">
    <h4 class="text-center mb-3">Detalhes da Resposta</h4>
    <hr class="line">

    <div class="">
      @if($respostas->count() > 0)
      <table class="table table-bordered">
        <tr>
          <th scope="col" class="text-center thNumber">N°</th>
          <th scope="col" class="text-center thReply">Resposta do Risco: {{ $risco->id}}</th>
        </tr>

        @foreach ($respostas as $key => $resposta)
        <tr>
          <td class="text-center text13 tdNumber">{!! $key + 1 !!}</td>
          <td class="text13 tdReply">{!! $resposta->respostaRisco !!}</td>
        </tr>
        @endforeach
      </table>
      @else
      <p class="text-center">Não há respostas disponíveis para este risco.</p>
      @endif
    </div>
  </div>
</div>

<div class="container d-flex justify-content-center">
  <button type="button" class="reply-btn" data-bs-toggle="modal" data-bs-target="#respostaModal">Responder</button>
</div>

<div class="modal fade" id="respostaModal" tabindex="-1" aria-labelledby="respostaModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="respostaModalLabel">Adicionar Resposta</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form action="{{ route('riscos.storeResposta', ['id' => $risco->id]) }}" method="POST">
          @csrf
          <div id="respostasFields">
            <div class="mb-4 resposta" style="margin-top: 10px;">
              <label for="respostas[0][respostaRisco]" class="form-label">Resposta 1</label>
              <input type="text" class="form-control" name="respostas[0][respostaRisco]" required>
            </div>
          </div>
          <div class="d-grid gap-2 d-md-flex justify-content-md-end" id="botoesExcluir">
            <button type="button" class="btn btn-primary me-md-2 mb-2" onclick="addRespostaField()">Adicionar Resposta</button>
            <button type="submit" class="btn btn-success mb-2">Salvar</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>

<script>
  let respostaCount = 1;

  function addRespostaField() {
    let respostasFields = document.getElementById('respostasFields');

    let fieldGroup = document.createElement('div');
    fieldGroup.classList.add('mb-3');

    let label = document.createElement('label');
    label.for = `respostas[${respostaCount}][respostaRisco]`;
    label.classList.add('form-label');
    label.innerText = `Resposta #${respostaCount + 1}`;

    let input = document.createElement('input');
    input.type = 'text';
    input.classList.add('form-control');
    input.name = `respostas[${respostaCount}][respostaRisco]`;
    input.required = true;

    let deleteButton = document.createElement('button');
    deleteButton.type = 'button';
    deleteButton.classList.add('btn', 'btn-danger', 'btn-sm', 'mt-2');
    deleteButton.innerText = 'Excluir Resposta';
    deleteButton.onclick = function () {
      removeRespostaField(fieldGroup);
    };

    fieldGroup.appendChild(label);
    fieldGroup.appendChild(input);
    fieldGroup.appendChild(deleteButton);
    respostasFields.appendChild(fieldGroup);
    respostaCount++;
  }

  function removeRespostaField(fieldGroup) {
    fieldGroup.remove();
    respostaCount--;
    if (respostaCount === 1) {
      document.querySelector('.resposta .btn-danger').remove();
    }
  }
</script>
@endsection
