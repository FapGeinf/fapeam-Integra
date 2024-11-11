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

      <!-- EIXO I: Botões -->
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

      <!-- EIXO I: Modal Apresentação -->
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

      <!-- EIXO I: Modal Indicadores -->
      <div class="modal fade" id="modalIndicadores" tabindex="-1" aria-labelledby="modalIndicadoresLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="modalIndicadoresLabel">EIXO I - INDICADORES</h5>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
              <span>
                <ol class="listStyle">
                  <li class="liStrong">Participação em Treinamentos e Workshops</li>
                  <span>
                    Métrica: Percentual de diretores e executivos que participaram de treinamentos relacionados ao programa de integridade no último ano.
                    Objetivo: ≥ 80% de participação.
                  </span>

                  <li class="mt-3 liStrong">Visibilidade e Comunicação</li>
                  <span>
                    Métrica: Número de comunicações oficiais (e-mails, reuniões, vídeos) emitidas pela alta direção sobre a importância do programa de integridade.
                    Objetivo: Mínimo de 4 comunicações por ano.
                  </span>

                  <li class="mt-3 liStrong">Participação em Comitês de Ética</li>
                  <span>
                    Métrica: Frequência de participação da alta direção em reuniões do comitê de ética ou integridade.<br>
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
      
      <!-- EIXO II: Botões -->
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
                <button type="button" class="btn btn-outline-primary btn-sm w-100 mb-2 rounded-pill shadow-sm transition-all hover-scale" data-bs-toggle="modal" data-bs-target="#modalApresentacao1">
                  <i class="bi bi-file-earmark-text me-2"></i> Apresentação
                </button>
              </li>
              <li>
                <button type="button" class="btn btn-outline-primary btn-sm w-100 rounded-pill shadow-sm transition-all hover-scale" data-bs-toggle="modal" data-bs-target="#modalIndicadores1">
                  <i class="bi bi-bar-chart-line me-2"></i> Indicadores
                </button>
              </li>
            </ul>
          </div>
        </div>
      </div>
        
      <!-- EIXO II: Modal Apresentação -->
      <div class="modal fade" id="modalApresentacao1" tabindex="-1" aria-labelledby="modalApresentacaoLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="modalApresentacaoLabel">EIXO II - APRESENTAÇÃO</h5>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
              <p>
                Criação de códigos, políticas e procedimentos, contribuindo para a formalização inicial daquilo que é a postura do órgão/entidade e esclarecendo como deve ser desenvolvida a prestação do serviço público e os relacionamentos internos e externos entre agentes públicos e privados de maneira a mitigar a ocorrência de possíveis quebras da integridade.
              </p>
              
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>
            </div>
          </div>
        </div>
      </div>

      <!-- EIXO II: Modal Indicadores -->
      <div class="modal fade" id="modalIndicadores1" tabindex="-1" aria-labelledby="modalIndicadoresLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="modalIndicadores">EIXO II - INDICADORES</h5>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
              <span>
                <ol class="listStyle">
                  <li class="liStrong">Participação em Treinamentos e Workshops</li>
                  <span>
                    Métrica: Percentual de diretores e executivos que participaram de treinamentos relacionados ao programa de integridade no último ano.
                    Objetivo: ≥ 80% de participação.
                  </span>

                  <li class="mt-3 liStrong">Visibilidade e Comunicação</li>
                  <span>
                    Métrica: Número de comunicações oficiais (e-mails, reuniões, vídeos) emitidas pela alta direção sobre a importância do programa de integridade.
                    Objetivo: Mínimo de 4 comunicações por ano.
                  </span>

                  <li class="mt-3 liStrong">Participação em Comitês de Ética</li>
                  <span>
                    Métrica: Frequência de participação da alta direção em reuniões do comitê de ética ou integridade.<br>
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

      <!-- EIXO III: Botões -->
      <div class="col-md-3 mb-4">
        <div class="card border-primary shadow-lg rounded-lg">
          <h5 class="card-title text-white bg-primary rounded-top p-2 d-flex align-items-center">
            <i class="bi bi-check-circle me-2"></i> EIXO III
          </h5>
          <div class="card-body">
            <div class="mb-3">
              <div class="d-flex">
                <i class="bi bi-bookmark-fill text-primary me-2"></i>
                <p class="card-text text-muted fs-6">AVALIAÇÃO DE RISCOS</p>
              </div>
            </div>

            <hr class="mt-0">

            <ul class="list-unstyled">
              <li>
                <button type="button" class="btn btn-outline-primary btn-sm w-100 mb-2 rounded-pill shadow-sm transition-all hover-scale" data-bs-toggle="modal" data-bs-target="#modalApresentacao2">
                  <i class="bi bi-file-earmark-text me-2"></i> Apresentação
                </button>
              </li>
              <li>
                <button type="button" class="btn btn-outline-primary btn-sm w-100 rounded-pill shadow-sm transition-all hover-scale" data-bs-toggle="modal" data-bs-target="#modalIndicadores2">
                  <i class="bi bi-bar-chart-line me-2"></i> Indicadores
                </button>
              </li>
            </ul>
          </div>
        </div>
      </div>

      <!-- EIXO III: Modal Apresentação -->
      <div class="modal fade" id="modalApresentacao2" tabindex="-1" aria-labelledby="modalApresentacaoLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="modalApresentacaoLabel">EIXO III - APRESENTAÇÃO</h5>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
              <p>
                A gestão de riscos associados ao tema da integridade consiste no processo de natureza permanente, estabelecido, direcionado e monitorado pelo órgão ou entidade que contempla as atividades de analisar, identificar, mapear, avaliar e gerenciar potenciais eventos que possam afetar a organização da Fapeam, destinado a fornecer segurança razoável quanto à realização de seus objetivos (Art. 4 IN CGE/AM n. 02/2022).
              </p>
              
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>
            </div>
          </div>
        </div>
      </div>

      <!-- EIXO III: Indicadores -->
      <div class="modal fade" id="modalIndicadores2" tabindex="-1" aria-labelledby="modalIndicadoresLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="modalIndicadores">EIXO II - INDICADORES</h5>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
              <span>
                <ol class="listStyle">
                  <li class="">Auditorias</li>
                  <!-- <span>
                    Métrica: Percentual de diretores e executivos que participaram de treinamentos relacionados ao programa de integridade no último ano.
                    Objetivo: ≥ 80% de participação.
                  </span> -->

                  <!-- <li class="mt-3 liStrong">Visibilidade e Comunicação</li>
                  <span>
                    Métrica: Número de comunicações oficiais (e-mails, reuniões, vídeos) emitidas pela alta direção sobre a importância do programa de integridade.
                    Objetivo: Mínimo de 4 comunicações por ano.
                  </span> -->

                  <!-- <li class="mt-3 liStrong">Participação em Comitês de Ética</li>
                  <span>
                    Métrica: Frequência de participação da alta direção em reuniões do comitê de ética ou integridade.
                    Objetivo: Presença em ≥ 80% das reuniões.
                  </span> -->
                </ol>
              </span>
            </div>

            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>
            </div>
          </div>
        </div>
      </div>

      <!-- EIXO IV: Botões -->
      <div class="col-md-3 mb-4">
        <div class="card border-primary shadow-lg rounded-lg">
          <h5 class="card-title text-white bg-primary rounded-top p-2 d-flex align-items-center">
            <i class="bi bi-check-circle me-2"></i> EIXO IV
          </h5>
          <div class="card-body">
            <div class="mb-3">
              <div class="d-flex">
                <i class="bi bi-bookmark-fill text-primary me-2"></i>
                <p class="card-text text-muted fs-6">IMPLEMENTAÇÃO DOS CONTROLES INTERNOS</p>
              </div>
            </div>
            <hr class="mt-0">

            <ul class="list-unstyled">
              <li>
                <button type="button" class="btn btn-outline-primary btn-sm w-100 mb-2 rounded-pill shadow-sm transition-all hover-scale" data-bs-toggle="modal" data-bs-target="#modalApresentacao3">
                  <i class="bi bi-file-earmark-text me-2"></i> Apresentação
                </button>
              </li>
              <li>
                <button type="button" class="btn btn-outline-primary btn-sm w-100 rounded-pill shadow-sm transition-all hover-scale" data-bs-toggle="modal" data-bs-target="#modalIndicadores3">
                  <i class="bi bi-bar-chart-line me-2"></i> Indicadores
                </button>
              </li>
            </ul>
          </div>
        </div>
      </div>

      <!-- EIXO IV: Modal Apresentação -->
      <div class="modal fade" id="modalApresentacao3" tabindex="-1" aria-labelledby="modalApresentacaoLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="modalApresentacaoLabel">EIXO IV - APRESENTAÇÃO</h5>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
              <p>
                A implementação dos controles internos contribui para o gerenciamento dos riscos de integridade os quais devem ser mantidos, analisados criticamente de forma periódica e testados para assegurar a sua contínua eficácia. Por controles internos administrativos entede-se que são atividades e procedimentos de controles incidentes sobre os processos de trabalho da unidade com o objetivo de diminuir os riscos e alcançar os objetivos da entidade, presentes em todos os níveis e em todas as funções e executados por todo o corpo funcional da organização.
              </p>
              
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>
            </div>
          </div>
        </div>
      </div>

      <!-- EIXO IV: Modal Indicadores -->
      <div class="modal fade" id="modalIndicadores3" tabindex="-1" aria-labelledby="modalIndicadoresLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="modalIndicadores">EIXO IV - INDICADORES</h5>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
              <span>
                <ol class="listStyle">
                  <li class="">Auditorias</li>
                  <!-- <span>
                    Métrica: Percentual de diretores e executivos que participaram de treinamentos relacionados ao programa de integridade no último ano.
                    Objetivo: ≥ 80% de participação.
                  </span> -->

                  <!-- <li class="mt-3 liStrong">Visibilidade e Comunicação</li>
                  <span>
                    Métrica: Número de comunicações oficiais (e-mails, reuniões, vídeos) emitidas pela alta direção sobre a importância do programa de integridade.
                    Objetivo: Mínimo de 4 comunicações por ano.
                  </span> -->

                  <!-- <li class="mt-3 liStrong">Participação em Comitês de Ética</li>
                  <span>
                    Métrica: Frequência de participação da alta direção em reuniões do comitê de ética ou integridade.
                    Objetivo: Presença em ≥ 80% das reuniões.
                  </span> -->
                </ol>
              </span>
            </div>

            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>
            </div>
          </div>
        </div>
      </div>

      <!-- EIXO V: Botões -->
      <div class="col-md-3 mb-4">
        <div class="card border-primary shadow-lg rounded-lg">
          <h5 class="card-title text-white bg-primary rounded-top p-2 d-flex align-items-center">
            <i class="bi bi-check-circle me-2"></i> EIXO V
          </h5>
          <div class="card-body">
            <div class="mb-3">
              <div class="d-flex">
                <i class="bi bi-bookmark-fill text-primary me-2"></i>
                <p class="card-text text-muted fs-6">COMUNICAÇÃO E TREINAMENTOS PERIÓDICOS</p>
              </div>
            </div>

            <hr class="mt-0">

            <ul class="list-unstyled">
              <li>
                <button type="button" class="btn btn-outline-primary btn-sm w-100 mb-2 rounded-pill shadow-sm transition-all hover-scale" data-bs-toggle="modal" data-bs-target="#modalApresentacao4">
                  <i class="bi bi-file-earmark-text me-2"></i> Apresentação
                </button>
              </li>
              <li>
                <button type="button" class="btn btn-outline-primary btn-sm w-100 rounded-pill shadow-sm transition-all hover-scale" data-bs-toggle="modal" data-bs-target="#modalIndicadores4">
                  <i class="bi bi-bar-chart-line me-2"></i> Indicadores
                </button>
              </li>
            </ul>
          </div>
        </div>
      </div>

      <!-- EIXO V: Modal Apresentação -->
      <div class="modal fade" id="modalApresentacao4" tabindex="-1" aria-labelledby="modalApresentacaoLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="modalApresentacaoLabel">EIXO V - APRESENTAÇÃO</h5>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
              <p>
                As ações de comunicação e treinamento do Programa de Integridade da FAPEAM abrange todas as iniciativas destinadas a levar aos agentes públicos e partes interessadas os valores do órgão ou entidade, comunicar as regras e padrões éticos, bem como fomentar comportamento alinhados à moral, ao respeito às leis e à integridade pública (Art. 6 IN CGE/AM n. 02/2022).
              </p>
              
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>
            </div>
          </div>
        </div>
      </div>

      <!-- EIXO V: Indicadores -->
      <div class="modal fade" id="modalIndicadores4" tabindex="-1" aria-labelledby="modalIndicadoresLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="modalIndicadores">EIXO V - INDICADORES</h5>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
              <span>
                <ol class="listStyle">
                  <li class="">Sugestão da CGE</li>
                  <!-- <span>
                    Métrica: Percentual de diretores e executivos que participaram de treinamentos relacionados ao programa de integridade no último ano.
                    Objetivo: ≥ 80% de participação.
                  </span> -->

                  <!-- <li class="mt-3 liStrong">Visibilidade e Comunicação</li>
                  <span>
                    Métrica: Número de comunicações oficiais (e-mails, reuniões, vídeos) emitidas pela alta direção sobre a importância do programa de integridade.
                    Objetivo: Mínimo de 4 comunicações por ano.
                  </span> -->

                  <!-- <li class="mt-3 liStrong">Participação em Comitês de Ética</li>
                  <span>
                    Métrica: Frequência de participação da alta direção em reuniões do comitê de ética ou integridade.
                    Objetivo: Presença em ≥ 80% das reuniões.
                  </span> -->
                </ol>
              </span>
            </div>

            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>
            </div>
          </div>
        </div>
      </div>

      <!-- EIXO VI: Botões -->
      <div class="col-md-3 mb-4">
        <div class="card border-primary shadow-lg rounded-lg">
          <h5 class="card-title text-white bg-primary rounded-top p-2 d-flex align-items-center">
            <i class="bi bi-check-circle me-2"></i> EIXO VI
          </h5>
          <div class="card-body">
            <div class="mb-3">
              <div class="d-flex">
                <i class="bi bi-bookmark-fill text-primary me-2"></i>
                <p class="card-text text-muted fs-6">CANAIS DE DENÚNCIA</p>
              </div>
            </div>
            <hr class="mt-0">

            <ul class="list-unstyled">
              <li>
                <button type="button" class="btn btn-outline-primary btn-sm w-100 mb-2 rounded-pill shadow-sm transition-all hover-scale" data-bs-toggle="modal" data-bs-target="#modalApresentacao5">
                  <i class="bi bi-file-earmark-text me-2"></i> Apresentação
                </button>
              </li>
              <li>
                <button type="button" class="btn btn-outline-primary btn-sm w-100 rounded-pill shadow-sm transition-all hover-scale" data-bs-toggle="modal" data-bs-target="#modalIndicadores5">
                  <i class="bi bi-bar-chart-line me-2"></i> Indicadores
                </button>
              </li>
            </ul>
          </div>
        </div>
      </div>

      <!-- EIXO VI: Modal Apresentação -->
      <div class="modal fade" id="modalApresentacao5" tabindex="-1" aria-labelledby="modalApresentacaoLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="modalApresentacaoLabel">EIXO VI - APRESENTAÇÃO</h5>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
              <p>
                A divulgação e utilização do canal de denuncias (linha ética, canal de integridade, canal de confiança, dentre outros) pelo órgão ou entidade tem por objetivo viabilizar um meio pelo qual todos os servidores e cidadãos possam denunciar desconformidades éticas e de conduta cometida por servidores internos e externos que tenham nertwork com da FAPEAM, inclusive se pertencentes à alta administração, bem como esclarecer dúvidas sobre dilemas éticos (Art. 7 IN CGE/AM n. 02/2022).
              </p>
              
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>
            </div>
          </div>
        </div>
      </div>

      <!-- EIXO VI: Modal Indicadores -->
      <div class="modal fade" id="modalIndicadores5" tabindex="-1" aria-labelledby="modalIndicadoresLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="modalIndicadores">EIXO VI - INDICADORES</h5>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
              <span>
                <ol class="listStyle">
                  <li class="liStrong">Acessibilidade:</li>
                  <span>
                    Métrica: Percentual de colaboradores que conhecem os canais de denúncia disponíveis (pesquisa interna).
                    Objetivo: ≥ 85% de conhecimento.
                  </span>

                  <li class="mt-3 liStrong">Visibilidade e Comunicação</li>
                  <span>
                    Métrica: Número de comunicações oficiais (e-mails, reuniões, vídeos) emitidas pela alta direção sobre a importância do programa de integridade.
                    Objetivo: Mínimo de 4 comunicações por ano.
                  </span>

                  <li class="mt-3 liStrong">Participação em Comitês de Ética</li>
                  <span>
                    Métrica: Frequência de participação da alta direção em reuniões do comitê de ética ou integridade.<br>
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

      <!-- EIXO VII: Botões -->
      <div class="col-md-3 mb-4">
        <div class="card border-primary shadow-lg rounded-lg">
          <h5 class="card-title text-white bg-primary rounded-top p-2 d-flex align-items-center">
            <i class="bi bi-check-circle me-2"></i> EIXO VII
          </h5>
          <div class="card-body">
            <div class="mb-3">
              <div class="d-flex">
                <i class="bi bi-bookmark-fill text-primary me-2"></i>
                <p class="card-text text-muted fs-6">INVESTIGAÇÕES INTERNAS</p>
              </div>
            </div>
            <hr class="mt-0">

            <ul class="list-unstyled">
              <li>
                <button type="button" class="btn btn-outline-primary btn-sm w-100 mb-2 rounded-pill shadow-sm transition-all hover-scale" data-bs-toggle="modal" data-bs-target="#modalApresentacao6">
                  <i class="bi bi-file-earmark-text me-2"></i> Apresentação
                </button>
              </li>
              <li>
                <button type="button" class="btn btn-outline-primary btn-sm w-100 rounded-pill shadow-sm transition-all hover-scale" data-bs-toggle="modal" data-bs-target="#modalIndicadores6">
                  <i class="bi bi-bar-chart-line me-2"></i> Indicadores
                </button>
              </li>
            </ul>
          </div>
        </div>
      </div>

      <!-- EIXO VII: Modal Apresentação -->
      <div class="modal fade" id="modalApresentacao6" tabindex="-1" aria-labelledby="modalApresentacaoLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="modalApresentacaoLabel">EIXO VI - APRESENTAÇÃO</h5>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
              <p>
                Os órgãos e entidades devem possuir processos internos investigativos para garantir que os fatos sejam verificados, responsabilidades identificadas, sanções e ações corretivas sejam aplicadas, não importando o nível do agente, gerente e servidor que as causou, demonstrando o comprometimento da instituição pública com o fazer correto e punir aqueles que não compartilham dos mesmos valores éticos.
              </p>
              
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>
            </div>
          </div>
        </div>
      </div>

      <!-- EIXO VII: Modal Indicadores -->
      <div class="modal fade" id="modalIndicadores6" tabindex="-1" aria-labelledby="modalIndicadoresLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="modalIndicadores">EIXO VII - INDICADORES</h5>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
              <span>
                <ol class="listStyle">
                  <span>
                    Métrica: Percentual de colaboradores que cometeram devios de conduta.<br>
                    Objetivo:  ≤ 5% dos colaboradores com desvio de conduta
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

      <!-- EIXO VIII: Botões -->
      <div class="col-md-3 mb-4">
        <div class="card border-primary shadow-lg rounded-lg">
          <h5 class="card-title text-white bg-primary rounded-top p-2 d-flex align-items-center">
            <i class="bi bi-check-circle me-2"></i> EIXO VIII
          </h5>
          <div class="card-body">
            <div class="mb-3">
              <div class="d-flex">
                <i class="bi bi-bookmark-fill text-primary me-2"></i>
                <p class="card-text text-muted fs-6">MONITORAMENTO CONTÍNUO</p>
              </div>
            </div>
            <hr class="mt-0">

            <ul class="list-unstyled">
              <li>
                <button type="button" class="btn btn-outline-primary btn-sm w-100 mb-2 rounded-pill shadow-sm transition-all hover-scale" data-bs-toggle="modal" data-bs-target="#modalApresentacao7">
                  <i class="bi bi-file-earmark-text me-2"></i> Apresentação
                </button>
              </li>
              <li>
                <button type="button" class="btn btn-outline-primary btn-sm w-100 rounded-pill shadow-sm transition-all hover-scale" data-bs-toggle="modal" data-bs-target="#modalIndicadores7">
                  <i class="bi bi-bar-chart-line me-2"></i> Indicadores
                </button>
              </li>

              <li class="mt-2">
                <a class="btn btn-outline-primary btn-sm w-100 rounded-pill shadow-sm transition-all hover-scale" href="{{route('riscos.index')}}"><i class="bi bi-bar-chart-line me-2"></i> Monitoramentos</a>
              </li>
            </ul>
          </div>
        </div>
      </div>

      <!-- EIXO VII: Modal Apresentação -->
      <div class="modal fade" id="modalApresentacao7" tabindex="-1" aria-labelledby="modalApresentacaoLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="modalApresentacaoLabel">EIXO VI - APRESENTAÇÃO</h5>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
              <p>
                Para avaliar a efetividade de um programa de integridade, é essencial realizar um monitoramento contínuo, de modo a verificar se os eixos estão operando conforme o previsto, os efeitos esperados em relação à conscientização estão sendo alcançados, riscos estão sendo devidamente gerenciados e se novos surgiram durante a operacionalização do programa, conforme o caso, implementar medidas mitigadoras.
              </p>
              
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>
            </div>
          </div>
        </div>
      </div>

      <!-- EIXO VII: Modal Indicadores -->
      <div class="modal fade" id="modalIndicadores7" tabindex="-1" aria-labelledby="modalIndicadoresLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="modalIndicadores">EIXO VIII - INDICADORES</h5>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
              <span>
                <ol class="listStyle">
                  <span>
                    Métrica: Percentual de setores que mitigaram os riscos inerentes<br> 
                    Objetivo: ≥ 85% de mitigação de riscos inerentes.
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
    </div>
  </div>
</div>
@endsection
