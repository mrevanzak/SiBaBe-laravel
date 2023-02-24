<?php

use App\Http\Controllers\CustomerController;
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
        Route::controller(CustomerController::class)->group(function () {
            Route::get('/user', 'getUser');
        });
        Route::controller(ProductController::class)->group(function () {
            Route::get('/products', 'index');
            Route::get('/products/{id}', 'show');
        });
    });
});

Route::group(['prefix' => 'admin'], function () {
    Route::resource('products', ProductController::class);
});
