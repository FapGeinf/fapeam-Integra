<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use app\Http\Middleware\VerifyCsrfToken;
use App\Models\Risco;
use App\Models\Unidade;
use App\Models\Monitoramento;
use Illuminate\Support\Facades\Log;

class RiscoController extends Controller
{
    public function index()
    {
        $riscos = Risco::all();
        $unidades = Unidade::all();
        return view('riscos.index', ['riscos' => $riscos, 'unidades' => $unidades]);
    }

    public function create()
    {
        $unidades = Unidade::all();
        return view('riscos.store', ['unidades' => $unidades]);
    }

    public function store(Request $request)
    {
        try {
            $request->validate([
                'riscoEvento' => 'required|string|max:255',
                'riscoCausa' => 'required|string|max:255',
                'riscoConsequencia' => 'required|string|max:255',
                'riscoAvaliacao' => 'required|string|max:255',
                'unidadeId' => 'required|exists:unidades,id',
                'monitoramentos' => 'required|array|min:1',
                'monitoramentos.*.monitoramentoControleSugerido' => 'required|string|max:255',
                'monitoramentos.*.statusMonitoramento' => 'required|string|max:255',
                'monitoramentos.*.execucaoMonitoramento' => 'required|string|max:255'
            ]);

            $risco = Risco::create([
                'riscoEvento' => $request->riscoEvento,
                'riscoCausa' => $request->riscoCausa,
                'riscoConsequencia' => $request->riscoConsequencia,
                'riscoAvaliacao' => $request->riscoAvaliacao,
                'unidadeId' => $request->unidadeId,
                'userIdRisco' => auth()->id()
            ]);
            dd($request->all());


            // Criação dos monitoramentos associados ao risco
            foreach ($request->monitoramentos as $monitoramentoData) {
                Monitoramento::create([
                    'monitoramentoControleSugerido' => $monitoramentoData['monitoramentoControleSugerido'],
                    'statusMonitoramento' => $monitoramentoData['statusMonitoramento'],
                    'execucaoMonitoramento' => $monitoramentoData['execucaoMonitoramento'],
                    'riscoFK' => $risco->id
                ]);
            }

            return redirect()->route('riscos.index')->with('success', 'Risco criado com sucesso!');
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['errors' => $e->getMessage()]);
        }
    }

    public function edit()
    {
        $unidades = Unidade::all();
        return view('riscos.edit', ['unidades' => $unidades]);
    }

    public function update(Request $request, $id)
    {
        $risco = Risco::findorFail($id);

        try {
            $request->validate([
                'riscoEvento' => 'required',
                'riscoCausa' => 'required',
                'riscoConsequencia' => 'required',
                'riscoAvaliacao' => 'required',
                'unidadeRiscoFK' => 'required'
            ]);

            $atualizaRisco =  $risco->update([
                'riscoEvento' => $request->riscoEvento,
                'riscoCausa' => $request->riscoCausa,
                'riscoConsequencia' => $request->riscoConsequencia,
                'riscoAvaliacao' => $request->riscoAvaliacao,
            ]);

            if (!$atualizaRisco) {
                return redirect()->back()->with('errors', 'Houve um erro no processo de edição:');
            } else {
                return redirect()->route('riscos.show')->with('success', 'Risco editado com sucesso');
            }
        } catch (\Exception $e) {
            return redirect()->back()->with('errors', $e->getMessage());
        }
    }

    public function delete($id)
    {
        $risco = Risco::findorFail($id);

        $deleteRisco = $risco->delete();

        if (!$deleteRisco) {
            return redirect()->back()->with('errors', 'Erro ao deletar o risco');
        }

        return redirect()->back()->with('success', 'Risco Deletado com sucesso');
    }

    public function __construct()
    {
        $this->middleware('auth');
    }
}
