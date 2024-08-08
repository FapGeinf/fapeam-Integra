<?php

namespace App\Http\Controllers;

use App\Events\PrazoProximo;
use Illuminate\Http\Request;
use app\Http\Middleware\VerifyCsrfToken;
use App\Models\Risco;
use App\Models\Unidade;
use App\Models\Monitoramento;
use App\Models\Notification;
use App\Models\Resposta;
use App\Models\Prazo;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
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
            } else {
                // Caso o usuário seja de um tipo de unidade diferente de 1
                $riscos = Risco::where('unidadeId', $user->unidade->id)->get();
            }

            // Contagem de todos os riscos
            $riscosAbertos = $riscos->count();

            // Contagem de todos os riscos do dia atual
            $riscosAbertosHoje = Risco::whereDate('created_at', \Carbon\Carbon::today())->count();

            $notificacoes = Notification::where('global', true)->get();

            return view('riscos.index', [
                'riscos' => $riscos,
                'prazo' => $prazo ? $prazo->data : null,
                'riscosAbertos' => $riscosAbertos,
                'riscosAbertosHoje' => $riscosAbertosHoje,
                'notificacoes' => $notificacoes
            ]);
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['errors' => 'Ocorreu um erro ao carregar os riscos. Por favor, tente novamente.']);
        }
    }

    public function marcarComoLida($id)
    {
        $notification = Notification::find($id);
        if ($notification) {
            $notification->update(['read_at' => now()]);
        }

        return redirect()->back();
    }

    public function marcarComoLidas(Request $request)
    {
        Notification::query()->update(['read_at' => now()]);

        return redirect()->back();
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
                'responsavelRisco' => 'required',
                'riscoEvento' => 'max:9000',
                'riscoCausa' => 'max:9000',
                'riscoConsequencia' => 'max:9000',
                'riscoAno' => 'required',
                'nivel_de_risco' => 'required|integer',
                'unidadeId' => 'required|exists:unidades,id',
                'monitoramentos' => 'required|array|min:1',
                'monitoramentos.*.monitoramentoControleSugerido' => 'max:9000',
                'monitoramentos.*.statusMonitoramento' => 'required|string',
                'monitoramentos.*.inicioMonitoramento' => 'required|date',
                'monitoramentos.*.fimMonitoramento' => 'nullable|date',
                'monitoramentos.*.isContinuo' => 'required|boolean', // Adicionei validação para isContinuo
            ]);

            // Cria um novo registro de risco
            $risco = Risco::create([
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
                if (!$monitoramentoData['isContinuo'] && isset($monitoramentoData['fimMonitoramento']) && $monitoramentoData['fimMonitoramento'] <= $monitoramentoData['inicioMonitoramento']) {
                    $aux = $monitoramentoData['fimMonitoramento'];
                    $monitoramentoData['fimMonitoramento'] = $monitoramentoData['inicioMonitoramento'];
                    $monitoramentoData['inicioMonitoramento'] = $aux;
                }
                $monitoramento = Monitoramento::create([
                    'monitoramentoControleSugerido' => $monitoramentoData['monitoramentoControleSugerido'],
                    'statusMonitoramento' => $monitoramentoData['statusMonitoramento'],
                    // 'execucaoMonitoramento' => $monitoramentoData['execucaoMonitoramento'],
                    'inicioMonitoramento' => $monitoramentoData['inicioMonitoramento'],
                    'fimMonitoramento' => $monitoramentoData['fimMonitoramento'] ?? null,
                    'isContinuo' => $monitoramentoData['isContinuo'] ?? false,
                    'riscoFK' => $risco->id
                ]);
            }

            return redirect()->route('riscos.index')->with('success', 'Risco criado com sucesso!');
        } catch (\Exception $e) {
            dd($e);
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

    public function editMonitoramento2($id)
    {

        $monitoramento = Monitoramento::findOrFail($id);


        return view('riscos.editMonitoramento', [
            'monitoramento' => $monitoramento
        ]);
    }


    public function updateMonitoramentos(Request $request, $id)
    {
        $risco = Risco::findOrFail($id);

        try {
            $request->validate([
                'monitoramentos' => 'required|array',
                'monitoramentos.*.id' => 'nullable|exists:monitoramentos,id',
                'monitoramentos.*.monitoramentoControleSugerido' => 'max:9000',
                'monitoramentos.*.statusMonitoramento' => 'max:9000',
                'monitoramentos.*.inicioMonitoramento' => 'required|date',
                'monitoramentos.*.fimMonitoramento' => 'nullable|date',
                'monitoramentos.*.isContinuo' => 'required|boolean',
            ]);

            $existingMonitoramentos = $risco->monitoramentos->keyBy('id');

            foreach ($request->monitoramentos as $monitoramentoData) {
                if (isset($monitoramentoData['id'])) {
                    if ($existingMonitoramentos->has($monitoramentoData['id'])) {
                        $monitoramento = $existingMonitoramentos->get($monitoramentoData['id']);

                        if (!$monitoramentoData['isContinuo'] && isset($monitoramentoData['fimMonitoramento']) && $monitoramentoData['fimMonitoramento'] <= $monitoramentoData['inicioMonitoramento']) {
                            $aux = $monitoramentoData['fimMonitoramento'];
                            $monitoramentoData['fimMonitoramento'] = $monitoramentoData['inicioMonitoramento'];
                            $monitoramentoData['inicioMonitoramento'] = $aux;
                        }

                        // Atualiza os dados do monitoramento existente
                        $monitoramento->update([
                            'monitoramentoControleSugerido' => $monitoramentoData['monitoramentoControleSugerido'],
                            'statusMonitoramento' => $monitoramentoData['statusMonitoramento'],
                            // 'execucaoMonitoramento' => $monitoramentoData['execucaoMonitoramento'],
                            'isContinuo' => $monitoramentoData['isContinuo'],
                            'inicioMonitoramento' => $monitoramentoData['inicioMonitoramento'],
                            'fimMonitoramento' => $monitoramentoData['isContinuo'] ? null : $monitoramentoData['fimMonitoramento'],
                        ]);

                        // Validar se fimMonitoramento é maior que inicioMonitoramento se fornecido
                        if (
                            !$monitoramentoData['isContinuo'] && isset($monitoramentoData['fimMonitoramento']) &&
                            $monitoramentoData['fimMonitoramento'] <= $monitoramentoData['inicioMonitoramento']
                        ) {
                            return redirect()->back()->withErrors(['errors' => 'A data do fim do Monitoramento deve ser maior do que a data do início do monitoramento.']);
                        }

                        // Remove o monitoramento da lista de existentes
                        unset($existingMonitoramentos[$monitoramentoData['id']]);
                    } else {
                        throw new \Exception('Monitoramento não encontrado para atualização.');
                    }
                } else {
                    // Cria um novo monitoramento

                    if (!$monitoramentoData['isContinuo'] && isset($monitoramentoData['fimMonitoramento']) && $monitoramentoData['fimMonitoramento'] <= $monitoramentoData['inicioMonitoramento']) {
                        $aux = $monitoramentoData['fimMonitoramento'];
                        $monitoramentoData['fimMonitoramento'] = $monitoramentoData['inicioMonitoramento'];
                        $monitoramentoData['inicioMonitoramento'] = $aux;
                    }
                    $newMonitoramentoData = [
                        'monitoramentoControleSugerido' => $monitoramentoData['monitoramentoControleSugerido'],
                        'statusMonitoramento' => $monitoramentoData['statusMonitoramento'],
                        // 'execucaoMonitoramento' => $monitoramentoData['execucaoMonitoramento'],
                        'isContinuo' => $monitoramentoData['isContinuo'],
                        'inicioMonitoramento' => $monitoramentoData['inicioMonitoramento'],
                        'fimMonitoramento' => $monitoramentoData['isContinuo'] ? null : $monitoramentoData['fimMonitoramento'],
                        'riscoFK' => $risco->id,
                    ];

                    // Validar se fimMonitoramento é maior que inicioMonitoramento se fornecido
                    // if (
                    //     !$monitoramentoData['isContinuo'] && isset($monitoramentoData['fimMonitoramento']) &&
                    //     $monitoramentoData['fimMonitoramento'] <= $monitoramentoData['inicioMonitoramento']
                    // ) {
                    //     return redirect()->back()->withErrors(['errors' => 'A data do fim do Monitoramento deve ser maior do que a data do início do monitoramento.']);
                    // }

                    Monitoramento::create($newMonitoramentoData);
                }
            }

            // Remove os monitoramentos que não foram atualizados ou criados
            foreach ($existingMonitoramentos as $monitoramento) {
                $monitoramento->delete();
            }

            return redirect()->route('riscos.show', ['id' => $risco->id])->with('success', 'Monitoramentos editados com sucesso');
        } catch (\Exception $e) {
            dd($e);
            return redirect()->back()->withErrors(['errors' => 'Houve um erro ao atualizar ou adicionar monitoramentos']);
        }
    }

    public function atualizaMonitoramento(Request $request, $id)
    {

        $request->validate([
            'monitoramentoControleSugerido' => 'required|string',
            'statusMonitoramento' => 'required|string',
            'isContinuo' => 'required|boolean',
            'inicioMonitoramento' => 'required|date',
            'fimMonitoramento' => 'nullable|date|after_or_equal:inicioMonitoramento',
        ]);


        $monitoramento = Monitoramento::findOrFail($id);


        $monitoramento->update([
            'monitoramentoControleSugerido' => $request->input('monitoramentoControleSugerido'),
            'statusMonitoramento' => $request->input('statusMonitoramento'),
            'isContinuo' => $request->input('isContinuo'),
            'inicioMonitoramento' => $request->input('inicioMonitoramento'),
            'fimMonitoramento' => $request->input('fimMonitoramento'),
        ]);

        $riscoId = $monitoramento->riscoFK;

        return redirect()->route('riscos.show', ['id' => $riscoId])
            ->with('success', 'Monitoramento atualizado com sucesso!');
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
                'respostas.*.respostaRisco' => 'required|string|max:5000',
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

    public function updateResposta(Request $request, $id)
    {
        $request->validate([
            'respostaRisco' => 'required|string',
        ]);

        try {
            $resposta = Resposta::findOrFail($id);

            $resposta->update([
                'respostaRisco' => $request->input('respostaRisco'),
            ]);

            return redirect()->route('riscos.respostas', ['id' => $resposta->respostaRiscoFK])
                ->with('success', 'Resposta atualizada com sucesso!');
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return redirect()->back()->withErrors(['error' => 'Resposta não encontrada.']);
        } catch (\Exception $e) {
            Log::error('Erro ao atualizar a resposta: ' . $e->getMessage());
            return redirect()->back()->withErrors(['error' => 'Ocorreu um erro ao atualizar a resposta. Por favor, tente novamente.']);
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

            event(new PrazoProximo($novoPrazo));

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
