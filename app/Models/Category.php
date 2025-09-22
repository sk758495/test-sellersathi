<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;


class Category extends Model
{
    protected $fillable = ['name', 'parent_id']; // Allow mass assignment

    // A category can have many child categories (self-referencing)
    public function children()
    {
        return $this->hasMany(Category::class, 'parent_id');
    }

    // A category can belong to a parent category (self-referencing)
    public function parent()
    {
        return $this->belongsTo(Category::class, 'parent_id');
    }
}
