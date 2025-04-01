<?php

namespace App\Http\Controllers;

use App\Http\Requests\InsertIndicadorRequest;
use App\Services\IndicadorService;
use Illuminate\Http\Request;
use Log;
class IndicadorController extends Controller
{
	protected $indicadorService;

	public function __construct(IndicadorService $indicadorService)
	{
		$this->indicadorService = $indicadorService;
	}

	public function index(Request $request)
	{
		$indicadores = $this->indicadorService->indexIndicadores($request->eixo_id);
		return view('indicadores.index', compact('indicadores'));
	}

	public function create()
	{
		$eixos = $this->indicadorService->formCreateIndicador();
		return view('indicadores.create', compact('eixos'));
	}

	public function store(InsertIndicadorRequest $request)
	{
		try {
			$validatedData = $request->validated();
			$this->indicadorService->insertIndicador($validatedData);
			return redirect()->route('indicadores.index')->with('success', 'Indicador criado com sucesso!');
		} catch (\Throwable $th) {
			Log::error('Erro ao criar indicador: '.$th->getMessage());
			return redirect()->back()->withErrors(['error' => 'Houve um erro inesperado ao inserir um novo indicador, tente novamente']);
		}
	}

	public function edit($id)
	{
		$dados = $this->indicadorService->editFormIndicador($id);
		return view('indicadores.edit', $dados);
	}

	public function update(InsertIndicadorRequest $request, $id)
	{
		try {
			$validatedData = $request->validated();
			$this->indicadorService->updateIndicador($id, $validatedData);
			return redirect()->route('indicadores.index')->with('success', 'Indicador atualizado com sucesso!');
		} catch (\Throwable $th) {
            Log::error('Erro ao atualizar indicador: '. $th->getMessage());
			return redirect()->back()->withErrors(['error' => 'Houve um erro inesperado ao atualizar o indicador, tente novamente.']);
		}
	}

}
