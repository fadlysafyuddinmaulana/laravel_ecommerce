# Rekap Proyek Laravel E-commerce

## 1. Struktur Folder Proyek

- **app/**: Berisi kode utama aplikasi, termasuk Model, Controller, dan Provider.
  - **Models/**: Definisi entitas basis data (Category, Customer, Department, Employee, Positions, Product, User).
  - **Http/Controllers/**: Logika pengendali (Controller) untuk menangani request dan response.
- **bootstrap/**: Inisialisasi aplikasi dan cache.
- **config/**: File konfigurasi aplikasi (database, mail, queue, dsb).
- **database/**: Migrasi, seeder, dan factory untuk pengelolaan data.
- **public/**: Root web server, berisi index.php dan aset publik.
- **resources/**: Sumber daya aplikasi seperti view Blade, CSS, dan JS.
- **routes/**: Definisi rute aplikasi (web, api, console).
- **storage/**: Penyimpanan file sementara, log, dan cache.
- **tests/**: Pengujian aplikasi.
- **vendor/**: Dependensi Composer.

## 2. Fungsi Model-Controller-View

- **Model**: Mewakili tabel di database, berisi relasi dan logika bisnis (contoh: `Product.php`, `User.php`).
- **Controller**: Menangani permintaan HTTP, mengelola data dari Model, dan mengirimkan ke View (contoh: `ProductController`).
- **View**: Menggunakan Blade untuk menampilkan data ke pengguna. File view berada di `resources/views/`.

## 3. Alur Interaksi Antar File

1. **Request** masuk melalui route di `routes/web.php` atau `routes/api.php`.
2. Route memanggil **Controller** terkait.
3. Controller memproses data, berinteraksi dengan **Model** untuk query database.
4. Data dikirim ke **View** (Blade) untuk ditampilkan ke user.

## 4. Koneksi Antar Komponen

- **Migrations**: Mendefinisikan struktur tabel database. Contoh: `create_products_table.php` membuat tabel `products`.
- **Model**: Mewakili tabel, mendefinisikan relasi (hasMany, belongsTo, dsb).
- **Controller**: Mengelola logika aplikasi, memanggil Model, dan mengarahkan ke View.
- **Seeder**: Mengisi data awal ke database.

## 5. Sintaks Blade & Alur Tampilan View

- Blade adalah template engine Laravel, file berekstensi `.blade.php`.
- Sintaks dasar:
  - `@extends('layout')`: Menggunakan layout utama.
  - `@section('content') ... @endsection`: Mendefinisikan section konten.
  - `@foreach ($products as $product) ... @endforeach`: Looping data.
  - `{{ $variable }}`: Menampilkan data.
- Alur tampilan:
  1. Controller mengirim data ke view.
  2. View menampilkan data menggunakan sintaks Blade.
  3. Layout dan komponen dapat digunakan untuk modularisasi tampilan.

## 6. Pemeriksaan Riwayat Perubahan & Ringkasan Commit

- Riwayat perubahan dapat dilihat melalui perintah `git log`.
- Commit penting:
  - Inisialisasi proyek dan struktur folder.
  - Penambahan model, controller, dan migrasi utama.
  - Integrasi Blade dan pembuatan view.
  - Penambahan seeder dan data demo.
  - Dokumentasi dan rekap perubahan.

## 7. Tujuan Dokumentasi

Dokumentasi ini bertujuan untuk:

- Memudahkan pengecekan riwayat perubahan proyek.
- Memberikan pemahaman arsitektur dan alur kerja aplikasi Laravel E-commerce.
- Menjadi referensi bagi pengembang baru dalam memahami struktur dan interaksi antar komponen.
