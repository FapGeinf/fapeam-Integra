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
        $eixo_id = $data['eixo_id'];
        if ($eixo_id) {
            $indicadores = Indicador::where('eixo_fk', $eixo_id)->with('eixo')->get();
        } else {
            $indicadores = Indicador::with('eixo')->get();
        }
        return $indicadores;
    }

    public function getIndicadorById($id)
    {
        return Indicador::findOrFail($id);
    }

    public function insertIndicador(array $data)
    {
        return Indicador::create([
            'nomeIndicador' => $data['nomeIndicador'] ?? null,
            'descricaoIndicador' => $data['descricaoIndicador'],
            'eixo_fk' => $data['eixo_fk'],
        ]);
    }

    public function updateIndicador($id, array $data)
    {
        $indicador = $this->getIndicadorById($id);
        $indicador->update([
            'nomeIndicador' => $data['nomeIndicador'] ?? null,
            'descricaoIndicador' => $data['descricaoIndicador'],
            'eixo_fk' => $data['eixo_fk']
        ]);
        return $indicador;
    }

}