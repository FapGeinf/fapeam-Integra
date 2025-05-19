<?php

namespace App\Services;
use App\Models\indicador;
use ErrorException;
use Exception;
use Log;

class IndicadorService
{
    public function indexLogs(array $data)
    {
        try {
            $eixo_id = $data['eixo_id'];
            if ($eixo_id) {
                $indicadores = Indicador::where('eixo_fk', $eixo_id)->with('eixo')->get();
            } else {
                $indicadores = Indicador::with('eixo')->get();
            }
            return $indicadores;
        } catch (Exception $e) {
            Log::error('Houve um erro ao retornar a lista de indicadores', ['error' => $e->getMessage()]);
            throw new ErrorException('Houve um erro a retornar a lista de indicadores');
        }
    }

    public function getIndicadorById($id)
    {
        return Indicador::findOrFail($id);
    }

    public function insertIndicador(array $data)
    {
        try {
            return Indicador::create([
                'nomeIndicador' => $data['nomeIndicador'] ?? null,
                'descricaoIndicador' => $data['descricaoIndicador'],
                'eixo_fk' => $data['eixo_fk'],
            ]);
        } catch (Exception $e) {
            Log::error('Houve um erro ao inserir um novo indicador.', ['error' => $e->getMessage()]);
            throw new ErrorException('Houve um erro inesperado na inserção de um novo indicador');
        }
    }

    public function updateIndicador($id, array $data)
    {
        try {
            $indicador = $this->getIndicadorById($id);
            $indicador->update([
                'nomeIndicador' => $data['nomeIndicador'] ?? null,
                'descricaoIndicador' => $data['descricaoIndicador'],
                'eixo_fk' => $data['eixo_fk']
            ]);
            return $indicador;
        } catch (Exception $e) {
            Log::error('Houve um erro ao atualizar o indicador.', ['error' => $e->getMessage()]);
            throw new ErrorException('Houve um erro inesperado na atualização do indicador.');
        }
    }

}