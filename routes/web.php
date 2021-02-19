<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\pizzaController;
use App\Http\Controllers\ingredienteController;
use App\Http\Controllers\pedidosController;
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

Route::get('/', function () {
    return view('laravue');
});


Route::get('/api/pizzas', [pizzaController::class, 'getPizza']);
Route::get('/api/pizzas/{id}/ingredientes', [pizzaController::class, 'getIngredientes']);
Route::post('/api/pizzas', ['uses' => 'pizzaController@setPizza' ]);

Route::get('/api/pedidos', [pedidosController::class, 'getPedido']);
Route::post('/api/pedidos', ['uses' => 'pedidosController@pedido' ]);

Route::get('/api/ingredientes', [ingredienteController::class, 'getIngrediente']);
Route::post('/api/ingredientes', ['uses' => 'ingredienteController@setIngrediente' ]);

Route::group(['middleware' => 'web'], function () {
    Route::get(env('LARAVUE_PATH'), 'LaravueController@index')->where('any', '.*')->name('laravue');
});
