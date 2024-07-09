<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Unidade;
use App\Models\User;
use App\Models\Monitoramento;
use App\Models\Resposta;

class Risco extends Model
{
    use HasFactory;

    protected $fillable = [
        'responsavelRisco',
        'riscoEvento',
        'riscoCausa',
        'riscoConsequencia',
        'nivel_de_risco',
        'userIdRisco',
        'unidadeId',
        'riscoAno'
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'userIdRisco');
    }

    public function monitoramentos()
    {
        return $this->hasMany(Monitoramento::class, 'riscoFK', 'id');
    }


    public function respostas()
    {
        return $this->hasMany(Resposta::class, 'respostaRiscoFK', 'id');
    }


    public function unidade()
    {
        return $this->belongsTo(Unidade::class, 'unidadeId');
    }
}
