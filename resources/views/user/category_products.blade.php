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
                <li class="breadcrumb-item active" aria-current="page">Category Products</li>
            </ol>
        </nav>
    </div>
    <!-- Category Products ---->

    <div class="container mt-4">
        <div class="row">


            <div>
                <h4> {{ $category->name }} Products</h4>
                <div class="row">
                    @foreach ($products as $product)
                        <div class="col-4 col-sm-6 col-md-3 mb-4">
                            <a href="{{ route('user.view_product', $product->id) }}"
                                style="text-decoration: none; color: black; font-weight: 500;">
                                <div class="card" id="product-card">
                                    <img src="{{ asset('storage/' . $product->main_image) }}" id="c-product"
                                        class="card-img-top img-fluid" alt="Product 1">
                                    <div class="card-body">
                                        <div id="main_products_align">
                                            <h5 class="card-title">
                                                {{ \Illuminate\Support\Str::words($product->product_name, 3, '...') }}
                                            </h5>
                                            <p class="card-text">₹{{ $product->discount_price }}</p>
                                        </div>

                                    </div>
                                </div>
                            </a>
                        </div>
                    @endforeach

                    <!-- Add more cards as needed -->
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



    <h2 class="text-center"> New Arrivals </h2>
    <div class="container mt-5">
        <div class="row">
            @foreach ($products as $product)
                <div class="col-6 col-sm-6 col-md-4 mb-4">
                    <a href="{{ route('user.view_product', $product->id) }}" style="text-decoration: none;">
                        <div class="card" id="product-card">
                            <img src="{{ asset('storage/' . $product->main_image) }}" class="card-img-top img-fluid"
                                id="p-deg" alt="Product 1">
                            <div class="card-body" style="height: 100px;">
                                <h5 class="card-title">
                                    {{ \Illuminate\Support\Str::words($product->product_name, 3, '...') }}</h5>
                                <button class="btn btn-primary" id="card-button">
                                    <i class="fas fa-arrow-right"></i>
                                </button>
                            </div>
                        </div>
                    </a>
                </div>
            @endforeach

            <div class="" style="text-align: right; justify-content:right ; display: flex;">
                <h5 class="card-title">View More...</h5>
                <button class="btn btn-primary" id="card-button">
                    <i class="fas fa-arrow-right"></i>
                </button>
            </div>

        </div>

        <!-- Add more cards as needed -->
    </div>

    </div>


    <!-- Br -->

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


</body>

</html>
