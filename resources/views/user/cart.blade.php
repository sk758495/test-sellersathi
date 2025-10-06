<!DOCTYPE html>
<html lang="en">

<head>
    <title>Gujju E Market - Shopping Cart</title>
    @include('user.head')
    <meta name="csrf-token" content="{{ csrf_token() }}">
</head>

<body>
    @include('user.navbar')

    <section class="shopping-cart spad">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    @if(session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            {{ session('success') }}
                            <button type="button" class="close" data-dismiss="alert">
                                <span>&times;</span>
                            </button>
                        </div>
                    @endif
                    
                    @if(session('error'))
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            {{ session('error') }}
                            <button type="button" class="close" data-dismiss="alert">
                                <span>&times;</span>
                            </button>
                        </div>
                    @endif

                    <div class="cart-table">
                        <table>
                            <thead>
                                <tr>
                                    <th>Image</th>
                                    <th class="p-name">Product Name</th>
                                    <th>Price</th>
                                    <th>Quantity</th>
                                    <th>Total</th>
                                    <th><i class="ti-close"></i></th>
                                </tr>
                            </thead>
                            <tbody id="cart-items">
                                @foreach ($carts as $cart)
                                <tr data-cart-id="{{ $cart->id }}">
                                    <td class="cart-pic first-row">
                                        <img src="{{ asset('storage/' . $cart->product->main_image) }}" alt="{{ $cart->product->product_name }}" style="width: 80px; height: 80px; object-fit: cover;">
                                    </td>
                                    <td class="cart-title first-row">
                                        <h5>{{ $cart->product->product_name }}</h5>
                                        @if($cart->discount_id && $cart->discount)
                                            <small class="text-success">{{ $cart->discount->discount_percentage }}% Discount Applied</small>
                                        @endif
                                    </td>
                                    <td class="p-price first-row">
                                        @php
                                            $productPrice = $cart->product->discount_price;
                                            if ($cart->discount_id && $cart->discount) {
                                                $productPrice = $cart->product->price - ($cart->product->price * ($cart->discount->discount_percentage / 100));
                                            }
                                        @endphp
                                        ₹<span class="item-price" data-price="{{ $productPrice }}">{{ number_format($productPrice, 2) }}</span>
                                    </td>
                                    <td class="qua-col first-row">
                                        <div class="quantity">
                                            <input type="number" min="1" max="99" value="{{ $cart->quantity }}" class="qty-input" data-cart-id="{{ $cart->id }}">
                                        </div>
                                    </td>
                                    <td class="total-price first-row">
                                        ₹<span class="item-total">{{ number_format($productPrice * $cart->quantity, 2) }}</span>
                                    </td>
                                    <td class="close-td first-row">
                                        <i class="ti-close delete-button" data-cart-id="{{ $cart->id }}" title="Remove item"></i>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    
                    <div class="row">
                        <div class="col-lg-4">
                            <div class="cart-buttons">
                                <a href="{{ route('dashboard') }}" class="primary-btn continue-shop">Continue Shopping</a>
                                <button type="button" class="primary-btn update-cart" id="update-all-cart">Update Cart</button>
                            </div>
                        </div>
                        <div class="col-lg-4 offset-lg-4">
                            <div class="proceed-checkout">
                                <ul>
                                    <li class="subtotal">Subtotal <span id="subtotal">₹{{ number_format($subtotal, 2) }}</span></li>
                                    <li class="shipping">Shipping <span id="shipping">₹50.00</span></li>
                                    <li class="cart-total">Total <span id="total">₹{{ number_format($total, 2) }}</span></li>
                                </ul>
                                <a href="{{ route('user.payment') }}" class="proceed-btn">PROCEED TO CHECKOUT</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    @include('user.footer')

    <script src="{{ asset('assets/js/jquery-3.3.1.min.js') }}"></script>
    <script src="{{ asset('assets/js/bootstrap.min.js') }}"></script>

    <style>
        .shopping-cart {
            padding: 50px 0;
        }
        
        .cart-table table {
            width: 100%;
            border-collapse: collapse;
        }
        
        .cart-table th, .cart-table td {
            padding: 15px;
            text-align: left;
            border-bottom: 1px solid #eee;
        }
        
        .cart-table th {
            background-color: #f8f9fa;
            font-weight: 600;
        }
        
        .quantity {
            display: flex;
            align-items: center;
            border: 1px solid #ddd;
            border-radius: 4px;
            overflow: hidden;
            width: fit-content;
        }
        
        .qty-btn {
            background: #f8f9fa;
            border: none;
            width: 35px;
            height: 40px;
            cursor: pointer;
            font-size: 18px;
            font-weight: bold;
            transition: all 0.3s ease;
        }
        
        .qty-btn:hover {
            background: #e9ecef;
        }
        
        .qty-btn:disabled {
            opacity: 0.5;
            cursor: not-allowed;
        }
        
        .qty-input {
            border: none;
            width: 60px;
            height: 40px;
            text-align: center;
            outline: none;
            font-weight: bold;
            background: white;
        }
        
        .delete-button {
            cursor: pointer;
            color: #dc3545;
            font-size: 18px;
            transition: all 0.3s ease;
        }
        
        .delete-button:hover {
            color: #c82333;
            transform: scale(1.1);
        }
        
        .proceed-checkout {
            background: #f8f9fa;
            padding: 30px;
            border-radius: 8px;
        }
        
        .proceed-checkout ul {
            list-style: none;
            padding: 0;
            margin: 0 0 20px 0;
        }
        
        .proceed-checkout li {
            display: flex;
            justify-content: space-between;
            padding: 10px 0;
            border-bottom: 1px solid #eee;
        }
        
        .proceed-checkout .cart-total {
            font-weight: bold;
            font-size: 18px;
            border-bottom: 2px solid #333;
        }
        
        .proceed-btn {
            display: block;
            width: 100%;
            background: #333;
            color: white;
            text-align: center;
            padding: 15px;
            text-decoration: none;
            border-radius: 4px;
            transition: all 0.3s ease;
        }
        
        .proceed-btn:hover {
            background: #555;
            color: white;
            text-decoration: none;
        }
        
        .primary-btn {
            background: #333;
            color: white;
            padding: 12px 25px;
            border: none;
            border-radius: 4px;
            text-decoration: none;
            display: inline-block;
            margin-right: 10px;
            transition: all 0.3s ease;
        }
        
        .primary-btn:hover {
            background: #555;
            color: white;
            text-decoration: none;
        }
        
        .loading {
            opacity: 0.6;
            pointer-events: none;
        }
        
        .alert {
            margin-bottom: 20px;
        }
    </style>

    <script>
        $(document).ready(function() {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $('#update-all-cart').click(function() {
                const updates = [];
                $('.qty-input').each(function() {
                    updates.push({
                        cart_id: $(this).data('cart-id'),
                        quantity: parseInt($(this).val())
                    });
                });
                
                $.ajax({
                    url: '/update-cart-bulk',
                    method: 'POST',
                    data: { updates: updates },
                    success: function() {
                        location.reload();
                    },
                    error: function() {
                        alert('Failed to update cart');
                    }
                });
            });

            $('.delete-button').click(function() {
                const cartId = $(this).data('cart-id');
                if (confirm('Remove this item from cart?')) {
                    $.ajax({
                        url: '/remove-from-cart',
                        method: 'DELETE',
                        data: { cart_id: cartId },
                        success: function(response) {
                            $('tr[data-cart-id="' + cartId + '"]').remove();
                            $('#subtotal').text('₹' + response.subtotal);
                            $('#total').text('₹' + response.total);
                            if ($('#cart-items tr').length === 0) location.reload();
                        },
                        error: function() {
                            alert('Failed to remove item. Please try again.');
                        }
                    });
                }
            });
        });
    </script>

</body>
</html>