<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CartValue extends Model
{
    protected $fillable = [
        'user_id',
        'cart_id',
        'subtotal',
        'shipping',
        'total_price',
    ];

    public function cart()
    {
        return $this->belongsTo(Cart::class); // Link to Cart model
    }

    public function user()
    {
        return $this->belongsTo(User::class); // Link to User model
    }
    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}

