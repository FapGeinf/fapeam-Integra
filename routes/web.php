<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RiscoController;

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
Auth::routes();

Route::get('/home', function(){
	return redirect()->route('riscos.index');
});

// Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
