<?php

namespace App\Http\Controllers;

use App\Models\Risco;
use App\Models\Monitoramento;
use Illuminate\Http\Request;
use Log;
use Exception;

class StatusController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function implementadasShow()
    {
        try {
            return $this->showRiscos('IMPLEMENTADA', 'riscos.implementadas');
        } catch (Exception $e) {
            Log::error('Erro em implementadasShow', ['error' => $e->getMessage()]);
            return redirect()->back()->with('error', 'Erro ao carregar riscos implementadas.');
        }
    }

    public function implementadasParcialmenteShow()
    {
        try {
            return $this->showRiscos('IMPLEMENTADA PARCIALMENTE', 'riscos.implementadasParcialmente');
        } catch (Exception $e) {
            Log::error('Erro em implementadasParcialmenteShow', ['error' => $e->getMessage()]);
            return redirect()->back()->with('error', 'Erro ao carregar riscos parcialmente implementadas.');
        }
    }

    public function emImplementacaoShow()
    {
        try {
            return $this->showRiscos('EM IMPLEMENTAÇÃO', 'riscos.emImplementacao');
        } catch (Exception $e) {
            Log::error('Erro em emImplementacaoShow', ['error' => $e->getMessage()]);
            return redirect()->back()->with('error', 'Erro ao carregar riscos em implementação.');
        }
    }

    public function naoImplementadaShow()
    {
        try {
            return $this->showRiscos('NÃO IMPLEMENTADA', 'riscos.naoImplementada');
        } catch (Exception $e) {
            Log::error('Erro em naoImplementadaShow', ['error' => $e->getMessage()]);
            return redirect()->back()->with('error', 'Erro ao carregar riscos não implementadas.');
        }
    }

    private function showRiscos($status, $view)
    {
        try {
            $user = auth()->user();
            $userUnit = $user->unidade->unidadeTipoFK;

            if ($userUnit === 1) {
                $todosMonitoramentos = Monitoramento::where('statusMonitoramento', $status)->get();
                $monitoramentosDaUnidade = $todosMonitoramentos;
            } else {
                $monitoramentosDaUnidade = Monitoramento::whereHas('risco', function ($query) use ($userUnit) {
                    $query->where('unidadeId', $userUnit);
                })->where('statusMonitoramento', $status)->get();
                $todosMonitoramentos = collect();
            }

            return view($view, [
                'monitoramentos' => $todosMonitoramentos,
                'monitoramentosDaUnidade' => $monitoramentosDaUnidade,
                'userUnit' => $userUnit
            ]);
        } catch (Exception $e) {
            Log::error('Erro em showRiscos', ['error' => $e->getMessage()]);
            abort(500, 'Erro ao carregar os riscos.');
        }
    }

}
