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
        try {
            return Versionamento::all();
        } catch (Exception $e) {
            Log::error('Erro ao recuperar todos os versionamentos', ['error' => $e->getMessage()]);
            throw new Exception('Houve um erro ao recuperar os versionamentos');
        }
    }

    public function getVersionamentoById($id)
    {
        try {
            return Versionamento::findOrFail($id);
        } catch (ModelNotFoundException $e) {
            Log::error('Não foi encontrado nenhum versionamento com esta id', ['error' => $e->getMessage(), 'id' => $id]);
            throw new ModelNotFoundException('Houve um erro ao recuperar o versionamento selecionado');
        } catch (Exception $e) {
            Log::error('Erro inesperado ao buscar versionamento por ID', ['error' => $e->getMessage(), 'id' => $id]);
            throw new Exception('Houve um erro ao recuperar o versionamento');
        }
    }

    public function versionamentosOrderByDate()
    {
        try {
            return Versionamento::orderBy('created_at')->get();
        } catch (Exception $e) {
            Log::error('Erro ao ordenar os versionamentos por data', ['error' => $e->getMessage()]);
            throw new Exception('Houve um erro ao recuperar os versionamentos ordenados por data');
        }
    }

    public function insertVersionamento(array $data)
    {
        try {
            return Versionamento::create($data);
        } catch (Exception $e) {
            Log::error('Erro ao inserir novo versionamento', ['error' => $e->getMessage(), 'dados' => $data]);
            throw new Exception('Houve um erro ao inserir o versionamento');
        }
    }

    public function updateVersionamento(array $data, $id)
    {
        try {
            $versionamento = Versionamento::findOrFail($id);
            $versionamento->update($data);
            return $versionamento;
        } catch (ModelNotFoundException $e) {
            Log::error('Não foi encontrado nenhum versionamento com esta id', ['error' => $e->getMessage(), 'id' => $id]);
            throw new ModelNotFoundException('Houve um erro ao recuperar o versionamento selecionado');
        } catch (Exception $e) {
            Log::error('Houve um erro inesperado ao atualizar o versionamento selecionado', ['error' => $e->getMessage(), 'id' => $id]);
            throw new Exception('Houve um erro ao atualizar o versionamento');
        }
    }

    public function deleteVersionamento($id)
    {
        try {
            $versionamento = $this->getVersionamentoById($id);
            $versionamento->delete();
            return true;
        } catch (ModelNotFoundException $e) {
            Log::error('Não foi encontrado nenhum versionamento com esta id', ['error' => $e->getMessage(), 'id' => $id]);
            throw new ModelNotFoundException('Houve um erro ao recuperar o versionamento selecionado');
        } catch (Exception $e) {
            Log::error('Houve um erro inesperado ao deletar o versionamento', ['error' => $e->getMessage(), 'id' => $id]);
            throw new Exception('Houve um erro inesperado ao deletar o versionamento');
        }
    }

}

