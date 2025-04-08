<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Diretoria;

class DiretoriaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Diretoria::factory()->create([
            'diretoriaSigla' => 'DAF',
            'diretoriaNome' => 'Diretoria Administrativo-Financeira',
        ]);
        Diretoria::factory()->create([
            'diretoriaSigla' => 'DITEC',
            'diretoriaNome' => 'Diretoria Técnico-Científica',
        ]);
        Diretoria::factory()->create([
            'diretoriaSigla' => 'PRESIDENCIA',
            'diretoriaNome' => 'Presidência',
        ]);
    }
}
