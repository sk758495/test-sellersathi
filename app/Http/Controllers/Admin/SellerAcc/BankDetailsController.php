<?php

namespace App\Http\Controllers\Admin\SellerAcc;

use App\Http\Controllers\Controller;
use App\Models\SellerAdminBankDetail;
use Illuminate\Http\Request;

class BankDetailsController extends Controller
{
    public function index()
    {
        $bankDetails = SellerAdminBankDetail::all();
        return view('admin.Seller-Admins-Bank-Details.index', compact('bankDetails'));
    }
    public function show($id)
    {
        // Get specific bank details of a seller admin
        $bankDetails = SellerAdminBankDetail::find($id);

        if (!$bankDetails) {
            return redirect()->route('admin.seller-accounts.index')->with('error', 'Bank details not found.');
        }

        // Get the related seller admin's name (assuming there's a relationship)
        $sellerAdmin = $bankDetails->sellerAdmin; // Assuming 'sellerAdmin' is the relationship name

        return view('admin.Seller-Admins-Bank-Details.show', compact('bankDetails', 'sellerAdmin'));
    }
}
