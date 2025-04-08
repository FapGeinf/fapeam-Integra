<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Eixo extends Model
{
    use HasFactory;

    protected $fillable = ['nome'];

    public function atividades()
    {
        return $this->belongsToMany(Atividade::class, 'atividade_eixos', 'eixo_id', 'atividade_id');
    }
}
