<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class AppInitialSeeder extends Seeder
{
    public function run(): void
    {
        // BRANDS
        DB::table('brands')->insert([
            ['brand_name' => 'Nike',   'created_at' => now(), 'updated_at' => now()],
            ['brand_name' => 'Adidas', 'created_at' => now(), 'updated_at' => now()],
            ['brand_name' => 'Uniqlo', 'created_at' => now(), 'updated_at' => now()],
        ]);

        // CATEGORIES
        DB::table('categories')->insert([
            ['category_name' => 'Electronics', 'created_at' => now(), 'updated_at' => now()],
            ['category_name' => 'Fashion',     'created_at' => now(), 'updated_at' => now()],
            ['category_name' => 'Groceries',   'created_at' => now(), 'updated_at' => now()],
        ]);

        // DEPARTMENTS
        DB::table('departments')->insert([
            [
                'department_name' => 'Human Resources',
                'department_code' => 'HR',
                'description'     => 'Handle employee-related processes.',
                'manager_id'      => null,
                'is_active'       => true,
                'created_at'      => now(),
                'updated_at'      => now(),
            ],
            [
                'department_name' => 'IT',
                'department_code' => 'IT',
                'description'     => 'Handle technology and infrastructure.',
                'manager_id'      => null,
                'is_active'       => true,
                'created_at'      => now(),
                'updated_at'      => now(),
            ],
        ]);

        // POSITIONS
        DB::table('positions')->insert([
            [
                'position_code' => 'HR-MGR',
                'position_name' => 'HR Manager',
                'description'   => 'Manage HR department.',
                'level'         => 3,
                'department_id' => 1,
                'status'        => 'active',
                'created_at'    => now(),
                'updated_at'    => now(),
            ],
            [
                'position_code' => 'IT-STAFF',
                'position_name' => 'IT Staff',
                'description'   => 'Handle daily IT operations.',
                'level'         => 1,
                'department_id' => 2,
                'status'        => 'active',
                'created_at'    => now(),
                'updated_at'    => now(),
            ],
        ]);

        // EMPLOYEES
        DB::table('employees')->insert([
            [
                'employee_code' => 'EMP001',
                'first_name'    => 'Andi',
                'last_name'     => 'Wijaya',
                'email'         => 'andi.hr@example.com',
                'phone'         => '081111111111',
                'username'      => 'andi.hr',
                'password'      => Hash::make('password'),
                'profile_image' => 'avatar.png',
                'role'          => 'manager',
                'position_id'   => 1,
                'department_id' => 1,
                'hire_date'     => '2022-01-01',
                'status'        => 'active',
                'created_at'    => now(),
                'updated_at'    => now(),
            ],
            [
                'employee_code' => 'EMP002',
                'first_name'    => 'Siti',
                'last_name'     => 'Rahma',
                'email'         => 'siti.it@example.com',
                'phone'         => '082222222222',
                'username'      => 'siti.it',
                'password'      => Hash::make('password'),
                'profile_image' => 'avatar.png',
                'role'          => 'staff',
                'position_id'   => 2,
                'department_id' => 2,
                'hire_date'     => '2023-01-01',
                'status'        => 'active',
                'created_at'    => now(),
                'updated_at'    => now(),
            ],
        ]);

        // CUSTOMERS
        DB::table('customers')->insert([
            [
                'customer_code'     => 'CUST001',
                'first_name'        => 'Budi',
                'last_name'         => 'Santoso',
                'gender'            => 'male',
                'phone'             => '081234567890',
                'username'          => 'budi',
                'email'             => 'budi@example.com',
                'email_verified_at' => now(),
                'password'          => Hash::make('password'),
                'profile_image'     => 'avatar.png',
                'date_of_birth'     => '1990-01-01',
                'address'           => 'Jl. Mawar No. 1',
                'city'              => 'Surakarta',
                'state'             => 'Jawa Tengah',
                'zip_code'          => '57100',
                'role'              => 'customer',
                'remember_token'    => null,
                'created_at'        => now(),
                'updated_at'        => now(),
            ],
        ]);

        // PRODUCTS
        DB::table('products')->insert([
            [
                'name'         => 'Smartphone X',
                'description'  => 'High-end smartphone.',
                'price'        => 7500000,
                'stock'        => 10,
                'category_id'  => 1,
                'brand_id'     => '1',
                'image'        => null,
                'status'       => 'active',
                'is_featured'  => true,
                'created_at'   => now(),
                'updated_at'   => now(),
            ],
            [
                'name'         => 'Running Shoes',
                'description'  => 'Comfortable running shoes.',
                'price'        => 550000,
                'stock'        => 30,
                'category_id'  => 2,
                'brand_id'     => '2',
                'image'        => null,
                'status'       => 'active',
                'is_featured'  => false,
                'created_at'   => now(),
                'updated_at'   => now(),
            ],
        ]);

        // PERSONAL ACCESS TOKENS (opsional)
        DB::table('personal_access_tokens')->insert([
            [
                'tokenable_type' => 'App\\Models\\User',
                'tokenable_id'   => 1,
                'name'           => 'Default Token',
                'token'          => hash('sha256', Str::random(40)),
                'abilities'      => json_encode(['*']),
                'last_used_at'   => null,
                'expires_at'     => now()->addYear(),
                'created_at'     => now(),
                'updated_at'     => now(),
            ],
        ]);
    }
}