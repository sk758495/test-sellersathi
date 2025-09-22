<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Brand extends Model
{
    protected $fillable = [
        'name',
        'image',

    ];
    public function brandCategories()
    {
        return $this->hasMany(BrandCategory::class);
    }
}
