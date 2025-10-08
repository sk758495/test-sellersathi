<?php

namespace App\Services;

use Exception;

class PaymentService
{
    private $merchantId;
    private $customerId;
    private $authorization;
    private $baseUrl;
    
    public function __construct()
    {
        $this->merchantId = 'SG3589';
        $this->customerId = '325345';
        $this->authorization = 'Basic RUMyODVFNzc5MkY0Mzk1QkVCRjAyNkQyQjQ4OTkxOg==';
        $this->baseUrl = 'https://smartgatewayuat.hdfcbank.com';
    }
    
    public function createPaymentSession($orderId, $customerId, $amount, $customerEmail = null, $customerPhone = null, $firstName = null, $lastName = null)
    {
        $data = [
            "order_id" => $orderId,
            "amount" => number_format($amount, 1, '.', ''),
            "currency" => "INR",
            "customer_id" => $customerId,
            "payment_page_client_id" => "hdfcmaster",
            "action" => "paymentPage",
            "return_url" => route('hdfc.user.callback'),
            "description" => "Complete your payment"
        ];
        
        if ($customerEmail) $data['customer_email'] = $customerEmail;
        if ($customerPhone) $data['customer_phone'] = $customerPhone;
        if ($firstName) $data['first_name'] = $firstName;
        if ($lastName) $data['last_name'] = $lastName;
        
        $curl = curl_init();
        curl_setopt_array($curl, [
            CURLOPT_URL => $this->baseUrl . '/session',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_POST => true,
            CURLOPT_POSTFIELDS => json_encode($data),
            CURLOPT_HTTPHEADER => [
                'x-merchantid: ' . $this->merchantId,
                'x-customerid: ' . $customerId,
                'Content-Type: application/JSON',
                'version: 2023-06-30',
                'Authorization: ' . $this->authorization
            ]
        ]);
        
        $response = curl_exec($curl);
        $httpCode = curl_getinfo($curl, CURLINFO_HTTP_CODE);
        curl_close($curl);
        
        if ($httpCode !== 200) {
            throw new Exception('Payment session creation failed: ' . $response);
        }
        
        return json_decode($response, true);
    }
    
    public function getOrderStatus($orderId)
    {
        $curl = curl_init();
        curl_setopt_array($curl, [
            CURLOPT_URL => $this->baseUrl . '/orders/' . $orderId,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_HTTPGET => true,
            CURLOPT_HTTPHEADER => [
                'x-merchantid: ' . $this->merchantId,
                'x-customerid: ' . $this->customerId,
                'Content-Type: application/x-www-form-urlencoded',
                'Authorization: ' . $this->authorization
            ]
        ]);
        
        $response = curl_exec($curl);
        $httpCode = curl_getinfo($curl, CURLINFO_HTTP_CODE);
        curl_close($curl);
        
        if ($httpCode !== 200) {
            throw new Exception('Order status check failed: ' . $response);
        }
        
        return json_decode($response, true);
    }
    
    public function validateHMAC($params)
    {
        // Add proper HMAC validation based on HDFC documentation
        // For now, basic validation
        return isset($params['order_id']) && isset($params['status']);
    }
    
    public function getStatusMessage($order)
    {
        $message = "Your order with order_id " . $order["order_id"] . " and amount " . $order["amount"] . " has the following status: ";
        $status = $order["status"];

        switch ($status) {
            case "CHARGED":
                return $message . "order payment done successfully";
            case "PENDING":
            case "PENDING_VBV":
                return $message . "order payment pending";
            case "AUTHORIZATION_FAILED":
                return $message . "order payment authorization failed";
            case "AUTHENTICATION_FAILED":
                return $message . "order payment authentication failed";
            default:
                return $message . "order status " . $status;
        }
    }
    
    public function processRefund($orderId, $amount, $uniqueRequestId)
    {
        $data = [
            "order_id" => $orderId,
            "amount" => $amount,
            "unique_request_id" => $uniqueRequestId
        ];
        
        $curl = curl_init();
        curl_setopt_array($curl, [
            CURLOPT_URL => $this->baseUrl . '/refunds',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_POST => true,
            CURLOPT_POSTFIELDS => json_encode($data),
            CURLOPT_HTTPHEADER => [
                'x-merchantid: ' . $this->merchantId,
                'x-customerid: ' . $this->customerId,
                'Content-Type: application/JSON',
                'Authorization: ' . $this->authorization
            ]
        ]);
        
        $response = curl_exec($curl);
        $httpCode = curl_getinfo($curl, CURLINFO_HTTP_CODE);
        curl_close($curl);
        
        if ($httpCode !== 200) {
            throw new Exception('Refund processing failed: ' . $response);
        }
        
        return json_decode($response, true);
    }
}