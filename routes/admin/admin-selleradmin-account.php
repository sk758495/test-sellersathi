<?php


use App\Http\Controllers\admin\pages\CategoryController;
use App\Http\Controllers\Admin\Seller_Admin_Order\ManageSellerAdminOrder;
use App\Http\Controllers\Admin\SellerAcc\BankDetailsController;
use App\Http\Controllers\Admin\SellerAcc\ManageController;
use Illuminate\Support\Facades\Route;



Route::prefix('admin')->middleware('auth:admin')->group(function () {

    Route::get('seller-account-manage', [ManageController::class, 'index'])->name('admin-seller-index');
    Route::delete('/destroy/{id}', [ManageController::class, 'destroy'])->name('selleradmin-destroy'); // Delete seller admin

// fetch bank details
    Route::get('seller-accounts', [BankDetailsController::class, 'index'])->name('admin.seller-accounts.index');
    Route::get('seller-accounts/{id}', [BankDetailsController::class, 'show'])->name('admin.seller-accounts.show');

});
