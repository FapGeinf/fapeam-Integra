<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\DiretoriaService;
use App\Http\Requests\DiretoriaRequest;

class DiretoriaController extends Controller
{
      protected $diretoriaService;

      public function __construct(DiretoriaService $diretoriaService)
      {
            $this->diretoriaService = $diretoriaService;
      }

      public function index()
      {
            $diretorias = $this->diretoriaService->returnDiretoriaOrderedByName();
            return view('diretorias.index', compact('diretorias'));
      }

      public function show($id)
      {
            $diretoria = $this->diretoriaService->findDiretoriaById($id);
            if (!$diretoria) {
                  return redirect()->route('diretorias.index')->with('error', 'Diretoria não encontrada.');
            }
            return view('diretorias.show', compact('diretoria'));
      }

      public function create()
      {
            return view('diretorias.create');
      }

      public function store(DiretoriaRequest $request)
      {
            $this->diretoriaService->createDiretoria($request->validated());
            return redirect()->route('diretorias.index')->with('success', 'Diretoria criada com sucesso!');
      }

      public function edit($id)
      {
            $diretoria = $this->diretoriaService->findDiretoriaById($id);
            if (!$diretoria) {
                  return redirect()->route('diretorias.index')->with('error', 'Diretoria não encontrada.');
            }
            return view('diretorias.edit', compact('diretoria'));
      }

      public function update(DiretoriaRequest $request, $id)
      {
            $updatedDiretoria = $this->diretoriaService->updateDiretoria($id, $request->validated());
            if (!$updatedDiretoria) {
                  return redirect()->route('diretorias.index')->with('error', 'Diretoria não encontrada.');
            }
            return redirect()->route('diretorias.index')->with('success', 'Diretoria atualizada com sucesso!');
      }

      public function destroy($id)
      {
            $deleted = $this->diretoriaService->deleteDiretoria($id);
            if (!$deleted) {
                  return redirect()->route('diretorias.index')->with('error', 'Diretoria não encontrada.');
            }
            return redirect()->route('diretorias.index')->with('success', 'Diretoria deletada com sucesso!');
      }
}
