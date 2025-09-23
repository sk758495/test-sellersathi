<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payment Page</title>
    <link rel="icon" href="{{ asset('user/images/gujju-logo-removebg.png') }}" sizes="32x32" type="image/x-icon">

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

         <!-- Display selected address -->
         <div class="selected-address">
            <h2>Selected Address:</h2>
            <p>
                {{ $selectedAddress ? $selectedAddress->address_line1 . ', ' . $selectedAddress->address_line2 . ', ' . $selectedAddress->city . ', ' . $selectedAddress->state . ' - ' . $selectedAddress->postal_code : 'No address selected.' }}
            </p>
        </div>
        <!-- Form to submit the order -->
        <form action="{{ route('seller-user.placeOrder', ['sellerAdminId' => $sellerAdminId]) }}" method="POST">
            @csrf
            <!-- Hidden fields to pass the selected payment method and total amount -->
            <input type="hidden" name="payment_method" id="payment_method" value="COD"> <!-- Default is COD -->
            <input type="hidden" name="total_price" value="{{ number_format($totalAmount ?? 0, 2) }}">
            <input type="hidden" name="address_id" value="{{ session('selected_address')->id }}">

            <!-- Payment Method Selection -->
            <div class="payment-method">
                <label>
                    <input type="radio" name="payment" id="cod" class="payment-option" checked>
                    Cash on Delivery (COD)
                </label>
                <label>
                    <input type="radio" name="payment" id="hdfc" class="payment-option">
                    Pay Online via HDFC
                </label>
            </div>

            <!-- HDFC Options -->
            <div class="hdfc-options" id="hdfc-options" style="display: none;">
                <h2>HDFC Payment Gateway</h2>
                <h1>Total Price: <strong>₹{{ number_format($totalAmount ?? 0, 2) }}</strong></h1>
                <p>You will be redirected to HDFC secure payment page</p>
                <button type="submit" class="btn btn-submit">Pay Now</button>
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
        // Handle switching between payment options
        document.addEventListener('DOMContentLoaded', function () {
            const hdfcOption = document.getElementById('hdfc');
            const codOption = document.getElementById('cod');
            const hdfcOptions = document.getElementById('hdfc-options');
            const codOptions = document.getElementById('cod-options');
            const paymentMethodInput = document.getElementById('payment_method');

            // Function to toggle payment method display
            function togglePaymentMethod() {
                if (hdfcOption.checked) {
                    hdfcOptions.style.display = 'block';
                    codOptions.style.display = 'none';
                    paymentMethodInput.value = 'hdfc';
                } else if (codOption.checked) {
                    hdfcOptions.style.display = 'none';
                    codOptions.style.display = 'block';
                    paymentMethodInput.value = 'COD';
                }
            }

            // Initialize display based on default selection
            togglePaymentMethod();

            // Add event listeners to radio buttons to handle changes
            hdfcOption.addEventListener('change', togglePaymentMethod);
            codOption.addEventListener('change', togglePaymentMethod);
        });
    </script>


        <!-- JavaScript to show custom pop-up -->
   <script>
    document.addEventListener('DOMContentLoaded', function () {
        // Check if there's a success, error or info message in the session
        @if(session('success'))
            showPopup("{{ session('success') }}", "success");
        @elseif(session('error'))
            showPopup("{{ session('error') }}", "error");
        @elseif(session('info'))
            showPopup("{{ session('info') }}", "info");
        @endif
    });

    // Function to display pop-up message
    function showPopup(message, type) {
        // Create the pop-up element
        const popup = document.createElement('div');
        popup.classList.add('popup', type); // Add class based on message type
        popup.innerText = message;

        // Append the pop-up to the body
        document.body.appendChild(popup);

        // Make the pop-up visible with a delay to allow the browser to render it
        setTimeout(() => {
            popup.style.transform = 'translateY(0)'; // Show the popup with animation
        }, 100);

        // Hide the pop-up after 5 seconds
        setTimeout(() => {
            popup.style.transform = 'translateY(-100px)'; // Move the popup out of the screen
            // Remove the pop-up from DOM after animation
            setTimeout(() => {
                popup.remove();
            }, 300);
        }, 5000);
    }
    </script>

    <style>
        /* Pop-up styles */
        .popup {
            position: fixed;
            top: 20px;  /* Change to top */
            left: 50%;
            transform: translateX(-50%) translateY(-100px); /* Start above the screen */
            background-color: #333;
            color: white;
            padding: 10px 20px;
            border-radius: 5px;
            font-size: 16px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            opacity: 0.9;
            transition: transform 0.3s ease-in-out, opacity 0.3s ease-in-out;
            z-index: 9999;
        }

        /* Success message styles */
        .popup.success {
            background-color: #28a745;
        }

        /* Error message styles */
        .popup.error {
            background-color: #dc3545;
        }

        /* Info message styles */
        .popup.info {
            background-color: #17a2b8; /* Blue color for info messages */
        }
    </style>

</body>
</html>
