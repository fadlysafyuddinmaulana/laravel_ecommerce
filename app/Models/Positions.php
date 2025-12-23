<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Positions extends Model
{
    protected $fillable = [
        'position_code',
        'position_name',
        'description',
        'level',
        'department_id',
        'status',
    ];

    public function department()
    {
        return $this->belongsTo(\App\Models\Department::class, 'department_id');
    }
}