<?php

use App\Events\PrazoProximo;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RiscoController;
use App\Models\Prazo;



/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/welcome', function () {
    return view('welcome');
});
Route::get('/', function (){
	return redirect()->route('riscos.index');
});

Route::get('/index', [RiscoController::class, 'index'])->name('riscos.index');
Route::get('/risco/novo', [RiscoController::class,'create'])->name('riscos.create');
Route::post('/risco/criar', [RiscoController::class, 'store'])->name('riscos.store');
Route::get('/riscos/show/{id}', [RiscoController::class, 'show'])->name('riscos.show');
Route::get('/riscos/{id}/edit', [RiscoController::class, 'edit'])->name('riscos.edit');
Route::put('/riscos/{id}', [RiscoController::class, 'update'])->name('riscos.update');
Route::post('/riscos/{id}/respostas', [RiscoController::class, 'storeResposta'])->name('riscos.storeResposta');
Route::delete('/riscos/monitoramentos/{id}',[RiscoController::class,'deleteMonitoramento'])->name('riscos.deleteMonitoramento');
Route::get('/riscos/respostas/{id}', [RiscoController::class, 'respostas'])->name('riscos.respostas');
Route::get('/riscos/{id}/edit-monitoramentos', [RiscoController::class, 'editMonitoramentos'])->name('riscos.edit-monitoramentos');
Route::put('/riscos/{id}/update-monitoramentos', [RiscoController::class, 'updateMonitoramentos'])->name('riscos.update-monitoramentos');
Route::post('/riscos/prazo',[RiscoController::class,'insertPrazo'])->name('riscos.prazo');
Route::post('/notificacoes/marcar-como-lidas', [RiscoController::class, 'marcarComoLidas'])->name('riscos.marcarComoLidas');
Route::post('/notificacoes/marcar-como-lida', [RiscoController::class, 'marcarComoLida'])->name('riscos.marcarComoLida');
Route::get('riscos/monitoramentos/{id}/edit', [RiscoController::class, 'editMonitoramento2'])->name('riscos.editMonitoramento');
Route::put('riscos/monitoramentos/{id}', [RiscoController::class, 'atualizaMonitoramento'])->name('riscos.monitoramento');





Auth::routes();

Route::get('/home', function(){
	return redirect()->route('riscos.index');
});

// Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
