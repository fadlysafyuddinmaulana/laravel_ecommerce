# 📚 Laravel E-Commerce - Project Documentation

**Tanggal**: 22 Desember 2025  
**Waktu**: 16:45:00 WIB  
**Branch**: main  
**Framework**: Laravel 11.x  
**Admin Template**: AdminLTE 3.2.0

---

## 📋 Table of Contents

1. [Ringkasan Proyek](#ringkasan-proyek)
2. [Database Structure](#database-structure)
3. [MVC Architecture Flow](#mvc-architecture-flow)
4. [Perubahan Detail](#perubahan-detail)
5. [File Structure](#file-structure)
6. [Routing](#routing)

---

## 🎯 Ringkasan Proyek

Proyek ini adalah aplikasi **Laravel E-Commerce** dengan fitur manajemen produk dan kategori. Menggunakan arsitektur **MVC (Model-View-Controller)** standar Laravel dengan AdminLTE sebagai template admin panel.

### Fitur Utama:

- ✅ **Dashboard** - Halaman utama admin
- ✅ **Product Management** - CRUD untuk produk
- ✅ **Category Management** - CRUD untuk kategori
- ✅ **Image Upload** - Upload gambar produk
- ✅ **DataTables Integration** - Tabel dinamis dengan search & pagination
- ✅ **Responsive UI** - AdminLTE 3.2.0

---

## 🗄️ Database Structure

### **1. Products Table**

**Migration**: `2025_12_18_122942_create_products_table.php`

| Column        | Type                   | Description                       |
| ------------- | ---------------------- | --------------------------------- |
| `id`          | BIGINT (PK)            | Primary key                       |
| `name`        | VARCHAR(255)           | Nama produk                       |
| `description` | TEXT (nullable)        | Deskripsi produk                  |
| `price`       | DECIMAL(12,2)          | Harga produk                      |
| `stock`       | INTEGER                | Stok produk (default: 0)          |
| `category_id` | BIGINT (nullable)      | Foreign key ke categories         |
| `brand`       | VARCHAR(25) (nullable) | Brand/merk produk                 |
| `image`       | TEXT (nullable)        | Path gambar produk                |
| `status`      | VARCHAR(20)            | Status produk (default: 'active') |
| `is_featured` | BOOLEAN                | Produk unggulan (default: false)  |
| `created_at`  | TIMESTAMP              | Waktu dibuat                      |
| `updated_at`  | TIMESTAMP              | Waktu diupdate                    |

### **2. Categories Table**

**Migration**: `2025_12_18_162839_create_categories_table.php`

| Column          | Type            | Description        |
| --------------- | --------------- | ------------------ |
| `id`            | BIGINT (PK)     | Primary key        |
| `category_name` | VARCHAR(255)    | Nama kategori      |
| `description`   | TEXT (nullable) | Deskripsi kategori |
| `created_at`    | TIMESTAMP       | Waktu dibuat       |
| `updated_at`    | TIMESTAMP       | Waktu diupdate     |

⚠️ **Note**: Ada inkonsistensi nama kolom di migration (`category_name`) vs Model (`name`). Perlu diperbaiki.

---

## 🔄 MVC Architecture Flow

### **Architecture Overview**

```
┌─────────────┐      ┌──────────────┐      ┌─────────────┐      ┌──────────────┐
│   Browser   │ ───> │   Routes     │ ───> │ Controller  │ ───> │    Model     │
│  (User)     │      │  (web.php)   │      │             │      │  (Database)  │
└─────────────┘      └──────────────┘      └─────────────┘      └──────────────┘
       ^                                           │                      │
       │                                           │                      │
       │                                           v                      v
       │                                    ┌─────────────┐        ┌──────────────┐
       └──────────────────────────────────  │    View     │  <───  │   Query      │
                                            │ (Blade)     │        │   Result     │
                                            └─────────────┘        └──────────────┘
```

---

## 📦 1. PRODUCT MODULE

### **Model**: `Product.php`

**Location**: `app/Models/Product.php`

```php
<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = [
        'name', 'description', 'price', 'stock',
        'category_id', 'brand', 'image',
        'status', 'is_featured'
    ];
}
```

**Fungsi**:

- Mendefinisikan tabel `products`
- Menentukan kolom yang bisa diisi mass-assignment (`$fillable`)
- Eloquent ORM untuk query database

---

### **Controller**: `ProductWebController.php`

**Location**: `app/Http/Controllers/ProductWebController.php`

#### **Methods & Flow**:

1. **`index(Request $request)`** - Menampilkan daftar produk

   ```
   Route: GET /products
   Flow:
   - Join dengan tabel categories
   - Filter by category_id (optional)
   - Search by name (optional)
   - Return view 'products.index' dengan data products & categories
   ```

2. **`create()`** - Form tambah produk

   ```
   Route: GET /products/create
   Flow:
   - Ambil semua kategori untuk dropdown
   - Return view 'products.create'
   ```

3. **`store(Request $request)`** - Simpan produk baru

   ```
   Route: POST /products
   Flow:
   - Validasi input (name, price, stock, dll)
   - Upload image ke storage/app/public/products
   - Simpan data ke database
   - Redirect ke products.index dengan pesan sukses
   ```

4. **`edit(Product $product)`** - Form edit produk

   ```
   Route: GET /products/{product}/edit
   Flow:
   - Route model binding otomatis load product by ID
   - Ambil semua kategori untuk dropdown
   - Return view 'products.edit' dengan data product
   ```

5. **`update(Request $request, Product $product)`** - Update produk

   ```
   Route: PUT /products/{product}
   Flow:
   - Validasi input
   - Upload image baru jika ada
   - Update data di database
   - Redirect ke products.index dengan pesan sukses
   ```

6. **`destroy(Product $product)`** - Hapus produk
   ```
   Route: DELETE /products/{product}
   Flow:
   - Soft/hard delete product
   - Redirect ke products.index dengan pesan sukses
   ```

---

### **Views**: Products

**Location**: `resources/views/products/`

1. **`index.blade.php`** - Daftar produk
   - DataTables dengan search & pagination
   - Filter by category dropdown
   - Button: Create, Edit, Delete
   - Tampilkan: Name, Brand, Category, Price, Stock, Status, Image

2. **`create.blade.php`** - Form tambah produk
   - Input: Name, Description, Price, Stock
   - Select: Category, Status
   - File upload: Image
   - Checkbox: Is Featured

3. **`edit.blade.php`** - Form edit produk
   - Pre-filled form dengan data product
   - Preview image saat ini
   - Logic upload image baru/keep existing

---

## 📁 2. CATEGORY MODULE

### **Model**: `Category.php`

**Location**: `app/Models/Category.php`

```php
<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $fillable = ['name', 'description'];
}
```

**Fungsi**:

- Mendefinisikan tabel `categories`
- Mass-assignment untuk `name` dan `description`

---

### **Controller**: `CategoryWebController.php`

**Location**: `app/Http/Controllers/CategoryWebController.php`

#### **Methods & Flow**:

1. **`index(Request $request)`** - Daftar kategori

   ```
   Route: GET /categories
   Flow:
   - Query semua kategori
   - Search by name (optional)
   - Order by created_at DESC
   - Return view 'categories.index'
   ```

2. **`create()`** - Form tambah kategori

   ```
   Route: GET /categories/create
   Flow: Return view 'categories.create'
   ```

3. **`store(Request $request)`** - Simpan kategori

   ```
   Route: POST /categories
   Flow:
   - Validasi: name (required), description (nullable)
   - Create category
   - Redirect dengan success message
   ```

4. **`edit(Category $category)`** - Form edit kategori

   ```
   Route: GET /categories/{category}/edit
   Flow:
   - Route model binding
   - Return view 'categories.edit'
   ```

5. **`update(Request $request, Category $category)`** - Update kategori

   ```
   Route: PUT /categories/{category}
   Flow:
   - Validasi input
   - Update category
   - Redirect dengan success message
   ```

6. **`destroy(Category $category)`** - Hapus kategori
   ```
   Route: DELETE /categories/{category}
   Flow:
   - Delete category
   - Redirect dengan success message
   ```

---

### **Views**: Categories

**Location**: `resources/views/categories/`

1. **`index.blade.php`** - Daftar kategori
   - DataTables integration
   - Columns: No, Name, Description, Actions
   - Button: New Category, Edit, Delete

2. **`create.blade.php`** - Form tambah kategori
   - Input: Name (required)
   - Textarea: Description (optional)

3. **`edit.blade.php`** - Form edit kategori
   - Pre-filled form dengan data kategori

---

## 🛣️ Routing

**File**: `routes/web.php`

### Dashboard

```php
Route::get('/', function () {
    return view('pages.dashboard');
})->name('dashboard');
```

### Products Resource Routes

```php
Route::get('/products', [ProductWebController::class, 'index'])->name('products.index');
Route::get('/products/create', [ProductWebController::class, 'create'])->name('products.create');
Route::post('/products', [ProductWebController::class, 'store'])->name('products.store');
Route::get('/products/{product}/edit', [ProductWebController::class, 'edit'])->name('products.edit');
Route::put('/products/{product}', [ProductWebController::class, 'update'])->name('products.update');
Route::delete('/products/{product}', [ProductWebController::class, 'destroy'])->name('products.destroy');
```

### Categories Resource Routes

```php
Route::get('/categories', [CategoryWebController::class, 'index'])->name('categories.index');
Route::get('/categories/create', [CategoryWebController::class, 'create'])->name('categories.create');
Route::post('/categories', [CategoryWebController::class, 'store'])->name('categories.store');
Route::get('/categories/{category}/edit', [CategoryWebController::class, 'edit'])->name('categories.edit');
Route::put('/categories/{category}', [CategoryWebController::class, 'update'])->name('categories.update');
Route::delete('/categories/{category}', [CategoryWebController::class, 'destroy'])->name('categories.destroy');
```

---

## 📝 Perubahan Detail

### ✅ **File yang Dimodifikasi**

#### 1. **Controllers**

- **`ProductWebController.php`** ✏️ Modified
  - Added image upload logic
  - Added category join & filter
  - Added search functionality
  - Updated validation rules

#### 2. **Database Migrations**

- **`2025_12_18_162839_create_categories_table.php`** ✏️ Modified
  - Changed column name from `name` to `category_name`
  - Added description field

#### 3. **Views - Layouts**

- **`resources/views/layouts/app.blade.php`** ✏️ Modified
  - Restructured layout dengan partials
  - Added DataTables CSS/JS
  - Added stack untuk styles & scripts

- **`resources/views/pages/dashboard.blade.php`** ✏️ Modified
  - Updated template extends & sections

#### 4. **Views - Products**

- **`resources/views/products/index.blade.php`** ✏️ Modified
  - Added category filter dropdown
  - Added DataTables integration
  - Added image preview column
  - Added search functionality

- **`resources/views/products/create.blade.php`** ✏️ Modified
  - Added category dropdown
  - Added image upload field
  - Added is_featured checkbox
  - Added status select

- **`resources/views/products/edit.blade.php`** ✏️ Modified
  - Similar to create.blade.php
  - Added current image preview
  - Pre-filled form values

#### 5. **Routes**

- **`routes/web.php`** ✏️ Modified
  - Added all product routes (CRUD)
  - Added all category routes (CRUD)
  - Changed dashboard route

---

### ➕ **File Baru yang Ditambahkan**

#### 1. **Controllers**

- ✨ `app/Http/Controllers/CategoryController.php` (API - tidak digunakan)
- ✨ `app/Http/Controllers/CategoryWebController.php` (Web CRUD)

#### 2. **Views - Categories**

- ✨ `resources/views/categories/index.blade.php`
- ✨ `resources/views/categories/create.blade.php`
- ✨ `resources/views/categories/edit.blade.php`

#### 3. **Views - Layouts (Partials)**

- ✨ `resources/views/layouts/partials/header.blade.php` - Top navbar
- ✨ `resources/views/layouts/partials/sidebar.blade.php` - Side menu
- ✨ `resources/views/layouts/partials/footer.blade.php` - Footer

#### 4. **Documentation**

- ✨ `PENJELASAN_DATABASE_DAN_API.md` - Database & API docs

#### 5. **Assets**

- ✨ `public/assets/` - AdminLTE 3.2.0 template files

#### 6. **Routes Backup**

- ✨ `routes/web_backup.php` - Backup file

---

### ❌ **File yang Dihapus**

#### 1. **Old Partials (Moved)**

- 🗑️ `resources/views/partials/footer.blade.php` → Moved to `layouts/partials/`
- 🗑️ `resources/views/partials/header.blade.php` → Moved to `layouts/partials/`
- 🗑️ `resources/views/partials/sidebar.blade.php` → Moved to `layouts/partials/`

#### 2. **AdminLTE 4.0 RC (Removed)**

- 🗑️ `assets/AdminLTE-4.0.0-rc4/` - Complete folder (300+ files)
- 🗑️ `assets/AdminLTE-4.0.0-rc4.zip`

**Reason**: Switched to stable AdminLTE 3.2.0 from RC version 4.0

---

## 📂 File Structure

```
laravel_ecommerce/
├── app/
│   ├── Http/
│   │   └── Controllers/
│   │       ├── CategoryController.php          ✨ NEW (API)
│   │       ├── CategoryWebController.php       ✨ NEW (Web)
│   │       ├── ProductWebController.php        ✏️ MODIFIED
│   │       ├── ProductController.php           (Existing)
│   │       ├── CustomerController.php          (Existing)
│   │       └── EmployeeController.php          (Existing)
│   └── Models/
│       ├── Category.php                        (Existing)
│       ├── Product.php                         (Existing)
│       ├── Customer.php                        (Existing)
│       └── Employee.php                        (Existing)
│
├── database/
│   └── migrations/
│       ├── 2025_12_18_122942_create_products_table.php
│       └── 2025_12_18_162839_create_categories_table.php  ✏️ MODIFIED
│
├── resources/
│   └── views/
│       ├── layouts/
│       │   ├── app.blade.php                   ✏️ MODIFIED
│       │   └── partials/                       ✨ NEW FOLDER
│       │       ├── header.blade.php            ✨ NEW
│       │       ├── sidebar.blade.php           ✨ NEW
│       │       └── footer.blade.php            ✨ NEW
│       ├── pages/
│       │   └── dashboard.blade.php             ✏️ MODIFIED
│       ├── products/
│       │   ├── index.blade.php                 ✏️ MODIFIED
│       │   ├── create.blade.php                ✏️ MODIFIED
│       │   └── edit.blade.php                  ✏️ MODIFIED
│       └── categories/                         ✨ NEW FOLDER
│           ├── index.blade.php                 ✨ NEW
│           ├── create.blade.php                ✨ NEW
│           └── edit.blade.php                  ✨ NEW
│
├── routes/
│   ├── web.php                                 ✏️ MODIFIED
│   └── web_backup.php                          ✨ NEW
│
├── public/
│   └── assets/                                 ✨ NEW
│       └── AdminLTE-3.2.0/                     ✨ NEW
│
└── PENJELASAN_DATABASE_DAN_API.md              ✨ NEW
```

---

## 🎨 Layout Structure

### **Main Layout**: `layouts/app.blade.php`

```blade
<!DOCTYPE html>
<html>
<head>
    <!-- Meta, Title, CSS -->
    @stack('styles')
</head>
<body>
    <div class="wrapper">
        @include('layouts.partials.header')
        @include('layouts.partials.sidebar')

        <div class="content-wrapper">
            <div class="content-header">
                <h1>@yield('page-title')</h1>
                <ol>@yield('breadcrumb')</ol>
            </div>

            <div class="content">
                @yield('content')
            </div>
        </div>

        @include('layouts.partials.footer')
    </div>

    <!-- Scripts -->
    @stack('scripts')
</body>
</html>
```

### **Sidebar Menu**:

```
├── Dashboard (/)
└── Products (dropdown)
    ├── All Products (/products)
    ├── Categories (/categories)
    ├── Brand (belum ada route)
    ├── Reviews (belum ada route)
    └── Stock Management (belum ada route)
```

---

## 🔧 Features Implemented

### ✅ **Products**

- [x] List products dengan DataTables
- [x] Create product dengan image upload
- [x] Edit product
- [x] Delete product
- [x] Filter by category
- [x] Search by name
- [x] Join dengan categories table

### ✅ **Categories**

- [x] List categories dengan DataTables
- [x] Create category
- [x] Edit category
- [x] Delete category
- [x] Search by name

### ✅ **UI/UX**

- [x] AdminLTE 3.2.0 template
- [x] Responsive layout
- [x] DataTables pagination & search
- [x] Success/Error flash messages
- [x] Breadcrumb navigation
- [x] Active menu indicator

---

## ⚠️ Issues & Todo

### **🐛 Bugs**

1. ❌ Inkonsistensi nama kolom:
   - Migration: `category_name`
   - Model: `name`
   - **Fix**: Update migration atau model agar sama

2. ❌ Delete button menggunakan `<a>` tag bukan `<form>`
   - DELETE request seharusnya pakai form + method spoofing
   - **Fix**: Ganti dengan form DELETE proper

3. ❌ Category relationship tidak didefinisikan di Model
   - Product model tidak punya `belongsTo(Category::class)`
   - **Fix**: Tambahkan Eloquent relationships

### **📋 Todo**

- [ ] Tambah validation error display di form
- [ ] Implementasi Brand management
- [ ] Implementasi Reviews management
- [ ] Implementasi Stock management
- [ ] Add Customer & Employee CRUD
- [ ] Implementasi authentication/login
- [ ] Image deletion saat update/delete product
- [ ] Add soft deletes
- [ ] Add seeder untuk sample data

---

## 🚀 Development Flow Example

### **Example: Adding a New Product**

1. **User** akses `/products/create`
2. **Route** match `products.create`
3. **Controller** `ProductWebController@create`:
   ```php
   public function create() {
       $categories = Category::orderBy('name')->get();
       return view('products.create', compact('categories'));
   }
   ```
4. **View** `products/create.blade.php` render form
5. **User** submit form ke `/products` (POST)
6. **Route** match `products.store`
7. **Controller** `ProductWebController@store`:
   ```php
   - Validate input
   - Upload image → storage/app/public/products/
   - Product::create($data)
   - Redirect dengan success message
   ```
8. **Database** insert new row di `products` table
9. **User** redirect ke `/products` dengan pesan "Product created successfully"

---

## 📊 Statistics

| Metric            | Count               |
| ----------------- | ------------------- |
| Total Controllers | 7                   |
| Total Models      | 5                   |
| Total Views       | 11+                 |
| Total Routes      | 13                  |
| Database Tables   | 5+                  |
| Modified Files    | 7                   |
| New Files         | 10+                 |
| Deleted Files     | 300+ (AdminLTE 4.0) |

---

## 🎓 Conclusion

Proyek ini mengimplementasikan **MVC pattern** dengan baik:

- **Model**: Handle database logic (Product, Category)
- **View**: Blade templates dengan AdminLTE
- **Controller**: Business logic untuk CRUD operations

Struktur kode mengikuti Laravel conventions dengan route model binding, validation, dan Eloquent ORM. UI responsif dengan DataTables untuk user experience yang lebih baik.

---

**Generated**: 22 Desember 2025  
**Waktu**: 16:45:00 WIB  
**Version**: 1.0  
**Author**: Laravel E-Commerce Team
