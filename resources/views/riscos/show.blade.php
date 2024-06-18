@extends('layouts.app')
@section('content')

@section('title') {{'Detalhes do Risco'}} @endsection
<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Riscos</title>
  <link rel="stylesheet" href="{{asset('css/show.css')}}">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
</head>
<body>
  @if(session('error'))
    <script>alert('{{ session('error') }}');</script>
  @endif

  <div class="container-fluid p-30">
    <div class="col-12 box-shadow">
      <h5 class="text-center mb-2">Detalhamento Risco Inerente</h5>

      <div class="">
        <table class="table table-bordered mb-4">
        <thead>
          <tr>
            <th scope="col" class="text-center text-light tBorder">Evento</th>
            <th scope="col" class="text-center text-light tBorder">Causa</th>
            <th scope="col" class="text-center text-light tBorder">Consequência</th>
            <th scope="col" class="text-center text-light">Avaliação</th>
          </tr>
        </thead>

        <tbody>
          <tr>
            <td class="text-center pb-5 tBorder">{!! $risco->riscoEvento !!}</td>
            <td class="text-center pb-5 tBorder">{!! $risco->riscoCausa !!}</td>
            <td class="text-center pb-5 tBorder">{!! $risco->riscoConsequencia !!}</td>
            <td class="text-center pb-5">{{ $risco->riscoAvaliacao }}</td>
          </tr>
        </tbody>
      </table>

        <h5 class="text-center mb-2">Plano de ação</h5>
        <table class="table table-bordered mb-4">
          <thead>
            <tr>
              <th scope="col" class="text-center text-light tBorder">Controle Sugerido</th>
              <th scope="col" class="text-center text-light tBorder">Status</th>
              <th scope="col" class="text-center text-light">Execução</th>
              {{-- <th scope="col" class="text-center text-light bg-dark">Ações</th> --}}
            </tr>
          </thead>

          <tbody>
            @foreach ($risco->monitoramentos as $monitoramento)
              <tr>
                <td class="text-center pb-5 tBorder">{!! $monitoramento->monitoramentoControleSugerido !!}</td>
                <td class="text-center pb-5 tBorder">{!! $monitoramento->statusMonitoramento !!}</td>
                <td class="text-center pb-5">{!! $monitoramento->execucaoMonitoramento !!}</td>
                @if(count($monitoramentos)>1)
                  <td><button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#modal-exclusao">Excluir</button></td>
                @endif
              </tr>
            @endforeach
          </tbody>
        </table>

        <div class="text-center mb-4">
          @if (Auth::user()->unidade->unidadeTipoFK == 1)
            <a href="{{ route('riscos.edit', $risco->id) }}" class="edit-btn">Editar</a>
          @endif
          <a href="{{ route('riscos.respostas', ['id' => $risco->id]) }}" class="reply-btn">Ver Respostas</a>
        </div>
      </div>
      

      </div>
    </div>
            {{-- <h2 class="text-center mb-4">Respostas</h2>
            <div id="respostasDiv" class="mb-4">
                @if($respostas->count() > 0)
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th scope="col" class="text-center text-light bg-dark">Nº</th>
                                <th scope="col" class="text-center text-light bg-dark">Resposta</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($respostas as $key => $resposta)
                                <tr>
                                    <td class="text-center">{{ $key + 1 }}</td>
                                    <td>{!! $resposta->respostaRisco !!}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                @else
                    <p class="text-center">Não há respostas disponíveis para este risco.</p>
                @endif
            </div>
        

    <div class="modal fade" id="respostaModal" tabindex="-1" aria-labelledby="respostaModalLabel" aria-hidden="true">
        <div class="modal-dialog">
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
                            <button type="button" class="btn btn-secondary me-md-2 mb-2" onclick="addRespostaField()">Adicionar Campo</button>
                            <button type="submit" class="btn btn-primary mb-2">Salvar</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div> --}}


    <div class="modal fade" id="modal-exclusao">
        <div class="modal-dialog">
             <div class="modal-content">
                 <div class="modal-header">
                     <h4 class="modal-title">Aviso</h4>
                 </div>
                 <div class="modal-body">
                     <p>Tem certeza que deseja apagar este monitoramento?</p>
                 </div>
                 <div class="modal-footer">
                    <form action="{{route('riscos.deleteMonitoramento', $monitoramento->id)}}" method="POST">
                          @method('DELETE')
                          @csrf
                          <button type="submit" class="btn btn-danger" data-bs-dismiss="modal">Apagar</button>
                    </form>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>
                 </div>
             </div>
         </div>
     </div>
    {{-- <script>
        let respostaCount = 1;

        function addRespostaField() {
            let respostasFields = document.getElementById('respostasFields');

            let fieldGroup = document.createElement('div');
            fieldGroup.classList.add('mb-3');

            let label = document.createElement('label');
            label.for = `respostas[${respostaCount}][respostaRisco]`;
            label.classList.add('form-label');
            label.innerText = `Resposta ${respostaCount + 1}`;

            let input = document.createElement('input');
            input.type = 'text';
            input.classList.add('form-control');
            input.name = `respostas[${respostaCount}][respostaRisco]`;
            input.required = true;

            let deleteButton = document.createElement('button');
            deleteButton.type = 'button';
            deleteButton.classList.add('btn', 'btn-danger', 'btn-sm');
            deleteButton.innerText = 'Excluir Campo';
            deleteButton.onclick = function() {
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
    </script> --}}

  <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js"></script>
</body>
</html>
@endsection
