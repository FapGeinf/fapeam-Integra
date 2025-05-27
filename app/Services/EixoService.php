<?php

namespace App\Services;
use App\Models\Eixo;

class EixoService
{
      public function getAllEixosOrderbyNome()
      {
             return Eixo::orderBy('nome')->get();
      }

      public function getAllEixos()
      { 
             return Eixo::all();
      }

      public function findEixoById($id)
      {
             return Eixo::findOrFail($id);
      }
}