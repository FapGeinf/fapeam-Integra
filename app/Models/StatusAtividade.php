<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StatusAtividade extends Model
{
    use HasFactory;

    protected $table = 'status_atividades';
    protected $fillable = ['nome'];

    public function atividades()
    {
        return $this->hasMany(Atividade::class, 'status_atividade_id');
    }
}
