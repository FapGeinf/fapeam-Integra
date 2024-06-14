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
					'unidadeNome' => 'Unidade Teste',
					'unidadeEmail' => 'unidade_teste@email.com',
					'unidadeTipoFK' => '1'
				]);
    }
}
