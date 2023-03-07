<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CheckoutControler;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\HistoryController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProductController;
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

Route::group(['prefix' => 'customer'], function () {
    Route::controller(ProductController::class)->group(function () {
        Route::get('/products', 'index');
        Route::get('/products/{id}', 'show');
    });

    Route::controller(CustomerController::class)->group(function () {
        Route::post('/login', 'login');
        Route::post('/register', 'register');
    });

    Route::group(['prefix' => 'jwt', 'middleware' => 'auth:sanctum'], function () {
        Route::get('get-user', function () {
            return auth()->user();
        });
        Route::controller(CustomerController::class)->group(function () {
            Route::get('/user', 'getUser');
        });
        Route::controller(ProductController::class)->group(function () {
            Route::get('/products', 'index');
            Route::get('/products/{id}', 'show');
        });
        Route::controller(CartController::class)->group(function () {
            Route::get('/products/add/{id}', 'addToCart');
            Route::get('/cart', 'index');
            Route::get('/cart/plus/{id}', 'addQuantity');
            Route::get('/cart/minus/{id}', 'minusQuantity');
            Route::get('/cart/delete/{id}', 'delete');
        });
        Route::controller(CheckoutControler::class)->group(function () {
            Route::post('checkout/confirm', 'checkoutConfirm');
            Route::post('checkout/confirm/payment', 'payment');
        });
        Route::controller(HistoryController::class)->group(function () {
            Route::get('/history', 'index');
            Route::get('/history/{id}', 'show');
        });
    });
});

Route::group(['prefix' => 'admin'], function () {
    Route::controller(AdminController::class)->group(function () {
        Route::post('/login', 'login');
    });

    Route::group(['prefix' => 'jwt', 'middleware' => 'auth:sanctum'], function () {
        Route::resource('products', ProductController::class);
        Route::controller(OrderController::class)->group(function () {
            Route::get('/orders', 'index');
            Route::post('/orders/{id}', 'confirm');
        });
    });
});
