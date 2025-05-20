@extends('layouts.app')
@section('content')
<link rel="stylesheet" href="{{ asset('css/resp.css') }}">
<script src="{{ asset('js/auto-dismiss.js') }}"></script>
<style>
    .liDP {
        margin-left: 0 !important;
    }

    .modal-content {
        background-color: #fff;
    }
</style>
@section('title') {{ 'Detalhes da Providência' }} @endsection
<div class="container-general p-30 mt-5">
    @if (session('error'))
        <div class="alert alert-danger text-center auto-dismiss">
            {{ session('error') }}
        </div>
    @endif

    @if (session('success'))
        <div class="alert alert-success text-center auto-dismiss">
            {{ session('success') }}
        </div>
    @endif

    <div class="col-12 box-shadow border mb-3">
        <h5 class="text-center mb-3">Monitoramento</h5>
        <div class="form-control" style="background-color: #f3f3f3;">
            {!! $monitoramento->monitoramentoControleSugerido !!}
        </div>
    </div>

    <div class="col-12 box-shadow border">
        <h5 class="text-center mb-3">Providência</h5>
        <div class="chat-box">
            @if ($respostas->count() > 0)
                @php
                    $lastSetor = null;
                    $alignmentClass = 'align-left';
                @endphp

                @foreach ($respostas as $resposta)
                    @php
                        $currentSetor = $resposta->user->unidade->id;
                        $isLeftAligned = $alignmentClass === 'align-left';
                    @endphp

                    @if ($lastSetor === $currentSetor)
                        <div class="message {{ $isLeftAligned ? 'other-message' : 'another-message' }} {{ $alignmentClass }}">
                            <div class="p-1">
                                <div class="d-flex row mb-3">
                                    <div class="dataSector" style="text-align: left; {{ $alignmentClass === 'align-right' ? 'background-color: #d9d9d9cc;' : '' }}">
                                        <div>
                                            Criado em:
                                            <i class="bi bi-clock"></i>
                                            <span class="dataSpan text-uppercase">
                                                {{ $resposta->created_at->format('d/m/Y') }}
                                                    às
                                                {{ $resposta->created_at->format('H:i') }}
                                            </span>
                                        </div>

                                        <div>
                                            Lotação:
                                            <i class="bi bi-building"></i>
                                            <span class="dataSpan text-uppercase">
                                                {{ $resposta->user->unidade->unidadeNome }}
                                            </span>
                                        </div>

                                        <div>
                                            Perfil:
                                            <i class="bi bi-person"></i>
                                            <span class="dataSpan text-uppercase">
                                                {{ $resposta->user->name }}
                                            </span>
                                        </div>

                                        @if ($resposta->homologadoDiretoria != null)
                                            <div class="sign">
                                                <span class="dataSpan">
                                                    {{ $resposta->homologadoDiretoria }}
                                                </span>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div>

                            <div class="form-control fStyle mb-2" style="text-align: left;">
                                <p style="background-color: #f0f0f0;">{!! $resposta->respostaRisco !!}</p>
                            </div>

                            @if ($resposta->anexo)
                                <div class="custom-actions-wrapper" id="actionsWrapper{{ $resposta->id }}">
                                    <button class="custom-actions-btn" onclick="toggleActionsMenu({{ $resposta->id }})">
                                        Ações <i class="bi bi-chevron-down"></i>
                                    </button>
                                
                                    <div class="custom-actions-menu">
                                        <a href="{{ Storage::url($resposta->anexo) }}" target="_blank">
                                            <i class="bi bi-eye me-2"></i>Visualizar
                                        </a>
                                
                                        <a href="{{ Storage::url($resposta->anexo) }}" download>
                                            <i class="bi bi-download me-2"></i>Baixar
                                        </a>
                                
                                        <a href="#" onclick="editResposta({{ $resposta->id }}, `{{ $resposta->respostaRisco }}`)" data-bs-toggle="modal" data-bs-target="#editRespostaModal">
                                            <i class="bi bi-pen me-2"></i>Editar
                                        </a>
                                    </div>
                                </div>

                                <span style="color: #949494; margin-left: 4px; margin-right: 4px;">|</span>
                            
                               <button type="button" class="highlighted-btn highlight-danger" data-bs-toggle="modal" data-bs-target="#deleteAnexoModal{{ $resposta->id }}">
                                        <i class="bi bi-trash me-1"></i>Excluir Anexo
                                </button>
                            
                                @if (Auth::user()->usuario_tipo_fk == 2)
                                    <button type="button" class="highlighted-btn highlight-success" data-bs-toggle="modal" data-bs-target="#homologacaoModal{{ $resposta->id }}">
                                        <i class="bi bi-check-circle me-1"></i>Homologar
                                    </button>
                                @endif

                            @else
                                <div class="text-end">
                                    <button type="button" class="highlighted-btn highlight-warning" data-bs-toggle="modal" data-bs-target="#editRespostaModal" onclick="editResposta({{ $resposta->id }}, `{{ $resposta->respostaRisco }}`)">
                                        <i class="bi bi-pen me-1"></i>Editar
                                    </button>

                                    @if (Auth::user()->usuario_tipo_fk == 2 && $resposta->homologadoDiretoria == null)
                                        <button type="button" class="highlighted-btn highlight-success" data-bs-toggle="modal" data-bs-target="#homologacaoModal{{ $resposta->id }}">
                                            <i class="bi bi-check-circle me-1"></i>Homologar
                                        </button>
                                    @endif

                                    @if (Auth::user()->usuario_tipo_fk == 1 && $resposta->homologadaPresidencia === null)
                                        <button type="button" class="highlighted-btn highlight-success" data-bs-toggle="modal" data-bs-target="#homologacaoPresidenciaModal{{ $resposta->id }}">
                                            <i class="bi bi-check-circle me-1"></i>Homologar (Presidência)
                                        </button>
                                    @endif
                                </div>
                            @endif
                        </div>
                    @else

                        @php
                            $alignmentClass = $isLeftAligned ? 'align-right' : 'align-left';
                        @endphp

                        <div class="message {{ $alignmentClass === 'align-left' ? 'other-message' : 'another-message' }} {{ $alignmentClass }}">
                            <div class="p-1">
                                <div class="d-flex row">
                                    <div class="dataSector" style="text-align: left; {{ $alignmentClass === 'align-right' ? 'background-color: #d9d9d9cc;' : '' }}">
                                        <div>
                                            Criado em:
                                            <i class="bi bi-clock"></i>
                                            <span class="dataSpan text-uppercase">
                                                {{ $resposta->created_at->format('d/m/Y') }}
                                                às
                                                {{ $resposta->created_at->format('H:i') }}
                                            </span>
                                        </div>

                                        <div>
                                            Lotação:
                                            <i class="bi bi-building"></i>
                                            <span class="dataSpan text-uppercase">
                                                {{ $resposta->user->unidade->unidadeNome }}
                                            </span>
                                        </div>

                                        <div>
                                            Perfil:
                                            <i class="bi bi-person"></i>
                                            <span class="dataSpan text-uppercase">
                                                {{ $resposta->user->name }}
                                            </span>
                                        </div>

                                        @if ($resposta->homologadoDiretoria != null)
                                            <div class="sign">
                                                <span class="dataSpan">
                                                    {{ $resposta->homologadoDiretoria }}
                                                </span>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div>

                            <div class="form-control fStyle my-2" style="text-align: left;">
                                <p style="background-color: #f0f0f0;">{!! $resposta->respostaRisco !!}</p>
                            </div>
                            
                            @if ($resposta->anexo)
                            <div class="text-end d-inline-flex align-items-center gap-2">

                                <!-- Menu customizado -->
                                <div class="custom-actions-wrapper" id="actionsWrapper{{ $resposta->id }}">
                                    <button class="custom-actions-btn" onclick="toggleActionsMenu({{ $resposta->id }})">
                                        Ações <i class="bi bi-chevron-down" style="font-size: 11px;"></i>
                                    </button>

                                    <div class="custom-actions-menu">
                                        <a href="{{ Storage::url($resposta->anexo) }}" target="_blank">
                                            <i class="bi bi-eye me-2"></i>Visualizar
                                        </a>

                                        <a href="{{ Storage::url($resposta->anexo) }}" download>
                                            <i class="bi bi-download me-2"></i>Baixar
                                        </a>

                                        <a href="#" onclick="editResposta({{ $resposta->id }}, `{{ $resposta->respostaRisco }}`)" data-bs-toggle="modal" data-bs-target="#editRespostaModal">
                                            <i class="bi bi-pen me-2"></i>Editar
                                        </a>
                                    </div>
                                </div>

                                <span style="color: #949494;">|</span>
                                                            
                                <button type="button" class="highlighted-btn highlight-danger" data-bs-toggle="modal" data-bs-target="#deleteAnexoModal{{ $resposta->id }}">
                                        <i class="bi bi-trash me-1"></i>Excluir Anexo
                                </button>

                            
                                @if (Auth::user()->usuario_tipo_fk == 2)
                                    <button type="button" class="highlighted-btn highlight-success" data-bs-toggle="modal" data-bs-target="#homologacaoModal{{ $resposta->id }}">
                                        <i class="bi bi-check-circle me-1"></i>Homologar
                                    </button>
                                @endif
                            </div>

                            @else
                                <div class="text-end">
                                    <button type="button" class="highlighted-btn highlight-warning me-1" data-bs-toggle="modal" data-bs-target="#editRespostaModal" onclick="editResposta({{ $resposta->id }}, `{{ $resposta->respostaRisco }}`)">
                                        <i class="bi bi-pen me-1"></i>Editar
                                    </button>

                                    @if (Auth::user()->usuario_tipo_fk == 2 && $resposta->homologadoDiretoria == null)
                                        <button type="button" class="highlighted-btn highlight-success" data-bs-toggle="modal" data-bs-target="#homologacaoModal{{ $resposta->id }}">
                                            <i class="bi bi-check-circle me-1"></i>Homologar
                                        </button>
                                    @endif

                                    @if (Auth::user()->usuario_tipo_fk == 1 && $resposta->homologadaPresidencia === null)
                                        <button type="button" class="highlighted-btn highlight-success" data-bs-toggle="modal" data-bs-target="#homologacaoPresidenciaModal{{ $resposta->id }}">
                                            <i class="bi bi-check-circle me-1"></i>Homologar (Presidência)
                                        </button>
                                    @endif
                                </div>
                            @endif
                        </div>
                    @endif

                    @php
                        $lastSetor = $currentSetor;
                    @endphp

                    <div class="modal fade" id="deleteAnexoModal{{ $resposta->id }}" tabindex="-1" aria-labelledby="deleteAnexoModalLabel{{ $resposta->id }}" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="deleteAnexoModalLabel{{ $resposta->id }}">Confirmar Exclusão do Anexo</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <p>Tem certeza que deseja excluir o anexo?</p>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="footer-btn footer-secondary" data-bs-dismiss="modal">Cancelar</button>
                                    <form method="POST" action="{{ route('riscos.deleteAnexo', $resposta->id) }}">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="footer-btn footer-danger">Excluir Anexo</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="modal fade" id="homologacaoModal{{ $resposta->id }}" tabindex="-1" aria-labelledby="homologacaoModalLabel{{ $resposta->id }}" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="homologacaoModalLabel{{ $resposta->id }}">Confirmar Homologação</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>

                                <div class="modal-body">
                                    Você tem certeza de que deseja homologar esta resposta?
                                </div>

                                <div class="modal-footer">
                                    <button type="button" class="footer-btn footer-secondary" data-bs-dismiss="modal">Cancelar</button>
                                    <form action="{{ route('riscos.homologar', $resposta->id) }}" method="POST">
                                        @csrf
                                        @method('PUT')
                                        <button type="submit" class="footer-btn footer-success">Homologar</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="modal fade" id="homologacaoPresidenciaModal{{ $resposta->id }}" tabindex="-1" aria-labelledby="homologacaoPresidenciaModalLabel{{ $resposta->id }}" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="homologacaoPresidenciaModalLabel{{ $resposta->id }}">Homologar pela Presidência</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fechar"></button>
                                </div>

                                <div class="modal-body">
                                    Tem certeza que deseja homologar esta resposta como presidente?
                                </div>

                                <div class="modal-footer">
                                    <button type="button" class="footer-btn footer-secondary" data-bs-dismiss="modal">Cancelar</button>
                                    <form action="{{ route('riscos.homologar', $resposta->id) }}" method="POST">
                                        @csrf
                                        @method('PUT')
                                        <button type="submit" class="footer-btn footer-success">
                                            Homologar (Presidência)
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach

            @else
                <p class="text-center">Não há respostas disponíveis para este risco.</p>
            @endif

            <div class="container d-flex justify-content-center mt-4">
                <button type="button" class="reply-btn" data-bs-toggle="modal" data-bs-target="#respostaModal">Responder</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="respostaModal" tabindex="-1" aria-labelledby="respostaModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="respostaModalLabel">Responder</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            
            <div class="modal-body">
                <form action="{{ route('riscos.storeResposta', ['id' => $monitoramento->id]) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="mb-4">
                        <label for="statusMonitoramento">Status:</label>
                        <select class="form-select input-enabled" id="statusMonitoramento" name="statusMonitoramento" required>
                            <option value="NÃO IMPLEMENTADA"
                                {{ old('statusMonitoramento') == 'NÃO IMPLEMENTADA' ? 'selected' : '' }}>
                                NÃO IMPLEMENTADA
                            </option>

                            <option value="EM IMPLEMENTAÇÃO"
                                {{ old('statusMonitoramento') == 'EM IMPLEMENTAÇÃO' ? 'selected' : '' }}>
                                EM IMPLEMENTAÇÃO
                            </option>

                            <option value="IMPLEMENTADA PARCIALMENTE"
                                {{ old('statusMonitoramento') == 'IMPLEMENTADA PARCIALMENTE' ? 'selected' : '' }}>
                                IMPLEMENTADA PARCIALMENTE
                            </option>
                            
                            <option value="IMPLEMENTADA"
                                {{ old('statusMonitoramento') == 'IMPLEMENTADA' ? 'selected' : '' }}>
                                IMPLEMENTADA
                            </option>
                        </select>
                    </div>

                    <div class="mb-4">
                        <label for="respostaRisco">Providência:</label>
                        <textarea class="form-control" id="respostaRisco" name="respostaRisco" required></textarea>
                    </div>

                    <div class="mb-4">
                        <label for="anexo" class="">Anexar Arquivo:</label>

                        <input type="file" class="form-control input-enabled" id="anexo" name="anexo">
                        <small class="form-text text-muted"><span class="text-danger">*</span>Apenas um arquivo pode ser anexado</small>
                    </div>


                    <div class="modal-footer justify-content-md-end p-0">
                        <button type="button" class="highlighted-btn-sm highlight-success mt-2" id="abrirConfirmacaoBtn">Enviar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="confirmacaoModal" tabindex="-1" aria-labelledby="confirmacaoModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">

        <h5 class="modal-title" id="confirmacaoModalLabel">Confirme sua resposta</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fechar"></button>
      </div>

      <div class="modal-body">
        <label class="mb-0 d-block">Status selecionado:</label>
        <span id="confirmStatus" class="form-control input-disabled"></span>

        <label class="d-block pt-4">Providência:</label>
        <div id="confirmProvidencia" class="form-control input-disabled mb-3"></div>

        <label class="d-block pt-2">Anexo:</label>
        <span id="confirmAnexo" class="form-control input-disabled mb-2"></span>

        <div id="previewContainer"></div>

      </div>

      <div class="modal-footer">
        <button type="button" class="highlighted-btn-sm footer-secondary" data-bs-dismiss="modal">Voltar e corrigir</button>
        <button type="button" class="highlighted-btn-sm highlight-success" id="confirmarEnvioBtn">Confirmar e enviar</button>
      </div>
    </div>
  </div>
</div>

<div class="modal fade" id="editRespostaModal" tabindex="-1" aria-labelledby="editRespostaModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editRespostaModalLabel">Editar Resposta</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <div class="modal-body">
                <form id="editRespostaForm" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <input type="hidden" id="editRespostaId" name="id">

                    <div class="mb-4">
                        <label for="statusMonitoramento" class="">Status:</label>
                        <select class="form-select input-enabled" id="statusMonitoramento" name="statusMonitoramento" required>
                            <option value="NÃO IMPLEMENTADA"
                                {{ old('statusMonitoramento', $monitoramento->statusMonitoramento) == 'NÃO IMPLEMENTADA' ? 'selected' : '' }}>
                                NÃO IMPLEMENTADA
                            </option>

                            <option value="EM IMPLEMENTAÇÃO"
                                {{ old('statusMonitoramento', $monitoramento->statusMonitoramento) == 'EM IMPLEMENTAÇÃO' ? 'selected' : '' }}>
                                EM IMPLEMENTAÇÃO
                            </option>

                            <option value="IMPLEMENTADA PARCIALMENTE"
                                {{ old('statusMonitoramento', $monitoramento->statusMonitoramento) == 'IMPLEMENTADA PARCIALMENTE' ? 'selected' : '' }}>
                                IMPLEMENTADA PARCIALMENTE
                            </option>

                            <option value="IMPLEMENTADA"
                                {{ old('statusMonitoramento', $monitoramento->statusMonitoramento) == 'IMPLEMENTADA' ? 'selected' : '' }}>
                                IMPLEMENTADA
                            </option>
                        </select>
                    </div>

                    <div class="mb-4">
                        <label for="editRespostaRisco" class="">Resposta:</label>
                        <textarea class="form-control" id="editRespostaRisco" name="respostaRisco" required></textarea>
                    </div>

                    <div class="mb-4">
                        <label for="editRespostaAnexo" class="d-block">Anexar Arquivo:</label>
                        <input type="file" class="form-control input-enabled" id="editRespostaAnexo" name="anexo">
                        <small class="form-text text-muted"><span class="text-danger">*</span>Apenas um arquivo pode ser anexado</small>
                    </div>

                    <div class="modal-footer p-0">
                        <div class="d-grid gap-2 d-md-flex justify-content-md-end mt-3">
                            <button type="button" class="highlighted-btn-sm highlight-success" id="abrirEditConfirmacaoBtn">
                                Salvar Edição
                            </button>
                        </div>
                    </div>
                    
                </form>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="editConfirmacaoModal" tabindex="-1" aria-labelledby="editConfirmacaoModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Confirmar Edição</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fechar"></button>
            </div>

            <div class="modal-body">
                <label class="mb-0">Status:</label>
                <span id="editConfirmStatus" class="form-control input-disabled"></span>

                <label class="d-block pt-4">Providência:</label>
                <div id="editConfirmProvidencia" class="form-control input-disabled mb-3"></div>


                <label class="d-block pt-2">Anexo:</label>
                <span id="editConfirmAnexo" class="form-control input-disabled mb-2"></span>

                <div id="previewContainerEdit"></div>
            </div>

            <div class="modal-footer">
                <button type="button" class="highlighted-btn-sm footer-secondary" data-bs-dismiss="modal">Voltar e corrigir</button>
                <button type="button" class="highlighted-btn-sm highlight-success" id="confirmarEdicaoBtn">Confirmar e enviar</button>
            </div>
        </div>
    </div>
</div>



<x-back-button />
<script src="{{ asset('ckeditor/ckeditor.js') }}"></script>
<script src="{{ asset('js/respostas.js') }}"></script>
<script src="{{ asset('js/bootstrap.bundle.min.js') }}"></script>
<script src="{{ asset('js/modais/storeProvidencia.js') }}"></script>
<script src="{{ asset('js/modais/editProvidencia.js') }}"></script>
<script src="{{ asset('js/wrapper/customActions.js') }}"></script>
@endsection
