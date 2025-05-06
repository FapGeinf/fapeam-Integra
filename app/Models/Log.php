<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Log extends Model
{
    use HasFactory;

    protected $fillable = ['acao','descricao','user_id'];

    public function user()
    {
           $this->belongsTo(User::class,'user_id');
    }
}
