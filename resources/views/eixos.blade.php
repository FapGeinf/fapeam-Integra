@extends('layouts.app')
@section('content')

@section('title') {{ 'Eixos' }} @endsection

<head>
  <link rel="stylesheet" href="{{ asset('css/eixos.css') }}">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
</head>

<div class="form-wrapper pt-5">
  <div class="form_create1 border">
    <div class="text-center">
      <span class="custom__span-title fw-bold">
        EIXOS DO PROGRAMA DE INTEGRIDADE
      </span>
    </div>
  </div>
</div>

<div class="form-wrapper pt-4">
  <div class="custom__form_create border">
    <div class="row">

      <!-- EIXO I -->
      <div class="col-md-3 mb-4">
        <div class="card overflow-hidden">
          <h5 class="bg__card_pattern bg__card_pattern_footer p-3 text-light text-center mb-0" style="height: 70px;">
            EIXO <span style="" class="ms-1">I</span>
          </h5>
      
          <div class="card-body border card-fofinho p-4">
            <div class="my-auto title-teste text-center d-flex">
              COMPROMETIMENTO E APOIO DA ALTA DIREÇÃO
            </div>
          </div>
      
          <div class="card-hover">
            <a href="{{ route('apresentacoes.eixo1') }}">
              <button class="btn btn-light">Abrir</button>
            </a>
          </div>
      
          <div>
            <h5 class="bg__card_pattern p-1 mb-0"></h5>
          </div>
        </div>
      </div>

      <!-- EIXO II -->
      <div class="col-md-3 mb-4">
        <div class="card overflow-hidden">
          <h5 class="bg__card_pattern bg__card_pattern_footer p-3 text-light text-center mb-0" style="height: 70px;">
            EIXO <span style="" class="ms-1">II</span>
          </h5>
      
          <div class="card-body border card-fofinho p-4">
            <div class="my-auto title-teste text-center d-flex">
              INSTITUCIONALIZAÇÃO DO CÓDIGO DE CONDUTA
            </div>
          </div>
      
          <div class="card-hover">
            <a href="{{ route('apresentacoes.eixo2') }}">
              <button class="btn btn-light">Abrir</button>
            </a>
          </div>
      
          <div>
            <h5 class="bg__card_pattern p-1 mb-0"></h5>
          </div>
        </div>
      </div>

      <!-- EIXO III -->
      <div class="col-md-3 mb-4">
        <div class="card overflow-hidden">
          <h5 class="bg__card_pattern bg__card_pattern_footer p-3 text-light text-center mb-0" style="height: 70px;">
            EIXO <span style="" class="ms-1">III</span>
          </h5>
      
          <div class="card-body border card-fofinho p-4">
            <div class="my-auto title-teste text-center d-flex">
              AVALIAÇÃO DE RISCOS
            </div>
          </div>
      
          <div class="card-hover">
            <a href="{{ route('apresentacoes.eixo3') }}">
              <button class="btn btn-light">Abrir</button>
            </a>
          </div>
      
          <div>
            <h5 class="bg__card_pattern p-1 mb-0"></h5>
          </div>
        </div>
      </div>

      <!-- EIXO IV -->
      <div class="col-md-3 mb-4">
        <div class="card overflow-hidden">
          <h5 class="bg__card_pattern bg__card_pattern_footer p-3 text-light text-center mb-0" style="height: 70px;">
            EIXO <span style="" class="ms-1">IV</span>
          </h5>
      
          <div class="card-body border card-fofinho p-4">
            <div class="my-auto title-teste text-center d-flex">
              IMPLEMENTAÇÃO DOS CONTROLES INTERNOS
            </div>
          </div>
      
          <div class="card-hover">
            <a href="{{ route('apresentacoes.eixo4') }}">
              <button class="btn btn-light">Abrir</button>
            </a>
          </div>
      
          <div>
            <h5 class="bg__card_pattern p-1 mb-0"></h5>
          </div>
        </div>
      </div>

      <!-- EIXO V -->
      <div class="col-md-3 mb-4">
        <div class="card overflow-hidden">
          <h5 class="bg__card_pattern bg__card_pattern_footer p-3 text-light text-center mb-0" style="height: 70px;">
            EIXO <span style="" class="ms-1">V</span>
          </h5>
      
          <div class="card-body border card-fofinho p-4">
            <div class="my-auto title-teste text-center d-flex">
              COMUNICAÇÃO E TREINAMENTOS PERIÓDICOS
            </div>
          </div>
      
          <div class="card-hover">
            <a href="{{ route('apresentacoes.eixo5') }}">
              <button class="btn btn-light">Abrir</button>
            </a>
          </div>
      
          <div>
            <h5 class="bg__card_pattern p-1 mb-0"></h5>
          </div>
        </div>
      </div>

      <!-- EIXO VI -->
      <div class="col-md-3 mb-4">
        <div class="card overflow-hidden">
          <h5 class="bg__card_pattern bg__card_pattern_footer p-3 text-light text-center mb-0" style="height: 70px;">
            EIXO <span style="" class="ms-1">VI</span>
          </h5>
      
          <div class="card-body border card-fofinho p-4">
            <div class="my-auto title-teste text-center d-flex">
              CANAIS DE DENÚNCIA
            </div>
          </div>
      
          <div class="card-hover">
            <a href="{{ route('apresentacoes.eixo6') }}">
              <button class="btn btn-light">Abrir</button>
            </a>
          </div>
      
          <div>
            <h5 class="bg__card_pattern p-1 mb-0"></h5>
          </div>
        </div>
      </div>

      <!-- EIXO VII -->
      <div class="col-md-3 mb-4">
        <div class="card overflow-hidden">
          <h5 class="bg__card_pattern bg__card_pattern_footer p-3 text-light text-center mb-0" style="height: 70px;">
            EIXO <span style="" class="ms-1">VII</span>
          </h5>
      
          <div class="card-body border card-fofinho p-4">
            <div class="my-auto title-teste text-center d-flex">
              INVESTIGAÇÕES INTERNAS
            </div>
          </div>
      
          <div class="card-hover">
            <a href="{{ route('apresentacoes.eixo7') }}">
              <button class="btn btn-light">Abrir</button>
            </a>
          </div>
      
          <div>
            <h5 class="bg__card_pattern p-1 mb-0"></h5>
          </div>
        </div>
      </div>
      

      <!-- EIXO VIII -->
      <div class="col-md-3 mb-4">
        <div class="card overflow-hidden">
          <h5 class="bg__card_pattern bg__card_pattern_footer p-3 text-light text-center mb-0" style="height: 70px;">
            EIXO <span style="" class="ms-1">VIII</span>
          </h5>
      
          <div class="card-body border card-fofinho p-4">
            <div class="my-auto title-teste text-center d-flex">
              MONITORAMENTO CONTÍNUO
            </div>
          </div>
      
          <div class="card-hover">
            <a href="{{ route('apresentacoes.eixo8') }}">
              <button class="btn btn-light">Abrir</button>
            </a>
          </div>
      
          <div>
            <h5 class="bg__card_pattern p-1 mb-0"></h5>
          </div>
        </div>
      </div>
      
    </div>
  </div>
</div>

@endsection
