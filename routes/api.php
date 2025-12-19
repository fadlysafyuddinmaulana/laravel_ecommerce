<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CustomerController;

// Contoh bawaan Sanctum:
Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

// CRUD Products
Route::apiResource('products', ProductController::class);
// CRUD Customers
Route::apiResource('customers', CustomerController::class);