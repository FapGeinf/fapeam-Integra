<?php

namespace App\Services;
use App\Models\UnidadeTipo;

class UnidadeTipoService
{
      public function getAllUnidadeTipos()
      {
             return UnidadeTipo::all();
      }
}