<?php

namespace App\Http\Controllers;

use App\Models\Atividade;
use Illuminate\Http\Request;
use App\Models\Eixo;

class AtividadeController extends Controller
{
    protected $atividade;
    protected $eixo;

    public function __construct(Atividade $atividade, Eixo $eixo)
    {
           $this->atividade = $atividade;
           $this->eixo = $eixo;
    }

    private function validateRules(Request $request)
    {
        return $request->validate([
            'eixo_id' => 'required|exists:eixos,id',
            'atividade_descricao' => 'required|string',
            'objetivo' => 'required|string',
            'publico_alvo' => 'required|string|max:255',
            'tipo_evento' => 'required|string|max:255',
            'canal_divulgacao' => 'required|string|max:255',
            'data_prevista' => 'required|date',
            'data_realizada' => 'required|date',
            'meta' => 'required|integer|min:0',
            'realizado' => 'required|integer|min:0',
        ]);
    }

    public function index(Request $request)
    {
        $eixo_id = $request->get('eixo_id');

        if ($eixo_id && in_array($eixo_id, [1, 2, 3, 4, 5, 6, 7, 8])) {
            $atividades = $this->atividade->where('eixo_id', $eixo_id)->get();
        } else {
            $atividades = $this->atividade->all();
        }

        return view('atividades.index', ['atividades' => $atividades]);
    }

    public function showAtividade($id)
    {
        $atividade = $this->atividade->findOrFail($id);
        return view('atividades.showAtividade', ['atividade' => $atividade]);
    }

    public function createAtividade()
    {
        $eixos = $this->eixo->all();
        return view('atividades.createAtividade', ['eixos' => $eixos]);
    }

    public function storeAtividade(Request $request)
    {
        $validatedData = $this->validateRules($request);

        try {
            $atividade = $this->atividade->create($validatedData);

            if ($atividade) {
                return redirect()->route('atividades.index')->with('success', 'Atividade criada com sucesso!');
            }
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Ocorreu um erro ao salvar a atividade. Por favor, tente novamente mais tarde.');
        }

        return redirect()->back()->with('error', 'Ocorreu um erro inesperado.');
    }

    public function editAtividade($id)
    {
        $eixos = $this->eixo->all();
        $atividade = $this->atividade->findOrFail($id);

        if (!$atividade) {
            return redirect()->back()->with('error', 'Não foi encontrada a atividade selecionada no sistema.');
        }

        return view('atividades.editAtividade', ['eixos' => $eixos, 'atividade' => $atividade]);
    }

    public function updateAtividade(Request $request, $id)
    {
        $validatedData = $this->validateRules($request);

        try {
            $atividade = $this->atividade->findOrFail($id);

            $atividade->update($validatedData);
            return redirect()->route('atividades.index')->with('success', 'Atividade atualizada com sucesso!');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Ocorreu um erro ao atualizar a atividade. Por favor, tente novamente mais tarde.');
        }
    }

    public function deleteAtividade($id)
    {
        try {
            $atividade = $this->atividade->findOrFail($id);
            $atividade->delete();
            return redirect()->route('atividades.index')->with('success', 'Atividade deletada com sucesso!');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Ocorreu um erro ao excluir a atividade. Por favor, tente novamente mais tarde.');
        }
    }
}
