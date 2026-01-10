<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class IndonesiaAddressSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Sample data for Indonesian provinces and major cities
        $addresses = [
            // DKI Jakarta
            ['country' => 'INDONESIA', 'province' => 'DKI JAKARTA', 'city' => 'Jakarta Pusat', 'postal_code' => '10110'],
            ['country' => 'INDONESIA', 'province' => 'DKI JAKARTA', 'city' => 'Jakarta Utara', 'postal_code' => '14410'],
            ['country' => 'INDONESIA', 'province' => 'DKI JAKARTA', 'city' => 'Jakarta Barat', 'postal_code' => '11110'],
            ['country' => 'INDONESIA', 'province' => 'DKI JAKARTA', 'city' => 'Jakarta Selatan', 'postal_code' => '12110'],
            ['country' => 'INDONESIA', 'province' => 'DKI JAKARTA', 'city' => 'Jakarta Timur', 'postal_code' => '13110'],

            // Jawa Barat
            ['country' => 'INDONESIA', 'province' => 'JAWA BARAT', 'city' => 'Bandung', 'postal_code' => '40111'],
            ['country' => 'INDONESIA', 'province' => 'JAWA BARAT', 'city' => 'Bogor', 'postal_code' => '16111'],
            ['country' => 'INDONESIA', 'province' => 'JAWA BARAT', 'city' => 'Depok', 'postal_code' => '16411'],
            ['country' => 'INDONESIA', 'province' => 'JAWA BARAT', 'city' => 'Bekasi', 'postal_code' => '17111'],
            ['country' => 'INDONESIA', 'province' => 'JAWA BARAT', 'city' => 'Cimahi', 'postal_code' => '40511'],

            // Jawa Tengah
            ['country' => 'INDONESIA', 'province' => 'JAWA TENGAH', 'city' => 'Semarang', 'postal_code' => '50111'],
            ['country' => 'INDONESIA', 'province' => 'JAWA TENGAH', 'city' => 'Solo', 'postal_code' => '57111'],
            ['country' => 'INDONESIA', 'province' => 'JAWA TENGAH', 'city' => 'Yogyakarta', 'postal_code' => '55111'],
            ['country' => 'INDONESIA', 'province' => 'JAWA TENGAH', 'city' => 'Magelang', 'postal_code' => '56111'],

            // Jawa Timur
            ['country' => 'INDONESIA', 'province' => 'JAWA TIMUR', 'city' => 'Surabaya', 'postal_code' => '60111'],
            ['country' => 'INDONESIA', 'province' => 'JAWA TIMUR', 'city' => 'Malang', 'postal_code' => '65111'],
            ['country' => 'INDONESIA', 'province' => 'JAWA TIMUR', 'city' => 'Sidoarjo', 'postal_code' => '61211'],
            ['country' => 'INDONESIA', 'province' => 'JAWA TIMUR', 'city' => 'Gresik', 'postal_code' => '61111'],

            // Bali
            ['country' => 'INDONESIA', 'province' => 'BALI', 'city' => 'Denpasar', 'postal_code' => '80111'],
            ['country' => 'INDONESIA', 'province' => 'BALI', 'city' => 'Badung', 'postal_code' => '80351'],
            ['country' => 'INDONESIA', 'province' => 'BALI', 'city' => 'Gianyar', 'postal_code' => '80511'],

            // Sumatera Utara
            ['country' => 'INDONESIA', 'province' => 'SUMATERA UTARA', 'city' => 'Medan', 'postal_code' => '20111'],
            ['country' => 'INDONESIA', 'province' => 'SUMATERA UTARA', 'city' => 'Binjai', 'postal_code' => '20711'],

            // Sumatera Barat
            ['country' => 'INDONESIA', 'province' => 'SUMATERA BARAT', 'city' => 'Padang', 'postal_code' => '25111'],
            ['country' => 'INDONESIA', 'province' => 'SUMATERA BARAT', 'city' => 'Bukittinggi', 'postal_code' => '26111'],

            // Sulawesi Selatan
            ['country' => 'INDONESIA', 'province' => 'SULAWESI SELATAN', 'city' => 'Makassar', 'postal_code' => '90111'],
            ['country' => 'INDONESIA', 'province' => 'SULAWESI SELATAN', 'city' => 'Pare-Pare', 'postal_code' => '91111'],

            // Kalimantan Timur
            ['country' => 'INDONESIA', 'province' => 'KALIMANTAN TIMUR', 'city' => 'Balikpapan', 'postal_code' => '76111'],
            ['country' => 'INDONESIA', 'province' => 'KALIMANTAN TIMUR', 'city' => 'Samarinda', 'postal_code' => '75111'],
        ];

        foreach ($addresses as $address) {
            DB::table('addresses')->insert(array_merge($address, [
                'created_at' => now(),
                'updated_at' => now(),
            ]));
        }
    }
}
