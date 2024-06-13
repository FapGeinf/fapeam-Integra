<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Resposta extends Model
{
    use HasFactory;

    protected $fillable = ['respostaRisco','respostaRiscoFk','user_id'];

    public function user()
    {
           return $this->belongsTo(User::class,'id','user_id');
    }

    public function risco()
    {
          return $this->belongsTo(Risco::class,'id','respostaRiscoFK');
    }
}
