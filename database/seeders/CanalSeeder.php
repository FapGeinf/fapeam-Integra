<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Canal;

class CanalSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
           Canal::factory()->create([
              "nome" => "Portal Fapeam"
           ]);

           Canal::factory()->create([
               "nome" => "GEPE Comunica"
           ]);

           Canal::factory()->create([
             "nome" => "Memorando"
           ]);

           Canal::factory()->create([
            "nome" => "Outros"
           ]);
    }
}
