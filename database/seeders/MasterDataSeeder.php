<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MasterDataSeeder extends Seeder
{
    public function run(): void
    {
        /*
        |--------------------------------------------------------------------------
        | BRANDS
        |--------------------------------------------------------------------------
        */
        DB::table('brands')->insert([
            ['name' => 'Samsung', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Apple',   'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Xiaomi',  'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Asus',    'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Lenovo',  'created_at' => now(), 'updated_at' => now()],
        ]);

        /*
        |--------------------------------------------------------------------------
        | DEPARTMENTS
        |--------------------------------------------------------------------------
        */
        DB::table('departments')->insert([
            [
                'department_name' => 'Human Resource',
                'department_code' => 'HR',
                'description'     => 'Mengelola sumber daya manusia.',
                'manager_id'      => null,
                'is_active'       => true,
                'created_at'      => now(),
                'updated_at'      => now(),
            ],
            [
                'department_name' => 'Finance',
                'department_code' => 'FIN',
                'description'     => 'Mengelola keuangan perusahaan.',
                'manager_id'      => null,
                'is_active'       => true,
                'created_at'      => now(),
                'updated_at'      => now(),
            ],
            [
                'department_name' => 'IT',
                'department_code' => 'IT',
                'description'     => 'Menangani sistem dan infrastruktur IT.',
                'manager_id'      => null,
                'is_active'       => true,
                'created_at'      => now(),
                'updated_at'      => now(),
            ],
            [
                'department_name' => 'Sales',
                'department_code' => 'SLS',
                'description'     => 'Mengelola penjualan produk.',
                'manager_id'      => null,
                'is_active'       => true,
                'created_at'      => now(),
                'updated_at'      => now(),
            ],
        ]);

        // Ambil ID department
        $deptHR  = DB::table('departments')->where('department_code', 'HR')->value('id');
        $deptFIN = DB::table('departments')->where('department_code', 'FIN')->value('id');
        $deptIT  = DB::table('departments')->where('department_code', 'IT')->value('id');
        $deptSLS = DB::table('departments')->where('department_code', 'SLS')->value('id');

        /*
        |--------------------------------------------------------------------------
        | POSITIONS
        |--------------------------------------------------------------------------
        */
        DB::table('positions')->insert([
            [
                'position_code' => 'HR-MGR',
                'position_name' => 'HR Manager',
                'description'   => 'Bertanggung jawab atas seluruh aktivitas HR.',
                'level'         => 3,
                'department_id' => $deptHR,
                'status'        => 'active',
                'created_at'    => now(),
                'updated_at'    => now(),
            ],
            [
                'position_code' => 'HR-STF',
                'position_name' => 'HR Staff',
                'description'   => 'Membantu proses administrasi HR.',
                'level'         => 1,
                'department_id' => $deptHR,
                'status'        => 'active',
                'created_at'    => now(),
                'updated_at'    => now(),
            ],
            [
                'position_code' => 'IT-MGR',
                'position_name' => 'IT Manager',
                'description'   => 'Mengelola tim IT.',
                'level'         => 3,
                'department_id' => $deptIT,
                'status'        => 'active',
                'created_at'    => now(),
                'updated_at'    => now(),
            ],
            [
                'position_code' => 'IT-DEV',
                'position_name' => 'Software Developer',
                'description'   => 'Mengembangkan dan memelihara aplikasi.',
                'level'         => 2,
                'department_id' => $deptIT,
                'status'        => 'active',
                'created_at'    => now(),
                'updated_at'    => now(),
            ],
            [
                'position_code' => 'SLS-REP',
                'position_name' => 'Sales Representative',
                'description'   => 'Menangani penjualan dan hubungan dengan pelanggan.',
                'level'         => 1,
                'department_id' => $deptSLS,
                'status'        => 'active',
                'created_at'    => now(),
                'updated_at'    => now(),
            ],
        ]);

        /*
        |--------------------------------------------------------------------------
        | CATEGORIES
        |--------------------------------------------------------------------------
        */
        DB::table('categories')->insert([
            ['name' => 'Elektronik',        'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Aksesoris',         'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Peralatan Kantor',  'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Furniture',         'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Lainnya',           'created_at' => now(), 'updated_at' => now()],
        ]);

        /*
        |--------------------------------------------------------------------------
        | EMPLOYEES (contoh 1 data)
        |--------------------------------------------------------------------------
        */
        DB::table('employees')->insert([
            [
                'employee_code'  => 'EMP0001',
                'first_name'     => 'fadly safyuddin',
                'last_name'      => 'maulana',
                'email'          => 'fadly.m73@gmail.com',
                'phone'          => '+6285326762048',
                'username'       => 'admin',
                'password'       => '$2y$12$1KRI60ytXN9FsuAY.SYhPu3fvilOMEiImX65bVjLYQ7O/423JU7Qa',
                'profile_image'  => 'avatar.png',
                'role'           => 'staff',
                'position_id'    => 2,
                'department_id'  => 2,
                'hire_date'      => '2001-10-30',
                'status'         => 'active',
                'created_at'     => '2026-01-05 07:50:57',
                'updated_at'     => '2026-01-05 07:50:57',
            ],
        ]);

        /*
        |--------------------------------------------------------------------------
        | PRODUCTS (contoh, id_brand diisi dari kolom id_brand tabel brands)
        |--------------------------------------------------------------------------
        */
        $categoryId   = DB::table('categories')->where('name', 'Elektronik')->value('id_category');
        $brandSamsung = DB::table('brands')->where('name', 'Samsung')->value('id_brand');
        $brandApple   = DB::table('brands')->where('name', 'Apple')->value('id_brand');
        $brandXiaomi  = DB::table('brands')->where('name', 'Xiaomi')->value('id_brand');
        $brandAsus    = DB::table('brands')->where('name', 'Asus')->value('id_brand');
        $brandLenovo  = DB::table('brands')->where('name', 'Lenovo')->value('id_brand');

        $products = [
            [
                'name'        => 'Samsung Galaxy A13',
                'description' => 'Smartphone entry-level dengan layar luas dan baterai besar.',
                'price'       => 2499000.00,
                'stock'       => 10,
                'id_category' => $categoryId,
                'id_brand'    => $brandSamsung,
                'image'       => null,
                'is_visible'  => 'show',
                'status'      => 'active',
                'is_featured' => true,
                'has_discount' => false,
            ],
            [
                'name'        => 'Samsung Galaxy S23',
                'description' => 'Smartphone flagship dengan performa tinggi.',
                'price'       => 14999000.00,
                'stock'       => 5,
                'id_category' => $categoryId,
                'id_brand'    => $brandSamsung,
                'image'       => null,
                'is_visible'  => 'show',
                'status'      => 'active',
                'is_featured' => true,
                'has_discount' => false,
            ],
            [
                'name'        => 'iPhone 14',
                'description' => 'Smartphone premium dari Apple.',
                'price'       => 15999000.00,
                'stock'       => 4,
                'id_category' => $categoryId,
                'id_brand'    => $brandApple,
                'image'       => null,
                'is_visible'  => 'show',
                'status'      => 'active',
                'is_featured' => true,
                'has_discount' => false,
            ],
            [
                'name'        => 'iPhone 13',
                'description' => 'Smartphone Apple generasi sebelumnya.',
                'price'       => 12999000.00,
                'stock'       => 6,
                'id_category' => $categoryId,
                'id_brand'    => $brandApple,
                'image'       => null,
                'is_visible'  => 'show',
                'status'      => 'active',
                'is_featured' => false,
                'has_discount' => true,
            ],
            [
                'name'        => 'Xiaomi Redmi Note 12',
                'description' => 'Smartphone dengan value for money tinggi.',
                'price'       => 2999000.00,
                'stock'       => 15,
                'id_category' => $categoryId,
                'id_brand'    => $brandXiaomi,
                'image'       => null,
                'is_visible'  => 'show',
                'status'      => 'active',
                'is_featured' => false,
                'has_discount' => false,
            ],
            [
                'name'        => 'Xiaomi Redmi 13C',
                'description' => 'Smartphone murah dengan baterai besar.',
                'price'       => 1999000.00,
                'stock'       => 20,
                'id_category' => $categoryId,
                'id_brand'    => $brandXiaomi,
                'image'       => null,
                'is_visible'  => 'show',
                'status'      => 'active',
                'is_featured' => false,
                'has_discount' => true,
            ],
            [
                'name'        => 'Asus ROG Phone 7',
                'description' => 'Smartphone gaming dengan spesifikasi tinggi.',
                'price'       => 17999000.00,
                'stock'       => 3,
                'id_category' => $categoryId,
                'id_brand'    => $brandAsus,
                'image'       => null,
                'is_visible'  => 'show',
                'status'      => 'active',
                'is_featured' => true,
                'has_discount' => false,
            ],
            [
                'name'        => 'Asus Zenfone 10',
                'description' => 'Smartphone compact dengan performa flagship.',
                'price'       => 10999000.00,
                'stock'       => 4,
                'id_category' => $categoryId,
                'id_brand'    => $brandAsus,
                'image'       => null,
                'is_visible'  => 'show',
                'status'      => 'active',
                'is_featured' => false,
                'has_discount' => false,
            ],
            [
                'name'        => 'Lenovo Tab M10',
                'description' => 'Tablet untuk hiburan dan belajar.',
                'price'       => 3499000.00,
                'stock'       => 8,
                'id_category' => $categoryId,
                'id_brand'    => $brandLenovo,
                'image'       => null,
                'is_visible'  => 'show',
                'status'      => 'active',
                'is_featured' => false,
                'has_discount' => false,
            ],
            [
                'name'        => 'Lenovo IdeaPad Slim 3',
                'description' => 'Laptop entry-level untuk kebutuhan harian.',
                'price'       => 5999000.00,
                'stock'       => 5,
                'id_category' => $categoryId,
                'id_brand'    => $brandLenovo,
                'image'       => null,
                'is_visible'  => 'show',
                'status'      => 'active',
                'is_featured' => true,
                'has_discount' => false,
            ],
        ];

        foreach ($products as &$product) {
            $product['created_at'] = now();
            $product['updated_at'] = now();
        }

        DB::table('products')->insert($products);
    }
}