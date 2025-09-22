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

    <h1>Your Order Has Been Received</h1>

    <p>Dear {{ $user->name }},</p>

    @if($order)
        <p>Your order has been successfully placed. Below are the details:</p>
        <ul>
            <li><strong>Order ID:</strong> {{ $order->id }}</li>
            <li><strong>Product:</strong> {{ $order->product->product_name }}</li>
            <li><strong>Quantity:</strong> {{ $order->quantity }}</li>
            <li><strong>Total Price:</strong> {{ $order->total_price }}</li>
        </ul>
    @elseif($cartItem)
        <p>Your cart item has been successfully added to the order. Here are the details:</p>
        <ul>
            <li><strong>Product:</strong> {{ $cartItem->product->product_name }}</li>
            <li><strong>Quantity:</strong> {{ $cartItem->quantity }}</li>
            <li><strong>Estimated Total Price:</strong> {{ $cartItem->quantity * $cartItem->product->price }}</li>
        </ul>
    @else
        <p>No order details found.</p>
    @endif

    <p>Thank you for shopping with us!</p>

    <p>Best regards,</p>
    <p>{{ $sellerAdmin->name }}'s Shop</p>
        <!-- Footer -->
        <div class="footer">
            <p>If you have any questions, feel free to contact us at <strong>support@gujjumarket.com</strong></p>
            <p>Gujju e-Market | All rights reserved</p>
        </div>
    </div>
</body>
</html>
