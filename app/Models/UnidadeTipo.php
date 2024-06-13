<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UnidadeTipo extends Model
{
    use HasFactory;

    protected $fillable = ['unidadeTipoNome'];

    public function unidades()
    {
          return $this->hasMany(Unidade::class);
    }
}
