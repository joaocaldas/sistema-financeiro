<?php

use App\Http\Controllers\RelatoriosController;
use App\Http\Controllers\ChequeController;
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



Route::group(['prefix' => '/'], function () {
    Voyager::routes();

    Route::get('relatorio-fluxo_caixa', [RelatoriosController::class, 'formFluxoCaixa'])->name('relatorio.form');
    Route::get('relatorio-fluxo_caixa/result', [RelatoriosController::class, 'fluxoCaixa'])->name('relatorio.result');
    Route::get('relatorio-cheques', [ChequeController::class, 'form'])->name('cheques.form');
    Route::get('relatorio-cheques/result', [ChequeController::class, 'relatorio'])->name('cheques.result');
    Route::get('cheques-a-compensar', [ChequeController::class, 'chequesACompensar'])->name('cheques.compensar');
    Route::post('cheque-compensar/{id}', [ChequeController::class, 'compensar'])->name('cheque.compensar');
});
