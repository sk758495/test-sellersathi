<?php

namespace App\Http\Controllers\SellerUser;

use App\Http\Controllers\Controller;
use App\Models\SellerOrder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SellerOrderController extends Controller
{
    public function trackOrder($sellerAdminId)
    {
        // Fetch orders for the authenticated user and the selected seller (sellerAdminId)
        $orders = SellerOrder::where('user_id', Auth::id()) // Orders for the authenticated user
                             ->where('seller_admin_id', $sellerAdminId) // Orders for the selected seller (sellerAdminId)
                             ->with('product', 'address') // Eager load product and address relationships
                             ->get();

        // Pass the orders and sellerAdminId to the view
        return view('seller-user.order-status', compact('orders', 'sellerAdminId'));
    }
}
