<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\SliderController;
use App\Http\Controllers\Api\ProductController;
use App\Http\Controllers\Api\ManufacturerController;
use App\Http\Controllers\Api\HomeController;
use App\Http\Controllers\Api\CategoryControler;

Route::post('register', [AuthController::class, 'register']);
Route::post('login', [AuthController::class, 'login']);

Route::get('/user', function (Request $request) {
    return $request->user();

})->middleware('auth:sanctum');
Route::get('/sliders', [SliderController::class, 'index'])->middleware('auth:sanctum');
Route::get('/products/trending', [ProductController::class, 'trending'])->middleware('auth:sanctum');
Route::get('/new/products', [ProductController::class, 'newProducts'])->middleware('auth:sanctum');
Route::get('/manufacturers/{id}', [ManufacturerController::class, 'index'])->middleware('auth:sanctum');
Route::get('/home', [HomeController::class, 'index'])->middleware('auth:sanctum');
Route::get('/categories/{id}', [CategoryControler::class, 'index'])->middleware('auth:sanctum');

