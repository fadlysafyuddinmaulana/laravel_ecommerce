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
            'profile_image',
            'position',
            'department',
            'hire_date',
            'status',
        ];

        /**
         * Generate unique employee code
         * Format: EMP001, EMP002, etc.
         */
        public static function generateEmployeeCode()
        {
            // Get the last employee code
            $lastEmployee = self::orderBy('employee_code', 'desc')->first();
            
            if (!$lastEmployee) {
                return 'EMP001';
            }
            
            // Extract number from last code (EMP001 -> 001)
            $lastNumber = (int) substr($lastEmployee->employee_code, 3);
            
            // Increment and format with leading zeros
            $newNumber = $lastNumber + 1;
            
            return 'EMP' . str_pad($newNumber, 3, '0', STR_PAD_LEFT);
        }
}