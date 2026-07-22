@extends('layouts.app')
@section('content')
@section('title') {{ 'Eixos' }} @endsection

<link rel="stylesheet" href="{{ asset('css/eixos.css') }}">

<div class="container d-flex flex-column justify-content-center align-items-center">
  <img src="{{ asset('img/login/logo_ajuste1.png') }}"  class="logo-hero mt-5 mb-4" alt="Logo Integra">
  <span class="h3" style="color: #34415e;">Eixos do Programa de Integridade</span>
</div>

<div class="form-wrapper pt-2">
  <div class="custom__form_create">
    <div class="row g-3 justify-content-center">

      <!-- EIXO I -->
      <div class="col-12 col-sm-6 col-md-6 col-lg-4 col-xl-3 d-flex">
        <div class="card border overflow-hidden h-100 w-100 mx-auto" style="max-width: 360px;">
          <h5 class="bg__card_pattern bg__card_pattern_footer p-3 text-light text-center mb-0" style="height: 50px;">
            <img class="eixo__img card-hover-img" src="{{ asset('img/eixos/handshake.png') }}" alt="Minha Imagem">
            <span class="card-hover-title">EIXO I</span>
          </h5>

          <div class="card-body card-fofinho p-4">
            <div class="my-auto title-teste border rounded text-center fw-semibold subtitle d-flex justify-content-center align-items-center p-1">
              Comprometimento e Apoio da Alta Direção
            </div>
          </div>

          <div class="card-hover">
            <a href="{{ route('apresentacoes.eixo1') }}">
              <button class="btn btn-light">
                <i class="bi bi-box-arrow-up-right me-1"></i>
                Abrir
              </button>
            </a>
          </div>

          <div class="card-eixos-footer">
            <h5 class="bg__card_pattern w-50 rounded mx-auto p-1 mt-2 mb-0"></h5>
          </div>
        </div>
      </div>

      <!-- EIXO II -->
      <div class="col-12 col-sm-6 col-md-6 col-lg-4 col-xl-3 d-flex">
        <div class="card border overflow-hidden h-100 w-100 mx-auto" style="max-width: 360px;">
          <h5 class="bg__card_pattern bg__card_pattern_footer p-3 text-light text-center mb-0" style="height: 50px;">
            <img class="eixo__img2 card-hover-img" src="{{ asset('img/eixos/notebook.png') }}" alt="Minha Imagem">
            <span class="card-hover-title">EIXO II</span>
          </h5>

          <div class="card-body card-fofinho p-4">
            <div class="my-auto title-teste border rounded text-center fw-semibold subtitle d-flex justify-content-center align-items-center p-1">
              Institucionalização do Código de Conduta
            </div>
          </div>

          <div class="card-hover">
            <a href="{{ route('apresentacoes.eixo2') }}">
              <button class="btn btn-light">
                <i class="bi bi-box-arrow-up-right me-1"></i>
                Abrir
              </button>
            </a>
          </div>

          <div class="card-eixos-footer">
            <h5 class="bg__card_pattern w-50 rounded mx-auto p-1 mt-2 mb-0"></h5>
          </div>
        </div>
      </div>

      <!-- EIXO III -->
      <div class="col-12 col-sm-6 col-md-6 col-lg-4 col-xl-3 d-flex">
        <div class="card border overflow-hidden h-100 w-100 mx-auto" style="max-width: 360px;">
          <h5 class="bg__card_pattern bg__card_pattern_footer p-3 text-light text-center mb-0" style="height: 50px;">
            <img class="eixo__img3 card-hover-title" src="{{ asset('img/eixos/alert.png') }}" alt="Minha Imagem">
            <span class="card-hover-title">EIXO III</span>
          </h5>

          <div class="card-body card-fofinho p-4">
            <div class="my-auto title-teste border rounded text-center fw-semibold subtitle d-flex justify-content-center align-items-center p-1">
              Avaliação de Riscos
            </div>
          </div>

          <div class="card-hover">
            <a href="{{ route('apresentacoes.eixo3') }}">
              <button class="btn btn-light">
                <i class="bi bi-box-arrow-up-right me-1"></i>
                Abrir
              </button>
            </a>
          </div>

          <div class="card-eixos-footer">
            <h5 class="bg__card_pattern w-50 rounded mx-auto p-1 mt-2 mb-0"></h5>
          </div>
        </div>
      </div>

      <!-- EIXO IV -->
      <div class="col-12 col-sm-6 col-md-6 col-lg-4 col-xl-3 d-flex">
        <div class="card border overflow-hidden h-100 w-100 mx-auto" style="max-width: 360px;">
          <h5 class="bg__card_pattern bg__card_pattern_footer p-3 text-light text-center mb-0" style="height: 50px;">
            <img class="eixo__img3 card-hover-img" src="{{ asset('img/eixos/equalizer.png') }}" alt="Minha Imagem">
            <span class="card-hover-title">EIXO IV</span>
          </h5>

          <div class="card-body card-fofinho p-4">
            <div class="my-auto title-teste border rounded text-center fw-semibold subtitle d-flex justify-content-center align-items-center p-1">
              Implementação dos Controles Internos
            </div>
          </div>

          <div class="card-hover">
            <a href="{{ route('apresentacoes.eixo4') }}">
              <button class="btn btn-light">
                <i class="bi bi-box-arrow-up-right me-1"></i>
                Abrir
              </button>
            </a>
          </div>

          <div class="card-eixos-footer">
            <h5 class="bg__card_pattern w-50 rounded mx-auto p-1 mt-2 mb-0"></h5>
          </div>
        </div>
      </div>

      <!-- EIXO V -->
      <div class="col-12 col-sm-6 col-md-6 col-lg-4 col-xl-3 d-flex">
        <div class="card border overflow-hidden h-100 w-100 mx-auto" style="max-width: 360px;">
          <h5 class="bg__card_pattern bg__card_pattern_footer p-3 text-light text-center mb-0" style="height: 50px;">
            <img class="eixo__img3 card-hover-img" src="{{ asset('img/eixos/training.png') }}" alt="Minha Imagem">
            <span class="card-hover-title">EIXO V</span>
          </h5>

          <div class="card-body card-fofinho p-4">
            <div class="my-auto title-teste border rounded text-center fw-semibold subtitle d-flex justify-content-center align-items-center p-1">
              Comunicação e Treinamentos Periódicos
            </div>
          </div>

          <div class="card-hover">
            <a href="{{ route('apresentacoes.eixo5') }}">
              <button class="btn btn-light">
                <i class="bi bi-box-arrow-up-right me-1"></i>
                Abrir
              </button>
            </a>
          </div>

          <div class="card-eixos-footer">
            <h5 class="bg__card_pattern w-50 rounded mx-auto p-1 mt-2 mb-0"></h5>
          </div>
        </div>
      </div>

      <!-- EIXO VI -->
      <div class="col-12 col-sm-6 col-md-6 col-lg-4 col-xl-3 d-flex">
        <div class="card border overflow-hidden h-100 w-100 mx-auto" style="max-width: 360px;">
          <h5 class="bg__card_pattern bg__card_pattern_footer p-3 text-light text-center mb-0" style="height: 50px;">
            <img class="eixo__img3 card-hover-img" src="{{ asset('img/eixos/loudspeaker.png') }}" alt="Minha Imagem">
            <span class="card-hover-title">EIXO VI</span>
          </h5>

          <div class="card-body card-fofinho p-4">
            <div class="my-auto title-teste border rounded text-center fw-semibold subtitle d-flex justify-content-center align-items-center p-1">
              Canais de Denúncia
            </div>
          </div>

          <div class="card-hover">
            <a href="{{ route('apresentacoes.eixo6') }}">
              <button class="btn btn-light">
                <i class="bi bi-box-arrow-up-right me-1"></i>
                Abrir
              </button>
            </a>
          </div>

          <div class="card-eixos-footer">
            <h5 class="bg__card_pattern w-50 rounded mx-auto p-1 mt-2 mb-0"></h5>
          </div>
        </div>
      </div>

      <!-- EIXO VII -->
      <div class="col-12 col-sm-6 col-md-6 col-lg-4 col-xl-3 d-flex">
        <div class="card border overflow-hidden h-100 w-100 mx-auto" style="max-width: 360px;">
          <h5 class="bg__card_pattern bg__card_pattern_footer p-3 text-light text-center mb-0" style="height: 50px;">
            <img class="eixo__img3 card-hover-img" src="{{ asset('img/eixos/search.png') }}" alt="Minha Imagem">
            <span class="card-hover-title">EIXO VII</span>
          </h5>

          <div class="card-body card-fofinho p-4">
            <div class="my-auto title-teste border rounded text-center fw-semibold subtitle d-flex justify-content-center align-items-center p-1">
              Investigações Internas
            </div>
          </div>

          <div class="card-hover">
            <a href="{{ route('apresentacoes.eixo7') }}">
              <button class="btn btn-light">
                <i class="bi bi-box-arrow-up-right me-1"></i>
                Abrir
              </button>
            </a>
          </div>

          <div class="card-eixos-footer">
            <h5 class="bg__card_pattern w-50 rounded mx-auto p-1 mt-2 mb-0"></h5>
          </div>
        </div>
      </div>

      <!-- EIXO VIII -->
      <div class="col-12 col-sm-6 col-md-6 col-lg-4 col-xl-3 d-flex">
        <div class="card border overflow-hidden h-100 w-100 mx-auto" style="max-width: 360px;">
          <h5 class="bg__card_pattern bg__card_pattern_footer p-3 text-light text-center mb-0" style="height: 50px;">
            <img class="eixo__img3 card-hover-img" src="{{ asset('img/eixos/monitoring.png') }}" alt="Minha Imagem">
            <span class="card-hover-title">EIXO VIII</span>
          </h5>

          <div class="card-body card-fofinho p-4">
            <div class="my-auto title-teste border rounded text-center fw-semibold subtitle d-flex justify-content-center align-items-center p-1">
              Monitoramento Contínuo
            </div>
          </div>

          <div class="card-hover">
            <a href="{{ route('apresentacoes.eixo8') }}">
              <button class="btn btn-light">
                <i class="bi bi-box-arrow-up-right me-1"></i>
                Abrir
              </button>
            </a>
          </div>

          <div class="card-eixos-footer">
            <h5 class="bg__card_pattern w-50 rounded mx-auto p-1 mt-2 mb-0"></h5>
          </div>
        </div>
      </div>

    </div>
  </div>
</div>
@endsection
