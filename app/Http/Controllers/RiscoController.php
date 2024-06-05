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
             $riscos = Riscos::where('user_id',$user_id)->get();
             return view('riscos.index',['riscos' => $riscos]);
      }

      public function create()
      {
             $unidades = Unidades::all();       
             return view('riscos.create');
      }

      public function store(Request $request)
      {
             try{
                $request->validate([
                   'riscoEvento' => 'required',
                   'riscoCausa' => 'required',
                   'riscoConsequencia' => 'required',
                   'riscoAvaliacao' => 'required',
                   'unidadeRiscoFK' => 'required'
                ]);
             }catch(\Exception $e){

             }
      }
}
