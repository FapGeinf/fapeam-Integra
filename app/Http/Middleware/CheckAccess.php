<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class CheckAccess
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        $user = auth()->user();
        // dd($user);
        $access = $user->unidade->unidadeTipoFK;
        $routeName = explode('.',$request->route()->getName())[1];


        $permissions = [
            '1' => ['index','show','create','store','edit','update','delete','deleteMonitoramento','storeResposta','respostas','edit-monitoramentos','insert-monitoramentos','prazo','monitoramento','editMonitoramento','updateResposta','markAsRead','deleteAnexo'],
            '2' => ['index','show','storeResposta','respostas','markAsRead'],
            '3' => ['index','show','create','store','edit','update','delete','deleteMonitoramento','storeResposta','respostas','edit-monitoramentos','insert-monitoramentos','prazo','monitoramento','editMonitoramento','updateResposta','markAsRead','deleteAnexo'],
            '4' => ['index','show','create','store','edit','update','delete','deleteMonitoramento','storeResposta','respostas','edit-monitoramentos','insert-monitoramentos','prazo','monitoramento','editMonitoramento','updateResposta','markAsRead','deleteAnexo'],
            '5' => ['index','show','create','store','edit','update','delete','deleteMonitoramento','storeResposta','respostas','edit-monitoramentos','insert-monitoramentos','prazo','monitoramento','editMonitoramento','updateResposta','markAsRead','deleteAnexo'],
        ];
        // dd(in_array($routeName, $permissions[$access]));
        if (!in_array($routeName, $permissions[$access])) {
            Log::info('Access level: ' . $access);
            Log::info('Route Name: ' . $routeName);

            if (!$request->headers->has('referer') || !$request->isMethod('get')) {
                session()->flash('error', 'Você não tem acesso a esta funcionalidade.');
            }
            // return back()->with('error', 'Você não tem acesso a realizar essa funcionalidade');
            // return redirect('index');
            //Ainda quero refinar essa mensagem de erro
            return redirect()->back();
        }
        return $next($request);
    }
}
