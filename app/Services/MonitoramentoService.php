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
        $monitoramentosCriados = [];


        $monitoramentos = isset($validatedData['monitoramentos']) ? $validatedData['monitoramentos'] : [$validatedData];

        foreach ($monitoramentos as $monitoramentoData) {
            $isContinuo = filter_var($monitoramentoData['isContinuo'], FILTER_VALIDATE_BOOLEAN);

            if (!$isContinuo && isset($monitoramentoData['fimMonitoramento']) && $monitoramentoData['fimMonitoramento'] <= $monitoramentoData['inicioMonitoramento']) {
                throw new Exception("O fim do monitoramento não pode ser anterior ao início.");
            }

            $path = null;
            if (!empty($monitoramentoData['anexoMonitoramento']) && $monitoramentoData['anexoMonitoramento']->isValid()) {
                $file = $monitoramentoData['anexoMonitoramento'];
                $filename = time() . '_' . $file->getClientOriginalName();
                $path = $file->storeAs('public/anexos', $filename);
            }

            $monitoramento = Monitoramento::create([
                'monitoramentoControleSugerido' => $monitoramentoData['monitoramentoControleSugerido'] ?? null,
                'statusMonitoramento' => $monitoramentoData['statusMonitoramento'],
                'inicioMonitoramento' => $monitoramentoData['inicioMonitoramento'],
                'fimMonitoramento' => $monitoramentoData['fimMonitoramento'] ?? null,
                'isContinuo' => $isContinuo,
                'riscoFK' => $riscoId,
                'anexoMonitoramento' => $path
            ]);

            $monitoramentosCriados[] = $monitoramento;
        }

        return [
            'monitoramentos' => $monitoramentosCriados
        ];
    }



    public function updateMonitoramento($id, array $validatedData)
    {
        $monitoramento = Monitoramento::findOrFail($id);

        $monitoramento->update([
            'monitoramentoControleSugerido' => $validatedData['monitoramentoControleSugerido'] ?? $monitoramento->monitoramentoControleSugerido,
            'statusMonitoramento' => $validatedData['statusMonitoramento'] ?? $monitoramento->statusMonitoramento,
            'isContinuo' => $validatedData['isContinuo'] ?? $monitoramento->isContinuo,
            'inicioMonitoramento' => $validatedData['inicioMonitoramento'] ?? $monitoramento->inicioMonitoramento,
            'fimMonitoramento' => $validatedData['fimMonitoramento'] ?? $monitoramento->fimMonitoramento,
        ]);

        Log::info('Monitoramento atualizado:', $monitoramento->toArray());

        if (!empty($validatedData['anexoMonitoramento']) && $validatedData['anexoMonitoramento']->isValid()) {
            Log::info('Novo anexo recebido.');

            if ($monitoramento->anexoMonitoramento) {
                Storage::delete($monitoramento->anexoMonitoramento);
                Log::info('Anexo antigo excluído:', ['path' => $monitoramento->anexoMonitoramento]);
            }

            $file = $validatedData['anexoMonitoramento'];
            $filename = time() . '_' . $file->getClientOriginalName();
            $path = $file->storeAs('public/anexos', $filename);

            Log::info('Novo arquivo enviado:', ['filename' => $filename, 'path' => $path]);

            $monitoramento->anexoMonitoramento = $path;
            $monitoramento->save();

            Log::info('Novo anexo salvo no monitoramento.', ['path' => $path]);
        } else {
            Log::info('Nenhum novo anexo recebido.');
        }

        Log::info('Atualização de monitoramento concluída com sucesso.');

        return $monitoramento;
    }

    public function deleteMonitoramento($id)
    {
        $monitoramento = Monitoramento::findOrFail($id);
        return $monitoramento->delete();
    }

    public function formEditMonitoramentos($id)
    {
        return $risco = Risco::findOrFail($id);
        ;
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