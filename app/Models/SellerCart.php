<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SellerCart extends Model
{
    use HasFactory;

    protected $table = 'seller_carts';

    protected $fillable = [
        'user_id',
        'seller_admin_id',
        'product_id',
        'product_name',
        'color_name',
        'color_code',
        'quantity',
        'price'
    ];


    // Define relationship to user
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Define relationship to seller_admin
    public function sellerAdmin()
    {
        return $this->belongsTo(SellerAdmin::class, 'seller_admin_id');
    }

    // Define relationship to seller_product
    public function product()
    {
        return $this->belongsTo(SellerProduct::class, 'product_id');
    }

    public function products()
    {
        return $this->belongsTo(SellerProduct::class, 'product_id');
    }
}
