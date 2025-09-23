<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BrandCategory extends Model
{
    protected $fillable = ['name', 'brand_id'];

    public function brand()
    {
        return $this->belongsTo(Brand::class);
    }

    public function subcategories()
    {
        return $this->hasMany(Subcategory::class);
    }

    public function images()
    {
        return $this->hasMany(BrandCategoryImage::class);
    }

    public function products()
    {
        return $this->hasMany(Product::class, 'brand_category_id');
    }
}
