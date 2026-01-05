# Panduan Implementasi Fitur Baru - Laravel E-Commerce

## Ringkasan Perubahan

Dokumen ini menjelaskan implementasi fitur-fitur baru yang telah ditambahkan ke dalam project Laravel E-Commerce.

---

## 1. Sistem Filter Produk (New Products & Discount Products)

### Database Changes

- **Tabel**: `products`
- **Kolom Baru**: `has_discount` (boolean, default: false)

### Model Scopes (Product.php)

Telah ditambahkan 3 scope untuk filtering produk:

```php
// Produk baru (created dalam 30 hari terakhir)
Product::newProducts()->get();

// Produk dengan diskon
Product::withDiscount()->get();

// Produk featured
Product::featured()->get();
```

### Penggunaan di Controller (HomeWebController)

```php
public function index()
{
    // Featured products (max 3)
    $featuredProducts = Product::featured()->limit(3)->get();

    // New products (max 3)
    $newProducts = Product::newProducts()->limit(3)->get();

    // Discount products (max 3)
    $discountProducts = Product::withDiscount()->limit(3)->get();

    // Testimonials (max 3)
    $testimonials = Testimonial::active()->limit(3)->get();

    return view('user_page.pages.index', compact(
        'featuredProducts',
        'newProducts',
        'discountProducts',
        'testimonials'
    ));
}
```

### Pengaturan Produk di Admin Panel

Di halaman **Create Product** dan **Edit Product**, terdapat checkbox baru:

- ✅ **Featured Product**: Produk unggulan yang ditampilkan di homepage
- ✅ **Product Has Discount**: Tandai produk sebagai memiliki diskon

### Penjelasan Lines 32-84 (index.blade.php)

Bagian ini adalah **Product Section** di homepage yang menampilkan produk featured. Sebelumnya hardcoded, sekarang menggunakan data dinamis dari database:

- **Column 1**: Text deskripsi dan tombol "Explore"
- **Columns 2-4**: 3 produk featured dari database (dengan fallback jika tidak ada data)

---

## 2. Sistem Testimonial (Dinamis dari Database)

### Database Schema

**Tabel**: `testimonials`

| Kolom         | Tipe         | Keterangan                 |
| ------------- | ------------ | -------------------------- |
| id            | bigint       | Primary key                |
| name          | varchar(255) | Nama pemberi testimoni     |
| position      | varchar(255) | Jabatan                    |
| company       | varchar(255) | Nama perusahaan (nullable) |
| content       | text         | Isi testimoni              |
| image         | varchar(255) | Path foto (nullable)       |
| is_active     | boolean      | Status aktif/nonaktif      |
| display_order | integer      | Urutan tampilan            |
| created_at    | timestamp    | Waktu pembuatan            |
| updated_at    | timestamp    | Waktu update               |

### Model Scope (Testimonial.php)

```php
// Mengambil testimonial aktif, diurutkan berdasarkan display_order
Testimonial::active()->get();
```

### Cara Mengganti Testimonial yang Ditampilkan

#### Opsi 1: Ubah Status is_active

```sql
-- Nonaktifkan testimonial ID 1
UPDATE testimonials SET is_active = 0 WHERE id = 1;

-- Aktifkan testimonial ID 8
UPDATE testimonials SET is_active = 1 WHERE id = 8;
```

#### Opsi 2: Ubah Display Order

```sql
-- Set display_order lebih kecil untuk prioritas lebih tinggi
UPDATE testimonials SET display_order = 1 WHERE id = 8;
UPDATE testimonials SET display_order = 10 WHERE id = 1;
```

#### Opsi 3: Via Laravel Tinker

```bash
php artisan tinker
```

```php
// Nonaktifkan testimonial tertentu
Testimonial::find(1)->update(['is_active' => false]);

// Aktifkan testimonial baru
Testimonial::find(8)->update(['is_active' => true, 'display_order' => 1]);
```

### Pembatasan Tampilan (Max 3 Testimonials)

Di `HomeWebController@index`, testimoni sudah dibatasi:

```php
$testimonials = Testimonial::active()->limit(3)->get();
```

Hanya 3 testimonial aktif pertama (berdasarkan `display_order`) yang akan ditampilkan di homepage.

### Seeder Data

Jalankan seeder untuk membuat data testimoni sample:

```bash
php artisan db:seed --class=TestimonialSeeder
```

---

## 3. CMS untuk Halaman About & Services

### Rekomendasi Implementasi: **Database-Driven CMS**

Telah dibuat tabel `page_contents` untuk mengelola konten halaman secara dinamis.

### Database Schema

**Tabel**: `page_contents`

| Kolom         | Tipe         | Keterangan                               |
| ------------- | ------------ | ---------------------------------------- |
| id            | bigint       | Primary key                              |
| page_name     | varchar(255) | Nama halaman (about, services, dll)      |
| section_key   | varchar(255) | Key section (hero_title, feature_1, dll) |
| content       | text         | Konten/teks                              |
| content_type  | varchar(255) | Tipe konten (text, html, image, url)     |
| display_order | integer      | Urutan tampilan                          |
| is_active     | boolean      | Status aktif                             |
| created_at    | timestamp    | -                                        |
| updated_at    | timestamp    | -                                        |

### Cara Penggunaan di View (Blade)

#### Metode 1: Menggunakan Helper Method

```blade
<!-- Di about.blade.php -->
<h1>{{ \App\Models\PageContent::getContent('about', 'hero_title', 'Default Title') }}</h1>

<p>{{ \App\Models\PageContent::getContent('about', 'hero_description') }}</p>
```

#### Metode 2: Passing dari Controller

```php
// Di HomeWebController@about
public function about()
{
    $pageContents = PageContent::active()
        ->forPage('about')
        ->orderBy('display_order')
        ->get()
        ->keyBy('section_key');

    return view('user_page.pages.about', compact('pageContents'));
}
```

```blade
<!-- Di view -->
<h1>{{ $pageContents['hero_title']->content ?? 'Default' }}</h1>
```

### Contoh Data untuk About Page

```php
PageContent::create([
    'page_name' => 'about',
    'section_key' => 'hero_title',
    'content' => 'Siapa dan kenapa perusahaan ada.',
    'content_type' => 'text',
    'display_order' => 1,
    'is_active' => true,
]);

PageContent::create([
    'page_name' => 'about',
    'section_key' => 'hero_description',
    'content' => 'Donec vitae odio quis nisl dapibus malesuada...',
    'content_type' => 'html',
    'display_order' => 2,
    'is_active' => true,
]);
```

### Keuntungan Pendekatan Database:

✅ Konten dapat diubah tanpa edit kode  
✅ Mudah dibuat admin panel CRUD untuk manage konten  
✅ Support multi-language (tinggal tambah kolom `locale`)  
✅ Version control friendly (tidak perlu commit setiap ubah teks)

---

## 4. Perbaikan UI Checkout Page

Checkout page sudah memiliki layout yang rapi dengan:

- ✅ Responsive grid (Bootstrap)
- ✅ Proper spacing dan alignment
- ✅ Delivery options dengan radio buttons
- ✅ Payment method selection dengan visual feedback
- ✅ Order summary sticky sidebar
- ✅ Form validation
- ✅ Card input formatting (auto-format card number & expiry)

Layout sudah sesuai dengan best practices modern e-commerce checkout.

---

## 5. Routes Baru

Telah ditambahkan routes untuk halaman-halaman header:

```php
// routes/web.php
Route::get('/services', [HomeWebController::class, 'services'])->name('services');
Route::get('/blog', [HomeWebController::class, 'blog'])->name('blog');
Route::get('/contact', [HomeWebController::class, 'contact'])->name('contact');
```

**Catatan**: Route `/about` sudah ada sebelumnya.

---

## 6. Pagination Blog (9 per halaman)

Di `HomeWebController@blog`:

```php
public function blog()
{
    // Paginate dengan 9 item per halaman
    $blogs = Product::orderBy('created_at', 'desc')->paginate(9);

    return view('user_page.pages.blog', compact('blogs'));
}
```

**TODO**: Buat model `Blog` atau `Post` yang terpisah dari Product. Saat ini masih menggunakan Product sebagai placeholder.

### Implementasi Pagination di View

```blade
<!-- Di blog.blade.php -->
@foreach($blogs as $blog)
    <!-- Display blog item -->
@endforeach

<!-- Pagination links -->
<div class="mt-4">
    {{ $blogs->links() }}
</div>
```

---

## 7. Controllers untuk Admin Panel (Future Development)

Telah dibuat controller kosong untuk management di admin:

- `TestimonialWebController.php` - Manage testimonials
- `PageContentWebController.php` - Manage page contents (CMS)

**TODO**: Implementasi CRUD untuk kedua controller ini dengan views AdminLTE.

---

## 8. Admin Sidebar Navigation Update

### Perubahan Menu Content Management

Sidebar admin telah diupdate untuk menampilkan menu-menu baru yang sesuai dengan fitur CMS:

**Menu Baru di Content Management:**

- ✅ **Page Contents (CMS)** - Untuk mengelola konten dinamis halaman About, Services, dll
- ✅ **Testimonials** - Untuk mengelola testimonial customer

### Akses Menu

```blade
<!-- Di sidebar.blade.php -->
Content Management
├── Page Contents (CMS)     → route: page-contents.index
├── Testimonials            → route: testimonials.index
├── Banners                 → route: banners.index
├── Blogs                   → route: blogs.index
└── FAQs                    → route: faqs.index
```

### Route Names yang Digunakan

Sidebar menggunakan route naming convention:

- `page-contents.*` - Untuk semua route page contents (index, create, edit, dll)
- `testimonials.*` - Untuk semua route testimonials

### Active State Detection

Menu akan aktif (highlighted) ketika:

```php
request()->routeIs('page-contents.*')  // Any page contents route
request()->routeIs('testimonials.*')    // Any testimonials route
```

### Icon yang Digunakan

| Menu                | Icon | Class FontAwesome        |
| ------------------- | ---- | ------------------------ |
| Page Contents (CMS) | 📄   | `fas fa-file-alt`        |
| Testimonials        | 💬   | `fas fa-quote-left`      |
| Banners             | 🖼️   | `fas fa-image`           |
| Blogs               | 📝   | `fas fa-blog`            |
| FAQs                | ❓   | `fas fa-question-circle` |

### TODO: Implementasi Routes

✅ **Routes sudah ditambahkan di `routes/web.php`:**

```php
// Page Contents Routes (CMS)
Route::get('/page-contents', [PageContentWebController::class, 'index'])->name('page-contents.index');
Route::get('/page-contents/create', [PageContentWebController::class, 'create'])->name('page-contents.create');
Route::post('/page-contents', [PageContentWebController::class, 'store'])->name('page-contents.store');
Route::get('/page-contents/{pageContent}/edit', [PageContentWebController::class, 'edit'])->name('page-contents.edit');
Route::put('/page-contents/{pageContent}', [PageContentWebController::class, 'update'])->name('page-contents.update');
Route::delete('/page-contents/{pageContent}', [PageContentWebController::class, 'destroy'])->name('page-contents.destroy');

// Testimonials Routes
Route::get('/testimonials', [TestimonialWebController::class, 'index'])->name('testimonials.index');
Route::get('/testimonials/create', [TestimonialWebController::class, 'create'])->name('testimonials.create');
Route::post('/testimonials', [TestimonialWebController::class, 'store'])->name('testimonials.store');
Route::get('/testimonials/{testimonial}/edit', [TestimonialWebController::class, 'edit'])->name('testimonials.edit');
Route::put('/testimonials/{testimonial}', [TestimonialWebController::class, 'update'])->name('testimonials.update');
Route::delete('/testimonials/{testimonial}', [TestimonialWebController::class, 'destroy'])->name('testimonials.destroy');
```

---

## Migrasi Database

Untuk menggunakan fitur-fitur baru, jalankan migrasi:

```bash
php artisan migrate
```

Migrasi yang dijalankan:

1. `add_has_discount_to_products_table` - Kolom has_discount
2. `create_testimonials_table` - Tabel testimonials
3. `create_page_contents_table` - Tabel page_contents untuk CMS

---

## Seeder Data Sample

```bash
# Seed testimonials
php artisan db:seed --class=TestimonialSeeder
```

---

## Struktur File yang Diubah/Ditambahkan

### Models

- ✅ `app/Models/Product.php` - Ditambah scope & has_discount
- ✅ `app/Models/Testimonial.php` - Model baru
- ✅ `app/Models/PageContent.php` - Model baru untuk CMS

### Controllers

- ✅ `app/Http/Controllers/HomeWebController.php` - Update logic
- ✅ `app/Http/Controllers/ProductWebController.php` - Validasi has_discount
- ✅ `app/Http/Controllers/TestimonialWebController.php` - Controller baru (kosong)
- ✅ `app/Http/Controllers/PageContentWebController.php` - Controller baru (kosong)

### Views

- ✅ `resources/views/user_page/pages/index.blade.php` - Dynamic products & testimonials
- ✅ `resources/views/products/create.blade.php` - Checkbox has_discount
- ✅ `resources/views/products/edit.blade.php` - Checkbox has_discount
- ✅ `resources/views/layouts/partials/sidebar.blade.php` - Added menu untuk Testimonials & Page Contents

### Routes

- ✅ `routes/web.php` - Tambah routes services, blog, contact

### Migrations

- ✅ `database/migrations/*_add_has_discount_to_products_table.php`
- ✅ `database/migrations/*_create_testimonials_table.php`
- ✅ `database/migrations/*_create_page_contents_table.php`

### Seeders

- ✅ `database/seeders/TestimonialSeeder.php`

---

## Langkah-Langkah Testing

### 1. Test Produk dengan Diskon

```bash
php artisan tinker
```

```php
// Update beberapa produk untuk has_discount = true
Product::find(1)->update(['has_discount' => true]);
Product::find(2)->update(['has_discount' => true, 'is_featured' => true]);

// Cek scope
Product::withDiscount()->get();
Product::newProducts()->get();
```

### 2. Test Testimonials

- Akses homepage: `http://localhost:8000/`
- Lihat bagian Testimonials (seharusnya max 3 item)
- Ubah `is_active` atau `display_order` di database, refresh halaman

### 3. Test Routes Baru

- `/services` - Seharusnya load page services
- `/blog` - Seharusnya ada pagination (9 items per page)
- `/contact` - Load contact page

### 4. Test Product Form

- Buka `/products/create`
- Cek ada checkbox "Product Has Discount"
- Create product dengan discount enabled
- Edit product, cek value checkbox tersimpan

---

## Next Steps / Rekomendasi

### Prioritas Tinggi

1. **Buat CRUD Admin untuk Testimonials**
   - View index, create, edit untuk manage testimonials
   - Upload image untuk testimonial photos
2. **Buat CRUD Admin untuk Page Contents (CMS)**
   - Interface untuk manage konten About & Services
   - WYSIWYG editor untuk content_type = 'html'

3. **Implementasi About & Services Content**
   - Seed data untuk page_contents
   - Update view About & Services menggunakan data dari database
   - Sesuaikan dengan design dari pasted image

### Prioritas Medium

4. **Buat Model Blog/Post yang terpisah**
   - Migration untuk tabel `blogs` atau `posts`
   - Model Blog dengan relasi Author
   - Update BlogController untuk pagination

5. **Filter Produk di Shop Page**
   - Tambah filter "New Products"
   - Tambah filter "Discount Products"
   - UI checkbox di sidebar shop

### Prioritas Rendah

6. **Upload Image untuk Testimonials**
   - Form upload di CRUD testimonial
   - Validasi & resize image
7. **Multi-language Support**
   - Tambah kolom `locale` di page_contents
   - Implementasi language switcher

---

## Catatan Penting

⚠️ **Database Inconsistency**: Tabel `categories` memiliki kolom `category_name` di migration, tapi models menggunakan `name`. Gunakan `name` untuk konsistensi kode.

⚠️ **Blog masih menggunakan Product**: Saat ini blog pagination masih mengambil dari tabel products. Sebaiknya buat model Blog terpisah.

⚠️ **Admin Panel untuk CMS**: Fitur CMS sudah ready di backend, tapi belum ada interface admin untuk manage konten. Perlu dibuat CRUD views.

---

## Kontak & Support

Untuk pertanyaan atau issue terkait implementasi fitur ini, silakan buka issue di repository atau hubungi tim development.

**Last Updated**: 5 Januari 2026
