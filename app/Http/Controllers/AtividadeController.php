<?php

namespace App\Http\Controllers;

use App\Http\Requests\InsertCanalRequest;
use App\Services\AtividadeService;
use App\Services\CanalService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use App\Http\Requests\AtividadeRequest;
use Exception;

class AtividadeController extends Controller
{
    protected $atividade, $canal;

    public function __construct(AtividadeService $atividade, CanalService $canal)
    {
        $this->atividade = $atividade;
        $this->canal = $canal;
    }

   
    public function index(Request $request)
    {
        try {
            $eixo_id = $request->get('eixo_id');
            $dados = $this->atividade->indexAtividadesConcluidas($eixo_id); 
            return view('atividades.index', $dados);
        } catch (Exception $e) {
            Log::error('Erro ao listar atividades concluídas: ' . $e->getMessage(), [
                'user_id' => Auth::id(),
                'eixo_id' => $request->get('eixo_id'),
            ]);
            return redirect()->back()->with('error', 'Erro ao carregar a lista de atividades.');
        }
    }

    public function planoAcao(Request $request)
    {
        try {
            $eixo_id = $request->get('eixo_id');
            // Crie este método no seu AtividadeService para retornar os itens pendentes/não ocorridos
            $dados = $this->atividade->indexPlanoAcao($eixo_id); 
            return view('atividades.plano_acao', $dados);
        } catch (Exception $e) {
            Log::error('Erro ao listar plano de ação: ' . $e->getMessage(), [
                'user_id' => Auth::id(),
                'eixo_id' => $request->get('eixo_id'),
            ]);
            return redirect()->back()->with('error', 'Erro ao carregar o plano de ação.');
        }
    }

    public function painelAtividadesExecutadas(Request $request)
    {
        try {
            $eixo_id = $request->get('eixo_id');
            $dados = $this->atividade->indexAtividadesExecutadasByEixo($eixo_id);
            return view('atividades.executadas', $dados);
        } catch (Exception $e) {
            Log::error('Erro ao listar atividades executadas: ' . $e->getMessage(), [
                'user_id' => Auth::id(),
                'eixo_id' => $request->get('eixo_id'),
            ]);
            return redirect()->back()->with('error', 'Erro ao carregar a lista de atividades.');
        }
    }

    public function painelAtividadesAcompanhamento(Request $request)
    {
        try {
            $eixo_id = $request->get('eixo_id');
            $dados = $this->atividade->indexAtividadesAcompanhamentoByEixo($eixo_id);
            return view('atividades.acompanhamento', $dados);
        } catch (Exception $e) {
            Log::error('Erro ao listar atividades em acompanhamento: ' . $e->getMessage(), [
                'user_id' => Auth::id(),
                'eixo_id' => $request->get('eixo_id'),
            ]);
            return redirect()->back()->with('error', 'Erro ao carregar a lista de atividades.');
        }
    }

    public function painelAtividadesNaoExecutadas(Request $request)
    {
        try {
            $eixo_id = $request->get('eixo_id');
            $dados = $this->atividade->indexAtividadesNaoExecutadasByEixo($eixo_id);
            return view('atividades.nao_executadas', $dados);
        } catch (Exception $e) {
            Log::error('Erro ao listar atividades não executadas: ' . $e->getMessage(), [
                'user_id' => Auth::id(),
                'eixo_id' => $request->get('eixo_id'),
            ]);
            return redirect()->back()->with('error', 'Erro ao carregar a lista de atividades.');
        }
    }

    public function createCanal(InsertCanalRequest $request)
    {
        try {
            $validatedData = $request->validated();
            $canal = $this->canal->insertCanal($validatedData);

            Log::info("Inserção de Canal realizada", [
                'user_id' => Auth::id(),
                'user_name' => Auth::user()->name ?? 'Visitante',
                'canal_id' => $canal->id ?? null
            ]);

            return response()->json([
                'success' => true,
                'canal' => $canal
            ], 201);

        } catch (Exception $e) {
            Log::error('Erro ao criar canal: ' . $e->getMessage(), [
                'user_id' => Auth::id(),
                'request' => $request->all()
            ]);
            return response()->json([
                'success' => false,
                'message' => 'Erro ao criar canal.'
            ], 500);
        }
    }

    public function showAtividade($id)
    {
        try {
            $atividade = $this->atividade->show($id);
            return view('atividades.showAtividade', ['atividade' => $atividade]);
        } catch (Exception $e) {
            Log::error("Erro ao mostrar atividade $id: " . $e->getMessage(), [
                'user_id' => Auth::id(),
                'atividade_id' => $id
            ]);
            return redirect()->back()->with('error', 'Erro ao carregar a atividade.');
        }
    }

    public function createAtividade()
    {
        try {
            $dados = $this->atividade->createFormAtividade();
            return view('atividades.createAtividade', $dados);
        } catch (Exception $e) {
            Log::error('Erro ao carregar formulário de criação de atividade: ' . $e->getMessage(), [
                'user_id' => Auth::id(),
            ]);
            return redirect()->back()->with('error', 'Erro ao carregar a página de criação de atividade.');
        }
    }

    public function storeAtividade(AtividadeRequest $request)
    {
        Log::channel('action')->info('Dados do formulário', ['dados' => $request->all()]);
        
        try {
            $validatedData = $request->validated();
            $atividade = $this->atividade->store($validatedData);

            Log::info("Criação de Atividade realizada", [
                'user_id' => Auth::id(),
                'user_name' => Auth::user()->name ?? 'Visitante',
                'atividade_id' => $atividade['id'] ?? null
            ]);

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
        try {
            $dados = $this->atividade->editFormAtividade($id);
            return view('atividades.editAtividade', $dados);
        } catch (Exception $e) {
            Log::error('Erro ao acessar página de edição de atividade', [
                'error' => $e->getMessage(),
                'atividade_id' => $id
            ]);
            return redirect()->back()->with('error', 'Erro ao carregar dados da atividade.');
        }
    }

    public function updateAtividade(AtividadeRequest $request, $id)
    {
        Log::info('Dados recebidos para atualização da atividade:', $request->all());

        try {
            $validatedData = $request->validated();
            $atividade = $this->atividade->updateAtividade($id, $validatedData);

            Log::info("Atualização de Atividade realizada", [
                'user_id' => Auth::id(),
                'user_name' => Auth::user()->name ?? 'Visitante',
                'atividade_id' => $id
            ]);

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

            Log::info("Exclusão de Atividade realizada", [
                'user_id' => Auth::id(),
                'user_name' => Auth::user()->name ?? 'Visitante',
                'atividade_id' => $id
            ]);

            return redirect()->back()->with('success', 'Atividade deletada com sucesso!');
        } catch (Exception $e) {
            Log::error('Houve um erro inesperado ao deletar a atividade selecionada', [
                'error' => $e->getMessage(), 
                'atividade_id' => $id
            ]);
            return redirect()->back()->with('error', 'Ocorreu um erro ao excluir a atividade. Por favor, tente novamente mais tarde.');
        }
    }
}