<?php

use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Web\ProductWebController;
use App\Http\Controllers\Web\CategoryWebController;
use App\Http\Controllers\Web\EmployeeWebController;
use App\Http\Controllers\Web\DepartmentWebController;
use App\Http\Controllers\Web\PositionsWebController;
use App\Http\Controllers\Web\AuthWebController;
use App\Http\Controllers\Web\HomeWebController;

// Email verification routes
Route::get('/email/verify', function () {
    return view('auth.verify-email');
})->middleware('auth')  // pakai guard web (customers)
  ->name('verification.notice');


// Email verification routes
Route::get('/email/verify', function () {
    return view('auth.verify-email');
})->middleware('auth')  // pakai guard web (customers)
  ->name('verification.notice');

Route::get('/email/verify/{id}/{hash}', function (EmailVerificationRequest $request) {
    $request->fulfill();      // set email_verified_at
    return redirect()->route('landing'); // atau route lain
})->middleware(['auth', 'signed'])
  ->name('verification.verify');

Route::post('/email/verification-notification', function (Request $request) {
    $request->user()->sendEmailVerificationNotification();
    return back()->with('message', 'Verification link sent!');
})->middleware(['auth', 'throttle:6,1'])
  ->name('verification.send');

// Landing Page
Route::get('/', function () {
    return view('user_page.pages.index');
})->name('landing');

Route::get('/dashboard', function () {
    return view('pages.dashboard', ['layout' => 'layouts.app']);
})->name('dashboard');

// Authentication Routes
Route::get('/login', [AuthWebController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthWebController::class, 'login'])->name('auth.login.post');
Route::get('/register', [AuthWebController::class, 'showRegisterForm'])->name('auth.register');
Route::post('/register', [AuthWebController::class, 'register'])->name('auth.register.post');
Route::post('/logout', [AuthWebController::class, 'logout'])->name('auth.logout');

Route::get('/home', [HomeWebController::class, 'index'])->middleware(['auth'])->name('landing');
Route::get('/shop', [HomeWebController::class, 'shop'])->name('shop');

// Resource Routes
Route::get('/products', [ProductWebController::class, 'index'])->name('products.index');
Route::get('/products/create', [ProductWebController::class, 'create'])->name('products.create');
Route::post('/products', [ProductWebController::class, 'store'])->name('products.store');
Route::get('/products/{product}/edit', [ProductWebController::class, 'edit'])->name('products.edit');
Route::put('/products/{product}', [ProductWebController::class, 'update'])->name('products.update');
Route::delete('/products/{product}', [ProductWebController::class, 'destroy'])->name('products.destroy');

// Category Routes
Route::get('/categories', [CategoryWebController::class, 'index'])->name('categories.index');
Route::get('/categories/create', [CategoryWebController::class, 'create'])->name('categories.create');
Route::post('/categories', [CategoryWebController::class, 'store'])->name('categories.store');
Route::get('/categories/{category}/edit', [CategoryWebController::class, 'edit'])->name('categories.edit');
Route::put('/categories/{category}', [CategoryWebController::class, 'update'])->name('categories.update');
Route::delete('/categories/{category}', [CategoryWebController::class, 'destroy'])->name('categories.destroy');

// Employee Routes
Route::get('/employees', [EmployeeWebController::class, 'index'])->name('employees.index');
Route::get('/employees/create', [EmployeeWebController::class, 'create'])->name('employees.create');
Route::post('/employees', [EmployeeWebController::class, 'store'])->name('employees.store');
Route::get('/employees/{employee}/edit', [EmployeeWebController::class, 'edit'])->name('employees.edit');
Route::put('/employees/{employee}', [EmployeeWebController::class, 'update'])->name('employees.update');
Route::delete('/employees/{employee}', [EmployeeWebController::class, 'destroy'])->name('employees.destroy');

// Department Routes
Route::get('/departments', [DepartmentWebController::class, 'index'])->name('departments.index');
Route::get('/departments/create', [DepartmentWebController::class, 'create'])->name('departments.create');
Route::post('/departments', [DepartmentWebController::class, 'store'])->name('departments.store');
Route::get('/departments/{department}/edit', [DepartmentWebController::class, 'edit'])->name('departments.edit');
Route::put('/departments/{department}', [DepartmentWebController::class, 'update'])->name('departments.update');
Route::delete('/departments/{department}', [DepartmentWebController::class, 'destroy'])->name('departments.destroy');

// Position Routes
Route::get('/positions', [PositionsWebController::class, 'index'])->name('positions.index');
Route::get('/positions/create', [PositionsWebController::class, 'create'])->name('positions.create');
Route::post('/positions', [PositionsWebController::class, 'store'])->name('positions.store');
Route::get('/positions/{position}/edit', [PositionsWebController::class, 'edit'])->name('positions.edit');
Route::put('/positions/{position}', [PositionsWebController::class, 'update'])->name('positions.update');
Route::delete('/positions/{position}', [PositionsWebController::class, 'destroy'])->name('positions.destroy');

// Bulk delete routes
Route::post('/products/bulk-delete', [ProductWebController::class, 'bulkDelete'])->name('products.bulk-delete');
Route::post('/categories/bulk-delete', [CategoryWebController::class, 'bulkDelete'])->name('categories.bulk-delete');
Route::post('/employees/bulk-delete', [EmployeeWebController::class, 'bulkDelete'])->name('employees.bulk-delete');
Route::post('/departments/bulk-delete', [DepartmentWebController::class, 'bulkDelete'])->name('departments.bulk-delete');
Route::post('/positions/bulk-delete', [PositionsWebController::class, 'bulkDelete'])->name('positions.bulk-delete');