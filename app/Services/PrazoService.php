<?php

namespace App\Services;
use App\Models\Prazo;
use Exception;
use App\Events\PrazoProximo;
use Log;

class PrazoService
{
    public function storePrazo(array $data)
    {
        try {
            $prazoExistente = Prazo::first();

            if ($prazoExistente) {
                $prazoExistente->delete();
            }

            $novoPrazo = Prazo::create([
                'data' => $data['data']
            ]);

            event(new PrazoProximo($novoPrazo));

            return true;

        } catch (Exception $e) {
            Log::error('Houve um erro ao registrar um novo prazo.', [
                'error' => $e->getMessage()
            ]);

            throw new Exception('Houve um erro ao registrar um novo prazo.');
        }
    }

}