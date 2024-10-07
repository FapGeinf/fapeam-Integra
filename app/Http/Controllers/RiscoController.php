<?php

namespace App\Http\Controllers;

use App\Events\NovaRespostaCriada;
use App\Events\PrazoProximo;
use Illuminate\Http\Request;
use app\Http\Middleware\VerifyCsrfToken;
use App\Mail\ResponseNotification;
use App\Models\Risco;
use App\Models\Unidade;
use App\Models\Monitoramento;
use App\Models\Notification;
use App\Models\Resposta;
use App\Models\Prazo;
use App\Models\User;
use Carbon\Carbon;
use Exception;
use FFI\Exception as FFIException;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;





class RiscoController extends Controller
{
    public function index()
    {
        try {
            $user = auth()->user();
            $prazo = Prazo::latest()->first();

            if ($user->unidade->unidadeTipoFK == 1) {
                $riscos = Risco::all();
            } else {
                $riscos = Risco::where('unidadeId', $user->unidade->id)->get();
            }

            $riscosAbertos = $riscos->count();


            $riscosAbertosHoje = Risco::whereDate('created_at', \Carbon\Carbon::today())->count();


            $notificacoes = $this->filtraNotificacoes();


            $notificacoesNaoLidas = $notificacoes->whereNull('read_at');
            $notificacoesLidas = $notificacoes->whereNotNull('read_at');

            return view('riscos.index', [
                'riscos' => $riscos,
                'prazo' => $prazo ? $prazo->data : null,
                'riscosAbertos' => $riscosAbertos,
                'riscosAbertosHoje' => $riscosAbertosHoje,
                'notificacoes' => $notificacoes,
                'notificacoesNaoLidas' => $notificacoesNaoLidas,
                'notificacoesLidas' => $notificacoesLidas,
            ]);
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['errors' => 'Ocorreu um erro ao carregar os riscos. Por favor, tente novamente.']);
        }
    }



    public function markAsRead(Request $request)
    {
        $notificationIds = $request->input('notification_ids');

        if ($notificationIds) {
            Notification::whereIn('id', $notificationIds)->update(['read_at' => now()]);
            return redirect()->route('riscos.index')->with('success', 'Notificações marcadas como lidas com sucesso.');
        }

        return redirect()->route('riscos.index')->with('error', 'Erro ao marcar notificações como lidas.');
    }



    private function filtraNotificacoes()
    {
        try {
            $user = auth()->user();
            $unidadeTipoId = $user->unidade->unidadeTipo->id;

            switch ($unidadeTipoId) {
                case 1:
                    $notificacoesTipo1 = Notification::where('global', false)
                        ->where('user_id', $user->id)
                        ->get();

                    Log::info('Notificações do tipo 1', ['notificacoes' => $notificacoesTipo1]);

                    return $notificacoesTipo1;

                    break;

                case 2:
                    $notificacoesTipo2 = Notification::where('global', false)
                        ->where('user_id', $user->id)
                        ->whereHas('monitoramento.risco.unidade', function ($query) use ($user) {
                            $query->where('unidadeId', $user->unidade->unidadeIdFK);
                        })
                        ->get();

                    Log::info('Notificações do tipo 2', ['notificacoes' => $notificacoesTipo2]);

                    return $notificacoesTipo2;

                    break;

                default:

                    Log::info('Tipo de unidade não reconhecido', ['unidade_tipo' => $unidadeTipoId]);
                    return collect();
            }
        } catch (Exception $e) {
            Log::error('Error filtering notifications', ['error' => $e->getMessage()]);
            return collect();
        }
    }





    public function show($id)
    {
        try {
            $risco = Risco::with(['monitoramentos'])->findOrFail($id);
            return view('riscos.show', [
                'risco' => $risco,
                'monitoramentos' => $risco->monitoramentos
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
                'monitoramentos.*.fimMonitoramento' => 'nullable|date|after:monitoramentos.*.inicioMonitoramento',
                'monitoramentos.*.isContinuo' => 'required|boolean',
                'monitoramentos.*.anexoMonitoramento' => 'nullable|file|mimes:jpeg,png,pdf|max:51200'
            ]);

            // Criação do risco
            $risco = Risco::create([
                'responsavelRisco' => $validatedData['responsavelRisco'],
                'riscoEvento' => $validatedData['riscoEvento'],
                'riscoCausa' => $validatedData['riscoCausa'],
                'riscoConsequencia' => $validatedData['riscoConsequencia'],
                'nivel_de_risco' => (int)$validatedData['nivel_de_risco'], // Converter para inteiro
                'unidadeId' => $validatedData['unidadeId'],
                'riscoAno' => $validatedData['riscoAno'],
                'userIdRisco' => auth()->id()
            ]);

            foreach ($validatedData['monitoramentos'] as $index => $monitoramentoData) {
                $isContinuo = filter_var($monitoramentoData['isContinuo'], FILTER_VALIDATE_BOOLEAN);

                if (!$isContinuo && isset($monitoramentoData['fimMonitoramento']) && $monitoramentoData['fimMonitoramento'] <= $monitoramentoData['inicioMonitoramento']) {
                    throw new \Exception('Fim do monitoramento não pode ser anterior ao início do monitoramento.');
                }

                $path = null;
                if ($request->hasFile("monitoramentos.$index.anexoMonitoramento")) {
                    $file = $request->file("monitoramentos.$index.anexoMonitoramento");
                    $filename = time() . '_' . $file->getClientOriginalName();
                    $path = $file->storeAs('public/anexos', $filename);
                }

                $monitoramento = Monitoramento::create([
                    'monitoramentoControleSugerido' => $monitoramentoData['monitoramentoControleSugerido'],
                    'statusMonitoramento' => $monitoramentoData['statusMonitoramento'],
                    'inicioMonitoramento' => $monitoramentoData['inicioMonitoramento'],
                    'fimMonitoramento' => $monitoramentoData['fimMonitoramento'] ?? null,
                    'isContinuo' => $isContinuo,
                    'riscoFK' => $risco->id,
                    'anexoMonitoramento' => $path // Armazena o caminho do arquivo diretamente
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


        Log::info('Editando monitoramento:', [
            'monitoramento' => $monitoramento->toArray(),
        ]);

        return view('riscos.editMonitoramento', [
            'monitoramento' => $monitoramento,
        ]);
    }




    public function insertMonitoramentos(Request $request, $id)
    {
        $risco = Risco::findOrFail($id);

        try {
            $validatedData = $request->validate([
                'monitoramentos' => 'required|array',
                'monitoramentos.*.monitoramentoControleSugerido' => 'max:9000',
                'monitoramentos.*.statusMonitoramento' => 'max:9000',
                'monitoramentos.*.inicioMonitoramento' => 'required|date',
                'monitoramentos.*.fimMonitoramento' => 'nullable|date|after_or_equal:inicioMonitoramento',
                'monitoramentos.*.isContinuo' => 'required|boolean',
                'monitoramentos.*.anexoMonitoramento' => 'nullable|file|mimes:pdf,doc,docx,jpg,png|max:51200',
            ]);

            foreach ($validatedData['monitoramentos'] as $index => $monitoramentoData) {
                $isContinuo = filter_var($monitoramentoData['isContinuo'], FILTER_VALIDATE_BOOLEAN);

                if (!$isContinuo && isset($monitoramentoData['fimMonitoramento']) && $monitoramentoData['fimMonitoramento'] <= $monitoramentoData['inicioMonitoramento']) {
                    throw new \Exception('Fim do monitoramento não pode ser anterior ao início do monitoramento.');
                }

                $path = null;
                if ($request->hasFile("monitoramentos.$index.anexoMonitoramento")) {
                    $file = $request->file("monitoramentos.$index.anexoMonitoramento");
                    $filename = time() . '_' . $file->getClientOriginalName();
                    $path = $file->storeAs('public/anexos', $filename);
                }

                $monitoramento = Monitoramento::create([
                    'monitoramentoControleSugerido' => $monitoramentoData['monitoramentoControleSugerido'],
                    'statusMonitoramento' => $monitoramentoData['statusMonitoramento'],
                    'inicioMonitoramento' => $monitoramentoData['inicioMonitoramento'],
                    'fimMonitoramento' => $monitoramentoData['fimMonitoramento'] ?? null,
                    'isContinuo' => $isContinuo,
                    'riscoFK' => $risco->id,
                    'anexoMonitoramento' => $path
                ]);
            }

            return redirect()->route('riscos.show', ['id' => $risco->id])
                ->with('success', 'Monitoramentos inseridos com sucesso');
        } catch (\Exception $e) {
            Log::error('Error inserting monitoramentos:', [
                'exception_message' => $e->getMessage(),
                'exception_trace' => $e->getTraceAsString(),
            ]);

            return redirect()->back()->withErrors(['errors' => 'Houve um erro ao inserir monitoramentos']);
        }
    }

    public function atualizaMonitoramento(Request $request, $id)
    {
        try {
            $request->validate([
                'monitoramentoControleSugerido' => 'required|string',
                'statusMonitoramento' => 'required|string',
                'isContinuo' => 'required|boolean',
                'inicioMonitoramento' => 'required|date',
                'fimMonitoramento' => 'nullable|date|after_or_equal:inicioMonitoramento',
                'anexoMonitoramento' => 'nullable|file|mimes:jpeg,png,pdf|max:51200'
            ]);

            $monitoramento = Monitoramento::findOrFail($id);

            $monitoramento->update([
                'monitoramentoControleSugerido' => $request->input('monitoramentoControleSugerido'),
                'statusMonitoramento' => $request->input('statusMonitoramento'),
                'isContinuo' => $request->input('isContinuo'),
                'inicioMonitoramento' => $request->input('inicioMonitoramento'),
                'fimMonitoramento' => $request->input('fimMonitoramento'),
            ]);

            Log::info('Monitoramento atualizado:', $monitoramento->toArray());


            if ($request->hasFile('anexoMonitoramento')) {
                Log::info('Novo anexo recebido.');

                if ($monitoramento->anexoMonitoramento) {
                    Storage::delete($monitoramento->anexoMonitoramento);
                    Log::info('Anexo antigo excluído:', ['path' => $monitoramento->anexoMonitoramento]);
                }

                $file = $request->file('anexoMonitoramento');
                $filename = time() . '_' . $file->getClientOriginalName();
                $path = $file->storeAs('public/anexos', $filename);

                Log::info('Novo arquivo enviado:', ['filename' => $filename, 'path' => $path]);

                $monitoramento->anexoMonitoramento = $path;
                $monitoramento->save();

                Log::info('Novo anexo salvo no monitoramento.', ['path' => $path]);
            } else {
                Log::info('Nenhum novo anexo recebido.');
            }

            Log::info('Atualização de monitoramento concluída com sucesso.');

            return redirect()->route('riscos.show', ['id' => $monitoramento->riscoFK])
                ->with('success', 'Monitoramento atualizado com sucesso!');
        } catch (\Illuminate\Validation\ValidationException $e) {
            Log::error('Erro de validação ao atualizar monitoramento:', [
                'errors' => $e->errors(),
                'request' => $request->all()
            ]);
            return back()->withErrors($e->errors())->withInput();
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            Log::error('Monitoramento não encontrado:', ['id' => $id]);
            return redirect()->route('riscos.index')->with('error', 'Monitoramento não encontrado.');
        } catch (\Illuminate\Contracts\Filesystem\FileNotFoundException $e) {
            Log::error('Erro ao tentar excluir o anexo antigo:', ['path' => $monitoramento->anexoMonitoramento]);
            return back()->with('error', 'Erro ao tentar excluir o anexo antigo. Por favor, tente novamente.');
        } catch (\Exception $e) {
            Log::error('Erro inesperado ao atualizar monitoramento:', [
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            return back()->with('error', 'Ocorreu um erro inesperado. Por favor, tente novamente.')->withInput();
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


    private function sendEmail(Resposta $resposta, Monitoramento $monitoramento, Notification $notification)
    {
        try {
            if ($resposta) {
                $users = User::all();
                Mail::to(auth()->user())->send(new ResponseNotification($notification, $monitoramento));
            }
        } catch (Exception $e) {
            Log::error('Houve um erro ao enviar um email: ' . $e->getMessage());
            throw new Exception('Houve um erro ao enviar o email');
        }
    }


    public function storeResposta(Request $request, $id)
    {
        $monitoramento = Monitoramento::findOrFail($id);
        $risco = Risco::findOrFail($monitoramento->riscoFK);

        try {
            Log::info('Storing resposta for monitoramento', ['monitoramento_id' => $monitoramento->id]);

            $request->validate([
                'respostaRisco' => 'required|string|max:5000',
                'anexo' => 'nullable|file|mimes:jpg,png,pdf|max:51200'
            ]);

            $filePath = null;
            if ($request->hasFile('anexo')) {
                $filePath = $request->file('anexo')->store('anexos', 'public');
                Log::info('File uploaded', ['file_path' => $filePath]);
            } else {
                Log::info('No file uploaded');
            }

            $resposta = Resposta::create([
                'respostaRisco' => $request->respostaRisco,
                'respostaMonitoramentoFK' => $monitoramento->id,
                'user_id' => auth()->id(),
                'anexo' => $filePath
            ]);

            $monitoramento->update([
                'statusMonitoramento' => $request->input('statusMonitoramento')
            ]);

            Log::info('Updated statusMonitoramento', [
                'monitoramento_id' => $monitoramento->id,
                'new_status' => $monitoramento->statusMonitoramento
            ]);

            Log::info('Resposta created', ['resposta_id' => $resposta->id]);

            $unitId = $risco->unidadeId;
            $usersForUnit = User::where('unidadeIdFK', $unitId)->get();
            $subcomissaoUnit = Unidade::where('unidadeNome', 'Subcomissão do Programa de Integridade')->first();
            $usersForSubcomissao = User::where('unidadeIdFK', $subcomissaoUnit->id)->get();
            $allUsers = $usersForUnit->merge($usersForSubcomissao)->unique('id');

            Log::info('Attaching notification to users', ['user_count' => $allUsers->count()]);

            foreach ($allUsers as $user) {
                $formattedDateTime = Carbon::parse($resposta->created_at)->format('d/m/Y \à\s H:i');
                $message = '<div><span>Nova mensagem!</span><br><br><div><span>Usuário: </span>' . htmlspecialchars($user->name) . '</div>' .
                    '<div><span>Unidade: </span>' . ($user->unidade ? htmlspecialchars($user->unidade->unidadeNome) : 'Desconhecida') . '</div>' .
                    '<div><span>Data do envio: </span>' . htmlspecialchars($formattedDateTime) . '</div><br>' .
                    '</div>';

                $notification = Notification::create([
                    'message' => $message,
                    'global' => false,
                    'monitoramentoId' => $monitoramento->id,
                    'user_id' => $user->id
                ]);

                Log::info('Notification created', ['notification_id' => $notification->id, 'user_id' => $user->id]);
            }



            return redirect()->route('riscos.respostas', $id)->with('success', 'Respostas adicionadas com sucesso');
        } catch (\Exception $e) {
            Log::error('Error storing resposta', [
                'error' => $e->getMessage(),
                'monitoramento_id' => $monitoramento->id
            ]);
            return redirect()->back()->withErrors(['errors' => $e->getMessage()]);
        }
    }





    public function updateResposta(Request $request, $id)
    {

        $request->validate([
            'respostaRisco' => 'required|string|max:5000',
            'anexo' => 'nullable|file|mimes:jpg,png,pdf|max:51200',
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

    public function deleteAnexo(Request $request, $id)
    {
        try {
            Log::info('Attempting to delete anexo for Resposta with ID: ' . $id);

            $resposta = Resposta::findOrFail($id);

            if ($resposta->anexo) {
                Log::info('Anexo found: ' . $resposta->anexo . ' for Resposta ID: ' . $id);

                Storage::disk('public')->delete($resposta->anexo);

                $resposta->anexo = null;
                $resposta->save();

                Log::info('Anexo deleted and Resposta updated for ID: ' . $id);
            } else {
                Log::info('No anexo found for Resposta ID: ' . $id);
            }

            return redirect()->back()->with('success', 'Anexo deletado com sucesso');
        } catch (Exception $e) {

            Log::error('Error deleting anexo for Resposta ID: ' . $id . '. Error: ' . $e->getMessage());

            return redirect()->back()->with('errors', 'Houve um erro ao deletar o anexo selecionado');
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
