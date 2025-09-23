<?php

namespace App\Http\Controllers\User\Order;

use App\Http\Controllers\Controller;
use App\Models\BrandCategory;
use App\Models\Order;
use App\Models\Cart;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Cache;
use App\Mail\OrderPlaced;

class OrderStatusController extends Controller
{
    public function order_status()
    {
        // Fetch the orders for the authenticated user with address and product relationships
        $orders = Order::with(['address', 'product'])
                      ->where('user_id', auth()->user()->id)
                      ->latest()
                      ->get();
        $brand_categories = BrandCategory::with('images')->take(6)->get();
        
        // Get HDFC payment status for each order
        foreach ($orders as $order) {
            if ($order->payment_method === 'hdfc' && $order->order_id) {
                $order->hdfc_status = $this->getHdfcOrderStatus($order->order_id);
            }
        }

        return view('user.order.order-status', compact('orders', 'brand_categories'));
    }
    
    private function getHdfcOrderStatus($orderId)
    {
        $curl = curl_init();
        curl_setopt_array($curl, [
            CURLOPT_URL => 'https://smartgatewayuat.hdfcbank.com/orders/' . $orderId,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_HTTPGET => true,
            CURLOPT_HTTPHEADER => [
                'x-merchantid: SG3589',
                'x-customerid: 325345',
                'Content-Type: application/x-www-form-urlencoded',
                'Authorization: Basic RUMyODVFNzc5MkY0Mzk1QkVCRjAyNkQyQjQ4OTkxOg=='
            ]
        ]);
        
        $response = curl_exec($curl);
        $httpCode = curl_getinfo($curl, CURLINFO_HTTP_CODE);
        curl_close($curl);
        
        if ($httpCode === 200) {
            return json_decode($response, true);
        }
        
        return null;
    }
}
