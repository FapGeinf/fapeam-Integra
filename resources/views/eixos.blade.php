@extends('layouts.app')
@section('content')

@section('title') {{ 'Eixos' }} @endsection

<head>
  <link rel="stylesheet" href="{{ asset('css/eixos.css') }}">

  <style>
    .card-fofinho {
      justify-content: center;
      align-items: center;
    }

    .title-fofinho {
      font-size: 30px;
      font-family: Georgia, 'Times New Roman', Times, serif;
    }

    /* Estilo para o card original e alternativo */
    .card {
      position: relative;
    }

    .card:hover {
      transform: translateY(-10px)
    }

    .card-hover {
      position: absolute;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      background-color: #002560;
      color: white;
      display: flex;
      flex-direction: column;
      justify-content: center;
      align-items: center;
      text-align: center;
      opacity: 0;
      transition: opacity 0.5s ease-in-out;
      z-index: 1;
    }

    /* Exibe o card alternativo ao passar o mouse */
    .card:hover .card-hover {
      opacity: 1;
    }

    .card:hover .card-body {
      opacity: 0;
    }

    .card-hover button {
      margin-top: 10px;
    }
  </style>
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
        <div class="card shadow-lg rounded-lg overflow-hidden">
          <div class="card-body card-fofinho p-4">
            <div class="mb-3 title-fofinho d-flex">
              EIXO I
            </div>
            <div class="mt-5">
              <span class="">Passe o mouse</span>
            </div>
            
          </div>

          <!-- Card alternativo -->
          <div class="card-hover">
            <p class="p-5">COMPROMETIMENTO E APOIO DA ALTA DIREÇÃO</p>
            <button class="btn btn-light mt-5">Ler mais</button>
          </div>
        </div>
      </div>

      <!-- EIXO II -->
      <div class="col-md-3 mb-4">
        <div class="card shadow-lg rounded-lg overflow-hidden">
          <div class="card-body card-fofinho p-4">
            <div class="mb-3 title-fofinho d-flex">
              EIXO II
            </div>
          </div>
          <!-- Card alternativo -->
          <div class="card-hover">
            <p>INSTITUCIONALIZAÇÃO DO CÓDIGO DE CONDUTA</p>
            <button class="btn btn-light">Ação</button>
          </div>
        </div>
      </div>


      <!-- EIXO III -->
      <div class="col-md-3 mb-4">
        <div class="card shadow-lg rounded-lg overflow-hidden">
          <div class="card-body card-fofinho p-4">
            <div class="mb-3 title-fofinho d-flex">
              EIXO III
            </div>

            <span></span>
          </div>
          <!-- Card alternativo -->
          <div class="card-hover">
            <p>AVALIAÇÃO DE RISCO</p>
            <button class="btn btn-light">Ação</button>
          </div>
        </div>
      </div>

      <!-- EIXO IIII -->
      <div class="col-md-3 mb-4">
        <div class="card shadow-lg rounded-lg overflow-hidden">
          <div class="card-body card-fofinho p-4">
            <div class="mb-3 title-fofinho d-flex">
              EIXO IIII
            </div>
          </div>
          <!-- Card alternativo -->
          <div class="card-hover">
            <p>IMPLEMENTAÇÃO DOS CONTROLES INTERNOS</p>
            <button class="btn btn-light">Ação</button>
          </div>
        </div>
      </div>

    </div>
  </div>
</div>

@endsection
