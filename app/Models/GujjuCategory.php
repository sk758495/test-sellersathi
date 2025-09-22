<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GujjuCategory extends Model
{
    protected $fillable = [
        'name',
        'image',

    ];
    protected $table = 'gujju_categories'; // Make sure the table name is correct

 

}
