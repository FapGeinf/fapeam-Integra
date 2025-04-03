<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Monitoramento extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = ['monitoramentoControleSugerido', 'statusMonitoramento','inicioMonitoramento','fimMonitoramento', 'riscoFK','isContinuo'];

    public function risco()
    {
        return $this->belongsTo(Risco::class, 'riscoFK', 'id');
    }

    public function respostas()
    {
        return $this->hasMany(Resposta::class, 'respostaMonitoramentoFK', 'id');
    }


}
