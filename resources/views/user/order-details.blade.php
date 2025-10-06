<!DOCTYPE html>
<html lang="en">
<head>
    <title>Order Details - Gujju E Market</title>
    @include('user.head')
</head>
<body>
    @include('user.navbar')

    <section class="order-details spad">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="order-header">
                        <h2>Order Details</h2>
                        <div class="order-info">
                            <p><strong>Order Number:</strong> {{ $order->order_number }}</p>
                            <p><strong>Order Date:</strong> {{ $order->created_at->format('d M Y, h:i A') }}</p>
                            <p><strong>Payment Method:</strong> {{ $order->payment_method }}</p>
                            <p><strong>Status:</strong> 
                                <span class="status-badge status-{{ strtolower($order->order_status) }}">
                                    {{ $order->order_status }}
                                </span>
                            </p>
                        </div>
                    </div>

                    <div class="order-items">
                        <h4>Order Items</h4>
                        <div class="table-responsive">
                            <table class="table order-table">
                                <thead>
                                    <tr>
                                        <th>Product</th>
                                        <th>Price</th>
                                        <th>Quantity</th>
                                        <th>Total</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($order->orderItems as $item)
                                    <tr>
                                        <td>
                                            <div class="product-info">
                                                <img src="{{ asset('storage/' . $item->product->main_image) }}" 
                                                     alt="{{ $item->product->product_name }}" 
                                                     class="product-thumb">
                                                <div class="product-details">
                                                    <h6>{{ $item->product->product_name }}</h6>
                                                    @if($item->discount_id)
                                                        <small class="text-success">Discount Applied</small>
                                                    @endif
                                                </div>
                                            </div>
                                        </td>
                                        <td>₹{{ number_format($item->price, 2) }}</td>
                                        <td>{{ $item->quantity }}</td>
                                        <td>₹{{ number_format($item->total_price, 2) }}</td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-lg-6">
                            <div class="shipping-address">
                                <h4>Shipping Address</h4>
                                <div class="address-card">
                                    <p>{{ $order->address->address_line1 }}</p>
                                    @if($order->address->address_line2)
                                        <p>{{ $order->address->address_line2 }}</p>
                                    @endif
                                    <p>{{ $order->address->city }}, {{ $order->address->state }}</p>
                                    <p>{{ $order->address->country }} - {{ $order->address->postal_code }}</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="order-summary">
                                <h4>Order Summary</h4>
                                <div class="summary-card">
                                    <div class="summary-row">
                                        <span>Subtotal:</span>
                                        <span>₹{{ number_format($order->subtotal, 2) }}</span>
                                    </div>
                                    <div class="summary-row">
                                        <span>Shipping:</span>
                                        <span>₹{{ number_format($order->shipping_charge, 2) }}</span>
                                    </div>
                                    <div class="summary-row total">
                                        <span><strong>Total:</strong></span>
                                        <span><strong>₹{{ number_format($order->total_price, 2) }}</strong></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="order-actions">
                        <a href="{{ route('dashboard') }}" class="btn btn-primary">Continue Shopping</a>
                        @if($order->order_status === 'Pending')
                            <button class="btn btn-danger" onclick="cancelOrder({{ $order->id }})">Cancel Order</button>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </section>

    @include('user.footer')

    <style>
        .order-details {
            padding: 50px 0;
        }
        
        .order-header {
            background: #f8f9fa;
            padding: 30px;
            border-radius: 8px;
            margin-bottom: 30px;
        }
        
        .order-header h2 {
            margin-bottom: 20px;
            color: #333;
        }
        
        .order-info p {
            margin-bottom: 10px;
            font-size: 16px;
        }
        
        .status-badge {
            padding: 5px 15px;
            border-radius: 20px;
            font-size: 14px;
            font-weight: bold;
        }
        
        .status-pending {
            background: #fff3cd;
            color: #856404;
        }
        
        .status-confirmed {
            background: #d4edda;
            color: #155724;
        }
        
        .status-cancelled {
            background: #f8d7da;
            color: #721c24;
        }
        
        .order-items {
            margin-bottom: 30px;
        }
        
        .order-items h4 {
            margin-bottom: 20px;
            color: #333;
        }
        
        .order-table {
            background: white;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }
        
        .order-table th {
            background: #333;
            color: white;
            padding: 15px;
            font-weight: 600;
        }
        
        .order-table td {
            padding: 15px;
            vertical-align: middle;
            border-bottom: 1px solid #eee;
        }
        
        .product-info {
            display: flex;
            align-items: center;
        }
        
        .product-thumb {
            width: 60px;
            height: 60px;
            object-fit: cover;
            border-radius: 8px;
            margin-right: 15px;
        }
        
        .product-details h6 {
            margin: 0;
            font-size: 16px;
            color: #333;
        }
        
        .shipping-address, .order-summary {
            margin-bottom: 30px;
        }
        
        .shipping-address h4, .order-summary h4 {
            margin-bottom: 20px;
            color: #333;
        }
        
        .address-card, .summary-card {
            background: #f8f9fa;
            padding: 20px;
            border-radius: 8px;
        }
        
        .address-card p {
            margin-bottom: 5px;
            color: #666;
        }
        
        .summary-row {
            display: flex;
            justify-content: space-between;
            padding: 10px 0;
            border-bottom: 1px solid #ddd;
        }
        
        .summary-row.total {
            border-bottom: none;
            border-top: 2px solid #333;
            margin-top: 10px;
            padding-top: 15px;
            font-size: 18px;
        }
        
        .order-actions {
            text-align: center;
            padding-top: 30px;
        }
        
        .btn {
            padding: 12px 30px;
            border-radius: 5px;
            text-decoration: none;
            margin: 0 10px;
            display: inline-block;
            font-weight: 600;
            transition: all 0.3s ease;
        }
        
        .btn-primary {
            background: #333;
            color: white;
            border: 2px solid #333;
        }
        
        .btn-primary:hover {
            background: #555;
            border-color: #555;
            color: white;
            text-decoration: none;
        }
        
        .btn-danger {
            background: #dc3545;
            color: white;
            border: 2px solid #dc3545;
        }
        
        .btn-danger:hover {
            background: #c82333;
            border-color: #c82333;
        }
    </style>

    <script>
        function cancelOrder(orderId) {
            if (confirm('Are you sure you want to cancel this order?')) {
                // Add cancel order functionality here
                alert('Order cancellation functionality to be implemented');
            }
        }
    </script>
</body>
</html>