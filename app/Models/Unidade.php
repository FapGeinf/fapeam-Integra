<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Unidade extends Model
{
    use HasFactory;

		protected $fillable = [
			'unidadeNome','unidadeEmail','unidadeTipoFK'
		];

	 public function unidadeTipo()
	 {
		    return $this->belongsTo(UnidadeTipo::class,'unidadeTipoFK');
	 }
	//  public function risco(){
	// 		return $this->belongsToMany(Risco::class);
	//  }
}
