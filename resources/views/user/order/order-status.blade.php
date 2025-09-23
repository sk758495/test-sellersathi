<!DOCTYPE html>
<html lang="en">

<head>
   
    <title>Gujju E Market</title>

    @include('user.head')
    
</head>

<body>

    @include('user.navbar')

    <!-- Body Section -->

    <style>
        .page-title {
            background: #F4631E;
            color: white;
            padding: 30px 0;
            margin-bottom: 30px;
        }
        .order-item {
            background: white;
            border: 1px solid #e9ecef;
            border-radius: 12px;
            margin-bottom: 25px;
            padding: 0;
            box-shadow: 0 4px 15px rgba(0,0,0,0.08);
            transition: all 0.3s ease;
            overflow: hidden;
        }
        .order-item:hover {
            transform: translateY(-3px);
            box-shadow: 0 8px 25px rgba(0,0,0,0.15);
        }
        .order-header {
            background: #f8f9fa;
            padding: 20px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            border-bottom: 1px solid #e9ecef;
        }
        .order-id {
            font-weight: 600;
            color: #F4631E;
            font-size: 18px;
        }
        .order-date {
            color: #6c757d;
            font-size: 14px;
        }
        .status-badge {
            padding: 8px 16px;
            border-radius: 25px;
            font-size: 12px;
            font-weight: 600;
            animation: pulse 2s infinite;
        }
        @keyframes pulse {
            0% { transform: scale(1); }
            50% { transform: scale(1.05); }
            100% { transform: scale(1); }
        }
        .status-pending { background: #fff3cd; color: #856404; }
        .status-processing { background: #cce5ff; color: #004085; }
        .status-shipped { background: #d4edda; color: #155724; }
        .status-delivered { background: #d1ecf1; color: #0c5460; }
        .status-cancelled { background: #f8d7da; color: #721c24; }
        .status-charged { background: #d4edda; color: #155724; }
        .status-failed { background: #f8d7da; color: #721c24; }
        .order-content {
            padding: 20px;
        }
        .product-section {
            display: flex;
            align-items: center;
            margin-bottom: 20px;
            padding: 15px;
            background: #f8f9fa;
            border-radius: 8px;
            transition: all 0.3s ease;
        }
        .product-section:hover {
            background: #e9ecef;
        }
        .product-image {
            width: 80px;
            height: 80px;
            object-fit: cover;
            border-radius: 8px;
            margin-right: 15px;
            transition: transform 0.3s ease;
        }
        .product-image:hover {
            transform: scale(1.1);
        }
        .product-info {
            flex: 1;
        }
        .product-name {
            font-weight: 600;
            color: #333;
            margin-bottom: 5px;
            text-decoration: none;
            transition: color 0.3s ease;
        }
        .product-name:hover {
            color: #F4631E;
            text-decoration: none;
        }
        .view-product {
            background: #F4631E;
            color: white;
            padding: 8px 16px;
            border-radius: 20px;
            text-decoration: none;
            font-size: 12px;
            font-weight: 600;
            transition: all 0.3s ease;
        }
        .view-product:hover {
            background: #d63916;
            color: white;
            text-decoration: none;
            transform: translateY(-2px);
        }
        .order-details {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 15px;
        }
        .detail-item {
            padding: 15px;
            background: #f8f9fa;
            border-radius: 8px;
            text-align: center;
            transition: all 0.3s ease;
        }
        .detail-item:hover {
            background: #e9ecef;
            transform: translateY(-2px);
        }
        .detail-label {
            font-size: 12px;
            color: #6c757d;
            font-weight: 600;
            margin-bottom: 8px;
            text-transform: uppercase;
        }
        .detail-value {
            font-weight: 600;
            color: #333;
            font-size: 14px;
        }
        .no-orders {
            text-align: center;
            padding: 60px 20px;
            background: white;
            border-radius: 12px;
            border: 1px solid #e9ecef;
            animation: fadeIn 0.5s ease;
        }
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }
        .order-item {
            animation: slideIn 0.5s ease forwards;
        }
        @keyframes slideIn {
            from { opacity: 0; transform: translateX(-20px); }
            to { opacity: 1; transform: translateX(0); }
        }
    </style>

    <div class="page-title">
        <div class="container">
            <h2 class="mb-0 text-center">Order Status</h2>
        </div>
    </div>

    <div class="container">
        @if($orders->isEmpty())
            <div class="no-orders">
                <h4>No Orders Found</h4>
                <p class="text-muted mb-0">You haven't placed any orders yet.</p>
            </div>
        @else
            @foreach ($orders as $order)
                <div class="order-item">
                    <div class="order-header">
                        <div>
                            <div class="order-id">Order #{{ $order->id }}</div>
                            <div class="order-date">{{ $order->created_at->format('d M Y, H:i') }}</div>
                        </div>
                        <span class="status-badge status-{{ strtolower(str_replace(' ', '-', $order->order_status)) }}">
                            {{ $order->order_status }}
                        </span>
                    </div>
                    
                    <div class="order-content">
                        <div class="product-section">
                            <img src="{{ asset('storage/' . $order->product->main_image) }}" alt="{{ $order->product->product_name }}" class="product-image">
                            <div class="product-info">
                                <a href="{{ route('user.view_product', $order->product->id) }}" class="product-name">
                                    {{ $order->product->product_name }}
                                </a>
                                <div class="text-muted" style="font-size: 12px;">Click to view product details</div>
                            </div>
                            <a href="{{ route('user.view_product', $order->product->id) }}" class="view-product">
                                View Product
                            </a>
                        </div>
                        
                        <div class="order-details">
                            <div class="detail-item">
                                <div class="detail-label">Quantity</div>
                                <div class="detail-value">{{ $order->quantity }}</div>
                            </div>
                            <div class="detail-item">
                                <div class="detail-label">Total Price</div>
                                <div class="detail-value">₹{{ number_format($order->total_price, 2) }}</div>
                            </div>
                            <div class="detail-item">
                                <div class="detail-label">Payment Method</div>
                                <div class="detail-value">{{ $order->payment_method }}</div>
                            </div>
                            @if($order->payment_method === 'HDFC' || $order->payment_method === 'hdfc')
                            <div class="detail-item">
                                <div class="detail-label">Transaction ID</div>
                                <div class="detail-value">
                                    @if($order->transaction_id)
                                        {{ $order->transaction_id }}
                                    @elseif(isset($order->hdfc_status['cf_payment_id']))
                                        {{ $order->hdfc_status['cf_payment_id'] }}
                                    @else
                                        N/A
                                    @endif
                                </div>
                            </div>
                            @if(isset($order->hdfc_status))
                            <div class="detail-item">
                                <div class="detail-label">Payment Status</div>
                                <div class="detail-value">{{ $order->hdfc_status['status'] ?? 'Unknown' }}</div>
                            </div>
                            <div class="detail-item">
                                <div class="detail-label">Payment Gateway</div>
                                <div class="detail-value">{{ $order->hdfc_status['payment_method']['type'] ?? 'HDFC' }}</div>
                            </div>
                            @endif
                            @endif
                            <div class="detail-item">
                                <div class="detail-label">Delivery Address</div>
                                <div class="detail-value">
                                    @if($order->address)
                                        {{ $order->address->address_line1 }}, {{ $order->address->city }}, {{ $order->address->state }} - {{ $order->address->postal_code }}
                                    @else
                                        No address available
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        @endif
    </div>
    <!-- Body Section end -->

 <!-- Footer -->
    @include('user.footer')

    <!-- Js Plugins -->
    <script src="{{ asset('assets/js/jquery-3.3.1.min.js') }}"></script>
    <script src="{{ asset('assets/js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('assets/js/jquery-ui.min.js') }}"></script>
    <script src="{{ asset('assets/js/jquery.countdown.min.js') }}"></script>
    <script src="{{ asset('assets/js/jquery.nice-select.min.js') }}"></script>
    <script src="{{ asset('assets/js/jquery.zoom.min.js') }}"></script>
    <script src="{{ asset('assets/js/jquery.dd.min.js') }}"></script>
    <script src="{{ asset('assets/js/jquery.slicknav.js') }}"></script>
    <script src="{{ asset('assets/js/owl.carousel.min.js') }}"></script>
    <script src="{{ asset('assets/js/main.js') }}"></script>

    <script>
        function changeMainImage(imageSrc) {
            document.getElementById('main-image').src = imageSrc;
            
            // Update active thumbnail
            document.querySelectorAll('.thumb-item').forEach(item => {
                item.classList.remove('active');
            });
            event.target.closest('.thumb-item').classList.add('active');
        }

        // Tab functionality
        $(document).ready(function() {
            $('.pd-tab-list a').click(function(e) {
                e.preventDefault();
                
                // Remove active class from all tabs and content
                $('.pd-tab-list a').removeClass('active');
                $('.tab-pane').removeClass('active');
                
                // Add active class to clicked tab
                $(this).addClass('active');
                
                // Show corresponding content
                var target = $(this).data('target');
                $(target).addClass('active');
            });
        });
    </script>

</body>

</html>
