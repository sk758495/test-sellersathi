<?php

namespace App\Http\Controllers\SellerAdmin;

use App\Http\Controllers\Controller;
use App\Models\SellerAdminBankDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class SellerAdminBankDetailController extends Controller
{
    public function showBankDetails($sellerAdminId)
    {
        // Ensure the logged-in seller is trying to access their own data
        $loggedInSellerAdminId = Auth::guard('seller-admin')->user()->id;
        if ($loggedInSellerAdminId !== (int)$sellerAdminId) {
            return redirect()->back()->with('error', 'Unauthorized access.');
        }

        // Get the bank details of the seller if exists, else pass an empty object
        $bankDetails = SellerAdminBankDetail::where('seller_admin_id', $sellerAdminId)->first();

        return view('seller-admin.bank-details.edit', compact('bankDetails', 'sellerAdminId'));
    }

    public function storeBankDetails(Request $request, $sellerAdminId)
    {
        // Validate the request
        $request->validate([
            'account_name' => 'required|string|max:255',
            'account_number' => 'required|string|max:20',
            'ifsc_code' => 'required|string|max:20',
            'bank_name' => 'required|string|max:255',
            'branch_name' => 'required|string|max:255',
            'phone' => 'required|string|max:10',
            'upi_id' => 'required|string|max:255', // UPI ID validation
        ]);

        // Ensure the logged-in seller is trying to access their own data
        $loggedInSellerAdminId = Auth::guard('seller-admin')->user()->id;
        if ($loggedInSellerAdminId !== (int)$sellerAdminId) {
            return redirect()->back()->with('error', 'Unauthorized access.');
        }

        // If bank details already exist, update them, otherwise create new ones
        SellerAdminBankDetail::updateOrCreate(
            ['seller_admin_id' => $sellerAdminId],
            [
                'account_name' => $request->account_name,
                'account_number' => $request->account_number,
                'ifsc_code' => $request->ifsc_code,
                'bank_name' => $request->bank_name,
                'branch_name' => $request->branch_name,
                'upi_id' => $request->upi_id,
                'phone' => $request->phone,

            ]
        );

        // Redirect to the dashboard with a success message
        return redirect()->route('seller-admin.dashboard', ['sellerAdminId' => $sellerAdminId])
                         ->with('success', 'Bank details updated successfully.');
    }
   
}
