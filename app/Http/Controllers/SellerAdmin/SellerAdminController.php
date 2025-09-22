<?php

namespace App\Http\Controllers\SellerAdmin;

use App\Http\Controllers\Controller;
use App\Models\SellerAdmin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Mail;
use App\Mail\SellerAdminOtpMail;
use App\Models\Product;
use App\Models\SellerOrder;
use App\Models\SellerProduct;
use Illuminate\Support\Facades\Auth;

class SellerAdminController extends Controller
{
    // Dashboard Method to show products and count
    public function dashboard($sellerAdminId)
{
    // Get the logged-in seller admin's ID
    $loggedInSellerAdminId = Auth::guard('seller-admin')->id();

    // Check if the logged-in user is trying to access their own data
    if ($loggedInSellerAdminId !== (int) $sellerAdminId) {
        return redirect()->route('seller-admin.login')->with('error', 'Unauthorized access.');
    }

    // Find the seller admin by their ID
    $sellerAdmin = SellerAdmin::findOrFail($sellerAdminId);

    // Fetch products related to the seller admin
    $products = SellerProduct::where('seller_admin_id', $sellerAdminId)->get();
    $productsCount = $products->count();

   // Fetch the number of pending orders (assuming `SellerOrder` model and `status` field)
   $pendingOrdersCount = SellerOrder::where('seller_admin_id', $sellerAdminId)
   ->where('status', 'pending')
   ->count();

    // Fetch completed orders and their total price
    $completedOrders = SellerOrder::where('seller_admin_id', $sellerAdminId)
    ->where('status', 'completed')
    ->get();
    $completedOrdersCount = $completedOrders->count();
    $totalCompletedAmount = $completedOrders->sum('total_price'); // Assuming 'total_price' is the field for order price

    // Fetch canceled orders and their total price
    $canceledOrders = SellerOrder::where('seller_admin_id', $sellerAdminId)
    ->where('status', 'canceled')
    ->get();
    $canceledOrdersCount = $canceledOrders->count();
    $totalCanceledAmount = $canceledOrders->sum('total_price'); // Assuming 'total_price' is the field for order price

    // Pass the data to the view
    return view('seller-admin.dashboard', compact('products', 'productsCount', 'sellerAdmin', 'pendingOrdersCount', 'completedOrdersCount', 'totalCompletedAmount', 'canceledOrdersCount', 'totalCanceledAmount'));
}


     // Show the form to create a new seller admin
     public function create()
     {
         return view('seller-admin.create');
     }

     // Store a new seller admin
     public function store(Request $request)
     {
         $request->validate([
             'name' => 'required|string|max:255',
             'email' => 'required|email|unique:seller_admins,email',
             'password' => 'required|string|min:8|confirmed',
         ]);

         // Create the seller admin without OTP-related fields
         $sellerAdmin = SellerAdmin::create([
             'name' => $request->name,
             'email' => $request->email,
             'password' => Hash::make($request->password),
         ]);

         // Generate OTP and expiration time
         $otp = rand(100000, 999999); // Generate a 6-digit OTP
         $expiresAt = now()->addMinutes(10); // OTP expires in 10 minutes

         // Store OTP and expiration time in the session
         Session::put('otp', $otp);
         Session::put('otp_expires_at', $expiresAt);

         // Send OTP via email
         Mail::to($sellerAdmin->email)->send(new SellerAdminOtpMail($otp));

         // Redirect to OTP verification page
         return redirect()->route('seller-admin.verify', ['id' => $sellerAdmin->id]);
     }

     // Method to display OTP form
public function showOtpForm($id)
{
    // Find the seller admin by ID
    $sellerAdmin = SellerAdmin::findOrFail($id);

    return view('seller-admin.verify', compact('sellerAdmin'));
}


// Method to verify OTP
public function verifyOtp(Request $request, $id)
{
    $request->validate([
        'otp' => 'required|numeric|digits:6',
    ]);

    // Retrieve OTP and expiration time from session
    $storedOtp = Session::get('otp');
    $otpExpiry = Session::get('otp_expires_at');

    // Check if OTP has expired or is invalid
    if (!$storedOtp || now()->gt($otpExpiry)) {
        Session::forget(['otp', 'otp_expires_at']); // Clear expired OTP
        return back()->with('error', 'OTP has expired. Please request a new one.');
    }

    // Check if the provided OTP matches the stored OTP
    if ($request->otp == $storedOtp) {
        // OTP is valid, mark email as verified
        $sellerAdmin = SellerAdmin::findOrFail($id);
        $sellerAdmin->email_verified_at = now();
        $sellerAdmin->save();

        // Log the seller admin in
        Auth::guard('seller-admin')->login($sellerAdmin);
        // Clear OTP from session after successful verification
        Session::forget(['otp', 'otp_expires_at']);

        return redirect()->route('seller-admin.dashboard', ['sellerAdminId' => $sellerAdmin->id])->with('success', 'Email verified successfully!');
    }

    return back()->with('error', 'Invalid OTP. Please try again.');
}



     // Show the form to edit an existing seller admin
     public function edit($id)
     {
         $sellerAdmin = SellerAdmin::findOrFail($id);
         return view('seller-admin.edit', compact('sellerAdmin'));
     }

     // Update an existing seller admin
     public function update(Request $request, $id)
     {
         $request->validate([
             'name' => 'required|string|max:255',
             'email' => 'required|email|unique:seller_admins,email,' . $id,
             'password' => 'nullable|string|min:8|confirmed',
         ]);

         $sellerAdmin = SellerAdmin::findOrFail($id);
         $sellerAdmin->name = $request->name;
         $sellerAdmin->email = $request->email;

         if ($request->filled('password')) {
             $sellerAdmin->password = Hash::make($request->password); // Update password only if provided
         }

         $sellerAdmin->save();

         return redirect()->route('seller-admin.dashboard')->with('success', 'Seller Admin updated successfully!');
     }

     // Delete a seller admin
     public function destroy($id)
     {
         $sellerAdmin = SellerAdmin::findOrFail($id);
         $sellerAdmin->delete();

         return redirect()->route('seller-admin.index')->with('success', 'Seller Admin deleted successfully!');
     }
}
