@extends('layouts.app')
@section('content')

@section('title')
    {{ 'Tabela das Respostas' }}
@endsection

<head>
    <link rel="stylesheet" href="{{ asset('css/resp.css') }}">
</head>

<div class="container-xl p-30">
    @if (session('error'))
        <script>
            alert('Não foi possível salvar sua resposta no momento');
        </script>
    @endif
    <div class="col-12 box-shadow">
        <h4 class="text-center">Providência(s) do Risco Inerente</h4>
        <hr class="hr1">

        <div class="chat-box">
            @if ($respostas->count() > 0)
                @php
                    $lastSetor = null; // Para rastrear o setor da última mensagem
                    $alignmentClass = 'align-left'; // Define o alinhamento inicial
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
                                  <div class="dataSector" style="{{ $alignmentClass === 'align-right' ? 'background-color: #d9d9d9cc;' : '' }}">
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
                                    </div>
                                </div>
                            </div>

                            <hr class="hr2">

                            <p class="form-control fStyle" style="background-color: #f0f0f0;">{!! $resposta->respostaRisco !!}</p>
                            <div class="text-end">
                                <button type="button" class="btn btn-warning btn-sm" data-bs-toggle="modal"
                                    data-bs-target="#editRespostaModal"
                                    onclick="editResposta({{ $resposta->id }}, `{{ $resposta->respostaRisco }}`)">
                                    <i class="bi bi-pen"></i>
                                </button>
                            </div>
                        </div>
                    @else
                        @php
                            $alignmentClass = $isLeftAligned ? 'align-right' : 'align-left';
                        @endphp

                        <div class="message {{ $alignmentClass === 'align-left' ? 'other-message' : 'another-message' }} {{ $alignmentClass }}">
                            <div class="p-1">
                                <div class="d-flex row">
                                    <div class="dataSector" style="{{ $alignmentClass === 'align-right' ? 'background-color: #d9d9d9cc;' : '' }}">
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
                                    </div>
                                </div>
                            </div>

                            <hr class="hr2">

                            <p class="form-control fStyle" style="background-color: #f0f0f0;">{!! $resposta->respostaRisco !!}</p>
                            <div class="text-end">
                                <button type="button" class="btn btn-warning btn-sm" data-bs-toggle="modal"
                                    data-bs-target="#editRespostaModal"
                                    onclick="editResposta({{ $resposta->id }}, `{{ $resposta->respostaRisco }}`)">
                                    <i class="bi bi-pen"></i>
                                </button>
                            </div>
                        </div>
                    @endif

                    @php
                        $lastSetor = $currentSetor; // Atualiza o setor da última mensagem
                    @endphp
                @endforeach
            @else
                <p class="text-center">Não há respostas disponíveis para este risco.</p>
            @endif
            <div class="container d-flex justify-content-center mt-4">
                <button type="button" class="reply-btn" data-bs-toggle="modal"
                    data-bs-target="#respostaModal">Responder</button>
            </div>
        </div>
    </div>
</div>

<!-- Modal de Edição -->
<div class="modal fade" id="editRespostaModal" tabindex="-1" aria-labelledby="editRespostaModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editRespostaModalLabel">Editar Resposta</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="editRespostaForm" method="POST">
                    @csrf
                    @method('PUT')
                    <input type="hidden" id="editRespostaId" name="id">
                    <div class="mb-4">
                        <label for="editRespostaRisco" class="form-label">Resposta</label>
                        <textarea class="form-control" id="editRespostaRisco" name="respostaRisco" required></textarea>
                    </div>
                    <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                        <button type="submit" class="btn btn-success mb-2">Salvar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Modal de Resposta -->
<div class="modal fade" id="respostaModal" tabindex="-1" aria-labelledby="respostaModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="respostaModalLabel">Adicionar Resposta</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="{{ route('riscos.storeResposta', ['id' => $risco->id]) }}" method="POST">
                    @csrf
                    <div id="respostasFields">
                        <div class="mb-4 resposta" style="margin-top: 10px;">
                            <label for="respostas[0][respostaRisco]" class="form-label">Resposta</label>
                            <textarea class="form-control" name="respostas[0][respostaRisco]" id="respostaRisco" required></textarea>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-success mb-2">Salvar</button>
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

        document.addEventListener('shown.bs.modal', function (event) {
            const modalId = event.target.id;
            if (modalId === 'editRespostaModal') {
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
        form.action = `/riscos/respostas/${id}`;
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
