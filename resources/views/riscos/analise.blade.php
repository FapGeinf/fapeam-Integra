@extends('layouts.app')
@section('title') {{ 'Análise do Risco' }} @endsection
@section('content')

<link rel="stylesheet" href="{{ asset('css/index.css') }}">
<link rel="stylesheet" href="{{ asset('css/main.css') }}">
<link rel="stylesheet" href="{{ asset('css/tables.css') }}">
<link rel="stylesheet" href="{{ asset('css/buttons.css') }}">
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/5.2.3/css/bootstrap.min.css">
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.25/css/jquery.dataTables.css">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.10.25/js/jquery.dataTables.js"></script>

<style>
  #tableHome td,
  #tableHome th {
    cursor: default !important;
  }
</style>

<div class="pt-5">
  <div class="container-xxl border box-shadow bg-white py-0" style="max-width: 1500px !important;">
    <table id="tableHome" class="table table-striped">
      <thead>
        <tr class="text-center text13">
          <th>N°</th>
          <th>Responsável</th>
          <th class="text-nowrap">Unidade</th>
          <th class="text-nowrap">Evento de Risco</th>
          <th>Causa</th>
          <th>Consequência</th>
          <th class="text-nowrap" style="width: 100px;">Classificação do Risco</th>
        </tr>
      </thead>

      <tbody>
        @foreach ($riscos as $risco)
          <tr class="">
            <td class="text13 text-nowrap text-center">{{ $risco->id }}</td>
            <td class="text13 text-nowrap text-center">{!! $risco->responsavelRisco !!}</td>
            <td class="text13 word-break text-nowrap text-center">{!! $risco->unidade->unidadeSigla !!}</td>
            <td class="text13 text-start">{!! Str::limit($risco->riscoEvento, 720) !!}</td>
            <td class="text13 text-start">{!! Str::limit($risco->riscoCausa, 720) !!}</td>
            <td class="text13 text-start">{!! Str::limit($risco->riscoConsequencia, 720) !!}</td>
             
            @if ($risco->nivel_de_risco == 1)
              <td class="bg-baixo riscoAvaliacao text-center text13">
                <span class="fw-bold">Baixo</span>
              </td>

            @elseif ($risco->nivel_de_risco == 2)
              <td class="bg-medio riscoAvaliacao text-center text13">
                <span class="fw-bold">Médio</span>
              </td>

            @else
              <td class="bg-alto riscoAvaliacao text-center text13">
                <span class="fw-bold">Alto</span>
              </td>
            @endif
          </tr>
        @endforeach
      </tbody>
    </table>
  </div>
</div>

<div class="modal fade" id="notificationModal" tabindex="-1" aria-labelledby="notificationModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-scrollable">
    <div class="modal-content bg-white">
      <div class="modal-header">
        <h5 class="modal-title" id="notificationModalLabel">Notificações</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>

      <div class="modal-body">
        @if ($notificacoesNaoLidas->isEmpty() && $notificacoesLidas->isEmpty())
          <p class="text-center">Sem notificações.</p>

        @else
          <form id="markAsReadForm" method="POST" action="{{ route('riscos.markAsRead') }}">
            @csrf

            @if (!$notificacoesNaoLidas->isEmpty())
              <div class="mb-4">
                <div class="d-flex align-items-center justify-content-between mb-2">
                  <h6 class="text-primary mb-0">Não lidas</h6>

                  <button type="submit" class="highlighted-btn-sm highlight-success">
                    <i class="bi bi-save2 me-1"></i>
                    Salvar seleção
                  </button>
                </div>

                <div class="row g-2">
                  @foreach ($notificacoesNaoLidas as $notificacao)
                    <div class="col-12">
                      <div class="card-shadow-sm border">
                        <div class="card-body py-2">
                          <div class="d-flex align-items-center justify-content-between gap-3">
                            <div class="d-flex align-items-start gap-2">
                              <div class="form-check">
                                <input class="form-check-input notification-checkbox"
                                  type="checkbox" name="notification_ids[]"
                                  id="notificationCheck{{ $notificacao->id }}"
                                  value="{{ $notificacao->id }}">
                              </div>     
                              
                              <div class="small">
                                <span>{!! $notificacao->message !!}</span>
                              </div>
                            </div>

                            <div class="d-flex align-items-center gap-2">
                              @if (!is_null($notificacao->monitoramentoId))
                                <a href="{{ route('riscos.respostas', ['id' => $notificacao->monitoramentoId]) }}"  
                                  class="highlighted-btn-sm highlight-blue text-nowrap text-decoration-none">
                                  <i class="bi bi-box-arrow-up-right me-1"></i>
                                  Resposta
                                </a>
                              @endif
                            </div>

                          </div>
                        </div>
                      </div>
                    </div>
                  @endforeach
                </div>
              </div>
            @endif

            @if (!$notificacoesLidas->isEmpty())
              <div>
                <h6 class="text-muted">Lidas</h6>

                @foreach ($notificacoesLidas as $notificacao)
                  <div class="row g-2">
                    <div class="col-12">
                      <div class="card border mb-2">
                        <div class="card-body py-2">
                          <div class="d-flex align-items-center justify-content-between gap-3">
                            <div class="d-flex align-items-start gap-2">
                              <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="notificationCheck{{ $notificacao->id }}" checked disabled>
                              </div>

                              <div class="small">
                                <span>{!! $notificacao->message !!}</span>
                              </div>
                            </div>

                            <div class="d-flex align-items-center gap-2">
                              @if (!is_null($notificacao->monitoramentoId))
                                <a href="{{ route('riscos.respostas', ['id' => $notificacao->monitoramentoId]) }}" 
                                  class="highlighted-btn-sm highlight-blue text-nowrap text-decoration-none">
                                  <i class="bi bi-box-arrow-up-right me-1"></i>
                                  Resposta
                                </a>
                              @endif
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                @endforeach
              </div>
            @endif
          </form>
        @endif
      </div>

      <div class="modal-footer">
        <button type="button" class="highlighted-btn-sm highlight-grey" data-bs-dismiss="modal">
          <i class="bi-x-lg"></i>
          Fechar
        </button>
      </div>
    </div>
  </div>
</div>

<script>
  document.addEventListener('DOMContentLoaded', function() {
    const prazoElement = document.getElementById('prazo');
    const prazoDate = new Date(prazoElement.dataset.prazo);
    const today = new Date();

    const diffTime = prazoDate - today;
    const diffDays = Math.ceil(diffTime / (1000 * 60 * 60 * 24));

    prazoElement.classList.remove('bg-success', 'bg-warning', 'bg-danger');

    if (diffDays < 0) {
      prazoElement.classList.add('bg-danger');
    } else if (diffDays <= 7) {
      prazoElement.classList.add('bg-warning');
    } else {
      prazoElement.classList.add('bg-success');
    }
  });
</script>

<script>
  document.addEventListener('DOMContentLoaded', function() {
    document.getElementById('notificationModal').addEventListener('show.bs.modal', function() {
      const notificationBadge = document.getElementById('notificationBadge');
      const unreadCount = parseInt(notificationBadge.dataset.count, 10);
      notificationBadge.textContent = unreadCount;
      notificationBadge.dataset.count = unreadCount;
    });

    document.getElementById('showMoreUnread')?.addEventListener('click', function() {
      const notifications = document.getElementById('unreadNotifications');
      notifications.classList.toggle('expanded');
      this.textContent = notifications.classList.contains('expanded') ? 'Mostrar menos' :
        'Mostrar mais';
    });

    document.getElementById('showMoreRead')?.addEventListener('click', function() {
      const notifications = document.getElementById('readNotifications');
      notifications.classList.toggle('expanded');
      this.textContent = notifications.classList.contains('expanded') ? 'Mostrar menos' :
        'Mostrar mais';
    });
  });
</script>

<script>
  document.addEventListener('DOMContentLoaded', function() {
    document.getElementById('notificationModal').addEventListener('show.bs.modal', function() {
      const notificationBadge = document.getElementById('notificationBadge');
      const unreadCount = parseInt(notificationBadge.dataset.count, 10);
      notificationBadge.textContent = unreadCount;
      notificationBadge.dataset.count = unreadCount;
    });

    document.getElementById('showMoreUnread')?.addEventListener('click', function() {
      const notifications = document.getElementById('unreadNotifications');
      notifications.classList.toggle('expanded');
      this.textContent = notifications.classList.contains('expanded') ? 'Mostrar menos' :
        'Mostrar mais';
    });

    document.getElementById('showMoreRead')?.addEventListener('click', function() {
      const notifications = document.getElementById('readNotifications');
      notifications.classList.toggle('expanded');
      this.textContent = notifications.classList.contains('expanded') ? 'Mostrar menos' :
        'Mostrar mais';
    });
  });
</script>

<script>
  $(document).ready(function() {
    console.log("Inicializando DataTable...");

    var table = $('#tableHome').DataTable({
      language: {
        url: '//cdn.datatables.net/plug-ins/1.13.6/i18n/pt-BR.json',
        search: "Procurar:",
        lengthMenu: "Paginação: _MENU_",
        info: 'Mostrando página _PAGE_ de _PAGES_',
        infoEmpty: 'Sem relatórios de risco disponíveis no momento',
        infoFiltered: '(Filtrados do total de _MAX_ relatórios)',
        zeroRecords: 'Nada encontrado. Se achar que isso é um erro, contate o suporte.',
        paginate: {
          next: "Próximo",
          previous: "Anterior"
        }
      },

      initComplete: function() {
        console.log("DataTable inicializado com sucesso.");
        var divContainer = $('<div class="divContainer d-flex justify-content-between align-items-center flex-wrap"></div>');

        var buttonContainer = $('<div class="d-flex align-items-center gap-2"></div>');


        var dropdownContainer = $('<div class="dropdown-container"></div>');
        var dropdownButton = $('<button class="footer-btn footer-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">Mostrar filtros</button>');
        var dropdownMenu = $('<div class="dropdown-menu p-3 bg-white" style="max-width: 350px;"></div>');

        if (!$('#filterUnidade').length) {
          console.log("Adicionando filtro de unidade...");
          var selectUnidade = $('<select id="filterUnidade" class="form-select form-select-sm input-enabled pointer"><option value="">Todas as Unidades</option></select>');

          @foreach($unidades->sortBy('unidadeSigla') as $unidade)
            selectUnidade.append('<option value="{{ $unidade->unidadeSigla }}">{{ $unidade->unidadeSigla }}</option>');
          @endforeach

          var labelUnidades = $('<label for="filterUnidade" class="labelUnidade">Unidades:</label>');
          dropdownMenu.append(labelUnidades).append(selectUnidade);
        }

        if (!$('#filterAvaliação').length) {
          console.log("Adicionando filtro de avaliação...");
          var selectAvaliacao = $('<select id="filterAvaliação" class="form-select form-select-sm input-enabled pointer"><option value="">Todas as Avaliações</option></select>');

          var avaliacaoOptions = [
            { value: "Baixo", text: "Baixo" },
            { value: "Médio", text: "Médio" },
            { value: "Alto", text: "Alto" }
          ];

          $.each(avaliacaoOptions, function (index, option) {
            selectAvaliacao.append('<option value="' + option.value + '">' + option.text + '</option>');
          });

          var labelAvaliacoes = $('<label for="filterAvaliação" class="labelAvaliação d-block mt-2">Avaliação:</label>');
          dropdownMenu.append(labelAvaliacoes).append(selectAvaliacao);
        }

        // Modificação para adicionar classes ao seletor de paginação
        $('.dataTables_length select').addClass('mt-2 select__pag');

        dropdownMenu.append($('.dataTables_length'));
        dropdownContainer.append(dropdownButton).append(dropdownMenu);
        buttonContainer.append(dropdownContainer);

        var notificationButton = $('<button id="notificationButton" type="button" class="footer-btn footer-notif position-relative" data-bs-toggle="modal" data-bs-target="#notificationModal"><i class="bi bi-bell"></i><span id="notificationBadge" class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger" data-count="{{ $notificacoes->whereNull('read_at')->count() }}">{{ $notificacoes->whereNull('read_at')->count() }}<span class="visually-hidden">unread messages</span></span></button>');

        divContainer.append(buttonContainer);

        var searchAndPrazoContainer = $('<div class="d-flex align-items-center gap-3"></div>');

        var searchContainer = $('<div class="search-container mx-auto"></div>');
        searchContainer.append($('.dataTables_filter'));
        searchAndPrazoContainer.append(searchContainer);

        var prazoContainer = $('<div class="highlight-date-term border" id="prazo" data-prazo="{{ \Carbon\Carbon::parse($prazo)->format('Y-m-d') }}">Prazo Final: <span class="fw-bold">{{ \Carbon\Carbon::parse($prazo)->format('d/m/Y') }}</span></div>');
        searchAndPrazoContainer.append(notificationButton);
        searchAndPrazoContainer.append(prazoContainer);

        divContainer.append(searchAndPrazoContainer);

        $(table.table().container()).prepend(divContainer);

        $('#filterUnidade').on('change', function () {
          console.log("Filtro de unidade alterado.");
          var val = $(this).val();
          table.column(2).search(val).draw();
        });

        $('#filterAvaliação').on('change', function () {
          console.log("Filtro de avaliação alterado.");
          var val = $.fn.dataTable.util.escapeRegex($(this).val());
          table.column(6).search(val ? '^' + val + '$' : '', true, false).draw();
        });

        $('#filterMonitoramentoRespondido').on('change', function () {
          console.log("Filtro por monitoramentos respondidos ativado.");
          if (this.checked) {
            table.column(7).search('^[1-9][0-9]*$', true, false).draw(); 

          } else {
            table.column(7).search('', true, false).draw();
          }
        });
      }
    });
  });
</script>
    
<x-back-button/>
@endsection