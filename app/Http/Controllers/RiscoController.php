<?php

namespace App\Http\Controllers;
use App\Http\Requests\insertPrazoRequest;
use App\Http\Requests\StoreMonitoramentoRequest;
use App\Http\Requests\StoreRespostaRequest;
use App\Http\Requests\StoreRiscoRequest;
use App\Http\Requests\UpdateMonitoramentosRequest;
use App\Http\Requests\UpdateRespostaRequest;
use App\Services\MonitoramentoService;
use App\Services\PrazoService;
use App\Services\RespostaService;
use App\Services\RiscoService;
use Illuminate\Http\Request;
use App\Mail\ResponseNotification;
use App\Models\Monitoramento;
use App\Models\Notification;
use App\Models\Resposta;
use App\Models\User;
use Exception;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class RiscoController extends Controller
{
    protected $riscoService, $monitoramentoService, $respostaService, $prazoService;

    public function index()
    {
        try {
            $dados = $this->riscoService->indexRiscos();
            return view('riscos.index', $dados);
        } catch (Exception $e) {
            return redirect()->back()->withErrors(['errors' => 'Ocorreu um erro ao carregar os riscos. Por favor, tente novamente.']);
        }
    }

    public function analise()
    {
        try {
            $dados = $this->riscoService->analiseRiscos();
            return view('riscos.analise', $dados);
        } catch (Exception $e) {
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

    public function show($id)
    {
        try {
            $dados = $this->riscoService->show($id);
            return view('riscos.show', $dados);
        } catch (Exception $e) {
            return redirect()->back()->withErrors(['errors' => 'Ocorreu um erro ao carregar os dados do risco.']);
        }
    }

    public function create()
    {
        $dados = $this->riscoService->formCreateRisco();
        return view('riscos.store', $dados);
    }

    public function store(StoreRiscoRequest $request)
    {
        try {
            $validatedData = $request->validated();
            $this->riscoService->storeRisco($validatedData);
            return redirect()->route('riscos.index')->with('success', 'Risco criado com sucesso!');
        } catch (Exception $e) {
            Log::error('Erro ao criar risco: ' . $e->getMessage());
            return redirect()->back()->withErrors(['errors' => 'Ocorreu um erro ao criar o risco. Por favor, tente novamente.'])->withInput();
        }
    }

    public function edit($id)
    {
        $dados = $this->riscoService->editFormRisco($id);
        return view('riscos.edit', $dados);
    }

    public function update(Request $request, $id)
    {
        try {
            $risco = $this->riscoService->updateRisco($request->all(), $id);
            return redirect()->route('riscos.show', ['id' => $risco->id])->with('success', 'Risco editado com sucesso');
        } catch (Exception $e) {
            return redirect()->back()->withErrors(['errors' => 'Ocorreu um erro ao atualizar o risco.'])->withInput();
        }
    }

    public function editMonitoramentos($id)
    {
        $risco = $this->monitoramentoService->formEditMonitoramentos($id);
        return view('riscos.monitoramentos', compact('risco'));
    }

    public function editMonitoramento2($id)
    {
        $monitoramento = $this->monitoramentoService->formEditMonitoramento($id);
        return view('riscos.editMonitoramento', [
            'monitoramento' => $monitoramento,
        ]);
    }

    public function insertMonitoramentos(StoreMonitoramentoRequest $request, $id)
    {
        try {
            $validatedData = $request->validated();

            if (isset($validatedData['monitoramentos'])) {
                $monitoramentos = $this->monitoramentoService->storeMonitoramento($validatedData, $id);
            } else {
                $monitoramentos = $this->monitoramentoService->storeMonitoramento([$validatedData], $id);
            }

            return redirect()->route('riscos.show', ['id' => $id])
                ->with('success', 'Controles Sugeridos inseridos com sucesso');
        } catch (Exception $e) {
            Log::error('Error inserting Controles Sugeridos:', [
                'exception_message' => $e->getMessage(),
                'exception_trace' => $e->getTraceAsString(),
            ]);

            return redirect()->back()->withErrors(['errors' => 'Houve um erro ao inserir Controles Sugeridos'])->withInput();
        }
    }


    public function atualizaMonitoramento(UpdateMonitoramentosRequest $request, $id)
    {
        try {
            $validatedData = $request->validated();
            $monitoramento = $this->monitoramentoService->updateMonitoramento($id, $validatedData);
            return redirect()->route('riscos.show', ['id' => $monitoramento->riscoFK])
                ->with('success', 'Controle Sugerido atualizado com sucesso!');
        } catch (\Illuminate\Validation\ValidationException $e) {
            Log::error('Erro de validação ao atualizar controle sugerido:', [
                'errors' => $e->errors(),
                'request' => $request->all()
            ]);
            return back()->withErrors($e->errors())->withInput();
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            Log::error('Controle Sugerido não encontrado:', ['id' => $id]);
            return redirect()->route('riscos.index')->with('error', 'Controle Sugerido não encontrado.');
        } catch (\Illuminate\Contracts\Filesystem\FileNotFoundException $e) {
            Log::error('Erro ao tentar excluir o anexo antigo:', ['path' => $monitoramento->anexoMonitoramento]);
            return back()->with('error', 'Erro ao tentar excluir o anexo antigo. Por favor, tente novamente.');
        } catch (Exception $e) {
            Log::error('Erro inesperado ao atualizar controle sugerido:', [
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            return back()->with('error', 'Ocorreu um erro inesperado. Por favor, tente novamente.')->withInput();
        }
    }

    public function delete($id)
    {
        $this->riscoService->deleteRisco($id);
        return redirect()->back()->with(['success' => 'Risco Deletado com sucesso']);
    }

    public function deleteMonitoramento($id)
    {
        try {
            $this->monitoramentoService->deleteMonitoramento($id);
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

    public function storeResposta(StoreRespostaRequest $request, $id)
    {
        try {
            Log::info('Storing resposta for monitoramento', ['monitoramento_id' => $id]);
            $validatedData = $request->validated();
            $resposta = $this->respostaService->storeResposta($id, $validatedData);
            $monitoramento = $resposta->monitoramento;
            Log::info('Resposta armazenada com sucesso', [
                'resposta_id' => $resposta->id,
                'monitoramento_id' => $monitoramento->id
            ]);

            return redirect()->route('riscos.respostas', $id)->with('success', 'Respostas adicionadas com sucesso');
        } catch (Exception $e) {
            Log::error('Error storing resposta', [
                'error' => $e->getMessage(),
                'monitoramento_id' => $id
            ]);

            return redirect()->back()->withErrors(['errors' => $e->getMessage()])->withInput();
        }
    }

    public function updateResposta(UpdateRespostaRequest $request, $id)
    {

        try {
            $validatedData = $request->validated();
            $resposta = $this->respostaService->updateResposta($id, $validatedData);
            return redirect()->route('riscos.respostas', ['id' => $resposta->respostaMonitoramentoFK])
                ->with('success', 'Resposta atualizada com sucesso!');
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return redirect()->back()->withErrors(['error' => 'Resposta não encontrada.']);
        } catch (Exception $e) {
            Log::error('Erro ao atualizar a resposta: ' . $e->getMessage());
            return redirect()->back()->withErrors(['error' => 'Ocorreu um erro ao atualizar a resposta. Por favor, tente novamente.'])->withInput();
        }
    }

    public function deleteAnexo(Request $request, $id)
    {
        try {
            Log::info('Attempting to delete anexo for Resposta with ID: ' . $id);
            $this->respostaService->deleteAnexo($id);
            return redirect()->back()->with('success', 'Anexo deletado com sucesso');
        } catch (Exception $e) {

            Log::error('Error deleting anexo for Resposta ID: ' . $id . '. Error: ' . $e->getMessage());

            return redirect()->back()->with('errors', 'Houve um erro ao deletar o anexo selecionado');
        }
    }

    public function respostas($id)
    {
        $dados = $this->respostaService->show($id);
        return view('riscos.respostas', $dados);
    }

    public function homologar($id)
    {
        try {
            $dataConcat = $this->respostaService->homologarResposta($id);
            return redirect()->back()->with('success', 'Resposta homologada com sucesso! ' . $dataConcat);
        } catch (Exception $e) {
            Log::error('Erro ao homologar resposta: ' . $e->getMessage(), [
                'id' => $id,
                'stack' => $e->getTraceAsString()
            ]);
            return redirect()->back()->with('error', 'Ocorreu um erro ao tentar homologar a resposta. Tente novamente.');
        }
    }


    public function insertPrazo(insertPrazoRequest $request)
    {
        try {
            $validatedData = $request->validated();
            $this->prazoService->insertPrazo($validatedData);
            return redirect()->back()->with('success', 'Prazo Inserido com sucesso');
        } catch (Exception $e) {
            return redirect()->back()->with('error', 'Um erro ocorreu: ' . $e->getMessage())->withInput();
        }
    }

    public function __construct(RiscoService $riscoService, MonitoramentoService $monitoramentoService, RespostaService $respostaService, PrazoService $prazoService)
    {
        $this->middleware('auth');
        $this->riscoService = $riscoService;
        $this->monitoramentoService = $monitoramentoService;
        $this->respostaService = $respostaService;
        $this->prazoService = $prazoService;
        // $this->middleware('checkAccess');
    }
}
