<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Unidade;

class NovasUnidadesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
           Unidade::factory()->create([
             'unidadeNome' => ' DIRETORIA ADMINISTRATIVO-FINANCEIRA',
             'unidadeSigla' => 'DAF',
						 'unidadeEmail' => 'diretoriaadministrativafinanceira@email.com',
             'unidadeTipoFK' => 5,
						 'unidadeDiretoria' => '1',
           ]);

           Unidade::factory()->create([
               'unidadeNome' => 'DIRETORIA TECNICO-CIENTIFICA',
               'unidadeSigla' => 'DITEC',
							 'unidadeEmail' => 'diretoriatecnicacientifica@email.com',
               'unidadeTipoFK' => 5,
							 'unidadeDiretoria' => '2',
           ]);

           Unidade::factory()->create([
               'unidadeNome' => 'PRESIDÊNCIA',
               'unidadeSigla' => 'PRES',
							 'unidadeEmail' => 'presidenciafap@email.com',
               'unidadeTipoFK' => 4,
							 'unidadeDiretoria' => '3',
           ]);
    }
}
