<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;

// Contoh bawaan Sanctum:
Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

// CRUD Products
Route::apiResource('products', ProductController::class);