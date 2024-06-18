<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use app\Http\Middleware\VerifyCsrfToken;
use App\Models\Risco;
use App\Models\Unidade;
use App\Models\Monitoramento;
use App\Models\Resposta;
use Illuminate\Support\Facades\Log;

class RiscoController extends Controller
{
    public function index()
    {
        $riscos = Risco::all();
        $unidades = Unidade::all();
        return view('riscos.index', ['riscos' => $riscos, 'unidades' => $unidades]);
    }

    public function show($id)
    {
        $risco = Risco::with('respostas')->findOrFail($id);
        $respostas = Resposta::where('respostaRiscoFK', $risco->id)->get();
        $monitoramentos = Monitoramento::where('riscoFK', $risco->id)->get();
        return view('riscos.show', ['risco' => $risco, 'respostas' => $respostas, 'monitoramentos' => $monitoramentos]);
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
                'probabilidade_risco' => 'required|integer|min:1',
                'impacto_risco' => 'required|integer|min:1',
                'unidadeId' => 'required|exists:unidades,id',
                'monitoramentos' => 'required|array|min:1',
                'monitoramentos.*.monitoramentoControleSugerido' => 'required|string|max:255',
                'monitoramentos.*.statusMonitoramento' => 'required|string|max:255',
                'monitoramentos.*.execucaoMonitoramento' => 'required|string|max:255'
            ]);

            $riscoAvaliacao = (int) ($request->probabilidade_risco * $request->impacto_risco);

            $risco = Risco::create([
                'riscoEvento' => $request->riscoEvento,
                'riscoCausa' => $request->riscoCausa,
                'riscoConsequencia' => $request->riscoConsequencia,
                'probabilidade_risco' => $request->probabilidade_risco,
                'impacto_risco' => $request->impacto_risco,
                'riscoAvaliacao' => $riscoAvaliacao,
                'unidadeId' => $request->unidadeId,
                'userIdRisco' => auth()->id()
            ]);

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
            return redirect()->back()->withErrors(['errors' => 'Ocorreu um erro ao criar o risco. Por favor, tente novamente.']);
        }
    }

    public function edit($id)
    {
        $unidades = Unidade::all();
        $risco = Risco::findOrFail($id);
        return view('riscos.edit', ['risco' => $risco, 'unidades' => $unidades]);
    }

    public function update(Request $request, $id)
    {
        $risco = Risco::findOrFail($id);

        try {
            $request->validate([
                'riscoEvento' => 'required|string|max:255',
                'riscoCausa' => 'required|string|max:255',
                'riscoConsequencia' => 'required|string|max:255',
                'probabilidade_risco' => 'required|integer|min:1',
                'impacto_risco' => 'required|integer|min:1',
                'unidadeId' => 'required|exists:unidades,id',
                'monitoramentos' => 'nullable|array',
                'monitoramentos.*.monitoramentoControleSugerido' => 'required|string|max:255',
                'monitoramentos.*.statusMonitoramento' => 'required|string|max:255',
                'monitoramentos.*.execucaoMonitoramento' => 'required|string|max:255'
            ]);

            $riscoAvaliacao = (int) ($request->probabilidade_risco * $request->impacto_risco);

            $risco->update([
                'riscoEvento' => $request->riscoEvento,
                'riscoCausa' => $request->riscoCausa,
                'riscoConsequencia' => $request->riscoConsequencia,
                'probabilidade_risco' => $request->probabilidade_risco,
                'impacto_risco' => $request->impacto_risco,
                'riscoAvaliacao' => $riscoAvaliacao,
                'unidadeId' => $request->unidadeId,
            ]);

            if ($request->has('monitoramentos')) {
                foreach ($request->monitoramentos as $monitoramentoData) {
                    if (isset($monitoramentoData['id'])) {
                        $monitoramento = Monitoramento::findOrFail($monitoramentoData['id']);
                        $monitoramento->update([
                            'monitoramentoControleSugerido' => $monitoramentoData['monitoramentoControleSugerido'],
                            'statusMonitoramento' => $monitoramentoData['statusMonitoramento'],
                            'execucaoMonitoramento' => $monitoramentoData['execucaoMonitoramento'],
                            'riscoFK' => $risco->id
                        ]);
                    } else {
                        Monitoramento::create([
                            'monitoramentoControleSugerido' => $monitoramentoData['monitoramentoControleSugerido'],
                            'statusMonitoramento' => $monitoramentoData['statusMonitoramento'],
                            'execucaoMonitoramento' => $monitoramentoData['execucaoMonitoramento'],
                            'riscoFK' => $risco->id
                        ]);
                    }
                }
            }

            return redirect()->route('riscos.index')->with(['success' => 'Riscos e monitoramentos atualizados com sucesso']);
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['errors' => 'Ocorreu um erro ao atualizar o risco. Por favor, tente novamente.']);
        }
    }

    public function delete($id)
    {
        $risco = Risco::findorFail($id);

        $deleteRisco = $risco->delete();

        if (!$deleteRisco) {
            return redirect()->back()->withErrors(['errors' => 'Houve um erro ao deletar o risco']);
        }

        return redirect()->back()->with(['success' => 'Risco Deletado com sucesso']);
    }

    public function deleteMonitoramento($id)
    {
        $monitoramento = Monitoramento::findOrFail($id);

        try {
            $deleteMonitoramento = $monitoramento->delete();

            if (!$deleteMonitoramento) {
                return redirect()->back()->withErrors(['errors' => 'Houve um erro ao deletar o monitoramento']);
            }

            return redirect()->back()->with(['success' => 'Monitoramento deletado com sucesso']);
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['errors' => $e->getMessage()]);
        }
    }



    public function storeResposta(Request $request, $id)
    {
        $risco = Risco::findOrFail($id);

        try {
            $request->validate([
                'respostas' => 'required|array|min:1',
                'respostas.*.respostaRisco' => 'required|string|max:255',
            ]);

            if (is_array($request->respostas)) {
                foreach ($request->respostas as $respostaData) {
                    Resposta::create([
                        'respostaRisco' => $respostaData['respostaRisco'],
                        'respostaRiscoFK' => $risco->id,
                        'user_id' => auth()->id()
                    ]);
                }
            }
            return redirect()->route('riscos.respostas', $id)->with('success', 'Respostas adicionadas com sucesso');
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['errors' => $e->getMessage()]);
        }
    }

    public function respostas($id)
    {
        $risco = Risco::with('respostas')->findorFail($id);
        $respostas = Resposta::where('respostaRiscoFK', $risco->id)->get();
        return view('riscos.respostas', ['risco' => $risco, 'respostas' => $respostas]);
    }


    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('checkAccess');
    }
}
