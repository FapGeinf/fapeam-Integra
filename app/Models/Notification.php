<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    use HasFactory;

    protected $fillable = ['message','global','read_at','monitoramentoId','user_id'];

    protected $casts = [
         'global' => 'boolean'
    ];

    protected $dates = ['read_at'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function markAsRead()
    {
        $this->update(['read_at' => now()]);
    }

    public function monitoramento()
    {
           return $this->belongsTo(Monitoramento::class,'monitoramentoId');
    }
}
