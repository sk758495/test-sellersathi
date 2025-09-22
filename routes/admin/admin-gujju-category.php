<?php

use App\Http\Controllers\Admin\GujjuCategory\GujjuCategoryController;
use Illuminate\Support\Facades\Route;



Route::prefix('gujjucategory')->middleware('auth:admin')->group(function () {

Route::get('view_gujjucategory', [GujjuCategoryController::class, 'view_gujjucategory'])->name('gujjucategory.view_gujjucategory');

Route::get('add-brand', [GujjuCategoryController::class, 'add_brand'])->name('gujjucategory.add_gujjucategory');

Route::post('add-brand', [GujjuCategoryController::class, 'store_brand'])->name('gujjucategory.store_gujjucategory');

// Route::post('/brands', [GujjuCategoryController::class, 'store_brand'])->name('pages.store_brand');

Route::get('/edit/gujjucategory/{id}', [GujjuCategoryController::class, 'edit_brand'])->name('gujju-category.view_edit_category');
Route::put('/updqate-gujju-category/{id}', [GujjuCategoryController::class, 'update_brand'])->name('gujju-category.update_category');
Route::delete('/gujju-category/{id}', [GujjuCategoryController::class, 'destroy'])->name('gujjucategory.delete_gujjucategory');

});

