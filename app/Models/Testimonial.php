<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Testimonial extends Model
{
    protected $fillable = [
        'name',
        'position',
        'company',
        'content',
        'image',
        'is_active',
        'display_order',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    // Scope for active testimonials
    public function scopeActive($query)
    {
        return $query->where('is_active', true)
                     ->orderBy('display_order', 'asc');
    }
}
