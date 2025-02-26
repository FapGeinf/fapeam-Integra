@extends('layouts.app')
@section('content')

@section('title')
{{ 'Detalhes da Providência' }}
@endsection

<head>
    <link rel="stylesheet" href="{{ asset('css/resp.css') }}">

    <style>
        .liDP {
            margin-left: 0 !important;
        }
    </style>
</head>

<div class="container-xl p-30">


		@if (session('error'))
				<div class="alert alert-danger">
						{{ session('error') }}
				</div>
		@endif

    @if (session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
    @endif

    <div class="col-12 box-shadow">

        <div class="monitoramento">
            <h4 class="text-center">Monitoramento</h4>
            <hr class="hr1" style="padding-bottom: .6rem;">
            <div class="form-control" style="background-color: #f3f3f3;">
                {!! $monitoramento->monitoramentoControleSugerido !!}</div>
            <hr>
        </div>

        <h4 class="text-center">Providência(s)</h4>
        <hr class="hr1">

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
                    <div class="d-flex row">
                        <div class="dataSector" style="text-align: left; {{ $alignmentClass === 'align-right' ? 'background-color: #d9d9d9cc;' : '' }}">
                            <div>
                                Criado em:
                                <i class="bi bi-clock"></i>
                                <span class="dataSpan">
                                    {{ $resposta->created_at->format('d/m/Y') }}
                                    às
                                    {{ $resposta->created_at->format('H:i') }}
                                </span>
                            </div>
                            <div>
                                Lotação:
                                <i class="bi bi-building"></i>
                                <span class="dataSpan">
                                    {{ $resposta->user->unidade->unidadeNome }}
                                </span>
                            </div>
														<div>
																Perfil:
																<i class="bi bi-person"></i>
																<span class="dataSpan">
																		{{ $resposta->user->name }}
																</span>
														</div>
														@if($resposta->homologadoDiretoria != NULL)
															<div>
																<span class="dataSpan">
																		{{ $resposta->homologadoDiretoria }}
																</span>
															</div>
														@endif
													</div>
                    </div>
                </div>

                <hr class="hr2">

                <div class="form-control fStyle mb-2" style="text-align: left;">
                    <p style="background-color: #f0f0f0;">{!! $resposta->respostaRisco !!}</p>
                </div>

                @if ($resposta->anexo)
                <div class="text-end">
                    <a href="{{ Storage::url($resposta->anexo) }}" class="btn btn-info btn-sm" target="_blank">
                        <i class="bi bi-eye"></i>
                    </a>
                    <a href="{{ Storage::url($resposta->anexo) }}" class="btn btn-primary btn-sm" download>
                        <i class="bi bi-download"></i>
                    </a>
                    <button type="button" class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#editRespostaModal" onclick="editResposta({{ $resposta->id }}, `{{ $resposta->respostaRisco }}`)">
                        <i class="bi bi-pen"></i>
                    </button>

                    <button type="button" class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#deleteAnexoModal" onclick="setDeleteAnexo({{ $resposta->id }})">
                        <i class="bi bi-trash"></i> Excluir Anexo
                    </button>

										@if(Auth::user()->usuario_tipo_fk == 2)
                    	<button type="button" class="btn btn-sm btn-success" data-bs-toggle="modal" data-bs-target="#homologacaoModal{{ $resposta->id }}">
                      	  Homologar
                    	</button>
										@endif
                </div>
                @else
                <div class="text-end">

                    <button type="button" class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#editRespostaModal" onclick="editResposta({{ $resposta->id }}, `{{ $resposta->respostaRisco }}`)">
                        <i class="bi bi-pen"></i> Editar
                    </button>

										@if(Auth::user()->usuario_tipo_fk == 2)
                    	<button type="button" class="btn btn-sm btn-success" data-bs-toggle="modal" data-bs-target="#homologacaoModal{{ $resposta->id }}">
                      	  Homologar
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
                                <span class="dataSpan">
                                    {{ $resposta->created_at->format('d/m/Y') }}
                                    às
                                    {{ $resposta->created_at->format('H:i') }}
                                </span>
                            </div>
                            <div>
                                Lotação:
                                <i class="bi bi-building"></i>
                                <span class="dataSpan">
                                    {{ $resposta->user->unidade->unidadeNome }}
                                </span>
                            </div>
														<div>
																Perfil:
																<i class="bi bi-person"></i>
																<span class="dataSpan">
																		{{ $resposta->user->name }}
																</span>
														</div>
														@if($resposta->homologadoDiretoria != NULL)
															<div>
																<span class="dataSpan">
																		{{ $resposta->homologadoDiretoria }}
																</span>
															</div>
														@endif
													</div>
                    </div>
                </div>

                <hr class="hr2">

                <div class="form-control fStyle mb-2" style="text-align: left;">
                    <p style="background-color: #f0f0f0;">{!! $resposta->respostaRisco !!}</p>
                </div>

                @if ($resposta->anexo)
                <div class="text-end">
                    <a href="{{ Storage::url($resposta->anexo) }}" class="btn btn-info btn-sm" target="_blank">
                        <i class="bi bi-eye"></i>
                    </a>
                    <a href="{{ Storage::url($resposta->anexo) }}" class="btn btn-primary btn-sm" download>
                        <i class="bi bi-download"></i>
                    </a>
                    <button type="button" class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#editRespostaModal" onclick="editResposta({{ $resposta->id }}, `{{ $resposta->respostaRisco }}`)">
                        <i class="bi bi-pen"></i>
                    </button>

                    <button type="button" class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#deleteAnexoModal" onclick="setDeleteAnexo({{ $resposta->id }})">
                        <i class="bi bi-trash"></i> Excluir Anexo
                    </button>
										@if(Auth::user()->usuario_tipo_fk == 2)
                    	<button type="button" class="btn btn-sm btn-success" data-bs-toggle="modal" data-bs-target="#homologacaoModal{{ $resposta->id }}">
                      	  Homologar
                    	</button>
										@endif
                </div>
                @else
                <div class="text-end">
                    <button type="button" class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#editRespostaModal" onclick="editResposta({{ $resposta->id }}, `{{ $resposta->respostaRisco }}`)">
                        <i class="bi bi-pen"></i>
                    </button>
										
										@if(Auth::user()->usuario_tipo_fk == 2)
                    	<button type="button" class="btn btn-sm btn-success" data-bs-toggle="modal" data-bs-target="#homologacaoModal{{ $resposta->id }}">
                      	  Homologar
                    	</button>
										@endif
									
                </div>
                @endif
            </div>
            @endif
            @php
            $lastSetor = $currentSetor;
            @endphp
            <div class="modal fade" id="deleteAnexoModal" tabindex="-1" aria-labelledby="deleteAnexoModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="deleteAnexoModalLabel">Confirmar Exclusão do Anexo
                            </h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <p>Tem certeza que deseja excluir o anexo?</p>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                            <form action="{{ route('riscos.deleteAnexo', $resposta->id) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger">Excluir Anexo</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal fade" id="homologacaoModal{{ $resposta->id }}" tabindex="-1" aria-labelledby="homologacaoModalLabel{{ $resposta->id }}" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="homologacaoModalLabel{{ $resposta->id }}">Confirmar Homologação
                            </h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            Você tem certeza de que deseja homologar esta resposta?
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                            <form action="{{ route('riscos.homologar', $resposta->id) }}" method="POST">
                                @csrf
                                @method('PUT')
                                <button type="submit" class="btn btn-success">Homologar</button>
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
                        <label for="editRespostaRisco" class="form-label">Resposta</label>
                        <textarea class="form-control" id="editRespostaRisco" name="respostaRisco" required></textarea>
                    </div>
                    <div class="mb-4">
                        <label for="editRespostaAnexo" class="form-label">Anexar Arquivo</label>
                        <input type="file" class="form-control" id="editRespostaAnexo" name="anexo">
                    </div>
                    <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                        <button type="submit" class="success">Salvar</button>
                    </div>
                </form>
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
                        <!-- <label for="respostaRisco" class="form-label">Resposta</label> -->
                        <textarea class="form-control" id="respostaRisco" name="respostaRisco" required></textarea>
                    </div>
                    <div class="mb-4">
                        <label for="anexo" class="form-label">Anexar Arquivo</label>
                        <input type="file" style="background-color: #f0f0f0;" class="form-control" id="anexo" name="anexo">
                    </div>
                    <div class="mb-4">
                        <label for="statusMonitoramento-{{ $monitoramento->id }}" class="form-label">Status do
                            Monitoramento</label>
                        <select class="form-select" style="background-color: #f0f0f0;" id="statusMonitoramento-{{ $monitoramento->id }}" name="statusMonitoramento" required>
                            <option value="NÃO IMPLEMENTADA" {{ old('statusMonitoramento', $monitoramento->statusMonitoramento) == 'NÃO IMPLEMENTADA' ? 'selected' : '' }}>
                                NÃO IMPLEMENTADA
                            </option>
                            <option value="EM IMPLEMENTAÇÃO" {{ old('statusMonitoramento', $monitoramento->statusMonitoramento) == 'EM IMPLEMENTAÇÃO' ? 'selected' : '' }}>
                                EM IMPLEMENTAÇÃO
                            </option>
                            <option value="IMPLEMENTADA PARCIALMENTE" {{ old('statusMonitoramento', $monitoramento->statusMonitoramento) == 'IMPLEMENTADA PARCIALMENTE' ? 'selected' : '' }}>
                                IMPLEMENTADA PARCIALMENTE
                            </option>
                            <option value="IMPLEMENTADA" {{ old('statusMonitoramento', $monitoramento->statusMonitoramento) == 'IMPLEMENTADA' ? 'selected' : '' }}>
                                IMPLEMENTADA
                            </option>
                        </select>
                    </div>
                    <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                        <button type="submit" class="btn btn-primary mb-2">Enviar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>



<script src="/ckeditor/ckeditor.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        CKEDITOR.replace('respostaRisco', {
            extraPlugins: 'wordcount',
            wordcount: {
                showCharCount: true,
                maxCharCount: 4500,
                maxCharCountMsg: 'Você atingiu o limite máximo de caracteres permitidos.',
                charCountMsg: 'Caracteres restantes: {0}'
            }
        });

        document.addEventListener('shown.bs.modal', function(event) {
            const modalId = event.target.id;
            if (modalId === 'editRespostaModal') {
                const respostaId = document.getElementById('editRespostaId').value;
                if (CKEDITOR.instances['editRespostaRisco']) {
                    CKEDITOR.instances['editRespostaRisco'].destroy();
                }
                CKEDITOR.replace('editRespostaRisco', {
                    extraPlugins: 'wordcount',
                    wordcount: {
                        showCharCount: true,
                        maxCharCount: 4500,
                        maxCharCountMsg: 'Você atingiu o limite máximo de caracteres permitidos.',
                        charCountMsg: 'Caracteres restantes: {0}'
                    }
                });
            }
        });
    });

    function editResposta(id, resposta) {
        const form = document.getElementById('editRespostaForm');
        form.action = `/riscos/monitoramentos/respostas/${id}`;
        document.getElementById('editRespostaId').value = id;
        if (CKEDITOR.instances['editRespostaRisco']) {
            CKEDITOR.instances['editRespostaRisco'].destroy();
        }
        CKEDITOR.replace('editRespostaRisco', {
            extraPlugins: 'wordcount',
            wordcount: {
                showCharCount: true,
                maxCharCount: 4500,
                maxCharCountMsg: 'Você atingiu o limite máximo de caracteres permitidos.',
                charCountMsg: 'Caracteres restantes: {0}'
            }
        });
        CKEDITOR.instances['editRespostaRisco'].setData(resposta);


    }
</script>
@endsection
