<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Atividade;
use App\Models\Eixo;
use App\Models\Canal;
use App\Models\Indicador;
use App\Models\Publico;
use App\Models\MedidaTipo;
use App\Models\StatusAtividade;

class AtividadeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $publicos = Publico::pluck('id')->toArray();
        $medidas  = MedidaTipo::pluck('id')->toArray();
        $eixos    = Eixo::pluck('id')->toArray();
        $canais   = Canal::pluck('id')->toArray();


        if (count($eixos) < 8) {
            for ($i = count($eixos) + 1; $i <= 8; $i++) {
                $eixo = Eixo::firstOrCreate(['nome' => "Eixo {$i}"]);
                $eixos[] = $eixo->id;
            }
        }

        if (empty($canais)) {
            $canais = [
                Canal::firstOrCreate(['nome' => 'Presencial'])->id,
                Canal::firstOrCreate(['nome' => 'Online / Web'])->id,
                Canal::firstOrCreate(['nome' => 'Redes Sociais'])->id,
            ];
        }

        $publicoDefault = $publicos[0] ?? 1;
        $medidaDefault  = $medidas[0]  ?? 1;

        $eixoPadrao = $eixos[0] ?? 1;

        $indicadores = [
            Indicador::firstOrCreate(
                ['nomeIndicador' => 'Percentual de Alunos e Pesquisadores Atendidos'],
                ['descricaoIndicador' => 'Mede o alcance e impacto nos estudantes e pesquisadores beneficiados.', 'eixo_fk' => $eixoPadrao]
            )->id,
            Indicador::firstOrCreate(
                ['nomeIndicador' => 'Número de Eventos Científicos Realizados'],
                ['descricaoIndicador' => 'Acompanha o volume total de eventos organizados.', 'eixo_fk' => $eixoPadrao]
            )->id,
            Indicador::firstOrCreate(
                ['nomeIndicador' => 'Quantidade de Publicações e Divulgações'],
                ['descricaoIndicador' => 'Mede as publicações e materiais impressos/digitais gerados.', 'eixo_fk' => $eixoPadrao]
            )->id,
            Indicador::firstOrCreate(
                ['nomeIndicador' => 'Índice de Satisfação dos Participantes'],
                ['descricaoIndicador' => 'Média percentual de aprovação nas avaliações pós-evento.', 'eixo_fk' => $eixoPadrao]
            )->id,
            Indicador::firstOrCreate(
                ['nomeIndicador' => 'Número de Parcerias Estratégicas Firmadas'],
                ['descricaoIndicador' => 'Registra convênios e parcerias consolidadas no período.', 'eixo_fk' => $eixoPadrao]
            )->id,
        ];


        $statusExecutada      = StatusAtividade::firstOrCreate(['nome' => 'Executada'])->id;
        $statusAcompanhamento = StatusAtividade::firstOrCreate(['nome' => 'Acompanhamento'])->id;
        $statusNaoExecutada   = StatusAtividade::firstOrCreate(['nome' => 'Não Executada'])->id;

        $responsaveis = [
            'Maria Silva', 'João Pedro', 'Ana Costa', 'Carlos Eduardo',
            'Fernanda Lima', 'Roberto Alves', 'Juliana Rocha', 'Lucas Mendes'
        ];

        $tiposEventos = [
            'Workshop', 'Treinamento Interno', 'Divulgação / Mídia', 'Mesa Redonda',
            'Publicação Institucional', 'Seminário', 'Reunião Técnica', 'Fórum de Discussão'
        ];

        $titulosAcoes = [
            'Workshop Anual de Inovação e Ciência',
            'Treinamento Interno de Governança e Transparência',
            'Campanha de Difusão dos Novos Editais de Fomento',
            'Mesa Redonda: Bioeconomia e Sustentabilidade no AM',
            'Elaboração e Publicação do Relatório Anual de Impacto',
            'Seminário Internacional de Biotecnologia Aplicada',
            'Capacitação em Gestão de Projetos para Pesquisadores',
            'Fórum de Integração Academia e Setor Produtivo',
            'Treinamento de Submissão de Propostas na Plataforma',
            'Encontro de Alinhamento Estratégico com Gestores',
            'Lançamento da Revista Científica Institucional',
            'Painel sobre Inteligência Artificial na Gestão Pública',
            'Oficina de Redação de Patentes e Propriedade Intelectual',
            'Campanha de Conscientização de Segurança da Informação',
            'Jornada Científica para Jovens Pesquisadores',
            'Reunião do Comitê de Avaliação de Riscos',
            'Simpósio de Biodiversidade e Recursos Naturais',
            'Sessão Técnica de Apresentação de Resultados Parciais',
            'Webinar sobre Fontes de Financiamento Internacionais',
            'Ação de Divulgação Itinerante nos Municípios do Interior',
            'Reunião Conjunta com Agências de Fomento Parceiras',
            'Capacitação sobre Boas Práticas em Compras Públicas',
            'Mapeamento e Diagnóstico do Ecossistema Local de C&T',
            'Edição Especial do Boletim Informativo Mensal'
        ];

        foreach ($titulosAcoes as $index => $titulo) {
            if ($index % 3 === 0) {
                $statusId = $statusExecutada;
                $dataRealizada = '2026-0' . rand(1, 6) . '-' . rand(10, 28);
                $realizado = (string) rand(50, 200);
                $justificativa = null;
            } elseif ($index % 3 === 1) {
                $statusId = $statusAcompanhamento;
                $dataRealizada = null;
                $realizado = (string) rand(0, 40);
                $justificativa = null;
            } else {
                $statusId = $statusNaoExecutada;
                $dataRealizada = null;
                $realizado = '0';
                $justificativa = 'Atividade não executada no período devido a readequação do cronograma orçamentário.';
            }

            shuffle($eixos);
            $eixosAtividade = array_slice($eixos, 0, rand(1, 3));

            shuffle($canais);
            $canaisAtividade = array_slice($canais, 0, rand(1, 2));

            shuffle($indicadores);
            $indicadoresAtividade = rand(0, 1) ? array_slice($indicadores, 0, rand(1, 2)) : [];

            $pId = $publicos[$index % count($publicos)] ?? $publicoDefault;
            $mId = $medidas[$index % count($medidas)] ?? $medidaDefault;

            $atividade = Atividade::create([
                'responsavel'         => $responsaveis[$index % count($responsaveis)],
                'atividade_descricao' => "<p>{$titulo}.</p>",
                'objetivo'            => "<p>Promover e alcançar os objetivos estratégicos vinculados à ação '{$titulo}'.</p>",
                'publico_id'          => $pId,
                'tipo_evento'         => $tiposEventos[$index % count($tiposEventos)],
                'data_prevista'       => '2026-0' . rand(1, 9) . '-' . rand(10, 28),
                'data_realizada'      => $dataRealizada,
                'meta'                => (string) rand(50, 200),
                'realizado'           => $realizado,
                'medida_id'           => $mId,
                'status_atividade_id' => $statusId,
                'justificativa'       => $justificativa,
            ]);

            $atividade->eixos()->sync($eixosAtividade);
            $atividade->canais()->sync($canaisAtividade);
            if (!empty($indicadoresAtividade)) {
                $atividade->indicadores()->sync($indicadoresAtividade);
            }
        }
    }
}