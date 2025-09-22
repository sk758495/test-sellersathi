<?php

use App\Http\Controllers\SellerAdmin\SellerAdminBankDetailController;
use Illuminate\Support\Facades\Route;

Route::prefix('seller-admin')->middleware('auth:seller-admin')->group(function () {
    // Route to view and edit bank details
    Route::get('bank-details/{sellerAdminId}', [SellerAdminBankDetailController::class, 'showBankDetails'])->name('seller-admin.bank-details');

    // Route to store/update bank details
    Route::post('bank-details/{sellerAdminId}/save', [SellerAdminBankDetailController::class, 'storeBankDetails'])->name('seller-admin.bank-details.save');
});
