<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Atividade extends Model
{
    use HasFactory;

    protected $fillable = ['eixo_id', 'atividade_descricao','objetivo','publico_alvo','tipo_evento','canal_divulgacao','data_prevista','data_realizada','meta','realizado'];

    public function eixo()
    {
           return $this->belongsTo(Eixo::class,'eixo_id','id');
    }
}
