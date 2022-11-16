<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ControllerPDV;
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

Route::get('/',[ControllerPDV::class, 'index']);
Route::get('/home',[ControllerPDV::class, 'index']);

Route::get('/historico-vendas', [ControllerPDV::class,'historico']);
Route::get('/adicionarVenda', [ControllerPDV::class,'adicionarVenda'])->name('adicionarVenda');
Route::post('/finalizarVenda/{id_venda}', [ControllerPDV::class,'finalizarVenda'])->name('finalizarVenda');
Route::post('/adicionarItemVenda/{id_venda}', [ControllerPDV::class,'adicionarItemVenda'])->name('adicionarItemVenda');
Route::post('/excluirItemVenda/{id_venda}/{id_produto}', [ControllerPDV::class,'excluirItemVenda'])->name('excluirItemVenda');

Route::get('/produtos', [ControllerPDV::class,'produtos']);
Route::post('/adicionarProduto', [ControllerPDV::class,'adicionarProduto'])->name('adicionarProduto');
Route::post('/excluirProduto/{id}', [ControllerPDV::class,'excluirProduto'])->name('excluirProduto');

Route::get('/sobre', [ControllerPDV::class,'sobre']);
