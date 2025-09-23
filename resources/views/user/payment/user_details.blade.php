<!DOCTYPE html>
<html lang="en">

<head>
    <title>Gujju E Market</title>
    @include('user.head')
</head>

<body>
    @include('user.navbar')

    <!-- Breadcrumb Section -->
    <div class="container mt-3">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
                <li class="breadcrumb-item"><a href="{{ route('user.cart') }}">Cart</a></li>
                <li class="breadcrumb-item active" aria-current="page">Checkout</li>
            </ol>
        </nav>
    </div>

    <!-- Shopping Cart Section Begin -->
    <section class="checkout-section spad">
        <div class="container">
            <form action="{{ route('user.save_address') }}" method="POST" class="checkout-form">
                @csrf
                <div class="row">
                    <div class="col-lg-6">
                        @if (!$addresses->isEmpty())
                        <div class="checkout-content">
                            <a href="#" class="content-btn" id="saved-addresses-btn">
                                <i class="fas fa-map-marker-alt"></i>
                                Use Saved Address
                            </a>
                        </div>
                        @endif
                        <h4>Delivery Address</h4>
                        
                        @if (!$addresses->isEmpty())
                        <div class="saved-addresses-container" id="saved-addresses" style="display:none;">
                            <div class="saved-addresses-header">
                                <i class="fas fa-map-marker-alt"></i>
                                <span>Choose from saved addresses</span>
                            </div>
                            <div class="addresses-list">
                                @foreach ($addresses as $address)
                                <div class="address-card" data-address-id="{{ $address->id }}">
                                    <div class="address-radio">
                                        <input type="radio" name="saved_address_id" id="address{{ $address->id }}" value="{{ $address->id }}">
                                        <span class="radio-checkmark"></span>
                                    </div>
                                    <div class="address-content">
                                        <div class="address-main">{{ $address->address_line1 }}</div>
                                        <div class="address-details">{{ $address->city }}, {{ $address->state }}, {{ $address->country }} - {{ $address->postal_code }}</div>
                                    </div>
                                    <div class="address-actions">
                                        <i class="fas fa-check-circle address-selected-icon"></i>
                                    </div>
                                </div>
                                @endforeach
                            </div>
                            <div class="saved-addresses-footer">
                                <button type="button" class="use-address-btn" id="use-saved-address">
                                    <i class="fas fa-check"></i>
                                    Use Selected Address
                                </button>
                            </div>
                        </div>
                        @endif

                        <div class="row" id="new-address-fields">
                            <div class="col-lg-6">
                                <label for="country">Country<span>*</span></label>
                                <input type="text" id="country" name="country" required>
                            </div>
                            <div class="col-lg-6">
                                <label for="state">State<span>*</span></label>
                                <input type="text" id="state" name="state" required>
                            </div>
                            <div class="col-lg-12">
                                <label for="address_line1">Street Address<span>*</span></label>
                                <input type="text" id="address_line1" name="address_line1" class="street-first" required>
                                <input type="text" name="address_line2" placeholder="Apartment, suite, etc. (optional)">
                            </div>
                            <div class="col-lg-6">
                                <label for="city">Town / City<span>*</span></label>
                                <input type="text" id="city" name="city" required>
                            </div>
                            <div class="col-lg-6">
                                <label for="postal_code">Postcode / ZIP<span>*</span></label>
                                <input type="text" id="postal_code" name="postal_code" required>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="place-order">
                            <h4>Your Order</h4>
                            <div class="order-total">
                                <ul class="order-table">
                                    <li>Product <span>Total</span></li>
                                    @php $total = 0; @endphp
                                    @if(session('cart'))
                                        @foreach(session('cart') as $item)
                                            @php $total += $item['price'] * $item['quantity']; @endphp
                                            <li class="fw-normal">{{ $item['name'] }} x {{ $item['quantity'] }} <span>₹ {{ number_format($item['price'] * $item['quantity'], 2) }}</span></li>
                                        @endforeach
                                    @else
                                        <li class="fw-normal">No items in cart <span>₹0.00</span></li>
                                    @endif
                                    <li class="fw-normal">Subtotal <span>₹ {{ number_format($total, 2) }}</span></li>
                                    <li class="total-price">Total <span>₹ {{ number_format($total, 2) }}</span></li>
                                </ul>
                                <div class="payment-check">
                                    <div class="pc-item">
                                        <label for="pc-cod">
                                            Cash on Delivery
                                            <input type="radio" id="pc-cod" name="payment_method" value="cod" checked>
                                            <span class="checkmark"></span>
                                        </label>
                                    </div>
                                    <div class="pc-item">
                                        <label for="pc-online">
                                            Online Payment
                                            <input type="radio" id="pc-online" name="payment_method" value="online">
                                            <span class="checkmark"></span>
                                        </label>
                                    </div>
                                </div>
                                <div class="order-btn">
                                    <button type="submit" class="site-btn place-btn">Save Address & Continue</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </section>
    <!-- Shopping Cart Section End -->

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

    <style>
        .saved-addresses-container {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border-radius: 15px;
            margin-bottom: 30px;
            overflow: hidden;
            box-shadow: 0 10px 30px rgba(102, 126, 234, 0.2);
            animation: slideDown 0.3s ease-out;
        }
        
        @keyframes slideDown {
            from { opacity: 0; transform: translateY(-10px); }
            to { opacity: 1; transform: translateY(0); }
        }
        
        .saved-addresses-header {
            background: rgba(255, 255, 255, 0.1);
            padding: 20px;
            color: white;
            font-weight: 600;
            font-size: 16px;
            display: flex;
            align-items: center;
            gap: 10px;
        }
        
        .saved-addresses-header i {
            font-size: 18px;
        }
        
        .addresses-list {
            padding: 20px;
            background: white;
        }
        
        .address-card {
            background: #f8f9fa;
            border: 2px solid #e9ecef;
            border-radius: 12px;
            padding: 20px;
            margin-bottom: 15px;
            cursor: pointer;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            display: flex;
            align-items: center;
            gap: 15px;
            position: relative;
            overflow: hidden;
        }
        
        .address-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 4px;
            height: 100%;
            background: #F4631E;
            transform: scaleY(0);
            transition: transform 0.3s ease;
        }
        
        .address-card:hover {
            border-color: #F4631E;
            background: #fff;
            box-shadow: 0 8px 25px rgba(244, 99, 30, 0.15);
            transform: translateY(-2px);
        }
        
        .address-card:hover::before {
            transform: scaleY(1);
        }
        
        .address-card.selected {
            border-color: #F4631E;
            background: #fff8f5;
            box-shadow: 0 8px 25px rgba(244, 99, 30, 0.2);
        }
        
        .address-card.selected::before {
            transform: scaleY(1);
        }
        
        .address-radio {
            position: relative;
            width: 24px;
            height: 24px;
        }
        
        .address-radio input[type="radio"] {
            opacity: 0;
            position: absolute;
            width: 100%;
            height: 100%;
            margin: 0;
            cursor: pointer;
        }
        
        .radio-checkmark {
            position: absolute;
            top: 0;
            left: 0;
            width: 24px;
            height: 24px;
            background: white;
            border: 2px solid #dee2e6;
            border-radius: 50%;
            transition: all 0.3s ease;
        }
        
        .radio-checkmark::after {
            content: '';
            position: absolute;
            top: 50%;
            left: 50%;
            width: 12px;
            height: 12px;
            background: #F4631E;
            border-radius: 50%;
            transform: translate(-50%, -50%) scale(0);
            transition: transform 0.2s ease;
        }
        
        .address-card input[type="radio"]:checked + .radio-checkmark {
            border-color: #F4631E;
        }
        
        .address-card input[type="radio"]:checked + .radio-checkmark::after {
            transform: translate(-50%, -50%) scale(1);
        }
        
        .address-content {
            flex: 1;
        }
        
        .address-main {
            font-weight: 600;
            color: #2d3748;
            font-size: 16px;
            margin-bottom: 5px;
        }
        
        .address-details {
            color: #718096;
            font-size: 14px;
            line-height: 1.4;
        }
        
        .address-actions {
            opacity: 0;
            transition: opacity 0.3s ease;
        }
        
        .address-card.selected .address-actions {
            opacity: 1;
        }
        
        .address-selected-icon {
            color: #48bb78;
            font-size: 20px;
        }
        
        .saved-addresses-footer {
            padding: 20px;
            background: white;
            border-top: 1px solid #e9ecef;
        }
        
        .use-address-btn {
            background: linear-gradient(135deg, #48bb78 0%, #38a169 100%);
            color: white;
            border: none;
            padding: 12px 25px;
            border-radius: 25px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            gap: 8px;
            margin: 0 auto;
        }
        
        .use-address-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(72, 187, 120, 0.3);
        }
        
        .checkout-content .content-btn {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 12px 25px;
            border-radius: 25px;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            margin-bottom: 20px;
            transition: all 0.3s ease;
            font-weight: 600;
            box-shadow: 0 4px 15px rgba(102, 126, 234, 0.3);
        }
        
        .checkout-content .content-btn:hover {
            background: linear-gradient(135deg, #5f3dc4 0%, #6c5ce7 100%);
            color: white;
            text-decoration: none;
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(102, 126, 234, 0.4);
        }
    </style>

    <script>
        $(document).ready(function() {
            // Toggle saved addresses
            $('#saved-addresses-btn').click(function(e) {
                e.preventDefault();
                $('#saved-addresses').slideToggle(300, function() {
                    // After animation completes, check visibility
                    if ($('#saved-addresses').is(':visible')) {
                        $('#new-address-fields').slideUp(200);
                    } else {
                        $('#new-address-fields').slideDown(200);
                    }
                });
            });

            // Address card selection
            $('.address-card').click(function() {
                $('.address-card').removeClass('selected');
                $(this).addClass('selected');
                $(this).find('input[type="radio"]').prop('checked', true);
            });

            // Use saved address functionality
            $('#use-saved-address').click(function() {
                var selectedAddress = $('input[name="saved_address_id"]:checked');
                if (selectedAddress.length > 0) {
                    var form = $('<form method="POST" action="{{ route('user.select_address') }}">').append(
                        $('<input type="hidden" name="_token" value="{{ csrf_token() }}">'),
                        $('<input type="hidden" name="address_id" value="' + selectedAddress.val() + '">')
                    );
                    $('body').append(form);
                    form.submit();
                } else {
                    alert('Please select an address first.');
                }
            });
        });
    </script>

</body>

</html>