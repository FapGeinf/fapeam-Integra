<?php

namespace App\Http\Controllers;

use App\Models\Eixo;
use DB;
use Illuminate\Http\Request;
use App\Models\Risco;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\Atividade;
use App\Models\Monitoramento;


class RelatorioController extends Controller
{
    public function gerarRelatorioGeral()
    {

        $riscos = Risco::with(['unidade', 'monitoramentos.respostas.user'])->get();

        $riscosAgrupados = $riscos->groupBy(function ($risco) {
            return $risco->unidade->id;
        });

        $html = view('relatorios.relatorioTemplate', compact('riscosAgrupados'))->render();

        $pdf = Pdf::loadHTML($html)->setPaper('A4', 'portrait');

        return $pdf->download('relatorio_de_riscos.pdf');
    }

    public function graficosIndex()
    {
        $totalAtividades = Atividade::count();
        $totalRiscos = Risco::count();
        $totalMonitoramentos = Monitoramento::count();
        $totalEixos = Eixo::count();

        $atividadesPorEixo = Atividade::select('eixo_id', DB::raw('COUNT(*) as total'))
            ->groupBy('eixo_id')
            ->with('eixo')
            ->get();

        $riscosPorUnidade = Risco::select('unidadeId', DB::raw('COUNT(*) as total'))
            ->groupBy('unidadeId')
            ->with('unidade')
            ->get();

        $riscosPorNivel = Risco::select('nivel_de_risco', DB::raw('COUNT(*) as total'))
            ->groupBy('nivel_de_risco')
            ->get();

        $riscosPorAno = Risco::select(DB::raw('riscoAno'), DB::raw('COUNT(*) as total'))
            ->groupBy(DB::raw('riscoAno'))
            ->orderBy(DB::raw('riscoAno'), 'asc') 
            ->get();

        $atividadesData = $atividadesPorEixo->map(function ($atividade) {
            return [
                'name' => $atividade->eixo->nome,
                'y' => $atividade->total,
            ];
        });

        $riscosUnidadeData = $riscosPorUnidade->map(function ($risco) {
            return [
                'name' => $risco->unidade->unidadeNome,
                'y' => $risco->total,
            ];
        });

        $riscosNivelData = $riscosPorNivel->map(function ($risco) {
            return [
                'name' => $this->getNivelDeRiscoLabel($risco->nivel_de_risco),
                'y' => $risco->total,
            ];
        });

       
        $riscosAnoData = $riscosPorAno->map(function ($risco) {
            return [
                'name' => $risco->riscoAno,
                'y' => $risco->total,
            ];
        });


        return view('graficos.index', compact(
            'totalRiscos',
            'totalMonitoramentos',
            'totalAtividades',
            'totalEixos',
            'atividadesData',
            'riscosUnidadeData',
            'riscosNivelData',
            'riscosAnoData'
        ));
    }

    private function getNivelDeRiscoLabel($nivel)
    {
        switch ($nivel) {
            case 1:
                return 'Baixo';
            case 2:
                return 'Médio';
            case 3:
                return 'Alto';
            default:
                return 'Desconhecido';
        }
    }

}

