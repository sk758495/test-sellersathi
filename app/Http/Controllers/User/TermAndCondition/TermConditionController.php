<?php

namespace App\Http\Controllers\User\TermAndCondition;

use App\Http\Controllers\Controller;
use App\Models\BrandCategory;
use Illuminate\Http\Request;

class TermConditionController extends Controller
{
    public function term_condition(){
        $brand_categories = BrandCategory::with('images')->latest()->take(6)->get();
        return view('user.term-condition.view-term-condition', compact('brand_categories'));
    }
}
