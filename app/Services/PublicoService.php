<?php

namespace App\Services;
use App\Models\Publico;
use Illuminate\Support\Facades\Log;

class PublicoService
{
    public function indexPublicos()
    {
        return Publico::all();
    }

    public function show($id)
    {
        return Publico::findOrFail($id);
    }

    /**
     * Trata a lógica do publico_id e cria o registro se necessário.
     * * @param array $data Dados da requisição (ex: $request->validated())
     * @return array Dados atualizados com o novo publico_id se 'outros' foi selecionado
     */
    public function handlePublicoId(array $data): array
    {
        if (
            isset($data['publico_id']) && 
            $data['publico_id'] === 'outros' && 
            !empty($data['novo_publico'])
        ) {
            Log::info('Criando novo público via Service', ['nome' => $data['novo_publico']]);

            $novoPublico = Publico::create(['nome' => $data['novo_publico']]);
            $data['publico_id'] = $novoPublico->id;

            Log::info('Novo público criado com sucesso via Service', ['id' => $novoPublico->id]);
        }

        return $data;
    }

    public function createPublico($data)
    {
        return Publico::create($data);
    }
}