<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class Customer extends Authenticatable
{
    /**
     * Generate unique customer code (e.g. CUS0001, CUS0002, ...)
     * @return string
     */
    public static function generateCustomerCode()
    {
        $lastCustomer = self::orderByDesc('id')->first();
        $lastCode = $lastCustomer ? $lastCustomer->customer_code : null;
        
        if ($lastCode && preg_match('/CUS(\d+)/', $lastCode, $matches)) {
            $nextNumber = (int)$matches[1] + 1;
        } else {
            $nextNumber = 1;
        }
        
        return 'CUS' . str_pad($nextNumber, 4, '0', STR_PAD_LEFT);
    }


    use HasApiTokens, HasFactory, Notifiable;

    protected $fillable = [
        'customer_code',
        'first_name',
        'last_name',
        'gender',
        'phone',
        'username',
        'email',
        'password',
        'profile_image',
        'date_of_birth',
        'address',
        'city',
        'state',
        'zip_code',
        'role',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'password' => 'hashed',
        ];
    }
}