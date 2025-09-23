<!DOCTYPE html>
<html lang="en">

<head>
   
    <title>Gujju E Market</title>

    @include('user.head')
    
</head>

<body>

    @include('user.navbar')

    <style>
        body { background: #f8f9fa; }
        .confirmation-card {
            max-width: 600px;
            margin: 40px auto;
            background: white;
            border-radius: 15px;
            box-shadow: 0 8px 25px rgba(0,0,0,0.1);
            overflow: hidden;
        }
        .success-header {
            background: linear-gradient(135deg, #48bb78, #38a169);
            padding: 30px;
            text-align: center;
            color: white;
        }
        .success-icon {
            font-size: 40px;
            margin-bottom: 15px;
        }
        .success-title {
            font-size: 1.8rem;
            font-weight: 600;
            margin: 0;
        }
        .order-content {
            padding: 30px;
        }
        .order-id {
            text-align: center;
            background: #F4631E;
            color: white;
            padding: 15px;
            border-radius: 10px;
            margin-bottom: 25px;
            font-size: 1.2rem;
            font-weight: 600;
        }
        .info-row {
            display: flex;
            justify-content: space-between;
            padding: 12px 0;
            border-bottom: 1px solid #f1f1f1;
        }
        .info-label {
            color: #666;
            font-weight: 500;
        }
        .info-value {
            font-weight: 600;
            color: #333;
        }
        .whatsapp-section {
            background: #25d366;
            color: white;
            padding: 20px;
            border-radius: 10px;
            text-align: center;
            margin: 20px 0;
        }
        .action-buttons {
            display: flex;
            gap: 10px;
            margin-top: 20px;
        }
        .btn {
            flex: 1;
            padding: 12px;
            border: none;
            border-radius: 8px;
            font-weight: 600;
            text-decoration: none;
            text-align: center;
            transition: all 0.3s ease;
        }
        .btn-whatsapp {
            background: #25d366;
            color: white;
        }
        .btn-dashboard {
            background: #F4631E;
            color: white;
        }
        .btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 15px rgba(0,0,0,0.2);
            color: white;
            text-decoration: none;
        }
        @media (max-width: 768px) {
            .confirmation-card { margin: 20px; }
            .action-buttons { flex-direction: column; }
        }
    </style>

    <div class="container">
        <div class="confirmation-card">
            <div class="success-header">
                <div class="success-icon">
                    <i class="fas fa-check-circle"></i>
                </div>
                <h1 class="success-title">Order Confirmed!</h1>
            </div>
            
            <div class="order-content">
                <div class="order-id">
                    Order #{{ $order->id }}
                </div>
                
                <div class="info-row">
                    <span class="info-label">Customer</span>
                    <span class="info-value">{{ $order->user->name }}</span>
                </div>
                
                <div class="info-row">
                    <span class="info-label">Product</span>
                    <span class="info-value">{{ $order->product->product_name }}</span>
                </div>
                
                <div class="info-row">
                    <span class="info-label">Status</span>
                    <span class="info-value">{{ $order->order_status }}</span>
                </div>
                
                <div class="info-row">
                    <span class="info-label">Payment</span>
                    <span class="info-value">{{ $order->payment_method }}</span>
                </div>
                
                <div class="info-row">
                    <span class="info-label">Total</span>
                    <span class="info-value">₹{{ number_format($order->total_price, 2) }}</span>
                </div>
                
                <div class="info-row">
                    <span class="info-label">Delivery Address</span>
                    <span class="info-value">
                        @if($order->address)
                            {{ $order->address->address_line1 }}, {{ $order->address->city }}, {{ $order->address->state }} - {{ $order->address->postal_code }}
                        @else
                            No address available
                        @endif
                    </span>
                </div>
                
                <div class="whatsapp-section">
                    <i class="fab fa-whatsapp" style="font-size: 24px; margin-bottom: 10px;"></i>
                    <div>Confirm via WhatsApp for faster processing</div>
                </div>
                
                <div class="action-buttons">
                    <a href="https://wa.me/9328822480?text=Order%20ID%3A%20{{ $order->id }}%0AName%3A%20{{ urlencode($order->user->name) }}%0AProduct%3A%20{{ urlencode($order->product->product_name) }}%0ATotal%3A%20₹{{ number_format($order->total_price, 2) }}" target="_blank" class="btn btn-whatsapp">
                        <i class="fab fa-whatsapp"></i> WhatsApp
                    </a>
                    <a href="{{ route('dashboard') }}" class="btn btn-dashboard">
                        <i class="fas fa-home"></i> Dashboard
                    </a>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Redirect to dashboard after 15 seconds
        // setTimeout(function() {
        //     window.location.href = "{{ route('dashboard') }}";
        // }, 15000);  // 15 seconds
    </script>
        <!-- JavaScript to show custom pop-up -->
   
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



