@extends('layouts.app')

@section('content')

@section('title') {{'Editar Formulário'}} @endsection
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Formulário de Risco</title>
    <link rel="stylesheet" href="{{asset('css/edit.css')}}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <script src="/ckeditor/ckeditor.js"></script>
</head>

<body>
    @if(session('error'))
    <script>
        alert('{{ session('
            error ') }}');
    </script>
    @endif

    <div class="error-message alertShow pt-4">
        @if($errors->any())
        <div class="alert alert-danger d-flex justify-content-center">
            @foreach ($errors->all() as $error )
            <span class="text-center">Houve um erro ao editar esse risco</span>
            @endforeach
        </div>
        @endif
    </div>

    <div class="form-wrapper pt-4">
        <div class="form_create">
            <h3 style="text-align: center; margin-bottom: 20px;">
                Editar Formulário de Risco
            </h3>
            <hr>

            <form action="{{ route('riscos.update', ['id' => $risco->id]) }}" method="post" id="formCreate">
                @csrf
                @method('PUT')
                <input type="hidden" name="risco_id" value="{{ $risco->id }}">

                <div class="row g-3 mb-3">
                    <div class="col-sm-4 col-md-4 mQuery">
                        <label for="name">Insira o Ano:</label>
                        <input type="text" id="riscoAno" name="riscoAno" class="form-control dataValue"
                            value="{{$risco->riscoAno}}" minlength="4" maxlength="4" >
                    </div>

                    <div class="col-sm-8 col-md-8 mQuery">
                        <label for="name">Responsável do Risco:</label>
                        <input type="text" id="responsavelRisco" name="responsavelRisco" class="form-control dataValue"
                            value="{{$risco->responsavelRisco ?? old('responsavelRisco')}}" maxlength="100">
                    </div>
                </div>

                <label id="first" for="riscoEvento">Evento:</label>
                <textarea name="riscoEvento" class="textInput"
                    required>{{ $risco->riscoEvento ?? old('riscoEvento') }}</textarea>

                <label for="riscoCausa">Causa:</label>
                <textarea name="riscoCausa" class="textInput"
                    required>{{ $risco->riscoCausa ?? old('riscoCausa')}}</textarea>

                <label for="riscoConsequencia">Consequência:</label>
                <textarea name="riscoConsequencia" class="textInput"
                    required>{{ $risco->riscoConsequencia ?? old('riscoConsequencia') }}</textarea>

                <div class="row g-3 mt-1">

                    <div class="row g-3">
                        <div class="col-sm-6 col-md-12">
                            <label for="nivel_de_risco">Nivel de Risco:</label>
                            <select name="nivel_de_risco" id="nivel_de_risco" required>
                                <option value="1">Baixo</option>
                                <option value="2">Médio</option>
                                <option value="3">Alto</option>
                            </select>
                            <div class="col-sm-8 col-md-12 mQuery">
                                <label for="unidadeId">Unidade:</label>
                                <select name="unidadeId" required>
                                    <option selected disabled>Selecione uma unidade</option>
                                    @foreach($unidades as $unidade)
                                    <option value="{{ $unidade->id }}"
                                        {{ isset($risco) && $risco->unidadeId == $unidade->id ? 'selected' : '' }}>
                                        {{ $unidade->unidadeNome }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="row g-3 mt-1">

                            <hr id="hr4">

                            <span id="tip">
                                <i class="bi bi-exclamation-circle-fill"></i>
                                Dica: Revise sua edição antes de salvar
                            </span>
                            <div class="mt-3 text-center mb-3">
                                <a href="{{ route('riscos.edit-monitoramentos', ['id' => $risco->id]) }}"
                                    class="btn btn-primary">Editar Monitoramentos</a>
                            </div>

                            <div id="btnSave">
                                <button type="button" onclick="showConfirmationModal()" class="submit-btn">Salvar Edição</button>
                            </div>

                            <div class="modal fade" id="confirmationModal" tabindex="-1" aria-labelledby="confirmationModalLabel" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="confirmationModalLabel">Confirmação de Edição</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <div id="modalContent">
                                                <!-- Conteúdo do modal será inserido dinamicamente aqui -->
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                                            <button type="button" onclick="submitForm()" class="btn btn-primary">Salvar</button>
                                        </div>
                                    </div>
                                </div>
                            </div>


            </form>
        </div>
    </div>

    <script>
        function showConfirmationModal() {
            // Captura dos dados do formulário
            let riscoAno = document.getElementById('riscoAno').value;
            let responsavelRisco = document.getElementById('responsavelRisco').value;
            let riscoEvento = CKEDITOR.instances.riscoEvento.getData();
            let riscoCausa = CKEDITOR.instances.riscoCausa.getData();
            let riscoConsequencia = CKEDITOR.instances.riscoConsequencia.getData();
            let nivel_de_risco = document.getElementById('nivel_de_risco').value;
            let unidadeId = document.querySelector('[name="unidadeId"]').options[document.querySelector('[name="unidadeId"]').selectedIndex].text;

            // Construção do HTML para o modal de confirmação
            let modalContent = `
                <p><strong>Ano:</strong> ${riscoAno}</p>
                <p><strong>Responsável do Risco:</strong> ${responsavelRisco}</p>
                <p><strong>Evento de Risco:</strong></p>
                <p>${riscoEvento}</p>
                <p><strong>Causa do Risco:</strong></p>
                <p>${riscoCausa}</p>
                <p><strong>Causa da Consequência:</strong></p>
                <p>${riscoConsequencia}</p>
                <p><strong>Nível de Risco:</strong> ${nivel_de_risco}</p>
                <p><strong>Unidade:</strong> ${unidadeId}</p>
                <hr>
                <p>Deseja realmente salvar as alterações?</p>
            `;

            // Inserção do conteúdo no modal de confirmação
            document.getElementById('modalContent').innerHTML = modalContent;

            // Exibir o modal de confirmação
            let confirmationModal = new bootstrap.Modal(document.getElementById('confirmationModal'));
            confirmationModal.show();
        }

        function submitForm() {
            document.getElementById('formCreate').submit();
        }

        CKEDITOR.replace('riscoEvento');
        CKEDITOR.replace('riscoCausa');
        CKEDITOR.replace('riscoConsequencia');
    </script>


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
@endsection
