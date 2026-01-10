<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'price',
        'stock',
        'id_category',
        'id_brand',
        'image',
        'is_visible',
        'status',
        'is_featured',
        'has_discount',
    ];

    protected $casts = [
        'is_featured' => 'boolean',
        'has_discount' => 'boolean',
    ];

    public function category()
    {
        return $this->belongsTo(Category::class, 'id_category', 'id_category');
    }
    
    public function brand()
    {
        return $this->belongsTo(Brand::class, 'id_brand', 'id_brand');
    }

    // Scope for new products (created in last 30 days)
    public function scopeNewProducts($query, $days = 30)
    {
        return $query->where('created_at', '>=', now()->subDays($days))
                     ->where('status', 'active')
                     ->where('is_visible', 'show');
    }

    // Scope for products with discount
    public function scopeWithDiscount($query)
    {
        return $query->where('has_discount', true)
                     ->where('status', 'active')
                     ->where('is_visible', 'show');
    }

    // Scope for featured products
    public function scopeFeatured($query)
    {
        return $query->where('is_featured', true)
                     ->where('status', 'active');
    }
    
    // Scope for visible products
    public function scopeVisible($query)
    {
        return $query->where('is_visible', 'show');
    }

}