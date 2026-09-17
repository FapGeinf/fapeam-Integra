<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Log;
use Exception;
use App\Http\Requests\EixoAnexoRequest;
use App\Models\Eixo;
use Illuminate\Support\Facades\Storage;

class EixosController extends Controller
{
       public function Eixo1()
       {
              return view('apresentacoes.eixo1');
       }

       public function Eixo2()
       {
              return view('apresentacoes.eixo2');
       }

       public function Eixo3()
       {
              return view('apresentacoes.eixo3');
       }

       public function Eixo4()
       {
              return view('apresentacoes.eixo4');
       }

       public function Eixo5()
       {
              return view('apresentacoes.eixo5');
       }

       public function Eixo6()
       {
              return view('apresentacoes.eixo6');
       }

       public function Eixo7()
       {
              return view('apresentacoes.eixo7');
       }

       public function Eixo8()
       {
              return view('apresentacoes.eixo8');
       }

       public function mostrarEixo($eixo_id)
       {
              try {
                     $eixosValidos = [1, 2, 3, 4, 5, 6, 7, 8];

                     if (in_array($eixo_id, $eixosValidos)) {
                            return view("apresentacoes.eixo{$eixo_id}");
                     }

                     return redirect()->route('atividades.index')
                            ->with('error', 'Eixo não encontrado.');

              } catch (Exception $e) {
                     Log::error('Erro ao carregar o eixo: ' . $e->getMessage());

                     return redirect()->route('atividades.index')
                            ->with('error', 'Ocorreu um erro ao carregar o eixo.');
              }
       }

       public function uploadAnexo(EixoAnexoRequest $request, $eixo_id)
       {
              try {
                     $eixo = Eixo::findOrFail($eixo_id);

                     if (!$request->hasFile('anexo_path') || !$request->file('anexo_path')->isValid()) {
                            return redirect()->back()->with('error', 'Nenhum arquivo válido foi enviado.');
                     }

                     if ($eixo->anexo_path) {
                            Storage::delete($eixo->anexo_path);
                     }

                     $file = $request->file('anexo_path');

                     $nomeOriginal = $file->getClientOriginalName();

                     $path = $file->storeAs('public/anexos', $nomeOriginal);

                     $eixo->update([
                            'anexo_path' => $path
                     ]);

                     return redirect()->back()->with('success', 'Anexo atualizado com sucesso.');

              } catch (\Throwable $e) {
                     Log::error("Erro ao enviar anexo (Eixo ID: {$eixo_id}): " . $e->getMessage());

                     return redirect()->back()->with('error', 'Ocorreu um erro ao enviar o anexo.');
              }
       }
       public function downloadAnexo($eixo_id)
       {
              try {
                     $eixo = Eixo::findOrFail($eixo_id);

                     if (!$eixo->anexo_path || !Storage::exists($eixo->anexo_path)) {
                            return redirect()->back()->with('error', 'Anexo não encontrado.');
                     }

                     return Storage::download($eixo->anexo_path);

              } catch (\Throwable $e) {
                     Log::error("Erro ao baixar anexo (Eixo ID: {$eixo_id}): " . $e->getMessage());

                     return redirect()->back()->with('error', 'Ocorreu um erro ao baixar o anexo.');
              }
       }

}
