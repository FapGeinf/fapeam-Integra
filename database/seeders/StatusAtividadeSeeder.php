<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\StatusAtividade;

class StatusAtividadeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $statusAtividades = [
            ['nome' => 'Acompanhamento'],
            ['nome' => 'Executado'],
            ['nome' => 'Não Executado'],
        ];

        foreach ($statusAtividades as $status) {
            StatusAtividade::create($status);
        }
    }
}
