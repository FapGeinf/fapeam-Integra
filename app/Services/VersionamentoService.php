<?php

namespace App\Services;

use App\Models\Versionamento;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Log;
use Exception;
use Throwable;


class VersionamentoService
{
    public function returnAllVersionamentos()
    {
        try {
            Log::info('Buscando todos os versionamentos');
            return Versionamento::all();
        } catch (Throwable $e) {
            Log::error('Erro ao buscar versionamentos', ['error' => $e->getMessage()]);
            throw new Exception('Erro ao buscar versionamentos. Tente novamente mais tarde.');
        }
    }

    public function getVersionamentoById($id)
    {
        try {
            Log::info('Buscando versionamento por ID', ['id' => $id]);
            return Versionamento::findOrFail($id);
        } catch (Throwable $e) {
            Log::error('Erro ao buscar versionamento', ['id' => $id, 'error' => $e->getMessage()]);
            throw new Exception('Versionamento não encontrado.');
        }
    }

    public function versionamentosOrderByDate()
    {
        try {
            Log::info('Buscando versionamentos ordenados por data');
            return Versionamento::orderBy('created_at')->get();
        } catch (Throwable $e) {
            Log::error('Erro ao buscar versionamentos ordenados', ['error' => $e->getMessage()]);
            throw new Exception('Erro ao buscar versionamentos. Tente novamente mais tarde.');
        }
    }

    public function insertVersionamento(array $data)
    {
        try {
            Log::info('Inserindo novo versionamento', ['data' => $data]);

            $versionamento = Versionamento::create($data);

            Log::info('Versionamento criado com sucesso', ['id' => $versionamento->id]);

            return $versionamento;
        } catch (QueryException $e) {
            Log::error('Erro ao inserir versionamento no banco', ['error' => $e->getMessage(), 'data' => $data]);
            throw new Exception('Erro ao criar versionamento. Verifique os dados informados.');
        } catch (Throwable $e) {
            Log::error('Erro inesperado ao inserir versionamento', ['error' => $e->getMessage(), 'data' => $data]);
            throw new Exception('Ocorreu um erro inesperado ao criar o versionamento. Tente novamente mais tarde.');
        }
    }

    public function updateVersionamento(array $data, $id)
    {
        try {
            Log::info('Atualizando versionamento', ['id' => $id, 'data' => $data]);

            $versionamento = $this->getVersionamentoById($id);
            $versionamento->update($data);

            Log::info('Versionamento atualizado com sucesso', ['id' => $id]);

            return $versionamento;
        } catch (QueryException $e) {
            Log::error('Erro no banco ao atualizar versionamento', ['id' => $id, 'error' => $e->getMessage(), 'data' => $data]);
            throw new Exception('Erro ao atualizar versionamento. Verifique os dados informados.');
        } catch (Throwable $e) {
            Log::error('Erro inesperado ao atualizar versionamento', ['id' => $id, 'error' => $e->getMessage(), 'data' => $data]);
            throw new Exception('Ocorreu um erro inesperado ao atualizar o versionamento. Tente novamente mais tarde.');
        }
    }

    public function deleteVersionamento($id)
    {
        try {
            Log::info('Deletando versionamento', ['id' => $id]);

            $versionamento = $this->getVersionamentoById($id);
            $versionamento->delete();

            Log::info('Versionamento deletado com sucesso', ['id' => $id]);

            return true;
        } catch (QueryException $e) {
            Log::error('Erro no banco ao excluir versionamento', ['id' => $id, 'error' => $e->getMessage()]);
            throw new Exception('Erro ao excluir versionamento. Verifique se há registros dependentes.');
        } catch (Throwable $e) {
            Log::error('Erro inesperado ao excluir versionamento', ['id' => $id, 'error' => $e->getMessage()]);
            throw new Exception('Ocorreu um erro inesperado ao excluir o versionamento. Tente novamente mais tarde.');
        }
    }
}

