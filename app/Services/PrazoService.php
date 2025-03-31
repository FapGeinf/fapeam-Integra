<?php

namespace App\Services;

use App\Events\PrazoProximo;
use App\Models\Prazo;

class PrazoService
{
    public function insertPrazo(array $validatedData)
    {
        $prazoExistente = Prazo::first();

        if ($prazoExistente) {
            $prazoExistente->delete();
        }

        $novoPrazo = Prazo::create([
            'data' => $validatedData['data']
        ]);

        if (!$novoPrazo) {
            return redirect()->back()->with('error', 'Erro ao inserir um Prazo');
        }

        event(new PrazoProximo($novoPrazo));

        return $novoPrazo;
    }
}