<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    // The order statuses
    const STATUS_PENDING = 'Pending';
    const STATUS_CONFIRMED = 'Confirmed';
    const STATUS_CANCELLED = 'Cancelled';

    protected $fillable = [
        'user_id', 'address_id', 'order_number', 'subtotal', 'shipping_charge', 'total_price', 'payment_method', 'order_status', 'order_id', 'transaction_id'
    ];
    
    protected $casts = [
        'address_id' => 'integer',
        'user_id' => 'integer',
        'subtotal' => 'decimal:2',
        'shipping_charge' => 'decimal:2',
        'total_price' => 'decimal:2'
    ];

    // Add a helper method to check if an order is pending
    public function isPending()
    {
        return $this->order_status === self::STATUS_PENDING;
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function address()
    {
        return $this->belongsTo(Address::class);
    }

    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }

    // For backward compatibility - get first product
    public function product()
    {
        return $this->hasOneThrough(Product::class, OrderItem::class, 'order_id', 'id', 'id', 'product_id');
    }

    // Get total quantity of all items in order
    public function getTotalQuantityAttribute()
    {
        return $this->orderItems->sum('quantity');
    }

    // Generate unique order number
    public static function generateOrderNumber()
    {
        return 'ORD-' . date('Ymd') . '-' . strtoupper(substr(uniqid(), -6));
    }
}

