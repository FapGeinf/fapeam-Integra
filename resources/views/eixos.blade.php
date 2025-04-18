@extends('layouts.app')
@section('content')

@section('title') {{ 'Eixos' }} @endsection

<head>
  <link rel="stylesheet" href="{{ asset('css/eixos.css') }}">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
</head>

<div class="form-wrapper pt-5">
  <div class="form_create1">
    <div class="text-center">
      <span class="custom__span-title fw-bold">
        EIXOS DO PROGRAMA DE INTEGRIDADE
      </span>
    </div>
  </div>
</div>

<div class="form-wrapper pt-4">
  <div class="custom__form_create">
    <div class="row">

      <!-- EIXO I -->
      <div class="col-xxl-3 col-xl-4 col-lg-4 col-md-6 col-sm-12 mb-4">
        <div class="card border overflow-hidden">
          <h5 class="bg__card_pattern bg__card_pattern_footer p-3 text-light text-center mb-0" style="height: 70px;">
            <img class="eixo__img card-hover-img" src="{{ asset('img/eixos/handshake.png') }}" alt="Minha Imagem">

             <span class="card-hover-title">EIXO I</span>
          </h5>
      
          <div class="card-body card-fofinho p-4">
            <div class="my-auto title-teste form-control text-center fw-bold d-flex">
              COMPROMETIMENTO E APOIO DA ALTA DIREÇÃO
            </div>
          </div>
      
          <div class="card-hover">
            <a href="{{ route('apresentacoes.eixo1') }}">
              
              <button class="btn btn-light">
                <i class="bi bi-arrow-right"></i>
                Abrir
              </button>
            </a>
          </div>
      
          <div>
            <h5 class="bg__card_pattern w-50 rounded mx-auto p-1 mb-0"></h5>
          </div>
        </div>
      </div>

      <!-- EIXO II -->
      <div class="col-xxl-3 col-xl-4 col-lg-4 col-md-6 col-sm-12 mb-4">
        <div class="card border overflow-hidden">
          <h5 class="bg__card_pattern bg__card_pattern_footer p-3 text-light text-center mb-0" style="height: 70px;">
            <img class="eixo__img2 card-hover-img" src="{{ asset('img/eixos/notebook.png') }}" alt="Minha Imagem">
            
            <span class="card-hover-title">EIXO II</span>
          </h5>
      
          <div class="card-body card-fofinho p-4">
            <div class="my-auto title-teste form-control text-center d-flex fw-bold">
              INSTITUCIONALIZAÇÃO DO CÓDIGO DE CONDUTA
            </div>
          </div>
      
          <div class="card-hover">
            <a href="{{ route('apresentacoes.eixo2') }}">
              
              <button class="btn btn-light">
                <i class="bi bi-arrow-right"></i>
                Abrir
              </button>
            </a>
          </div>
      
          <div>
            <h5 class="bg__card_pattern w-50 rounded mx-auto p-1 mb-0"></h5>
          </div>
        </div>
      </div>

      <!-- EIXO III -->
      <div class="col-xxl-3 col-xl-4 col-lg-4 col-md-6 col-sm-12 mb-4">
        <div class="card border overflow-hidden">
          <h5 class="bg__card_pattern bg__card_pattern_footer p-3 text-light text-center mb-0" style="height: 70px;">

            <img class="eixo__img3 card-hover-title" src="{{ asset('img/eixos/alert.png') }}" alt="Minha Imagem">
            <span class="card-hover-title">EIXO III</span>
          </h5>
      
          <div class="card-body card-fofinho p-4">
            <div class="my-auto title-teste form-control text-center d-flex fw-bold">
              AVALIAÇÃO DE RISCOS
            </div>
          </div>
      
          <div class="card-hover">
            <a href="{{ route('apresentacoes.eixo3') }}">
              
              <button class="btn btn-light">
                <i class="bi bi-arrow-right"></i>
                Abrir
              </button>
            </a>
          </div>
      
          <div>
            <h5 class="bg__card_pattern w-50 rounded mx-auto p-1 mb-0"></h5>
          </div>
        </div>
      </div>

      <!-- EIXO IV -->
      <div class="col-xxl-3 col-xl-4 col-lg-4 col-md-6 col-sm-12 mb-4">
        <div class="card border overflow-hidden">
          <h5 class="bg__card_pattern bg__card_pattern_footer p-3 text-light text-center mb-0" style="height: 70px;">
            <img class="eixo__img3 card-hover-img" src="{{ asset('img/eixos/equalizer.png') }}" alt="Minha Imagem">

            <span class="card-hover-title">EIXO IV</span>
          </h5>
      
          <div class="card-body card-fofinho p-4">
            <div class="my-auto title-teste form-control text-center d-flex fw-bold">
              IMPLEMENTAÇÃO DOS CONTROLES INTERNOS
            </div>
          </div>
      
          <div class="card-hover">
            <a href="{{ route('apresentacoes.eixo4') }}">

              <button class="btn btn-light">
                <i class="bi bi-arrow-right"></i>
                Abrir
              </button>
            </a>
          </div>
      
          <div>
            <h5 class="bg__card_pattern w-50 rounded mx-auto p-1 mb-0"></h5>
          </div>
        </div>
      </div>

      <!-- EIXO V -->
      <div class="col-xxl-3 col-xl-4 col-lg-4 col-md-6 col-sm-12 mb-4">
        <div class="card border overflow-hidden">
          <h5 class="bg__card_pattern bg__card_pattern_footer p-3 text-light text-center mb-0" style="height: 70px;">
            <img class="eixo__img3 card-hover-img" src="{{ asset('img/eixos/training.png') }}" alt="Minha Imagem">

            <span class="card-hover-title">EIXO V</span>
          </h5>
      
          <div class="card-body card-fofinho p-4">
            <div class="my-auto title-teste form-control text-center d-flex fw-bold">
              COMUNICAÇÃO E TREINAMENTOS PERIÓDICOS
            </div>
          </div>
      
          <div class="card-hover">
            <a href="{{ route('apresentacoes.eixo5') }}">
              
              <button class="btn btn-light">
                <i class="bi bi-arrow-right"></i>
                Abrir
              </button>
            </a>
          </div>
      
          <div>
            <h5 class="bg__card_pattern w-50 rounded mx-auto p-1 mb-0"></h5>
          </div>
        </div>
      </div>

      <!-- EIXO VI -->
      <div class="col-xxl-3 col-xl-4 col-lg-4 col-md-6 col-sm-12 mb-4">
        <div class="card border overflow-hidden">
          <h5 class="bg__card_pattern bg__card_pattern_footer p-3 text-light text-center mb-0" style="height: 70px;">
            <img class="eixo__img3 card-hover-img" src="{{ asset('img/eixos/loudspeaker.png') }}" alt="Minha Imagem">

            <span class="card-hover-title">EIXO VI</span>
          </h5>
      
          <div class="card-body card-fofinho p-4">
            <div class="my-auto title-teste form-control text-center d-flex fw-bold">
              CANAIS DE DENÚNCIA
            </div>
          </div>
      
          <div class="card-hover">
            <a href="{{ route('apresentacoes.eixo6') }}">
              
              <button class="btn btn-light">
                <i class="bi bi-arrow-right"></i>
                Abrir
              </button>
            </a>
          </div>
      
          <div>
            <h5 class="bg__card_pattern w-50 rounded mx-auto p-1 mb-0"></h5>
          </div>
        </div>
      </div>

      <!-- EIXO VII -->
      <div class="col-xxl-3 col-xl-4 col-lg-4 col-md-6 col-sm-12 mb-4">
        <div class="card border overflow-hidden">
          <h5 class="bg__card_pattern bg__card_pattern_footer p-3 text-light text-center mb-0" style="height: 70px;">
            <img class="eixo__img3 card-hover-img" src="{{ asset('img/eixos/search.png') }}" alt="Minha Imagem">

            <span class="card-hover-title">EIXO VII</span>
          </h5>
      
          <div class="card-body card-fofinho p-4">
            <div class="my-auto title-teste form-control text-center d-flex fw-bold">
              INVESTIGAÇÕES INTERNAS
            </div>
          </div>
      
          <div class="card-hover">
            <a href="{{ route('apresentacoes.eixo7') }}">
              
              <button class="btn btn-light">
                <i class="bi bi-arrow-right"></i>
                Abrir
              </button>
            </a>
          </div>
      
          <div>
            <h5 class="bg__card_pattern w-50 rounded mx-auto p-1 mb-0"></h5>
          </div>
        </div>
      </div>

      <!-- EIXO VIII -->
      <div class="col-xxl-3 col-xl-4 col-lg-4 col-md-6 col-sm-12 mb-4">
        <div class="card border overflow-hidden">
          <h5 class="bg__card_pattern bg__card_pattern_footer p-3 text-light text-center mb-0" style="height: 70px;">
            
            <img class="eixo__img3 card-hover-img" src="{{ asset('img/eixos/monitoring.png') }}" alt="Minha Imagem">

            <span class="card-hover-title">EIXO VIII</span>
          </h5>
      
          <div class="card-body card-fofinho p-4">
            <div class="my-auto form-control title-teste text-center d-flex fw-bold">
              MONITORAMENTO CONTÍNUO
            </div>
          </div>
      
          <div class="card-hover">
            <a href="{{ route('apresentacoes.eixo8') }}">
              
              <button class="btn btn-light">
                <i class="bi bi-arrow-right"></i>
                Abrir
              </button>
            </a>
          </div>
      
          <div>
            <h5 class="bg__card_pattern w-50 rounded mx-auto p-1 mb-0"></h5>
          </div>
        </div>
      </div>
      
    </div>
  </div>
</div>

@endsection
