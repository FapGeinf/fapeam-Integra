<?php

namespace App\Http\Controllers;
use App\Services\LogService;
use App\Services\MonitoramentoService;
use App\Services\PrazoService;
use App\Services\RespostaService;
use Illuminate\Http\Request;
use App\Mail\ResponseNotification;
use App\Models\Monitoramento;
use App\Models\Notification;
use App\Models\Resposta;
use App\Models\User;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use App\Services\RiscoService;

class RiscoController extends Controller
{

    protected $log, $risco, $monitoramento, $resposta, $prazo;

    public function index()
    {
        try {
            $dados = $this->risco->indexRiscos();
            $usuarioNome = Auth::user()->name;
            $this->log->insertLog([
                'acao' => 'Acesso',
                'descricao' => "O usuario $usuarioNome acessou a tela de Riscos",
                'user_id' => Auth::user()->id
            ]);
            return view('riscos.index', $dados);
        } catch (Exception $e) {
            return redirect()->back()->withErrors(['error' => 'Ocorreu um erro ao carregar os riscos. Por favor, tente novamente.']);
        }
    }
    public function analise()
    {

        try {
            $dados = $this->risco->indexAnalise();
            $usuarioNome = Auth::user()->name;
            $this->log->insertLog([
                'acao' => 'Acesso',
                'descricao' => "O usuario $usuarioNome acessou a tela de Riscos",
                'user_id' => Auth::user()->id
            ]);
            return view('riscos.analise', $dados);
        } catch (Exception $e) {
            return redirect()->back()->withErrors(['error' => 'Ocorreu um erro ao carregar os riscos. Por favor, tente novamente.']);
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
    public function show($id)
    {
        try {
            $dados = $this->risco->showRisco($id);
            $usuarioNome = Auth::user()->name;
            $this->log->insertLog([
                'acao' => 'Acesso',
                'descricao' => "O usuario $usuarioNome acessou a o risco de $id",
                'user_id' => Auth::user()->id
            ]);
            return view('riscos.show', $dados);
        } catch (Exception $e) {
            return redirect()->back()->withErrors('Ocorreu um erro ao carregar os dados do risco.');
        }
    }
    public function create()
    {
        $dados = $this->risco->formStoreRisco();
        $usuarioNome = Auth::user()->name;
        $this->log->insertLog([
            'acao' => 'Acesso',
            'descricao' => "O usuario $usuarioNome acessou a tela de inserção de Riscos",
            'user_id' => Auth::user()->id
        ]);
        return view('riscos.store', $dados);
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
                'probabilidade' => 'required|integer',
                'impacto' => 'required|integer',
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
            $risco = $this->risco->insertRisco($validatedData);
            $usuarioNome = Auth::user()->name;
            $this->log->insertLog([
                'acao' => 'Inserção',
                'descricao' => "O usuario $usuarioNome inseriu um risco de id $risco->id",
                'user_id' => Auth::user()->id
            ]);
            return redirect()->route('riscos.index')->with('success', 'Risco criado com sucesso!');
        } catch (Exception $e) {
            Log::error('Erro ao criar risco: ' . $e->getMessage());
            return redirect()->back()->withErrors('Ocorreu um erro ao criar o risco. Por favor, tente novamente.')->withInput();
        }
    }
    public function edit($id)
    {
        $dados = $this->risco->formEditRisco($id);
        $usuarioNome = Auth::user()->name;
        $this->log->insertLog([
            'acao' => 'Acesso',
            'descricao' => "O usuario $usuarioNome acessou a tela de edição do risco de $id",
            'user_id' => Auth::user()->id
        ]);
        return view('riscos.edit', $dados);
    }

    public function update(Request $request, $id)
    {
        try {
            $risco = $this->risco->updateRisco($id, $request->all());
            $usuarioNome = Auth::user()->name;
            $this->log->insertLog([
                'acao' => 'Atualização',
                'descricao' => "O usuario $usuarioNome atualizou o Risco de $id",
                'user_id' => Auth::user()->id
            ]);
            return redirect()->route('riscos.show', ['id' => $risco->id])->with('success', 'Risco editado com sucesso');
        } catch (Exception $e) {
            return redirect()->back()->withErrors('Ocorreu um erro ao atualizar o risco.');
        }
    }

    public function delete($id)
    {
        $this->risco->deleteRisco($id);
        $usuarioNome = Auth::user()->name;
        $this->log->insertLog([
            'acao' => 'Exclusão',
            'descricao' => "O usuario $usuarioNome deletou um risco de $id",
            'user_id' => Auth::user()->id
        ]);
        return redirect()->back()->with(['success' => 'Risco Deletado com sucesso']);
    }

    public function editMonitoramentos($id)
    {
        $risco = $this->monitoramento->formInsertMonitoramentos($id);
        return view('riscos.monitoramentos', compact('risco'));
    }

    public function editMonitoramento2($id)
    {
        $monitoramento = $this->monitoramento->findMonitoramentoById($id);

        Log::info('Editando monitoramento:', [
            'monitoramento' => $monitoramento->toArray(),
        ]);
        return view('riscos.editMonitoramento', [
            'monitoramento' => $monitoramento,
        ]);
    }

    public function insertMonitoramentos(Request $request, $id)
    {
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

            $result = $this->monitoramento->insertMonitoramentos($validatedData, $id);

            $usuarioNome = Auth::user()->name;
            $this->log->insertLog([
                'acao' => 'Inserção',
                'descricao' => "O usuario $usuarioNome inseriu uma lista de monitoramentos",
                'user_id' => Auth::user()->id
            ]);

            return redirect()->route('riscos.show', ['id' => $id])
                ->with('success', 'Controles Sugeridos inseridos com sucesso');
        } catch (Exception $e) {
            Log::error('Error inserting Controles Sugeridos:', [
                'exception_message' => $e->getMessage(),
                'exception_trace' => $e->getTraceAsString(),
            ]);

            return redirect()->back()->withErrors(['errors' => 'Houve um erro ao inserir Controles Sugeridos']);
        }
    }

    public function atualizaMonitoramento(Request $request, $id)
    {
        try {
            $validatedData = $request->validate([
                'monitoramentoControleSugerido' => 'required|string',
                'statusMonitoramento' => 'required|string',
                'isContinuo' => 'required|boolean',
                'inicioMonitoramento' => 'required|date',
                'fimMonitoramento' => 'nullable|date|after_or_equal:inicioMonitoramento',
                'anexoMonitoramento' => 'nullable|file|mimes:jpeg,png,pdf|max:51200'
            ]);

            $monitoramento = $this->monitoramento->updateMonitoramento($id, $validatedData);

            $usuarioNome = Auth::user()->name;
            $this->log->insertLog([
                'acao' => 'Atualização',
                'descricao' => "O usuario $usuarioNome atualizou um controle sugerido de $id",
                'user_id' => Auth::user()->id
            ]);

            return redirect()->route('riscos.show', ['id' => $monitoramento->riscoFK])
                ->with('success', 'Controle Sugerido atualizado com sucesso!');
        } catch (Exception $e) {
            Log::error('Erro ao atualizar controle sugerido:', [
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
                'request' => $request->all()
            ]);

            return back()->with('error', 'Ocorreu um erro ao atualizar o controle sugerido.')->withInput();
        }
    }


    public function deleteMonitoramento($id)
    {
        try {
            $this->monitoramento->destroyMonitoramento($id);

            $usuarioNome = Auth::user()->name;
            $this->log->insertLog([
                'acao' => 'Exclusão',
                'descricao' => "O usuario $usuarioNome deletou um controle sugerido de $id",
                'user_id' => Auth::user()->id
            ]);

            return redirect()->back()->with(['success' => 'Controle Sugerido deletado com sucesso']);
        } catch (Exception $e) {
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
        try {
            Log::info('Storing resposta for monitoramento', ['monitoramento_id' => $id]);
            $validatedData = $request->validate([
                'respostaRisco' => 'required|string|max:5000',
                'anexo' => 'nullable|file|mimes:jpg,png,pdf|max:102400'
            ]);
            $resposta = $this->resposta->insertRespostas($id, $validatedData);
            $usuarioNome = Auth::user()->name;
            $this->log->insertLog([
                'acao' => 'Acesso',
                'descricao' => "O usuario $usuarioNome inseriu uma nova providência de id $resposta->id",
                'user_id' => Auth::user()->id
            ]);
            return redirect()->route('riscos.respostas', $id)->with('success', 'Respostas adicionadas com sucesso');
        } catch (Exception $e) {
            Log::error('Error storing resposta', [
                'error' => $e->getMessage(),
                'monitoramento_id' => $id
            ]);
            return redirect()->back()->withErrors(['errors' => $e->getMessage()]);
        }
    }

    public function updateResposta(Request $request, $id)
    {
        try {

            $validatedData = $request->validate([
                'respostaRisco' => 'required|string|max:5000',
                'anexo' => 'nullable|file|mimes:jpg,png,pdf|max:102400',
            ]);

            $resposta = $this->resposta->updateResposta($id, $validatedData);

            $usuarioNome = Auth::user()->name;
            $this->log->insertLog([
                'acao' => 'Atualização',
                'descricao' => "O usuario $usuarioNome atualizou a resposta de $id",
                'user_id' => Auth::user()->id
            ]);

            return redirect()->route('riscos.respostas', ['id' => $resposta->respostaMonitoramentoFk])
                ->with('success', 'Resposta atualizada com sucesso!');
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return redirect()->back()->withErrors(['error' => 'Resposta não encontrada.']);
        } catch (Exception $e) {
            Log::error('Erro ao atualizar a resposta: ' . $e->getMessage());
            return redirect()->back()->withErrors(['error' => 'Ocorreu um erro ao atualizar a resposta. Por favor, tente novamente.']);
        }
    }

    public function deleteAnexo(Request $request, $id)
    {
        try {
            $this->resposta->destroyAnexo($id);
            $usuarioNome = Auth::user()->name;
            $this->log->insertLog([
                'acao' => 'Exclusão',
                'descricao' => "O usuario $usuarioNome deletou o anexo da resposta $id",
                'user_id' => Auth::user()->id
            ]);

            return redirect()->back()->with('success', 'Anexo deletado com sucesso');
        } catch (Exception $e) {

            Log::error('Error deleting anexo for Resposta ID: ' . $id . '. Error: ' . $e->getMessage());

            return redirect()->back()->with('errors', 'Houve um erro ao deletar o anexo selecionado');
        }
    }

    public function respostas($id)
    {
        $dados = $this->resposta->showRespostas($id);
        $usuarioNome = Auth::user()->name;
        $this->log->insertLog([
            'acao' => 'Acesso',
            'descricao' => "O usuario $usuarioNome acessou a tela de Controle Sugerido com id $id",
            'user_id' => Auth::user()->id
        ]);
        return view('riscos.respostas', $dados);
    }

    public function homologar($id)
    {
        try {
            $homologacao = $this->resposta->homologacaoResposta($id);

            $usuarioNome = Auth::user()->name;
            $this->log->insertLog([
                'acao' => 'Homologação',
                'descricao' => "O usuario $usuarioNome homologou a resposta de $id",
                'user_id' => Auth::user()->id
            ]);

            return redirect()->back()
                ->with('success', $homologacao['mensagem'])
                ->with('homologacao', $homologacao['dataConcat']);
        } catch (Exception $e) {
            Log::error('Erro ao homologar resposta: ' . $e->getMessage(), [
                'id' => $id,
                'stack' => $e->getTraceAsString()
            ]);
            return redirect()->back()->with('error', 'Ocorreu um erro ao tentar homologar a resposta. Tente novamente.');
        }
    }

    public function insertPrazo(Request $request)
    {
        try {
            $validatedData = $request->validate([
                'data' => 'required|date'
            ]);

            $this->prazo->storePrazo($validatedData);

            $usuarioNome = Auth::user()->name;
            $this->log->insertLog([
                'acao' => 'Inserção',
                'descricao' => "O usuario $usuarioNome inseriu um novo prazo",
                'user_id' => Auth::user()->id
            ]);

            return redirect()->back()->with('success', 'Prazo Inserido com sucesso');
        } catch (Exception $e) {
            return redirect()->back()->with('error', 'Um erro ocorreu: ' . $e->getMessage());
        }
    }

    public function indexRespostas()
    {
        $dados = $this->resposta->indexRespostas();
        $diretoriaId = $dados['diretoriaId'];

        $usuarioNome = Auth::user()->name;

        $this->log->insertLog([
            'acao' => 'Acesso',
            'descricao' => "O usuário $usuarioNome acessou a tela de providências da diretoria de ID {$diretoriaId}",
            'user_id' => Auth::user()->id
        ]);

        return view('respostas.index',$dados);
    }


    public function __construct(LogService $log, RiscoService $risco, MonitoramentoService $monitoramento, RespostaService $resposta, PrazoService $prazo)
    {
        $this->middleware('auth');
        // $this->middleware('checkAccess');
        $this->log = $log;
        $this->risco = $risco;
        $this->monitoramento = $monitoramento;
        $this->resposta = $resposta;
        $this->prazo = $prazo;
    }
}
