<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;

class DemoDataSeeder extends Seeder
{
    public function run()
    {
        $now = Carbon::now();

        // 1) Insert positions (department_id left null for now)
        $positions = [
            ['position_code' => 'POS001', 'position_name' => 'HR Manager', 'description' => 'Manajer departemen HR', 'level' => 3, 'status' => 'active', 'created_at' => $now, 'updated_at' => $now],
            ['position_code' => 'POS002', 'position_name' => 'HR Staff', 'description' => 'Staff departemen HR', 'level' => 1, 'status' => 'active', 'created_at' => $now, 'updated_at' => $now],
            ['position_code' => 'POS003', 'position_name' => 'IT Manager', 'description' => 'Manajer departemen IT', 'level' => 3, 'status' => 'active', 'created_at' => $now, 'updated_at' => $now],
            ['position_code' => 'POS004', 'position_name' => 'Software Developer', 'description' => 'Pengembang perangkat lunak', 'level' => 2, 'status' => 'active', 'created_at' => $now, 'updated_at' => $now],
            ['position_code' => 'POS005', 'position_name' => 'System Administrator', 'description' => 'Administrator sistem', 'level' => 2, 'status' => 'active', 'created_at' => $now, 'updated_at' => $now],
            ['position_code' => 'POS006', 'position_name' => 'Sales Manager', 'description' => 'Manajer penjualan', 'level' => 3, 'status' => 'active', 'created_at' => $now, 'updated_at' => $now],
            ['position_code' => 'POS007', 'position_name' => 'Sales Executive', 'description' => 'Eksekutif penjualan', 'level' => 1, 'status' => 'active', 'created_at' => $now, 'updated_at' => $now],
            ['position_code' => 'POS008', 'position_name' => 'Marketing Specialist', 'description' => 'Spesialis pemasaran', 'level' => 2, 'status' => 'active', 'created_at' => $now, 'updated_at' => $now],
            ['position_code' => 'POS009', 'position_name' => 'Finance Manager', 'description' => 'Manajer keuangan', 'level' => 3, 'status' => 'active', 'created_at' => $now, 'updated_at' => $now],
            ['position_code' => 'POS010', 'position_name' => 'Accountant', 'description' => 'Akuntan', 'level' => 2, 'status' => 'active', 'created_at' => $now, 'updated_at' => $now],
            ['position_code' => 'POS011', 'position_name' => 'Operations Manager', 'description' => 'Manajer operasional', 'level' => 3, 'status' => 'active', 'created_at' => $now, 'updated_at' => $now],
            ['position_code' => 'POS012', 'position_name' => 'Warehouse Staff', 'description' => 'Staff gudang', 'level' => 1, 'status' => 'active', 'created_at' => $now, 'updated_at' => $now],
        ];

        DB::table('positions')->insert($positions);

        // 2) Create departments derived from positions (department_name & department_code from position_name & position_code)
        $allPositions = DB::table('positions')->get();
        $departments = [];
        $seen = [];
        // Mapping nama/judul department ke deskripsi
        $descMap = [
            'HR Manager' => 'Departemen yang mengelola SDM dan kepegawaian',
            'HR Staff' => 'Departemen yang mengelola SDM dan kepegawaian',
            'IT Manager' => 'Departemen teknologi informasi dan sistem',
            'Software Developer' => 'Departemen teknologi informasi dan sistem',
            'System Administrator' => 'Departemen teknologi informasi dan sistem',
            'Sales Manager' => 'Departemen penjualan dan pemasaran',
            'Sales Executive' => 'Departemen penjualan dan pemasaran',
            'Marketing Specialist' => 'Departemen penjualan dan pemasaran',
            'Finance Manager' => 'Departemen keuangan dan akuntansi',
            'Accountant' => 'Departemen keuangan dan akuntansi',
            'Operations Manager' => 'Departemen operasional dan logistik',
            'Warehouse Staff' => 'Departemen operasional dan logistik',
        ];
        foreach ($allPositions as $p) {
            if (!empty($p->position_code) && !isset($seen[$p->position_code])) {
                $seen[$p->position_code] = true;
                $desc = $descMap[$p->position_name] ?? null;
                $departments[] = [
                    'department_name' => $p->position_name,
                    'department_code' => $p->position_code,
                    'description' => $desc,
                    'is_active' => true,
                    'created_at' => $now,
                    'updated_at' => $now,
                ];
            }
        }

        // Insert unique departments
        if (!empty($departments)) {
            DB::table('departments')->insert($departments);
        }

        // 3) Update positions.department_id by matching department_code == position_code
        $allPositions = DB::table('positions')->get();
        foreach ($allPositions as $p) {
            if (empty($p->position_code)) continue;
            $dept = DB::table('departments')->where('department_code', $p->position_code)->first();
            if ($dept) {
                DB::table('positions')->where('id', $p->id)->update(['department_id' => $dept->id]);
            }
        }

        // 4) Seed categories
        $categories = [
            ['category_name' => 'Electronics', 'description' => 'Produk elektronik dan gadget', 'created_at' => $now, 'updated_at' => $now],
            ['category_name' => 'Fashion', 'description' => 'Pakaian dan aksesoris', 'created_at' => $now, 'updated_at' => $now],
            ['category_name' => 'Home & Living', 'description' => 'Peralatan rumah tangga', 'created_at' => $now, 'updated_at' => $now],
            ['category_name' => 'Beauty & Health', 'description' => 'Produk kecantikan dan kesehatan', 'created_at' => $now, 'updated_at' => $now],
            ['category_name' => 'Sports & Outdoor', 'description' => 'Peralatan olahraga dan outdoor', 'created_at' => $now, 'updated_at' => $now],
        ];
        DB::table('categories')->insert($categories);

        // 5) Seed products (map category by name)
        $categoryMap = DB::table('categories')->pluck('id', 'category_name')->toArray();
        $products = [
            ['name' => 'Samsung Galaxy S24', 'description' => 'Smartphone flagship', 'price' => 15000000.00, 'stock' => 50, 'category_id' => $categoryMap['Electronics'] ?? null, 'brand' => 'Samsung', 'image' => 'galaxy-s24.jpg', 'status' => 'active', 'is_featured' => true, 'created_at' => $now, 'updated_at' => $now],
            ['name' => 'iPhone 15 Pro', 'description' => 'iPhone terbaru', 'price' => 18000000.00, 'stock' => 30, 'category_id' => $categoryMap['Electronics'] ?? null, 'brand' => 'Apple', 'image' => 'iphone-15-pro.jpg', 'status' => 'active', 'is_featured' => true, 'created_at' => $now, 'updated_at' => $now],
            ['name' => 'Kaos Polos Premium', 'description' => 'Kaos cotton combed 30s', 'price' => 85000.00, 'stock' => 500, 'category_id' => $categoryMap['Fashion'] ?? null, 'brand' => 'Local Brand', 'image' => 'kaos-polos.jpg', 'status' => 'active', 'is_featured' => false, 'created_at' => $now, 'updated_at' => $now],
        ];
        DB::table('products')->insert($products);

        // 6) Seed employees (use mapping from position_code -> positions.id and department_code -> departments.id)
        $employeeRows = [
            ['employee_code' => 'EMP001','first_name' => 'Budi','last_name' => 'Santoso','email' => 'budi.santoso@company.com','phone' => '081234567890','username' => 'budi.santoso','password' => Hash::make('password'),'profile_image' => 'avatar.png','position_code' => 'POS001','department_code' => 'POS001','hire_date' => '2023-01-15','status' => 'active'],
            ['employee_code' => 'EMP002','first_name' => 'Siti','last_name' => 'Nurhaliza','email' => 'siti.nurhaliza@company.com','phone' => '081234567891','username' => 'siti.nurhaliza','password' => Hash::make('password'),'profile_image' => 'avatar.png','position_code' => 'POS002','department_code' => 'POS002','hire_date' => '2023-02-20','status' => 'active'],
            ['employee_code' => 'EMP003','first_name' => 'Ahmad','last_name' => 'Wijaya','email' => 'ahmad.wijaya@company.com','phone' => '081234567892','username' => 'ahmad.wijaya','password' => Hash::make('password'),'profile_image' => 'avatar.png','position_code' => 'POS003','department_code' => 'POS003','hire_date' => '2023-01-10','status' => 'active'],
            ['employee_code' => 'EMP004','first_name' => 'Dewi','last_name' => 'Lestari','email' => 'dewi.lestari@company.com','phone' => '081234567893','username' => 'dewi.lestari','password' => Hash::make('password'),'profile_image' => 'avatar.png','position_code' => 'POS004','department_code' => 'POS004','hire_date' => '2023-03-15','status' => 'active'],
            ['employee_code' => 'EMP005','first_name' => 'Eko','last_name' => 'Prasetyo','email' => 'eko.prasetyo@company.com','phone' => '081234567894','username' => 'eko.prasetyo','password' => Hash::make('password'),'profile_image' => 'avatar.png','position_code' => 'POS005','department_code' => 'POS005','hire_date' => '2023-04-01','status' => 'active'],
            ['employee_code' => 'EMP006','first_name' => 'Rina','last_name' => 'Kusuma','email' => 'rina.kusuma@company.com','phone' => '081234567895','username' => 'rina.kusuma','password' => Hash::make('password'),'profile_image' => 'avatar.png','position_code' => 'POS006','department_code' => 'POS006','hire_date' => '2023-01-20','status' => 'active'],
            ['employee_code' => 'EMP007','first_name' => 'Andi','last_name' => 'Setiawan','email' => 'andi.setiawan@company.com','phone' => '081234567896','username' => 'andi.setiawan','password' => Hash::make('password'),'profile_image' => 'avatar.png','position_code' => 'POS007','department_code' => 'POS007','hire_date' => '2023-05-10','status' => 'active'],
            ['employee_code' => 'EMP008','first_name' => 'Maya','last_name' => 'Anggraini','email' => 'maya.anggraini@company.com','phone' => '081234567897','username' => 'maya.anggraini','password' => Hash::make('password'),'profile_image' => 'avatar.png','position_code' => 'POS008','department_code' => 'POS008','hire_date' => '2023-06-01','status' => 'active'],
            ['employee_code' => 'EMP009','first_name' => 'Rudi','last_name' => 'Hartono','email' => 'rudi.hartono@company.com','phone' => '081234567898','username' => 'rudi.hartono','password' => Hash::make('password'),'profile_image' => 'avatar.png','position_code' => 'POS009','department_code' => 'POS009','hire_date' => '2023-01-05','status' => 'active'],
            ['employee_code' => 'EMP010','first_name' => 'Linda','last_name' => 'Permata','email' => 'linda.permata@company.com','phone' => '081234567899','username' => 'linda.permata','password' => Hash::make('password'),'profile_image' => 'avatar.png','position_code' => 'POS010','department_code' => 'POS010','hire_date' => '2023-07-15','status' => 'active'],
        ];

        foreach ($employeeRows as $er) {
            $pos = DB::table('positions')->where('position_code', $er['position_code'])->first();
            $dept = DB::table('departments')->where('department_code', $er['department_code'])->first();

            DB::table('employees')->insert([
                'employee_code' => $er['employee_code'],
                'first_name' => $er['first_name'],
                'last_name' => $er['last_name'],
                'email' => $er['email'],
                'phone' => $er['phone'],
                'username' => $er['username'],
                'password' => $er['password'],
                'profile_image' => $er['profile_image'],
                'position_id' => $pos->id ?? null,
                'department_id' => $dept->id ?? null,
                'hire_date' => $er['hire_date'],
                'status' => $er['status'],
                'created_at' => $now,
                'updated_at' => $now,
            ]);
        }

        // 7) Set department manager_id: prioritaskan employee dengan posisi mengandung 'Manager', fallback ke employee pertama
        $departmentsAll = DB::table('departments')->get();
        foreach ($departmentsAll as $d) {
            $manager = DB::table('employees')
                ->join('positions', 'employees.position_id', '=', 'positions.id')
                ->where('employees.department_id', $d->id)
                ->where('positions.position_name', 'ILIKE', '%Manager%')
                ->orderBy('employees.id')
                ->select('employees.id')
                ->first();
            if (!$manager) {
                $manager = DB::table('employees')
                    ->where('department_id', $d->id)
                    ->orderBy('id')
                    ->select('id')
                    ->first();
            }
            if ($manager) {
                DB::table('departments')->where('id', $d->id)->update(['manager_id' => $manager->id, 'updated_at' => $now]);
            }
        }

        // 8) Seed customers
        $customers = [
            ['first_name' => 'Andi','last_name' => 'Pratama','gender' => 'male','phone' => '081234560001','username' => 'andi.pratama','email' => 'andi.pratama@gmail.com','email_verified_at' => $now,'password' => Hash::make('password'),'profile_image' => 'avatar.png','date_of_birth' => '1990-05-15','address' => 'Jl. Merdeka No. 123','city' => 'Jakarta','state' => 'DKI Jakarta','zip_code' => '12345','role' => 'customer','created_at' => $now,'updated_at' => $now],
            ['first_name' => 'Sari','last_name' => 'Dewi','gender' => 'female','phone' => '081234560002','username' => 'sari.dewi','email' => 'sari.dewi@gmail.com','email_verified_at' => $now,'password' => Hash::make('password'),'profile_image' => 'avatar.png','date_of_birth' => '1995-08-20','address' => 'Jl. Sudirman No. 456','city' => 'Bandung','state' => 'Jawa Barat','zip_code' => '40123','role' => 'customer','created_at' => $now,'updated_at' => $now],
        ];
        DB::table('customers')->insert($customers);
    }
}