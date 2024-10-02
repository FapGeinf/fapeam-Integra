<?php

namespace App\Http\Controllers;

use App\Models\Risco;
use App\Models\Monitoramento;
use Illuminate\Http\Request;

class StatusController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function implementadasShow()
    {
        return $this->showRiscos('IMPLEMENTADA', 'riscos.implementadas');
    }

    public function implementadasParcialmenteShow()
    {
        return $this->showRiscos('IMPLEMENTADA PARCIALMENTE', 'riscos.implementadasParcialmente');
    }

    public function emImplementacaoShow()
    {
        return $this->showRiscos('EM IMPLEMENTAÇÃO', 'riscos.emImplementacao');
    }

    public function naoImplementadaShow()
    {
        return $this->showRiscos('NÃO IMPLEMENTADA', 'riscos.naoImplementada');
    }

    private function showRiscos($status, $view)
    {
        $user = auth()->user();
        $userUnit = $user->unidade->unidadeTipoFK;

        if ($userUnit === 1) {
            $todosMonitoramentos = Monitoramento::where('statusMonitoramento', $status)->get();
            $monitoramentosDaUnidade = $todosMonitoramentos;
        } else {
            $monitoramentosDaUnidade = Monitoramento::whereHas('risco', function ($query) use ($userUnit) {
                $query->where('unidadeId', $userUnit);
            })->where('statusMonitoramento', $status)->get();
        }

        return view($view, [
            'monitoramentos' => $todosMonitoramentos ?? collect(),
            'monitoramentosDaUnidade' => $monitoramentosDaUnidade,
            'userUnit' => $userUnit
        ]);
    }
}
