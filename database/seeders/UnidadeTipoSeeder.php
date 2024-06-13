<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\UnidadeTipos;

class UnidadeTipoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        UnidadeTipos::factory()->create([
					'unidadeTipoNome' => 'Unidade Teste',
				]);
    }
}
