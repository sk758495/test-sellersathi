<!DOCTYPE html>
<html lang="en">

<head>
    <title>Gujju E Market</title>
    @include('user.head')

</head>

<body>

    @include('user.navbar')

    <!-- Body Section -->

    <!-- Category Products ---->

    <div class="container mt-4">
        <div class="row">
            <div>
                <h4>{{ $discountPercentage }}% Discount</h4>
                <div class="row">
                    @if ($discounts->isEmpty())
                        <!-- Display message if no products are available -->
                        <div class="col-12">
                            <p class="text-center" style="font-size: 18px; color: #6c757d;">
                                Discount products coming soon...
                            </p>
                        </div>
                    @else
                        <!-- Display products if available -->
                        @foreach ($discounts as $discount)
                        <div class="col-4 col-sm-6 col-md-3 mb-4">
                            <a href="{{ route('user.view_discount_product', $discount->id) }}" style="text-decoration: none; color: black; font-weight: 500;">
                                <div class="card" id="product-card">
                                    <img src="{{ asset('storage/' . $discount->product->main_image) }}" id="c-product" class="card-img-top img-fluid" alt="Product 1">
                                    <div class="card-body">
                                        <div id="main_products_align">
                                            <!-- Product Name -->
                                            <h5 class="card-title">{{ \Illuminate\Support\Str::words($discount->product->product_name, 8, '...') }}</h5>

                                            <!-- Original Discount Price (Strikethrough) -->
                                            <p class="card-text text-muted" style="text-decoration: line-through;">
                                                ₹{{ number_format($discount->product->discount_price, 2) }}
                                            </p>

                                            <!-- Calculated Discounted Price -->
                                            <p class="card-text" style="font-weight: bold; color: #d9534f;">
                                                ₹{{ number_format($discount->calculated_discounted_price, 2) }}
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        </div>
                        @endforeach
                    @endif
                </div>
            </div>
        </div>
    </div>


    <script>
        function updateMinPriceLabel(value) {
            document.getElementById('minPriceLabel').textContent = value;
        }

        function updateMaxPriceLabel(value) {
            document.getElementById('maxPriceLabel').textContent = value;
        }
    </script>


    <!-- Body Section end -->

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
