<?php

namespace App\Http\Controllers;

use App\Http\Requests\RelatorioLogRequest;
use App\Services\LogService;
use Exception;
use Illuminate\Http\Request;
use App\Models\Log as LogModel;
use Log;
use Carbon\Carbon;
use Barryvdh\DomPDF\Facade\Pdf;

class LogController extends Controller
{
      protected $log;

      public function __construct(LogService $log)
      {
             $this->log = $log;
      }

      public function indexLogs()
      {
            try {
                  $logs = $this->log->getLogs();
                  return view('logs.index', compact('logs'));
            } catch (Exception $e) {
                  Log::error('Erro ao carregar logs:', ['error' => $e->getMessage()]);
                  return redirect()->back()->with('error', 'Erro ao carregar os logs.');
            }
      }

      public function gerarRelatorioPorDia(RelatorioLogRequest $request)
      {
            try{
                  $validatedData = $request->validated();
                  return  $this->log->relatorioLogs($validatedData);
            } catch (Exception $e) {
                  Log::error('Houve um erro ao gerar o pdf', ['error' => $e->getMessage()]);
                  return back()->withErrors(['erro' => 'Erro ao gerar relatório, verifique a data ou tente novamente']);
            }
      }

}
