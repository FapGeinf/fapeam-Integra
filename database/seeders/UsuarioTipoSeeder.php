<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\UsuarioTipo;
class UsuarioTipoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
           UsuarioTipo::factory()->create([
               "tipo" => "Presidente"
           ]);
           UsuarioTipo::factory()->create([
                "tipo" => "Diretor"
           ]);
           UsuarioTipo::factory()->create([
                 "tipo" => "Gestor"
           ]);
    }
}
