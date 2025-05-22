<?php

namespace App\Services;

use App\Http\Requests\VersionamentoRequest;
use App\Models\Versionamento;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Log;


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

    public function versionamentosOrderByDate()
    {
        return Versionamento::orderBy('created_at')->get();
    }

    public function insertVersionamento(array $data)
    {
        return Versionamento::create($data);
    }

    public function updateVersionamento(array $data, $id)
    {
        $versionamento = Versionamento::findOrFail($id);
        $versionamento->update($data);
        return $versionamento;
    }

    public function deleteVersionamento($id)
    {
        $versionamento = $this->getVersionamentoById($id);
        $versionamento->delete();
        return true;
    }

}

