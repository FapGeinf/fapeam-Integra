<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Riscos;
use App\Models\Monitoramento;
class MonitoramentoController extends Controller
{
      public function createMonitoramento($id)
      {
             $risco = Riscos::findorFail($id);
             return view('riscos.monitoramento'.['risco' => $risco]);
      }

      public function store(Request $request, $id)
      {
             $risco_id = Riscos::findorFail($id);
             try{
                $request->validate([
                    'monitoramentoControleSugerido' => 'required',
                    'statusMonitoramento' => 'required',
                    'execucaoMonitoramento' => 'required'
                ]);
             }catch(\Exception $e){
                 return redirect()->back()->with('errors','Por favor preencha os campos corretamente: '.$e->getMessage());
             }

             if(is_array($request->monitoramentos)){
                foreach($request->monitoramentos as $monitoramentoData){
                        $monitoramento = Monitoramento::create([
                            'monitoramentoControleSugerido' => $monitoramentoData['monitoramentoControleSugerido'],
                            'statusMonitoramento' => $monitoramentoData['statusMonitoramento'],
                            'execucaoMonitoramento' => $monitoramentoData['execucaoMonitoramento'],
                            'riscoFK' => $risco_id
                        ]);

                        if(!$monitoramento){
                            return redirect()->back()->with('errors','Houve um erro ao processar a criação de um monitoramento');
                        }else{
                            return redirect()->route('riscos.home')->with('success','Monitoramento inserido com sucesso');
                        }
                }
             }
      }

      public function editMonitoramento($id_monitoramento)
      {
             $monitoramento = Monitoramento::findorFail($id_monitoramento);
             return view('riscos.editMonitoramento',['monitoramento' => $monitoramento]);
      }

      public function updateMonitoramento(Request $request, $id_monitoramento)
      {
             $monitoramento = Monitoramento::findOrFail($id_monitoramento);
             try{

                $request->validate([
                    'monitoramentoControleSugerido' => 'required',
                    'statusMonitoramento' => 'required',
                    'execucaoMonitoramento' => 'required'
                ]);

                $monitoramento->update([
                    'monitoramentoControleSugerido' => $request->monitoramentoControleSugerido,
                    'statusMonitoramento' => $request->statusMonitoramento,
                    'execucaoMonitoramento' => $request->execucaoMonitoramento
                ]);

             }catch(\Exception $e){

             }
      }
}
