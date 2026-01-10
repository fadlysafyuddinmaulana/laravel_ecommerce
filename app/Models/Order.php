<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = [
        'order_number',
        'first_name',
        'last_name',
        'email',
        'address',
        'address2',
        'country',
        'province',
        'city',
        'postal_code',
        'subtotal',
        'delivery',
        'discount',
        'tax',
        'total',
        'payment_method',
        'card_name',
        'card_number_last4',
        'status',
    ];

    /**
     * Generate unique order number
     */
    public static function generateOrderNumber()
    {
        $lastOrder = self::orderBy('order_number', 'desc')->first();
        if (!$lastOrder) {
            return 'ORD001';
        }
        
        $lastNumber = (int) substr($lastOrder->order_number, 3);
        $newNumber = $lastNumber + 1;
        return 'ORD' . str_pad($newNumber, 3, '0', STR_PAD_LEFT);
    }

    /**
     * Relationship to order items
     */
    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }
}
