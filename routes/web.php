<?php

use App\Events\PrazoProximo;
use App\Http\Controllers\AtividadeController;
use App\Http\Controllers\DocumentoController;
use App\Http\Controllers\EixosController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RiscoController;
use App\Http\Controllers\StatusController;
use App\Http\Controllers\UserController;
use App\Models\Prazo;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\RelatorioController;


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
Route::get('/home', function (){
	return redirect()->route('riscos.index');
});

Route::get('/', function () {
	return redirect()->route('documentos.intro');
});

Route::get('/index', [RiscoController::class, 'index'])->name('riscos.index');
Route::get('/risco/novo', [RiscoController::class,'create'])->name('riscos.create');
Route::post('/risco/criar', [RiscoController::class, 'store'])->name('riscos.store');
Route::get('/riscos/show/{id}', [RiscoController::class, 'show'])->name('riscos.show');
Route::get('/riscos/{id}/edit', [RiscoController::class, 'edit'])->name('riscos.edit');
Route::put('/riscos/{id}', [RiscoController::class, 'update'])->name('riscos.update');
Route::post('/riscos/monitoramentos/{id}/respostas', [RiscoController::class, 'storeResposta'])->name('riscos.storeResposta');
Route::delete('/riscos/monitoramentos/{id}',[RiscoController::class,'deleteMonitoramento'])->name('riscos.deleteMonitoramento');
Route::get('/riscos/respostas/{id}', [RiscoController::class, 'respostas'])->name('riscos.respostas');
Route::get('/riscos/{id}/edit-monitoramentos', [RiscoController::class, 'editMonitoramentos'])->name('riscos.edit-monitoramentos');
Route::post('/riscos/{id}/update-monitoramentos', [RiscoController::class, 'insertMonitoramentos'])->name('riscos.insert-monitoramentos');
Route::post('/riscos/prazo',[RiscoController::class,'insertPrazo'])->name('riscos.prazo');
Route::post('/notificacoes/marcar-como-lidas', [RiscoController::class, 'marcarComoLidas'])->name('riscos.marcarComoLidas');
Route::post('/notificacoes/marcar-como-lida', [RiscoController::class, 'marcarComoLida'])->name('riscos.marcarComoLida');
Route::get('riscos/monitoramentos/{id}/edit', [RiscoController::class, 'editMonitoramento2'])->name('riscos.editMonitoramento');
Route::put('riscos/monitoramentos/{id}', [RiscoController::class, 'atualizaMonitoramento'])->name('riscos.monitoramento');
Route::put('/riscos/monitoramentos/respostas/{id}', [RiscoController::class, 'updateResposta'])->name('riscos.updateResposta');
Route::delete('riscos/delete-anexo/${respostaId}', [RiscoController::class, 'deleteAnexo'])->name('riscos.deleteAnexo');



Route::get('/painel', [UserController::class, 'painel'])->name('usuarios.index');
Route::put('/user/update/{id}', [UserController::class, 'updateUser'])->name('user.update');
Route::delete('/user/delete/{id}', [UserController::class, 'deleteUser'])->name('user.destroy');

Route::get('/user/alterar-senha', [UserController::class, 'changePassword'])->name('users.password');
Route::post('/user/alterar-senha',[UserController::class,'updatePassword'])->name('users.password');
Route::post('/notifications/mark-as-read', [RiscoController::class, 'markAsRead'])->name('riscos.markAsRead');


Route::get('/riscos/implementadas', [StatusController::class, 'implementadasShow'])->name('riscos.implementadas');
Route::get('/riscos/implementadas-parcialmente', [StatusController::class, 'implementadasParcialmenteShow'])->name('riscos.implementadasParcialmente');
Route::get('/riscos/em-implementacao', [StatusController::class, 'emImplementacaoShow'])->name('riscos.emImplementacao');
Route::get('/riscos/nao-implementada', [StatusController::class, 'naoImplementadaShow'])->name('riscos.naoImplementada');


Auth::routes();


Route::get('/apresentacao', [DocumentoController::class, 'showSystemPage'] )->name('apresentacao');

Route::get('/legislacao', function () {
	return view('links_login.legislacao');
})->name('legislacao');

Route::get('/manual', [DocumentoController::class, 'downloadManual'])->name('manual');

// Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::get('/eixos',[DocumentoController::class,'eixos'])->name('documentos.eixos')->middleware('auth');;

Route::get('/historico', function () {
	return view('historico');
})->name('historico')->middleware('auth');

Route::get('/relatorio/riscos', [RelatorioController::class, 'gerarRelatorioGeral'])->name('relatorios.download');

Route::get('/intro',[DocumentoController::class,'intro'])->name('documentos.intro')->middleware('auth');



Route::get('/apresentacoes/eixo1', [EixosController::class, 'Eixo1'])->name('apresentacoes.eixo1')->middleware('auth');
Route::get('/apresentacoes/eixo2', [EixosController::class, 'Eixo2'])->name('apresentacoes.eixo2')->middleware('auth');
Route::get('/apresentacoes/eixo3', [EixosController::class, 'Eixo3'])->name('apresentacoes.eixo3')->middleware('auth');
Route::get('/apresentacoes/eixo4', [EixosController::class, 'Eixo4'])->name('apresentacoes.eixo4')->middleware('auth');
Route::get('/apresentacoes/eixo5', [EixosController::class, 'Eixo5'])->name('apresentacoes.eixo5')->middleware('auth');
Route::get('/apresentacoes/eixo6', [EixosController::class, 'Eixo6'])->name('apresentacoes.eixo6')->middleware('auth');
Route::get('/apresentacoes/eixo7', [EixosController::class, 'Eixo7'])->name('apresentacoes.eixo7')->middleware('auth');
Route::get('/apresentacoes/eixo8', [EixosController::class, 'Eixo8'])->name('apresentacoes.eixo8')->middleware('auth');


Route::get('/atividades',[AtividadeController::class,'index'])->name('atividades.index')->middleware('auth');
Route::get('/atividade/show/{id}',[AtividadeController::class,'showAtividade'])->name('atividades.show')->middleware('auth');
Route::get('/atividades/create',[AtividadeController::class,'createAtividade'])->name('atividades.create')->middleware('auth');
Route::post('/atividades/store',[AtividadeController::class,'storeAtividade'])->name('atividades.store')->middleware('auth');
Route::get('/atividade/edit/{id}',[AtividadeController::class,'editAtividade'])->name('atividades.edit')->middleware('auth');
Route::put('/atividade/update/{id}',[AtividadeController::class,'updateAtividade'])->name('atividades.update')->middleware('auth');
Route::delete('/atividade/delete/{id}',[AtividadeController::class,'deleteAtividade'])->name('atividades.delete')->middleware('auth');

Route::get('/graficos',[RelatorioController::class,'graficosIndex'])->name('graficos.index');