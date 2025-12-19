<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Customer extends Model
{
    use HasFactory;

    protected $fillable = [
        'first_name',
        'last_name',
        'gender',
        'phone',
        'username',
        'email',
        'email_verified_at',
        'password',
        'profile_image',
        'date_of_birth',
        'address',
        'city',
        'state',
        'zip_code',
        'role',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'date_of_birth' => 'date',
    ];
}