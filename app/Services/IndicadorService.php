<?php

namespace App\Services;

use App\Models\Indicador;
use App\Models\Eixo;
use Illuminate\Database\QueryException;
use Exception;
use Log;

class IndicadorService
{
    public function indexIndicadores($eixo_id)
    {
        if ($eixo_id) {
            $indicadores = Indicador::where('eixo_fk', $eixo_id)->with('eixo')->get();
        } else {
            $indicadores = Indicador::with('eixo')->get();
        }

        return $indicadores;
    }

    public function formCreateIndicador()
    {
        $eixos = Eixo::all();
        return $eixos;
    }

    public function insertIndicador(array $data)
    {
        try {
            Log::info('Inserindo novo indicador', ['dados' => $data]);

            $indicador = Indicador::create([
                'nomeIndicador' => $data['nomeIndicador'] ?? null,
                'descricaoIndicador' => $data['descricaoIndicador'],
                'eixo_fk' => $data['eixo_fk']
            ]);

            Log::info('Indicador criado com sucesso', ['id' => $indicador->id]);

            return $indicador;
        } catch (QueryException $e) {
            Log::error('Erro no banco de dados ao inserir indicador', [
                'error' => $e->getMessage(),
                'dados' => $data,
            ]);
            throw new Exception('Erro ao salvar o indicador. Verifique os dados inseridos.');
        } catch (\Throwable $e) {
            Log::error('Erro inesperado ao inserir indicador', [
                'error' => $e->getMessage(),
                'dados' => $data,
            ]);
            throw new Exception('Ocorreu um erro ao inserir o indicador. Tente novamente mais tarde.');
        }
    }

    public function editFormIndicador($id)
    {
        $indicador = Indicador::findOrFail($id);
        $eixos = Eixo::all();
        return compact('indicador', 'eixos');
    }

    public function updateIndicador($id, array $data)
    {
        try {
            Log::info('Atualizando indicador', ['id' => $id, 'dados' => $data]);

            $indicador = Indicador::findOrFail($id);
            $indicador->update([
                'nomeIndicador' => $data['nomeIndicador'] ?? null,
                'descricaoIndicador' => $data['descricaoIndicador'],
                'eixo_fk' => $data['eixo_fk']
            ]);

            Log::info('Indicador atualizado com sucesso', ['id' => $id]);

            return $indicador;
        } catch (QueryException $e) {
            Log::error('Erro no banco de dados ao atualizar indicador', [
                'error' => $e->getMessage(),
                'id' => $id,
                'dados' => $data,
            ]);
            throw new Exception('Erro ao atualizar o indicador. Verifique os dados inseridos.');
        } catch (\Throwable $e) {
            Log::error('Erro inesperado ao atualizar indicador', [
                'error' => $e->getMessage(),
                'id' => $id,
                'dados' => $data,
            ]);
            throw new Exception('Ocorreu um erro ao atualizar o indicador. Tente novamente mais tarde.');
        }
    }
}