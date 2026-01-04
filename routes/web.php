<?php

use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductWebController;
use App\Http\Controllers\CategoryWebController;
use App\Http\Controllers\BrandWebController;
use App\Http\Controllers\EmployeeWebController;
use App\Http\Controllers\DepartmentWebController;
use App\Http\Controllers\PositionsWebController;
use App\Http\Controllers\AuthWebController;
use App\Http\Controllers\HomeWebController;
use App\Http\Controllers\CartWebController;

// halaman notice
Route::get('/email/verify', function () {
    // Jika sudah verified, redirect ke home
    if (auth()->user() && auth()->user()->hasVerifiedEmail()) {
        return redirect('/')->with('info', 'Email Anda sudah terverifikasi.');
    }
    return view('auth.verify-email');
})->middleware('auth')->name('verification.notice');

// link verifikasi
Route::get('/email/verify/{id}/{hash}', function (EmailVerificationRequest $request) {
    // Check jika sudah verified sebelumnya
    if ($request->user()->hasVerifiedEmail()) {
        return redirect('/')->with('info', 'Email Anda sudah terverifikasi sebelumnya.');
    }
    
    $request->fulfill(); // set email_verified_at
    
    // Set session untuk trigger auto refresh di halaman home
    session()->flash('email_verified', true);
    session()->flash('success', 'Email berhasil diverifikasi!');
    
    // Redirect langsung ke home
    return redirect('/');
})->middleware(['auth', 'signed'])->name('verification.verify');

// resend verifikasi
Route::post('/email/verification-notification', function (Request $request) {
    if ($request->user()->hasVerifiedEmail()) {
        return redirect()->route('landing');
    }

    $request->user()->sendEmailVerificationNotification();

    return back()->with('status', 'Link verifikasi baru sudah dikirim.');
})->middleware(['auth', 'throttle:6,1'])->name('verification.send');

Route::get('/', function () {
    return view('user_page.pages.index');
})->name('landing');

Route::get('/dashboard', function () {
    // Cek jika user adalah customer, redirect ke home
    if (auth()->check() && auth()->user()->role === 'customer') {
        return redirect('/')->with('error', 'Akses ditolak. Halaman ini hanya untuk admin dan pegawai.');
    }
    return view('pages.dashboard', ['layout' => 'layouts.app']);
})->middleware('auth')->name('dashboard');

// Authentication Routes
Route::get('/login', [AuthWebController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthWebController::class, 'login'])->name('login.post');
Route::get('/register', [AuthWebController::class, 'showRegisterForm'])->name('register');
Route::post('/register', [AuthWebController::class, 'register'])->name('register.post');
Route::post('/logout', [AuthWebController::class, 'logout'])->name('logout');

Route::get('/home', [HomeWebController::class, 'index'])->middleware(['auth'])->name('landing');
Route::get('/shop', [HomeWebController::class, 'shop'])->name('shop');
Route::get('/product/{id}', [ProductWebController::class, 'show'])->name('product.show');

// Cart Routes
Route::get('/cart', [CartWebController::class, 'index'])->name('cart');
Route::post('/cart/add', [CartWebController::class, 'add'])->name('cart.add');
Route::post('/cart/update', [CartWebController::class, 'update'])->name('cart.update');
Route::post('/cart/remove/{id}', [CartWebController::class, 'remove'])->name('cart.remove');
Route::post('/cart/clear', [CartWebController::class, 'clear'])->name('cart.clear');

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

// Brand Routes
Route::get('/brands', [BrandWebController::class, 'index'])->name('brands.index');
Route::get('/brands/create', [BrandWebController::class, 'create'])->name('brands.create');
Route::post('/brands', [BrandWebController::class, 'store'])->name('brands.store');
Route::get('/brands/{brand}/edit', [BrandWebController::class, 'edit'])->name('brands.edit');
Route::put('/brands/{brand}', [BrandWebController::class, 'update'])->name('brands.update');
Route::delete('/brands/{brand}', [BrandWebController::class, 'destroy'])->name('brands.destroy');

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
Route::post('/brands/bulk-delete', [BrandWebController::class, 'bulkDelete'])->name('brands.bulk-delete');
Route::post('/employees/bulk-delete', [EmployeeWebController::class, 'bulkDelete'])->name('employees.bulk-delete');
Route::post('/departments/bulk-delete', [DepartmentWebController::class, 'bulkDelete'])->name('departments.bulk-delete');
Route::post('/positions/bulk-delete', [PositionsWebController::class, 'bulkDelete'])->name('positions.bulk-delete');