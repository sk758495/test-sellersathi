<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order Details</title>
    <link rel="icon" href="{{ asset('user/images/gujju-logo-removebg.png') }}" sizes="32x32" type="image/x-icon">
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
        <p>Your order has been placed successfully! Here are your order details:</p>

        <div class="order-details">
            <div><strong>Order ID:</strong> #{{ $order->id }}</div>
            <div><strong>Status:</strong> {{ $order->order_status }}</div>
            <div><strong>Payment Method:</strong> {{ $order->payment_method }}</div>
            <div><strong>Total Price:</strong> ₹{{ number_format($order->total_price, 2) }}</div>
             </div>

        <p>You will be redirected back to your dashboard shortly...</p>

        <a href="{{ route('seller-user.dashboard', ['sellerAdminId' => $sellerAdminId]) }}" class="btn">Go to Dashboard</a>
    </div>

    <script>
        // Redirect to dashboard after 15 seconds
        setTimeout(function() {
            window.location.href = "{{ route('seller-user.dashboard', ['sellerAdminId' => $sellerAdminId]) }}";
        }, 15000);  // 15 seconds
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



