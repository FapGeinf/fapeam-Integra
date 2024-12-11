@extends('layouts.app')
@section('content')

@section('title') {{ 'Eixos' }} @endsection

<head>
  <link rel="stylesheet" href="{{ asset('css/eixos.css') }}">
</head>

<div class="form-wrapper pt-5">
  <div class="form_create1 border">
    <div class="titleDP text-center">
      <span>
        Eixos do Programa de Integridade
      </span>
    </div>
  </div>
</div>

<div class="form-wrapper pt-4">
  <div class="form_create border">
    <div class="row">

      <!-- EIXO I -->
      <div class="col-md-3 mb-4" >
        <a class="card shadow-lg rounded-lg overflow-hidden" href="{{ route('apresentacoes.eixo1') }}">
          <h5 class="card-title text-white bg__card_pattern p-3 d-flex align-items-center mb-0">
            <i class="bi bi-check-circle me-2"></i> EIXO I
          </h5>
          <div class="card-body p-4">
            <div class="mb-3 d-flex align-items-start">
              <i class="bi bi-bookmark-fill icon__color me-2 fs-5"></i>
              <p class="card-text text-muted fs-6 mb-0">COMPROMETIMENTO E APOIO DA ALTA DIREÇÃO</p>
            </div>
            <hr class="mt-2 mb-3 border-primary">
          </div>
        </a>
      </div>

      <!-- EIXO II -->
      <div class="col-md-3 mb-4">
        <a class="card shadow-lg rounded-lg overflow-hidden" href="{{ route('apresentacoes.eixo2') }}">
          <h5 class="card-title text-white bg__card_pattern p-3 d-flex align-items-center mb-0">
            <i class="bi bi-check-circle me-2"></i> EIXO II
          </h5>
          <div class="card-body p-4">
            <div class="mb-3 d-flex align-items-start">
              <i class="bi bi-bookmark-fill icon__color me-2 fs-5"></i>
              <p class="card-text text-muted fs-6 mb-0">INSTITUCIONALIZAÇÃO DO CÓDIGO DE CONDUTA</p>
            </div>
            <hr class="mt-2 mb-3 border-primary">
          </div>
        </a>
      </div>

      <!-- EIXO III -->
      <div class="col-md-3 mb-4" >
        <a class="card shadow-lg rounded-lg overflow-hidden" href="{{ route('apresentacoes.eixo3') }}">
          <h5 class="card-title text-white bg__card_pattern p-3 d-flex align-items-center mb-0">
            <i class="bi bi-check-circle me-2"></i> EIXO III
          </h5>
          <div class="card-body p-4">
            <div class="mb-3 d-flex align-items-start">
              <i class="bi bi-bookmark-fill icon__color me-2 fs-5"></i>
              <p class="card-text text-muted fs-6 mb-0">AVALIAÇÃO DE RISCOS</p>
            </div>
            <hr class="mt-2 mb-3 border-primary">
          </div>
        </a>
      </div>

      <!-- EIXO IV -->
      <div class="col-md-3 mb-4" >
        <a class="card shadow-lg rounded-lg overflow-hidden" href="{{ route('apresentacoes.eixo4') }}">
          <h5 class="card-title text-white bg__card_pattern p-3 d-flex align-items-center mb-0">
            <i class="bi bi-check-circle me-2"></i> EIXO IV
          </h5>
          <div class="card-body p-4">
            <div class="mb-3 d-flex align-items-start">
              <i class="bi bi-bookmark-fill icon__color me-2 fs-5"></i>
              <p class="card-text text-muted fs-6 mb-0">IMPLEMENTAÇÃO DOS CONTROLES INTERNOS</p>
            </div>
            <hr class="mt-2 mb-3 border-primary">
          </div>
        </a>
      </div>

      <!-- EIXO V -->
      <div class="col-md-3 mb-4" >
        <a class="card shadow-lg rounded-lg overflow-hidden" href="{{ route('apresentacoes.eixo5') }}">
          <h5 class="card-title text-white bg__card_pattern p-3 d-flex align-items-center mb-0">
            <i class="bi bi-check-circle me-2"></i> EIXO V
          </h5>
          <div class="card-body p-4">
            <div class="mb-3 d-flex align-items-start">
              <i class="bi bi-bookmark-fill icon__color me-2 fs-5"></i>
              <p class="card-text text-muted fs-6 mb-0">COMUNICAÇÃO E TREINAMENTOS PERIÓDICOS</p>
            </div>
            <hr class="mt-2 mb-3 border-primary">
          </div>
        </a>
      </div>

      <!-- EIXO VI -->
      <div class="col-md-3 mb-4">
        <a class="card shadow-lg rounded-lg overflow-hidden" href="{{ route('apresentacoes.eixo6') }}">
          <h5 class="card-title text-white bg__card_pattern p-3 d-flex align-items-center mb-0">
            <i class="bi bi-check-circle me-2"></i> EIXO VI
          </h5>
          <div class="card-body p-4">
            <div class="mb-3 d-flex align-items-start">
              <i class="bi bi-bookmark-fill icon__color me-2 fs-5"></i>
              <p class="card-text text-muted fs-6 mb-0">CANAIS DE DENÚNCIA</p>
            </div>
            <hr class="mt-2 mb-3 border-primary">
          </div>
        </a>
      </div>

      <!-- EIXO VII -->
      <div class="col-md-3 mb-4">
        <a class="card shadow-lg rounded-lg overflow-hidden" href="{{ route('apresentacoes.eixo7') }}">
          <h5 class="card-title text-white bg__card_pattern p-3 d-flex align-items-center mb-0">
            <i class="bi bi-check-circle me-2"></i> EIXO VII
          </h5>
          <div class="card-body p-4">
            <div class="mb-3 d-flex align-items-start">
              <i class="bi bi-bookmark-fill icon__color me-2 fs-5"></i>
              <p class="card-text text-muted fs-6 mb-0">INVESTIGAÇÕES INTERNAS</p>
            </div>
            <hr class="mt-2 mb-3 border-primary">
          </div>
        </a>
      </div>

      <!-- EIXO VIII -->
      <div class="col-md-3 mb-4">
        <a class="card shadow-lg rounded-lg overflow-hidden" href="{{ route('apresentacoes.eixo8') }}">
          <h5 class="card-title text-white bg__card_pattern p-3 d-flex align-items-center mb-0">
            <i class="bi bi-check-circle me-2"></i> EIXO VIII
          </h5>
          <div class="card-body p-4">
            <div class="mb-3 d-flex align-items-start">
              <i class="bi bi-bookmark-fill icon__color me-2 fs-5"></i>
              <p class="card-text text-muted fs-6 mb-0">MONITORAMENTO CONTÍNUO</p>
            </div>
            <hr class="mt-2 mb-3 border-primary">
          </div>
        </a>
      </div>

    </>
  </div>
</div>
@endsection
