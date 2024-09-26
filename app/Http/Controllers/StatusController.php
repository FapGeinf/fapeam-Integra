<?php

namespace App\Http\Controllers;

use App\Models\Risco;
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
            $todosRiscos = Risco::whereHas('monitoramentos', function ($query) use ($status) {
                $query->where('statusMonitoramento', $status);
            })->get();

            $riscosDaUnidade = $todosRiscos;
        } else {
            $riscosDaUnidade = Risco::where('unidadeId', $userUnit)
                ->whereHas('monitoramentos', function ($query) use ($status) {
                    $query->where('statusMonitoramento', $status);
                })->get();
        }

        return view($view, [
            'riscos' => $todosRiscos ?? collect(),
            'riscosDaUnidade' => $riscosDaUnidade,
            'userUnit' => $userUnit
        ]);
    }
}
