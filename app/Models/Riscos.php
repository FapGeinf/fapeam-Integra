<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Riscos extends Model
{
    use HasFactory;
		protected $fillable = [
			'riscoEvento',
			'riscoCausa',
			'riscoConsequencia',
			'riscoAvaliacao',
		];
}
