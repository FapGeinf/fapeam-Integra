<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8" />
    <title>Relatório do Eixo</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            font-size: 13pt;
            margin: 30px 40px;
            color: #212529;
            line-height: 1.6;
            background-color: #ffffff;
        }

        h2 {
            text-align: center;
            font-size: 26px;
            margin-bottom: 30px;
            color: #2c3e50;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        .atividade {
            background-color: #fafafa;
            padding: 25px 30px;
            margin-bottom: 40px;
            border: 1.5px solid #ced4da;
            border-radius: 8px;
            box-shadow: 0 2px 8px rgb(0 0 0 / 0.05);
        }

        .atividade h3 {
            font-size: 20px;
            background-color: #34495e;
            color: #ecf0f1;
            padding: 14px 22px;
            margin-top: 0;
            margin-bottom: 24px;
            font-weight: 700;
            border-radius: 8px;
            letter-spacing: 0.03em;
        }

        .linha {
            display: flex;
            flex-wrap: wrap;
            gap: 20px;
            margin-bottom: 20px;
        }

        .campo {
            flex: 1 1 250px;
        }

        .campo strong {
            display: block;
            font-weight: 700;
            color: #2c3e50;
            margin-bottom: 6px;
        }

        .input-curto {
            background: #fff;
            border: 1px solid #ced4da;
            border-radius: 6px;
            padding: 10px 14px;
            font-size: 14px;
            box-shadow: inset 0 1px 3px rgb(0 0 0 / 0.1);
        }

        .campo-texto {
            margin-top: 10px;
            background: #fff;
            border: 1px solid #ced4da;
            border-radius: 6px;
            padding: 14px 18px;
            color: #2f3640;
            font-size: 14.5px;
            line-height: 1.5;
            white-space: pre-wrap;
            box-shadow: inset 0 1px 3px rgb(0 0 0 / 0.1);
            margin-bottom: 20px;
        }

        @media (max-width: 768px) {
            .linha {
                flex-direction: column;
            }

            body {
                margin: 20px 15px;
                font-size: 12pt;
            }

            h2 {
                font-size: 20px;
                margin-bottom: 24px;
            }
        }
    </style>
</head>

<body>
    <h2>Relatório de Atividades - Eixo: {{ $eixoNome }}</h2>

    @foreach($atividades as $index => $atividade)
        <div class="atividade">
            <h3>Atividade {{ $index + 1 }}</h3>

            <!-- CAMPOS CURTOS - AGRUPADOS -->
            <div class="linha">
                <div class="campo">
                    <strong>Público</strong>
                    <div class="input-curto">{{ $atividade->publico->nome }}</div>
                </div>

                <div class="campo">
                    <strong>Tipo de Evento</strong>
                    <div class="input-curto">
                        @switch($atividade->tipo_evento)
                            @case(1) Presencial @break
                            @case(2) Online @break
                            @case(3) Presencial e Online @break
                            @default Sem evento
                        @endswitch
                    </div>
                </div>

                <div class="campo">
                    <strong>Canal</strong>
                    <div class="input-curto">{{ $atividade->canais->pluck('nome')->implode(', ') ?: '-' }}</div>
                </div>
            </div>

            <div class="linha">
                <div class="campo">
                    <strong>Data Prevista</strong>
                    <div class="input-curto">{{ \Carbon\Carbon::parse($atividade->data_prevista)->format('d/m/Y') }}</div>
                </div>

                <div class="campo">
                    <strong>Data Realizada</strong>
                    <div class="input-curto">
                        {{ $atividade->data_realizada ? \Carbon\Carbon::parse($atividade->data_realizada)->format('d/m/Y') : '-' }}
                    </div>
                </div>

                <div class="campo">
                    <strong>Responsável</strong>
                    <div class="input-curto">{{ $atividade->responsavel }}</div>
                </div>
            </div>

            <div class="linha">
                <div class="campo">
                    <strong>Meta</strong>
                    <div class="input-curto">{{ $atividade->meta }}</div>
                </div>

                <div class="campo">
                    <strong>Realizado</strong>
                    <div class="input-curto">{{ $atividade->realizado }}</div>
                </div>

                <div class="campo">
                    <strong>Medida</strong>
                    <div class="input-curto">{{ $atividade->medida->nome }}</div>
                </div>
            </div>

            <!-- CAMPOS LONGOS - AO FINAL -->
            <div style="margin-top: 25px;">
                <strong>Descrição da Atividade</strong>
                <div class="campo-texto">
                    {!! $atividade->atividade_descricao !!}
                </div>
            </div>

            @if($atividade->objetivo)
                <div>
                    <strong>Objetivo</strong>
                    <div class="campo-texto">
                        {!! $atividade->objetivo !!}
                    </div>
                </div>
            @endif

            @if($atividade->justificativa)
                <div>
                    <strong>Justificativa</strong>
                    <div class="campo-texto">
                        {!! $atividade->justificativa !!}
                    </div>
                </div>
            @endif
        </div>
    @endforeach
</body>

</html>
