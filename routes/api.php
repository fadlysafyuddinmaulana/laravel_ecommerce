<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\ProductController;
use App\Http\Controllers\Api\CustomerController;
use App\Http\Controllers\Api\EmployeeController;
use App\Http\Controllers\Api\DepartmentController;
use App\Http\Controllers\Api\PositionsController;

// Contoh bawaan Sanctum:
Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::prefix('auth')->group(function () {
    // Register customer lewat API
    Route::post('/register/customer', [AuthController::class, 'registerCustomer'])
        ->name('api.auth.register.customer');

    // Login multi-role (customer / employee)
    Route::post('/login', [AuthController::class, 'login'])
        ->name('api.auth.login');

    // (Nanti) Logout dan profil, jika sudah siap multi-auth Sanctum
    // Route::middleware('auth:sanctum')->group(function () {
    //     Route::post('/logout', [AuthController::class, 'logout'])
    //         ->name('api.auth.logout');
    //     Route::get('/me', [AuthController::class, 'me'])
    //         ->name('api.auth.me');
    // });
});


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

// CRUD Departments
Route::apiResource('departments', DepartmentController::class)->names([
    'index' => 'api.departments.index',
    'store' => 'api.departments.store',
    'show' => 'api.departments.show',
    'update' => 'api.departments.update',
    'destroy' => 'api.departments.destroy',
]);

// CRUD Positions
Route::apiResource('positions', PositionsController::class)->names([
    'index' => 'api.positions.index',
    'store' => 'api.positions.store',
    'show' => 'api.positions.show',
    'update' => 'api.positions.update',
    'destroy' => 'api.positions.destroy',
]);