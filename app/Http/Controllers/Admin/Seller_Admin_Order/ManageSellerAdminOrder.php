<?php

namespace App\Http\Controllers\Admin\Seller_Admin_Order;

use App\Http\Controllers\Controller;
use App\Models\SellerAdmin;
use App\Models\SellerOrder;
use Illuminate\Http\Request;

class ManageSellerAdminOrder extends Controller
{
     // Show all orders for all SellerAdmins
     public function showAllOrders()
     {
         // Get all SellerAdmins
         $sellerAdmins = SellerAdmin::all(); // Fetch all seller-admins

         // Fetch all orders for each SellerAdmin and group them
         $orders = [];

         foreach ($sellerAdmins as $sellerAdmin) {
             $orders[$sellerAdmin->id] = SellerOrder::where('seller_admin_id', $sellerAdmin->id)->get();
         }

         // Return the view with all orders grouped by SellerAdmin
         return view('admin.seller_admin_order.manage-seller-order', compact('sellerAdmins', 'orders'));
     }

       // Confirm an order
       public function confirmOrder($orderId)
       {
           $order = SellerOrder::find($orderId);

           if ($order) {
               // Update the order status to 'completed'
               $order->status = 'completed';
               $order->save();

               // Redirect back with success message
               return redirect()->route('admin.orders.all')->with('success', 'Order Confirmed Successfully!');
           }

           return redirect()->route('admin.orders.all')->with('error', 'Order not found!');
       }

       public function cancelOrder($orderId)
       {
           $order = SellerOrder::find($orderId);

           if ($order) {
               // Update the order status to 'canceled'
               $order->status = 'canceled';
               $order->save();

               // Redirect back with success message
               return redirect()->route('admin.orders.all')->with('success', 'Order Cancelled Successfully!');
           }

           return redirect()->route('admin.orders.all')->with('error', 'Order not found!');
       }

}
