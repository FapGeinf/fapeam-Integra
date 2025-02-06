<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Indicador;
use App\Models\Eixo;
class IndicadorController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
			$eixo_id = $request->get('eixo_id');
			if ($eixo_id) {
				$indicadores = Indicador::where('eixo_fk', $eixo_id)->with('eixo')->get();
			} else {
				$indicadores = Indicador::with('eixo')->get();
			}
			return view('indicadores.index', compact('indicadores'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
			$eixos = Eixo::all();
			return view('indicadores.create', compact('eixos'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
public function store(Request $request)
{
    try {
        $request->validate([
            'nome' => 'nullable|string|max:255',
            'descricao' => 'nullable|string',
            'eixo' => 'nullable|exists:eixos,id',
        ]);

        $indicador = new Indicador([
            'nomeIndicador' => $request->get('nome'),
            'descricaoIndicador' => $request->get('descricao'),
            'eixo_fk' => $request->get('eixo'),
        ]);

        $indicador->save();
        return redirect()->route('indicadores.index')->with('success', 'Indicador criado com sucesso!');
    } catch (\Throwable $th) {
			dd($th);
        return redirect()->back()->withErrors(['error' => 'Erro ao criar indicador: ' . $th->getMessage()]);
    }
}

    public function edit($id)
    {
        //
    }

 
    public function update(Request $request, $id)
    {
        //
    }

}
