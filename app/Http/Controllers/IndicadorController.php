<?php

namespace App\Http\Controllers;

use App\Services\LogService;
use Auth;
use Illuminate\Http\Request;
use App\Models\Indicador;
use App\Models\Eixo;
class IndicadorController extends Controller
{

	protected $log;

	public function __construct(LogService $log)
	{
		$this->log = $log;
	}

	public function index(Request $request)
	{
		$eixo_id = $request->get('eixo_id');
		if ($eixo_id) {
			$indicadores = Indicador::where('eixo_fk', $eixo_id)->with('eixo')->get();
		} else {
			$indicadores = Indicador::with('eixo')->get();
		}
		if (Auth::check()) {
			$username = Auth::user()->name;
			$eixoNome = $indicadores->eixo->nome;

			$this->log->insertLog([
				'acao' => 'Acesso',
				'descricao' => "O usuário de nome $username estar acessando a index dos indicadores do eixo $eixoNome",
				'user_id' => Auth::user()->id
			]);
		}
		return view('indicadores.index', compact('indicadores'));
	}


	public function create()
	{
		$eixos = Eixo::all();
		if (Auth::check()) {
			$username = Auth::user()->name;

			$this->log->insertLog([
				'acao' => 'Acesso',
				'descricao' => "O usuário de nome $username estar acessando a página de inserção de indicadores",
				'user_id' => Auth::user()->id
			]);
		}
		return view('indicadores.create', compact('eixos'));
	}

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
			if (Auth::check()) {
				$username = Auth::user()->name;

				$this->log->insertLog([
					'acao' => 'Inserção',
					'descricao' => "O usuário de nome $username estar inserindo um novo indicador do eixo {$indicador->eixo->nome}",
					'user_id' => Auth::user()->id
				]);
			}
			return redirect()->route('indicadores.index')->with('success', 'Indicador criado com sucesso!');
		} catch (\Throwable $th) {
			dd($th);
			return redirect()->back()->withErrors(['error' => 'Erro ao criar indicador: ' . $th->getMessage()]);
		}
	}
	public function edit($id)
	{
		$indicador = Indicador::findOrFail($id);
		$eixos = Eixo::all();
		if(Auth::check()){
			$username = Auth::user()->name;

			$this->log->insertLog([
				'acao' => 'Acesso',
				'descricao' => "O usuário de nome $username estar acessando a página de edição do indicador de $id do eixo {$indicador->eixo->nome}",
				'user_id' => Auth::user()->id
			]);
		}
		return view('indicadores.edit', compact('indicador', 'eixos'));
	}
	public function update(Request $request, $id)
	{
		try {
			$request->validate([
				'nome' => 'nullable|string|max:255',
				'descricao' => 'nullable|string|max:255',
				'eixo' => 'nullable|exists:eixos,id',
			]);

			$indicador = Indicador::findOrFail($id);
			$indicador->nomeIndicador = $request->get('nome');
			$indicador->descricaoIndicador = $request->get('descricao');
			$indicador->eixo_fk = $request->get('eixo');
			$indicador->save();
			if(Auth::check()){
				$username = Auth::user()->name;
				$this->log->insertLog([
					'acao' => 'Atualização',
					'descricao' => "O usuário de nome $username estar atualizando o indicador de $id e eixo {$indicador->eixo->nome}",
					'user_id' => Auth::user()->id
				]);
			}
			return redirect()->route('indicadores.index')->with('success', 'Indicador atualizado com sucesso!');
		} catch (\Throwable $th) {
			dd($th);
			return redirect()->back()->withErrors(['error' => 'Erro ao atualizar indicador: ' . $th->getMessage()]);
		}
	}

}
