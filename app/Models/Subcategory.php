<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Subcategory extends Model
{
    protected $fillable = ['name', 'brand_category_id'];

    public function brandCategory()
    {
        return $this->belongsTo(BrandCategory::class);
    }

    public function products()
    {
        return $this->hasMany(Product::class);
    }
}
