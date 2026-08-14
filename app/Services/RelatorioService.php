<?php

namespace App\Services;

use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\View;
use App\Services\RiscoService;
use App\Services\AtividadeService;
use App\Services\EixoService;
use App\Services\CanalService;
use App\Services\PublicoService;

class RelatorioService
{
    protected $riscoService,
    $atividadeService,
    $eixoService,
    $canalService,
    $publicoService;

    public function __construct(
        RiscoService $riscoService,
        AtividadeService $atividadeService,
        EixoService $eixoService,
        CanalService $canalService,
        PublicoService $publicoService
    ) {
        $this->riscoService = $riscoService;
        $this->atividadeService = $atividadeService;
        $this->eixoService = $eixoService;
        $this->canalService = $canalService;
        $this->publicoService = $publicoService;
    }

    public function gerarRelatorioGeral()
    {
        $riscos = $this->riscoService->listarRiscosComDetalhes();
        $riscosAgrupados = $riscos->groupBy(fn($risco) => $risco->unidade->id);

        $html = View::make('relatorios.relatorioTemplate', compact('riscosAgrupados'))->render();

        return Pdf::loadHTML($html)->setPaper('A4', 'portrait');
    }

    public function gerarRelatorioPorEixo(int $eixoId)
    {
        $atividades = $this->atividadeService->listarAtividadesPorEixo($eixoId);

        $eixo = $this->eixoService->findEixoById($eixoId);
        $eixoNome = $eixo->nome;

        $html = View::make('relatorios.relatoriosEixos', compact('atividades', 'eixoNome'))->render();

        return Pdf::loadHTML($html)->setPaper('A4', 'portrait')->download("relatorio_do_eixo_{$eixoNome}.pdf");
    }

    public function gerarDadosGraficos()
    {
        $atividades = $this->atividadeService->listarAtividades();

        $eixosCount = [];
        $publicoCount = [];
        $eventosCount = [];
        $canaisCount = [];

        foreach ($atividades as $atividade) {
            foreach ($atividade->eixos as $eixo) {
                $eixosCount[$eixo->id] = ($eixosCount[$eixo->id] ?? 0) + 1;
            }

            if ($atividade->publico) {
                $publicoCount[$atividade->publico->id] = ($publicoCount[$atividade->publico->id] ?? 0) + 1;
            }

            $eventosCount[$atividade->tipo_evento] = ($eventosCount[$atividade->tipo_evento] ?? 0) + 1;

            foreach ($atividade->canais as $canal) {
                $canaisCount[$canal->id] = ($canaisCount[$canal->id] ?? 0) + 1;
            }
        }

        $graficoEixos = collect($eixosCount)->map(function ($count, $id) {
            $eixo = $this->eixoService->findEixoById($id);
            return ['name' => $eixo?->nome ?? 'Desconhecido', 'y' => $count];
        })->values();

        $graficoPublico = collect($publicoCount)->map(function ($count, $id) {
            $publico = $this->publicoService->findPublicoById($id);
            return ['name' => $publico?->nome ?? 'Desconhecido', 'y' => $count];
        })->values();

        $graficoEventos = collect($eventosCount)->map(function ($count, $id) {
            return ['name' => $id == 1 ? 'Presencial' : 'Online', 'y' => $count];
        })->values();

        $graficoCanais = collect($canaisCount)->map(function ($count, $id) {
            $canal = $this->canalService->findCanalById($id);
            return ['name' => $canal?->nome ?? 'Desconhecido', 'y' => $count];
        })->values();

        return [
            'graficoEixos' => $graficoEixos,
            'graficoPublico' => $graficoPublico,
            'graficoEventos' => $graficoEventos,
            'graficoCanais' => $graficoCanais,
            'atividades' => $atividades,
            'eixos' => $this->eixoService->getAllEixos(),
            'canais' => $this->canalService->getAllCanais(),
            'publicos' => $this->publicoService->indexPublicos(),
        ];
    }

    public function gerarRelatorioAtividadesPorStatus($status)
    {
        $atividades = match ($status->nome) {
            "Acompanhamento" => $this->atividadeService->getAtividadesAcompanhamento(),
            "Executado"      => $this->atividadeService->getAtividadesExecutadas(),
            "Não Executado"  => $this->atividadeService->getAtividadesNaoExecutado(),
            default          => $this->atividadeService->listarAtividades(),
        };

        $html = View::make('atividades.relatorio-por-status', compact('atividades'))->render();

        return Pdf::loadHTML($html)
            ->setPaper('A4', 'portrait')
            ->download("relatorio-atividades-{$status->nome}.pdf");
    }
}
