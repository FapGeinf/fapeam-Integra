<?php

namespace App\Http\Controllers;

use App\Models\Atividade;
use Illuminate\Http\Request;
use App\Models\Eixo;

class AtividadeController extends Controller
{
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
            'data_realizada' => 'nullable|date|after_or_equal:data_prevista',
            'meta' => 'required|integer|min:0',
            'realizado' => 'required|integer|min:0',
        ]);
    }

    public function index()
    {
       
        $atividades = Atividade::with('eixo')->paginate(10);
    
        return view('atividades.index', ['atividades' => $atividades]);
    }
    

    public function showAtividade($id)
    {
        $atividade = Atividade::findOrFail($id);
        return view('atividades.showAtividade', ['atividade' => $atividade]);
    }

    public function createAtividade()
    {
        $eixos = Eixo::all();
        return view('atividades.createAtividade', ['eixos' => $eixos]);
    }

    public function storeAtividade(Request $request)
    {
        $validatedData = $this->validateRules($request);

        try {
            $atividade = Atividade::create($validatedData);

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
        $eixos = Eixo::all();
        $atividade = Atividade::findorFail($id);

        if (!$atividade) {
            return redirect()->back()->with('errors', 'Não foi encontrada a atividade selecionada no sistema...');
        }

        return view('atividades.editAtividade', ['eixos' => $eixos, 'atividade' => $atividade]);
    }

    public function updateAtividade(Request $request, $id)
    {
        $validatedData = $this->validateRules($request);

        try {
            $atividade = Atividade::findOrFail($id);

            $atividade->update($validatedData);
            return redirect()->route('atividades.index')->with('success', 'Atividade atualizada com sucesso!');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Ocorreu um erro ao atualizar a atividade. Por favor, tente novamente mais tarde.');
        }
    }

    public function deleteAtividade($id)
    {
        try {
            $atividade = Atividade::findOrFail($id);
            $atividade->delete();
            return redirect()->route('atividades.index')->with('success', 'Atividade deletada com sucesso!');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Ocorreu um erro ao excluir a atividade. Por favor, tente novamente mais tarde.');
        }
    }
}
