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
      <div class="col-md-3 mb-4">
        <div class="card border1">
          <div class="card-body">
            <div class="mb-3">
              <h5 class="card-title">EIXO I</h5>
              <span>
                COMPROMETIMENTO E APOIO DA ALTA DIREÇÃO
              </span>
            </div>
            
            <ul>
              <li><a href="#">Apresentação</a></li>
              <li><a href="#">Indicadores</a></li>
            </ul>
          </div>
        </div>
      </div>

      <div class="col-md-3 mb-4">
        <div class="card border1">
          <div class="card-body">
            <div class="mb-3">
              <h5 class="card-title">EIXO II</h5>
              <span>
                INSTITUCIONALIZAÇÃO DO CÓDIGO DE CONDUTA
              </span>
            </div>
            
            <ul>
              <li><a href="#">Apresentação</a></li>
              <li><a href="#">Indicadores</a></li>
            </ul>
          </div>
        </div>
      </div>

      <div class="col-md-3 mb-4">
        <div class="card border1">
          <div class="card-body">
            <div class="mb-4">
              <h5 class="card-title">EIXO III</h5>
              <span>
                AVALIAÇÃO DE RISCOS
              </span>
            </div>
            
            <ul>
              <li><a href="#">Apresentação</a></li>
              <li><a href="#">Indicadores</a></li>
            </ul>
          </div>
        </div>
      </div>

      <div class="col-md-3 mb-4">
        <div class="card border1">
          <div class="card-body">
            <div class="mb-3">
              <h5 class="card-title">EIXO IV</h5>
              <span>
                IMPLEMENTAÇÃO DOS CONTROLES INTERNOS
              </span>
            </div>
            
            <ul>
              <li><a href="#">Apresentação</a></li>
              <li><a href="#">Indicadores</a></li>
            </ul>
          </div>
        </div>
      </div>

      <div class="col-md-3 mb-4">
        <div class="card border1">
          <div class="card-body">
            <div class="mb-3">
              <h5 class="card-title">EIXO V</h5>
              <span>
                COMUNICAÇÃO E TREINAMENTOS PERIÓDICOS
              </span>
            </div>
            
            <ul>
              <li><a href="#">Apresentação</a></li>
              <li><a href="#">Indicadores</a></li>
            </ul>
          </div>
        </div>
      </div>

      <div class="col-md-3 mb-4">
        <div class="card border1">
          <div class="card-body">
            <div class="mb-3">
              <h5 class="card-title">EIXO VI</h5>
              <span>
                CANAIS DE DENÚNCIA
              </span>
            </div>
            
            <ul>
              <li><a href="#">Apresentação</a></li>
              <li><a href="#">Indicadores</a></li>
            </ul>
          </div>
        </div>
      </div>

      <div class="col-md-3 mb-4">
        <div class="card border1">
          <div class="card-body">
            <div class="mb-3">
              <h5 class="card-title">EIXO VII</h5>
              <span>
                INVESTIGAÇÕES INTERNAS
              </span>
            </div>
            
            <ul>
              <li><a href="#">Apresentação</a></li>
              <li><a href="#">Indicadores</a></li>
            </ul>
          </div>
        </div>
      </div>

      <div class="col-md-3 mb-4">
        <div class="card border1">
          <div class="card-body">
            <div class="mb-3">
              <h5 class="card-title">EIXO VIII</h5>
              <span>
                MONITORAMENTO CONTÍNUO
              </span>
            </div>
            
            <ul>
              <li><a href="#">Apresentação</a></li>
              <li><a href="{{route('riscos.index')}}">Monitoramentos</a></li>
            </ul>
          </div>
        </div>
      </div>

    </div>
  </div>
</div>

{{-- <div class="container mt-4">
  <div class="box-container p-4">
    <div class="row">
      <div class="col-md-3 mb-4">
        <div class="card">
          <div class="card-body">
            <h5 class="card-title">Eixo 1</h5>
            <p class="card-text">Descrição do eixo 1.</p>
            <ul>
              <li><a href="#">Apresentação</a></li>
              <li><a href="#">Indicadores</a></li>
            </ul>
          </div>
        </div>
      </div>

      <div class="col-md-3 mb-4">
        <div class="card">
          <div class="card-body">
            <h5 class="card-title">Eixo 2</h5>
            <p class="card-text">Descrição do eixo 2.</p>
            <ul>
              <li><a href="#">Apresentação</a></li>
              <li><a href="#">Indicadores</a></li>
            </ul>
          </div>
        </div>
      </div>

      <div class="col-md-3 mb-4">
        <div class="card">
          <div class="card-body">
            <h5 class="card-title">Eixo 3</h5>
            <p class="card-text">Descrição do eixo 3.</p>
            <ul>
              <li><a href="#">Apresentação</a></li>
              <li><a href="#">Indicadores</a></li>
            </ul>
          </div>
        </div>
      </div>

      <div class="col-md-3 mb-4">
        <div class="card">
          <div class="card-body">
            <h5 class="card-title">Eixo 4</h5>
            <p class="card-text">Descrição do eixo 4.</p>
            <ul>
              <li><a href="#">Apresentação</a></li>
              <li><a href="#">Indicadores</a></li>
            </ul>
          </div>
        </div>
      </div>

      <div class="col-md-3 mb-4">
        <div class="card">
          <div class="card-body">
            <h5 class="card-title">Eixo 5</h5>
            <p class="card-text">Descrição do eixo 5.</p>
            <ul>
              <li><a href="#">Apresentação</a></li>
              <li><a href="#">Indicadores</a></li>
            </ul>
          </div>
        </div>
      </div>

      <div class="col-md-3 mb-4">
        <div class="card">
          <div class="card-body">
            <h5 class="card-title">Eixo 6</h5>
            <p class="card-text">Descrição do eixo 6.</p>
            <ul>
              <li><a href="#">Apresentação</a></li>
              <li><a href="#">Indicadores</a></li>
            </ul>
          </div>
        </div>
      </div>

      <div class="col-md-3 mb-4">
        <div class="card">
          <div class="card-body">
            <h5 class="card-title">Eixo 7</h5>
            <p class="card-text">Descrição do eixo 7.</p>
            <ul>
              <li><a href="#">Apresentação</a></li>
              <li><a href="#">Indicadores</a></li>
            </ul>
          </div>
        </div>
      </div>

      <div class="col-md-3 mb-4">
        <div class="card">
          <div class="card-body">
            <h5 class="card-title">Eixo 8</h5>
            <p class="card-text">Descrição do eixo 8.</p>
            <ul>
              <li><a href="#">Apresentação</a></li>
              <li><a href="{{route('riscos.index')}}">Monitoramentos</a></li>
            </ul>
          </div>
        </div>
      </div>
    </div>
  </div>
</div> --}}
@endsection
