# 📚 Rekap Komprehensif Laravel E-Commerce Project

**Tanggal Pembuatan**: 23 Desember 2025  
**Waktu**: 15:00:00 WIB  
**Branch**: main  
**Framework**: Laravel 12.x  
**Template Admin**: AdminLTE 3.2.0

---

## 📋 Table of Contents

1. [Ringkasan Executive](#ringkasan-executive)
2. [Struktur Folder Lengkap](#struktur-folder-lengkap)
3. [Alur MVC Detail](#alur-mvc-detail)
4. [Database Schema](#database-schema)
5. [Controllers](#controllers)
6. [Models](#models)
7. [Views](#views)
8. [Routes](#routes)
9. [Perubahan dari Awal hingga Sekarang](#perubahan-dari-awal-hingga-sekarang)
10. [Fitur yang Sudah Diimplementasi](#fitur-yang-sudah-diimplementasi)
11. [Catatan Penting](#catatan-penting)

---

## 🎯 Ringkasan Executive

### Project Overview

Laravel E-Commerce adalah aplikasi manajemen e-commerce berbasis web dengan arsitektur **dual-controller pattern** (Web + API). Project ini menggunakan Laravel 12.x sebagai backend framework dan AdminLTE 3.2.0 sebagai template admin panel.

### Arsitektur

```
┌────────────────────────────────────────────┐
│           DUAL ARCHITECTURE                │
├────────────────────────────────────────────┤
│                                            │
│  WEB (Browser)          API (JSON)         │
│  ↓                      ↓                  │
│  *WebController    →    *Controller        │
│  ↓                      ↓                  │
│  Blade Views       →    JSON Response      │
│  (Server-side)          (Stateless)        │
│                                            │
└────────────────────────────────────────────┘
```

### Tech Stack

-   **Backend**: Laravel 12.x, PHP 8.2+
-   **Frontend**: Blade Templates, AdminLTE 3.2.0
-   **Database**: MySQL/PostgreSQL
-   **UI Library**: Bootstrap 4, DataTables, SweetAlert2
-   **Icons**: Font Awesome 7.1.0
-   **Build Tool**: Vite, NPM
-   **Authentication**: Laravel Sanctum (API)

---

## 📂 Struktur Folder Lengkap

```
laravel_ecommerce/
│
├── .github/
│   └── copilot-instructions.md              [AI Agent Documentation]
│
├── app/
│   ├── Http/
│   │   └── Controllers/
│   │       ├── CategoryController.php       [API Controller]
│   │       ├── CategoryWebController.php    [Web Controller - CRUD Categories]
│   │       ├── CustomerController.php       [API Controller]
│   │       ├── Department.php               [Skeleton - Belum Implementasi]
│   │       ├── DepartmentController.php     [Skeleton - Belum Implementasi]
│   │       ├── EmployeeController.php       [Web Controller - CRUD Employees]
│   │       ├── EmployeeWebController.php    [Web Controller - Duplicate/Backup]
│   │       ├── PositionController.php       [Skeleton - Belum Implementasi]
│   │       ├── PositionWebController.php    [Skeleton - Belum Implementasi]
│   │       ├── ProductController.php        [API Controller]
│   │       └── ProductWebController.php     [Web Controller - CRUD Products]
│   │
│   └── Models/
│       ├── Category.php                     [Eloquent Model]
│       ├── Customer.php                     [Eloquent Model]
│       ├── Department.php                   [Eloquent Model - Skeleton]
│       ├── Employee.php                     [Eloquent Model + Auto-Code Generator]
│       ├── Position.php                     [Eloquent Model - Skeleton]
│       ├── Product.php                      [Eloquent Model]
│       └── User.php                         [Default Laravel User Model]
│
├── database/
│   ├── migrations/
│   │   ├── 0001_01_01_000000_create_users_table.php
│   │   ├── 0001_01_01_000001_create_cache_table.php
│   │   ├── 0001_01_01_000002_create_jobs_table.php
│   │   ├── 2025_12_17_052927_create_personal_access_tokens_table.php
│   │   ├── 2025_12_18_122942_create_products_table.php
│   │   ├── 2025_12_18_141148_create_customers_table.php
│   │   ├── 2025_12_18_141706_create_employees_table.php
│   │   ├── 2025_12_18_162839_create_categories_table.php
│   │   ├── 2025_12_22_184218_create_positions_table.php    [Migration Added]
│   │   └── 2025_12_22_184344_create_departments_table.php  [Migration Added]
│   │
│   └── seeders/
│       └── DatabaseSeeder.php
│
├── docs/
│   ├── 2025_12_22_143000_penjelasan_database_dan_api.md
│   ├── 2025_12_22_164500_project_documentation.md
│   └── 2025_12_23_103000_rekap_perubahan_project.md
│
├── public/
│   ├── assets/
│   │   ├── AdminLTE-3.2.0/                  [Template Aktif]
│   │   ├── AdminLTE-4.0.0-rc4/              [Tersedia, Tidak Dipakai]
│   │   └── fontawesome-free-7.1.0-web/     [Icon Library]
│   │       ├── css/
│   │       ├── js/
│   │       ├── svgs/                        [5,600+ SVG Icons]
│   │       └── webfonts/                    [WOFF2 Font Files]
│   │
│   └── storage → ../storage/app/public      [Symlink untuk File Upload]
│
├── resources/
│   ├── views/
│   │   ├── categories/
│   │   │   ├── index.blade.php              [List Categories + DataTables]
│   │   │   ├── create.blade.php             [Form Create Category]
│   │   │   └── edit.blade.php               [Form Edit Category]
│   │   │
│   │   ├── employees/
│   │   │   ├── index.blade.php              [List Employees + Row Expansion]
│   │   │   ├── create.blade.php             [Form Create Employee + Auto-Code]
│   │   │   └── edit.blade.php               [Form Edit Employee]
│   │   │
│   │   ├── layouts/
│   │   │   ├── app.blade.php                [Master Layout]
│   │   │   └── partials/
│   │   │       ├── header.blade.php         [Top Navbar]
│   │   │       ├── sidebar.blade.php        [Side Menu + Navigation]
│   │   │       └── footer.blade.php         [Footer]
│   │   │
│   │   ├── pages/
│   │   │   └── dashboard.blade.php          [Dashboard/Home]
│   │   │
│   │   ├── posistion/                       [TYPO: Should be "position"]
│   │   │   ├── index.blade.php              [Skeleton - Copy dari Products]
│   │   │   ├── create.blade.php             [Skeleton]
│   │   │   └── edit.blade.php               [Skeleton]
│   │   │
│   │   ├── products/
│   │   │   ├── index.blade.php              [List Products + Row Details]
│   │   │   ├── create.blade.php             [Form Create Product + Upload]
│   │   │   └── edit.blade.php               [Form Edit Product]
│   │   │
│   │   └── welcome.blade.php                [Laravel Default Welcome Page]
│   │
│   ├── css/
│   │   └── app.css
│   │
│   └── js/
│       ├── app.js
│       └── bootstrap.js
│
├── routes/
│   ├── api.php                              [RESTful API Routes]
│   ├── web.php                              [Web Routes dengan Manual Routing]
│   ├── web_backup.php                       [Backup File]
│   └── console.php
│
├── storage/
│   └── app/
│       └── public/                          [File Upload Destination]
│           ├── products/                    [Product Images]
│           ├── employees/                   [Employee Profile Images]
│           └── categories/                  [Category Images - Belum Dipakai]
│
├── composer.json                            [PHP Dependencies]
├── package.json                             [NPM Dependencies]
├── vite.config.js                          [Build Configuration]
└── phpunit.xml                             [Testing Configuration]
```

---

## 🔄 Alur MVC Detail

### 1. REQUEST FLOW (Web)

```
┌─────────────────────────────────────────────────────────────────┐
│                      USER ACTION (Browser)                       │
│  User mengakses URL: /products                                  │
└─────────────────────────────────────────────────────────────────┘
                            ↓
┌─────────────────────────────────────────────────────────────────┐
│                    ROUTES (routes/web.php)                       │
│  Route::get('/products', [ProductWebController::class, 'index'])│
│  →name('products.index')                                         │
└─────────────────────────────────────────────────────────────────┘
                            ↓
┌─────────────────────────────────────────────────────────────────┐
│               CONTROLLER (ProductWebController)                  │
│  public function index()                                        │
│  {                                                              │
│      $products = Product::join('categories')                    │
│                         ->select(...)                           │
│                         ->get();                                │
│      return view('products.index', compact('products'));        │
│  }                                                              │
└─────────────────────────────────────────────────────────────────┘
                            ↓
┌─────────────────────────────────────────────────────────────────┐
│                      MODEL (Product)                             │
│  - Eloquent ORM Query Builder                                   │
│  - Join dengan Categories table                                 │
│  - Return Collection of Products                                │
└─────────────────────────────────────────────────────────────────┘
                            ↓
┌─────────────────────────────────────────────────────────────────┐
│                    DATABASE (MySQL)                              │
│  SELECT products.*, categories.name as category_name            │
│  FROM products                                                  │
│  LEFT JOIN categories ON products.category_id = categories.id  │
└─────────────────────────────────────────────────────────────────┘
                            ↓
┌─────────────────────────────────────────────────────────────────┐
│                 VIEW (products/index.blade.php)                  │
│  - @extends('layouts.app')                                      │
│  - @foreach($products as $product)                              │
│  - DataTables JavaScript                                        │
│  - SweetAlert2 untuk Delete Confirmation                        │
└─────────────────────────────────────────────────────────────────┘
                            ↓
┌─────────────────────────────────────────────────────────────────┐
│                      RESPONSE (HTML)                             │
│  Browser render HTML dengan AdminLTE styling                    │
└─────────────────────────────────────────────────────────────────┘
```

### 2. CREATE/STORE FLOW (Detailed)

```
USER CLICK "New Product" BUTTON
    ↓
GET /products/create
    ↓
ProductWebController::create()
    - Load categories from database
    - Return view dengan dropdown categories
    ↓
USER SEES FORM
    - Name, Description, Price, Stock, etc.
    - Category Dropdown (from database)
    - Image Upload Field
    - Is Featured Checkbox
    ↓
USER SUBMIT FORM
    ↓
POST /products (with @csrf token)
    ↓
ProductWebController::store(Request $request)
    ↓
VALIDATION
    $request->validate([
        'name'  => 'required|string|max:255',
        'price' => 'required|numeric',
        'image' => 'nullable|image|max:2048',
        ...
    ]);
    ↓
IF VALIDATION FAILS
    → Redirect back dengan error messages
    → Flash old input values
    ↓
IF VALIDATION SUCCESS
    ↓
FILE UPLOAD (jika ada)
    $path = $request->file('image')->store('products', 'public');
    // Simpan ke: storage/app/public/products/xyz.jpg
    ↓
SAVE TO DATABASE
    Product::create([
        'name' => $data['name'],
        'price' => $data['price'],
        'image' => $path,  // products/xyz.jpg
        ...
    ]);
    ↓
SQL QUERY (di balik layar)
    INSERT INTO products (name, price, image, ...)
    VALUES ('Product Name', 100000, 'products/xyz.jpg', ...)
    ↓
REDIRECT WITH SUCCESS MESSAGE
    return redirect()->route('products.index')
            ->with('success', 'Product created successfully.');
    ↓
DISPLAY SUCCESS MESSAGE
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
```

---

## 🗄️ Database Schema

### 1. **Products Table**

```sql
CREATE TABLE `products` (
    `id` BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    `name` VARCHAR(255) NOT NULL,
    `description` TEXT NULL,
    `price` DECIMAL(12,2) NOT NULL,
    `stock` INT NOT NULL DEFAULT 0,
    `category_id` BIGINT UNSIGNED NULL,
    `brand` VARCHAR(25) NULL,
    `image` TEXT NULL,
    `status` VARCHAR(20) DEFAULT 'active',
    `is_featured` BOOLEAN DEFAULT FALSE,
    `created_at` TIMESTAMP NULL,
    `updated_at` TIMESTAMP NULL,

    -- Foreign Key
    FOREIGN KEY (`category_id`) REFERENCES `categories`(`id`)
        ON DELETE SET NULL
);
```

**Indexes**:

-   PRIMARY KEY: `id`
-   INDEX: `category_id` (untuk join cepat)
-   INDEX: `status` (untuk filter)
-   INDEX: `is_featured` (untuk query featured products)

**Validasi**:

-   `name`: Required, max 255 karakter
-   `price`: Required, numeric, > 0
-   `stock`: Required, integer, >= 0
-   `category_id`: Nullable, harus exist di categories table
-   `image`: Nullable, format image (jpg/png/webp), max 2MB

---

### 2. **Categories Table**

```sql
CREATE TABLE `categories` (
    `id` BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    `category_name` VARCHAR(255) NOT NULL,  -- ⚠️ Inconsistency!
    `description` TEXT NULL,
    `created_at` TIMESTAMP NULL,
    `updated_at` TIMESTAMP NULL
);
```

**⚠️ KNOWN ISSUE**: Migration menggunakan `category_name`, tetapi Model dan View menggunakan `name`

**Solusi**:

1. **Option A**: Rename column di migration
    ```sql
    ALTER TABLE categories CHANGE category_name name VARCHAR(255);
    ```
2. **Option B**: Update Model untuk mapping
    ```php
    protected $casts = ['category_name' => 'name'];
    ```

---

### 3. **Employees Table**

```sql
CREATE TABLE `employees` (
    `id` BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    `employee_code` VARCHAR(20) UNIQUE NOT NULL,  -- Auto-generated
    `first_name` VARCHAR(100) NOT NULL,
    `last_name` VARCHAR(100) NOT NULL,
    `email` VARCHAR(150) UNIQUE NULL,
    `phone` VARCHAR(20) NULL,
    `username` VARCHAR(255) UNIQUE NOT NULL,
    `password` VARCHAR(255) NOT NULL,  -- Hashed dengan bcrypt
    `profile_image` VARCHAR(255) NULL,
    `position` VARCHAR(50) NOT NULL,
    `department` VARCHAR(50) NOT NULL,
    `hire_date` DATE NULL,
    `salary` DECIMAL(15,2) NULL,
    `status` ENUM('active', 'inactive') DEFAULT 'active',
    `created_at` TIMESTAMP NULL,
    `updated_at` TIMESTAMP NULL
);
```

**Unique Constraints**:

-   `employee_code`: Auto-generated (EMP001, EMP002, ...)
-   `email`: Unique jika diisi
-   `username`: Unique, required

**Auto-Code Algorithm**:

```php
public static function generateEmployeeCode()
{
    $lastEmployee = self::orderBy('employee_code', 'desc')->first();
    if (!$lastEmployee) return 'EMP001';

    $lastNumber = (int) substr($lastEmployee->employee_code, 3);
    $newNumber = $lastNumber + 1;
    return 'EMP' . str_pad($newNumber, 3, '0', STR_PAD_LEFT);
}
```

---

### 4. **Customers Table**

```sql
CREATE TABLE `customers` (
    `id` BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    `name` VARCHAR(255) NOT NULL,
    `email` VARCHAR(255) UNIQUE NULL,
    `phone` VARCHAR(20) NULL,
    `address` TEXT NULL,
    `city` VARCHAR(100) NULL,
    `postal_code` VARCHAR(10) NULL,
    `gender` ENUM('male', 'female', 'other') NULL,
    `created_at` TIMESTAMP NULL,
    `updated_at` TIMESTAMP NULL
);
```

---

### 5. **Positions Table** (Skeleton)

```sql
CREATE TABLE `positions` (
    `id` BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    `position_code` VARCHAR(20) UNIQUE NULL,
    `position_name` VARCHAR(100) NULL,
    `description` TEXT NULL,
    `status` BOOLEAN DEFAULT TRUE,
    `created_at` TIMESTAMP NULL,
    `updated_at` TIMESTAMP NULL
);
```

---

### 6. **Departments Table** (Skeleton)

```sql
CREATE TABLE `departments` (
    `id` BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    `created_at` TIMESTAMP NULL,
    `updated_at` TIMESTAMP NULL
);
```

⚠️ **Note**: Migration belum lengkap, hanya struktur default

---

## 🎮 Controllers

### Pattern: Dual Controller Architecture

Laravel E-Commerce menggunakan **dual controller pattern**:

-   **`*WebController.php`** → Server-side rendering (Blade views)
-   **`*Controller.php`** → RESTful API (JSON responses)

### 1. ProductWebController.php

**Location**: `app/Http/Controllers/ProductWebController.php`

**Methods**:

#### `index(Request $request)`

```php
public function index(Request $request)
{
    $query = Product::join('categories', 'products.category_id', '=', 'categories.id')
                    ->select('products.*', 'categories.name as category_name');

    // Filter by category
    if ($request->filled('category_id')) {
        $query->where('products.category_id', $request->category_id);
    }

    $products = $query->orderBy('products.created_at', 'desc')->get();
    $categories = Category::orderBy('name')->get();

    return view('products.index', compact('products', 'categories'));
}
```

**Fungsi**:

-   Join dengan categories untuk mendapat nama kategori
-   Filter optional by category_id
-   Order by created_at descending (terbaru di atas)
-   Return view dengan data products dan categories

---

#### `create()`

```php
public function create()
{
    $categories = Category::orderBy('name')->get();
    return view('products.create', compact('categories'));
}
```

**Fungsi**:

-   Load categories untuk dropdown
-   Return form create

---

#### `store(Request $request)`

```php
public function store(Request $request)
{
    $data = $request->validate([
        'name'        => 'required|string|max:255',
        'description' => 'nullable|string',
        'price'       => 'required|numeric',
        'stock'       => 'required|integer|min:0',
        'category_id' => 'nullable|integer|exists:categories,id',
        'brand'       => 'nullable|string|max:25',
        'image'       => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        'status'      => 'nullable|string|max:20',
        'is_featured' => 'boolean',
    ]);

    // Handle file upload
    if ($request->hasFile('image')) {
        $path = $request->file('image')->store('products', 'public');
        $data['image'] = $path;
    }

    Product::create($data);

    return redirect()->route('products.index')
            ->with('success', 'Product created successfully.');
}
```

**Fungsi**:

-   Validasi input
-   Upload image ke `storage/app/public/products/`
-   Simpan path relatif ke database (`products/xyz.jpg`)
-   Redirect dengan flash message

---

#### `edit(Product $product)`

```php
public function edit(Product $product)
{
    $categories = Category::orderBy('name')->get();
    return view('products.edit', compact('product', 'categories'));
}
```

**Route Model Binding**: Parameter `$product` otomatis di-load dari database by ID

---

#### `update(Request $request, Product $product)`

```php
public function update(Request $request, Product $product)
{
    $data = $request->validate([...]);

    // Upload image baru jika ada
    if ($request->hasFile('image')) {
        $path = $request->file('image')->store('products', 'public');
        $data['image'] = $path;
    } else {
        // Jangan overwrite image lama
        unset($data['image']);
    }

    $product->update($data);

    return redirect()->route('products.index')
            ->with('success', 'Product updated successfully.');
}
```

**Logic Upload**:

-   Jika ada file baru → upload dan update path
-   Jika tidak ada file → jangan ubah path lama

---

#### `destroy(Product $product)`

```php
public function destroy(Product $product)
{
    $product->delete();
    return redirect()->route('products.index')
            ->with('success', 'Product deleted successfully.');
}
```

---

#### `bulkDelete(Request $request)`

```php
public function bulkDelete(Request $request)
{
    $request->validate([
        'ids' => 'required|array',
        'ids.*' => 'exists:products,id',
    ]);

    $count = Product::whereIn('id', $request->ids)->delete();

    return redirect()->route('products.index')
            ->with('success', "$count product(s) deleted successfully.");
}
```

---

### 2. CategoryWebController.php

**Similar Structure** dengan ProductWebController, tetapi lebih sederhana:

-   Tidak ada file upload
-   Tidak ada filter/search
-   Hanya CRUD basic

**Methods**:

-   `index()` - List categories dengan DataTables
-   `create()` - Form create
-   `store()` - Save category baru
-   `edit()` - Form edit
-   `update()` - Update category
-   `destroy()` - Delete category
-   `bulkDelete()` - Bulk delete categories

---

### 3. EmployeeController.php

**⚠️ Note**: Tidak ada `EmployeeWebController` (berbeda dari Product/Category)

**Special Features**:

1. **Auto-Generate Employee Code**:

    ```php
    $data['employee_code'] = Employee::generateEmployeeCode();
    ```

2. **Password Hashing**:

    ```php
    $data['password'] = Hash::make($data['password']);
    ```

3. **Password Optional pada Update**:

    ```php
    if ($request->filled('password')) {
        $data['password'] = Hash::make($data['password']);
    } else {
        unset($data['password']);
    }
    ```

4. **Profile Image Upload**:
    ```php
    if ($request->hasFile('profile_image')) {
        $path = $request->file('profile_image')->store('employees', 'public');
        $data['profile_image'] = $path;
    }
    ```

**Methods**:

-   `index()` - List employees dengan row expansion
-   `create()` - Form create dengan preview kode
-   `store()` - Save employee dengan auto-code & hash password
-   `edit()` - Form edit
-   `update()` - Update dengan password optional
-   `destroy()` - Delete employee
-   `bulkDelete()` - Bulk delete employees

---

### 4. API Controllers (ProductController, CategoryController, CustomerController)

**Location**: `app/Http/Controllers/*Controller.php` (tanpa suffix "Web")

**Karakteristik**:

-   Return JSON responses
-   Stateless (tidak pakai session)
-   Authentication via Sanctum (Bearer token)
-   Registered di `routes/api.php` dengan `apiResource()`

**Example Response**:

```json
{
    "success": true,
    "data": {
        "id": 1,
        "name": "Product Name",
        "price": 100000,
        ...
    }
}
```

---

## 📦 Models

### 1. Product.php

```php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = [
        'name', 'description', 'price', 'stock',
        'category_id', 'brand', 'image',
        'status', 'is_featured'
    ];

    // Relationship (belum diimplementasi)
    // public function category()
    // {
    //     return $this->belongsTo(Category::class);
    // }
}
```

**$fillable**: Whitelist untuk mass-assignment (security)

---

### 2. Category.php

```php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $fillable = ['name', 'description'];

    // ⚠️ Perlu mapping karena migration pakai 'category_name'
}
```

---

### 3. Employee.php

```php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Hash;

class Employee extends Model
{
    protected $fillable = [
        'employee_code', 'first_name', 'last_name',
        'email', 'phone', 'username', 'password',
        'profile_image', 'position', 'department',
        'hire_date', 'salary', 'status'
    ];

    /**
     * Generate unique employee code (EMP001, EMP002, ...)
     */
    public static function generateEmployeeCode()
    {
        $lastEmployee = self::orderBy('employee_code', 'desc')->first();

        if (!$lastEmployee) {
            return 'EMP001';
        }

        $lastNumber = (int) substr($lastEmployee->employee_code, 3);
        $newNumber = $lastNumber + 1;

        return 'EMP' . str_pad($newNumber, 3, '0', STR_PAD_LEFT);
    }
}
```

**Static Method**: `generateEmployeeCode()` dipanggil dari controller

---

### 4. Customer.php

```php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    protected $fillable = [
        'name', 'email', 'phone', 'address',
        'city', 'postal_code', 'gender'
    ];
}
```

---

### 5. Department.php & Position.php

**Skeleton Models** - Hanya struktur default:

```php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Department extends Model
{
    // Belum ada implementasi
}
```

---

## 🎨 Views

### Layout System

**Master Layout**: `layouts/app.blade.php`

```blade
<!DOCTYPE html>
<html lang="en">
<head>
    <title>@yield('title', 'Dashboard') - {{ config('app.name') }}</title>

    <!-- AdminLTE CSS -->
    <link rel="stylesheet" href="{{ asset('assets/AdminLTE-3.2.0/dist/css/adminlte.min.css') }}">

    <!-- Font Awesome 7.1.0 -->
    <link rel="stylesheet" href="{{ asset('assets/fontawesome-free-7.1.0-web/css/all.min.css') }}">

    <!-- SweetAlert2 -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">

    @stack('styles')
</head>
<body class="hold-transition sidebar-mini">
    <div class="wrapper">
        @include('layouts.partials.header')
        @include('layouts.partials.sidebar')

        <div class="content-wrapper">
            <div class="content-header">
                <h1>@yield('page-title')</h1>
                <ol class="breadcrumb">
                    @yield('breadcrumb')
                </ol>
            </div>

            <div class="content">
                @yield('content')
            </div>
        </div>

        @include('layouts.partials.footer')
    </div>

    <!-- jQuery & Bootstrap -->
    <script src="{{ asset('assets/AdminLTE-3.2.0/plugins/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('assets/AdminLTE-3.2.0/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>

    <!-- AdminLTE App -->
    <script src="{{ asset('assets/AdminLTE-3.2.0/dist/js/adminlte.min.js') }}"></script>

    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <!-- Global Success Toast -->
    <script>
        @if(session('success'))
            const Toast = Swal.mixin({
                toast: true,
                position: 'top-end',
                showConfirmButton: false,
                timer: 3000,
                timerProgressBar: true
            });

            Toast.fire({
                icon: 'success',
                title: '{{ session('success') }}'
            });
        @endif
    </script>

    @stack('scripts')
</body>
</html>
```

**Sections**:

-   `@yield('title')` - Page title untuk `<title>` tag
-   `@yield('page-title')` - H1 heading di content header
-   `@yield('breadcrumb')` - Breadcrumb navigation
-   `@yield('content')` - Main content area
-   `@stack('styles')` - Page-specific CSS
-   `@stack('scripts')` - Page-specific JavaScript

---

### Sidebar Menu Structure

**File**: `layouts/partials/sidebar.blade.php`

```
📂 Dashboard (/)
│
📂 Products (dropdown)
├── All Products (/products)
├── Categories (/categories)
├── Brands (# - placeholder)
├── Reviews (# - placeholder)
└── Stock Management (# - placeholder)
│
📂 Customers (dropdown)
├── All Customers (# - placeholder)
└── Customer Groups (# - placeholder)
│
📂 Employees (dropdown)
├── All Employees (/employees)
├── Positions (# - placeholder)
└── Departments (# - placeholder)
```

**Active Menu Highlight**:

```blade
<li class="nav-item {{ request()->routeIs('products.*') ? 'menu-open' : '' }}">
    <a href="#" class="nav-link {{ request()->routeIs('products.*') ? 'active' : '' }}">
        <i class="nav-icon fas fa-box"></i>
        <p>Products <i class="right fas fa-angle-left"></i></p>
    </a>
    <ul class="nav nav-treeview">
        <li class="nav-item">
            <a href="{{ route('products.index') }}"
               class="nav-link {{ request()->routeIs('products.index') ? 'active' : '' }}">
                <i class="fas fa-cubes nav-icon"></i>
                <p>All Products</p>
            </a>
        </li>
    </ul>
</li>
```

---

### DataTables Pattern

**Digunakan di**: products/index, categories/index, employees/index

**JavaScript Initialization**:

```javascript
$("#example1").DataTable({
    responsive: true,
    autoWidth: false,
    columnDefs: [
        {
            orderable: false,
            targets: [0, 8], // Checkbox & Actions tidak bisa di-sort
            searchable: false,
        },
    ],
    order: [[2, "asc"]], // Default sort by column 2 (Name)
    fnDrawCallback: function (oSettings) {
        // Auto numbering
        var api = this.api();
        var startIndex = api.context[0]._iDisplayStart;
        api.column(0, { order: "applied" })
            .nodes()
            .each(function (cell, i) {
                cell.innerHTML = startIndex + i + 1;
            });
    },
});
```

**Features**:

-   Pagination (10/25/50/100 per page)
-   Search/Filter real-time
-   Sorting per kolom
-   Auto-numbering (konsisten saat pindah halaman)
-   Responsive layout

---

### Row Expansion Pattern (Employee)

**HTML**:

```blade
<tr data-hire-date="{{ $employee->hire_date }}"
    data-salary="{{ $employee->salary }}">
    <td>{{ $employee->name }}</td>
    <td>
        <button class="btn btn-sm btn-info details-control">
            <i class="fa-regular fa-folder-closed"></i>
        </button>
    </td>
</tr>
```

**JavaScript**:

```javascript
$(".details-control").on("click", function () {
    var tr = $(this).closest("tr");
    var row = table.row(tr);

    if (row.child.isShown()) {
        row.child.hide();
        btn.html('<i class="fa-regular fa-folder-closed"></i>');
    } else {
        var rowData = {
            hireDate: tr.data("hire-date"),
            salary: tr.data("salary"),
        };
        row.child(format(rowData)).show();
        btn.html('<i class="fa-regular fa-folder-open"></i>');
    }
});
```

**Function Format**:

```javascript
function format(rowData) {
    return (
        '<div class="employee-details">' +
        "<dl>" +
        "<dt>Hire Date</dt><dd>" +
        rowData.hireDate +
        "</dd>" +
        "<dt>Salary</dt><dd>" +
        rowData.salary +
        "</dd>" +
        "</dl></div>"
    );
}
```

---

### SweetAlert2 Integration

**Delete Confirmation**:

```javascript
$(".btn-delete").on("click", function (e) {
    e.preventDefault();
    var form = $(this).closest("form");

    Swal.fire({
        title: "Are you sure?",
        text: "You won't be able to revert this!",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#d33",
        cancelButtonColor: "#3085d6",
        confirmButtonText: "Yes, delete it!",
    }).then((result) => {
        if (result.isConfirmed) {
            form.submit();
        }
    });
});
```

**Success Toast** (Global):

```javascript
@if(session('success'))
    Toast.fire({
        icon: 'success',
        title: '{{ session('success') }}'
    });
@endif
```

---

## 🛣️ Routes

### Web Routes (routes/web.php)

**Dashboard**:

```php
Route::get('/', function () {
    return view('pages.dashboard');
})->name('dashboard');
```

---

**Products** (Manual Resourceful):

```php
Route::get('/products', [ProductWebController::class, 'index'])->name('products.index');
Route::get('/products/create', [ProductWebController::class, 'create'])->name('products.create');
Route::post('/products', [ProductWebController::class, 'store'])->name('products.store');
Route::get('/products/{product}/edit', [ProductWebController::class, 'edit'])->name('products.edit');
Route::put('/products/{product}', [ProductWebController::class, 'update'])->name('products.update');
Route::delete('/products/{product}', [ProductWebController::class, 'destroy'])->name('products.destroy');
Route::post('/products/bulk-delete', [ProductWebController::class, 'bulkDelete'])->name('products.bulk-delete');
```

---

**Categories**:

```php
Route::get('/categories', [CategoryWebController::class, 'index'])->name('categories.index');
Route::get('/categories/create', [CategoryWebController::class, 'create'])->name('categories.create');
Route::post('/categories', [CategoryWebController::class, 'store'])->name('categories.store');
Route::get('/categories/{category}/edit', [CategoryWebController::class, 'edit'])->name('categories.edit');
Route::put('/categories/{category}', [CategoryWebController::class, 'update'])->name('categories.update');
Route::delete('/categories/{category}', [CategoryWebController::class, 'destroy'])->name('categories.destroy');
Route::post('/categories/bulk-delete', [CategoryWebController::class, 'bulkDelete'])->name('categories.bulk-delete');
```

---

**Employees**:

```php
Route::get('/employees', [EmployeeWebController::class, 'index'])->name('employees.index');
Route::get('/employees/create', [EmployeeWebController::class, 'create'])->name('employees.create');
Route::post('/employees', [EmployeeWebController::class, 'store'])->name('employees.store');
Route::get('/employees/{employee}/edit', [EmployeeWebController::class, 'edit'])->name('employees.edit');
Route::put('/employees/{employee}', [EmployeeWebController::class, 'update'])->name('employees.update');
Route::delete('/employees/{employee}', [EmployeeWebController::class, 'destroy'])->name('employees.destroy');
Route::post('/employees/bulk-delete', [EmployeeWebController::class, 'bulkDelete'])->name('employees.bulk-delete');
```

---

### API Routes (routes/api.php)

```php
Route::apiResource('products', ProductController::class)->names([
    'index' => 'api.products.index',
    'store' => 'api.products.store',
    'show' => 'api.products.show',
    'update' => 'api.products.update',
    'destroy' => 'api.products.destroy'
]);

Route::apiResource('categories', CategoryController::class)->names([
    'index' => 'api.categories.index',
    'store' => 'api.categories.store',
    'show' => 'api.categories.show',
    'update' => 'api.categories.update',
    'destroy' => 'api.categories.destroy'
]);

Route::apiResource('customers', CustomerController::class)->names([
    'index' => 'api.customers.index',
    'store' => 'api.customers.store',
    'show' => 'api.customers.show',
    'update' => 'api.customers.update',
    'destroy' => 'api.customers.destroy'
]);
```

**Prefix**: Semua route otomatis dapat prefix `/api`  
**Example**: `GET /api/products`, `POST /api/products`, `PUT /api/products/1`

---

## 📊 Perubahan dari Awal hingga Sekarang

### Commit Timeline

```
┌─────────────────────────────────────────────────────────┐
│ 24b12a1 - Implement product management API             │
│           (Initial commit - API only)                   │
└─────────────────────────────────────────────────────────┘
                        ↓
┌─────────────────────────────────────────────────────────┐
│ beeea3e - Tambah tabel & model kategori                │
│           (Category table + basic CRUD)                 │
└─────────────────────────────────────────────────────────┘
                        ↓
┌─────────────────────────────────────────────────────────┐
│ e6295af - Tambah Customer model + migration            │
│           (Customer table dengan enum gender)           │
└─────────────────────────────────────────────────────────┘
                        ↓
┌─────────────────────────────────────────────────────────┐
│ a6451c2 - Tambah Employee model + Controller           │
│           (Employee CRUD implementation)                │
└─────────────────────────────────────────────────────────┘
                        ↓
┌─────────────────────────────────────────────────────────┐
│ 76eb93c - Implementasi manajemen produk CRUD           │
│           (Enhanced Product features)                   │
└─────────────────────────────────────────────────────────┘
                        ↓
┌─────────────────────────────────────────────────────────┐
│ 94ba3b2 - Implement AdminLTE v4.0.0-rc4               │
│           (Initial AdminLTE integration)                │
└─────────────────────────────────────────────────────────┘
                        ↓
┌─────────────────────────────────────────────────────────┐
│ 3189802 - Perombakan layout dengan AdminLTE           │
│           (Layout restructure + partials)               │
└─────────────────────────────────────────────────────────┘
                        ↓
┌─────────────────────────────────────────────────────────┐
│ 84ba959 - Implementasi Produk & Kategori + AdminLTE   │
│           (Switch to AdminLTE 3.2.0 stable)             │
└─────────────────────────────────────────────────────────┘
                        ↓
┌─────────────────────────────────────────────────────────┐
│ 189c3df - Enhanced Product & Category Management       │
│ 166ddb5 - Revert experiment                            │
│ 553f78e - Database simulation + sample data            │
│ 68e069f - Revert simulation                            │
└─────────────────────────────────────────────────────────┘
                        ↓
┌─────────────────────────────────────────────────────────┐
│ eb97a6a - Merge branch 'frontend-adminlte'             │
│           (Merge all frontend changes)                  │
└─────────────────────────────────────────────────────────┘
                        ↓
┌─────────────────────────────────────────────────────────┐
│ 061d3a2 - FontAwesome 7.1.0 + Employee Enhancement     │ ← CURRENT
│           - Upgrade FontAwesome ke v7.1.0               │
│           - Auto-generate employee code                 │
│           - Enhanced Employee UI                        │
│           - SweetAlert2 integration                     │
│           - Row expansion pattern                       │
│           - Bulk delete features                        │
│           - Copilot instructions                        │
└─────────────────────────────────────────────────────────┘
```

---

### Major Changes Summary

#### 1. **Infrastructure**

-   ✅ Laravel 12.x setup
-   ✅ AdminLTE 3.2.0 integration (downgrade dari 4.0.0-rc4)
-   ✅ Font Awesome upgrade dari v6 → v7.1.0
-   ✅ DataTables integration
-   ✅ SweetAlert2 integration

#### 2. **Database**

-   ✅ Products table
-   ✅ Categories table (⚠️ dengan inconsistency nama kolom)
-   ✅ Customers table
-   ✅ Employees table
-   ✅ Positions table (skeleton)
-   ✅ Departments table (skeleton)

#### 3. **Backend**

-   ✅ Dual controller pattern (Web + API)
-   ✅ File upload implementation
-   ✅ Auto-code generation (Employee)
-   ✅ Password hashing (Employee)
-   ✅ Validation rules
-   ✅ Flash messages
-   ✅ Bulk delete functionality

#### 4. **Frontend**

-   ✅ Master layout dengan partials
-   ✅ Products CRUD views
-   ✅ Categories CRUD views
-   ✅ Employees CRUD views
-   ✅ DataTables integration
-   ✅ Row expansion (Employee)
-   ✅ SweetAlert2 confirmations
-   ✅ Image preview

#### 5. **Documentation**

-   ✅ Database & API explanation (Indonesian)
-   ✅ Project documentation (English)
-   ✅ Change log (Indonesian)
-   ✅ Copilot instructions (.github)

---

## ✅ Fitur yang Sudah Diimplementasi

### 🎨 **UI/UX Features**

#### AdminLTE Integration

-   [x] Master layout dengan sidebar + header + footer
-   [x] Responsive design (mobile-friendly)
-   [x] Active menu highlighting
-   [x] Breadcrumb navigation
-   [x] DataTables untuk semua list page
-   [x] Bootstrap 4 styling
-   [x] Font Awesome 7.1.0 icons

#### Interactive Elements

-   [x] SweetAlert2 delete confirmation
-   [x] Success toast notification (top-right)
-   [x] Flash messages (session-based)
-   [x] Row expansion (Employee details)
-   [x] Bulk select checkboxes
-   [x] Auto-numbering pada DataTables
-   [x] Image preview di edit form

---

### 📦 **Product Management**

#### CRUD Operations

-   [x] List products dengan join categories
-   [x] Create product dengan image upload
-   [x] Edit product (preserve image lama)
-   [x] Delete product dengan konfirmasi
-   [x] Bulk delete products

#### Features

-   [x] Filter by category dropdown
-   [x] Search by product name
-   [x] Show product details (row expansion)
-   [x] Status badge (active/inactive)
-   [x] Featured product checkbox
-   [x] Price formatting (Rp.)
-   [x] Stock management
-   [x] Brand field

---

### 📁 **Category Management**

#### CRUD Operations

-   [x] List categories dengan DataTables
-   [x] Create category
-   [x] Edit category
-   [x] Delete category dengan konfirmasi
-   [x] Bulk delete categories

#### Features

-   [x] Search by category name
-   [x] Description field (optional)
-   [x] Simple form (no image upload)

---

### 👥 **Employee Management**

#### CRUD Operations

-   [x] List employees dengan DataTables
-   [x] Create employee dengan auto-code
-   [x] Edit employee (password optional)
-   [x] Delete employee dengan konfirmasi
-   [x] Bulk delete employees

#### Special Features

-   [x] **Auto-generate employee code** (EMP001, EMP002, ...)
-   [x] **Password hashing** dengan bcrypt
-   [x] **Row expansion** untuk hire_date & salary
-   [x] **Profile image upload** (prepared, not yet in form)
-   [x] Status badge (active/inactive)
-   [x] Username unique validation
-   [x] Email unique validation (optional)
-   [x] Position & Department fields

---

### 🔐 **Security Features**

-   [x] CSRF protection (@csrf token)
-   [x] Password hashing (Hash::make)
-   [x] Mass-assignment protection ($fillable)
-   [x] Validation rules
-   [x] Unique constraints (email, username, employee_code)
-   [x] File upload validation (type, size)

---

### 🌐 **API Endpoints**

#### Products API

-   [x] GET /api/products (list all)
-   [x] POST /api/products (create)
-   [x] GET /api/products/{id} (show single)
-   [x] PUT/PATCH /api/products/{id} (update)
-   [x] DELETE /api/products/{id} (delete)

#### Categories API

-   [x] GET /api/categories
-   [x] POST /api/categories
-   [x] GET /api/categories/{id}
-   [x] PUT/PATCH /api/categories/{id}
-   [x] DELETE /api/categories/{id}

#### Customers API

-   [x] GET /api/customers
-   [x] POST /api/customers
-   [x] GET /api/customers/{id}
-   [x] PUT/PATCH /api/customers/{id}
-   [x] DELETE /api/customers/{id}

---

## 📝 Catatan Penting

### ⚠️ **Known Issues**

#### 1. Database Inconsistency

**Problem**: Categories table migration menggunakan `category_name`, tetapi Model dan View menggunakan `name`

**Location**: `database/migrations/2025_12_18_162839_create_categories_table.php`

**Impact**:

-   Query join menggunakan `categories.name` akan error
-   Perlu mapping manual atau rename column

**Solutions**:

```sql
-- Option A: Rename column di database
ALTER TABLE categories CHANGE category_name name VARCHAR(255);

-- Option B: Update migration dan re-migrate
// Ubah di migration:
$table->string('category_name');
// Menjadi:
$table->string('name');
```

---

#### 2. Typo Folder Name

**Problem**: Folder `resources/views/posistion/` seharusnya `position/`

**Impact**:

-   Typo bisa menyebabkan confusion
-   Belum dipakai karena masih skeleton

**Solution**:

```bash
# Rename folder
mv resources/views/posistion resources/views/position
```

---

#### 3. Duplicate Employee Controllers

**Problem**: Ada 2 controller untuk Employee:

-   `EmployeeController.php`
-   `EmployeeWebController.php`

**Observation**:

-   Routes menggunakan `EmployeeWebController`
-   `EmployeeController` mungkin backup/duplicate

**Recommendation**: Delete salah satu atau dokumentasikan fungsinya

---

#### 4. Skeleton Files

**Files yang belum diimplementasi**:

-   `DepartmentController.php` - Hanya struktur default
-   `PositionController.php` - Hanya struktur default
-   `PositionWebController.php` - Hanya struktur default
-   `Department.php` model - Tidak ada $fillable
-   `Position.php` model - Tidak ada $fillable
-   `resources/views/posistion/` - Copy dari products, belum disesuaikan

**Status**: Prepared for future implementation

---

#### 5. Profile Image Upload (Employee)

**Status**: Column ada di database, field ada di form, tetapi tidak functional

**Missing**:

-   Upload logic di controller sudah ada
-   Form field sudah ada
-   Preview belum ditampilkan di index

**To Do**: Test upload functionality

---

### 📌 **Best Practices yang Diterapkan**

#### 1. **Naming Conventions**

-   Controllers: `PascalCase` + suffix `Controller` atau `WebController`
-   Models: `PascalCase` singular
-   Tables: `snake_case` plural
-   Routes: `kebab-case` dengan prefix jelas
-   Views: `kebab-case.blade.php`

#### 2. **Security**

-   CSRF token untuk semua POST/PUT/DELETE
-   Password hashing dengan bcrypt
-   Mass-assignment protection dengan $fillable
-   File upload validation (type + size)
-   Unique constraints di database

#### 3. **Code Organization**

-   Partials untuk reusable components (header, sidebar, footer)
-   Stack untuk page-specific CSS/JS
-   Flash messages untuk user feedback
-   Route model binding untuk cleaner code
-   Validation di controller (bukan di model)

#### 4. **User Experience**

-   Confirm before delete (SweetAlert2)
-   Success toast notification
-   Loading states (DataTables)
-   Responsive layout
-   Clear error messages
-   Auto-numbering di tabel

---

### 🚀 **Next Steps / Recommendations**

#### Priority 1 (Critical)

-   [ ] Fix category table naming inconsistency
-   [ ] Remove duplicate EmployeeController
-   [ ] Fix folder typo (posistion → position)

#### Priority 2 (Important)

-   [ ] Implement Position management (CRUD)
-   [ ] Implement Department management (CRUD)
-   [ ] Complete profile image upload untuk Employee
-   [ ] Add relationship methods di Models (belongsTo, hasMany)
-   [ ] Soft delete implementation

#### Priority 3 (Enhancement)

-   [ ] Add authentication/authorization
-   [ ] Implement role-based access control
-   [ ] Export to Excel/PDF
-   [ ] Advanced search/filter
-   [ ] Dashboard analytics
-   [ ] Activity logs/audit trail

#### Priority 4 (Nice to Have)

-   [ ] Multi-language support (i18n)
-   [ ] Email notifications
-   [ ] Image cropping/resizing
-   [ ] Barcode/QR code generation
-   [ ] Inventory alerts
-   [ ] Sales reporting

---

## 🎓 Kesimpulan

### Achievements

Project Laravel E-Commerce ini telah berhasil mengimplementasikan:

1. **Arsitektur Dual Controller** - Web (Blade) + API (JSON)
2. **CRUD Lengkap** untuk 3 modul utama (Products, Categories, Employees)
3. **UI/UX Modern** dengan AdminLTE 3.2.0 + DataTables + SweetAlert2
4. **Security Best Practices** - CSRF, Password Hashing, Validation
5. **Advanced Features** - Auto-code generation, Row expansion, Bulk delete
6. **Comprehensive Documentation** - 3 dokumen markdown + Copilot instructions

### Current State

-   **Database**: 6 tables (3 fully implemented, 3 skeleton)
-   **Controllers**: 12 files (6 functional, 6 skeleton/backup)
-   **Models**: 7 models (4 functional, 3 skeleton)
-   **Views**: 20+ Blade templates
-   **Routes**: 21+ web routes, 15+ API routes
-   **Assets**: AdminLTE 3.2.0, Font Awesome 7.1.0, DataTables, SweetAlert2

### Code Quality

-   ✅ Laravel conventions
-   ✅ RESTful routing
-   ✅ MVC pattern
-   ✅ DRY principle
-   ✅ Secure coding
-   ⚠️ Needs: Relationships, Testing, Documentation cleanup

### Ready for Production?

**Not Yet** - Perlu:

1. Fix known issues (naming inconsistency)
2. Implement authentication
3. Add unit/feature tests
4. Complete remaining modules (Position, Department)
5. Optimize queries (N+1 problem)
6. Setup CI/CD

---

**Dokumentasi ini dibuat untuk**:

-   Referensi development team
-   Onboarding developer baru
-   Code review
-   Project handover
-   GitHub Copilot AI Agent

**Versi**: 2.0  
**Tanggal**: 23 Desember 2025  
**Dibuat oleh**: AI Assistant + Development Team  
**Status**: Living Document (akan diupdate seiring development)
