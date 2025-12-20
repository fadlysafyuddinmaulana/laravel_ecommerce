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
Route::apiResource('products', ProductController::class)->names([
    'index' => 'api.products.index',
    'store' => 'api.products.store',
    'show' => 'api.products.show',
    'update' => 'api.products.update',
    'destroy' => 'api.products.destroy',
]);
// CRUD Customers
Route::apiResource('customers', CustomerController::class)->names([
    'index' => 'api.customers.index',
    'store' => 'api.customers.store',
    'show' => 'api.customers.show',
    'update' => 'api.customers.update',
    'destroy' => 'api.customers.destroy',
]);
// CRUD Employee
Route::apiResource('employees', EmployeeController::class)->names([
    'index' => 'api.employees.index',
    'store' => 'api.employees.store',
    'show' => 'api.employees.show',
    'update' => 'api.employees.update',
    'destroy' => 'api.employees.destroy',
]);