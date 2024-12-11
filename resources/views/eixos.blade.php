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
      <div class="col-md-3 mb-4">
        <div class="card overflow-hidden">
          <h5 class="bg__card_pattern p-3 mb-0"></h5>

          <div class="card-body card-fofinho p-4">
            <div class="mb-3 title-fofinho d-flex">
              EIXO I
            </div>

            <div class="mt-5 custom__mouse">
              <span style="color: #0c326f">
                <i class="fas fa-mouse-pointer"></i>
                Passe o mouse
              </span>
            </div>

          </div>

          <div class="card-hover">
            <p class="p-5">COMPROMETIMENTO E APOIO DA ALTA DIREÇÃO</p>
            <button class="btn btn-light mt-5 mb-3">Ler mais</button>
          </div>
        </div>
      </div>

      <!-- EIXO II -->
      <div class="col-md-3 mb-4">
        <div class="card overflow-hidden">
          <h5 class="bg__card_pattern p-3 mb-0"></h5>
          
          <div class="card-body card-fofinho p-4">
            <div class="mb-3 title-fofinho d-flex">
              EIXO II
            </div>

            <div class="mt-5 custom__mouse">
              <span style="color: #0c326f">
                <i class="fas fa-mouse-pointer"></i>
                Passe o mouse
              </span>
            </div>
          </div>

          <div class="card-hover">
            <p class="p-5">INSTITUCIONALIZAÇÃO DO CÓDIGO DE CONDUTA</p>
            <button class="btn btn-light mt-5 mb-3">Ler mais</button>
          </div>
        </div>
      </div>

      <!-- EIXO III -->
      <div class="col-md-3 mb-4">
        <div class="card overflow-hidden">
          <h5 class="bg__card_pattern p-3 mb-0"></h5>
          
          <div class="card-body card-fofinho p-4">
            <div class="mb-3 title-fofinho d-flex">
              EIXO III
            </div>

            <div class="mt-5 custom__mouse">
              <span style="color: #0c326f">
                <i class="fas fa-mouse-pointer"></i>
                Passe o mouse
              </span>
            </div>
          </div>

          <div class="card-hover">
            <p class="p-5">AVALIAÇÃO DE RISCO</p>
            <button class="btn btn-light mt-5 mb-3">Ler mais</button>
          </div>
        </div>
      </div>

      <!-- EIXO IV -->
      <div class="col-md-3 mb-4">
        <div class="card overflow-hidden">
          <h5 class="bg__card_pattern p-3 mb-0"></h5>

          <div class="card-body card-fofinho p-4">
            <div class="mb-3 title-fofinho d-flex">
              EIXO IV
            </div>

            {{-- <div class="mt-5 custom__mouse">
              <span style="color: #0c326f">
                <i class="fas fa-mouse-pointer"></i>
                Passe o mouse
              </span>
            </div> --}}
          </div>

          <div class="card-hover">
            <p class="p-5">IMPLEMENTAÇÃO DOS CONTROLES INTERNOS</p>
            <button class="btn btn-light mt-5 mb-3">Ler mais</button>
          </div>
        </div>
      </div>

      <!-- EIXO V -->
      <div class="col-md-3 mb-4">
        <div class="card overflow-hidden">
          <h5 class="bg__card_pattern p-3 mb-0"></h5>

          <div class="card-body card-fofinho p-4">
            <div class="mb-3 title-fofinho d-flex">
              EIXO V
            </div>

            <div class="mt-5 custom__mouse">
              <span style="color: #0c326f">
                <i class="fas fa-mouse-pointer"></i>
                Passe o mouse
              </span>
            </div>

          </div>

          <div class="card-hover">
            <p class="p-5">COMUNICAÇÃO E TREINAMENTOS PERIÓDICOS</p>
            <button class="btn btn-light mt-5 mb-3">Ler mais</button>
          </div>
        </div>
      </div>

      <!-- EIXO VI -->
      <div class="col-md-3 mb-4">
        <div class="card overflow-hidden">
          <h5 class="bg__card_pattern p-3 mb-0"></h5>

          <div class="card-body card-fofinho p-4">
            <div class="mb-3 title-fofinho d-flex">
              EIXO VI
            </div>

            <div class="mt-5 custom__mouse">
              <span style="color: #0c326f">
                <i class="fas fa-mouse-pointer"></i>
                Passe o mouse
              </span>
            </div>
          </div>

          <div class="card-hover">
            <p class="p-5">CANAIS DE DENÚNCIA</p>
            <button class="btn btn-light mt-5 mb-3">Ler mais</button>
          </div>
        </div>
      </div>

      <!-- EIXO VII -->
      <div class="col-md-3 mb-4">
        <div class="card overflow-hidden">
          <h5 class="bg__card_pattern p-3 mb-0"></h5>

          <div class="card-body card-fofinho p-4">
            <div class="mb-3 title-fofinho d-flex">
              EIXO VII
            </div>

            <div class="mt-5 custom__mouse">
              <span style="color: #0c326f">
                <i class="fas fa-mouse-pointer"></i>
                Passe o mouse
              </span>
            </div>
          </div>

          <div class="card-hover">
            <p class="p-5">INVESTIGAÇÕES INTERNAS</p>
            <button class="btn btn-light mt-5 mb-3">Ler mais</button>
          </div>
        </div>
      </div>

      <!-- EIXO VIII -->
      <div class="col-md-3 mb-4">
        <div class="card overflow-hidden">
          <h5 class="bg__card_pattern p-3 mb-0"></h5>

          <div class="card-body card-fofinho p-4">
            <div class="mb-3 title-fofinho d-flex">
              EIXO VIII
            </div>

            <div class="mt-5 custom__mouse">
              <span style="color: #0c326f">
                <i class="fas fa-mouse-pointer"></i>
                Passe o mouse
              </span>
            </div>
          </div>

          <div class="card-hover">
            <p class="p-5">MONITORAMENTO CONTÍNUO</p>
            <button class="btn btn-light mt-5 mb-3">Ler mais</button>
          </div>
        </div>
      </div>

    </div>
  </div>
</div>

@endsection
