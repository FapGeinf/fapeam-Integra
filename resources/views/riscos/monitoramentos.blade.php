@extends('layouts.app')

@section('content')

@section('title', 'Editar Monitoramentos')

<head>
  <link rel="stylesheet" href="{{ asset('css/edit.css') }}">
  <script src="/ckeditor/ckeditor.js"></script>
</head>

<div class="form-wrapper pt-4">
    <div class="form_create">
      <h3 style="text-align: center; margin-bottom: 10px;">Formulário de Monitoramentos</h3>

      <div class="error-message">
          @if($errors->any())
               <div class="alert alert-danger">
                   <ul style="list-style-type:none;">
                       @foreach ($errors->all() as $error )
                           <li>{{$error}}</li>
                       @endforeach
                   </ul>
               </div>
           @endif
       </div>


      <form action="{{ route('riscos.update-monitoramentos', ['id' => $risco->id]) }}" method="POST" id="formCreate">
        @csrf
        @method('PUT')

        <div class="text-center">
          <span>Monitoramentos adicionados: </span>
          <span id="monitoramentoCounter">{{ count($risco->monitoramentos) }}</span>
        </div>

        <hr>

        @foreach($risco->monitoramentos as $index => $monitoramento)
          <div class="monitoramento">
            <span class="numeration">Monitoramento Nº {{ $index + 1 }}:</span>

            <textarea name="monitoramentos[{{ $index }}][monitoramentoControleSugerido]" placeholder="Monitoramento" class="textInput" id="monitoramentoControleSugerido{{ $index }}">{{ $monitoramento->monitoramentoControleSugerido }}</textarea>

            <div class="row g-3">
              <div class="col-sm-6 col-md-6">
                <label>Status do Monitoramento:</label>
                <select name="monitoramentos[{{ $index }}][statusMonitoramento]" class="textInput form-select" id="statusMonitoramento{{ $index }}">
                  <option value="NÃO IMPLEMENTADA" {{ $monitoramento->statusMonitoramento == 'NÃO IMPLEMENTADA' ? 'selected' : '' }}>NÃO IMPLEMENTADA</option>
                  <option value="EM IMPLEMENTAÇÃO" {{ $monitoramento->statusMonitoramento == 'EM IMPLEMENTAÇÃO' ? 'selected' : '' }}>EM IMPLEMENTAÇÃO</option>
                  <option value="IMPLEMENTADA PARCIALMENTE" {{ $monitoramento->statusMonitoramento == 'IMPLEMENTADA PARCIALMENTE' ? 'selected' : '' }}>IMPLEMENTADA PARCIALMENTE</option>
                  <option value="IMPLEMENTADA" {{ $monitoramento->statusMonitoramento == 'IMPLEMENTADA' ? 'selected' : '' }}>IMPLEMENTADA</option>
                </select>
              </div>

              <div class="col-sm-6 col-md-6">
                <label>Monitoramento Contínuo:</label>
                <select name="monitoramentos[{{ $index }}][isContinuo]" class="form-select" id="isContinuo{{ $index }}">
                  <option value="1" {{ $monitoramento->isContinuo == 1 ? 'selected' : '' }}>Sim</option>
                  <option value="0" {{ $monitoramento->isContinuo == 0 ? 'selected' : '' }}>Não</option>
                </select>
              </div>
            </div>

            <div class="row g-3">
              <div class="col-sm-12 col-md-6">
                <label>Início do Monitoramento:</label>
                <input type="date" name="monitoramentos[{{ $index }}][inicioMonitoramento]" class="textInput bgDateMon dateInput" value="{{ $monitoramento->inicioMonitoramento }}">
              </div>

              <div class="col-sm-12 col-md-6 mQuery2" id="fimMonitoramentoContainer{{ $index }}">
                <label>Fim do Monitoramento:</label>
                <input type="date" name="monitoramentos[{{ $index }}][fimMonitoramento]" class="textInput dateInput" id="fimMonitoramento{{ $index }}" value="{{ $monitoramento->fimMonitoramento }}">
              </div>
            </div>

          </div>

          <script>
            CKEDITOR.replace(`monitoramentoControleSugerido{{ $index }}`);

            document.addEventListener('DOMContentLoaded', function() {
              let isContinuoSelect = document.getElementById('isContinuo{{ $index }}');
              let fimMonitoramentoContainer = document.getElementById('fimMonitoramentoContainer{{ $index }}');

              function toggleFimMonitoramento() {
                if (isContinuoSelect.value == 1) {
                  fimMonitoramentoContainer.style.display = 'none';
                } else {
                  fimMonitoramentoContainer.style.display = 'block';
                }
              }

              toggleFimMonitoramento();

              isContinuoSelect.addEventListener('change', toggleFimMonitoramento);
            });
          </script>
        @endforeach

        <div id="monitoramentosDiv" class="monitoramento">
            <!-- Aqui serão adicionados os monitoramentos dinamicamente -->
        </div>

        <div class="buttons">
          <button type="button" class="add-btn" onclick="addMonitoramento()">Adicionar Monitoramento</button>
          <button type="button" class="close-btn" onclick="fecharFormulario()">Excluir</button>
        </div>

        <hr id="hr3">

        <span id="tip">
          <i class="bi bi-exclamation-circle-fill"></i>
          Dica: Revise sua edição antes de salvar
        </span>
        <div id="btnSave">
          <button type="button" onclick="showConfirmationModal()" class="submit-btn" data-bs-toggle="modal" data-bs-target="#confirmationModal">Salvar</button>
        </div>

          <!-- Modal de Confirmação -->
          <div class="modal fade" id="confirmationModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
              <div class="modal-dialog modal-dialog-centered">
              <div class="modal-content">
                  <div class="modal-header">
                  <h5 class="modal-title" id="exampleModalLabel">Confirmação de Edição</h5>
                  <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                  </div>
                  <div class="modal-body" id="modalContent">

                  </div>
                  <div class="modal-footer">
                  <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                  <button type="button" onclick="submitForm()" class="btn btn-success" id="btnEdit">Confirmar Edição</button>
                  </div>
              </div>
              </div>
          </div>
      </form>
    </div>
  </div>


<script>
  let cont = {{ count($risco->monitoramentos) }};
  let monitoramentoCounter = document.getElementById('monitoramentoCounter');

  function updateCounter() {
    monitoramentoCounter.textContent = cont;
  }

  function addMonitoramento() {
    let monitoramentosDiv = document.getElementById('monitoramentosDiv');
    let monitoramentoDiv = document.createElement('div');
    monitoramentoDiv.classList.add('monitoramento');

    let numeration = document.createElement('span');
    numeration.classList.add('numeration');
    numeration.textContent = `Monitoramento Nº ${cont + 1}`;
    monitoramentoDiv.appendChild(numeration);

    let controleSugerido = document.createElement('textarea');
    controleSugerido.name = `monitoramentos[${cont}][monitoramentoControleSugerido]`;
    controleSugerido.placeholder = 'Monitoramento';
    controleSugerido.classList.add('textInput');
    controleSugerido.id = `monitoramentoControleSugerido${cont}`;

    let statusMonitoramentoLabel = document.createElement('label');
    statusMonitoramentoLabel.textContent = 'Status do Monitoramento:';
    let statusMonitoramento = document.createElement('select');
    statusMonitoramento.name = `monitoramentos[${cont}][statusMonitoramento]`;
    statusMonitoramento.classList.add('textInput');
    statusMonitoramento.id = `statusMonitoramento${cont}`;

    let options = [
      { value: "NÃO IMPLEMENTADA", text: "NÃO IMPLEMENTADA" },
      { value: "EM IMPLEMENTAÇÃO", text: "EM IMPLEMENTAÇÃO" },
      { value: "IMPLEMENTADA PARCIALMENTE", text: "IMPLEMENTADA PARCIALMENTE" },
      { value: "IMPLEMENTADA", text: "IMPLEMENTADA" }
    ];

    options.forEach(function(optionData) {
      let option = document.createElement('option');
      option.value = optionData.value;
      option.text = optionData.text;
      statusMonitoramento.appendChild(option);
    });

    let divIsContinuo = document.createElement('div');
    divIsContinuo.classList.add('form-group');

    let labelIsContinuo = document.createElement('label');
    labelIsContinuo.textContent = 'Monitoramento Contínuo:';
    divIsContinuo.appendChild(labelIsContinuo);

    let selectIsContinuo = document.createElement('select');
    selectIsContinuo.name = `monitoramentos[${cont}][isContinuo]`;
    selectIsContinuo.classList.add('form-select');
    selectIsContinuo.id = `isContinuo${cont}`;

    let optionNao = document.createElement('option');
    optionNao.value = 0;
    optionNao.textContent = 'Não';
    selectIsContinuo.appendChild(optionNao);

    let optionSim = document.createElement('option');
    optionSim.value = 1;
    optionSim.textContent = 'Sim';
    selectIsContinuo.appendChild(optionSim);

    divIsContinuo.appendChild(selectIsContinuo);

    let rowDiv = document.createElement('div');
    rowDiv.classList.add('row', 'g-3');

    let colDiv1 = document.createElement('div');
    colDiv1.classList.add('col-sm-12', 'col-md-6');
    let inicioMonitoramentoLabel = document.createElement('label');
    inicioMonitoramentoLabel.textContent = 'Início do Monitoramento:';
    let inicioMonitoramento = document.createElement('input');
    inicioMonitoramento.type = 'date';
    inicioMonitoramento.name = `monitoramentos[${cont}][inicioMonitoramento]`;
    inicioMonitoramento.classList.add('textInput', 'dateInput');
    inicioMonitoramento.required = true;
    colDiv1.appendChild(inicioMonitoramentoLabel);
    colDiv1.appendChild(inicioMonitoramento);

    let colDiv2 = document.createElement('div');
    colDiv2.classList.add('col-sm-12', 'col-md-6', 'mQuery2');
    let fimMonitoramentoLabel = document.createElement('label');
    fimMonitoramentoLabel.textContent = 'Fim do Monitoramento:';
    let fimMonitoramento = document.createElement('input');
    fimMonitoramento.type = 'date';
    fimMonitoramento.name = `monitoramentos[${cont}][fimMonitoramento]`;
    fimMonitoramento.classList.add('textInput', 'dateInput');
    colDiv2.appendChild(fimMonitoramentoLabel);
    colDiv2.appendChild(fimMonitoramento);

    selectIsContinuo.addEventListener('change', function() {
      if (this.value == 1) {
        fimMonitoramento.value = '';
        colDiv2.style.display = 'none';
      } else {
        colDiv2.style.display = 'block';
      }
    });

    rowDiv.appendChild(colDiv1);
    rowDiv.appendChild(colDiv2);

    monitoramentoDiv.appendChild(controleSugerido);
    monitoramentoDiv.appendChild(statusMonitoramentoLabel);
    monitoramentoDiv.appendChild(statusMonitoramento);
    monitoramentoDiv.appendChild(divIsContinuo);
    monitoramentoDiv.appendChild(rowDiv);

    monitoramentosDiv.appendChild(monitoramentoDiv);

    CKEDITOR.replace(`monitoramentoControleSugerido${cont}`);

    cont++;
    updateCounter();
}


  function fecharFormulario() {
    document.getElementById('monitoramentosDiv').innerHTML = '';
    cont = 0;
    updateCounter();
  }

  updateCounter();
  CKEDITOR.replace('riscoEvento');
  CKEDITOR.replace('riscoCausa');
  CKEDITOR.replace('riscoConsequencia');

  @foreach($risco->monitoramentos as $index => $monitoramento)
    CKEDITOR.replace(`monitoramentoControleSugerido{{ $index }}`);

    let isContinuo{{ $index }} = document.getElementById(`isContinuo{{ $index }}`);
    let fimMonitoramento{{ $index }} = document.getElementById(`fimMonitoramentoContainer{{ $index }}`);

    isContinuo{{ $index }}.addEventListener('change', function() {
      if (this.value == 1) {
        fimMonitoramento{{ $index }}.style.display = 'none';
      } else {
        fimMonitoramento{{ $index }}.style.display = 'block';
      }
    });

  @endforeach




    function showConfirmationModal() {
        let modalContent = document.getElementById('modalContent');
        let confirmButton = document.getElementById('btnEdit');
        modalContent.innerHTML = '';

        function formatarDataParaBrasileiro(data) {
            if (data) {
                const partes = data.split('-');
                return `${partes[2]}/${partes[1]}/${partes[0]}`;
            }
            return '';
        }

        let monitoramentos = document.querySelectorAll('.monitoramento');
        let hasError = false;

        console.log('Number of monitoramentos found:', monitoramentos.length); // Debugging

        monitoramentos.forEach((monitoramento, index) => {
            let monitoramentoControleSugerido = CKEDITOR.instances[`monitoramentoControleSugerido${index}`].getData();
            let statusMonitoramento = monitoramento.querySelector(`select[name^="monitoramentos[${index}][statusMonitoramento]"]`).value;
            let isContinuo = monitoramento.querySelector(`select[name^="monitoramentos[${index}][isContinuo]"]`).value;
            let inicioMonitoramento = monitoramento.querySelector(`input[name^="monitoramentos[${index}][inicioMonitoramento]"]`).value;
            let fimMonitoramento = monitoramento.querySelector(`input[name^="monitoramentos[${index}][fimMonitoramento]"]`).value;

            console.log(`Monitoramento ${index + 1}:`, {
                monitoramentoControleSugerido,
                statusMonitoramento,
                isContinuo,
                inicioMonitoramento,
                fimMonitoramento
            }); // Debugging

            let errors = [];

            if (!monitoramentoControleSugerido) {
                errors.push('Controle Sugerido');
            }
            if (!statusMonitoramento) {
                errors.push('Status do Monitoramento');
            }
            if (!inicioMonitoramento) {
                errors.push('Início do Monitoramento');
            }

            if (isContinuo == '0' && !fimMonitoramento) {
                errors.push('Fim do Monitoramento');
            }

            if (errors.length > 0) {
                modalContent.innerHTML += `
                    <p class="text-danger">Monitoramento Nº ${index + 1} possui os seguintes campos obrigatórios não preenchidos: ${errors.join(', ')}.</p>
                    <div class="row g-3 mb-3">
                        <div class="col-sm-12">
                            <div style="padding-right: 5px; font-weight: bold;">Monitoramento N° ${index + 1}</div>
                        </div>

                        <div class="col-sm-6">
                            <div style="padding-right: 5px;">Controle Sugerido:</div>
                            <div style="background:#f0f0f0; overflow-wrap: break-word;" class="form-control">${monitoramentoControleSugerido || '<span class="text-danger">Campo obrigatório</span>'}</div>
                        </div>

                        <div class="col-sm-6">
                            <div style="padding-right: 5px;">Status do Monitoramento:</div>
                            <div style="background:#f0f0f0; overflow-wrap: break-word;" class="form-control">${statusMonitoramento || '<span class="text-danger">Campo obrigatório</span>'}</div>
                        </div>

                        <div class="col-sm-6">
                            <div style="padding-right: 5px;">Início do Monitoramento:</div>
                            <div style="background:#f0f0f0; overflow-wrap: break-word;" class="form-control">${inicioMonitoramento || '<span class="text-danger">Campo obrigatório</span>'}</div>
                        </div>

                        <div class="col-sm-6">
                            <div style="padding-right: 5px;">Fim do Monitoramento:</div>
                            <div style="background:#f0f0f0; overflow-wrap: break-word;" class="form-control">${fimMonitoramento || (isContinuo == '0' ? '<span class="text-danger">Campo obrigatório</span>' : 'N/A')}</div>
                        </div>
                        
                    </div>
                `;
                hasError = true;
            } else {
                inicioMonitoramento = formatarDataParaBrasileiro(inicioMonitoramento);

                if (isContinuo == '1') {
                    fimMonitoramento = 'N/A';
                } else {
                    fimMonitoramento = fimMonitoramento ? formatarDataParaBrasileiro(fimMonitoramento) : 'N/A';
                }

                modalContent.innerHTML += `
                  <div class="row g-3 mb-3">
                    <span class="text-center">Monitoramento N° ${index + 1}</span>

                    <hr style="width: 40%">

                    <div class="col-sm-12">
                      <div>Controle Sugerido:</div>
                      <div class="modalBg modalOF form-control">
                        ${monitoramentoControleSugerido || '<span class="text-danger">Campo obrigatório</span>'}
                    </div>
                  </div>

                  <div class="row g-3 bm-3">
                    <div class="col-sm-12">
                      <div>Situação do Monitoramento:</div>
                      <div class="modalBg modalOF form-control">
                        ${statusMonitoramento || '<span class="text-danger">Campo obrigatório</span>'}
                      </div>
                    </div>
                  </div>

                  <div class="row g-3 mb-3">
                    <div class="col-sm-6">
                      <div>Início do Monitoramento:</div>
                      <div class="modalBg form-control">
                        ${inicioMonitoramento || '<span class="text-danger">Campo obrigatório</span>'}
                      </div>
                    </div>

                    <div class="col-sm-6">
                      <div>
                        Fim do Monitoramento:
                      </div>

                      <div class="modalBg form-control">
                        ${fimMonitoramento || (isContinuo == '0' ? '<span class="text-danger">Campo obrigatório</span>' : 'N/A')}
                      </div>
                    </div>
                  </div>
                `;
              }

          if (hasError) {
            confirmButton.style.display = "none";
          } else {
            confirmButton.style.display = "block";
          }
        });
      }


    function submitForm() {
        document.getElementById('formCreate').submit();
    }

</script>

@endsection
