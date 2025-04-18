<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Resposta extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = ['respostaRisco', 'respostaMonitoramentoFK', 'user_id','anexo','homologadoDiretoria'];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function monitoramento()
    {
        return $this->belongsTo(Monitoramento::class, 'respostaMonitoramentoFK', 'id');
    }
}



