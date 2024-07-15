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
            'unidadeEmail' => 'subcomissao@email.com',
            'unidadeSigla' => 'Subcomissão',
            'unidadeTipoFK' => '1'
        ]);

        Unidade::factory()->create([
            'unidadeNome' => 'Secretária dos Conselhos',
            'unidadeEmail' => 'SECCONSELHOS@email.com',
            'unidadeSigla' => 'SECCONSELHOS',
            'unidadeTipoFK' => '2'
        ]);

        Unidade::factory()->create([
            'unidadeNome' => 'Gerência de Informática',
            'unidadeEmail' => 'geinf@email.com',
            'unidadeSigla' => 'GEINF',
            'unidadeTipoFK' => '2'
        ]);

        Unidade::factory()->create([
            'unidadeNome' => 'Unidade de Controle Interno',
            'unidadeEmail' => 'UCI@email.com',
            'unidadeSigla' => 'UCI',
            'unidadeTipoFK' => '2'
        ]);

        Unidade::factory()->create([
            'unidadeNome' => 'Presidência',
            'unidadeEmail' => 'presidencia@email.com',
            'unidadeSigla' => 'Presidencia',
            'unidadeTipoFK' => '2'
        ]);

        Unidade::factory()->create([
            'unidadeNome' => 'Diretoria Administrativo-Financeira',
            'unidadeEmail' => 'DAF@email.com',
            'unidadeSigla' => 'DAF',
            'unidadeTipoFK' => '2'
        ]);

        Unidade::factory()->create([
            'unidadeNome' => 'Diretoria Técnico-Científica',
            'unidadeEmail' => 'DITEC@email.com',
            'unidadeSigla' => 'DITEC',
            'unidadeTipoFK' => '2'
        ]);

        Unidade::factory()->create([
            'unidadeNome' => 'Departamento de Análise de Projetos',
            'unidadeEmail' => 'DEAP@email.com',
            'unidadeSigla' => 'DEAP',
            'unidadeTipoFK' => '2'
        ]);

        Unidade::factory()->create([
            'unidadeNome' => 'Departamento de Acompanhamento e Avaliação',
            'unidadeEmail' => 'DEAC@email.com',
            'unidadeSigla' => 'DEAC',
            'unidadeTipoFK' => '2'
        ]);

        Unidade::factory()->create([
            'unidadeNome' => 'Departamento de Operações e Fomento',
            'unidadeEmail' => 'DEOF@email.com',
            'unidadeSigla' => 'DEOF',
            'unidadeTipoFK' => '2'
        ]);

        Unidade::factory()->create([
            'unidadeNome' => 'Departamento de Comunicação e Difusão de Conhecimento',
            'unidadeEmail' => 'DECON@email.com',
            'unidadeSigla' => 'DECON',
            'unidadeTipoFK' => '2'
        ]);

        Unidade::factory()->create([
            'unidadeNome' => 'Núcleo de Avaliação de Prestação de Contas',
            'unidadeEmail' => 'NUPC@email.com',
            'unidadeSigla' => 'NUPC',
            'unidadeTipoFK' => '2'
        ]);

        Unidade::factory()->create([
            'unidadeNome' => 'Gerência de Orçamento',
            'unidadeEmail' => 'GEOR@email.com',
            'unidadeSigla' => 'GEOR',
            'unidadeTipoFK' => '2'
        ]);

        Unidade::factory()->create([
            'unidadeNome' => 'Gerência Financeira',
            'unidadeEmail' => 'GEFI@email.com',
            'unidadeSigla' => 'GEFI',
            'unidadeTipoFK' => '2'
        ]);

        Unidade::factory()->create([
            'unidadeNome' => 'Gerência de Gestão de Pessoal',
            'unidadeEmail' => 'GEPE@email.com',
            'unidadeSigla' => 'GEPE',
            'unidadeTipoFK' => '2'
        ]);

        Unidade::factory()->create([
            'unidadeNome' => 'Gerência de Apoio Logístico',
            'unidadeEmail' => 'GEAL@email.com',
            'unidadeSigla' => 'GEAL',
            'unidadeTipoFK' => '2'
        ]);

        Unidade::factory()->create([
            'unidadeNome' => 'Núcleo de Convênios',
            'unidadeEmail' => 'NUCV@email.com',
            'unidadeSigla' => 'NUCV',
            'unidadeTipoFK' => '2'
        ]);

        Unidade::factory()->create([
            'unidadeNome' => 'Núcleo de Contabilidade',
            'unidadeEmail' => 'NUCB@email.com',
            'unidadeSigla' => 'NUCB',
            'unidadeTipoFK' => '2'
        ]);

        Unidade::factory()->create([
            'unidadeNome' => 'Núcleo de Contratos',
            'unidadeEmail' => 'NUCT@email.com',
            'unidadeSigla' => 'NUCT',
            'unidadeTipoFK' => '2'
        ]);

        Unidade::factory()->create([
            'unidadeNome' => 'Núcleo de Patrimônio',
            'unidadeEmail' => 'NUPA@email.com',
            'unidadeSigla' => 'NUPA',
            'unidadeTipoFK' => '2'
        ]);

        Unidade::factory()->create([
            'unidadeNome' => 'Núcleo de Arquivo',
            'unidadeEmail' => 'NUAQ@email.com',
            'unidadeSigla' => 'NUAQ',
            'unidadeTipoFK' => '2'
        ]);

        Unidade::factory()->create([
            'unidadeNome' => 'Assessoria Jurídica',
            'unidadeEmail' => 'ASJUR@email.com',
            'unidadeSigla' => 'ASJUR',
            'unidadeTipoFK' => '2'
        ]);

        Unidade::factory()->create([
            'unidadeNome' => 'Comissão de Tomada de Contas Especial',
            'unidadeEmail' => 'CTCE@email.com',
            'unidadeSigla' => 'CTCE',
            'unidadeTipoFK' => '2'
        ]);

        Unidade::factory()->create([
            'unidadeNome' => 'Ouvidoria',
            'unidadeEmail' => 'ouvidoria@email.com',
            'unidadeSigla' => 'Ouvidoria',
            'unidadeTipoFK' => '2'
        ]);

        Unidade::factory()->create([
            'unidadeNome' => 'Câmara de Assessoramento Científico-Pesquisa',
            'unidadeEmail' => 'CACP@email.com',
            'unidadeSigla' => 'CACP',
            'unidadeTipoFK' => '2'
        ]);

        Unidade::factory()->create([
            'unidadeNome' => 'Câmara de Assessoramento Científico Pós-Graduação',
            'unidadeEmail' => 'CACPOS@email.com',
            'unidadeSigla' => 'CACPOS',
            'unidadeTipoFK' => '2'
        ]);

        Unidade::factory()->create([
            'unidadeNome' => 'Assessoria de Planejamento e Avaliação Institucional',
            'unidadeEmail' => 'ASPLAVI@email.com',
            'unidadeSigla' => 'ASPLAVI',
            'unidadeTipoFK' => '2'
        ]);
    }
}
