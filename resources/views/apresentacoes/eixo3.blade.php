@extends('layouts.app')
@section('title') {{ 'Eixo III - Avaliação de Riscos' }} @endsection
@section('content')

  <link rel="stylesheet" href="{{asset('css/main.css')}}">
  <link rel="stylesheet" href="{{asset('css/buttons.css')}}">

  <main class="container my-4 pt-5" style="max-width: 800px;">
    
    {{-- ALERTAS DE SESSÃO (SUCESSO / ERRO) --}}
    @if(session('success'))
      <div class="alert alert-success alert-dismissible fade show" role="alert">
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
      </div>
    @endif

    @if(session('error'))
      <div class="alert alert-danger alert-dismissible fade show" role="alert">
        {{ session('error') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
      </div>
    @endif

    <h1 class="h5 mb-3 text-center">Eixo III - Avaliação de Riscos</h1>

    <div class="card box-shadow" style="margin-bottom: 15px;">
      <div class="card-body p-2">
        <div class="mb-0">
          <p class="lh-lg">
            A avaliação de riscos é um dos eixos do Programa de Integridade da FAPEAM. O diagnóstico e tratamento desses
            riscos é realizado com base nas recomendações da Controladoria Geral da União <span>(CGU e da ISO
              31.000/2009)</span>.
          </p>

          <p class="lh-lg">
            Ações ou omissões que possam favorecer a ocorrência de fraudes ou atos de corrupção, podendo se configurar em
            causa, evento ou consequência de outros riscos, tais como financeiros, operacionais ou de imagem são riscos à
            integridade <span>(Portaria CGU nº 1089/2018)</span>.
          </p>
        </div>
      </div>
    </div>
  </main>

  @if(auth()->user()->unidade->unidadeTipoFK == 1 || auth()->user()->unidade->unidadeTipoFK == 3 || auth()->user()->unidade->unidadeTipoFK == 4)
    {{-- Container Flex para alinhar todos os botões na mesma linha perfeitamente --}}
    <div class="d-flex justify-content-center gap-2 flex-wrap mb-4">
      <a href="{{ route('relatorios.eixos', ['id' => 3]) }}" class="highlighted-btn-sm highlight-blue text-decoration-none">
        <i class="bi bi-list-columns-reverse"></i>
        Relatório
      </a>

      <form action="{{ route('atividades.index') }}" method="POST" class="d-inline">
        @csrf
        <input type="hidden" name="eixo_id" value="3">
        <button type="submit" class="highlighted-btn-sm highlight-blue">
          <i class="bi bi-file-text"></i>
           Atividades
        </button>
      </form>

      <a href="{{ route('atividades.plano-acao', ['eixo_id' => $eixo_id ?? 3]) }}"
        class="highlighted-btn-sm highlight-blue text-decoration-none d-inline-flex align-items-center gap-1">
        <i class="bi bi-list-check"></i>
        Plano de Ação
      </a>

      <form action="{{ route('indicadores.index') }}" method="POST" class="d-inline">
        @csrf
        <input type="hidden" name="eixo_id" value="3">
        <button type="submit" class="highlighted-btn-sm highlight-blue">
          <i class="bi bi-reception-4"></i>
          Indicadores
        </button>
      </form>

      <a href="{{ route('avaliacao') }}" class="highlighted-btn-sm highlight-blue text-decoration-none">
        <i class="bi bi-download"></i>
        Diagnóstico de Riscos
      </a>

      <a href="{{ route('riscos.analise') }}" class="highlighted-btn-sm highlight-blue text-decoration-none d-inline-flex align-items-center gap-1">
        <i class="bi bi-box-arrow-in-up-right"></i>
        Análise do Risco
      </a>

      <button type="button" class="highlighted-btn-sm highlight-blue" data-bs-toggle="modal" data-bs-target="#modalUploadAnexo">
        <i class="bi bi-upload"></i> Enviar Anexo
      </button>

      <a href="{{ route('anexo', $eixo_id ?? 3) }}" class="highlighted-btn-sm highlight-blue text-decoration-none">
        <i class="bi bi-download"></i> Baixar Anexo do Eixo
      </a>
    </div>

    {{-- MODAL DE UPLOAD DE ANEXO --}}
    <div class="modal fade" id="modalUploadAnexo" tabindex="-1" aria-labelledby="modalUploadAnexoLabel" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="modalUploadAnexoLabel">
              <i class="bi bi-upload text-primary me-2"></i>Enviar Anexo do Eixo
            </h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>

          <form action="{{ route('anexo.upload', $eixo_id ?? 3) }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="modal-body text-start">
              <p class="text-muted text13">Selecione o arquivo de anexo para este eixo. Se já existir um arquivo, ele será substituído automaticamente.</p>

              <div class="mb-3">
                <label for="anexo_path" class="fw-bold mb-2">Arquivo:</label>
                <input type="file" name="anexo_path" id="anexo_path" class="form-control border-grey" required>
              </div>
            </div>

            <div class="modal-footer">
              <button type="button" class="footer-btn footer-secondary" data-bs-dismiss="modal">Cancelar</button>
              <button type="submit" class="footer-btn footer-primary bg-primary text-white border-0">
                <i class="bi bi-cloud-upload me-1"></i> Enviar
              </button>
            </div>
          </form>
        </div>
      </div>
    </div>
  @endif

@endsection