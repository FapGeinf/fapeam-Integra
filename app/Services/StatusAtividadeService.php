<?php

namespace App\Services;
use App\Models\StatusAtividade;

class StatusAtividadeService
{
    public function getAllStatusAtividades()
    {
        return StatusAtividade::all();
    }
}