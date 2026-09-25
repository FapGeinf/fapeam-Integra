<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PlanoAcao extends Model
{
    use HasFactory;

    protected $fillable = [
        'eixo_id',
        'objetivo',
        'descricao_acao',
        'meta',
        'indicador_id',
        'procedimentos',
        'metricas',
        'prazo_execucao',
        'responsavel_id' 
    ];

    protected $table = 'plano_acoes';

    public function eixo()
    {
        return $this->belongsTo(Eixo::class, 'eixo_id');
    }

    public function indicador()
    {
        return $this->belongsTo(Indicador::class, 'indicador_id');
    }

    public function responsavel()
    {
        return $this->belongsTo(User::class, 'responsavel_id');
    }
}