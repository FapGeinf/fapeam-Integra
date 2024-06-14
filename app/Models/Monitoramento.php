<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Monitoramento extends Model
{
    use HasFactory;

    protected $fillable = ['monitoramentoControleSugerido', 'statusMonitoramento', 'execucaoMonitoramento', 'riscoFK'];

    public function risco()
    {
        return $this->belongsTo(Risco::class, 'riscoFK');
    }
}
