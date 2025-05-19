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
        try {
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
        } catch (Exception $e) {
            Log::error('Houve um erro no processo de inserção de monitoramentos', ['error' => $e->getMessage()]);
            throw new Exception('Houve um erro no processo de inserção de controles sugeridos.');
        }
    }

    public function updateMonitoramento($id, array $validatedData)
    {
        try {
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

        } catch (Exception $e) {
            Log::error('Houve um erro inesperado ao atualizar o controle sugerido', ['error' => $e->getMessage(), 'monitoramento_id' => $id]);
            throw new Exception('Houve um erro ao atualizar o controle sugerido selecionado');
        }
    }

    public function destroyMonitoramento($id)
    {
        try {
            $monitoramento = Monitoramento::findOrFail($id);
            $monitoramento->delete();
            return true;
        } catch (Exception $e) {
            Log::error('Houve um erro inesperado ao deletar o controle sugerido selecionado.', ['error' => $e->getMessage(), 'monitoramento_id' => $id]);
            throw new Exception('Houve um erro inesperado ao deletar o controle sugerido selecionado.');
        }
    }
}