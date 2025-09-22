<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />    
    <link rel="icon" href="{{ asset('user/images/gujju-logo-removebg.png') }}" sizes="32x32" type="image/x-icon">
    <title>Order Invoice</title>
    <style>
        body { font-family: Arial, sans-serif; }
        .container { max-width: 800px; margin: 0 auto; }
        h1, h2, h3 { text-align: center; }
        .table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        .table, .table th, .table td { border: 1px solid #ddd; }
        .table th, .table td { padding: 8px; text-align: left; }
        .total { text-align: right; font-weight: bold; margin-top: 20px; }
        .footer { text-align: center; font-size: 12px; margin-top: 40px; }
    </style>
</head>
<body>
    <div class="container">
        <h1>Order Invoice (Order ID: {{ $order->id }})</h1>

        <h3>Seller Information</h3>
        <p><strong>Seller Name:</strong> {{ $order->sellerAdmin->name }}</p>
        <p><strong>Seller Address:</strong> Gujju e-Market, 15 Giriraj Bagh, Waghodia Road, Vadodara, Gujarat 390019</p>

        <h3>Customer Information</h3>
        <p><strong>Name:</strong> {{ $order->user->name }}</p>
        <p><strong>Email:</strong> {{ $order->user->email }}</p>
        <p><strong>Phone:</strong> {{ $order->user->phone }}</p>
        <p><strong>Shipping Address:</strong> {{ $order->address->address_line1 }}, {{ $order->address->address_line2 }}, {{ $order->address->city }}</p>

        <h3>Order Details</h3>
        <table class="table">
            <thead>
                <tr>
                    <th>Product Name</th>
                    <th>Quantity</th>
                    <th>Product Price</th>
                    <th>Subtotal</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>{{ $order->product->product_name }}</td>
                    <td>{{ $order->quantity }}</td>
                    <td>{{ $order->product->price }}</td>
                    <td>{{ $order->total_price }}</td>
                </tr>
            </tbody>
        </table>

        <div class="total">
            <p><strong>Total Amount: {{ $order->total_price }} Rs</strong></p>
        </div>

        <div class="footer">
            <p>This is an electronically generated invoice and does not require a signature.</p>
        </div>
    </div>
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
