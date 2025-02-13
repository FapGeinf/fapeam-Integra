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
use App\Http\Controllers\IndicadorController;


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

Route::get('/analise',[RiscoController::class,'analise'])->name('riscos.analise');

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

Route::get('/avaliacao', [DocumentoController::class, 'downloadAvaliacao'])->name('avaliacao');


// Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::get('/eixos',[DocumentoController::class,'eixos'])->name('documentos.eixos')->middleware('auth');;

Route::get('/historico', function () {
	return view('historico');
})->name('historico')->middleware('auth');

Route::get('/relatorio/riscos', [RelatorioController::class, 'gerarRelatorioGeral'])->name('relatorios.download');

Route::get('/intro',[DocumentoController::class,'intro'])->name('documentos.intro')->middleware('auth');

Route::prefix('apresentacoes')->name('apresentacoes.')->middleware('auth')->group(function () {
    Route::get('/eixo1', [EixosController::class, 'Eixo1'])->name('eixo1');
    Route::get('/eixo2', [EixosController::class, 'Eixo2'])->name('eixo2');
    Route::get('/eixo3', [EixosController::class, 'Eixo3'])->name('eixo3');
    Route::get('/eixo4', [EixosController::class, 'Eixo4'])->name('eixo4');
    Route::get('/eixo5', [EixosController::class, 'Eixo5'])->name('eixo5');
    Route::get('/eixo6', [EixosController::class, 'Eixo6'])->name('eixo6');
    Route::get('/eixo7', [EixosController::class, 'Eixo7'])->name('eixo7');
    Route::get('/eixo8', [EixosController::class, 'Eixo8'])->name('eixo8');
});

Route::prefix('atividades')->name('atividades.')->middleware('auth')->group(function () {
    Route::get('/', [AtividadeController::class, 'index'])->name('index');
    Route::post('/', [AtividadeController::class, 'index'])->name('atividades.index');
    Route::get('/show/{id}', [AtividadeController::class, 'showAtividade'])->name('show');
    Route::get('/create', [AtividadeController::class, 'createAtividade'])->name('create');
    Route::post('/store', [AtividadeController::class, 'storeAtividade'])->name('store');
    Route::get('/edit/{id}', [AtividadeController::class, 'editAtividade'])->name('edit');
    Route::put('/update/{id}', [AtividadeController::class, 'updateAtividade'])->name('update');
    Route::delete('/delete/{id}', [AtividadeController::class, 'deleteAtividade'])->name('delete');
});

Route::prefix('indicadores')->name('indicadores.')->middleware('auth')->group(function () {
		Route::match(['get', 'post'], '/', [IndicadorController::class, 'index'])->name('index');
    Route::get('/create', [IndicadorController::class, 'create'])->name('create');
    Route::post('/store', [IndicadorController::class, 'store'])->name('store');
    Route::get('/edit/{id}', [IndicadorController::class, 'edit'])->name('edit');
    Route::put('/update/{id}', [IndicadorController::class, 'update'])->name('update');
});
Route::get('/graficos',[RelatorioController::class,'graficosIndex'])->name('graficos.index');
Route::post('/canal/criar',[AtividadeController::class,'createCanal'])->name('canal.criar');
Route::get('/eixo/{eixo_id}', [EixosController::class, 'mostrarEixo'])->name('eixo.mostrar');