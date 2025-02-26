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
				'unidadeTipoNome' => 'Administrador',
		]);
        UnidadeTipo::factory()->create([
            'unidadeTipoNome' => 'Setor',
        ]);
        UnidadeTipo::factory()->create([
            'unidadeTipoNome' => 'SubComissão',
        ]);
        UnidadeTipo::factory()->create([
			'unidadeTipoNome' => 'Presidência',
		]);
        UnidadeTipo::factory()->create([
            'unidadeTipoNome' => 'Diretoria'
        ]);
    }
}
