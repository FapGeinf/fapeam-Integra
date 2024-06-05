<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UsuarioTipos extends Model
{
    use HasFactory;

    protected $fillable = ['tipo'];

    public function users()
    {
           return $this->hasMany(User::class);
    }
}
