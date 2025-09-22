<?php

use App\Http\Controllers\Admin\Pages\BrandCategoryController;
use App\Http\Controllers\Admin\Pages\BrandController;
use Illuminate\Support\Facades\Route;

Route::prefix('pages')->middleware('auth:admin')->group(function () {

    Route::get('brands', [BrandController::class, 'view_brands'])->name('pages.view_brands');

    Route::get('add-brand', [BrandController::class, 'add_brand'])->name('pages.add_brand');

    Route::post('add-brand', [BrandController::class, 'store_brand'])->name('pages.store_brand');

    Route::post('/brands', [BrandController::class, 'store_brand'])->name('pages.store_brand');

    Route::get('/edit/{id}', [BrandController::class, 'edit_brand'])->name('pages.edit_brand');
    Route::put('/brands/{id}', [BrandController::class, 'update_brand'])->name('pages.update_brand');
    Route::delete('/brands/{id}', [BrandController::class, 'destroy'])->name('pages.delete_brand');
});

// routes/web.php

Route::prefix('admin')->name('pages.')->group(function () {
    // Route to view brands
    Route::get('/brands', [BrandCategoryController::class, 'view_brands'])->name('view_brands');

    // Route to add a brand category
    Route::get('/brand/{brand}/add-brand-category', [BrandCategoryController::class, 'add_brand_category'])->name('add_brand_category');
    Route::post('/brand/{brand}/store-brand-category', [BrandCategoryController::class, 'store_brand_category'])->name('store_brand_category');

    // Route to add a subcategory
    Route::get('/brand-category/{brandCategory}/add-subcategory', [BrandCategoryController::class, 'add_subcategory'])->name('add_subcategory');
    Route::post('/brand-category/{brandCategory}/store-subcategory', [BrandCategoryController::class, 'store_subcategory'])->name('store_subcategory');


    // Route to edit the brand category
    Route::get('/edit-brand-category/{id}', [BrandCategoryController::class, 'edit'])->name('edit_brand_category');

    // Route to update the brand category
    Route::post('/update-brand-category/{id}', [BrandCategoryController::class, 'update'])->name('update_brand_category');

    Route::delete('/delete-brand-category/{id}', [BrandCategoryController::class, 'destroy'])->name('delete_brand_category');

    Route::delete('/subcategory/{subcategory}', [BrandCategoryController::class, 'destroySubcategory'])->name('destroy_subcategory');
});
