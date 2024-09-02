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
use Illuminate\Support\Facades\Storage;


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
        try {
            $risco = Risco::findOrFail($id);
            $monitoramentos = Monitoramento::where('riscoFK', $risco->id)->get();
            foreach ($monitoramentos as $monitoramento) {
                $monitoramento->respostas = Resposta::where('respostaMonitoramentoFK', $monitoramento->id)->get();
            }
            return view('riscos.show', [
                'risco' => $risco,
                'monitoramentos' => $monitoramentos
            ]);
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['errors' => 'Ocorreu um erro ao carregar os dados do risco.']);
        }
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
                'monitoramentos.*.isContinuo' => 'required|boolean',
                'monitoramentos.*.anexoMonitoramento' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:2048',
            ]);

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

            foreach ($validatedData['monitoramentos'] as $monitoramentoData) {
                if (!$monitoramentoData['isContinuo'] && isset($monitoramentoData['fimMonitoramento']) && $monitoramentoData['fimMonitoramento'] <= $monitoramentoData['inicioMonitoramento']) {
                    $aux = $monitoramentoData['fimMonitoramento'];
                    $monitoramentoData['fimMonitoramento'] = $monitoramentoData['inicioMonitoramento'];
                    $monitoramentoData['inicioMonitoramento'] = $aux;
                }

                if (isset($monitoramentoData['anexoMonitoramento'])) {
                    $file = $monitoramentoData['anexoMonitoramento'];
                    $monitoramentoData['anexoMonitoramento'] = $file->store('anexosMonitoramento', 'public');
                } else {
                    $monitoramentoData['anexoMonitoramento'] = null; // Garante que o campo seja nulo se não houver anexo
                }


                Monitoramento::create([
                    'monitoramentoControleSugerido' => $monitoramentoData['monitoramentoControleSugerido'],
                    'statusMonitoramento' => $monitoramentoData['statusMonitoramento'],
                    'inicioMonitoramento' => $monitoramentoData['inicioMonitoramento'],
                    'fimMonitoramento' => $monitoramentoData['fimMonitoramento'] ?? null,
                    'isContinuo' => $monitoramentoData['isContinuo'] ?? false,
                    'anexoMonitoramento' => $monitoramentoData['anexoMonitoramento'],
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



    public function insertMonitoramentos(Request $request, $id)
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
                'monitoramentos.*.anexoMonitoramento' => 'nullable|file|mimes:pdf,doc,docx,jpg,png|max:2048',
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


                        if (isset($monitoramentoData['anexoMonitoramento']) && $monitoramentoData['anexoMonitoramento']->isValid()) {
                            $file = $monitoramentoData['anexoMonitoramento'];
                            $monitoramentoData['anexoMonitoramento'] = $file->store('anexosMonitoramento', 'public');
                        } else {
                            $monitoramentoData['anexoMonitoramento'] = $monitoramento->anexoMonitoramento;
                        }

                        $monitoramento->update([
                            'monitoramentoControleSugerido' => $monitoramentoData['monitoramentoControleSugerido'],
                            'statusMonitoramento' => $monitoramentoData['statusMonitoramento'],
                            'isContinuo' => $monitoramentoData['isContinuo'],
                            'inicioMonitoramento' => $monitoramentoData['inicioMonitoramento'],
                            'fimMonitoramento' => $monitoramentoData['isContinuo'] ? null : $monitoramentoData['fimMonitoramento'],
                            'anexoMonitoramento' => $monitoramentoData['anexoMonitoramento'],
                        ]);
                        unset($existingMonitoramentos[$monitoramentoData['id']]);
                    } else {
                        throw new \Exception('Monitoramento não encontrado para atualização.');
                    }
                } else {
                    $newMonitoramentoData = [
                        'monitoramentoControleSugerido' => $monitoramentoData['monitoramentoControleSugerido'],
                        'statusMonitoramento' => $monitoramentoData['statusMonitoramento'],
                        'isContinuo' => $monitoramentoData['isContinuo'],
                        'inicioMonitoramento' => $monitoramentoData['inicioMonitoramento'],
                        'fimMonitoramento' => $monitoramentoData['isContinuo'] ? null : $monitoramentoData['fimMonitoramento'],
                        'riscoFK' => $risco->id,
                        'anexoMonitoramento' => isset($monitoramentoData['anexoMonitoramento']) && $monitoramentoData['anexoMonitoramento']->isValid() ? $monitoramentoData['anexoMonitoramento']->store('anexosMonitoramento', 'public') : null,
                    ];

                    Monitoramento::create($newMonitoramentoData);
                }
            }

            foreach ($existingMonitoramentos as $monitoramento) {
                    $monitoramento->delete();
            }

            return redirect()->route('riscos.show', ['id' => $risco->id])->with('success', 'Monitoramentos editados com sucesso');
        } catch (\Exception $e) {
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

        try {
            $monitoramento = Monitoramento::findOrFail($id);

            $monitoramentoData = [
                'monitoramentoControleSugerido' => $request->input('monitoramentoControleSugerido'),
                'statusMonitoramento' => $request->input('statusMonitoramento'),
                'isContinuo' => $request->input('isContinuo'),
                'inicioMonitoramento' => $request->input('inicioMonitoramento'),
                'fimMonitoramento' => $request->input('fimMonitoramento'),
            ];

            if ($request->hasFile('anexoMonitoramento')) {
                if ($monitoramento->anexoMonitoramento) {
                    Storage::disk('public')->delete($monitoramento->anexoMonitoramento);
                }

                $monitoramentoData['anexoMonitoramento'] = $request->file('anexoMonitoramento')->store('anexos', 'public');
            }


            $monitoramento->update($monitoramentoData);

            $riscoId = $monitoramento->riscoFK;

            return redirect()->route('riscos.show', ['id' => $riscoId])
                ->with('success', 'Monitoramento atualizado com sucesso!');
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return redirect()->back()->withErrors(['error' => 'Monitoramento não encontrado.']);
        } catch (\Exception $e) {
            Log::error('Erro ao atualizar o monitoramento: ' . $e->getMessage());
            return redirect()->back()->withErrors(['error' => 'Ocorreu um erro ao atualizar o monitoramento. Por favor, tente novamente.']);
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
        $monitoramento = Monitoramento::findOrFail($id);

        try {
            $request->validate([
                'respostas' => 'required|array|min:1',
                'respostas.*.respostaRisco' => 'required|string|max:5000',
                'respostas.*.anexo' => 'nullable|file|mimes:jpg,png,pdf|max:2048'
            ]);

            foreach ($request->respostas as $index => $respostaData) {
                $filePath = null;
                if (isset($respostaData['anexo']) && $request->hasFile("respostas.$index.anexo")) {
                    $filePath = $request->file("respostas.$index.anexo")->store('anexos', 'public');
                }

                Resposta::create([
                    'respostaRisco' => $respostaData['respostaRisco'],
                    'respostaMonitoramentoFK' => $monitoramento->id,
                    'user_id' => auth()->id(),
                    'anexo' => $filePath
                ]);
            }

            return redirect()->route('riscos.respostas', $id)->with('success', 'Respostas adicionadas com sucesso');
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['errors' => $e->getMessage()]);
        }
    }

    public function updateResposta(Request $request, $id)
    {

        $request->validate([
            'respostaRisco' => 'required|string|max:5000',
            'anexo' => 'nullable|file|mimes:jpg,png,pdf|max:2048',
        ]);

        try {

            $resposta = Resposta::findOrFail($id);


            $resposta->respostaRisco = $request->input('respostaRisco');


            if ($request->hasFile('anexo')) {
                if ($resposta->anexo) {
                    Storage::disk('public')->delete($resposta->anexo);
                }

                $resposta->anexo = $request->file('anexo')->store('anexos', 'public');
            }

            $resposta->save();

            return redirect()->route('riscos.respostas', ['id' => $resposta->respostaMonitoramentoFK])
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
        $monitoramento = Monitoramento::with('respostas')->findorFail($id);
        $respostas = Resposta::where('respostaMonitoramentoFK', $monitoramento->id)->get();
        return view('riscos.respostas', ['monitoramento' => $monitoramento, 'respostas' => $respostas]);
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
