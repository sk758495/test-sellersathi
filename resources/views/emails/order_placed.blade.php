<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order Confirmation</title>
    <style>
        /* General email styles */
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
            color: #333;
        }

        .email-container {
            width: 100%;
            max-width: 600px;
            margin: 0 auto;
            background-color: #fff;
            border-radius: 8px;
            padding: 20px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .email-header {
            text-align: center;
            margin-bottom: 30px;
        }

        .email-header img {
            max-width: 150px;
            margin: 0 auto;
        }

        h1 {
            color: #2c3e50;
            font-size: 24px;
            text-align: center;
            margin-bottom: 10px;
        }

        p {
            font-size: 16px;
            line-height: 1.5;
            margin-bottom: 20px;
        }

        h3 {
            color: #2c3e50;
            font-size: 20px;
            margin-bottom: 10px;
        }

        ul {
            padding: 0;
            list-style-type: none;
            margin: 0;
        }

        ul li {
            background-color: #f9f9f9;
            border-radius: 5px;
            margin-bottom: 15px;
            padding: 15px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        ul li strong {
            color: #34495e;
        }

        .total-amount {
            font-size: 18px;
            font-weight: bold;
            color: #e74c3c;
            margin-top: 20px;
        }

        .footer {
            text-align: center;
            margin-top: 30px;
            font-size: 14px;
            color: #7f8c8d;
        }

        .footer p {
            margin: 5px 0;
        }

        /* Responsive Design */
        @media only screen and (max-width: 600px) {
            .email-container {
                padding: 15px;
            }

            h1 {
                font-size: 20px;
            }

            h3 {
                font-size: 18px;
            }

            .total-amount {
                font-size: 16px;
            }

            ul li {
                padding: 10px;
            }
        }
    </style>
</head>
<body>
    <div class="email-container">
        <!-- Header with logo -->
        <div class="email-header">
            <img src="{{ asset('https://gujjuemarket.com/user/images/gujju-logo.jpg') }}" alt="Gujju e-Market Logo">
        </div>

        <!-- Main content -->
        <h1>Thank you for your order, {{ $order->user->name }}!</h1>
        <p>We have successfully received your order. We will notify you once your order has been confirmed and processed.</p>

        <h3>Order Details:</h3>
        <ul>
            @if(is_array($cartItems) || $cartItems instanceof \Illuminate\Support\Collection)
                @foreach ($cartItems as $cartItem)
                    @php
                        // Handle both array and object formats
                        if (is_array($cartItem)) {
                            $product = \App\Models\Product::find($cartItem['product_id']);
                            $quantity = $cartItem['quantity'];
                        } else {
                            $product = $cartItem->product;
                            $quantity = $cartItem->quantity;
                        }
                    @endphp
                    @if($product)
                        <li>
                            <strong>Product:</strong> {{ $product->product_name }}<br>
                            <strong>SKU:</strong> {{ $product->sku }}<br>
                            <strong>Price:</strong> ₹{{ number_format($product->discount_price, 2) }}<br>
                            <strong>Quantity:</strong> {{ $quantity }}<br>
                            <strong>Total:</strong> ₹{{ number_format($product->discount_price * $quantity, 2) }}<br>
                        </li>
                    @endif
                @endforeach
            @else
                <li>
                    <strong>Product:</strong> {{ $order->product->product_name }}<br>
                    <strong>SKU:</strong> {{ $order->product->sku }}<br>
                    <strong>Price:</strong> ₹{{ number_format($order->product->discount_price, 2) }}<br>
                    <strong>Quantity:</strong> {{ $order->quantity }}<br>
                    <strong>Total:</strong> ₹{{ number_format($order->total_price, 2) }}<br>
                </li>
            @endif
        </ul>

        <hr>

        <p class="total-amount"><strong>Total Amount:</strong> ₹{{ $order->total_price }}</p>

        <p>Thank you for shopping with us! We appreciate your business and will keep you updated on your order status.</p>

        <!-- Footer -->
        <div class="footer">
            <p>If you have any questions, feel free to contact us at <strong>support@gujjumarket.com</strong></p>
            <p>Gujju e-Market | All rights reserved</p>
        </div>
    </div>
</body>
</html>
