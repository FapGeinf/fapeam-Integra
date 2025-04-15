<?php

namespace App\Http\Controllers;

use App\Models\Eixo;
use DB;
use Exception;
use Illuminate\Http\Request;
use App\Models\Risco;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\Atividade;
use App\Models\Monitoramento;
use App\Models\Unidade;
use App\Models\Canal;
use App\Models\Publico;
use Log;



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
        try {
            $atividades = Atividade::count();
            $eixos = Eixo::all();
            $canais = Canal::all();
            $publicos = Publico::all();

            $atividades = Atividade::with('eixos', 'publico', 'canais')->get();

            $eixosCount = [];
            $publicoCount = [];
            $eventosCount = [];
            $canaisCount = [];

            foreach ($atividades as $atividade) {
                foreach ($atividade->eixos as $eixo) {
                    if (!isset($eixosCount[$eixo->id])) {
                        $eixosCount[$eixo->id] = 0;
                    }
                    $eixosCount[$eixo->id]++;
                }

                $publico = $atividade->publico;
                if ($publico) {
                    if (!isset($publicoCount[$publico->id])) {
                        $publicoCount[$publico->id] = 0;
                    }
                    $publicoCount[$publico->id]++;
                }

                $tipoEventoId = $atividade->tipo_evento;
                if ($tipoEventoId) {
                    if (!isset($eventosCount[$tipoEventoId])) {
                        $eventosCount[$tipoEventoId] = 0;
                    }
                    $eventosCount[$tipoEventoId]++;
                }

                foreach ($atividade->canais as $canal) {
                    if (!isset($canaisCount[$canal->id])) {
                        $canaisCount[$canal->id] = 0;
                    }
                    $canaisCount[$canal->id]++;
                }
            }

            $graficoEixos = [];
            foreach ($eixosCount as $eixoId => $count) {
                $eixo = Eixo::find($eixoId);
                $graficoEixos[] = [
                    'name' => $eixo ? $eixo->nome : 'Desconhecido',
                    'y' => $count,
                ];
            }

            $graficoPublico = [];
            foreach ($publicoCount as $publicoId => $count) {
                $publicoObj = Publico::find($publicoId);
                $graficoPublico[] = [
                    'name' => $publicoObj ? $publicoObj->nome : 'Desconhecido',
                    'y' => $count,
                ];
            }

            $graficoEventos = [];
            foreach ($eventosCount as $eventoId => $count) {
                $nomeEvento = $eventoId == 1 ? 'Presencial' : 'Online';
                $graficoEventos[] = [
                    'name' => $nomeEvento,
                    'y' => $count,
                ];
            }

            $graficoCanais = [];
            foreach ($canaisCount as $canalId => $count) {
                $canalObj = Canal::find($canalId);
                $graficoCanais[] = [
                    'name' => $canalObj ? $canalObj->nome : 'Desconhecido',
                    'y' => $count,
                ];
            }

            return view('graficos.index', [
                'graficoEixos' => $graficoEixos,
                'graficoPublico' => $graficoPublico,
                'graficoEventos' => $graficoEventos,
                'graficoCanais' => $graficoCanais,
                'eixos' => $eixos,
                'canais' => $canais,
                'publicos' => $publicos,
                'atividades' => $atividades
            ]);
        } catch (Exception $e) {
            return redirect()->route('graficos.index')->with('error', 'Ocorreu um erro ao carregar os gráficos. Tente novamente mais tarde.');
        }
    }

    public function relatoriosPorEixo($id)
    {
        try {
            $atividades = Atividade::whereHas('eixos', function ($query) use ($id) {
                $query->where('eixos.id', $id);
            })->orderBy('data_prevista')->get();

            $eixo = Eixo::findOrFail($id);

            $eixoNome = $eixo->nome;

            if (!$atividades) {
                return redirect()->back()->with('error', 'Não foi encontrada atividades com este eixo');
            }
            $html = view('relatorios.relatoriosEixos', compact('atividades','eixoNome'))->render();

            $pdf = Pdf::loadHTML($html)->setPaper('A4', 'portrait');

            return $pdf->download('relatorio_do_eixo_'.$eixoNome.'.pdf');
        } catch (Exception $e) {
            Log::error('Houve um erro ao fazer o downloado do relatorio por eixo', [
                'error' => $e->getMessage()
            ]);
            return redirect()->back()->withErrors('Houve um erro inesperado ao fazer o download do relatorio por eixo');
        }
    }

}

