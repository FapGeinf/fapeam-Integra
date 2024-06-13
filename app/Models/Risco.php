<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Unidade;

class Risco extends Model
{
    use HasFactory;
		protected $fillable = [
			'riscoEvento',
			'riscoCausa',
			'riscoConsequencia',
			'riscoAvaliacao',
			'unidadeRiscoFK'
		];
	
	public function unidade()
	{
		   return $this->belongsTo(Unidade::class, 'unidadeRiscoFK');
	}

	public function monitoramentos()
	{
		   return $this->hasMany(Monitoramento::class);
	}

	public function respostas()
	{
		   return $this->hasMany(Resposta::class);
	}
}
