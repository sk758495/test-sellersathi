<?php

namespace App\Http\Controllers;

use App\Services\PaymentService;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Exception;

class PaymentController extends Controller
{
    private $paymentService;
    
    public function __construct(PaymentService $paymentService)
    {
        $this->paymentService = $paymentService;
    }
    
    public function initiatePayment(Request $request)
    {
        $request->validate([
            'amount' => 'required|numeric|min:1',
            'customer_id' => 'required|string',
            'order_id' => 'nullable|string'
        ]);
        
        $orderId = $request->order_id ?: 'laravel_' . Str::random(10);
        $customerId = $request->customer_id;
        $amount = $request->amount;
        
        try {
            $session = $this->paymentService->createPaymentSession($orderId, $customerId, $amount);
            $redirectUrl = $session["payment_links"]["web"];
            
            return redirect($redirectUrl);
        } catch (Exception $e) {
            return back()->with('error', 'Payment initiation failed: ' . $e->getMessage());
        }
    }
    
    public function handleCallback(Request $request)
    {
        $params = $request->method() === 'POST' ? $request->all() : $request->query();
        
        if (!isset($params['order_id'])) {
            return response()->json(['error' => 'Required Parameter Order Id is missing'], 400);
        }
        
        try {
            // Validate HMAC if status is not NEW
            if ($params["status"] != "NEW" && !$this->paymentService->validateHMAC($params)) {
                throw new Exception("Signature verification failed");
            }
            
            $order = $this->paymentService->getOrderStatus($params['order_id']);
            $message = $this->paymentService->getStatusMessage($order);
            
            return view('payment.callback', compact('message', 'params', 'order'));
        } catch (Exception $e) {
            return view('payment.error', ['error' => $e->getMessage()]);
        }
    }
    
    public function processRefund(Request $request)
    {
        $request->validate([
            'order_id' => 'required|string',
            'amount' => 'required|numeric|min:0.01',
            'unique_request_id' => 'required|string'
        ]);
        
        try {
            $refund = $this->paymentService->processRefund(
                $request->order_id,
                $request->amount,
                $request->unique_request_id
            );
            
            return view('payment.refund', compact('refund'));
        } catch (Exception $e) {
            return response()->json([
                'error' => 'Refund processing failed',
                'message' => $e->getMessage()
            ], 500);
        }
    }
    
    public function getOrderStatus($orderId)
    {
        try {
            $order = $this->paymentService->getOrderStatus($orderId);
            return response()->json($order);
        } catch (Exception $e) {
            return response()->json([
                'error' => 'Failed to get order status',
                'message' => $e->getMessage()
            ], 500);
        }
    }
}