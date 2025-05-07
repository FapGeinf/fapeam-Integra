<?php

namespace App\Http\Controllers;

use App\Services\RelatorioService;
use Exception;
use Log;

class RelatorioController extends Controller
{
    protected $relatorioService;

    public function __construct(RelatorioService $relatorioService)
    {
        $this->relatorioService = $relatorioService;
    }

    public function gerarRelatorioGeral()
    {
        $pdf = $this->relatorioService->gerarRelatorioGeral();
        return $pdf->download('relatorio_de_riscos.pdf');
    }

    public function graficosIndex()
    {
        try {
            $dados = $this->relatorioService->gerarDadosGraficos();
            return view('graficos.index', $dados);
        } catch (Exception $e) {
            return redirect()->route('graficos.index')->with('error', 'Erro ao carregar os gráficos.');
        }
    }

    public function relatoriosPorEixo($id)
    {
        try {
            return $this->relatorioService->gerarRelatorioPorEixo($id);
        } catch (Exception $e) {
            Log::error('Erro ao gerar relatório por eixo', ['error' => $e->getMessage()]);
            return redirect()->back()->withErrors('Erro inesperado ao gerar o relatório.');
        }
    }
}
