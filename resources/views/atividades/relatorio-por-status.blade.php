<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Relatório de Atividades</title>
    <style>
        @page {
            margin: 1.5cm 1.5cm 2cm 1.5cm;
        }
        
        body {
            font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif;
            color: #333;
            font-size: 11px;
            line-height: 1.4;
        }

        .header {
            width: 100%;
            border-bottom: 2px solid #1a365d;
            padding-bottom: 8px;
            margin-bottom: 15px;
        }

        .header table {
            width: 100%;
            border-collapse: collapse;
        }

        .logo-title {
            font-size: 18px;
            font-weight: bold;
            color: #1a365d;
            text-transform: uppercase;
        }

        .meta-info {
            text-align: right;
            font-size: 9px;
            color: #718096;
        }

        .report-title {
            text-align: center;
            margin-bottom: 20px;
        }

        .report-title h2 {
            margin: 0;
            color: #2d3748;
            font-size: 16px;
        }

        .status-badge {
            display: inline-block;
            background-color: #ebf8ff;
            color: #2b6cb0;
            padding: 2px 8px;
            border-radius: 10px;
            font-size: 10px;
            font-weight: bold;
            margin-top: 5px;
            border: 1px solid #bee3f8;
        }

        table.atividades-table {
            width: 100%;
            border-collapse: collapse;
        }

        table.atividades-table th {
            background-color: #1a365d;
            color: #ffffff;
            font-weight: bold;
            text-align: left;
            padding: 6px 8px;
            font-size: 10px;
            text-transform: uppercase;
        }

        table.atividades-table td {
            padding: 8px;
            border-bottom: 1px solid #e2e8f0;
            vertical-align: top;
        }

        .badge-item {
            display: inline-block;
            background-color: #edf2f7;
            color: #4a5568;
            padding: 1px 5px;
            border-radius: 3px;
            font-size: 9px;
            margin-right: 2px;
            margin-bottom: 2px;
        }

        .meta-text {
            font-size: 9px;
            color: #718096;
            margin-top: 3px;
        }

        .footer {
            position: fixed;
            bottom: -1cm;
            left: 0;
            right: 0;
            height: 25px;
            border-top: 1px solid #e2e8f0;
            text-align: center;
            font-size: 8px;
            color: #a0aec0;
            padding-top: 5px;
        }

        tr {
            page-break-inside: avoid;
        }

        .no-data {
            text-align: center;
            padding: 30px;
            background-color: #f7fafc;
            border: 1px dashed #cbd5e0;
            border-radius: 5px;
            color: #718096;
            font-style: italic;
        }
    </style>
</head>
<body>

    <div class="header">
        <table>
            <tr>
                <td class="logo-title">Sistema de Gestão de Atividades</td>
                <td class="meta-info">
                    <strong>Gerado em:</strong> {{ now()->format('d/m/Y H:i') }}<br>
                    <strong>Relatório Analítico por Status</strong>
                </td>
            </tr>
        </table>
    </div>

    <div class="report-title">
        <h2>Relatório de Atividades</h2>
        <span class="status-badge">
            Status: {{ $atividades->first()?->statusAtividade?->nome ?? 'Status Filtrado' }}
        </span>
    </div>

    @if($atividades->isEmpty())
        <div class="no-data">
            Nenhuma atividade cadastrada com este status no momento.
        </div>
    @else
        <table class="atividades-table">
            <thead>
                <tr>
                    <th style="width: 8%;">ID</th>
                    <th style="width: 37%;">Descrição / Objetivo</th>
                    <th style="width: 25%;">Eixos & Canais</th>
                    <th style="width: 15%;">Público-Alvo</th>
                    <th style="width: 15%;">Meta / Realizado</th>
                </tr>
            </thead>
            <tbody>
                @foreach($atividades as $atividade)
                    <tr>
                        <td>
                            <strong>#{{ $atividade->id }}</strong>
                            <div class="meta-text" style="font-weight: bold;">Resp: {{ $atividade->responsavel ?? 'N/I' }}</div>
                        </td>

                        <td>
                            <div style="font-weight: bold; color: #2d3748; font-size: 11px;">
                                {{ strip_tags($atividade->atividade_descricao) }}
                            </div>
                            
                            @if($atividade->objetivo)
                                <div class="meta-text" style="margin-top: 4px;">
                                    <strong>Objetivo:</strong> {{ Str::limit(strip_tags($atividade->objetivo), 150) }}
                                </div>
                            @endif
                            
                            @if($atividade->justificativa)
                                <div class="meta-text" style="color: #9b2c2c; margin-top: 4px;">
                                    <strong>Justificativa:</strong> {{ Str::limit(strip_tags($atividade->justificativa), 100) }}
                                </div>
                            @endif
                        </td>

                        <td>
                            <div style="margin-bottom: 5px;">
                                <strong style="font-size: 9px; color: #4a5568; display: block;">Eixos:</strong>
                                @forelse($atividade->eixos as $eixo)
                                    <span class="badge-item">{{ $eixo->nome }}</span>
                                @empty
                                    <span class="meta-text">Nenhum</span>
                                @endforelse
                            </div>
                            
                            <div>
                                <strong style="font-size: 9px; color: #4a5568; display: block;">Canais:</strong>
                                @forelse($atividade->canais as $canal)
                                    <span class="badge-item">{{ $canal->nome }}</span>
                                @empty
                                    <span class="meta-text">Nenhum</span>
                                @endforelse
                            </div>
                        </td>

                        <td>
                            <div>{{ $atividade->publico?->nome ?? 'Não Informado' }}</div>
                            <div class="meta-text">
                                <strong>Evento:</strong> {{ $atividade->tipo_evento == 1 ? 'Presencial' : 'Online' }}
                            </div>
                        </td>

                        <td>
                            <div><strong>Meta:</strong> {{ $atividade->meta ?? '0' }}</div>
                            <div style="color: #2f855a;"><strong>Realizado:</strong> {{ $atividade->realizado ?? '0' }}</div>
                            <div class="meta-text" style="font-size: 8px;">
                                Unid: {{ $atividade->medida?->nome ?? 'Quant.' }}
                            </div>
                            @if($atividade->data_realizada)
                                <div class="meta-text" style="font-size: 8px;">
                                    Em: {{ \Carbon\Carbon::parse($atividade->data_realizada)->format('d/m/Y') }}
                                </div>
                            @endif
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif

    <div class="footer">
        Relatório Analítico de Atividades por Status • Página Dinâmica
    </div>

</body>
</html>