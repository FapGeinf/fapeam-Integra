<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Riscos;
use App\Models\Unidades;

class RiscoController extends Controller
{
    public function index()
    {
        $user_id = auth()->user();
        $riscos = Riscos::where('user_id', $user_id)->get();
        return view('riscos.index', ['riscos' => $riscos]);
    }

    public function create()
    {
        $unidades = Unidades::all();
        return view('riscos.create');
    }

    public function store(Request $request)
    {
        try {
            $request->validate([
                'riscoEvento' => 'required',
                'riscoCausa' => 'required',
                'riscoConsequencia' => 'required',
                'riscoAvaliacao' => 'required',
                'unidadeRiscoFK' => 'required'
            ]);


            $risco = Riscos::create([
                'riscoEvento' => $request->riscoEvento,
                'riscoCausa' => $request->riscoCausa,
                'riscoConsequencia' => $request->riscoConsequencia,
                'riscoAvaliacao' => $request->riscoAvaliacao,
                'unidadeRiscoFK' => $request->unidadeRiscoFK
            ]);

            if (!$risco) {
                return redirect()->back()->with('error', 'Houve um erro ao processar a criação de um risco');
            } else {
                return redirect()->route('riscos.index');
            }
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    public function edit()
    {
           $unidades = Unidades::all();
           return view('riscos.edit',['unidades'=>$unidades]);
    }
}
