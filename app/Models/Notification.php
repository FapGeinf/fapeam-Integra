<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    use HasFactory;

    protected $fillable = ['message','global','read_at'];

    protected $casts = [
         'global' => 'boolean'
    ];

    protected $dates = ['read_at'];
}
