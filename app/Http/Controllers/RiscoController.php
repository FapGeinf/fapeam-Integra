<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use app\Http\Middleware\VerifyCsrfToken;
use App\Models\Risco;
use App\Models\Unidade;
use App\Models\Monitoramento;
use App\Models\Resposta;
use App\Models\Prazo;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Log;

class RiscoController extends Controller
{
    public function index()
    {
        try {
            $user = auth()->user();
            $prazo = Prazo::latest()->first();

            if ($user->unidade->unidadeTipoFK == 1) {
                // Caso o usuário seja de um tipo de unidade igual a 1
                $riscos = Risco::all();
                $monitoramentos = Monitoramento::all();
            } else {
                // Caso o usuário seja de um tipo de unidade diferente de 1
                $riscos = Risco::where('unidadeId', $user->unidade->unidadeTipoFK)->get();
                $monitoramentos = Monitoramento::whereIn('riscoFK', $riscos->pluck('id'))->get();
            }

            // Contagem de todos os riscos
            $riscosAbertos = $riscos->count();

            // Contagem de todos os riscos do dia atual
            $riscosAbertosHoje = Risco::whereDate('created_at', \Carbon\Carbon::today())->count();

            return view('riscos.index', [
                'riscos' => $riscos,
                'monitoramentos' => $monitoramentos,
                'prazo' => $prazo ? $prazo->data : null,
                'riscosAbertos' => $riscosAbertos,
                'riscosAbertosHoje' => $riscosAbertosHoje,
            ]);
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['errors' => 'Ocorreu um erro ao carregar os riscos. Por favor, tente novamente.']);
        }
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
            $validatedData = $request->validate([
                'riscoNum' => 'required',
                'responsavelRisco' => 'required',
                'riscoEvento' => 'required|string|max:9000',
                'riscoCausa' => 'required|string|max:9000',
                'riscoConsequencia' => 'required|string|max:9000',
                'riscoAno' => 'required',
                'nivel_de_risco' => 'required|integer',
                'unidadeId' => 'required|exists:unidades,id',
                'monitoramentos' => 'required|array|min:1',
                'monitoramentos.*.monitoramentoControleSugerido' => 'required|string|max:9000',
                'monitoramentos.*.statusMonitoramento' => 'required|string',
                'monitoramentos.*.execucaoMonitoramento' => 'required|string|max:9000',
                'monitoramentos.*.inicioMonitoramento' => 'required|date',
                'monitoramentos.*.fimMonitoramento' => 'nullable|date'
            ]);

            // Verifica se o número de risco já existe para a unidade
            $numriscoExistente = Risco::where('riscoNum', $validatedData['riscoNum'])
                ->where('unidadeId', $validatedData['unidadeId'])
                ->exists();

            if ($numriscoExistente) {
                return redirect()->back()->withErrors(['errors' => 'Número de risco já existe para essa unidade.']);
            }

            // Cria um novo registro de risco
            $risco = Risco::create([
                'riscoNum' => $validatedData['riscoNum'],
                'responsavelRisco' => $validatedData['responsavelRisco'],
                'riscoEvento' => $validatedData['riscoEvento'],
                'riscoCausa' => $validatedData['riscoCausa'],
                'riscoConsequencia' => $validatedData['riscoConsequencia'],
                'nivel_de_risco' => $validatedData['nivel_de_risco'],
                'unidadeId' => $validatedData['unidadeId'],
                'riscoAno' => $validatedData['riscoAno'],
                'userIdRisco' => auth()->id()
            ]);

            // Cria monitoramentos associados ao risco
            foreach ($validatedData['monitoramentos'] as $monitoramentoData) {
                Monitoramento::create([
                    'monitoramentoControleSugerido' => $monitoramentoData['monitoramentoControleSugerido'],
                    'statusMonitoramento' => $monitoramentoData['statusMonitoramento'],
                    'execucaoMonitoramento' => $monitoramentoData['execucaoMonitoramento'],
                    'inicioMonitoramento' => $monitoramentoData['inicioMonitoramento'],
                    'fimMonitoramento' => $monitoramentoData['fimMonitoramento'] ?? null,
                    'isContinuo' => $monitoramentoData['isContinuo'] ?? false,
                    'riscoFK' => $risco->id
                ]);
            }

            return redirect()->route('riscos.index')->with('success', 'Risco criado com sucesso!');
        } catch (\Exception $e) {
            Log::error('Erro ao criar risco: ' . $e->getMessage());
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
        try {
            $risco = Risco::findOrFail($id);

            $numRiscoExistente = Risco::where('riscoNum', $request->riscoNum)
                ->where('unidadeId', $request->unidadeId)
                ->where('id', '!=', $id)
                ->exists();

            if ($numRiscoExistente) {
                return redirect()->back()->withErrors(['errors' => 'Número de risco já existe para essa unidade.']);
            }

            $risco->update($request->all());

            return redirect()->route('riscos.show', ['id' => $risco->id])->with('success', 'Risco editado com sucesso');
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['errors' => 'Ocorreu um erro ao atualizar o risco.']);
        }
    }

    public function editMonitoramentos($id)
    {
        $risco = Risco::findOrFail($id);
        return view('riscos.monitoramentos', compact('risco'));
    }

    public function updateMonitoramentos(Request $request, $id)
    {
        $risco = Risco::findOrFail($id);

        try {
            $request->validate([
                'monitoramentos' => 'required|array',
                'monitoramentos.*.id' => 'nullable|exists:monitoramentos,id',
                'monitoramentos.*.monitoramentoControleSugerido' => 'required|string|max:9000',
                'monitoramentos.*.statusMonitoramento' => 'required|string|max:9000',
                'monitoramentos.*.execucaoMonitoramento' => 'required|string|max:9000',
                'monitoramentos.*.inicioMonitoramento' => 'required|date',
                'monitoramentos.*.fimMonitoramento' => 'nullable|date',
                'monitoramentos.*.isContinuo' => 'required|boolean', // Adicionei validação para isContinuo
            ]);

            $existingMonitoramentos = $risco->monitoramentos->keyBy('id');

            foreach ($request->monitoramentos as $monitoramentoData) {
                if (isset($monitoramentoData['id'])) {
                    if ($existingMonitoramentos->has($monitoramentoData['id'])) {
                        $monitoramento = $existingMonitoramentos->get($monitoramentoData['id']);

                        // Atualiza os dados do monitoramento existente
                        $monitoramento->update([
                            'monitoramentoControleSugerido' => $monitoramentoData['monitoramentoControleSugerido'],
                            'statusMonitoramento' => $monitoramentoData['statusMonitoramento'],
                            'execucaoMonitoramento' => $monitoramentoData['execucaoMonitoramento'],
                            'isContinuo' => $monitoramentoData['isContinuo'],
                            'inicioMonitoramento' => $monitoramentoData['inicioMonitoramento'],
                            'fimMonitoramento' => $monitoramentoData['isContinuo'] ? null : $monitoramentoData['fimMonitoramento'],
                        ]);

                        // Remove o monitoramento da lista de existentes
                        unset($existingMonitoramentos[$monitoramentoData['id']]);
                    } else {
                        throw new \Exception('Monitoramento não encontrado para atualização.');
                    }
                } else {
                    // Cria um novo monitoramento
                    $newMonitoramentoData = [
                        'monitoramentoControleSugerido' => $monitoramentoData['monitoramentoControleSugerido'],
                        'statusMonitoramento' => $monitoramentoData['statusMonitoramento'],
                        'execucaoMonitoramento' => $monitoramentoData['execucaoMonitoramento'],
                        'isContinuo' => $monitoramentoData['isContinuo'],
                        'inicioMonitoramento' => $monitoramentoData['inicioMonitoramento'],
                        'fimMonitoramento' => $monitoramentoData['isContinuo'] ? null : $monitoramentoData['fimMonitoramento'],
                        'riscoFK' => $risco->id,
                    ];

                    Monitoramento::create($newMonitoramentoData);
                }
            }

            // Remove os monitoramentos que não foram atualizados ou criados
            foreach ($existingMonitoramentos as $monitoramento) {
                $monitoramento->delete();
            }

            return redirect()->route('riscos.show', ['id' => $risco->id])->with('success', 'Monitoramentos editados com sucesso');
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['errors' => 'Houve um erro ao atualizar ou adicionar monitoramentos']);
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
                'respostas.*.respostaRisco' => 'required|string|max:9000',
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

    public function insertPrazo(Request $request)
    {
        try {
            $request->validate([
                'data' => 'required|date'
            ]);

            $prazoExistente = Prazo::first();

            if ($prazoExistente) {
                $prazoExistente->delete();
            }

            $novoPrazo = Prazo::create([
                'data' => $request->data
            ]);

            if (!$novoPrazo) {
                return redirect()->back()->with('error', 'Erro ao inserir um Prazo');
            }

            return redirect()->back()->with('success', 'Prazo Inserido com sucesso');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Um erro ocorreu: ' . $e->getMessage());
        }
    }



    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('checkAccess');
    }
}
