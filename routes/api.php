<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\EmployeeController;

// Contoh bawaan Sanctum:
Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

// CRUD Products
Route::apiResource('products', ProductController::class);
// CRUD Customers
Route::apiResource('customers', CustomerController::class);
// CRUD Employee
Route::apiResource('employees', EmployeeController::class);