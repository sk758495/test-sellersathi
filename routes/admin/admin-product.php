<?php

use App\Http\Controllers\ProductController;
use Illuminate\Support\Facades\Route;



Route::prefix('admin')->middleware('auth:admin')->group(function () {

    Route::get('products/create', [ProductController::class, 'create'])->name('admin.products.create');
    Route::post('products', [ProductController::class, 'store'])->name('admin.products.store');

    Route::get('get-brand-categories/{brandId}', [ProductController::class, 'getBrandCategories']);
    Route::get('get-subcategories/{brandCategoryId}', [ProductController::class, 'getSubcategories']);


    Route::get('products/view_product', [ProductController::class, 'view_all_products'])->name('admin.products.view_product');

    Route::get('products/view_product_details/{id}', [ProductController::class, 'view_product_details'])->name('admin.products.view_product_details');


    Route::get('products/edit_product/{id}', [ProductController::class, 'edit_product'])->name('admin.products.edit_product');


    Route::put('products/update-product/{id}', [ProductController::class, 'update'])->name('admin.products.update');

    // Delete Product Route
    Route::delete('products/{id}', [ProductController::class, 'destroy'])->name('admin.products.destroy');

    Route::get('/admin/products/export/filter', [ProductController::class, 'exportFilter'])->name('admin.products.export.filter');
    Route::get('/admin/products/export', [ProductController::class, 'export'])->name('admin.products.export');

    Route::get('admin/products/import', [ProductController::class, 'showImportForm'])->name('products.import.form');
    Route::post('admin/products/import', [ProductController::class, 'import'])->name('products.import');
});
