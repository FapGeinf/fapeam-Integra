<?php

namespace App\Services;
use App\Models\Monitoramento;
use Exception;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use App\Models\Risco;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\QueryException;
;
use Throwable;


class MonitoramentoService
{

    public function storeMonitoramento(array $validatedData, $riscoId)
    {
        try {
            $monitoramentosCriados = [];


            $monitoramentos = $validatedData['monitoramentos'] ?? [$validatedData];

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

            Log::info('Monitoramento(s) criado(s) com sucesso', ['monitoramentos' => $monitoramentosCriados]);

            return ['monitoramentos' => $monitoramentosCriados];

        } catch (QueryException $e) {
            Log::error('Erro no banco de dados ao criar monitoramento', [
                'error' => $e->getMessage(),
                'data' => $validatedData,
                'user_id' => auth()->id()
            ]);
            throw new Exception("Erro ao salvar monitoramento no banco de dados.", 500);
        } catch (Throwable $e) {
            Log::error('Erro inesperado ao criar monitoramento', [
                'error' => $e->getMessage(),
                'data' => $validatedData,
                'user_id' => auth()->id()
            ]);
            throw new Exception("Ocorreu um erro inesperado ao criar monitoramento.", 500);
        }
    }


    public function updateMonitoramento($id, array $validatedData)
    {
        try {
            $monitoramento = Monitoramento::findOrFail($id);

            $monitoramento->update([
                'monitoramentoControleSugerido' => $validatedData['monitoramentoControleSugerido'] ?? $monitoramento->monitoramentoControleSugerido,
                'statusMonitoramento' => $validatedData['statusMonitoramento'] ?? $monitoramento->statusMonitoramento,
                'isContinuo' => isset($validatedData['isContinuo']) ? filter_var($validatedData['isContinuo'], FILTER_VALIDATE_BOOLEAN) : $monitoramento->isContinuo,
                'inicioMonitoramento' => $validatedData['inicioMonitoramento'] ?? $monitoramento->inicioMonitoramento,
                'fimMonitoramento' => $validatedData['fimMonitoramento'] ?? $monitoramento->fimMonitoramento,
            ]);

            Log::info('Monitoramento atualizado com sucesso', ['monitoramento' => $monitoramento]);

            return $monitoramento;

        } catch (ModelNotFoundException $e) {
            Log::warning("Monitoramento não encontrado", ['id' => $id]);
            throw new Exception("Monitoramento não encontrado para o ID: {$id}", 404);
        } catch (QueryException $e) {
            Log::error('Erro no banco ao atualizar monitoramento', [
                'error' => $e->getMessage(),
                'data' => $validatedData,
                'user_id' => auth()->id()
            ]);
            throw new Exception("Erro ao atualizar monitoramento no banco de dados.", 500);
        } catch (Throwable $e) {
            Log::error('Erro inesperado ao atualizar monitoramento', [
                'error' => $e->getMessage(),
                'data' => $validatedData,
                'user_id' => auth()->id()
            ]);
            throw new Exception("Ocorreu um erro inesperado ao atualizar monitoramento.", 500);
        }
    }

    public function deleteMonitoramento($id)
    {
        try {
            $monitoramento = Monitoramento::findOrFail($id);

            $deleted = $monitoramento->delete();

            Log::info("Monitoramento deletado com sucesso", ['id' => $id]);

            return $deleted;

        } catch (ModelNotFoundException $e) {
            Log::warning("Monitoramento não encontrado para exclusão", ['id' => $id]);
            throw new Exception("Monitoramento não encontrado para o ID: {$id}");

        } catch (QueryException $e) {
            Log::error("Erro ao excluir monitoramento no banco", [
                'id' => $id,
                'error' => $e->getMessage()
            ]);
            throw new Exception("Erro ao excluir monitoramento no banco de dados.");

        } catch (Throwable $e) {
            Log::error("Erro inesperado ao excluir monitoramento", [
                'id' => $id,
                'error' => $e->getMessage()
            ]);
            throw new Exception("Ocorreu um erro inesperado ao excluir monitoramento.");
        }
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