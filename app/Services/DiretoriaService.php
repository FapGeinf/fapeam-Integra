<?php

namespace App\Services;
use App\Models\Diretoria;

class DiretoriaService
{
    public function getAllDiretorias()
    {
        return Diretoria::all();
    }

    public function returnDiretoriaOrderedByName()
    {
        return Diretoria::orderBy('diretoriaNome', 'asc')->get();
    }

    public function findDiretoriaById($id)
    {
        return Diretoria::find($id);
    }

    public function createDiretoria(array $data)
    {
        return Diretoria::create($data);
    }

    public function updateDiretoria($id, array $data)
    {
        $diretoria = $this->findDiretoriaById($id);
        if ($diretoria) {
            $diretoria->update($data);
            return $diretoria;
        }
        return null;
    }

    public function deleteDiretoria($id)
    {
        $diretoria = $this->findDiretoriaById($id);
        if ($diretoria) {
            $diretoria->delete();
            return true;
        }
        return false;
    }
}