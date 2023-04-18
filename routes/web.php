<?php

use App\Mail\cobrarParcela;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\produtoController;
use App\Http\Controllers\vendaController;
use App\Http\Controllers\parcelaController;

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
 Route::get('/dashboard', function () {
    return view('welcome');
});


Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    //produto
    Route::get('/', [produtoController::class, 'index'])->name('produto.index');
    Route::get('/create', [produtoController::class, 'create'])->name('produto.create');
    Route::get('/show/{id}', [produtoController::class, 'show'])->name('produto.show');
    Route::post('/store', [produtoController::class, 'store'])->name('produto.store');
    
    Route::delete('/{id}', [produtoController::class, 'destroy'])->name('produto.destroy');
    Route::put('update/{id}', [produtoController::class, 'update'])->name('produto.update');
    //vendas
    Route::get('/vendas', [vendaController::class, 'index'])->name('venda.index');
    Route::get('/vendas/create', [vendaController::class, 'create'])->name('venda.create');
    Route::post('/vendas/store', [vendaController::class, 'store'])->name('venda.store');
    Route::post('/vendas/buscarProduto', [vendaController::class, 'buscarProduto'])->name('venda.buscarProduto');
    //parcelas
    Route::get('parcelas/{id}',[parcelaController::class,'show'])->name('parcela.show');
    Route::put('parcelas/update/',[parcelaController::class,'update'])->name('parcela.update');
    Route::post('parcelas/emailEnviar/',[parcelaController::class,'emailEnviar'])->name('parcela.emailEnviar');

    
   
});

require __DIR__.'/auth.php';
