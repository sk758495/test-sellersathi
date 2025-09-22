<?php


use App\Http\Controllers\admin\pages\CategoryController;
use Illuminate\Support\Facades\Route;



Route::prefix('admin')->middleware('auth:admin')->group(function () {

    Route::get('/categories', [CategoryController::class, 'index'])->name('categories.index');
    Route::get('/categories/create', [CategoryController::class, 'create'])->name('categories.create');
    Route::post('/categories', [CategoryController::class, 'store'])->name('categories.store');



    Route::get('/categories/{id}/edit', [CategoryController::class, 'edit'])->name('categories.edit'); // Edit route
    Route::put('/categories/{id}', [CategoryController::class, 'update'])->name('categories.update');
    Route::delete('/categories/{id}', [CategoryController::class, 'destroy'])->name('categories.destroy');

    Route::get('/categories/{id}/edit_child', [CategoryController::class, 'edit_child'])->name('categories.edit_child');
    Route::put('/categories/{id}', [CategoryController::class, 'update_child'])->name('categories.update_child');
    Route::delete('/categories/child/{id}', [CategoryController::class, 'destroyChild'])->name('categories.destroy_child');

    
});
