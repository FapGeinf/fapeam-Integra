@extends('layouts.app')

@section('content')
<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Riscos</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa;
        }

        .container-fluid {
            position: relative;
            top: 120px;
            display: flex;
            justify-content: center;
        }

        .box-shadow {
            box-shadow: 0 .5rem 1rem rgba(0, 0, 0, .15);
            border-radius: .25rem;
            background-color: #fff;
            padding: 20px;
            margin-bottom: 30px;
        }

        .table th,
        .table td {
            vertical-align: middle;
        }

        .text-center {
            text-align: center;
        }

        .text-light {
            color: #f8f9fa !important;
        }

        .bg-dark {
            background-color: #343a40 !important;
        }

        .mb-4 {
            margin-bottom: 1.5rem !important;
        }

        .resposta {
            margin-bottom: 10px;
        }
    </style>
</head>
<body>
    @if(session('error'))
        <script>alert('{{ session('error') }}');</script>
    @endif

    <div class="container-fluid pt-4">
        <div class="box-shadow">
            <h4 class="text-center mb-4">Detalhamento Risco Inerente</h4>
            <table class="table table-bordered mb-4">
                <thead>
                    <tr>
                        <th scope="col" class="text-center text-light bg-dark">Evento</th>
                        <th scope="col" class="text-center text-light bg-dark">Causa</th>
                        <th scope="col" class="text-center text-light bg-dark">Consequência</th>
                        <th scope="col" class="text-center text-light bg-dark">Avaliação</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td class="text-center">{!! $risco->riscoEvento !!}</td>
                        <td class="text-center">{!! $risco->riscoCausa !!}</td>
                        <td class="text-center">{!! $risco->riscoConsequencia !!}</td>
                        <td class="text-center">{{ $risco->riscoAvaliacao }}</td>
                    </tr>
                </tbody>
            </table>
            <h5 class="text-center mb-4">Plano de ação</h5>
            <table class="table table-bordered mb-4">
                <thead>
                    <tr>
                        <th scope="col" class="text-center text-light bg-dark">Controle Sugerido</th>
                        <th scope="col" class="text-center text-light bg-dark">Status</th>
                        <th scope="col" class="text-center text-light bg-dark">Execução</th>
                        <th scope="col" class="text-center text-light bg-dark">Ações</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($risco->monitoramentos as $monitoramento)
                        <tr>
                            <td class="text-center">{!! $monitoramento->monitoramentoControleSugerido !!}</td>
                            <td class="text-center">{!! $monitoramento->statusMonitoramento !!}</td>
                            <td class="text-center">{!! $monitoramento->execucaoMonitoramento !!}</td>
                            @if(count($monitoramentos)>1)
                            <td><button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#modal-exclusao">Excluir</button></td>
                            @endif
                        </tr>
                    @endforeach
                </tbody>
            </table>
            <div class="text-center mb-4">
                @if (Auth::user()->unidade->unidadeTipoFK == 1)
                    <a href="{{ route('riscos.edit', $risco->id) }}" class="btn btn-primary">Editar</a>
                @endif
                <button type="button" class="btn btn-secondary" data-bs-toggle="modal" data-bs-target="#respostaModal">Adicionar Resposta</button>
            </div>
            <h2 class="text-center mb-4">Respostas</h2>
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
        </div>
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
                            <div class="mb-3">
                                <label for="respostas[0][respostaRisco]" class="form-label">Resposta 1</label>
                                <input type="text" class="form-control" name="respostas[0][respostaRisco]" required>
                            </div>
                        </div>
                        <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                            <button type="button" class="btn btn-secondary me-md-2 mb-2" onclick="addRespostaField()">Adicionar Campo</button>
                            <button type="submit" class="btn btn-primary mb-2">Salvar</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
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
    <script>
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

            fieldGroup.appendChild(label);
            fieldGroup.appendChild(input);
            respostasFields.appendChild(fieldGroup);

            respostaCount++;
        }
    </script>

    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js"></script>
</body>
</html>
@endsection
