@extends('layouts.app')
@section('content')
@section('title') {{ 'Eixos' }} @endsection

<link rel="stylesheet" href="{{ asset('css/eixos.css') }}">

<div class="container d-flex flex-column justify-content-center align-items-center">
  <img src="{{ asset('img/login/logo_ajuste1.png') }}"
    class="logo-hero logo-clara mt-5 mb-4"
    alt="Logo Integra">

  <img src="{{ asset('img/logo-bw.png') }}"
    class="logo-hero logo-escura mt-5 mb-4"
    alt="Logo Integra">
  <span class="h3" style="color: #34415e;">Eixos do Programa de Integridade</span>
</div>

<div class="form-wrapper pt-2">
  <div class="custom__form_create">
    <div class="row g-3 justify-content-center">

      <!-- EIXO I -->
      <div class="col-12 col-sm-6 col-md-6 col-lg-4 col-xl-3 d-flex">
        <div class="eixo-card mx-auto">
          <div class="eixo-card__header">
            <img src="{{ asset('img/eixos/handshake.png') }}"
              class="eixo-card__icon"
              alt="">
            <span>EIXO I</span>
          </div>

          <div class="eixo-card__body">
            <div class="eixo-card__title">
              Comprometimento e Apoio da Alta Direção
            </div>
          </div>

          <div class="eixo-card__overlay">
            <a href="{{ route('apresentacoes.eixo1') }}" class="btn btn-light">
              <i class="bi bi-box-arrow-up-right me-1"></i>
              Abrir
            </a>
          </div>

          <div class="eixo-card__footer"></div>
        </div>
      </div>

      <!-- EIXO II -->
      <div class="col-12 col-sm-6 col-md-6 col-lg-4 col-xl-3 d-flex">
        <div class="eixo-card mx-auto">
          <div class="eixo-card__header">
            <img src="{{ asset('img/eixos/notebook.png') }}"
              class="eixo-card__icon"
              alt="">
            <span>EIXO II</span>
          </div>

          <div class="eixo-card__body">
            <div class="eixo-card__title">
              Institucionalização do Código de Conduta
            </div>
          </div>

          <div class="eixo-card__overlay">
            <a href="{{ route('apresentacoes.eixo2') }}" class="btn btn-light">
              <i class="bi bi-box-arrow-up-right me-1"></i>
              Abrir
            </a>
          </div>

          <div class="eixo-card__footer"></div>
        </div>
      </div>

      <!-- EIXO III -->
      <div class="col-12 col-sm-6 col-md-6 col-lg-4 col-xl-3 d-flex">
        <div class="eixo-card mx-auto">
          <div class="eixo-card__header">
            <img src="{{ asset('img/eixos/alert.png') }}"
              class="eixo-card__icon"
              alt="">
            <span>EIXO III</span>
          </div>

          <div class="eixo-card__body">
            <div class="eixo-card__title">
              Avaliação de Riscos
            </div>
          </div>

          <div class="eixo-card__overlay">
            <a href="{{ route('apresentacoes.eixo3') }}" class="btn btn-light">
              <i class="bi bi-box-arrow-up-right me-1"></i>
              Abrir
            </a>
          </div>

          <div class="eixo-card__footer"></div>
        </div>
      </div>

      <!-- EIXO IV -->
      <div class="col-12 col-sm-6 col-md-6 col-lg-4 col-xl-3 d-flex">
        <div class="eixo-card mx-auto">
          <div class="eixo-card__header">
            <img src="{{ asset('img/eixos/equalizer.png') }}"
              class="eixo-card__icon"
              alt="">
            <span>EIXO IV</span>
          </div>

          <div class="eixo-card__body">
            <div class="eixo-card__title">
              Implementação dos Controles Internos
            </div>
          </div>

          <div class="eixo-card__overlay">
            <a href="{{ route('apresentacoes.eixo4') }}" class="btn btn-light">
              <i class="bi bi-box-arrow-up-right me-1"></i>
              Abrir
            </a>
          </div>

          <div class="eixo-card__footer"></div>
        </div>
      </div>

      <!-- EIXO V -->
      <div class="col-12 col-sm-6 col-md-6 col-lg-4 col-xl-3 d-flex">
        <div class="eixo-card mx-auto">
          <div class="eixo-card__header">
            <img src="{{ asset('img/eixos/training.png') }}"
              class="eixo-card__icon"
              alt="">
            <span>EIXO V</span>
          </div>

          <div class="eixo-card__body">
            <div class="eixo-card__title">
              Comunicação e Treinamentos Periódicos
            </div>
          </div>

          <div class="eixo-card__overlay">
            <a href="{{ route('apresentacoes.eixo5') }}" class="btn btn-light">
              <i class="bi bi-box-arrow-up-right me-1"></i>
              Abrir
            </a>
          </div>

          <div class="eixo-card__footer"></div>
        </div>
      </div>

      <!-- EIXO VI -->
      <div class="col-12 col-sm-6 col-md-6 col-lg-4 col-xl-3 d-flex">
        <div class="eixo-card mx-auto">
          <div class="eixo-card__header">
            <img src="{{ asset('img/eixos/loudspeaker.png') }}"
              class="eixo-card__icon"
              alt="">
            <span>EIXO VI</span>
          </div>

          <div class="eixo-card__body">
            <div class="eixo-card__title">
              Canais de Denúncia
            </div>
          </div>

          <div class="eixo-card__overlay">
            <a href="{{ route('apresentacoes.eixo6') }}" class="btn btn-light">
              <i class="bi bi-box-arrow-up-right me-1"></i>
              Abrir
            </a>
          </div>

          <div class="eixo-card__footer"></div>
        </div>
      </div>

      <!-- EIXO VII -->
      <div class="col-12 col-sm-6 col-md-6 col-lg-4 col-xl-3 d-flex">
        <div class="eixo-card mx-auto">
          <div class="eixo-card__header">
            <img src="{{ asset('img/eixos/search.png') }}"
              class="eixo-card__icon"
              alt="">
            <span>EIXO VII</span>
          </div>

          <div class="eixo-card__body">
            <div class="eixo-card__title">
              Investigações Internas
            </div>
          </div>

          <div class="eixo-card__overlay">
            <a href="{{ route('apresentacoes.eixo7') }}" class="btn btn-light">
              <i class="bi bi-box-arrow-up-right me-1"></i>
              Abrir
            </a>
          </div>

          <div class="eixo-card__footer"></div>
        </div>
      </div>

      <!-- EIXO VIII -->
      <div class="col-12 col-sm-6 col-md-6 col-lg-4 col-xl-3 d-flex">
        <div class="eixo-card mx-auto">
          <div class="eixo-card__header">
            <img src="{{ asset('img/eixos/monitoring.png') }}"
              class="eixo-card__icon"
              alt="">
            <span>EIXO VIII</span>
          </div>

          <div class="eixo-card__body">
            <div class="eixo-card__title">
              Monitoramento Contínuo
            </div>
          </div>

          <div class="eixo-card__overlay">
            <a href="{{ route('apresentacoes.eixo8') }}" class="btn btn-light">
              <i class="bi bi-box-arrow-up-right me-1"></i>
              Abrir
            </a>
          </div>

          <div class="eixo-card__footer"></div>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection
