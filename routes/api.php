<?php

use App\Http\Controllers\Auth;
use App\Http\Controllers\Order;
use App\Http\Controllers\Stock;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('login', [Auth::class, 'login']);

Route::get('buns', [Stock::class, 'queryBuns'])->middleware('auth');
Route::get('fillings', [Stock::class, 'queryFillings'])->middleware('auth');

Route::post('order', [Order::class, 'store'])->middleware('auth');
Route::patch('order/{id}', [Order::class, 'update'])->middleware('auth');
Route::delete('order/{id}', [Order::class, 'destroy'])->middleware('auth');