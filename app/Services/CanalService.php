<?php

namespace App\Services;
use App\Models\Canal;
use Exception;
use DB;

class CanalService
{
    public function insertCanal(array $validatedData)
    {
        try {
            if (Canal::where('nome', $validatedData['nome'])->exists()) {
                throw new Exception('O canal já existe.');
            }

            return DB::transaction(function () use ($validatedData) {
                return Canal::create([
                    'nome' => $validatedData['nome']
                ]);
            });

        } catch (Exception $e) {
            throw new Exception('Erro ao criar o canal: ' . $e->getMessage());
        }
    }
}