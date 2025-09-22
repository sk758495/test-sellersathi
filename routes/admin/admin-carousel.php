<?php

use App\Http\Controllers\Admin\Carousel\CarouselController;
use App\Http\Controllers\Admin\Pages\BrandCategoryController;
use App\Http\Controllers\Admin\Pages\BrandController;
use Illuminate\Support\Facades\Route;



Route::prefix('admin')->middleware('auth:admin')->group(function () {

    Route::get('carousel', [CarouselController::class, 'carousel_view'])->name('carousel.carousel_view');
    Route::post('carousel', [CarouselController::class, 'save_carousel_images'])->name('carousel.save_carousel_images');
    Route::get('carousel/edit/{id}', [CarouselController::class, 'edit_carousel_image'])->name('admin.carousel.edit'); // Edit route
    Route::put('carousel/update/{id}', [CarouselController::class, 'update_carousel_image'])->name('admin.carousel.update');
    Route::delete('carousel/delete/{id}', [CarouselController::class, 'delete_carousel_image'])->name('admin.carousel.delete');


});


