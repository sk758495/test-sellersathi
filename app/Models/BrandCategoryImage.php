<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BrandCategoryImage extends Model
{
    protected $fillable = ['brand_category_id', 'image'];

    // Define the inverse relationship to the BrandCategory model
    public function brandCategory()
    {
        return $this->belongsTo(BrandCategory::class);
    }


}
