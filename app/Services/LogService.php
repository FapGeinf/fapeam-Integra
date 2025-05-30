<?php

namespace App\Services;
use App\Models\Log as LogModel;
use Log;
use Carbon\Carbon;
use Barryvdh\DomPDF\Facade\Pdf;

class LogService
{
    public function getLogs()
    {
        $logs = LogModel::orderBy('created_at')->get();
        return $logs;
    }

    public function relatorioLogs(array $validatedData)
    {

        $dataSelecionada = Carbon::parse($validatedData['created_at']);

        $logs = LogModel::whereBetween('created_at', [
            $dataSelecionada->copy()->startOfDay(),
            $dataSelecionada->copy()->endOfDay()
        ])->orderBy('created_at', 'asc')->get();

        $pdf = Pdf::loadView('relatorios.relatorioLogs', compact('logs'));

        $nomeArquivo = 'relatorio_logs_' . $dataSelecionada->format('d_m_Y') . '.pdf';

        return $pdf->download($nomeArquivo);
    }

    public function insertLog(array $data)
    {
        return LogModel::create([
            'acao' => $data['acao'],
            'descricao' => $data['descricao'],
            'user_id' => $data['user_id']
        ]);
    }

}