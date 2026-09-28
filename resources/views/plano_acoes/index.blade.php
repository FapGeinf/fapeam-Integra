@extends('layouts.app')
@section('title') {{ 'Lista de Planos de Ação' }} @endsection
@section('content')

<link rel="stylesheet" href="{{ asset('css/show.css') }}">
<link rel="stylesheet" href="{{ asset('css/tables.css') }}">
<link rel="stylesheet" href="{{ asset('css/buttons.css') }}">
<link rel="stylesheet" href="{{ asset('css/dropdown.css') }}">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
<script src="{{ asset('js/jquery-3.6.0.min.js') }}"></script>
<script src="{{ asset('js/dataTables.min.js') }}"></script>
<link rel="stylesheet" href="{{ asset('css/dataTables.dataTables.min.css') }}">
<script src="{{ asset('js/actionsDropdown.js') }}"></script>

<style>
    div.dt-container div.dt-layout-row {
        font-size: 13px;
    }
</style>

<x-alert-toast/>

<div class="container-xxl pt-5">
    <div class="col-12 border box-shadow rounded-4 bg-white p-4 shadow-sm">
    
        <div class="justify-content-center mb-4">
            <h5 class="text-center fw-bold text-dark mb-1">Planos de Ação</h5>
            <p class="text-center text-muted small mb-3">Gerencie e acompanhe as metas e ações estratégicas cadastradas.</p>
            
            <div class="d-flex justify-content-center">
                <a class="text-decoration-none highlighted-btn-sm highlight-success px-4 py-2 shadow-sm" href="{{ route('plano-acoes.create') }}">
                    <i class="bi bi-plus-circle me-1"></i>
                    Adicionar Plano de Ação
                </a>
            </div>
        </div>

        <div>
            <div class="table-responsive">
                <table class="table table-bordered table-striped align-middle">
                    <thead>
                        <tr class="text13">
                            <th class="text-center text-light bg-dark">#</th>
                            <th class="text-center text-light bg-dark">Biênio</th>
                            <th class="text-center text-light bg-dark">Eixo</th>
                            <th class="text-start text-light bg-dark">Objetivo</th>
                            <th class="text-center text-light bg-dark">Responsável</th>
                            <th class="text-center text-light bg-dark">Meta</th>
                            <th class="text-center text-light bg-dark" style="width: 140px;">Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($planos as $plano)
                            <tr class="text13">
                                <td class="text-center">{{ $plano->id }}</td>
                                <td class="text-center">
                                    <span class="badge bg-light text-secondary border px-2 py-1">{{ $plano->bienio ?? 'Não definido' }}</span>
                                </td>
                                <td class="text-center">{{ $plano->eixo->nome ?? 'N/A' }}</td>
                                <td class="text-start">{!! Str::limit($plano->objetivo, 50) !!}</td>
                                <td class="text-center">{{ $plano->responsavel->name ?? 'Não atribuído' }}</td>
                                <td class="text-center">{{ $plano->meta }}</td>
                                <td class="text-center">
                                    <div class="d-flex justify-content-center gap-1">
                                        <a href="{{ route('plano_acoes.show', $plano->id) }}" class="highlighted-btn-sm highlight-info text-decoration-none" title="Visualizar">
                                            <i class="bi bi-eye"></i>
                                        </a>
                                        <a href="{{ route('plano_acoes.edit', $plano->id) }}" class="highlighted-btn-sm highlight-warning text-decoration-none" title="Editar">
                                            <i class="bi bi-pencil"></i>
                                        </a>
                                        
                                        <!-- Botão que aciona o modal específico desta linha -->
                                        <button type="button" 
                                                class="highlighted-btn-sm highlight-danger border-0" 
                                                title="Excluir" 
                                                style="cursor: pointer;"
                                                data-bs-toggle="modal" 
                                                data-bs-target="#deleteModal{{ $plano->id }}">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>

                            
                            <div class="modal fade" id="deleteModal{{ $plano->id }}" tabindex="-1" aria-labelledby="deleteModalLabel{{ $plano->id }}" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered">
                                    <div class="modal-content border-0 shadow rounded-4">
                                        <div class="modal-header border-bottom px-4 py-3 bg-light rounded-top-4">
                                            <h5 class="modal-title fw-bold text-danger" id="deleteModalLabel{{ $plano->id }}">
                                                <i class="bi bi-exclamation-triangle-fill me-2"></i> Confirmar Exclusão
                                            </h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>

                                        <div class="modal-body p-4">
                                            <p class="text-dark mb-2">Tem certeza que deseja excluir o plano de ação <strong>{{ $plano->bienio }}</strong>?</p>
                                            <small class="text-danger d-block mt-3 fw-semibold">Esta ação não poderá ser desfeita.</small>
                                        </div>

                                        <div class="modal-footer border-top px-4 py-3 bg-light rounded-bottom-4">
                                            <button type="button" class="highlighted-btn-sm highlight-grey px-3" data-bs-dismiss="modal">
                                                <i class="bi bi-arrow-left me-1"></i> Cancelar
                                            </button>

                                            <form action="{{ route('plano-acoes.destroy', $plano->id) }}" method="POST" class="m-0 p-0">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="highlighted-btn-sm highlight-danger px-4">
                                                    <i class="bi bi-trash me-1"></i> Sim, excluir
                                                </button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center text-muted py-4">
                                    <i class="bi bi-folder2-open display-6 d-block mb-2 text-secondary opacity-50"></i>
                                    Nenhum plano de ação cadastrado até o momento.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<x-back-button/>
@endsection