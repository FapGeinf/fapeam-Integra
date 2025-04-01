<?php

namespace App\Http\Controllers;

use App\Http\Requests\InsertCanalRequest;
use App\Services\AtividadeService;
use App\Services\CanalService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Http\Requests\AtividadeRequest;

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
        $eixo_id = $request->get('eixo_id');
        $dados = $this->atividade->indexAtividades($eixo_id);
        return view('atividades.index', $dados);
    }

    public function createCanal(InsertCanalRequest $request)
    {
        $validatedData = $request->validated();
        $canal = $this->canal->insertCanal($validatedData);

        return response()->json([
            'success' => true,
            'canal' => $canal
        ], 201);
    }


    public function showAtividade($id)
    {
        $atividade = $this->atividade->show($id);
        return view('atividades.showAtividade', ['atividade' => $atividade]);
    }

    public function createAtividade()
    {
        $dados = $this->atividade->createFormAtividade();
        return view('atividades.createAtividade', $dados);
    }

    public function storeAtividade(AtividadeRequest $request)
    {
        Log::info('Dados recebidos para criação da atividade:', $request->all());
        try {
            $validatedData = $request->validated();
            $atividade = $this->atividade->store($validatedData);
            return redirect()->route('atividades.index', ['eixo_id' => $atividade['eixo_id']])->with('success', 'Atividade criada com sucesso!');
        } catch (\Exception $e) {
            dd($e);
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
        return view('atividades.editAtividade', $dados);
    }

    public function updateAtividade(AtividadeRequest $request, $id)
    {
        Log::info('Dados recebidos para atualização da atividade:', $request->all());

        try {
            $validatedData = $request->validated();

            $atividade = $this->atividade->updateAtividade($id, $validatedData);

            return redirect()->route('atividades.index', ['eixo_id' => $atividade['eixo_id']])->with('success', 'Atividade atualizada com sucesso!');
        } catch (\Exception $e) {
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
            return redirect()->route('atividades.index')->with('success', 'Atividade deletada com sucesso!');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Ocorreu um erro ao excluir a atividade. Por favor, tente novamente mais tarde.');
        }
    }
}