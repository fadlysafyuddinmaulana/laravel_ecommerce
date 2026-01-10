<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrderItem extends Model
{
    protected $fillable = [
        'order_id',
        'product_id',
        'product_name',
        'product_image',
        'price',
        'quantity',
        'subtotal',
    ];

    /**
     * Relationship to order
     */
    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    /**
     * Relationship to product
     */
    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}