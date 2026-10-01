@extends('layouts.app')
@section('title', 'Eixo IV - Implementação de Controles Internos')
@section('content')

<link rel="stylesheet" href="{{ asset('css/main.css') }}">
<link rel="stylesheet" href="{{ asset('css/buttons.css') }}">
<link rel="stylesheet" href="{{ asset('css/eixos-new.css') }}">

<x-alert-toast />

<main class="container my-4 pt-4 eixo-container">
  <section class="eixo-description">
    <div class="eixo-description-content">

      <div class="eixo-label">
        Eixo IV
      </div>

      <h1 class="eixo-title">
        Implementação de Controles Internos
      </h1>

      <p class="eixo-text">
        O controle interno visa assegurar o cumprimento das diretrizes e o fortalecimento da cultura de compliance e
        integridade, além de agregar valor e contribuir para a melhoria das operações da FAPEAM, auxiliando no alcance
        dos objetivos e metas institucionais, a partir da abordagem sistemática para avaliar e melhorar a eficácia dos
        processos de governança e gerenciamento de riscos.
      </p>
    </div>
  </section>

  @if(auth()->user()->unidade->unidadeTipoFK == 1 || auth()->user()->unidade->unidadeTipoFK == 3 || auth()->user()->unidade->unidadeTipoFK == 4)
    <section class="eixo-functions">
      <div class="function-section">
        <div class="function-info">
          <div class="function-icon">
            <i class="bi bi-shield-check"></i>
          </div>

          <div>
            <h2 class="function-title">
              Análise do Risco
            </h2>
          </div>
        </div>

        <div class="function-actions">
          <a href="{{ route('riscos.index') }}"
            class="highlighted-btn-sm highlight-blue text-decoration-none">

            <i class="bi bi-box-arrow-in-up-right"></i>
            Acessar
          </a>
        </div>
      </div>

      <div class="function-section">
        <div class="function-info">
          <div class="function-icon">
            <i class="bi bi-clipboard2-check"></i>
          </div>

          <div>
            <h2 class="function-title">
              Planejamento e execução
            </h2>
          </div>
        </div>

        <div class="function-actions">
          <form action="{{ route('atividades.index') }}"
            method="POST"
            class="eixo-form">

            @csrf

            <input type="hidden" name="eixo_id" value="4">
            <button type="submit" class="highlighted-btn-sm highlight-blue">
              <i class="bi bi-file-text"></i>
              Atividades
            </button>
          </form>

          <a href="{{ route('atividades.plano-acao', ['eixo_id' => $eixo_id ?? 4]) }}"
            class="highlighted-btn-sm highlight-blue text-decoration-none">
            <i class="bi bi-list-check"></i>
            Plano de Ação
          </a>
        </div>
      </div>

      <div class="function-section">
        <div class="function-info">
          <div class="function-icon">
            <i class="bi bi-bar-chart-line"></i>
          </div>

          <div>
            <h2 class="function-title">
              Monitoramento
            </h2>
          </div>
        </div>

        <div class="function-actions">
          <form action="{{ route('indicadores.index') }}"
            method="POST"
            class="eixo-form">

            @csrf

            <input type="hidden" name="eixo_id" value="4">
            <button type="submit" class="highlighted-btn-sm highlight-grey">
              <i class="bi bi-reception-4"></i>
              Indicadores
            </button>
          </form>
        </div>
      </div>

      <div class="function-section">
        <div class="function-info">
          <div class="function-icon">
            <i class="bi bi-folder2-open"></i>
          </div>

          <div>
            <h2 class="function-title">
              Documentos
            </h2>
          </div>
        </div>

        <div class="function-actions">
          <button
            class="highlighted-btn-sm highlight-grey dropdown-toggle"
            type="button"
            id="dropdownRelatorios"
            data-bs-toggle="dropdown"
            aria-expanded="false">

            <i class="bi bi-file-earmark-text"></i>
            Relatórios
          </button>

          <ul class="dropdown-menu dropdown-menu-dark"
            aria-labelledby="dropdownRelatorios">
            <li>
              <a href="{{ route('relatorios.eixos', ['id' => 4]) }}"
                class="dropdown-item fs-12">
                <i class="bi bi-download me-2"></i>
                Baixar relatório gerado pelo sistema
              </a>
            </li>

            <li>
              <hr class="dropdown-divider">
            </li>

            <li>
              <button
                type="button"
                class="dropdown-item fs-12"
                data-bs-toggle="modal"
                data-bs-target="#modalUploadAnexo">
                <i class="bi bi-upload me-2"></i>
                Enviar relatório externo
              </button>
            </li>

            <li>
              <a href="{{ route('anexo', $eixo_id ?? 4) }}"
                class="dropdown-item fs-12">
                <i class="bi bi-download me-2"></i>
                Baixar relatório externo
              </a>
            </li>
          </ul>

          <button
            type="button"
            class="highlighted-btn-sm highlight-grey"
            data-bs-toggle="modal"
            data-bs-target="#modalUploadAnexo">
            <i class="bi bi-paperclip"></i>
            Enviar Anexo
          </button>
        </div>
      </div>
    </section>
  @endif
</main>

<div class="modal fade"
  id="modalUploadAnexo"
  tabindex="-1"
  aria-labelledby="modalUploadAnexoLabel"
  aria-hidden="true">

  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modalUploadAnexoLabel">
          <i class="bi bi-upload text-primary me-2"></i>
          Enviar Anexo do Eixo
        </h5>

        <button type="button"
          class="btn-close"
          data-bs-dismiss="modal"
          aria-label="Close">
        </button>
      </div>

      <form action="{{ route('anexo.upload', $eixo_id ?? 4) }}"
        method="POST"
        enctype="multipart/form-data">
        @csrf
        <div class="modal-body text-start">
          <p class="text-muted text13">
            Selecione o arquivo de anexo para este eixo.
            Se já existir um arquivo, ele será substituído
            automaticamente.
          </p>

          <div class="mb-3">
            <label for="anexo_path" class="fw-bold mb-2">
              Arquivo:
            </label>

            <input type="file"
              name="anexo_path"
              id="anexo_path"
              class="form-control input-enabled border-grey"
              required>
          </div>
        </div>

        <div class="modal-footer">
          <button type="button"
            class="footer-btn footer-secondary"
            data-bs-dismiss="modal">
            <i class="bi bi-x-lg me-1"></i>
            Cancelar
          </button>

          <button type="submit"
            class="footer-btn footer-primary bg-primary text-white border-0">
            <i class="bi bi-cloud-upload me-1"></i>
            Enviar
          </button>
        </div>
      </form>
    </div>
  </div>
</div>
@endsection