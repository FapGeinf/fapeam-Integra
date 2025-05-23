<?php

namespace App\Services;
use App\Models\Log as LogModel;
use Log;

class LogService
{

    public function insertLog(array $data)
    {
        return LogModel::create([
            'acao' => $data['acao'],
            'descricao' => $data['descricao'],
            'user_id' => $data['user_id']
        ]);
    }

}