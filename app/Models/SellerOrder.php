<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SellerOrder extends Model
{
    use HasFactory;


    // Table associated with the model
    protected $table = 'seller_orders';

    // Define fillable attributes
    protected $fillable = [
        'user_id', 'seller_admin_id', 'address_id', 'product_id', 'payment_method', 'quantity', 'total_price', 'status'
    ];

    // Relationship with the user (buyer)
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Relationship with the seller admin
    public function sellerAdmin()
    {
        return $this->belongsTo(SellerAdmin::class);
    }

    // Relationship with the selected address
    public function address()
    {
        return $this->belongsTo(Address::class);
    }

    // Relationship with the product (ensure products table exists)
    public function product()
    {
        return $this->belongsTo(SellerProduct::class);
    }

    public function cartItems()
    {
        return $this->hasMany(SellerCart::class, 'order_id');  // Adjust based on your database structure
    }

    public function products()
    {
        return $this->hasMany(SellerCart::class, 'order_id', 'id'); // Adjust if necessary
    }


}
