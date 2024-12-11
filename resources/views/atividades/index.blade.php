@extends('layouts.app')

@section('content')
<div class="container-lg mt-5">
    <div class="row d-flex justify-content-center align-items-center">
        <div class="col-lg-12">
            <div class="alert-container">
                @if (session('success'))
                    <div class="alert alert-success">
                        {{ session('success') }}
                    </div>
                @elseif (session('error'))
                    <div class="alert alert-danger">
                        {{ session('error') }}
                    </div>
                @endif
            </div>
            <div class="card rounded-3 shadow-sm border-1 mb-4">
                <div class="card-body d-flex justify-content-between">
                    <h2 class="mb-0 fw-bold">Lista de Atividades</h2>
                    @if(Auth::user()->unidade->unidadeTipoFK == 1)
                    <a href="{{ route('atividades.create') }}" class="btn btn-primary">Adicionar Atividade</a>
                    @endif
                </div>
            </div>
            <div class="card rounded-3 shadow-sm border-1">
                <div class="card-body">
                    <div class="table-responsive"> <!-- Adicione esta div -->
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Eixo</th>
                                    <th scope="col">Atividade</th>
                                    <th scope="col">Objetivo</th>
                                    <th scope="col">Publico Alvo</th>
                                    <th scope="col">Tipo de Evento</th>
                                    <th scope="col">Canal de Divulgação</th>
                                    <th scope="col">Data Prevista</th>
                                    <th scope="col">Data Realizada</th>
                                    <th scope="col">Meta</th>
                                    <th scope="col">Realizado</th>
                                    <th scope="col">Ações</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($atividades as $atividade)
                                    <tr>
                                        <td>{{ $atividade->id }}</td>
                                        <td>{{ $atividade->eixo->nome }}</td>
                                        <td>{{ $atividade->atividade_descricao }}</td>
                                        <td>{{ $atividade->objetivo }}</td>
                                        <td>{{$atividade->publico_alvo}}</td>
                                        <td>{{$atividade->tipo_evento}}</td>
                                        <td>{{$atividade->canal_divulgacao}}</td>
                                        <td>{{ \Carbon\Carbon::parse($atividade->data_prevista)->format('d/m/Y') }}</td>
                                        <td>{{ $atividade->data_realizada ? \Carbon\Carbon::parse($atividade->data_realizada)->format('d/m/Y') : 'Não realizada' }}
                                        </td>
                                        <td>{{$atividade->meta}}</td>
                                        <td>{{$atividade->realizado}}</td>
                                        <td>
                                        @if(Auth::user()->unidade->unidadeTipoFK == 1)
                                            <div class="d-flex justify-content-start">
                                                <a href="{{ route('atividades.edit', $atividade->id) }}"
                                                    class="btn btn-sm btn-warning me-2">Editar</a>
                                                <button type="button" class="btn btn-sm btn-danger" data-bs-toggle="modal"
                                                    data-bs-target="#deleteModal{{ $atividade->id }}">
                                                    Excluir
                                                </button>
                                            </div>
                                        </td>
                                        @endif
                                    </tr>
                                    <div class="modal fade" id="deleteModal{{ $atividade->id }}" tabindex="-1"
                                        aria-labelledby="deleteModalLabel{{ $atividade->id }}" aria-hidden="true">
                                        <div class="modal-dialog modal-dialog-centered">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="deleteModalLabel{{ $atividade->id }}">
                                                        Confirmar Exclusão</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                        aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">
                                                    Tem certeza que deseja excluir esta atividade?
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary"
                                                        data-bs-dismiss="modal">Cancelar</button>
                                                    <form action="{{ route('atividades.delete', $atividade->id) }}"
                                                        method="POST">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-danger">Excluir</button>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </tbody>
                        </table>
                    </div> 
                </div>
            </div>
        </div>
    </div>
</div>
@endsection