<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use App\Models\BrandCategory;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        View::composer('*', function ($view) {
            $brands = \App\Models\Brand::with(['brandCategories.subcategories'])->get();
            $brand_categories = \App\Models\BrandCategory::with('subcategories')->get();
            $view->with(compact('brands', 'brand_categories'));
        });
    }
}
