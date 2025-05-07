<?php

namespace App\Http\Controllers;

use App\Http\Requests\InsertCanalRequest;
use App\Services\AtividadeService;
use App\Services\CanalService;
use App\Services\LogService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use App\Http\Requests\AtividadeRequest;
use Exception;

class AtividadeController extends Controller
{
    protected $atividade, $canal, $log;

    public function __construct(AtividadeService $atividade, CanalService $canal, LogService $log)
    {
        $this->atividade = $atividade;
        $this->canal = $canal;
        $this->log = $log;
    }

    public function index(Request $request)
    {
        $eixo_id = $request->get('eixo_id');
        $dados = $this->atividade->indexAtividades($eixo_id);

        if (Auth::check()) {
            $username = Auth::user()->name;
            $this->log->insertLog([
                'acao' => 'Acesso',
                'descricao' => "O usuário de nome $username está acessando a lista de atividades",
                'user_id' => Auth::user()->id
            ]);
        }

        return view('atividades.index', $dados);
    }

    public function createCanal(InsertCanalRequest $request)
    {
        $validatedData = $request->validated();
        $canal = $this->canal->insertCanal($validatedData);

        if (Auth::check()) {
            $username = Auth::user()->name;
            $this->log->insertLog([
                'acao' => 'Inserção',
                'descricao' => "O usuário de nome $username está inserindo um novo canal",
                'user_id' => Auth::user()->id
            ]);
        }

        return response()->json([
            'success' => true,
            'canal' => $canal
        ], 201);
    }

    public function showAtividade($id)
    {
        $atividade = $this->atividade->show($id);

        if (Auth::check()) {
            $username = Auth::user()->name;
            $this->log->insertLog([
                'acao' => 'Acesso',
                'descricao' => "O usuário de nome $username está visualizando a atividade de ID $id",
                'user_id' => Auth::user()->id
            ]);
        }

        return view('atividades.showAtividade', ['atividade' => $atividade]);
    }

    public function createAtividade()
    {
        $dados = $this->atividade->createFormAtividade();

        if (Auth::check()) {
            $username = Auth::user()->name;
            $this->log->insertLog([
                'acao' => 'Acesso',
                'descricao' => "O usuário de nome $username está acessando a página de criação de atividade",
                'user_id' => Auth::user()->id
            ]);
        }

        return view('atividades.createAtividade', $dados);
    }

    public function storeAtividade(AtividadeRequest $request)
    {
        Log::info('Dados recebidos para criação da atividade:', $request->all());
        try {
            $validatedData = $request->validated();
            $atividade = $this->atividade->store($validatedData);

            if (Auth::check()) {
                $username = Auth::user()->name;
                $this->log->insertLog([
                    'acao' => 'Inserção',
                    'descricao' => "O usuário de nome $username está criando uma nova atividade",
                    'user_id' => Auth::user()->id
                ]);
            }

            return redirect()->route('atividades.index', ['eixo_id' => $atividade['eixo_id']])->with('success', 'Atividade criada com sucesso!');
        } catch (Exception $e) {
            Log::error('Erro ao salvar a atividade', [
                'error_message' => $e->getMessage(),
                'stack_trace' => $e->getTraceAsString(),
                'request_data' => $request->all(),
            ]);

            return redirect()->back()->with('error', 'Ocorreu um erro ao salvar a atividade. Por favor, tente novamente mais tarde.')->withInput();
        }
    }

    public function editAtividade($id)
    {
        $dados = $this->atividade->editFormAtividade($id);

        if (Auth::check()) {
            $username = Auth::user()->name;
            $this->log->insertLog([
                'acao' => 'Acesso',
                'descricao' => "O usuário de nome $username está acessando a página de edição da atividade de ID $id",
                'user_id' => Auth::user()->id
            ]);
        }

        return view('atividades.editAtividade', $dados);
    }

    public function updateAtividade(AtividadeRequest $request, $id)
    {
        Log::info('Dados recebidos para atualização da atividade:', $request->all());

        try {
            $validatedData = $request->validated();
            $atividade = $this->atividade->updateAtividade($id, $validatedData);

            if (Auth::check()) {
                $username = Auth::user()->name;
                $this->log->insertLog([
                    'acao' => 'Atualização',
                    'descricao' => "O usuário de nome $username está atualizando a atividade de ID $id",
                    'user_id' => Auth::user()->id
                ]);
            }

            return redirect()->route('atividades.index', ['eixo_id' => $atividade['eixo_id']])->with('success', 'Atividade atualizada com sucesso!');
        } catch (Exception $e) {
            Log::error('Erro ao atualizar a atividade', [
                'error_message' => $e->getMessage(),
                'stack_trace' => $e->getTraceAsString(),
                'request_data' => $request->all(),
            ]);

            return redirect()->back()->with('error', 'Ocorreu um erro ao atualizar a atividade. Por favor, tente novamente mais tarde.')->withInput();
        }
    }

    public function deleteAtividade($id)
    {
        try {
            $this->atividade->delete($id);

            if (Auth::check()) {
                $username = Auth::user()->name;
                $this->log->insertLog([
                    'acao' => 'Exclusão',
                    'descricao' => "O usuário de nome $username está excluindo a atividade de ID $id",
                    'user_id' => Auth::user()->id
                ]);
            }

            return redirect()->route('atividades.index')->with('success', 'Atividade deletada com sucesso!');
        } catch (Exception $e) {
            return redirect()->back()->with('error', 'Ocorreu um erro ao excluir a atividade. Por favor, tente novamente mais tarde.');
        }
    }
}
