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
             "nome" => "Colaboradores Internos"
           ]);

           Publico::factory()->create([
               "nome" => "Público Externo"
           ]);

           Publico::factory()->create([
               "nome" => "Pesquisadores"
           ]);
    }
}
