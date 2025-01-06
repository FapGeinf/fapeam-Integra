<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Canal extends Model
{
    use HasFactory;

    protected $fillable = ['nome'];

    protected $table = 'canais';

    public function atividades()
    {
        return $this->belongsToMany(Atividade::class, 'atividade_canal', 'canal_id', 'atividade_id');
    }
}
