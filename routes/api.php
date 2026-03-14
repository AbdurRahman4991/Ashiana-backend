<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\SliderController;
use App\Http\Controllers\Api\ProductController;
use App\Http\Controllers\Api\ManufacturerController;
use App\Http\Controllers\Api\HomeController;
use App\Http\Controllers\Api\CategoryControler;
use App\Http\Controllers\Api\OrderControllr;

Route::post('register', [AuthController::class, 'register']);
Route::post('login', [AuthController::class, 'login']);
Route::get('/search', [ProductController::class, 'search']);

// Route::get('/user', function (Request $request) {
//     return $request->user();

// })->middleware('auth:sanctum');

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/sliders', [SliderController::class, 'index']);
    Route::get('/products/trending', [ProductController::class, 'trending']);
    Route::get('/manufacturers/{id}', [ManufacturerController::class, 'index']);
    Route::get('/new/products', [ProductController::class, 'newProducts']);
    Route::get('/categories/{id}', [CategoryControler::class, 'index']);
    Route::get('/home', [HomeController::class, 'index']);
    Route::post('/orders', [OrderControllr::class, 'placeOrder']);
    Route::get('/my-orders', [OrderControllr::class, 'myOrders']);

    Route::get('/orders/{id}', [OrderControllr::class, 'show']);
    Route::get('/orders/{id}/invoice', [OrderControllr::class, 'invoice']);

});
