<?php

namespace App\Http\Controllers\User\PrivacyPolicy;

use App\Http\Controllers\Controller;
use App\Models\BrandCategory;
use Illuminate\Http\Request;

class PrivacyPolicyController extends Controller
{
    public function privacy_policy(){
        $brand_categories = BrandCategory::with('images')->latest()->take(6)->get();
        return view('user.privacy-policy.privacy-policy-view', compact('brand_categories'));
    }
}
