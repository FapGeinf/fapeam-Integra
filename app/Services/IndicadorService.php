<?php

namespace App\Services;

use App\Models\Indicador;
use App\Models\Eixo;

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
        return Indicador::create([
            'nomeIndicador' => $data['nomeIndicador'] ?? null,
            'descricaoIndicador' => $data['descricaoIndicador'],
            'eixo_fk' => $data['eixo_fk']
        ]);
    }

    public function editFormIndicador($id)
    {
        $indicador = Indicador::findOrFail($id);
        $eixos = Eixo::all();
        return compact('indicador', 'eixos');
    }

    public function updateIndicador($id, array $data)
    {
        $indicador = Indicador::findOrFail($id);
        return $indicador->update([
            'nomeIndicador' => $data['nomeIndicador'] ?? null,
            'descricaoIndicador' => $data['descricaoIndicador'],
            'eixo_fk' => $data['eixo_fk']
        ]);
    }
}