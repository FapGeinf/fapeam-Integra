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
        <div class="card border-primary shadow-lg rounded-lg">
          <h5 class="card-title text-white bg-primary rounded-top p-2 d-flex align-items-center">
            <i class="bi bi-check-circle me-2"></i> EIXO I
          </h5>
          <div class="card-body">
            <div class="mb-3">
              <div class="d-flex">
                <i class="bi bi-bookmark-fill text-primary me-2"></i>
                <p class="card-text text-muted fs-6">COMPROMETIMENTO E APOIO DA ALTA DIREÇÃO</p>
              </div>
            </div>

            <hr class="mt-0">

            <ul class="list-unstyled">
              <li>
                <button type="button" class="btn btn-outline-primary btn-sm w-100 mb-2 rounded-pill shadow-sm transition-all hover-scale" data-bs-toggle="modal" data-bs-target="#modalApresentacao">
                  <i class="bi bi-file-earmark-text me-2"></i> Apresentação
                </button>
              </li>
              <li>
                <button type="button" class="btn btn-outline-primary btn-sm w-100 rounded-pill shadow-sm transition-all hover-scale" data-bs-toggle="modal" data-bs-target="#modalIndicadores">
                  <i class="bi bi-bar-chart-line me-2"></i> Indicadores
                </button>
              </li>
            </ul>
          </div>
        </div>
      </div>

      <!-- Modal Apresentação -->
      <div class="modal fade" id="modalApresentacao" tabindex="-1" aria-labelledby="modalApresentacaoLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="modalApresentacaoLabel">EIXO I - APRESENTAÇÃO</h5>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
              <p>
                O art. 2 da IN CGE/AM n0 02/2022 prevê que a alta administração dos órgãos ou entidades estaduais devem expressar compromisso e apoio à implementação e ao cumprimento do Programa de Integridade, demonstrando, por intermédio de ações institucionais públicas ou internas, a importância dos valores e das políticas que o compõe.
              </p>
              
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>
            </div>
          </div>
        </div>
      </div>

      <!-- Modal Indicadores -->
      <div class="modal fade" id="modalIndicadores" tabindex="-1" aria-labelledby="modalIndicadoresLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="modalIndicadoresLabel">EIXO I - INDICADORES</h5>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
              <span>
                <ol style="list-style:upper-latin">
                  <li>Participação em Treinamentos e Workshops</li>
                  <span>
                    Métrica: Percentual de diretores e executivos que participaram de treinamentos relacionados ao programa de integridade no último ano.
                    Objetivo: ≥ 80% de participação.
                  </span>

                  <li class="mt-3">Visibilidade e Comunicação</li>
                  <span>
                    Métrica: Número de comunicações oficiais (e-mails, reuniões, vídeos) emitidas pela alta direção sobre a importância do programa de integridade.
                    Objetivo: Mínimo de 4 comunicações por ano.
                  </span>

                  <li class="mt-3">Participação em Comitês de Ética</li>
                  <span>
                    Métrica: Frequência de participação da alta direção em reuniões do comitê de ética ou integridade.
                    Objetivo: Presença em ≥ 80% das reuniões.
                  </span>
                </ol>
              </span>
            </div>

            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>
            </div>
          </div>
        </div>
      </div>
      


      <div class="col-md-3 mb-4">
        <div class="card border-primary shadow-lg rounded-lg">
          <h5 class="card-title text-white bg-primary rounded-top p-2 d-flex align-items-center">
            <i class="bi bi-check-circle me-2"></i> EIXO II
          </h5>
          <div class="card-body">
            <div class="mb-3">
              <div class="d-flex">
                <i class="bi bi-bookmark-fill text-primary me-2"></i>
                <p class="card-text text-muted fs-6">INSTITUCIONALIZAÇÃO DO CÓDIGO DE CONDUTA</p>
              </div>
            </div>
            <hr class="mt-0">

            <ul class="list-unstyled">
              <li>
                <button type="button" class="btn btn-outline-primary btn-sm w-100 mb-2 rounded-pill shadow-sm transition-all hover-scale" data-bs-toggle="modal" data-bs-target="#modalApresentacao">
                  <i class="bi bi-file-earmark-text me-2"></i> Apresentação
                </button>
              </li>
              <li>
                <button type="button" class="btn btn-outline-primary btn-sm w-100 rounded-pill shadow-sm transition-all hover-scale" data-bs-toggle="modal" data-bs-target="#modalIndicadores">
                  <i class="bi bi-bar-chart-line me-2"></i> Indicadores
                </button>
              </li>
            </ul>
          </div>
        </div>
      </div>
        




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
@endsection
