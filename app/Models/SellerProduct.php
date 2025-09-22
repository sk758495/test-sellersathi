<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SellerProduct extends Model
{
    use HasFactory;

    protected $fillable = [
        'seller_admin_id',
        'admin_product_id',
        'sku',
        'product_name',
        'color_name',
        'color_code',
        'quantity',
        'lead_time',
        'price',
        'cost_price',
        'discount_price',
        'brand_id',
        'brand_category_id',
        'subcategory_id',
        'short_description',
        'long_description',
        'features',
        'whats_included',
        'main_image',
    ];

    // Relationship with SellerAdmin
    public function sellerAdmin()
    {
        return $this->belongsTo(SellerAdmin::class);
    }

    // Relationship with the Admin's Product
    public function adminProduct()
    {
        return $this->belongsTo(Product::class, 'admin_product_id');
    }

    public function brand() {
        return $this->belongsTo(Brand::class);
    }

    public function brandCategory() {
        return $this->belongsTo(BrandCategory::class);
    }

    public function subcategory() {
        return $this->belongsTo(Subcategory::class);
    }

    public function products()
    {
        return $this->hasMany(SellerProduct::class, 'seller_admin_id');
    }

    public function sellerOrders()
    {
        return $this->hasMany(SellerOrder::class);
    }

}
