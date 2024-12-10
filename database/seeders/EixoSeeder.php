<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Eixo;

class EixoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Eixo::factory()->create([
            'nome' => 'COMPROMETIMENTO E APOIO DA ALTA DIREÇÃO'
        ]);
        Eixo::factory()->create([
            'nome' => 'INSTITUCIONALIZAÇÃO DO CÓDIGO DE CONDUTA'
        ]);
        Eixo::factory()->create([
            'nome' => 'AVALIAÇÃO DE RISCOS'
        ]);
        Eixo::factory()->create([
            'nome' => 'IMPLEMENTAÇÃO DOS CONTROLES INTERNOS'
        ]);
        Eixo::factory()->create([
            'nome' => 'COMUNICAÇÃO E TREINAMENTOS PERIÓDICOS'
        ]);
        Eixo::factory()->create([
            'nome' => 'CANAIS DE DENÚNCIA'
        ]);
        Eixo::factory()->create([
            'nome' => 'INVESTIGAÇÕES INTERNAS'
        ]);
        Eixo::factory()->create([
            'nome' => 'MONITORAMENTO CONTÍNUO'
        ]);
    }
}
