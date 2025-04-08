<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\UsuarioTipo;

class InsercaoNovoUsuarioTipo extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
           UsuarioTipo::factory()->create([
                'tipo' => 'ROOT'
           ]);
    }
}
