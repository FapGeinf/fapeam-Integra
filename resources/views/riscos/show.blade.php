@extends('layouts.app')
@section('content')

@section('title')
    {{ 'Detalhes do Risco' }}
@endsection

<link rel="stylesheet" href="{{ asset('css/show.css') }}">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>

<style>
    .liDP {
        margin-left: 0 !important;
    }


</style>

<script src="/ckeditor/ckeditor.js"></script>


<body>
    @if (session('error'))
        <script>
            alert('{{ session('error') }}');
        </script>
    @endif

    <div class="container-xxl pt-5">
        <div class="col-12 border box-shadow">
            <h5 class="text-center mb-3">Detalhamento do Risco Inerente</h5>

            <div>
                <table class="table table-bordered mb-4">
                    <thead>
                        <tr>
                            <th scope="col" style="white-space: nowrap; width: 100px;" class="text-center text-light tBorder">N° Risco</th>
                            <th scope="col" class="text-center text-light tBorder">Evento:</th>
                            <th scope="col" class="text-center text-light tBorder">Causa:</th>
                            <th scope="col" class="text-center text-light tBorder">Consequência:</th>
                            <th scope="col" style="width: 100px;" class="text-center text-light">Avaliação:</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr class="text13">
                            <td class="text-center pb-1 tBorder">{!! $risco->id !!}</td>
                            <td class="pb-1 tBorder">{!! $risco->riscoEvento !!}</td>
                            <td class="pb-1 tBorder">{!! $risco->riscoCausa !!}</td>
                            <td class="pb-1 tBorder">{!! $risco->riscoConsequencia !!}</td>
                            @if ($risco->nivel_de_risco == 1)
                                <td class="bg-baixo riscoAvaliacao"><span class="fontBold">Baixo</span></td>
                            @elseif ($risco->nivel_de_risco == 2)
                                <td class="bg-medio riscoAvaliacao"><span class="fontBold">Médio</span></td>
                            @else
                                <td class="bg-alto riscoAvaliacao"><span class="fontBold">Alto</span></td>
                            @endif
                        </tr>
                    </tbody>
                </table> 
            </div>
        </div>
    </div>

    <div class="container-xxl">
        <div class="col-12 border box-shadow">
            <h5 class="text-center mb-3">Plano de ação</h5>
                <table class="table table-bordered mb-4">
                    <thead>
                        <tr>
                            <th scope="col" class="text-center text-light tBorder">Controle Sugerido:</th>
                            <th scope="col" class="text-center text-light">Data:</th>
                            <th scope="col" class="text-center text-light tBorder">Situação:</th>
                            <th scope="col" class="text-center text-light">Anexo:</th>
                            <th scope="col" class="text-center text-light">Modificado:</th>
                            <th scope="col" class="text-center text-light">Opções:</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($risco->monitoramentos as $monitoramento)
                            <tr>
                                <td class="text13 pb-1 tBorder">{!! $monitoramento->monitoramentoControleSugerido !!}</td>
                                <td style="white-space: nowrap;" class="text-center text-13 pb-1">
                                    {{ \Carbon\Carbon::parse($monitoramento->inicioMonitoramento)->format('d/m/Y') }} -
                                    {{ $monitoramento->fimMonitoramento ? \Carbon\Carbon::parse($monitoramento->fimMonitoramento)->format('d/m/Y') : 'Contínuo' }}
                                </td>
                                <td style="white-space: nowrap;" class="text-center text13 pb-1 tBorder">
                                    {!! $monitoramento->statusMonitoramento !!}</td>
                                <td class="text-center text13 pb-1 tBorder">
                                    @if ($monitoramento->anexoMonitoramento)
                                    <a href="{{ Storage::url($monitoramento->anexoMonitoramento) }}" 
                                        target="_blank" 
                                        class="button-download" 
                                        title="Visualizar Anexo">
                                         @if (strpos($monitoramento->anexoMonitoramento, '.pdf') !== false)
                                             <span class="file-icon">📄</span>
                                         @else
                                             <span class="file-icon">🖼️</span>
                                         @endif
                                         <span class="file-name">{{ basename($monitoramento->anexoMonitoramento) }}</span>
                                     </a>
                                     
                                    @else
                                        <div class="button-download no-file">
                                            <i class="bi bi-file-earmark-excel"></i>
                                            Nenhum anexo disponível   
                                        </div>
                                    @endif
                                </td>

                                <td class="text13 pb-1 tBorder text-center">{!!  \Carbon\Carbon::parse($monitoramento->updated_at)->format('d/m/Y H:i:s') !!}</td>

                                <td class="text-center">
                                    <div class="custom-actions-wrapper" id="actionsWrapper{{ $monitoramento->id }}">
                                        <button type="button" onclick="toggleActionsMenu({{ $monitoramento->id }})" class="custom-actions-btn">
                                            <i class="bi bi-three-dots-vertical"></i>
                                        </button>
                                        <div class="custom-actions-menu">
                                            <ul>
                                                @if (auth()->user()->unidade->unidadeTipo->id == 1)
                                                    <li>
                                                        <a href="{{ route('riscos.editMonitoramento', ['id' => $monitoramento->id]) }}">
                                                            <i class="bi bi-pencil me-2"></i>Editar
                                                        </a>
                                                    </li>

                                                    <li>
                                                        <button type="button" class="danger" data-bs-toggle="modal" data-bs-target="#excluirMonitoramento{{ $monitoramento->id }}">
                                                            <i class="bi bi-trash me-2"></i>Excluir
                                                        </button>
                                                    </li>
                                                @endif
                                                <li>
                                                    <a href="{{ route('riscos.respostas', ['id' => $monitoramento->id]) }}">
                                                        <i class="bi bi-eye me-2"></i>Visualizar
                                                    </a>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </td>
                                
                            </tr>

                            <script>
                                function toggleActionsMenu(id) {
                                    const wrapper = document.getElementById(`actionsWrapper${id}`);
                                    wrapper.classList.toggle('open');
                            
                                    // Fecha outros menus abertos
                                    document.querySelectorAll('.custom-actions-wrapper').forEach((el) => {
                                        if (el.id !== `actionsWrapper${id}`) {
                                            el.classList.remove('open');
                                        }
                                    });
                                }
                            
                                // Fecha o dropdown ao clicar fora
                                window.addEventListener('click', function (e) {
                                    document.querySelectorAll('.custom-actions-wrapper').forEach(wrapper => {
                                        if (!wrapper.contains(e.target)) {
                                            wrapper.classList.remove('open');
                                        }
                                    });
                                });
                            </script>
                            

                            <div class="modal fade" id="excluirMonitoramento{{ $monitoramento->id }}" tabindex="-1" aria-labelledby="excluirMonitoramentoLabel" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="excluirMonitoramentoLabel">Confirmar Exclusão do Controle Sugerido</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <p>Tem certeza que deseja excluir o Controle Sugerido?</p>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                                            <form action="{{ route('riscos.deleteMonitoramento', $monitoramento->id) }}" method="POST">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger">Excluir Monitoramento</button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </tbody>
                </table>

                <div class="text-center mb-4">
                    @if (Auth::user()->unidade->unidadeTipoFK == 1)
                        <a href="{{ route('riscos.edit', $risco->id) }}" class="warning">Editar Risco</a>
                        <a href="{{ route('riscos.edit-monitoramentos', ['id' => $risco->id]) }}" class="primary">Adicionar Controles Sugeridos</a>
                    @endif
                </div>
        </div>
    </div>

    <x-back-button/>

    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"></script>
    <!-- <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js"></script> -->

</body>

</html>
@endsection
