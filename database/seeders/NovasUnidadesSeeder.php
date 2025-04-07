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
             'unidadeNome' => 'Gabinete DAF',
             'unidadeSigla' => 'GAB-DAF',
             'unidadeTipoFK' => 2
           ]);

           Unidade::factory()->create([
               'unidadeNome' => 'Gabinete DITEC',
               'unidadeSigla' => 'GAB-DITEC',
               'unidadeTipoFK' => 2
           ]);

           Unidade::factory()->create([
               'unidadeNome' => 'Gabinete PRESIDÊNCIA',
               'unidadeSigla' => 'GAB-PRES',
               'unidadeTipoFK' => 2
           ]);

           Unidade::factory()->create([
               'unidadeNome' => 'Asseroria da Presidência',
               'unidadeSigla' => 'ASSPRED',
               'unidadeTipoFK' => 2
           ]);

           Unidade::factory()->create([
                 'unidadeNome' => 'Departamento de Planejamento e Avaliação Institucional da Presidência',
                 'unidadeSigla' => 'DEPLAVI',
                 'unidadeTipoFK' => 2
           ]);
    }
}
