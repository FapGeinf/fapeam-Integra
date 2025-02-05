<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class indicador extends Model
{
    use HasFactory;
		protected $table = "indicadores";

		protected $fillable = [
			'nomeIndicador',
			'descricaoIndicador',
			'eixo_fk'
		];

		public function eixo(){
			return $this->belongsTo(Eixo::class, 'eixo_fk');
		}
		
}
