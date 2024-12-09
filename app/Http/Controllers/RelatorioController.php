<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Risco;
use Barryvdh\DomPDF\Facade\Pdf;

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

}

