<div class="container">
    <h1>Seller Products for {{ $sellerAdmin->name }}</h1>
    <table class="table">
        <thead>
            <tr>
                <th>SKU</th>
                <th>Product Name</th>
                <th>Color</th>
                <th>Price</th>
                <th>Quantity</th>
                <th>Lead Time</th>
                <th>Cost Price</th>
                <th>Discount Price</th>
                <th>Brand</th>
                <th>Category</th>
                <th>Subcategory</th>
                <th>Description</th>
                <th>Features</th>
                <th>What's Included</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($sellerProducts as $product)
                <tr>
                    <td>{{ $product->sku }}</td>
                    <td>{{ $product->product_name }}</td>
                    <td>{{ $product->color_name }} ({{ $product->color_code }})</td> <!-- New fields: color_name, color_code -->
                    <td>{{ $product->price }}</td>
                    <td>{{ $product->quantity }}</td>
                    <td>{{ $product->lead_time }}</td> <!-- New field: lead_time -->
                    <td>{{ $product->cost_price }}</td> <!-- New field: cost_price -->
                    <td>{{ $product->discount_price }}</td> <!-- New field: discount_price -->
                    <td>{{ $product->brand ? $product->brand->name : 'N/A' }}</td> <!-- Assuming 'brand' relationship exists -->
                    <td>{{ $product->brandCategory ? $product->brandCategory->name : 'N/A' }}</td> <!-- Assuming 'brandCategory' relationship exists -->
                    <td>{{ $product->subcategory ? $product->subcategory->name : 'N/A' }}</td> <!-- Assuming 'subcategory' relationship exists -->
                    <td>{{ $product->short_description }}</td>
                    <td>{{ $product->features }}</td> <!-- New field: features -->
                    <td>{{ $product->whats_included }}</td> <!-- New field: whats_included -->
                    <td>
                        <!-- Add actions like Edit, Delete -->
                        
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
<form action="{{ route('seller-admin.logout') }}" method="POST">
    @csrf
    <button type="submit">Logout</button>
</form>

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
            