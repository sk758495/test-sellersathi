<?php

namespace App\Http\Controllers\User\About_Us;

use App\Http\Controllers\Controller;
use App\Models\BrandCategory;
use Illuminate\Http\Request;

class AboutUsController extends Controller
{
    public function about_us(){
        $brand_categories = BrandCategory::with('images')->latest()->take(6)->get();
        return view('user.about_us.view', compact('brand_categories'));
    }
}
