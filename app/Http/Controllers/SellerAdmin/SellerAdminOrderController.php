<?php

namespace App\Http\Controllers\SellerAdmin;

use App\Http\Controllers\Controller;
use App\Models\SellerOrder;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SellerAdminOrderController extends Controller
{
    // Show received orders for a seller
    public function receivedOrders($sellerAdminId)
    {
        // Get the logged-in seller admin's ID
        $loggedInSellerAdminId = Auth::guard('seller-admin')->user()->id;

        // Ensure the logged-in seller is accessing their own data
        if ($loggedInSellerAdminId !== (int) $sellerAdminId) {
            return redirect()->back()->with('error', 'Unauthorized access.');
        }

        // Get all orders for this seller admin
        $orders = SellerOrder::where('seller_admin_id', $sellerAdminId)->get();

        // Return the view with orders
        return view('seller-admin.orders.received', compact('orders', 'sellerAdminId'));
    }

    // View a single order's details
     // Show details of a specific order for the seller admin
     public function viewOrder($orderId, $sellerAdminId)
     {
         // Get the logged-in seller admin's ID
         $loggedInSellerAdminId = Auth::guard('seller-admin')->user()->id;

         // Ensure the logged-in seller is accessing their own data
         if ($loggedInSellerAdminId !== (int) $sellerAdminId) {
             return redirect()->back()->with('error', 'Unauthorized access.');
         }

         // Retrieve the order by its ID along with related models
         $order = SellerOrder::with(['user', 'sellerAdmin', 'address', 'product'])
                             ->where('id', $orderId)
                             ->where('seller_admin_id', $sellerAdminId)
                             ->first();

         // If the order does not exist, redirect with an error message
         if (!$order) {
             return redirect()->route('seller-admin.orders.received', ['sellerAdminId' => $sellerAdminId])
                              ->with('error', 'Order not found.');
         }

         // Return the view with the order details
         return view('seller-admin.orders.view', compact('order', 'sellerAdminId'));
     }


    public function downloadOrderInvoice($orderId, $sellerAdminId)
{
    // Get the logged-in seller admin's ID
    $loggedInSellerAdminId = Auth::guard('seller-admin')->user()->id;

    // Ensure the logged-in seller is accessing their own data
    if ($loggedInSellerAdminId !== (int) $sellerAdminId) {
        return redirect()->back()->with('error', 'Unauthorized access.');
    }

    // Retrieve the order by its ID along with related models
    $order = SellerOrder::with(['user', 'sellerAdmin', 'address', 'product'])
                         ->where('id', $orderId)
                         ->where('seller_admin_id', $sellerAdminId)
                         ->first();

    // If the order does not exist, redirect with an error message
    if (!$order) {
        return redirect()->route('seller-admin.orders.received', ['sellerAdminId' => $sellerAdminId])
                         ->with('error', 'Order not found.');
    }

    // Generate the PDF
    $pdf = Pdf::loadView('seller-admin.orders.invoice', compact('order', 'sellerAdminId'));

    // Download the generated PDF
    return $pdf->download('order_invoice_' . $order->id . '.pdf');
}
}

