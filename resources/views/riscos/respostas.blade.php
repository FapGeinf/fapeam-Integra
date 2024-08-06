@extends('layouts.app')
@section('content')

@section('title') {{'Tabela das Respostas'}} @endsection

<head>
  <link rel="stylesheet" href="{{asset('css/resp.css')}}">
</head>

<div class="container p-30">
  <div class="col-12 box-shadow">
    <h4 class="text-center mb-3">Detalhes da Resposta</h4>
    <hr class="line">

    <div class="chat-box">
      @if($respostas->count() > 0)
      @php
        $lastSetor = null; // Para rastrear o setor da última mensagem
      @endphp

      @foreach ($respostas as $resposta)
      @php
        $currentSetor = $resposta->user->unidade->id;
      @endphp

        @if($lastSetor === $currentSetor)
          <div class="message other-message {{ $alignmentClass }}">
            <div class="p-1">
              <span>
                <i class="bi bi-person-circle"></i>
              </span>

              <span>
                {{ $resposta->user->name }}:
              </span>
            </div>
            
            <hr>

            
            <p class="form-control fStyle" style="background-color: #f0f0f0;">{!! $resposta->respostaRisco !!}</p>

            <div class="text-end">
              <button type="button" class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#editRespostaModal" onclick="editResposta({{ $resposta->id }}, '{{ $resposta->respostaRisco }}')">Editar</button>
            </div>

          </div>
          
        @else
          @php
            $alignmentClass = (isset($alignmentClass) && $alignmentClass === 'align-left') ? 'align-right' : 'align-left';
          @endphp
          <div class="message other-message {{ $alignmentClass }}">
            <div class="p-1">
              <span>
                <i class="bi bi-person-circle"></i>
              </span>

              <span>
                {{ $resposta->user->name }}:
              </span>
              
            </div>

            <hr>
            
            <p class="form-control fStyle" style="background-color: #f0f0f0;">{!! $resposta->respostaRisco !!}</p>

            <div class="text-end">
              <button type="button" class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#editRespostaModal" onclick="editResposta({{ $resposta->id }}, '{{ $resposta->respostaRisco }}')">Editar</button>
            </div>
            
          </div>
        @endif

        @php
          $lastSetor = $currentSetor; // Atualiza o setor da última mensagem
        @endphp
      @endforeach
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
              <label for="respostas[0][respostaRisco]" class="form-label">Resposta</label>
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

<div class="modal fade" id="editRespostaModal" tabindex="-1" aria-labelledby="editRespostaModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="editRespostaModalLabel">Editar Resposta</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form id="editRespostaForm" action="{{route('riscos.updateResposta',['id' => $resposta->id])}}" method="POST">
          @csrf
          @method('PUT')
          <div class="mb-4">
            <label for="editRespostaRisco" class="form-label">Resposta</label>
            <input type="text" class="form-control" id="editRespostaRisco" name="respostaRisco" required>
          </div>
          <div class="d-grid gap-2 d-md-flex justify-content-md-end">
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

  function editResposta(id, resposta) {
    const form = document.getElementById('editRespostaForm');
    form.action = `/riscos/respostas/${id}`;
    document.getElementById('editRespostaRisco').value = resposta;
  }
</script>
@endsection
