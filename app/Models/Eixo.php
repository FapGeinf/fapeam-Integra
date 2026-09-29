<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Eixo extends Model
{
    use HasFactory;

    protected $fillable = ['nome', 'anexo_path'];

    public function atividades()
    {
        return $this->belongsToMany(Atividade::class, 'atividade_eixos', 'eixo_id', 'atividade_id');
    }

    public function planosAcao()
    {
        return $this->belongsToMany(PlanoAcao::class, 'eixo_plano_acao', 'eixo_id', 'plano_acao_id');
    }
}
