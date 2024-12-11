@extends('layouts.app')
@section('content')

@section('title') {{ 'Eixos' }} @endsection

<head>
  <link rel="stylesheet" href="{{ asset('css/eixos.css') }}">

  <style>
    .appContent {
      margin-left: 0 !important;
    }
  </style>

  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css.css">
</head>

<body>
  <div class="container-xxl pt-5">
    <div class="text-start">
      <h3 class="border__h3">
        Eixos do Programa de Integridade
      </h3>
    </div>

    <div id="carouselExampleIndicators" class="carousel slide" data-bs-ride="carousel" data-bs-interval="3000">
      <div class="carousel-indicators">
        <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
        <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="1" aria-label="Slide 2"></button>
        <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="2" aria-label="Slide 3"></button>
      </div>
    
      <div class="carousel-inner">
        <div class="carousel-item active position-relative">
          <img src="{{ asset('img/slide-fapeam2.png') }}" class="d-block w-100" alt="Imagem Aleatória" style="opacity: 0.5;">
          
          <!-- Container para os cards -->
          <div class="position-absolute top-50 start-50 translate-middle w-100 d-flex justify-content-center">
            <div class="row w-75">
              <!-- Card 1 -->
              <div class="col-md-4">
                <div class="card text-center shadow-sm">
                  <div class="card-body">
                    <h5 class="card-title">Card 1</h5>
                    <p class="card-text">Descrição do card 1.</p>
                    <a href="#" class="btn btn-primary">Saiba mais</a>
                  </div>
                </div>
              </div>
              <!-- Card 2 -->
              <div class="col-md-4">
                <div class="card text-center shadow-sm">
                  <div class="card-body">
                    <h5 class="card-title">Card 2</h5>
                    <p class="card-text">Descrição do card 2.</p>
                    <a href="#" class="btn btn-primary">Saiba mais</a>
                  </div>
                </div>
              </div>
              <!-- Card 3 -->
              <div class="col-md-4">
                <div class="card text-center shadow-sm">
                  <div class="card-body">
                    <h5 class="card-title">Card 3</h5>
                    <p class="card-text">Descrição do card 3.</p>
                    <a href="#" class="btn btn-primary">Saiba mais</a>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        
    
        <div class="carousel-item">
          <img src="{{ asset('img/slide-fapeam4.png') }}" class="d-block w-100" alt="Imagem Aleatória">
        </div>
        
        <div class="carousel-item">
          <img src="{{ asset('img/slide-fapeam6.png') }}" class="d-block w-100" alt="Imagem Aleatória">
        </div>
      </div>
    
      <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide="prev">
        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
        <span class="visually-hidden">Previous</span>
      </button>
    
      <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide="next">
        <span class="carousel-control-next-icon" aria-hidden="true"></span>
        <span class="visually-hidden">Next</span>
      </button>
    </div>
    

  </div>
</body>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
@endsection
