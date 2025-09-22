<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = [
        'product_name',        // Add this field to the fillable array
        'sku',
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
        'gujju_category_id',
    ];

    // Relationship with the Brand model
    public function brand()
    {
        return $this->belongsTo(Brand::class);
    }

    // Relationship with the BrandCategory model
    public function brandCategory()
    {
        return $this->belongsTo(BrandCategory::class);
    }

    // Relationship with the Subcategory model
    public function subcategory()
    {
        return $this->belongsTo(Subcategory::class);
    }


    public function images()
    {
        return $this->hasMany(ProductImage::class); // Define the relationship to the ProductImage model
    }

    public function orders()
    {
        return $this->hasMany(Order::class);  // One product can be in many orders
    }

        public function discount()
    {
        return $this->hasOne(Discount::class); // Assuming one discount per product
    }

    public function category()
{
    return $this->belongsTo(GujjuCategory::class, 'gujju_category_id');
}

}
