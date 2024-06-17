<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\UnidadeTipo;

class UnidadeTipoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        UnidadeTipo::factory()->create([
					'unidadeTipoNome' => 'Comissão',
		]);
        UnidadeTipo::factory()->create([
					'unidadeTipoNome' => 'Setor',
		]);
    }
}
