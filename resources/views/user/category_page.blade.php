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
            <li class="breadcrumb-item active" aria-current="page">Category Page</li>
        </ol>
    </nav>
</div>
<!-- category -->

<div class="container mt-5">
    <div class="row">
        @foreach ($brand_categories as $category)
            <div class="col-4 col-sm-6 col-md-3 mb-4">
                <a href="{{ route('user.category_products', $category->id) }}" style="text-decoration: none; color: black;">
                    <div class="card" id="category-card">
                        @if ($category->images->isNotEmpty())
                            <!-- Display the first image in the images collection -->
                            <img src="{{ url('storage/' . $category->images->first()->image) }}" class="card-img-top" alt="Category Image">
                        @else
                            <!-- Fallback image if no image exists -->
                            <img src="{{ asset('path_to_default_image.jpg') }}" class="card-img-top" alt="No Image Available">
                        @endif
                        <div class="card-body">
                            <h5 class="card-title">
                                {{ $category->name }}
                            </h5>
                            <button class="btn btn-primary" id="card-button">
                                <i class="fas fa-arrow-right"></i>
                            </button>
                        </div>
                    </div>
                </a>
            </div>
        @endforeach
        <!-- Add more cards as needed -->
    </div>

</div>
    <!-- New Arriable -->

    <h2 class="text-center"> New Arrivals </h2>
    <div class="container mt-5">
        <div class="row">
            @foreach ($products as $product)
            <div class="col-6 col-sm-6 col-md-4 mb-4">
                <a href="{{ route('user.view_product', $product->id) }}" style="text-decoration: none; color: black; font-weight: 500;">
                <div class="card" id="product-card">
                    <img src="{{ asset('storage/' . $product->main_image) }}" class="card-img-top img-fluid" alt="Product 1">
                    <div class="card-body">
                        <h5 class="card-title">{{ \Illuminate\Support\Str::words($product->product_name, 3, '...') }}</h5>
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