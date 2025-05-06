<?php

namespace App\Http\Controllers;

use Exception;
use Illuminate\Http\Request;
use App\Models\Log as LogModel;
use Log;
use Carbon\Carbon;
use Barryvdh\DomPDF\Facade\Pdf;

class LogController extends Controller
{
      public function indexLogs()
      {
            $logs = LogModel::orderBy('created_at')->get();
            return view('logs.index', compact('logs'));
      }

      public function gerarRelatorioPorDia(Request $request)
      {
            try {
                  $validatedData = $request->validate([
                        'created_at' => 'required|date'
                  ], [
                        'created_at.required' => 'Por favor, você não pode deixar esse campo vazio',
                        'created_at.date' => 'Por favor, selecione uma data válida'
                  ]);

                  $dataSelecionada = Carbon::parse($validatedData['created_at']);

                  $logs = LogModel::whereBetween('created_at', [
                        $dataSelecionada->copy()->startOfDay(),
                        $dataSelecionada->copy()->endOfDay()
                  ])->orderBy('created_at', 'asc')->get();

                  $pdf = Pdf::loadView('pdfs.relatorioLogs', compact('logs'));

                  $nomeArquivo = 'relatorio_logs_' . $dataSelecionada->format('d_m_Y') . '.pdf';

                  return $pdf->download($nomeArquivo);

            } catch (Exception $e) {
                  Log::error('Houve um erro ao gerar o pdf',['error' => $e->getMessage()]);
                  return back()->withErrors(['erro' => 'Erro ao gerar relatório, verifique a data ou tente novamente' ]);    
            }
      }
}
