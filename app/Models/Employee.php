<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Employee extends Model
{
        use HasFactory;

        protected $fillable = [
            'employee_code',
            'first_name',
            'last_name',
            'email',
            'phone',
            'username',
            'password',
            'position',
            'department',
            'hire_date',
            'status',
        ];
}