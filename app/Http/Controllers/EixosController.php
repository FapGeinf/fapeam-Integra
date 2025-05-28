<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Log;
use Exception;

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


}
