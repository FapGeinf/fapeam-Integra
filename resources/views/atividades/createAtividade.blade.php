@extends('layouts.app')
@section('title') {{ 'Nova Atividade' }} @endsection
@section('content')
<link rel="stylesheet" href="{{ asset('css/edit.css') }}">
<link href="{{ asset('css/choices.min.css') }}" rel="stylesheet">
<script src="{{ asset('js/choices.min.js') }}"></script>
<link rel="stylesheet" href="{{ asset('css/flatpickr.min.css') }}">
<script src="{{ asset('js/flatpickr.js') }}"></script>
<script src="{{ asset('js/pt.js') }}"></script>
<style>
    .form-label {
        margin-bottom: 0 !important;
    }

    .liDP {
        margin-left: 0 !important;
    }
</style>
@section('title') {{ 'Nova Atividade' }} @endsection
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

    @if ($errors->any())
    <div class="alert alert-danger">
        <ul style="list-style:none;">
            @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif
</div>

<div class="form-wrapper pt-4 paddingLeft">
    <div class="form_create border">
        <h3 style="text-align: center; margin-bottom: 5px;">
            Insira sua Atividade
        </h3>

        <div class="tipWarning mb-3">
            <span class="asteriscoTop">*</span>
            Campos obrigatórios
        </div>

        <form action="{{ route('atividades.store') }}" method="POST">
            @csrf
            <div class="row g-3">
                <div class="col-12">
                    <label for="eixo_ids" class="form-label"> <span class="asteriscoTop">*</span>Eixos:</label>
                    <select name="eixo_ids[]" id="eixo_ids" class="form-select" multiple>
                        <option disabled>Selecione os Eixos</option>
                        @foreach ($eixos as $eixo)
                        <option value="{{ $eixo->id }}" {{ in_array($eixo->id, old('eixo_ids', [])) ? 'selected' : '' }}>
                            {{ 'Eixo ' . $loop->iteration . ' - ' . $eixo->nome }}
                        </option>
                        @endforeach
                    </select>
                </div>

                <div class="col-12">
                    <label for="responsavel" class="form-label">Responsável:</label>
                    <input name="responsavel" id="responsavel" class="form-control insert-resp">
                    {{ old('responsavel') }}
                    </input>
                </div>

                <script src="{{ asset('js/eixosChoices.js') }}"></script>

                <div class="col-12">
                    <label for="atividade_descricao" class="form-label"> <span class="asteriscoTop">*</span>Atividade:</label>
                    <textarea name="atividade_descricao" id="atividade_descricao" class="form-control" required>
                    {{ old('atividade_descricao') }}
                    </textarea>
                </div>

                <div class="col-12">
                    <label for="objetivo" class="form-label"> <span class="asteriscoTop">*</span>Objetivo:</label>
                    <textarea name="objetivo" id="objetivo" class="form-control" required>
                    {{ old('objetivo') }}
                    </textarea>
                </div>

                <div class="col-12 col-md-6">

                    <select name="publico_id" id="publico_id" class="form-select">
                        <option value="">Selecione o Público Alvo</option>
                        @foreach ($publicos as $publico)
                        <option value="{{ $publico->id }}" {{ old('publico_id') == $publico->id ? 'selected' : '' }}>
                            {{ $publico->nome }}
                        </option>
                        @endforeach
                        <option value="outros">Outros</option>
                    </select>

                    <div id="outros-input-container" style="display: none; margin-top: 10px;">
                        <label for="novo_publico" class="form-label">Insira o novo público:</label>
                        <input type="text" name="novo_publico" id="novo_publico" class="form-control">
                    </div>
                </div>

                <div class="col-12 col-md-6">
                    <select name="tipo_evento" id="tipo_evento" class="form-select">
                        <option value="0" {{ old('tipo_evento') == '0' || old('tipo_evento') === null ? 'selected' : '' }}>Sem evento
                        </option>
                        <option value="1" {{ old('tipo_evento') == '1' ? 'selected' : '' }}>Presencial</option>
                        <option value="2" {{ old('tipo_evento') == '2' ? 'selected' : '' }}>Online</option>
                        <option value="2" {{ old('tipo_evento') == '3' ? 'selected' : '' }}>Presencial e Online</option>
                    </select>
                </div>

                <div class="col-12">
                    <label for="canal_id" class="form-label">
                        Canal de Divulgação:
                    </label>
                    <select name="canal_id[]" id="canal_id" class="form-select" multiple onchange="toggleOtherField()">
                        <option value="">Selecione o Canal de Divulgação</option>
                        @foreach ($canais as $canal)
                        <option value="{{ $canal->id }}" {{ in_array($canal->id, old('canal_id', [])) ? 'selected' : '' }}>
                            {{ $canal->nome }}
                        </option>
                        @endforeach
                        <option value="outros">Novo Canal Divulgação (digite abaixo)</option>
                    </select>
                </div>


                <div class="col-12" id="novo_canal_div" style="display: none;">
                    <label for="novo_canal" class="form-label">
                        Novo Canal de Divulgação:
                    </label>
                    <input type="text" id="novo_canal" name="novo_canal" class="form-control" placeholder="Digite o novo canal">
                    <button type="button" class="btn btn-primary mt-2" onclick="criarCanal()">Criar Novo Canal</button>
                </div>

                <script>
                    function toggleOtherField() {
                        var select = document.getElementById('canal_id');
                        var novoCanalDiv = document.getElementById('novo_canal_div');

                        if (select.value == 'outros') {
                            novoCanalDiv.style.display = 'block';
                        } else {
                            novoCanalDiv.style.display = 'none';
                        }
                    }


                    function criarCanal() {
                        let novoCanal = document.getElementById('novo_canal').value;

                        if (novoCanal.trim() !== "") {
                            fetch('{{ route('
                                    canal.criar ') }}', {
                                        method: 'POST',
                                        headers: {
                                            'Content-Type': 'application/json',
                                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                                        },
                                        body: JSON.stringify({
                                            nome: novoCanal
                                        })
                                    })
                                .then(response => response.json())
                                .then(data => {
                                    let modalContent = document.getElementById('modalMessageContent');
                                    if (data.success) {
                                        let select = document.getElementById('canal_id');
                                        let option = document.createElement('option');
                                        option.value = data.canal.id;
                                        option.text = data.canal.nome;
                                        select.appendChild(option);

                                        let selectedOptions = Array.from(select.options).map(option => option.value);
                                        select.value = selectedOptions.includes(data.canal.id.toString()) ? data.canal.id : select.value;

                                        document.getElementById('novo_canal').value = '';
                                        document.getElementById('novo_canal_div').style.display = 'none';

                                        modalContent.innerHTML = 'Canal criado com sucesso!';
                                    } else {
                                        modalContent.innerHTML = 'Erro ao criar o canal: ' + data.message;
                                    }

                                    let myModal = new bootstrap.Modal(document.getElementById('modalMessage'));
                                    myModal.show();
                                })
                                .catch(error => {
                                    let modalContent = document.getElementById('modalMessageContent');
                                    modalContent.innerHTML = 'Ocorreu um erro ao criar o canal';


                                    let myModal = new bootstrap.Modal(document.getElementById('modalMessage'));
                                    myModal.show();
                                    console.error('Erro:', error);
                                });
                        } else {
                            let modalContent = document.getElementById('modalMessageContent');
                            modalContent.innerHTML = 'Por favor, insira o nome do canal.';


                            let myModal = new bootstrap.Modal(document.getElementById('modalMessage'));
                            myModal.show();
                        }
                    }
                </script>


                <div id="modalMessage" class="modal" tabindex="-1" aria-labelledby="modalMessageLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="modalMessageLabel">Mensagem</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body" id="modalMessageContent">
                                <!-- Mensagem será inserida aqui -->
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-12 col-md-6">
                    <label for="data_prevista" class="form-label">Data Prevista:</label>
                    <input type="date" name="data_prevista" id="data_prevista" class="form-control" value="{{ old('data_prevista') }}">
                </div>

                <div class="col-12 col-md-6">
                    <label for="data_realizada" class="form-label">
                        Data Realizada:
                    </label>
                    <input type="date" name="data_realizada" id="data_realizada" class="form-control" value="{{ old('data_realizada') }}">
                </div>

                <hr>

                <div class="col-g12">
                    <label for="indicador_ids[]">Indicadores</label>
                    <select name="indicador_ids[]" id="indicador_ids" class="form-select" multiple>
                        <option disabled>Selecione os Indicadores</option>
                        @foreach ($indicadores as $indicador)
                        <option value="{{ $indicador->id }}" {{ in_array($indicador->id, old('indicador_ids', [])) ? 'selected' : '' }}>
                            {{ $indicador->nomeIndicador }}
                        </option>
                        @endforeach
                    </select>
                </div>

                <div class="col-12 col-md-6">
                    <label for="meta" class="form-label">Previsto:</label>
                    <input type="number" name="meta" id="meta" class="form-control" min="0" value="{{ old('meta') }}" oninput="mostrarUnidade()">
                </div>

                <div class="col-12 col-md-6">
                    <label for="realizado" class="form-label">Realizado:</label>
                    <input type="number" name="realizado" id="realizado" class="form-control" min="0" value="{{ old('realizado') }}" oninput="mostrarUnidade()">
                </div>

                <div class="col-12 col-md-6" id="unidade-container" style="display: none;">
                    <label for="medida_id" class="form-label"> <span class="asteriscoTop">*</span>Tipo de Unidade:</label>
                    <select name="medida_id" id="medida_id" class="form-control">
                        <option value="">Selecione o Tipo de Unidade</option>
                        @foreach ($medidas as $medida)
                        <option value="{{ $medida->id }}" {{ old('medida_id') == $medida->id ? 'selected' : '' }}>
                            {{ $medida->nome }}
                        </option>
                        @endforeach
                    </select>
                </div>

                <div class="d-flex justify-content-end pt-3">
                    <button type="submit" class="btn btn-md btn-primary">Enviar a Atividade</button>
                </div>
            </div>
        </form>
    </div>
</div>
<script src="{{asset('ckeditor/ckeditor.js')}}"></script>
<script src="{{ asset('js/insertAtividade.js') }}"></script>
<script src="{{ asset('js/indicadoresChoices.js') }}"></script>
<script src="{{ asset('js/eixosChoices.js') }}"></script>
<script src="{{asset('js/choicesCanal.js')}}"></script>
@endsection