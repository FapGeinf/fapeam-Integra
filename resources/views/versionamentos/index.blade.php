@extends('layouts.app')
<link rel="stylesheet" href="{{ asset('css/index.css') }}">
<link rel="stylesheet" href="{{ asset('css/atividades.css') }}">
<script src="{{ asset('js/jquery-3.6.0.min.js') }}"></script>
<script src="{{ asset('js/dataTables.min.js') }}"></script>
<link rel="stylesheet" href="{{ asset('css/dataTables.dataTables.min.css') }}">
<script src="{{ asset('js/versionamentos/indexVersionamentos.js') }}"></script>
<style>
    .liDP {
        margin-left: 0 !important;
    }

    .hover {
        text-decoration: none;
    }

    .hover:hover {
        text-decoration: underline;
    }
</style>
@section('title') {{ 'Lista de Atividades' }} @endsection
@section('content')
<div class="alert-container mt-5">
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
<div class="container-fluid px__custom pt-4">
    <div class="col-12 border main-datatable">
        <div class="d-flex justify-content-center text-center p-2" style="flex-direction: column;">
            <span style="font-size:22px;">Lista de Versionamentos</span>
        </div>
    </div>
</div>
<div class="container-fluid p-30">
    <div class="col-12 border main-datatable">
        <div class="container-fluid">
            <div class="row g-3 align-items-end">
                @if(Auth::user()->unidadeIdFK == 1)
                <div class="col-md-3 d-flex align-items-end">
                    <button type="button" data-bs-toggle="modal" data-bs-target="#insertVersionamento" class="btn btn-md btn-primary">Inserir Versionamento</button>
                </div>
                @endif
            </div>
            <div class="table-responsive">
                <table id="tableHome2" class="table cust-datatable mb-5">
                    <thead>
                        <tr style="white-space: nowrap; text-align:center;">
                            <th scope="col">Titulo</th>
                            <th scope="col">Descrição</th>
                            <th scope="col">Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($versionamentos as $versionamento)
                        <tr>
                            <td class="text-center">{{ $versionamento->titulo }}</td>
                            <td class="text-center">{!! $versionamento->descricao !!}</td>
                            <td>
                                @if(Auth::user()->unidade->unidadeTipoFK == 1)
                                <div class="d-flex justify-content-center gap-1">
                                    <button type="button" class="btn btn-warning" style="font-size: 13px;" data-bs-toggle="modal" data-bs-target="#editVersionamento{{ $versionamento->id }}">
                                        <i class="bi bi-pencil"></i> Editar
                                    </button>
                                    <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#deleteModal{{ $versionamento->id }}">
                                        <i class="bi bi-trash"></i> Deletar
                                    </button>
                                </div>
                                @endif
                            </td>
                        </tr>
                        <div class="modal fade" id="editVersionamento{{ $versionamento->id }}" tabindex="-1" aria-labelledby="editVersionamentoLabel{{ $versionamento->id }}" aria-hidden="true">
                            <div class="modal-dialog modal-lg modal-dialog-centered">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="editVersionamentoLabel{{ $versionamento->id }}">Editar Versionamento</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fechar"></button>
                                    </div>
                                    <div class="modal-body">
                                        <form action="{{ route('versionamentos.update', $versionamento->id) }}" method="POST">
                                            @csrf
                                            @method('PUT')
                                            <div class="mb-3">
                                                <label for="titulo" class="form-label">Título</label>
                                                <input type="text" name="titulo" id="titulo" class="form-control" value="{{ $versionamento->titulo }}" required>
                                            </div>
                                            <div class="mb-3">
                                                <label for="descricao" class="form-label">Descrição</label>
                                                <textarea name="descricao" id="descricao" class="form-control" rows="3" required>{!! $versionamento->descricao  !!}</textarea>
                                            </div>
                                            <div class="d-flex justify-content-end">
                                                <button type="submit" class="btn btn-success">Salvar</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal fade" id="deleteModal{{ $versionamento->id }}" tabindex="-1" aria-labelledby="deleteModalLabel{{ $versionamento->id }}" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="deleteModalLabel{{ $versionamento->id }}">Confirmar Exclusão</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        Tem certeza que deseja excluir este versionamento?
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="secondary" data-bs-dismiss="modal">Cancelar</button>
                                        <form action="{{ route('versionamentos.destroy', $versionamento->id) }}" method="POST">
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
<div class="modal fade" id="insertVersionamento" tabindex="-1" aria-labelledby="insertVersionamentoLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="insertVersionamentoLabel">Inserir Versionamento</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fechar"></button>
            </div>
            <div class="modal-body">
                <form action="{{ route('versionamentos.store') }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label for="titulo" class="form-label">Título</label>
                        <input type="text" name="titulo" id="titulo" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label for="descricao" class="form-label">Descrição</label>
                        <textarea name="descricao" id="descricao" class="form-control" rows="3" required></textarea>
                    </div>
                    <div class="d-flex justify-content-end">
                        <button type="submit" class="btn btn-success">Salvar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection