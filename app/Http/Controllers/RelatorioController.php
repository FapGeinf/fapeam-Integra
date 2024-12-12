<?php

namespace App\Http\Controllers;

use App\Models\Eixo;
use DB;
use Illuminate\Http\Request;
use App\Models\Risco;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\Atividade;
use App\Models\Monitoramento;
use App\Models\Unidade;


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

    public function graficosIndex(Request $request)
    {

        $ano = $request->input('ano');
        $unidadeId = $request->input('unidade');
        $eixoId = $request->input('eixo');
        $nivelDeRisco = $request->input('nivel_de_risco');
        $isContinuo = $request->input('isContinuo');
        $statusMonitoramento = $request->input('statusMonitoramento');

        $totalAtividades = Atividade::count();
        $totalRiscos = Risco::count();
        $totalMonitoramentos = Monitoramento::count();
        $totalEixos = Eixo::count();

        $monitoramentosTipos = Monitoramento::select('isContinuo', DB::raw('COUNT(*) as total'))
            ->groupBy('isContinuo')
            ->when($isContinuo !== null, function ($query) use ($isContinuo) {
                return $query->where('isContinuo', (bool) $isContinuo);
            })
            ->get();

        $monitoramentosStatus = Monitoramento::select('statusMonitoramento', DB::raw('COUNT(*) as total'))
            ->groupBy('statusMonitoramento')
            ->when($statusMonitoramento != null, function ($query) use ($statusMonitoramento) {
                return $query->where('statusMonitoramento', $statusMonitoramento);
            })
            ->get();

        $atividadesPorEixo = Atividade::select('eixo_id', DB::raw('COUNT(*) as total'))
            ->groupBy('eixo_id')
            ->with('eixo')
            ->when($eixoId, function ($query) use ($eixoId) {
                return $query->where('eixo_id', $eixoId);
            })
            ->get();

        $riscosPorUnidade = Risco::select('unidadeId', DB::raw('COUNT(*) as total'))
            ->groupBy('unidadeId')
            ->with('unidade')
            ->when($unidadeId, function ($query) use ($unidadeId) {
                return $query->where('unidadeId', $unidadeId);
            })
            ->get();

        $riscosPorNivel = Risco::select('nivel_de_risco', DB::raw('COUNT(*) as total'))
            ->groupBy('nivel_de_risco')
            ->when($nivelDeRisco, function ($query) use ($nivelDeRisco) {
                return $query->where('nivel_de_risco', $nivelDeRisco);
            })
            ->get();

        $riscosPorAno = Risco::select(DB::raw('riscoAno'), DB::raw('COUNT(*) as total'))
            ->groupBy(DB::raw('riscoAno'))
            ->when($ano, function ($query) use ($ano) {
                return $query->where('riscoAno', $ano);
            })
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


        $anos = Risco::distinct()->pluck('riscoAno');
        $unidades = Unidade::all();
        $eixos = Eixo::all();

        return view('graficos.index', compact(
            'totalRiscos',
            'totalMonitoramentos',
            'totalAtividades',
            'totalEixos',
            'atividadesData',
            'riscosUnidadeData',
            'riscosNivelData',
            'riscosAnoData',
            'monitoramentosTipos',
            'monitoramentosStatus',
            'isContinuo',
            'statusMonitoramento',
            'anos',
            'unidades',
            'eixos'
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

