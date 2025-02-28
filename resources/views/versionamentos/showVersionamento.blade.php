@extends('layouts.guest')
@section('content')
<link href="{{ asset('css/dataTables.dataTables.min.css') }}" rel="stylesheet" />
<script src="{{ asset('js/jquery-3.6.0.min.js') }}"></script>
<script src="{{ asset('js/dataTables.min.js') }}"></script>
<link rel="stylesheet" href="{{ asset('css/index.css') }}">
    
<div class="container-xl d-flex align-items-center justify-content-center mt-5 mb-5">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card rounded-2 shadow-sm border-1">
                <div class="card-header">
                    <h2 class="fw-bold text-center mt-2 mb-2">Versionamentos</h2>
                </div>
                <div class="row g-3 gap-3 px-3 py-2 mb-4">
                    <div class="col-md-6">
                        <label for="filter-data" class="fw-bold">Ordenar por Data Prevista</label>
                        <select name="filter-data" id="filter-data" class="form-select pointer">
                            <option value="asc">Mais Antiga</option>
                            <option value="desc">Mais Recente</option>
                        </select>
                    </div>
                </div>
                <div class="card-body">
                    @if (session('warning'))
                        <div class="alert alert-warning">
                            {{ session('warning') }}
                        </div>
                    @endif
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                    @if (session('success'))
                        <div class="alert alert-success">
                            {{ session('success') }}
                        </div>
                    @endif
                    <table class="table table-striped mt-3 mb-3" id="versionamentosTable">
                        <thead>
                            <tr>
                                <th>Título</th>
                                <th>Descrição</th>
                                <th>Data</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($versionamentos as $versionamento)
                                <tr>
                                    <td>{{ $versionamento->titulo }}</td>
                                    <td>{!! $versionamento->descricao !!}</td>
                                    <td>{{ \Carbon\Carbon::parse($versionamento->created_at)->format('d/m/Y') }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="text-center mt-4">
            <a href="{{ route('login')}}" class="btn btn-secondary"><i class="bi bi-arrow-left"></i></a>
        </div>
    </div>
</div>
<script>
$(document).ready(function() {
    let table = $('#versionamentosTable').DataTable({
        order: [[2, "asc"]],
        autoWidth: false,
        columnDefs: [{
            targets: "_all",
            defaultContent: ""
        }],
        language: {
            url: '{{ asset('js/pt_br-datatable.json') }}',
            search: "Procurar:",
            info: 'Mostrando página _PAGE_ de _PAGES_',
            infoEmpty: 'Sem registros disponíveis no momento',
            infoFiltered: '(Filtrados do total de _MAX_ registros)',
            zeroRecords: 'Nada encontrado. Se achar que isso é um erro, contate o suporte.',
            paginate: {
                next: "Próximo",
                previous: "Anterior"
            }
        }
    });

    $('#filter-data').on('change', function() {
        let order = $(this).val();
        table.order([2, order]).draw();
    });
});
</script>
@endsection
