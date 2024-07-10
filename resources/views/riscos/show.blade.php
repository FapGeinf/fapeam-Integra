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
  <script>
    alert('{{ session('error ') }}');
  </script>
  @endif

  <div class="container-fluid p-30">
    <div class="col-12 box-shadow">
      <h5 class="text-center mb-2">Detalhamento Risco Inerente</h5>

      <div class="">
        <table class="table table-bordered mb-4">
          <thead>
            <tr>
              <th style="white-space: nowrap; width: 100px;" scope="col" class="text-center text-light tBorder">N° Risco</th>
              <th scope="col" class="text-center text-light tBorder">Evento:</th>
              <th scope="col" class="text-center text-light tBorder">Causa:</th>
              <th scope="col" class="text-center text-light tBorder">Consequência:</th>
              <th style="width: 100px;" scope="col" class="text-center text-light">Avaliação:</th>
            </tr>
          </thead>

          <tbody>
            <tr>
              <td class="text-center pb-3 tBorder">{!! $risco->id !!}</td>
              <td class="text-center pb-3 tBorder">{!! $risco->riscoEvento !!}</td>
              <td class="text-center pb-3 tBorder">{!! $risco->riscoCausa !!}</td>
              <td class="text-center pb-3 tBorder">{!! $risco->riscoConsequencia !!}</td>

              @if($risco->nivel_de_risco==1)
                <td class = "bg-baixo riscoAvaliacao">{!! $risco->nivel_de_risco !!}</td>
                  @elseif ($risco->nivel_de_risco == 2)
                <td class = "bg-medio riscoAvaliacao">{!! $risco->nivel_de_risco !!}</td>
                  @else
                <td class = "bg-alto riscoAvaliacao">{!! $risco->nivel_de_risco !!}</td>
							@endif

              {{-- <td class="text-center pb-3">{!! $risco->riscoAvaliacao !!}</td> --}}
            </tr>
          </tbody>
        </table>

        <h5 class="text-center mb-2">Plano de ação</h5>
        <table class="table table-bordered mb-4">
          <thead>
            <tr>
              <th scope="col" class="text-center text-light tBorder">Controle Sugerido:</th>
              <th scope="col" class="text-center text-light tBorder">Status:</th>
              <th scope="col" class="text-center text-light">Execução:</th>
              <th scope="col" class="text-center text-light">Data:</th>
              @if(count($monitoramentos)>1)
              <th scope="col" class="text-center text-light">Ações:</th>
              @endif
            </tr>
          </thead>

          <tbody>
            @foreach ($risco->monitoramentos as $monitoramento)
                <td class="text-center pb-3 tBorder">{!! $monitoramento->monitoramentoControleSugerido !!}</td>
                <td style="white-space: nowrap;" class="text-center pb-3 tBorder">{!! $monitoramento->statusMonitoramento !!}</td>
                <td class="text-center pb-3">{!! $monitoramento->execucaoMonitoramento !!}</td>
                <td style="white-space: nowrap;" class="text-center pb-3">
                  {{ \Carbon\Carbon::parse($monitoramento->inicioMonitoramento)->format('d/m/Y') }} -
                  {{ $monitoramento->fimMonitoramento ? \Carbon\Carbon::parse($monitoramento->fimMonitoramento)->format('d/m/Y') : 'Contínuo' }}
                </td>
                @if(count($risco->monitoramentos) > 1)
                  <td class="text-center">
                    <button type="button" class="btn btn-sm btn-danger" data-bs-toggle="modal" data-bs-target="#modal-exclusao-{{ $monitoramento->id }}">Excluir</button>
                  </td>
                @endif
            </tr>
              </tr>

              <div class="modal fade" id="modal-exclusao-{{ $monitoramento->id }}">
                <div class="modal-dialog modal-dialog-centered">
                  <div class="modal-content">
                    <div class="modal-header">
                      <h4 class="modal-title">Aviso</h4>
                    </div>

                    <div class="modal-body">
                      <p>Tem certeza que deseja apagar este monitoramento?</p>
                    </div>

                    <div class="modal-footer">
                      <form action="{{ route('riscos.deleteMonitoramento', $monitoramento->id) }}"
                        method="POST">
                        @method('DELETE')
                        @csrf
                        <button type="submit" class="btn btn-danger" data-bs-dismiss="modal">Apagar</button>
                      </form>
                      <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>
                    </div>
                  </div>
                </div>
              </div>
            @endforeach
          </tbody>
        </table>

        <div class="text-center mb-4">
          @if (Auth::user()->unidade->unidadeTipoFK == 1)
          <a href="{{ route('riscos.edit', $risco->id) }}" class="edit-btn">Editar</a>
          <a href="{{ route('riscos.edit-monitoramentos', ['id' => $risco->id]) }}" class="btn-add">Adicionar Monitoramentos</a>
          @endif
          <a href="{{ route('riscos.respostas', ['id' => $risco->id]) }}" class="reply-btn">Ver Respostas</a>
        </div>
      </div>
    </div>
  </div>

  <footer class="rodape">
		<div class="riskLevelDiv">
			<span>Nível de Risco (Avaliação):</span>
			<span class="mode riskLevel1">Baixo</span>
			<span class="mode riskLevel2">Médio</span>
			<span class="mode riskLevel3">Alto</span>
		</div>
	</footer>

  <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js"></script>

</body>

</html>
@endsection
