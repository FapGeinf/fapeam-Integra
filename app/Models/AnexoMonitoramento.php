<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AnexoMonitoramento extends Model
{
    use HasFactory;

    protected $fillable = ['path','monitoramentoId'];
    protected $table = 'anexos_monitoramentos';

    public function monitoramento()
    {
           return $this->belongsTo(Monitoramento::class,'monitoramentoId');
    }
}
