<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AddressController extends Controller
{
    /**
     * Get all countries
     */
    public function getCountries()
    {
        $countries = DB::table('addresses')
            ->select('country')
            ->distinct()
            ->orderBy('country')
            ->pluck('country');

        return response()->json($countries);
    }

    /**
     * Get provinces by country
     */
    public function getProvinces($country)
    {
        $provinces = DB::table('addresses')
            ->where('country', $country)
            ->select('province')
            ->distinct()
            ->orderBy('province')
            ->pluck('province');

        return response()->json($provinces);
    }

    /**
     * Get cities by country and province
     */
    public function getCities($country, $province)
    {
        $cities = DB::table('addresses')
            ->where('country', $country)
            ->where('province', $province)
            ->select('city', 'postal_code')
            ->distinct()
            ->orderBy('city')
            ->get();

        return response()->json($cities);
    }

    /**
     * Get postal code by city
     */
    public function getPostalCode($country, $province, $city)
    {
        $address = DB::table('addresses')
            ->where('country', $country)
            ->where('province', $province)
            ->where('city', $city)
            ->first();

        return response()->json([
            'postal_code' => $address->postal_code ?? ''
        ]);
    }
}