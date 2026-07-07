<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\UnidadeService;
use App\Services\UnidadeTipoService;
use App\Http\Requests\UnidadeRequest;
use App\Http\Requests\UpdateUnidadeRequest;

class UnidadeController extends Controller
{
      protected $unidadeService, $unidadeTipoService;

      public function __construct(UnidadeService $unidadeService, UnidadeTipoService $unidadeTipoService)
      {
             $this->unidadeService = $unidadeService;
             $this->unidadeTipoService = $unidadeTipoService;
      }

      public function index()
      {
             $unidades = $this->unidadeService->getAllUnidades();
             $unidadesTipos = $this->unidadeTipoService->getAllUnidadeTipos();
             return view('unidades.index', compact('unidades','unidadesTipos'));
      }

      public function show($id)
      {
             $unidade = $this->unidadeService->findUnidadeById($id);
             return view('unidades.show', compact('unidade'));
      }

      public function create()
      {
             $unidadeTipos = $this->unidadeTipoService->getAllUnidadeTipos();
             return view('unidades.create',compact('unidadeTipos'));
      }

      public function store(UnidadeRequest $request)
      {
             $this->unidadeService->createUnidade($request->validated());
             return redirect()->route('unidades.index')->with('success', 'Unidade criada com sucesso!');
      }

      public function edit($id)
      {
             $unidade = $this->unidadeService->findUnidadeById($id);
             $unidadeTipos = $this->unidadeTipoService->getAllUnidadeTipos();
             return view('unidades.edit', compact('unidade', 'unidadeTipos'));
      }

      public function update(UpdateUnidadeRequest $request, $id)
      {
             $this->unidadeService->updateUnidade($id, $request->validated());
             return redirect()->route('unidades.index')->with('success', 'Unidade atualizada com sucesso!');
      }

      public function destroy($id)
      {
             $this->unidadeService->deleteUnidade($id);
             return redirect()->route('unidades.index')->with('success', 'Unidade deletada com sucesso!');
      }
}
