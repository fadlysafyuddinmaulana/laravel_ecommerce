<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Employee;

class Department extends Model
{
    protected $fillable = [
        'department_name',
        'department_code',
        'description',
        'manager_id',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    // Provide virtual attributes `name` and `code` used in views
    public function getNameAttribute()
    {
        return $this->department_name;
    }

    public function getCodeAttribute()
    {
        return $this->department_code;
    }

    // Manager relationship (Employee)
    public function manager()
    {
        return $this->belongsTo(Employee::class, 'manager_id');
    }
}