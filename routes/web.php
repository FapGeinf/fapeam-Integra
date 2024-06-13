<?php

use App\Http\Controllers\RiscoController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});





Route::middleware('auth')->group(function () {
		Route::get('/', function (){return redirect()->route('riscos.home');});


		Route::get('/home', [RiscoController::class, 'home'])->name('riscos.home');

		Route::get('/risco/novo', [RiscoController::class,'create'])->name('riscos.create');
		Route::post('/risco/criar', [RiscoController::class, 'store'])->name('riscos.store');
		
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
