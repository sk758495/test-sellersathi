<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gujju E-Market</title>
    <link rel="stylesheet" href="{{ asset('user/css/cart.css') }}">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="icon" href="{{ asset('user/images/gujju-logo-removebg.png') }}" sizes="32x32" type="image/x-icon">
</head>

<body>

    @include('seller-user.navbar')

    <!-- Body Section -->
    <div class="cart-container">
        <h1>Your Shopping Cart</h1>

        @if ($cart->count() > 0)
            <div class="table-wrapper">
                <table class="shopping-cart-table">
                    <thead>
                        <tr>
                            <th>Product</th>
                            <th>Name</th>
                            <th>Price</th>
                            <th>Quantity</th>
                            <th>Total</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody class="table-body">
                        @foreach ($cart as $cartItem)
                        <tr>
                            <td>
                                <div class="product-details">
                                    <img src="{{ asset('storage/' . $cartItem->product->main_image) }}" alt="Product Image">
                                </div>
                            </td>
                            <td>{{ $cartItem->product_name }}</td>
                            <td>₹{{ $cartItem->price }}</td>
                            <td>
                                <input type="number" value="{{ $cartItem->quantity }}" min="1" class="quantity-control" data-cart-id="{{ $cartItem->id }}">
                            </td>
                            <td>₹{{ $cartItem->price * $cartItem->quantity }}</td>
                            <td>
                                <button class="delete-button" data-cart-id="{{ $cartItem->id }}">Remove</button>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>

            <div class="cart-summary-section">
                <h2>Cart Summary</h2>
                <div class="summary-item">
                    <p>Subtotal: <span id="subtotal">₹{{ $subtotal }}</span></p>
                </div>
                <div class="summary-item">
                    <p>Shipping Charge: <span id="shipping">₹{{ $shipping }}</span></p>
                    <p style="color: red;">If you add more quantity Shipping Charge extra added: <span>₹20</span></p>
                </div>
                <div class="summary-item total-amount">
                    <p>Total: <span id="total">₹{{ $total }}</span></p>
                </div>
                <button class="checkout-button">
                    <a href="{{ route('seller-user.address.page', ['sellerAdminId' => $sellerAdminId]) }}" style="text-decoration: none; color: white;">Proceed to Checkout</a>
                </button>
            </div>

        @else
            <p>Your cart is empty.</p>
        @endif
    </div>

    @include('user.footer')

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <script>
$(document).ready(function() {
    // Handle quantity change (update quantity)
    $('.quantity-control').on('change', function() {
        var quantity = $(this).val();  // Get the new quantity
        var cartId = $(this).data('cart-id');  // Get the cart item ID
        var currentRow = $(this).closest('tr');  // Get the row of the cart item

        // Send AJAX request to update the cart item quantity
        $.ajax({
            url: '/update-cart-quantity',  // URL to update cart
            method: 'POST',                // HTTP method
            data: {
                _token: '{{ csrf_token() }}',  // CSRF token
                cart_id: cartId,               // Cart item ID
                quantity: quantity            // New quantity
            },
            dataType: 'json',  // Expect a JSON response
            success: function(response) {
                // Update the item total in the row (column 5 = Total)
                currentRow.find('td:nth-child(5)').text(response.item_total);

                // Update the cart summary (subtotal and total)
                $('#subtotal').text(response.subtotal);
                $('#total').text(response.total);
            },
            error: function(xhr, status, error) {
                console.error(xhr.responseText);  // Log the error for debugging
                alert('Error updating cart');
            }
        });
    });

    // Handle remove button click
    $('.delete-button').on('click', function() {
        var cartId = $(this).data('cart-id'); // Get the cart item ID
        var row = $(this).closest('tr'); // Get the row to remove

        // Confirm before removing the item
        if (confirm('Are you sure you want to remove this item from your cart?')) {
            $.ajax({
                url: '/seller-user/{{ $sellerAdminId }}/cart/remove/' + cartId, // Route to remove item from cart
                method: 'DELETE',
                data: {
                    _token: '{{ csrf_token() }}', // CSRF token for security
                    cart_id: cartId
                },
                success: function(response) {
                    // Remove the row from the table after successful deletion
                    row.remove();

                    // Update the cart summary
                    $('#subtotal').text(response.subtotal);
                    $('#total').text(response.total);

                    // Show a success message
                    alert(response.message);
                },
                error: function(xhr, status, error) {
                    console.error(xhr.responseText); // Log the error for debugging
                    alert('Error removing item from cart');
                }
            });
        }
    });
});

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

    <!-- Bootstrap JS (with Popper) -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
