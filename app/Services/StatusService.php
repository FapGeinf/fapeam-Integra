<?php

namespace App\Services;

use App\Models\Monitoramento;
use Illuminate\Support\Facades\Log;
use Exception;

class StatusService
{
    public function getRiscosPorStatus(string $status)
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

            return [
                'monitoramentos' => $todosMonitoramentos,
                'monitoramentosDaUnidade' => $monitoramentosDaUnidade,
                'userUnit' => $userUnit
            ];
        } catch (Exception $e) {
            Log::error('Erro em StatusService@getRiscosPorStatus', ['error' => $e->getMessage()]);
            throw new Exception('Erro ao obter riscos por status.');
        }
    }
}
