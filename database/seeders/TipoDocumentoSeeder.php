<?php

namespace Database\Seeders;

use App\Models\TipoDocumento;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TipoDocumentoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
           TipoDocumento::factory()->create([
                'nome' => 'Memorandos'
           ]);

           TipoDocumento::factory()->create([
                'nome' => 'Oficios'
           ]);

           TipoDocumento::factory()->create([
                 'nome' => 'Processos'
           ]);

           TipoDocumento::factory()->create([
                 'nome' => 'Outros'
           ]);
    }
}
