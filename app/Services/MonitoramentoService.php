<?php

namespace App\Services;
use App\Models\Monitoramento;
use Log;
use Exception;
use App\Models\Risco;

class MonitoramentoService
{
    public function formInsertMonitoramentos($id)
    {
        return Risco::findOrFail($id);
    }

    public function findMonitoramentoById($id)
    {
        return Monitoramento::findOrFail($id);
    }

    public function insertMonitoramentos(array $validatedData, $id)
    {
        $monitoramentos = [];
        $risco = Risco::findOrFail($id);

        foreach ($validatedData['monitoramentos'] as $index => $monitoramentoData) {
            $isContinuo = filter_var($monitoramentoData['isContinuo'], FILTER_VALIDATE_BOOLEAN);

            if (!$isContinuo && isset($monitoramentoData['fimMonitoramento']) && $monitoramentoData['fimMonitoramento'] <= $monitoramentoData['inicioMonitoramento']) {
                throw new Exception('Fim do monitoramento não pode ser anterior ao início do monitoramento.');
            }

            $monitoramento = Monitoramento::create([
                'monitoramentoControleSugerido' => $monitoramentoData['monitoramentoControleSugerido'],
                'statusMonitoramento' => $monitoramentoData['statusMonitoramento'],
                'inicioMonitoramento' => $monitoramentoData['inicioMonitoramento'],
                'fimMonitoramento' => $monitoramentoData['fimMonitoramento'] ?? null,
                'isContinuo' => $isContinuo,
                'riscoFK' => $risco->id,
            ]);

            $monitoramentos[] = $monitoramento;
        }

        return [
            'monitoramentos' => $monitoramentos,
            'risco' => $risco
        ];
    }

    public function updateMonitoramento($id, array $validatedData)
    {

        $monitoramento = Monitoramento::findOrFail($id);

        $monitoramento->update([
            'monitoramentoControleSugerido' => $validatedData['monitoramentoControleSugerido'],
            'statusMonitoramento' => $validatedData['statusMonitoramento'],
            'isContinuo' => $validatedData['isContinuo'],
            'inicioMonitoramento' => $validatedData['inicioMonitoramento'],
            'fimMonitoramento' => $validatedData['fimMonitoramento'],
        ]);

        Log::info('Monitoramento atualizado:', $monitoramento->toArray());


        Log::info('Atualização de controle sugerido concluída com sucesso.');

        return $monitoramento;
    }

    public function destroyMonitoramento($id)
    {
        $monitoramento = Monitoramento::findOrFail($id);
        $monitoramento->delete();
        return true;
    }
}