<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Unidade;

class UnidadeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Unidade::factory()->create([
            'unidadeNome' => 'Subcomissão do Programa de Integridade',
            'unidadeEmail' => 'subcomissão@email.com',
            'unidadeTipoFK' => '1'
        ]);

        Unidade::factory()->create([
            'unidadeNome' => 'Secretária dos Conselhos',
            'unidadeEmail' => 'SECCONSELHOS@email.com',
            'unidadeTipoFK' => '2'
        ]);

        Unidade::factory()->create([
            'unidadeNome' => 'Gerência de Informática',
            'unidadeEmail' => 'geinf@email.com',
            'unidadeTipoFK' => '2'
        ]);

        Unidade::factory()->create([
            'unidadeNome' => 'Unidade de Controle Interno',
            'unidadeEmail' => 'UCI@email.com',
            'unidadeTipoFK' => '2'
        ]);

        Unidade::factory()->create([
            'unidadeNome' => 'Presidência',
            'unidadeEmail' => 'presidencia@email.com',
            'unidadeTipoFK' => '2'
        ]);
        Unidade::factory()->create([
            'unidadeNome' => 'Diretoria Administrativo-Financeira',
            'unidadeEmail' => 'DAF@email.com',
            'unidadeTipoFK' => '2'
        ]);

        Unidade::factory()->create([
            'unidadeNome' => 'Diretoria Técnico-Científica',
            'unidadeEmail' => 'DITEC@email.com',
            'unidadeTipoFK' => '2'
        ]);

        Unidade::factory()->create([
            'unidadeNome' => 'Departamento de Análise de Projetos',
            'unidadeEmail' => 'DEAP@email.com',
            'unidadeTipoFK' => '2'
        ]);

        Unidade::factory()->create([
            'unidadeNome' => 'Departamento de Acompanhamento e Avaliação',
            'unidadeEmail' => 'DEAC@email.com',
            'unidadeTipoFK' => '2'
        ]);

        Unidade::factory()->create([
            'unidadeNome' => 'Departamento de Operações e Fomento',
            'unidadeEmail' => 'DEOF@email.com',
            'unidadeTipoFK' => '2'
        ]);

        Unidade::factory()->create([
            'unidadeNome' => 'Departamento de Comunicação e Difusão de Conhecimento',
            'unidadeEmail' => 'DECON@email.com',
            'unidadeTipoFK' => '2'
        ]);

        Unidade::factory()->create([
            'unidadeNome' => 'Núcleo de Avaliação de Prestação de Contas',
            'unidadeEmail' => 'NUPC@email.com',
            'unidadeTipoFK' => '2'
        ]);

        Unidade::factory()->create([
            'unidadeNome' => 'Gerência de Orçamento',
            'unidadeEmail' => 'GEOR@email.com',
            'unidadeTipoFK' => '2'
        ]);

        Unidade::factory()->create([
            'unidadeNome' => 'Gerência Financeira',
            'unidadeEmail' => 'GEFI@email.com',
            'unidadeTipoFK' => '2'
        ]);

        Unidade::factory()->create([
            'unidadeNome' => 'Gerência de Gestão de Pessoal',
            'unidadeEmail' => 'GEPE@email.com',
            'unidadeTipoFK' => '2'
        ]);

        Unidade::factory()->create([
            'unidadeNome' => 'Gerência de Apoio Logístico',
            'unidadeEmail' => 'GEAL@email.com',
            'unidadeTipoFK' => '2'
        ]);

        Unidade::factory()->create([
            'unidadeNome' => 'Núcleo de Convênios',
            'unidadeEmail' => 'NUCV@email.com',
            'unidadeTipoFK' => '2'
        ]);

        Unidade::factory()->create([
            'unidadeNome' => 'Núcleo de Contabilidade',
            'unidadeEmail' => 'NUCB@email.com',
            'unidadeTipoFK' => '2'
        ]);

        Unidade::factory()->create([
            'unidadeNome' => 'Núcleo de Contratos',
            'unidadeEmail' => 'NUCT@email.com',
            'unidadeTipoFK' => '2'
        ]);

        Unidade::factory()->create([
            'unidadeNome' => 'Núcleo de Patrimônio',
            'unidadeEmail' => 'NUPA@email.com',
            'unidadeTipoFK' => '2'
        ]);

        Unidade::factory()->create([
            'unidadeNome' => 'Núcleo de Arquivo',
            'unidadeEmail' => 'NUAQ@email.com',
            'unidadeTipoFK' => '2'
        ]);

        Unidade::factory()->create([
            'unidadeNome' => 'Assessoria Jurídica',
            'unidadeEmail' => 'ASJUR@email.com',
            'unidadeTipoFK' => '2'
        ]);

        Unidade::factory()->create([
            'unidadeNome' => 'Comissão de Tomada de Contas Especial',
            'unidadeEmail' => 'CTCE@email.com',
            'unidadeTipoFK' => '2'
        ]);

        Unidade::factory()->create([
            'unidadeNome' => 'Ouvidoria',
            'unidadeEmail' => 'ouvidoria@email.com',
            'unidadeTipoFK' => '2'
        ]);

        Unidade::factory()->create([
            'unidadeNome' => 'Câmara de Assessoramento Científico-Pesquisa',
            'unidadeEmail' => 'CACP@email.com',
            'unidadeTipoFK' => '2'
        ]);

        Unidade::factory()->create([
            'unidadeNome' => 'Câmara de Assessoramento Científico Pós-Graduação',
            'unidadeEmail' => 'CACPOS@email.com',
            'unidadeTipoFK' => '2'
        ]);
        Unidade::factory()->create([
            'unidadeNome' => 'Assessoria de Planejamento e Avaliação Institucional',
            'unidadeEmail' => 'ASPLAVI@email.com',
            'unidadeTipoFK' => '2'
        ]);
    }
}
