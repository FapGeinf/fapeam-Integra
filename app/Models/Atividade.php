<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Atividade extends Model
{
    use HasFactory;

    protected $fillable = ['eixo_id', 'atividade_descricao', 'objetivo','ano','publico_id', 'tipo_evento', 'canal_id', 'data_prevista', 'data_realizada', 'meta', 'realizado', 'medida_id', 'responsavel', 'justificativa','status_atividade_id'];

    public function eixos()
    {
        return $this->belongsToMany(Eixo::class, 'atividade_eixos', 'atividade_id', 'eixo_id');
    }

    public function publico()
    {
        return $this->belongsTo(Publico::class, 'publico_id');
    }

    public function canais()
    {
        return $this->belongsToMany(Canal::class, 'atividade_canal', 'atividade_id', 'canal_id');
    }

    public function medida()
    {
        return $this->belongsTo(MedidaTipo::class, 'medida_id');
    }
    public function indicadores()
    {
        return $this->belongsToMany(Indicador::class, 'atividade_indicadores', 'atividade_id', 'indicador_id');
    }

    public function statusAtividade()
    {
        return $this->belongsTo(StatusAtividade::class, 'status_atividade_id');
    }
}
