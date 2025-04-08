<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Publico;

class PublicoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
           Publico::factory()->create([
             "nome" => "Alta Direção"
           ]);

           Publico::factory()->create([
               "nome" => "Chefias"
           ]);

           Publico::factory()->create([
               "nome" => "Colaboradores da FAPEAM"
           ]);

           Publico::factory()->create([
               "nome" => "Ouvidoria"
           ]);

           Publico::factory()->create([
               "nome" => "Pesquisador"
           ]);

           Publico::factory()->create([
               "nome" => "Fornecedor"
           ]);

           Publico::factory()->create([
                  "nome" => "Comissão da Integridade"
           ]);

           Publico::factory()->create([
                  "nome" => "Comissão de Ética"
           ]);
    }
}
