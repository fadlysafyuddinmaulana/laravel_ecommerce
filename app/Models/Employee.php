<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class Employee extends Authenticatable
{
    /**
     * Generate unique employee code (e.g. EMP0001, EMP0002, ...)
     * @return string
     */
    public static function generateEmployeeCode()
    {
        $lastEmployee = self::orderByDesc('id')->first();
        $lastCode = $lastEmployee ? $lastEmployee->employee_code : null;

        if ($lastCode && preg_match('/EMP(\d+)/', $lastCode, $matches)) {
            $nextNumber = (int)$matches[1] + 1;
        } else {
            $nextNumber = 1;
        }

        return 'EMP' . str_pad($nextNumber, 4, '0', STR_PAD_LEFT);
    }
    use HasApiTokens, HasFactory, Notifiable;

    protected $fillable = [
        'employee_code',
        'first_name',
        'last_name',
        'email',
        'phone',
        'username',
        'password',
        'profile_image',
        'role',
        'position_id',
        'department_id',
        'hire_date',
        'status',
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

    // Relasi ke tabel positions
    public function position()
    {
        return $this->belongsTo(\App\Models\Positions::class, 'position_id');
    }

    // Relasi ke tabel departments
    public function department()
    {
        return $this->belongsTo(\App\Models\Department::class, 'department_id');
    }
    // relasi & generator code tetap seperti punyamu
}