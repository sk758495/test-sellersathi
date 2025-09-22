<!DOCTYPE html>
<html lang="en">

<head>
    <title>Gujju E Market</title>
    @include('user.head')

</head>

<body>

    @include('user.navbar')
    <!-- Body Section -->
    <div class="container mt-3">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
                <li class="breadcrumb-item"><a href="{{ route('user.category_page') }}">Category Page</a></li>
                <li class="breadcrumb-item active" aria-current="page">Single Products</li>
            </ol>
        </nav>
    </div>
    <!-- Single Products -->

    <!-- New Arriable -->
    <div class="container mt-5">
        <div class="row">
            <div class="col-6 col-sm-6 col-md-6 mb-6">
                <img id="mainImage" src="{{ asset('storage/' . $discount->product->main_image) }}" class="img-fluid" alt="Main Product Image">
                <!---
                <div class="image-container mt-3" style="display: flex; gap: 5px;">
                    <img src="images/product-2.jpg" class="thumbnail" alt="Product Image 1 " onclick="changeImage(this) ">
                    <img src="images/product-1.jpeg " class="thumbnail " alt="Product Image 2" onclick="changeImage(this)">
                    <img src="images/baby-pic.jpeg" class="thumbnail" alt="Product Image 3 " onclick="changeImage(this) ">
                </div>-->
            </div>

            <div class="col-6 col-sm-6 col-md-6 mb-6 ">
                <h2>{{ $discount->product->product_name }}</h2>
                <p class="text-muted ">Category: {{ $discount->product->brandCategory ? $discount->product->brandCategory->name : 'N/A' }}</p>
                <p class="text-muted ">Sku: {{ $discount->product->sku }}</p>
                <!-- Original Discount Price (Strikethrough) -->
                <p class="card-text text-muted" style="text-decoration: line-through;">
                    ₹{{ number_format($discount->product->price, 2) }}
                </p>
                
                <!-- Calculated Discounted Price -->
                <p class="card-text" style="font-weight: bold; color: #d9534f;">
                    ₹{{ number_format($discount->calculated_discounted_price, 2) }}
                </p>
                <p class="mt-3 ">{!! old('short_description', $discount->product->short_description ?? '') !!}</p>

                <div class="mt-3">
                    <h5>Color Variants:</h5>
                    <div>
                        <div class="color-circle" style="background-color: #{{ $discount->product->color_code }};" data-color="{{ $discount->product->color_name }}" onclick="selectColor('{{ $discount->product->color_name }}')"></div>

                    </div>
                </div>


                <div class="mt-4">
                    <button class="btn btn-primary">
                        <a href="{{ route('user.add_cart-new', ['id' => $discount->product->id, 'discount_id' => $discount->id]) }}" style="text-decoration: none; color: white;">
                            Add to Cart
                        </a>
                    </button>
                </div>

            </div>
        </div>
    </div>

    <div class="container mt-5 ">
        <div class="row ">
            <hr class="my-4 ">
            <div class="col-12 col-sm-6 col-md-12 mb-6 ">
                <h4>Description</h4>
                <p>{!! old('long_description', $discount->product->long_description ?? '') !!}</p>
            </div>
            <div class="col-12 col-sm-6 col-md-12 mb-6 ">
                <h4>Features</h4>
                <ul class="feature-list ">
                    {!! old('features', $discount->product->features ?? '') !!}

                </ul>
            </div>
            <!---
            <div class="col-12 col-sm-6 col-md-12 mb-6 ">
                <h4>Specifications</h4>
                <ul class="spec-list ">
                    <li>Specification 1</li>
                    <li>Specification 2</li>
                    <li>Specification 3</li>
                </ul>
            </div>-->
            <div class="col-12 col-sm-6 col-md-12 mb-6 ">
                <h4>What's Included</h4>
                <ul class="included-list ">
                    {!! old('whats_included', $discount->product->whats_included ?? '') !!}

                </ul>
            </div>
        </div>
    </div>

    {{-- <div class="container mt-5 ">
        <div class="row ">
            <div class="col-12 ">
                <hr class="my-4 ">
                <h4>Customer Reviews</h4>

            </div>
            <div class="col-12 col-sm-6 col-md-12 mb-12 ">
                <h5>Sunil Chauhan</h5>
                <p>⭐⭐⭐⭐⭐</p>
                <p>Great product! Highly recommend.</p>
            </div>
            <div class="col-12 col-sm-6 col-md-12 mb-12 ">
                <h5>Nilesh Bhatiya</h5>
                <p>⭐⭐⭐⭐</p>
                <p>nice</p>
            </div>
            <div class="col-12 col-sm-6 col-md-12 mb-12 ">
                <h5>Rajib Kanojiya</h5>
                <p>⭐⭐⭐⭐⭐</p>
                <p>Customer helping support is good</p>
            </div>
            <div class="col-12 col-sm-6 col-md-12 mb-12 ">
                <h5>Suresh Bharwad</h5>
                <p>⭐⭐⭐⭐</p>
                <p>Delievery System is good.</p>
            </div>
        </div>
    </div> --}}

    <script>
        function selectColor(color) {
            alert("You selected: " + color);
            // Add additional logic for color selection here if needed
        }
    </script>

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