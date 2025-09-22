<?php

namespace App\Http\Controllers\User\Disclaimer;

use App\Http\Controllers\Controller;
use App\Models\BrandCategory;
use Illuminate\Http\Request;

class DisclaimerController extends Controller
{
    public function disclaimer(){
        $brand_categories = BrandCategory::with('images')->latest()->take(6)->get();
        return view('user.disclaimer.disclaimer-view', compact('brand_categories'));
    }
}
