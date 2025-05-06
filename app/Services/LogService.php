<?php

namespace App\Services;
use App\Models\Log as LogModel;
use Log;

class LogService{

    public function insertLog(array $data)
    {
        try {
            return LogModel::create([
                'acao' => $data['acao'],
                'descricao' => $data['descricao'],
                'user_id' => $data['user_id']
            ]);
        } catch (\Exception $e) {
            Log::error('Erro ao inserir log: ' . $e->getMessage(), [
                'dados_recebidos' => $data,
                'trace' => $e->getTraceAsString()
            ]);
            return false;
        }
    }
    
}