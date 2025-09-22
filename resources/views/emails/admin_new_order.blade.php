<!DOCTYPE html>
<html>
<head>
    <title>New Order Notification</title>
</head>
<body>
    <h1>New Order Request</h1>
    <p>Hello,</p>
    <p>You have received a new order from a customer.</p>

    <h3>Order Details:</h3>
    <ul>
        <li><strong>Order ID:</strong> {{ $order->id }}</li>
        <li><strong>User:</strong> {{ $order->user->name }} ({{ $order->user->email }})</li>
        <li><strong>Product:</strong> {{ $order->product->product_name }}</li>
        <li><strong>Quantity:</strong> {{ $order->quantity }}</li>
        <li><strong>Total Price:</strong> ₹{{ $order->total_price }}</li>
        <li><strong>Payment Method:</strong> {{ $order->payment_method }}</li>
        <li><strong>Status:</strong> {{ ucfirst($order->status) }}</li>
        <li><strong>Shipping Address:</strong> {{ $order->address->address }}</li>
    </ul>

    <p>Please take the necessary actions.</p>

    <p>Regards,</p>
    <p>Your Ecommerce System</p>
</body>
</html>
