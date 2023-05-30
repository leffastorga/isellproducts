<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::post('/sanctum/token', [\App\Http\Controllers\Auth\AuthenticatedController::class, 'store']);


Route::middleware('auth:sanctum')->group(function (){

    Route::get('/user', function (Request $request){
        return $request->user();
    });

    Route::apiResource('products', \App\Http\Controllers\Product\ProductController::class)->except('destroy');

});
