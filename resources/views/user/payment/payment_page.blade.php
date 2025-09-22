<!DOCTYPE html>
<html lang="en">

<head>
    <title>Gujju E Market</title>
    @include('user.head')
    <style>
        /* Basic Reset */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

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
            max-width: 500px;
        }

        .page-title {
            font-size: 24px;
            font-weight: 600;
            text-align: center;
            color: #333;
        }

        .page-subtitle {
            font-size: 16px;
            text-align: center;
            color: #777;
            margin-bottom: 20px;
        }

        .payment-method {
            display: flex;
            justify-content: space-around;
            margin-bottom: 20px;
        }

        .payment-option {
            margin-right: 10px;
        }

        .payment-method label {
            font-size: 18px;
            color: #555;
            cursor: pointer;
        }

        .upi-options, .cod-options {
            display: none;
            text-align: center;
        }

        .qr-code {
            margin-bottom: 20px;
        }

        .qr-code img {
            width: 150px;
            height: 150px;
            margin-bottom: 10px;
        }

        .qr-code p {
            font-size: 14px;
            color: #666;
        }

        .btn {
            display: inline-block;
            padding: 12px 25px;
            margin: 10px;
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

        .btn.btn-submit {
            background-color: #28a745;
        }

        .btn.btn-submit:hover {
            background-color: #218838;
        }

        @media (max-width: 600px) {
            .container {
                width: 90%;
            }

            .btn {
                width: 100%;
                margin: 10px 0;
            }
        }

        /* Disabling UPI option styles */
        .disabled {
            opacity: 0.6;
            pointer-events: none;
        }

    </style>
</head>
<body>
    <div class="container">
        <h1 class="page-title">Payment Methods</h1>
        <p class="page-subtitle">Choose your preferred payment method</p>

        <!-- Form to submit the order -->
        <form action="{{ route('user.placeOrder') }}" method="POST">
            @csrf
            <!-- Hidden fields to pass the selected payment method and total amount -->
            <input type="hidden" name="payment_method" id="payment_method" value="COD"> <!-- Default is COD -->
            <input type="hidden" name="total_price" value="{{ number_format($totalAmount ?? 0, 2) }}">
            <input type="hidden" name="address_id" value="{{ session('selected_address')->id }}">

            <!-- Payment Method Selection -->
            <div class="payment-method">
                <label>
                    <input type="radio" name="payment" id="upi" class="payment-option" disabled>
                    UPI (Currently Disabled)
                </label>
                <label>
                    <input type="radio" name="payment" id="cod" class="payment-option" checked>
                    Cash on Delivery (COD)
                </label>
            </div>

            <!-- UPI Options (hidden by default) -->
            <div class="upi-options" id="upi-options">
                <h2>Pay with UPI</h2>
                <div class="qr-code">
                    <img src="https://via.placeholder.com/150" alt="QR Code">
                    <p>Scan this QR code with your UPI app</p>
                </div>
                <button type="button" class="btn" id="pay-with-upi">Pay via UPI App</button>
                <button type="submit" class="btn btn-submit">Submit Payment</button>
            </div>

            <!-- COD Options -->
            <div class="cod-options" id="cod-options">
                <h2>You have selected Cash on Delivery.</h2>
                <h1>Total Price: <strong>₹{{ number_format($totalAmount ?? 0, 2) }}</strong></h1>

                <button type="submit" class="btn btn-submit">Confirm and Place Order</button>
            </div>
        </form>
    </div>

    <script>
        // Handle switching between UPI and COD options
        document.addEventListener('DOMContentLoaded', function () {
            const upiOption = document.getElementById('upi');
            const codOption = document.getElementById('cod');
            const upiOptions = document.getElementById('upi-options');
            const codOptions = document.getElementById('cod-options');
            const paymentMethodInput = document.getElementById('payment_method');

            // Function to toggle payment method display
            function togglePaymentMethod() {
                if (upiOption.checked) {
                    upiOptions.style.display = 'block';
                    codOptions.style.display = 'none';
                    paymentMethodInput.value = 'UPI'; // Set payment method to UPI
                } else if (codOption.checked) {
                    upiOptions.style.display = 'none';
                    codOptions.style.display = 'block';
                    paymentMethodInput.value = 'COD'; // Set payment method to COD
                }
            }

            // Initialize display based on default selection
            togglePaymentMethod();

            // Add event listeners to radio buttons to handle changes
            upiOption.addEventListener('change', togglePaymentMethod);
            codOption.addEventListener('change', togglePaymentMethod);
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

</body>

</html>