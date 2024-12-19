<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\MedidaTipo;

class MedidaTipoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
            MedidaTipo::factory()->create([
                 "nome" => "Pessoa"
            ]);

            MedidaTipo::factory()->create([
                 "nome" => "Relatórios"
            ]);
    }
}
