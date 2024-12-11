@extends('layouts.app')
@section('content')

@section('title') {{ 'Eixos' }} @endsection

<head>
  <link rel="stylesheet" href="{{ asset('css/eixos.css') }}">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
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
      <div class="col-md-3 mb-4">
        <div class="card overflow-hidden">
          <div class="card-body card-fofinho p-4">
            <div class="mb-3 title-fofinho d-flex">
              EIXO I
            </div>

            <div class="mt-5">
              <span style="color: #0c326f">
                <i class="fas fa-mouse-pointer"></i>
                Passe o mouse
              </span>
            </div>

          </div>

          <!-- Card alternativo -->
          <div class="card-hover">
            <p class="p-5">COMPROMETIMENTO E APOIO DA ALTA DIREÇÃO</p>
            <button class="btn btn-light mt-5 mb-3">Ler mais</button>
          </div>
        </div>
      </div>

      <!-- EIXO II -->
      <div class="col-md-3 mb-4">
        <div class="card overflow-hidden">
          <div class="card-body card-fofinho p-4">
            <div class="mb-3 title-fofinho d-flex">
              EIXO II
            </div>

            <div class="mt-5">
              <span style="color: #0c326f">
                <i class="fas fa-mouse-pointer"></i>
                Passe o mouse
              </span>
            </div>
          </div>
          <!-- Card alternativo -->
          <div class="card-hover">
            <p class="p-5">INSTITUCIONALIZAÇÃO DO CÓDIGO DE CONDUTA</p>
            <button class="btn btn-light mt-5 mb-3">Ler mais</button>
          </div>
        </div>
      </div>

      <!-- EIXO III -->
      <div class="col-md-3 mb-4">
        <div class="card overflow-hidden">
          <div class="card-body card-fofinho p-4">
            <div class="mb-3 title-fofinho d-flex">
              EIXO III
            </div>

            <div class="mt-5">
              <span style="color: #0c326f">
                <i class="fas fa-mouse-pointer"></i>
                Passe o mouse
              </span>
            </div>
          </div>
          <!-- Card alternativo -->
          <div class="card-hover">
            <p class="p-5">AVALIAÇÃO DE RISCO</p>
            <button class="btn btn-light mt-5 mb-3">Ler mais</button>
          </div>
        </div>
      </div>

      <!-- EIXO IIII -->
      <div class="col-md-3 mb-4">
        <div class="card overflow-hidden">
          <div class="card-body card-fofinho p-4">
            <div class="mb-3 title-fofinho d-flex">
              EIXO IIII
            </div>

            <div class="mt-5">
              <span style="color: #0c326f">
                <i class="fas fa-mouse-pointer"></i>
                Passe o mouse
              </span>
            </div>
          </div>
          <!-- Card alternativo -->
          <div class="card-hover">
            <p class="p-5">IMPLEMENTAÇÃO DOS CONTROLES INTERNOS</p>
            <button class="btn btn-light mt-5 mb-3">Ler mais</button>
          </div>
        </div>
      </div>

    </div>
  </div>
</div>

@endsection
