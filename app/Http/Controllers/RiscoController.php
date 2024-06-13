<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use app\Http\Middleware\VerifyCsrfToken;
use App\Models\Risco;
use App\Models\Unidade;

class RiscoController extends Controller
{
    public function index()
    {
				$riscos = Risco::all();
				$unidades = Unidade::all();
        return view('riscos.index', ['riscos' => $riscos, 'unidades' => $unidades]);
    }

    public function create()
    {
        $unidades = Unidade::all();
        return view('riscos.store', ['unidades' => $unidades]);
    }

    public function store(Request $request)
    {			
					dd($request->all());
					$request->validate([
            'riscoEvento' => 'required',
            'riscoCausa' => 'required',
            'riscoConsequencia' => 'required',
            'riscoAvaliacao' => 'required',
            'unidadeRiscoFK' => 'required'
          ]);
					try {
						// dd($request->unidadeRiscoFk);
            $risco = Risco::create([
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
						dd($e);
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    public function edit()
    {
        $unidades = Unidade::all();
        return view('riscos.edit', ['unidades' => $unidades]);
    }

    public function update(Request $request, $id)
    {
        $risco = Risco::findorFail($id);

        try {
            $request->validate([
                'riscoEvento' => 'required',
                'riscoCausa' => 'required',
                'riscoConsequencia' => 'required',
                'riscoAvaliacao' => 'required',
                'unidadeRiscoFK' => 'required'
            ]);

            $atualizaRisco =  $risco->update([
                'riscoEvento' => $request->riscoEvento,
                'riscoCausa' => $request->riscoCausa,
                'riscoConsequencia' => $request->riscoConsequencia,
                'riscoAvaliacao' => $request->riscoAvaliacao,
            ]);

            if(!$atualizaRisco){
                return redirect()->back()->with('errors','Houve um erro no processo de edição:');
            }else{
                return redirect()->route('riscos.show')->with('success','Risco editado com sucesso');
            }

        } catch (\Exception $e) {
            return redirect()->back()->with('errors',$e->getMessage());
        }
    }

    public function delete($id)
    {
           $risco = Risco::findorFail($id);

           $deleteRisco = $risco->delete();

           if(!$deleteRisco){
              return redirect()->back()->with('errors','Erro ao deletar o risco');
           }

           return redirect()->back()->with('success','Risco Deletado com sucesso');
    }

		public function __construct(){
			$this->middleware('auth');
		}
}
