@extends('layouts.app')
@section('title') {{ 'Detalhes do Risco' }} @endsection
@section('content')

<link rel="stylesheet" href="{{ asset('css/show.css') }}">
<link rel="stylesheet" href="{{ asset('css/buttons.css') }}">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<script src="/ckeditor/ckeditor.js"></script>

<x-alert-toast/>
<x-back-to-top/>
<x-back-to-bottom/>

<div class="container-xxl pt-5">
  <div class="col-12 border box-shadow">
    <h5 class="text-center mb-3">Detalhamento do Risco Inerente - {{ $risco->unidade->unidadeSigla }}</h5>
    <div>
      <table class="table table-bordered mb-4">
        <thead>
          <tr>
            <th style="white-space: nowrap; width: 100px;" class="text-center text-light tBorder">N° Risco</th>
            <th class="text-center text-light tBorder text13">Evento:</th>
            <th class="text-center text-light tBorder text13">Causa:</th>
            <th class="text-center text-light tBorder text13">Consequência:</th>
            <th style="width: 100px;" class="text-center text-light text13">Avaliação:</th>
          </tr>
        </thead>

        <tbody>
          <tr class="text13">
            <td class="text-center pb-1 tBorder">{!! $risco->id !!}</td>
            <td class="pb-1 tBorder">{!! $risco->riscoEvento !!}</td>
            <td class="pb-1 tBorder">{!! $risco->riscoCausa !!}</td>
            <td class="pb-1 tBorder">{!! $risco->riscoConsequencia !!}</td>
            @if ($risco->nivel_de_risco == 1)
              <td class="bg-baixo riscoAvaliacao"><span class="fontBold">Baixo</span></td>
            @elseif ($risco->nivel_de_risco == 2)
              <td class="bg-medio riscoAvaliacao"><span class="fontBold">Médio</span></td>
            @else
              <td class="bg-alto riscoAvaliacao"><span class="fontBold">Alto</span></td>
            @endif
          </tr>
        </tbody>
      </table>
    </div>
  </div>
</div>

<div class="container-xxl">
  <div class="col-12 border box-shadow">
    <h5 class="text-center mb-3">Plano de ação - {{ $risco->unidade->unidadeSigla }}</h5>
    <table class="table table-bordered table-striped mb-4">
      <thead>
        <tr>
          <th class="text-center text-light text13 tBorder">Controle Sugerido:</th>
          <th class="text-center text-light text13">Data:</th>
          <th class="text-center text-light tBorder text13">Situação:</th>
          <th class="text-center text-light text13">Modificado:</th>
          <th class="text-center text-light text13">Providências</th>
          <th class="text-center text-light text13">Ações:</th>
        </tr>
      </thead>

      <tbody>
        @foreach ($risco->monitoramentos as $monitoramento)
          <tr>
            <td class="text13 pb-1 tBorder">{!! $monitoramento->monitoramentoControleSugerido !!}</td>
            <td style="white-space: nowrap;" class="text-center text-13 pb-1">
              {{ \Carbon\Carbon::parse($monitoramento->inicioMonitoramento)->format('d/m/Y') }} -
              {{ $monitoramento->fimMonitoramento ? \Carbon\Carbon::parse($monitoramento->fimMonitoramento)->format('d/m/Y') : 'Contínuo' }}
            </td>

            <td style="white-space: nowrap;" class="text-center text13 pb-1 tBorder">
              {!! $monitoramento->statusMonitoramento !!}
            </td>

            <td class="text13 pb-1 tBorder text-center">
              {!!  \Carbon\Carbon::parse($monitoramento->updated_at)->format('d/m/Y H:i:s') !!}
            </td>

            <td class="text13 pb-1 tBorder text-center">
              @if($monitoramento->monitoramentoRespondido == 0)
                <span class="fw-semibold text-danger">
                  Não recebeu nenhuma providência
                </span>

              @elseif($monitoramento->respostas->every(function ($resposta) {
                return $resposta->homologadaPresidencia && $resposta->homologadoDiretoria; }))
                <span class="fw-semibold text-success">
                  Homologação Completa
                </span>

              @else
                <span class="fw-semibold text-warning">
                  Há providências a serem homologadas
                </span>
              @endif
            </td>

            <td>
              <div class="d-flex gap-2">
                <a href="{{ route('riscos.respostas', ['id' => $monitoramento->id]) }}"
                  class="footer-btn footer-primary">
                  <i class="bi bi-box-arrow-in-up-right"></i>
                </a>

                @if (auth()->user()->unidade->unidadeTipo->id == 1)
                  <a href="{{ route('riscos.editMonitoramento', ['id' => $monitoramento->id]) }}"
                    class="footer-btn footer-warning">
                    <i class="bi bi-pencil"></i>
                  </a>

                  <a href="#" class="footer-btn footer-danger"
                    data-bs-toggle="modal"
                    data-bs-target="#excluirMonitoramento{{ $monitoramento->id }}">
                      <i class="bi bi-trash"></i>
                  </a>
                @endif
              </div>
            </td>
          </tr>

          <div class="modal fade" id="excluirMonitoramento{{ $monitoramento->id }}" tabindex="-1" aria-labelledby="excluirMonitoramentoLabel" aria-hidden="true">
            <div class="modal-dialog">
              <div class="modal-content">
                <div class="modal-header">
                  <h5 class="modal-title" id="excluirMonitoramentoLabel">Confirmação de Exclusão</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <div class="modal-body">
                    <p>Tem certeza que deseja excluir o controle sugerido?</p>
                </div>

                <div class="modal-footer">
                  <button type="button" class="highlighted-btn-sm highlight-grey" data-bs-dismiss="modal">
                    <i class="bi bi-x-lg"></i>
                    Cancelar
                  </button>

                  <form action="{{ route('riscos.deleteMonitoramento', $monitoramento->id) }}"
                    method="POST">
                    @csrf
                    @method('DELETE')
                      <button type="submit" class="highlighted-btn-sm highlight-danger">
                        <i class="bi bi-trash"></i>
                        Excluir Monitoramento
                      </button>
                  </form>
                </div>
              </div>
            </div>
          </div>
        @endforeach
      </tbody>
    </table>

    <div class="text-center mb-4">
      @if (Auth::user()->unidade->unidadeTipoFK == 1)
        <a href="{{ route('riscos.edit', $risco->id) }}" class="warning">Editar Risco</a>
        <a href="{{ route('riscos.edit-monitoramentos', ['id' => $risco->id]) }}" class="primary">
          Adicionar Controles Sugeridos</a>
      @endif
    </div>
  </div>
</div>

<x-back-button/>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"></script>
@endsection