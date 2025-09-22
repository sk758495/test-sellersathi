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
        'user_id', 'address_id','product_id', 'payment_method', 'order_status', // Add necessary fields
    ];

    // Add a helper method to check if an order is pending
    public function isPending()
    {
        return $this->order_status === self::STATUS_PENDING;
    }

    public function user()
    {
        return $this->belongsTo(User::class);  // An order belongs to a user
    }

    public function address()
    {
        return $this->belongsTo(Address::class); // Assuming an Order belongs to an Address
    }
    public function product()
    {
        return $this->belongsTo(Product::class);  // Assuming an Order belongs to one Product
    }
}

