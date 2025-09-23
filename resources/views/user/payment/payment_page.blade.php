<!DOCTYPE html>
<html lang="en">

<head>

    <title>Gujju E Market</title>

    @include('user.head')

</head>

<body>

    @include('user.navbar')

    <style>
        .payment-container {
            max-width: 800px;
            margin: 40px auto;
            background: white;
            border-radius: 20px;
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.1);
            overflow: hidden;
            animation: slideUp 0.6s ease-out;
        }

        @keyframes slideUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .payment-header {
            background: linear-gradient(135deg, #eb660d 0%, #c9674a 100%);
            padding: 40px;
            text-align: center;
            color: white;
        }

        .page-title {
            font-size: 28px;
            font-weight: 700;
            margin-bottom: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 12px;
        }

        .page-subtitle {
            font-size: 16px;
            opacity: 0.9;
            margin: 0;
        }

        .payment-content {
            padding: 40px;
        }

        .payment-method {
            margin-bottom: 30px;
        }

        .payment-method label {
            display: block;
            background: #f8f9fa;
            border: 2px solid #e2e8f0;
            border-radius: 15px;
            padding: 20px;
            margin-bottom: 15px;
            cursor: pointer;
            transition: all 0.3s ease;
            position: relative;
        }

        .payment-method label:hover {
            border-color: #F4631E;
            background: #fff8f5;
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(244, 99, 30, 0.15);
        }

        .payment-method input[type="radio"]:checked+span,
        .payment-method label:has(input:checked) {
            border-color: #F4631E;
            background: #fff8f5;
            box-shadow: 0 8px 25px rgba(244, 99, 30, 0.2);
        }

        .payment-method input[type="radio"] {
            margin-right: 15px;
            width: 20px;
            height: 20px;
        }

        .payment-method label[for="upi"] {
            opacity: 0.6;
            cursor: not-allowed;
        }

        .hdfc-options,
        .cod-options {
            background: #f8f9fa;
            border-radius: 15px;
            padding: 30px;
            margin-top: 20px;
            border: 1px solid #e2e8f0;
        }

        .payment-features {
            display: flex;
            justify-content: space-around;
            margin: 20px 0;
            flex-wrap: wrap;
        }

        .feature {
            text-align: center;
            padding: 15px;
            background: white;
            border-radius: 10px;
            margin: 5px;
            flex: 1;
            min-width: 120px;
        }

        .feature i {
            font-size: 24px;
            color: #F4631E;
            margin-bottom: 8px;
            display: block;
        }

        @media (max-width: 768px) {
            .payment-features {
                flex-direction: column;
            }

            .feature {
                min-width: 100%;
                margin: 5px 0;
            }
        }

        .cod-options h2 {
            color: #2d3748;
            font-size: 20px;
            font-weight: 600;
            margin-bottom: 20px;
            text-align: center;
        }

        .cod-options h1 {
            color: #F4631E;
            font-size: 24px;
            font-weight: 700;
            text-align: center;
            margin: 20px 0;
            padding: 20px;
            background: white;
            border-radius: 10px;
            border: 2px solid #F4631E;
        }

        .qr-code {
            text-align: center;
            margin: 20px 0;
        }

        .qr-code img {
            border-radius: 10px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
        }

        .btn,
        .btn-submit {
            background: linear-gradient(135deg, #F4631E, #ff8a50);
            color: white;
            border: none;
            padding: 15px 30px;
            border-radius: 25px;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            display: block;
            width: 100%;
            margin: 10px 0;
        }

        .btn:hover,
        .btn-submit:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(244, 99, 30, 0.4);
        }

        #pay-with-upi {
            background: linear-gradient(135deg, #48bb78, #38a169);
        }

        body {
            background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
            min-height: 100vh;
        }
    </style>

    <div class="payment-container">
        <div class="payment-header">
            <h1 class="page-title">
                <i class="fas fa-credit-card"></i>
                Payment Methods
            </h1>
            <p class="page-subtitle">Choose your preferred payment method</p>
        </div>

        <div class="payment-content">
            <h1 class="page-title">Payment Methods</h1>
            <p class="page-subtitle">Choose your preferred payment method</p>

            <!-- Form to submit the order -->
            <form action="{{ route('user.placeOrder') }}" method="POST">
                @csrf
                <!-- Hidden fields to pass the selected payment method and total amount -->
                <input type="hidden" name="payment_method" id="payment_method" value="hdfc"> <!-- Default is HDFC -->
                <input type="hidden" name="total_price" value="{{ number_format($totalAmount ?? 0, 2) }}">
                @if(session('selected_address'))
                <input type="hidden" name="address_id" value="{{ session('selected_address')->id }}">
                @endif

                <!-- Payment Method Selection -->
                <div class="payment-method">
                    <label>
                        <input type="radio" name="payment" id="hdfc" class="payment-option" value="hdfc" checked>
                        <i class="fas fa-university"></i> Pay Online via HDFC
                    </label>
                </div>

                <!-- HDFC Options -->
                <div class="hdfc-options" id="hdfc-options">
                    <h2>HDFC Payment Gateway</h2>
                    <h1>Total Price: <strong>₹{{ number_format($totalAmount ?? 0, 2) }}</strong></h1>
                    <p>You will be redirected to HDFC secure payment page</p>
                    <button type="submit" class="btn btn-submit">Pay Now</button>
                </div>
            </form>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const paymentMethodInput = document.getElementById('payment_method');
            paymentMethodInput.value = 'hdfc';
        });
    </script>

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

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const paymentMethodInput = document.getElementById('payment_method');
        
        document.querySelectorAll('.payment-option').forEach(input => {
            input.addEventListener('change', function () {
                paymentMethodInput.value = this.value;
                console.log('Payment method changed to:', this.value);
            });
        });
        
        // Set initial value
        const checkedOption = document.querySelector('.payment-option:checked');
        if (checkedOption) {
            paymentMethodInput.value = checkedOption.value;
        }
    });
</script>

</body>

</html>
