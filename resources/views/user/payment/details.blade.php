<!DOCTYPE html>
<html lang="en">

<head>
    <title>Gujju E Market</title>
    @include('user.head')

    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f9;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        .container {
            background-color: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 600px;
            text-align: center;
        }

        h1 {
            font-size: 28px;
            font-weight: 600;
            margin-bottom: 20px;
        }

        p {
            font-size: 18px;
            color: #555;
            margin-bottom: 10px;
        }

        .order-details {
            margin-top: 20px;
            text-align: left;
        }

        .order-details div {
            margin-bottom: 8px;
        }

        .btn {
            display: inline-block;
            padding: 12px 25px;
            margin-top: 20px;
            background-color: #007BFF;
            color: white;
            border: none;
            border-radius: 25px;
            font-size: 16px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        .btn:hover {
            background-color: #0056b3;
        }

    </style>
</head>
<body>
    <div class="container">
        <h1>Order Confirmation</h1>

        <div class="order-details">
            <div><strong>Order ID:</strong> #{{ $order->id }}</div>
            <div><strong>Name:</strong> {{ $order->user->name }}</div>
            <div><strong>Email:</strong> {{ $order->user->email }}</div>
            <div><strong>Phone:</strong> {{ $order->user->phone }}</div>
            <div><strong>Status:</strong> {{ $order->order_status }}</div>
            <div><strong>Product SKU:</strong> {{ $order->product->sku }}</div>
            <div><strong>Product Name:</strong> {{ $order->product->product_name }}</div>
            <div><strong>Payment Method:</strong> {{ $order->payment_method }}</div>
            <div><strong>Total Price:</strong> ₹{{ number_format($order->total_price, 2) }}</div>
             </div>

        {{-- <p>You will be redirected back to your dashboard shortly...</p> --}}

        
        <!-- WhatsApp Link -->
        <p style="color: rgb(255, 106, 0); font-weight:700; text-shadow: 0 0 0.6px black;">To confirm your order, click the button below to send your order details via WhatsApp:</p>
        <a href="https://wa.me/9328822480?text=Order%20ID%3A%20{{ $order->id }}%0AName%3A%20{{ urlencode($order->user->name) }}%0AEmail%3A%20{{ urlencode($order->user->email) }}%0APhone%3A%20{{ urlencode($order->user->phone) }}%0AStatus%3A%20{{ urlencode($order->order_status) }}%0AProduct%20Name%3A%20{{ urlencode($order->product->product_name) }}%0AProduct%20SKU%3A%20{{ urlencode($order->product->sku) }}%0APayment%20Method%3A%20{{ urlencode($order->payment_method) }}%0ATotal%20Price%3A%20₹{{ number_format($order->total_price, 2) }}" target="_blank">
            <button class="btn btn-primary">Send Order Conformation via WhatsApp</button>
        </a>      <br>  
        <a href="{{ route('dashboard') }}" class="btn">Go to Dashboard</a>
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



