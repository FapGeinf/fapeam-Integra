<?php

namespace App\Services;

use App\Http\Requests\VersionamentoRequest;
use App\Models\Versionamento;


class VersionamentoService
{
    public function returnAllVersionamentos()
    {
        return Versionamento::all();
    }

    public function getVersionamentoById($id)
    {
        return Versionamento::findOrFail($id);
    }

    public function insertVersionamento(array $data) 
    {
        return Versionamento::create($data);
    }

    public function updateVersionamento(array $data, $id) 
    {
        $versionamento = $this->getVersionamentoById($id);
        return $versionamento->update($data);
    }

    public function deleteVersionamento($id)
    {
        $versionamento = $this->getVersionamentoById($id);
        return $versionamento->delete();
    }
}

