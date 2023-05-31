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
Route::post('/register', [\App\Http\Controllers\Auth\RegisterController::class, 'store'])->name('register');

Route::middleware('auth:sanctum')->group(function (){

    Route::get('/me', function (Request $request){
        return $request->user();
    });

    Route::get('/users', [\App\Http\Controllers\UserController::class, 'index']);

    Route::apiResource('products', \App\Http\Controllers\Product\ProductController::class)->except('destroy');
    Route::get('cart', [\App\Http\Controllers\Cart\CartController::class, 'index'])->name('cart.index'); //my cart
    Route::apiResource('cart.items', \App\Http\Controllers\Cart\CartItemController::class)->except(['index', 'show']);
    Route::apiResource('payments', \App\Http\Controllers\Payment\PaymentController::class)->except('update');
    Route::apiResource('orders', \App\Http\Controllers\Order\OrderController::class)->except(['destroy']);

    Route::get('my/orders', [\App\Http\Controllers\Order\OrderController::class, 'myOrders'])->name('my.orders');

});
