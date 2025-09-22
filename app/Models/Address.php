<?php

// app/Models/Address.php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Address extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', 'address_line1', 'address_line2', 'city', 'state', 'country', 'postal_code'
    ];

    // Relationship with User model
    public function user()
    {
        return $this->belongsTo(User::class);
    }

}

