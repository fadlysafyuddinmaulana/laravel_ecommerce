# Penjelasan: Penyimpanan Data ke Database & RESTful API

## 📋 Daftar Isi

1. [Alur Penyimpanan Data ke Database](#alur-penyimpanan-data-ke-database)
2. [Cara Kerja RESTful API](#cara-kerja-restful-api)
3. [Perbedaan Web Routes vs API Routes](#perbedaan-web-routes-vs-api-routes)
4. [HTTP Methods dalam REST](#http-methods-dalam-rest)
5. [Contoh Request & Response API](#contoh-request--response-api)

---

## 🔄 Alur Penyimpanan Data ke Database

### 1. Route Definition

**File**: `routes/web.php`

```php
Route::post('/products', [ProductWebController::class, 'store'])->name('products.store');
```

**Penjelasan:**

-   Mendefinisikan endpoint POST `/products`
-   Mengarahkan ke method `store` di `ProductWebController`
-   Memberikan nama route `products.store` untuk referensi di template Blade

---

### 2. Form Submission

**File**: `resources/views/products/create.blade.php`

```php
<form method="POST" action="{{ route('products.store') }}" enctype="multipart/form-data">
    @csrf
    <!-- form fields -->
</form>
```

**Penjelasan setiap atribut:**

-   `method="POST"` → HTTP method untuk create data baru
-   `action="{{ route('products.store') }}"` → URL tujuan (mengarah ke route yang sudah didefinisikan)
-   `@csrf` → Token keamanan Laravel untuk mencegah Cross-Site Request Forgery (CSRF) attack
-   `enctype="multipart/form-data"` → Encoding type yang diperlukan untuk upload file/gambar

---

### 3. Controller Method

**File**: `app/Http/Controllers/ProductWebController.php`

#### a. Validation (Validasi Input)

```php
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
```

**Apa yang terjadi:**

1. Laravel memvalidasi semua input dari form
2. Jika validasi **gagal**: otomatis redirect kembali ke form dengan error messages
3. Jika validasi **sukses**: data yang sudah tervalidasi disimpan ke variable `$data` dan proses dilanjutkan

**Rules validasi yang digunakan:**

-   `required` → Field wajib diisi
-   `nullable` → Field boleh kosong
-   `string` → Tipe data string/text
-   `numeric` → Harus angka (bisa decimal)
-   `integer` → Harus angka bulat
-   `min:0` → Minimal nilai 0
-   `max:255` → Maksimal 255 karakter
-   `exists:categories,id` → Harus ada di tabel categories kolom id
-   `image` → Harus file gambar
-   `mimes:jpg,jpeg,png,webp` → Format gambar yang diizinkan
-   `max:2048` → Maksimal ukuran file 2MB (2048 KB)
-   `boolean` → Nilai true/false (1/0)

---

#### b. File Upload

```php
if ($request->hasFile('image')) {
    $path = $request->file('image')->store('products', 'public');
    $data['image'] = $path;
}
```

**Penjelasan step by step:**

1. `$request->hasFile('image')` → Mengecek apakah ada file yang diupload dengan nama 'image'
2. `$request->file('image')` → Mengambil file yang diupload
3. `->store('products', 'public')` → Menyimpan file ke folder `storage/app/public/products`
4. `$data['image'] = $path` → Menyimpan path file (contoh: `products/abc123.jpg`) ke array `$data`

**Path lengkap file:**

-   Actual location: `storage/app/public/products/abc123.jpg`
-   Public URL: `http://localhost:8000/storage/products/abc123.jpg`
-   Symlink: `public/storage` → `storage/app/public` (dibuat dengan `php artisan storage:link`)

---

#### c. Create Record (SIMPAN KE DATABASE)

```php
$product = Product::create($data);
```

**INI ADALAH SYNTAX YANG BENAR-BENAR MENYIMPAN DATA KE DATABASE!**

**Proses yang terjadi di balik layar:**

1. **Eloquent ORM** Laravel mengkonversi method `create()` menjadi SQL query
2. Laravel mengeksekusi SQL INSERT seperti ini:

    ```sql
    INSERT INTO products (
        name,
        description,
        price,
        stock,
        category_id,
        brand,
        image,
        status,
        is_featured,
        created_at,
        updated_at
    ) VALUES (
        'Samsung Galaxy S24',
        'Smartphone flagship...',
        12999000,
        50,
        1,
        'Samsung',
        'products/abc123.jpg',
        'active',
        0,
        '2025-12-22 10:30:00',
        '2025-12-22 10:30:00'
    )
    ```

3. **Data dikirim ke MySQL** database yang dikonfigurasi di `config/database.php`
4. **MySQL menyimpan** data ke table `products`
5. **Laravel menerima** response dan membuat object `$product` dengan data yang baru disimpan (termasuk ID yang auto-generated)

**Kenapa bisa otomatis?**

-   Model `Product` extends `Eloquent\Model`
-   Eloquent tahu table name dari nama model (Product → products)
-   Eloquent tahu kolom-kolom dari migrasi database
-   Property `$fillable` di model menentukan kolom mana yang boleh di-mass assign

---

#### d. Redirect dengan Flash Message

```php
return redirect()->route('products.index')->with('success', 'Product created successfully.');
```

**Penjelasan:**

-   `redirect()` → Buat response redirect
-   `->route('products.index')` → Ke route bernama 'products.index' (halaman list products)
-   `->with('success', 'Product created successfully.')` → Bawa flash message dengan key 'success'
-   Flash message hanya tersedia untuk 1 request berikutnya (ditampilkan di `index.blade.php`)

---

## 🌐 Cara Kerja RESTful API

### Konsep REST (Representational State Transfer)

REST adalah arsitektur untuk membuat web service dengan prinsip-prinsip:

#### 1. **Stateless (Tanpa Status)**

-   Setiap request dari client ke server harus mengandung semua informasi yang diperlukan
-   Server tidak menyimpan session/state dari client
-   Setiap request adalah independent (tidak tergantung request sebelumnya)

**Contoh:**

```
❌ STATEFUL (Web biasa dengan session):
Request 1: Login → Server simpan session user
Request 2: Get profile → Server tahu user dari session

✅ STATELESS (API):
Request 1: Login → Server return token
Request 2: Get profile + token → Server validasi token setiap request
```

#### 2. **Resource-based (Berbasis Resource)**

-   Fokus pada **resource** (products, customers, orders, dll) bukan action
-   Resource diakses melalui URL yang konsisten
-   Menggunakan **HTTP methods** untuk menentukan action

**Contoh:**

```
✅ GOOD (Resource-based):
GET    /api/products       → Get all products
POST   /api/products       → Create product
GET    /api/products/1     → Get product #1
PUT    /api/products/1     → Update product #1
DELETE /api/products/1     → Delete product #1

❌ BAD (Action-based):
/api/getAllProducts
/api/createNewProduct
/api/getProductById?id=1
/api/updateProductData?id=1
/api/deleteProductFromDatabase?id=1
```

#### 3. **HTTP Methods untuk CRUD**

-   **GET** → Read data (tidak mengubah data)
-   **POST** → Create data baru
-   **PUT/PATCH** → Update data existing
-   **DELETE** → Hapus data

#### 4. **JSON Response**

-   Format data standar untuk API
-   Mudah dibaca manusia dan machine
-   Supported oleh semua bahasa programming

---

## 🔀 Perbedaan Web Routes vs API Routes

### Web Routes (`routes/web.php`)

```php
Route::get('/products', [ProductWebController::class, 'index']);
Route::post('/products', [ProductWebController::class, 'store']);
Route::get('/products/{product}/edit', [ProductWebController::class, 'edit']);
Route::put('/products/{product}', [ProductWebController::class, 'update']);
Route::delete('/products/{product}', [ProductWebController::class, 'destroy']);
```

**Karakteristik:**

-   ✅ Return: **HTML Views** (Blade templates)
-   ✅ Session: Menggunakan **session & cookies**
-   ✅ CSRF: **Wajib pakai** token `@csrf`
-   ✅ Auth: **Session-based** authentication
-   ✅ Middleware: `web` (includes session, CSRF protection, cookie encryption)
-   ✅ Untuk: **Browser / Human users**

**Controller Return:**

```php
public function index()
{
    $products = Product::all();
    return view('products.index', compact('products')); // Return HTML
}
```

---

### API Routes (`routes/api.php`)

```php
Route::apiResource('products', ProductController::class)->names([
    'index'   => 'api.products.index',    // GET /api/products
    'store'   => 'api.products.store',    // POST /api/products
    'show'    => 'api.products.show',     // GET /api/products/{id}
    'update'  => 'api.products.update',   // PUT/PATCH /api/products/{id}
    'destroy' => 'api.products.destroy'   // DELETE /api/products/{id}
]);
```

**Karakteristik:**

-   ✅ Return: **JSON data**
-   ✅ Stateless: **Tidak pakai session**
-   ✅ CSRF: **Tidak pakai** token (diganti dengan token authentication)
-   ✅ Auth: **Token-based** (Bearer token, Sanctum, Passport)
-   ✅ Middleware: `api` (includes rate limiting, JSON response)
-   ✅ Prefix: Otomatis dapat prefix `/api` (jadi `/api/products`)
-   ✅ Untuk: **Mobile apps, Frontend frameworks (React/Vue/Angular), Third-party services**

**Controller Return:**

```php
public function index()
{
    $products = Product::all();
    return response()->json([
        'success' => true,
        'data' => $products
    ]); // Return JSON
}
```

---

## 📊 HTTP Methods dalam REST

| HTTP Method   | Action/Method | URL               | Controller Method               | Fungsi                           |
| ------------- | ------------- | ----------------- | ------------------------------- | -------------------------------- |
| **GET**       | index         | `/api/products`   | `index()`                       | Ambil semua data products        |
| **GET**       | show          | `/api/products/1` | `show($id)`                     | Ambil 1 data product dengan ID=1 |
| **POST**      | store         | `/api/products`   | `store(Request $request)`       | Buat product baru                |
| **PUT/PATCH** | update        | `/api/products/1` | `update(Request $request, $id)` | Update product ID=1              |
| **DELETE**    | destroy       | `/api/products/1` | `destroy($id)`                  | Hapus product ID=1               |

### Penjelasan Detail:

#### GET (Read)

-   **Tidak mengubah data** di server
-   **Idempotent**: Dipanggil berapa kalipun hasilnya sama
-   **Cacheable**: Bisa di-cache oleh browser
-   **Safe**: Aman dipanggil berkali-kali

#### POST (Create)

-   **Membuat data baru**
-   **Not idempotent**: Setiap call membuat data baru
-   Mengirim data dalam **request body**

#### PUT/PATCH (Update)

-   **PUT**: Replace seluruh resource
-   **PATCH**: Update sebagian field saja
-   **Idempotent**: Hasil sama jika dipanggil berkali-kali
-   Mengirim data dalam **request body**

#### DELETE (Delete)

-   **Menghapus data**
-   **Idempotent**: Hapus berkali-kali, hasilnya tetap data terhapus
-   Biasanya tidak perlu request body

---

## 💻 Contoh Request & Response API

### 1. CREATE Product (POST)

**HTTP Request:**

```http
POST /api/products HTTP/1.1
Host: localhost:8000
Content-Type: application/json
Authorization: Bearer eyJ0eXAiOiJKV1QiLCJhbGc...
Accept: application/json

{
    "name": "iPhone 15 Pro",
    "description": "Latest flagship iPhone with A17 Pro chip",
    "price": 15999000,
    "stock": 20,
    "brand": "Apple",
    "category_id": 2,
    "status": "active",
    "is_featured": true
}
```

**HTTP Response (201 Created):**

```json
{
    "success": true,
    "message": "Product created successfully",
    "data": {
        "id": 15,
        "name": "iPhone 15 Pro",
        "description": "Latest flagship iPhone with A17 Pro chip",
        "price": 15999000,
        "stock": 20,
        "brand": "Apple",
        "category_id": 2,
        "status": "active",
        "is_featured": true,
        "image": null,
        "created_at": "2025-12-22T10:30:00.000000Z",
        "updated_at": "2025-12-22T10:30:00.000000Z"
    }
}
```

---

### 2. GET All Products

**HTTP Request:**

```http
GET /api/products HTTP/1.1
Host: localhost:8000
Accept: application/json
Authorization: Bearer eyJ0eXAiOiJKV1QiLCJhbGc...
```

**HTTP Response (200 OK):**

```json
{
    "success": true,
    "data": [
        {
            "id": 1,
            "name": "Samsung Galaxy S24",
            "description": "Flagship Android phone",
            "price": 12999000,
            "stock": 50,
            "brand": "Samsung",
            "category_id": 1,
            "status": "active",
            "is_featured": false,
            "image": "products/galaxy-s24.jpg",
            "created_at": "2025-12-20T08:00:00.000000Z",
            "updated_at": "2025-12-20T08:00:00.000000Z"
        },
        {
            "id": 15,
            "name": "iPhone 15 Pro",
            "description": "Latest flagship iPhone with A17 Pro chip",
            "price": 15999000,
            "stock": 20,
            "brand": "Apple",
            "category_id": 2,
            "status": "active",
            "is_featured": true,
            "image": null,
            "created_at": "2025-12-22T10:30:00.000000Z",
            "updated_at": "2025-12-22T10:30:00.000000Z"
        }
    ],
    "meta": {
        "total": 2,
        "count": 2
    }
}
```

---

### 3. GET Single Product

**HTTP Request:**

```http
GET /api/products/15 HTTP/1.1
Host: localhost:8000
Accept: application/json
Authorization: Bearer eyJ0eXAiOiJKV1QiLCJhbGc...
```

**HTTP Response (200 OK):**

```json
{
    "success": true,
    "data": {
        "id": 15,
        "name": "iPhone 15 Pro",
        "description": "Latest flagship iPhone with A17 Pro chip",
        "price": 15999000,
        "stock": 20,
        "brand": "Apple",
        "category_id": 2,
        "status": "active",
        "is_featured": true,
        "image": null,
        "created_at": "2025-12-22T10:30:00.000000Z",
        "updated_at": "2025-12-22T10:30:00.000000Z"
    }
}
```

---

### 4. UPDATE Product (PUT/PATCH)

**HTTP Request:**

```http
PUT /api/products/15 HTTP/1.1
Host: localhost:8000
Content-Type: application/json
Authorization: Bearer eyJ0eXAiOiJKV1QiLCJhbGc...
Accept: application/json

{
    "price": 14999000,
    "stock": 15
}
```

**HTTP Response (200 OK):**

```json
{
    "success": true,
    "message": "Product updated successfully",
    "data": {
        "id": 15,
        "name": "iPhone 15 Pro",
        "description": "Latest flagship iPhone with A17 Pro chip",
        "price": 14999000,
        "stock": 15,
        "brand": "Apple",
        "category_id": 2,
        "status": "active",
        "is_featured": true,
        "image": null,
        "created_at": "2025-12-22T10:30:00.000000Z",
        "updated_at": "2025-12-22T10:45:00.000000Z"
    }
}
```

---

### 5. DELETE Product

**HTTP Request:**

```http
DELETE /api/products/15 HTTP/1.1
Host: localhost:8000
Accept: application/json
Authorization: Bearer eyJ0eXAiOiJKV1QiLCJhbGc...
```

**HTTP Response (200 OK):**

```json
{
    "success": true,
    "message": "Product deleted successfully"
}
```

---

### 6. Error Response (Validation Failed)

**HTTP Request:**

```http
POST /api/products HTTP/1.1
Host: localhost:8000
Content-Type: application/json
Authorization: Bearer eyJ0eXAiOiJKV1QiLCJhbGc...

{
    "name": "",
    "price": -1000
}
```

**HTTP Response (422 Unprocessable Entity):**

```json
{
    "success": false,
    "message": "Validation failed",
    "errors": {
        "name": ["The name field is required."],
        "price": ["The price must be at least 0."],
        "stock": ["The stock field is required."]
    }
}
```

---

### 7. Error Response (Unauthorized)

**HTTP Request (tanpa token):**

```http
GET /api/products HTTP/1.1
Host: localhost:8000
Accept: application/json
```

**HTTP Response (401 Unauthorized):**

```json
{
    "success": false,
    "message": "Unauthenticated"
}
```

---

## 🎯 Kenapa Pakai RESTful API?

### 1. **Separation of Concerns**

-   Backend (API) dan Frontend terpisah
-   Backend fokus ke business logic & database
-   Frontend fokus ke UI/UX
-   Bisa dikembangkan secara parallel oleh team berbeda

### 2. **Multi-platform**

-   Satu API bisa digunakan oleh:
    -   Website (React, Vue, Angular)
    -   Mobile apps (iOS/Swift, Android/Kotlin, React Native, Flutter)
    -   Desktop apps (Electron)
    -   IoT devices
    -   Third-party integrations

### 3. **Scalability**

-   API server bisa di-scale independent dari frontend
-   Load balancing lebih mudah
-   Caching lebih efektif
-   Microservices architecture

### 4. **Reusability**

-   Satu endpoint bisa dipakai banyak client
-   Tidak perlu duplicate logic
-   Update backend tidak affect frontend (selama API contract tidak berubah)

### 5. **Modern Architecture**

-   Standar industri saat ini
-   Mudah di-test (unit test, integration test)
-   Documentation tools (Swagger, Postman)
-   Version control yang jelas (v1, v2, dll)

---

## 🔄 Flow Data Lengkap (Web vs API)

### Web Flow (Browser):

```
User di Browser
    ↓
Klik Form Submit (POST /products)
    ↓
Request dikirim dengan CSRF token
    ↓
Laravel Router (routes/web.php)
    ↓
Middleware: web, CSRF verification, session
    ↓
ProductWebController::store()
    ↓
Validation
    ↓
File Upload (jika ada)
    ↓
Product::create($data) → Database
    ↓
Redirect dengan flash message
    ↓
Browser menerima redirect
    ↓
Request GET /products
    ↓
ProductWebController::index()
    ↓
Return view dengan data products
    ↓
Browser render HTML
    ↓
User melihat hasil
```

### API Flow (Mobile/React):

```
Mobile App / React App
    ↓
HTTP POST /api/products dengan Bearer token
    ↓
Laravel Router (routes/api.php)
    ↓
Middleware: api, auth:sanctum, rate limiting
    ↓
ProductController::store()
    ↓
Validation
    ↓
Product::create($data) → Database
    ↓
Return JSON response
    ↓
App menerima JSON
    ↓
App parse JSON
    ↓
App update UI
    ↓
User melihat hasil
```

---

## 📚 Kesimpulan

### Data Tersimpan ke Database karena:

1. **Route** mendefinisikan endpoint dan controller
2. **Form** mengirim data via HTTP POST
3. **Controller** menerima request
4. **Validation** memastikan data valid
5. **File Upload** menyimpan file (jika ada)
6. **Eloquent Model** (`Product::create()`) menjalankan SQL INSERT
7. **Database** menyimpan data secara permanen

### RESTful API adalah:

-   Arsitektur untuk web service
-   Menggunakan HTTP methods (GET, POST, PUT, DELETE)
-   Fokus pada resource, bukan action
-   Stateless (tidak pakai session)
-   Return JSON (bukan HTML)
-   Bisa digunakan multi-platform
-   Standar modern untuk aplikasi saat ini

### Proyek Laravel Anda:

✅ Sudah implement **Web Routes** untuk admin panel (browser)  
✅ Sudah implement **API Routes** untuk integrasi dengan aplikasi lain  
✅ Sudah siap untuk dikembangkan dengan mobile app atau frontend framework modern!

---

**Dibuat tanggal:** 22 Desember 2025  
**Waktu:** 14:30:00 WIB  
**Project:** Laravel E-Commerce  
**Version:** 1.0
