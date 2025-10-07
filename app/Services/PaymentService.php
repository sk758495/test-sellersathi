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
    
    public function createPaymentSession($orderId, $customerId, $amount)
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
        
        return $this->makeRequest('/session', $data, 'POST', 120);
    }
    
    private function makeRequest($endpoint, $data = null, $method = 'GET', $timeout = 60, $retries = 3)
    {
        $attempt = 0;
        
        while ($attempt < $retries) {
            try {
                $curl = curl_init();
                
                $curlOptions = [
                    CURLOPT_URL => $this->baseUrl . $endpoint,
                    CURLOPT_RETURNTRANSFER => true,
                    CURLOPT_TIMEOUT => $timeout,
                    CURLOPT_CONNECTTIMEOUT => 30,
                    CURLOPT_SSL_VERIFYPEER => true,
                    CURLOPT_SSL_VERIFYHOST => 2,
                    CURLOPT_FOLLOWLOCATION => true,
                    CURLOPT_MAXREDIRS => 3,
                    CURLOPT_USERAGENT => 'Laravel Payment Gateway Client',
                    CURLOPT_HTTPHEADER => [
                        'x-merchantid: ' . $this->merchantId,
                        'x-customerid: ' . $this->customerId,
                        'Content-Type: application/JSON',
                        'version: 2023-06-30',
                        'Authorization: ' . $this->authorization
                    ]
                ];
                
                if ($method === 'POST' && $data) {
                    $curlOptions[CURLOPT_POST] = true;
                    $curlOptions[CURLOPT_POSTFIELDS] = json_encode($data);
                }
                
                curl_setopt_array($curl, $curlOptions);
                
                $response = curl_exec($curl);
                $httpCode = curl_getinfo($curl, CURLINFO_HTTP_CODE);
                $curlError = curl_error($curl);
                curl_close($curl);
                
                if ($curlError) {
                    throw new Exception('cURL Error: ' . $curlError);
                }
                
                if ($httpCode === 200) {
                    return json_decode($response, true);
                }
                
                // If not successful, log and retry
                \Log::warning('Payment API request failed', [
                    'attempt' => $attempt + 1,
                    'http_code' => $httpCode,
                    'response' => $response,
                    'endpoint' => $endpoint
                ]);
                
            } catch (Exception $e) {
                \Log::error('Payment API exception', [
                    'attempt' => $attempt + 1,
                    'error' => $e->getMessage(),
                    'endpoint' => $endpoint
                ]);
            }
            
            $attempt++;
            
            if ($attempt < $retries) {
                sleep(2); // Wait 2 seconds before retry
            }
        }
        
        throw new Exception('Payment request failed after ' . $retries . ' attempts');
    }
    
    public function getOrderStatus($orderId)
    {
        return $this->makeRequest('/orders/' . $orderId, null, 'GET', 60);
    }
    
    public function validateHMAC($params)
    {
        // Implement HMAC validation if required by HDFC
        return true;
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
        
        return $this->makeRequest('/refunds', $data, 'POST', 90);
    }
}