<!DOCTYPE html>
<html>
<head>
    <title>Payment Success</title>
    <style>
        body { 
            font-family: Arial, sans-serif; 
            background: linear-gradient(135deg, #4CAF50, #45a049);
            margin: 0;
            padding: 20px;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .success-container {
            background: white;
            padding: 40px;
            border-radius: 15px;
            text-align: center;
            box-shadow: 0 10px 30px rgba(0,0,0,0.2);
            max-width: 500px;
            width: 100%;
        }
        .success-icon {
            font-size: 60px;
            color: #4CAF50;
            margin-bottom: 20px;
        }
        .success-title {
            font-size: 28px;
            color: #333;
            margin-bottom: 15px;
            font-weight: bold;
        }
        .success-message {
            font-size: 16px;
            color: #666;
            margin-bottom: 30px;
            line-height: 1.5;
        }
        .order-details {
            background: #f8f9fa;
            padding: 20px;
            border-radius: 10px;
            margin: 20px 0;
            text-align: left;
        }
        .btn {
            background: #F4631E;
            color: white;
            padding: 12px 30px;
            border: none;
            border-radius: 25px;
            font-size: 16px;
            text-decoration: none;
            display: inline-block;
            margin: 10px;
            transition: all 0.3s ease;
        }
        .btn:hover {
            background: #e55a1a;
            transform: translateY(-2px);
        }
    </style>
</head>
<body>
    <div class="success-container">
        <div class="success-icon">✅</div>
        <h1 class="success-title">Payment Successful!</h1>
        <p class="success-message">
            Thank you for your payment. Your transaction has been completed successfully.
        </p>
        
        @if(isset($order))
        <div class="order-details">
            <strong>Order ID:</strong> {{ $order['order_id'] }}<br>
            <strong>Amount:</strong> ₹{{ $order['amount'] }}<br>
            <strong>Status:</strong> {{ $order['status'] }}<br>
            <strong>Payment Method:</strong> {{ $order['payment_method_type'] ?? 'HDFC Gateway' }}
        </div>
        @endif
        
        <div>
            <a href="{{ route('dashboard') }}" class="btn">Continue Shopping</a>
            <a href="{{ route('user.cart') }}" class="btn">View Cart</a>
        </div>
    </div>
</body>
</html>