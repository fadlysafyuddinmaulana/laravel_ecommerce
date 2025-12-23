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

        /**
         * Generate next employee code
         * Format: EMP0001, EMP0002, etc.
         */
        public static function generateEmployeeCode()
        {
            $lastEmployee = self::orderBy('employee_code', 'desc')->first();
            
            if (!$lastEmployee || !$lastEmployee->employee_code) {
                return 'EMP0001';
            }

            // Extract number from employee code (e.g., EMP0001 -> 1)
            $lastNumber = (int) substr($lastEmployee->employee_code, 3);
            $nextNumber = $lastNumber + 1;

            // Format: EMP + 4 digits with leading zeros
            return 'EMP' . str_pad($nextNumber, 4, '0', STR_PAD_LEFT);
        }

        public function position()
        {
            return $this->belongsTo(Positions::class, 'position_id', 'id');
        }
        
        public function department()
        {
            return $this->belongsTo(Department::class, 'department_id', 'id');
        }
}