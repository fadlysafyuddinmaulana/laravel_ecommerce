# Rekap Proyek Laravel Ecommerce

_Diperbarui: 24 Desember 2025_

---

## Daftar Isi

- [Rekap Proyek Laravel Ecommerce](#rekap-proyek-laravel-ecommerce)
  - [Daftar Isi](#daftar-isi)
  - [Struktur Folder \& Penjelasan](#struktur-folder--penjelasan)
  - [Alur Kerja Model, Controller, dan View](#alur-kerja-model-controller-dan-view)
  - [Koneksi Antar File: Migrations, Model, Controller](#koneksi-antar-file-migrations-model-controller)
  - [Penjelasan Blade \& Alur View](#penjelasan-blade--alur-view)
  - [Riwayat Perubahan (Changes)](#riwayat-perubahan-changes)
  - [Commit History (Singkat)](#commit-history-singkat)

---

## Struktur Folder & Penjelasan

- **app/**
  - **Http/Controllers/**: Berisi controller yang menangani logika aplikasi dan request dari user.
  - **Models/**: Berisi model Eloquent yang merepresentasikan tabel database (misal: Product, Category, Employee, dsb).
  - **Providers/**: Berisi service provider untuk konfigurasi aplikasi.

- **bootstrap/**: File bootstrap Laravel, inisialisasi aplikasi.

- **config/**: File konfigurasi aplikasi (database, mail, cache, dsb).

- **database/**
  - **migrations/**: Script migrasi untuk membuat/ubah struktur tabel database.
  - **seeders/**: Script untuk mengisi data awal (dummy/demo) ke database.
  - **factories/**: Template pembuatan data dummy untuk testing.

- **docs/**: Dokumentasi proyek, rekap perubahan, dan penjelasan teknis.

- **public/**: Root web server, berisi index.php dan asset statis (gambar, CSS, JS, dsb).

- **resources/**
  - **views/**: File Blade (template view) untuk frontend.
  - **css/**, **js/**: Asset frontend.

- **routes/**: Definisi rute aplikasi (web.php, api.php, dsb).

- **storage/**: Penyimpanan file sementara, log, cache, dsb.

- **tests/**: Unit test dan feature test.

- **vendor/**: Dependency Composer (otomatis, jangan diubah manual).

---

## Alur Kerja Model, Controller, dan View

1. **Model**
   - Mewakili tabel di database (misal: `Product`, `Category`, `Employee`).
   - Berisi relasi antar tabel (hasMany, belongsTo, dsb).
   - Digunakan untuk query data dan manipulasi database.

2. **Controller**
   - Menerima request dari user (via route).
   - Memproses logika bisnis, validasi, dan manipulasi data via Model.
   - Mengembalikan response ke View (Blade) atau JSON (API).

3. **View (Blade)**
   - Menampilkan data ke user.
   - Menggunakan sintaks Blade (`@extends`, `@section`, `@foreach`, dsb) untuk templating dan logika sederhana.
   - Mendapatkan data dari Controller melalui compact/with.

**Alur:**

- User mengakses URL → Route → Controller → Model (query data) → Controller → View (Blade) → User.

---

## Koneksi Antar File: Migrations, Model, Controller

- **Migrations**: Mendefinisikan struktur tabel (field, tipe data, relasi foreign key). Contoh: `create_products_table` membuat tabel `products` dengan kolom `name`, `category_id`, dsb.
- **Model**: Mewakili tabel, mendefinisikan relasi (misal: `Product` belongsTo `Category`).
- **Controller**: Menggunakan Model untuk mengambil/ubah data, lalu mengirim data ke View.
- **View**: Mengakses data yang dikirim Controller, menampilkan dengan Blade.

**Mengapa sistem berjalan:**

- Laravel menghubungkan route ke controller, controller ke model, model ke database.
- Dependency injection dan binding otomatis memudahkan pengelolaan data dan logika.
- Blade memudahkan pembuatan tampilan dinamis dengan sintaks yang aman dan efisien.

---

## Penjelasan Blade & Alur View

- **@extends('layouts.app')**: Menggunakan layout utama (header, sidebar, footer).
- **@section('content')**: Mendefinisikan konten utama halaman.
- **@foreach($items as $item)**: Melakukan loop data.
- **@if($condition)**: Logika percabangan di view.
- **@csrf**: Token keamanan form agar aman dari CSRF.
- **@method('PUT'/'DELETE')**: Spoofing method HTTP pada form.
- **@include('partial')**: Memasukkan partial view.
- **@push('scripts')/@push('styles')**: Menambahkan script/style khusus halaman.

**Contoh Alur:**

- Controller mengirim data (misal: `$departments`) ke view.
- View menampilkan data dengan loop `@foreach($departments as $department)`.
- Form create/edit menggunakan `@csrf` dan `@method('PUT')` untuk keamanan dan method spoofing.
- Script JS (misal: DataTables, SweetAlert) di-push ke layout utama via `@push('scripts')`.

---

## Riwayat Perubahan (Changes)

- Tidak ada perubahan yang belum di-commit (working directory bersih).

## Commit History (Singkat)

```
cbd07e3 (origin/frontend-adminlte) fix: update formatting and consistency in project documentation
e4cb535 penambahan fontawesome versi baru dan penambahan fitur baru pada employee
9956b2d feat: enhance employee management & comprehensive project documentation
061d3a2 (origin/main, main) penambahan fontawesome versi baru dan penambahan fitur baru pada employee
189c3df feat: Implementasi Manajemen Produk & Kategori dengan AdminLTE 3.2.0
3189802 feat: Perombakan layout dengan integrasi AdminLTE, mencakup header, footer, sidebar, dan komponen dashboard
94ba3b2 feat: Implement AdminLTE v4.0.0-rc4 with TypeScript support and enhanced core components
76eb93c feat: Implementasi manajemen produk dengan operasi CRUD lengkap mencakup ProductWebController, form create dan edit dengan upload gambar, validasi field, storage symlink, auto-delete gambar lama, preview gambar pada edit, serta perbaikan bug pada method update
a6451c2 Menambahkan Model Employee, migrasi database, dan Controller dengan operasi CRUD (Create, Read, Update) untuk mengelola data karyawan.
e6295af Tambah model Customer, migration dengan enum gender, controller CRUD dengan validasi lengkap, import Response class, dan hash password
beeea3e perbaiki alur pembuatan produk: tambah tabel & model kategori, benahi validasi category_id, dan pastikan response 201 Created
24b12a1 Implement product management API with CRUD operations and integrate Sanctum for authentication
```

---

**Catatan:**

- Untuk detail perubahan tiap commit, cek repository GitHub atau gunakan perintah `git log` di lokal.
- Semua perubahan sudah terdokumentasi di commit history dan rekap docs.
