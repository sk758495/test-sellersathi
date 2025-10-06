<div class="order-details-modal">
    <div class="row mb-3">
        <div class="col-md-6">
            <h6><strong>Order Information</strong></h6>
            <p><strong>Order Number:</strong> {{ $order->order_number ?? $order->order_id ?? 'ORD-'.$order->id }}</p>
            <p><strong>Order Date:</strong> {{ $order->created_at->format('d M Y, h:i A') }}</p>
            <p><strong>Payment Method:</strong> {{ $order->payment_method }}</p>
            <p><strong>Status:</strong> 
                <span class="badge 
                    @if($order->order_status == 'Pending') bg-warning
                    @elseif($order->order_status == 'Confirmed') bg-success
                    @else bg-danger
                    @endif">
                    {{ $order->order_status }}
                </span>
            </p>
            @if($order->transaction_id)
                <p><strong>Transaction ID:</strong> {{ $order->transaction_id }}</p>
            @endif
        </div>
        <div class="col-md-6">
            <h6><strong>Customer Information</strong></h6>
            @if($order->user)
                <p><strong>Name:</strong> {{ $order->user->name }}</p>
                <p><strong>Email:</strong> {{ $order->user->email }}</p>
                <p><strong>Phone:</strong> {{ $order->user->phone ?? 'N/A' }}</p>
            @else
                <p class="text-muted">Customer information not available</p>
            @endif
        </div>
    </div>

    <div class="row mb-3">
        <div class="col-12">
            <h6><strong>Shipping Address</strong></h6>
            @if($order->address)
                <div class="card">
                    <div class="card-body">
                        <p class="mb-1">{{ $order->address->address_line1 }}</p>
                        @if($order->address->address_line2)
                            <p class="mb-1">{{ $order->address->address_line2 }}</p>
                        @endif
                        <p class="mb-1">{{ $order->address->city }}, {{ $order->address->state }}</p>
                        <p class="mb-0">{{ $order->address->country }} - {{ $order->address->postal_code }}</p>
                    </div>
                </div>
            @else
                <p class="text-muted">Address not available</p>
            @endif
        </div>
    </div>

    <div class="row mb-3">
        <div class="col-12">
            <h6><strong>Order Items</strong></h6>
            @if($order->orderItems && $order->orderItems->count() > 0)
                <div class="table-responsive">
                    <table class="table table-sm table-bordered">
                        <thead class="table-light">
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
                                    <div class="d-flex align-items-center">
                                        @if($item->product && $item->product->main_image)
                                            <img src="{{ asset('storage/' . $item->product->main_image) }}" 
                                                 alt="{{ $item->product->product_name }}" 
                                                 class="me-2" 
                                                 style="width: 40px; height: 40px; object-fit: cover; border-radius: 4px;">
                                        @endif
                                        <div>
                                            <strong>{{ $item->product ? $item->product->product_name : 'Product N/A' }}</strong>
                                            @if($item->discount_id)
                                                <br><small class="text-success">Discount Applied</small>
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
            @else
                <p class="text-muted">No items found for this order</p>
            @endif
        </div>
    </div>

    <div class="row">
        <div class="col-md-6 offset-md-6">
            <div class="card">
                <div class="card-body">
                    <h6><strong>Order Summary</strong></h6>
                    <div class="d-flex justify-content-between">
                        <span>Subtotal:</span>
                        <span>₹{{ number_format($order->subtotal ?? 0, 2) }}</span>
                    </div>
                    <div class="d-flex justify-content-between">
                        <span>Shipping:</span>
                        <span>₹{{ number_format($order->shipping_charge ?? 0, 2) }}</span>
                    </div>
                    <hr>
                    <div class="d-flex justify-content-between">
                        <strong>Total:</strong>
                        <strong>₹{{ number_format($order->total_price, 2) }}</strong>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>