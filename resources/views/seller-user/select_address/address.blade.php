<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gujju E-Market</title>
    <link rel="stylesheet" href="{{ asset('user/css/payment_page.css') }}">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="icon" href="{{ asset('user/images/gujju-logo-removebg.png') }}" sizes="32x32" type="image/x-icon">
</head>
<body>

@include('seller-user.navbar')

<div class="cart-body">
    <!-- Step 1: Address Selection -->
    <div id="address-section">
        <h2>1. Select a delivery address</h2>

        <!-- Display saved addresses only if they exist -->
        @if ($addresses->isEmpty())
            <!-- If no addresses are available, show only the "Add New Address" option -->
            <h4>No saved addresses found. Please add a new address.</h4>
        @else
            <h4>Choose a saved address</h4>
            <form action="{{ route('seller-user.select_address', ['sellerAdminId' => $sellerAdminId]) }}" method="POST">
                @csrf
                <div class="form-group">
                    @foreach ($addresses as $address)
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="address_id" id="address{{ $address->id }}" value="{{ $address->id }}" required>
                            <label class="form-check-label" for="address{{ $address->id }}">
                                {{ $address->address_line1 }}, {{ $address->city }}, {{ $address->state }}, {{ $address->country }} - {{ $address->postal_code }}
                            </label>
                        </div>
                    @endforeach
                </div>
                <button type="submit" class="btn btn-primary">Select Address</button>
            </form>
        @endif

        <hr>

        <!-- Option to Add New Address -->
        <button id="add-new-address-btn" class="btn btn-secondary">Add New Address</button>

        <div id="new-address-form" style="display:none;">
            <!-- Address Form to Add New Address -->
            <h4 style="margin-top: 15px;">Enter New Address</h4>
            <form action="{{ route('seller-user.save_address', ['sellerAdminId' => $sellerAdminId]) }}" method="POST">
                @csrf
                <div class="form-group">
                    <label for="address_line1">Address Line 1</label>
                    <input type="text" name="address_line1" class="form-control" required>
                </div>
                <div class="form-group">
                    <label for="address_line2">Address Line 2</label>
                    <input type="text" name="address_line2" class="form-control">
                </div>
                <div class="form-group">
                    <label for="city">City</label>
                    <input type="text" name="city" class="form-control" required>
                </div>
                <div class="form-group">
                    <label for="state">State</label>
                    <input type="text" name="state" class="form-control" required>
                </div>
                <div class="form-group">
                    <label for="country">Country</label>
                    <input type="text" name="country" class="form-control" required>
                </div>
                <div class="form-group">
                    <label for="postal_code">Postal Code</label>
                    <input type="text" name="postal_code" class="form-control" required>
                </div>
                <button type="submit" class="btn btn-primary" style="margin-top: 10px;">Save Address</button>
            </form>
        </div>
    </div>
</div>


@include('user.footer')

<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

<script>
    // Toggle display of the "Add New Address" form
    document.getElementById('add-new-address-btn').addEventListener('click', function() {
        const newAddressForm = document.getElementById('new-address-form');
        newAddressForm.style.display = newAddressForm.style.display === 'none' ? 'block' : 'none';
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
