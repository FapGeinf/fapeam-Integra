<?php

namespace App\Services;
use App\Models\Monitoramento;
use Exception;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use App\Models\Risco;

class MonitoramentoService
{

    public function storeMonitoramento(array $validatedData, $riscoId)
    {
        try {
            $monitoramentosCriados = [];

            $monitoramentos = isset($validatedData['monitoramentos']) ? $validatedData['monitoramentos'] : [$validatedData];

            foreach ($monitoramentos as $monitoramentoData) {
                $isContinuo = filter_var($monitoramentoData['isContinuo'], FILTER_VALIDATE_BOOLEAN);

                if (!$isContinuo && isset($monitoramentoData['fimMonitoramento']) && $monitoramentoData['fimMonitoramento'] <= $monitoramentoData['inicioMonitoramento']) {
                    throw new Exception("O fim do monitoramento não pode ser anterior ao início.");
                }

                $monitoramento = Monitoramento::create([
                    'monitoramentoControleSugerido' => $monitoramentoData['monitoramentoControleSugerido'] ?? null,
                    'statusMonitoramento' => $monitoramentoData['statusMonitoramento'],
                    'inicioMonitoramento' => $monitoramentoData['inicioMonitoramento'],
                    'fimMonitoramento' => $monitoramentoData['fimMonitoramento'] ?? null,
                    'isContinuo' => $isContinuo,
                    'riscoFK' => $riscoId,
                ]);

                $monitoramentosCriados[] = $monitoramento;
            }

            return ['monitoramentos' => $monitoramentosCriados];

        } catch (Exception $e) {
            Log::error('Erro ao criar monitoramento', [
                'error' => $e->getMessage(),
                'data' => $validatedData,
                'user_id' => auth()->id()
            ]);
            throw new Exception("Erro ao criar monitoramento.");
        }
    }



    public function updateMonitoramento($id, array $validatedData)
    {
        try {
            $monitoramento = Monitoramento::findOrFail($id);

            $monitoramento->update([
                'monitoramentoControleSugerido' => $validatedData['monitoramentoControleSugerido'] ?? $monitoramento->monitoramentoControleSugerido,
                'statusMonitoramento' => $validatedData['statusMonitoramento'] ?? $monitoramento->statusMonitoramento,
                'isContinuo' => $validatedData['isContinuo'] ?? $monitoramento->isContinuo,
                'inicioMonitoramento' => $validatedData['inicioMonitoramento'] ?? $monitoramento->inicioMonitoramento,
                'fimMonitoramento' => $validatedData['fimMonitoramento'] ?? $monitoramento->fimMonitoramento,
            ]);

            Log::info('Monitoramento atualizado:', $monitoramento->toArray());
            return $monitoramento;

        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            throw new Exception("Monitoramento não encontrado para o ID: {$id}");
        } catch (Exception $e) {
            Log::error('Erro ao atualizar o monitotoramento', [
                'error' => $e->getMessage(),
                'data' => $validatedData,
                'user_id' => auth()->id()
            ]);
            throw new Exception("Erro ao atualizar monitoramento." );
        }
    }

    public function deleteMonitoramento($id)
    {
        $monitoramento = Monitoramento::findOrFail($id);
        return $monitoramento->delete();
    }

    public function formEditMonitoramentos($id)
    {
        return $risco = Risco::findOrFail($id);
    }

    public function formEditMonitoramento($id)
    {

        $monitoramento = Monitoramento::findOrFail($id);

        Log::info('Editando monitoramento:', [
            'monitoramento' => $monitoramento->toArray(),
        ]);

        return $monitoramento;
    }


}