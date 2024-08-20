<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Resposta extends Model
{
    use HasFactory;

    protected $fillable = ['respostaRisco', 'respostaMonitoramentoFK', 'user_id'];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function risco()
    {
        return $this->belongsTo(Monitoramento::class, 'respostaMonitoramentoFK', 'id');
    }
}

