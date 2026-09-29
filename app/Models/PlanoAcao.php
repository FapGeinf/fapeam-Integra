<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PlanoAcao extends Model
{
    use HasFactory;

    protected $fillable = [
        'objetivo',
        'descricao_acao',
        'meta',
        'indicador_id',
        'procedimentos',
        'metricas',
        'prazo_execucao',
        'responsavel_id',
        'bienio' 
    ];

    public function eixos()
    {
        return $this->belongsToMany(Eixo::class, 'eixo_plano_acao', 'plano_acao_id', 'eixo_id');
    }

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

    public function atividades()
    {
        return $this->hasMany(Atividade::class);
    }

    public function getAnoInicioAttribute()
    {
        return $this->bienio ? explode('-', $this->bienio)[0] : null;
    }

    public function getAnoFimAttribute()
    {
        return $this->bienio ? explode('-', $this->bienio)[1] : null;
    }
}