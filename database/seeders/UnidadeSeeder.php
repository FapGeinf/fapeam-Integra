<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Unidade;

class UnidadeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Unidade::factory()->create([
					'unidadeNome' => 'Comissão do Programa de Integridade',
					'unidadeEmail' => 'comissão@email.com',
					'unidadeTipoFK' => '1'
		]);
        Unidade::factory()->create([
					'unidadeNome' => 'GEINF',
					'unidadeEmail' => 'geinf@email.com',
					'unidadeTipoFK' => '1'
		]);

    }
}
