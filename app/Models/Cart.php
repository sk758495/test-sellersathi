<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    protected $fillable = [
        'user_id',
        'product_id',
        'quantity',
        'discount_id',  // Add discount_id to fillable
    ];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function discount()
    {
        return $this->belongsTo(Discount::class);  // Relationship to Discount
    }

    public function cartValue()
    {
        return $this->hasOne(CartValue::class);
    }
}
