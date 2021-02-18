<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\pizzaController;

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
Route::get('/', [pizzaController::class, 'index']);
/*
Route::get('/', function () {
    return view('layouts/app');
});
Route::get('/pizza', [pizzaController::class, 'index']);

*/
Auth::routes();
Route::post('/pedido', ['uses' => 'App\Http\Controllers\pedidosController@pedido' ]);
Route::get('/home', [pizzaController::class, 'index']);

//Auth::routes();

//Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
