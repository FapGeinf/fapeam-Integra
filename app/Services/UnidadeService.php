<?php

namespace App\Services;
use App\Models\Unidade;


class UnidadeService
{
    public function getAllUnidades()
    {
        return Unidade::all();
    }

    public function findUnidadeById($id)
    {
        return Unidade::find($id);
    }

    public function createUnidade(array $data)
    {
        return Unidade::create($data);
    }

    public function getUnidadesByDiretoria($diretoriaId)
    {
        return Unidade::where('unidadeDiretoria', $diretoriaId)->get();
    }

    public function updateUnidade($id, array $data)
    {
        $unidade = $this->findUnidadeById($id);
        if ($unidade) {
            $unidade->update($data);
            return $unidade;
        }
        return null;
    }

    public function deleteUnidade($id)
    {
        $unidade = $this->findUnidadeById($id);
        if ($unidade) {
            $unidade->delete();
            return true;
        }
        return false;
    }
}