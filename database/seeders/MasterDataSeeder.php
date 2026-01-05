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
            ['brand_name' => 'Samsung', 'created_at' => now(), 'updated_at' => now()],
            ['brand_name' => 'Apple',   'created_at' => now(), 'updated_at' => now()],
            ['brand_name' => 'Xiaomi',  'created_at' => now(), 'updated_at' => now()],
            ['brand_name' => 'Asus',    'created_at' => now(), 'updated_at' => now()],
            ['brand_name' => 'Lenovo',  'created_at' => now(), 'updated_at' => now()],
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
            ['category_name' => 'Elektronik',        'created_at' => now(), 'updated_at' => now()],
            ['category_name' => 'Aksesoris',         'created_at' => now(), 'updated_at' => now()],
            ['category_name' => 'Peralatan Kantor',  'created_at' => now(), 'updated_at' => now()],
            ['category_name' => 'Furniture',         'created_at' => now(), 'updated_at' => now()],
            ['category_name' => 'Lainnya',           'created_at' => now(), 'updated_at' => now()],
        ]);

        /*
        |--------------------------------------------------------------------------
        | EMPLOYEES (1 data contoh)
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
        | PRODUCTS (25 data)
        |--------------------------------------------------------------------------
        */
        $categoryId   = DB::table('categories')->where('category_name', 'Elektronik')->value('id');
        $brandSamsung = DB::table('brands')->where('brand_name', 'Samsung')->value('id');
        $brandApple   = DB::table('brands')->where('brand_name', 'Apple')->value('id');
        $brandXiaomi  = DB::table('brands')->where('brand_name', 'Xiaomi')->value('id');
        $brandAsus    = DB::table('brands')->where('brand_name', 'Asus')->value('id');
        $brandLenovo  = DB::table('brands')->where('brand_name', 'Lenovo')->value('id');

        $products = [
            [
                'name'        => 'Samsung Galaxy A13',
                'description' => 'Smartphone entry-level dengan layar luas dan baterai besar.',
                'price'       => 2499000.00,
                'stock'       => 10,
                'category_id' => $categoryId,
                'brand_id'    => $brandSamsung,
                'image'       => null,
                'status'      => 'active',
                'is_featured' => true,
            ],
            [
                'name'        => 'Samsung Galaxy S23',
                'description' => 'Smartphone flagship dengan performa tinggi.',
                'price'       => 14999000.00,
                'stock'       => 5,
                'category_id' => $categoryId,
                'brand_id'    => $brandSamsung,
                'image'       => null,
                'status'      => 'active',
                'is_featured' => true,
            ],
            [
                'name'        => 'iPhone 14',
                'description' => 'Smartphone premium dari Apple.',
                'price'       => 15999000.00,
                'stock'       => 4,
                'category_id' => $categoryId,
                'brand_id'    => $brandApple,
                'image'       => null,
                'status'      => 'active',
                'is_featured' => true,
            ],
            [
                'name'        => 'iPhone 13',
                'description' => 'Smartphone Apple generasi sebelumnya dengan performa masih kencang.',
                'price'       => 12999000.00,
                'stock'       => 6,
                'category_id' => $categoryId,
                'brand_id'    => $brandApple,
                'image'       => null,
                'status'      => 'active',
                'is_featured' => false,
            ],
            [
                'name'        => 'Xiaomi Redmi Note 12',
                'description' => 'Smartphone dengan value for money tinggi.',
                'price'       => 2999000.00,
                'stock'       => 15,
                'category_id' => $categoryId,
                'brand_id'    => $brandXiaomi,
                'image'       => null,
                'status'      => 'active',
                'is_featured' => false,
            ],
            [
                'name'        => 'Xiaomi Redmi 13C',
                'description' => 'Smartphone murah dengan baterai besar.',
                'price'       => 1999000.00,
                'stock'       => 20,
                'category_id' => $categoryId,
                'brand_id'    => $brandXiaomi,
                'image'       => null,
                'status'      => 'active',
                'is_featured' => false,
            ],
            [
                'name'        => 'Asus ROG Phone 7',
                'description' => 'Smartphone gaming dengan spesifikasi tinggi.',
                'price'       => 17999000.00,
                'stock'       => 3,
                'category_id' => $categoryId,
                'brand_id'    => $brandAsus,
                'image'       => null,
                'status'      => 'active',
                'is_featured' => true,
            ],
            [
                'name'        => 'Asus Zenfone 10',
                'description' => 'Smartphone compact dengan performa flagship.',
                'price'       => 10999000.00,
                'stock'       => 4,
                'category_id' => $categoryId,
                'brand_id'    => $brandAsus,
                'image'       => null,
                'status'      => 'active',
                'is_featured' => false,
            ],
            [
                'name'        => 'Lenovo Tab M10',
                'description' => 'Tablet untuk hiburan dan belajar.',
                'price'       => 3499000.00,
                'stock'       => 8,
                'category_id' => $categoryId,
                'brand_id'    => $brandLenovo,
                'image'       => null,
                'status'      => 'active',
                'is_featured' => false,
            ],
            [
                'name'        => 'Lenovo IdeaPad Slim 3',
                'description' => 'Laptop entry-level untuk kebutuhan harian.',
                'price'       => 5999000.00,
                'stock'       => 5,
                'category_id' => $categoryId,
                'brand_id'    => $brandLenovo,
                'image'       => null,
                'status'      => 'active',
                'is_featured' => true,
            ],
            // 15 data tambahan
            ['name' => 'Samsung Galaxy A05',      'description' => 'Smartphone budget Samsung.',                    'price' => 1799000.00,  'stock' => 25, 'category_id' => $categoryId, 'brand_id' => $brandSamsung, 'image' => null, 'status' => 'active', 'is_featured' => false],
            ['name' => 'Samsung Galaxy M34',      'description' => 'Baterai besar dan layar AMOLED.',               'price' => 3299000.00,  'stock' => 12, 'category_id' => $categoryId, 'brand_id' => $brandSamsung, 'image' => null, 'status' => 'active', 'is_featured' => false],
            ['name' => 'iPhone SE 3',             'description' => 'iPhone kecil dengan chip kencang.',             'price' => 7999000.00,  'stock' => 7,  'category_id' => $categoryId, 'brand_id' => $brandApple,   'image' => null, 'status' => 'active', 'is_featured' => false],
            ['name' => 'iPad 10th Gen',           'description' => 'Tablet serbaguna dari Apple.',                  'price' => 8999000.00,  'stock' => 6,  'category_id' => $categoryId, 'brand_id' => $brandApple,   'image' => null, 'status' => 'active', 'is_featured' => false],
            ['name' => 'MacBook Air M2',          'description' => 'Laptop tipis dengan chip M2.',                  'price' => 17999000.00, 'stock' => 3,  'category_id' => $categoryId, 'brand_id' => $brandApple,   'image' => null, 'status' => 'active', 'is_featured' => true],
            ['name' => 'Xiaomi Pad 6',            'description' => 'Tablet Android dengan layar 120Hz.',            'price' => 4999000.00,  'stock' => 9,  'category_id' => $categoryId, 'brand_id' => $brandXiaomi,  'image' => null, 'status' => 'active', 'is_featured' => false],
            ['name' => 'Xiaomi 13T',              'description' => 'Smartphone dengan kamera Leica.',               'price' => 6999000.00,  'stock' => 6,  'category_id' => $categoryId, 'brand_id' => $brandXiaomi,  'image' => null, 'status' => 'active', 'is_featured' => true],
            ['name' => 'Asus Vivobook 15',        'description' => 'Laptop untuk kuliah dan kerja.',                'price' => 7499000.00,  'stock' => 5,  'category_id' => $categoryId, 'brand_id' => $brandAsus,    'image' => null, 'status' => 'active', 'is_featured' => false],
            ['name' => 'Asus TUF Gaming F15',     'description' => 'Laptop gaming mid-range.',                      'price' => 13999000.00, 'stock' => 4,  'category_id' => $categoryId, 'brand_id' => $brandAsus,    'image' => null, 'status' => 'active', 'is_featured' => true],
            ['name' => 'Lenovo Legion 5',         'description' => 'Laptop gaming dengan performa tinggi.',         'price' => 15999000.00, 'stock' => 3,  'category_id' => $categoryId, 'brand_id' => $brandLenovo,  'image' => null, 'status' => 'active', 'is_featured' => true],
            ['name' => 'Lenovo ThinkPad E14',     'description' => 'Laptop bisnis yang tangguh.',                  'price' => 10999000.00, 'stock' => 4,  'category_id' => $categoryId, 'brand_id' => $brandLenovo,  'image' => null, 'status' => 'active', 'is_featured' => false],
            ['name' => 'Samsung Monitor 24"',     'description' => 'Monitor Full HD 75Hz.',                         'price' => 1899000.00,  'stock' => 11, 'category_id' => $categoryId, 'brand_id' => $brandSamsung, 'image' => null, 'status' => 'active', 'is_featured' => false],
            ['name' => 'Apple AirPods 3',         'description' => 'TWS original Apple.',                           'price' => 3499000.00,  'stock' => 10, 'category_id' => $categoryId, 'brand_id' => $brandApple,   'image' => null, 'status' => 'active', 'is_featured' => true],
            ['name' => 'Xiaomi Buds 4 Pro',       'description' => 'TWS dengan ANC.',                               'price' => 1599000.00,  'stock' => 14, 'category_id' => $categoryId, 'brand_id' => $brandXiaomi,  'image' => null, 'status' => 'active', 'is_featured' => false],
            ['name' => 'Lenovo Wireless Mouse',   'description' => 'Mouse wireless simpel.',                        'price' => 199000.00,   'stock' => 30, 'category_id' => $categoryId, 'brand_id' => $brandLenovo,  'image' => null, 'status' => 'active', 'is_featured' => false],
        ];

        foreach ($products as &$product) {
            $product['created_at'] = now();
            $product['updated_at'] = now();
        }

        DB::table('products')->insert($products);
    }
}