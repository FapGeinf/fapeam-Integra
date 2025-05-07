<?php

namespace App\Services;

use App\Models\Risco;
use App\Models\Atividade;
use App\Models\Eixo;
use App\Models\Canal;
use App\Models\Publico;
use Barryvdh\DomPDF\Facade\Pdf;
use Exception;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\View;

class RelatorioService
{
    public function gerarRelatorioGeral()
    {
        $riscos = Risco::with(['unidade', 'monitoramentos.respostas.user'])->get();
        $riscosAgrupados = $riscos->groupBy(fn($risco) => $risco->unidade->id);

        $html = View::make('relatorios.relatorioTemplate', compact('riscosAgrupados'))->render();

        return Pdf::loadHTML($html)->setPaper('A4', 'portrait');
    }

    public function gerarRelatorioPorEixo(int $eixoId)
    {
        $atividades = Atividade::whereHas('eixos', function ($query) use ($eixoId) {
            $query->where('eixos.id', $eixoId);
        })->orderBy('data_prevista')->get();

        $eixo = Eixo::findOrFail($eixoId);
        $eixoNome = $eixo->nome;

        $html = View::make('relatorios.relatoriosEixos', compact('atividades', 'eixoNome'))->render();

        return Pdf::loadHTML($html)->setPaper('A4', 'portrait')->download("relatorio_do_eixo_{$eixoNome}.pdf");
    }

    public function gerarDadosGraficos()
    {
        $atividades = Atividade::with('eixos', 'publico', 'canais')->get();

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
            $eixo = Eixo::find($id);
            return ['name' => $eixo?->nome ?? 'Desconhecido', 'y' => $count];
        })->values();

        $graficoPublico = collect($publicoCount)->map(function ($count, $id) {
            $publico = Publico::find($id);
            return ['name' => $publico?->nome ?? 'Desconhecido', 'y' => $count];
        })->values();

        $graficoEventos = collect($eventosCount)->map(function ($count, $id) {
            return ['name' => $id == 1 ? 'Presencial' : 'Online', 'y' => $count];
        })->values();

        $graficoCanais = collect($canaisCount)->map(function ($count, $id) {
            $canal = Canal::find($id);
            return ['name' => $canal?->nome ?? 'Desconhecido', 'y' => $count];
        })->values();

        return [
            'graficoEixos' => $graficoEixos,
            'graficoPublico' => $graficoPublico,
            'graficoEventos' => $graficoEventos,
            'graficoCanais' => $graficoCanais,
            'atividades' => $atividades,
            'eixos' => Eixo::all(),
            'canais' => Canal::all(),
            'publicos' => Publico::all(),
        ];
    }
}
