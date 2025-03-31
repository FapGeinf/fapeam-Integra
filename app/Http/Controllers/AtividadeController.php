<?php

namespace App\Http\Controllers;

use App\Models\Atividade;
use App\Services\AtividadeService;
use Illuminate\Http\Request;
use App\Models\Eixo;
use App\Models\Publico;
use App\Models\Canal;
use App\Models\MedidaTipo;
use App\Models\Indicador;
use Illuminate\Support\Facades\Log;
use App\Http\Requests\AtividadeRequest;

class AtividadeController extends Controller
{
    protected $atividade;

    public function __construct(AtividadeService $atividade)
    {
        $this->atividade = $atividade;
    }

    public function index(Request $request)
    {
        $eixo_id = $request->get('eixo_id');
        $dados = $this->atividade->indexAtividades($eixo_id);
        return view('atividades.index', $dados);
    }


    public function createCanal(Request $request)
    {
        try {
            $request->validate([
                'nome' => 'max:255'
            ]);

            if (Canal::where('nome', $request->input('nome'))->exists()) {
                return response()->json([
                    'success' => false,
                    'message' => 'O canal já existe.'
                ], 400);
            }

            $canal = Canal::create([
                'nome' => $request->input('nome')
            ]);

            return response()->json([
                'success' => true,
                'canal' => $canal
            ], 201);

        } catch (\Exception $e) {
            Log::error('Erro ao criar canal: ' . $e->getMessage());

            return response()->json([
                'success' => false,
                'message' => 'Ocorreu um erro ao tentar criar o canal. Tente novamente mais tarde.'
            ], 500);
        }
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