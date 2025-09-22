<!DOCTYPE html>
<html lang="en">

<head>
    <title>Gujju E Market</title>
    @include('user.head')
</head>

<body>

    @include('user.navbar')

    <section class="shopping-cart spad">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
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
                            <tbody>
                                @foreach ($carts as $cart)
                                <tr>
                                    <td class="cart-pic first-row"><img src="{{ asset('storage/' . $cart->product->main_image) }}" alt=""></td>
                                    <td class="cart-title first-row">
                                        <h5>{{ $cart->product->product_name }}</h5>
                                    </td>
                                    <td class="p-price first-row">
                                        @php
                                            $productPrice = $cart->product->discount_price;
                                            if ($cart->discount_id && $cart->discount) {
                                                $productPrice = $cart->product->price - ($cart->product->price * ($cart->discount->discount_percentage / 100));
                                            }
                                        @endphp
                                        ₹ {{ number_format($productPrice, 2) }}
                                    </td>
                                    <td class="qua-col first-row">
                                        <div class="quantity">
                                            <div class="pro-qty">
                                                <input type="text" value="{{ $cart->quantity ?? 1 }}" class="quantity-control" data-cart-id="{{ $cart->id }}">
                                            </div>
                                        </div>
                                    </td>
                                    <td class="total-price first-row">₹ {{ number_format($productPrice * ($cart->quantity ?? 1), 2) }}</td>
                                    <td class="close-td first-row"><i class="ti-close delete-button" data-cart-id="{{ $cart->id }}"></i></td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="row">
                        <div class="col-lg-4">
                            <div class="cart-buttons">
                                <a href="{{ route('dashboard') }}" class="primary-btn continue-shop">Continue shopping</a>
                                <a href="#" class="primary-btn up-cart">Update cart</a>
                            </div>
                            <div class="discount-coupon">
                                <h6>Discount Codes</h6>
                                <form action="#" class="coupon-form">
                                    <input type="text" placeholder="Enter your codes">
                                    <button type="submit" class="site-btn coupon-btn">Apply</button>
                                </form>
                            </div>
                        </div>
                        <div class="col-lg-4 offset-lg-4">
                            <div class="proceed-checkout">
                                <ul>
                                    <li class="subtotal">Subtotal <span id="subtotal">₹ {{ number_format($subtotal, 2) }}</span></li>
                                    <li class="cart-total">Total <span id="total">₹ {{ number_format($total, 2) }}</span></li>
                                </ul>
                                <a href="{{ route('user.payment') }}" class="proceed-btn">PROCEED TO CHECK OUT</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

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
        $(document).ready(function() {
            // Quantity update functionality
            $('.quantity-control').on('change', function() {
                var cartId = $(this).data('cart-id');
                var quantity = $(this).val();
                
                $.ajax({
                    url: '/update-cart-quantity',
                    method: 'POST',
                    data: {
                        _token: '{{ csrf_token() }}',
                        cart_id: cartId,
                        quantity: quantity
                    },
                    success: function(response) {
                        // Update the item total
                        var row = $('[data-cart-id="' + cartId + '"]').closest('tr');
                        row.find('.total-price').text('₹ ' + response.item_total);
                        
                        // Update subtotal and total
                        $('#subtotal').text('₹ ' + response.subtotal);
                        $('#total').text('₹ ' + response.total);
                    },
                    error: function() {
                        alert('Error updating cart');
                    }
                });
            });
            
            // Remove item functionality
            $('.delete-button').on('click', function() {
                var cartId = $(this).data('cart-id');
                
                if(confirm('Are you sure you want to remove this item?')) {
                    $.ajax({
                        url: '/remove-from-cart',
                        method: 'DELETE',
                        data: {
                            _token: '{{ csrf_token() }}',
                            cart_id: cartId
                        },
                        success: function(response) {
                            // Remove the row
                            $('[data-cart-id="' + cartId + '"]').closest('tr').remove();
                            
                            // Update subtotal and total
                            $('#subtotal').text('₹ ' + response.subtotal);
                            $('#total').text('₹ ' + response.total);
                            
                            // Reload page if cart is empty
                            if($('tbody tr').length === 0) {
                                location.reload();
                            }
                        },
                        error: function() {
                            alert('Error removing item');
                        }
                    });
                }
            });
        });
    </script>

</body>

</html>