<?php

namespace App\Services;
use App\Models\MedidaTipo;

class MedidaTipoService
{
    public function getAllMedidas()
    {
        return MedidaTipo::all();
    }
}