<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gujju E-Market</title>
    <link rel="stylesheet" href="{{ asset('user/css/dashboard.css') }}">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="icon" href="{{ asset('user/images/gujju-logo-removebg.png') }}" sizes="32x32" type="image/x-icon">

</head>

<body>
    @include('seller-user.navbar')
    <!-- Carousel Section (Banner) -->
    {{-- <div class="container-x" id="carousel-banner">
        <div id="carouselExampleFade" class="carousel slide carousel-fade" data-bs-ride="carousel" data-bs-interval="3000">
            <div class="carousel-inner">
                @foreach($carouselImages as $index => $carouselImage)
                    <div class="carousel-item {{ $index == 0 ? 'active' : '' }}">
                        <img src="{{ asset('storage/' . $carouselImage->image_path) }}" class="d-block w-100 img-fluid" alt="...">
                        <div class="carousel-caption d-none d-md-block">
                            <div class="btn btn-success" id="carasoul-button">
                                <a href="{{ route('user.all_product_show_here') }}" class="text-white text-decoration-none">Shop</a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <!-- Carousel Indicators -->
            <div class="carousel-indicators">
                @foreach($carouselImages as $index => $carouselImage)
                    <button type="button" data-bs-target="#carouselExampleFade" data-bs-slide-to="{{ $index }}" class="{{ $index == 0 ? 'active' : '' }}" aria-current="true" aria-label="Slide {{ $index + 1 }}"></button>
                @endforeach
            </div>

            <!-- Previous and Next Controls -->
            <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleFade" data-bs-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Previous</span>
            </button>
            <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleFade" data-bs-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Next</span>
            </button>
        </div>

    </div> --}}


    <!-- Body Section -->

    <!-- category -->

    {{-- <div class="container mt-5" style="text-align: center!important;">
        <div class="row" id="category-card-row" style="text-align: center!important;">
            @foreach ($brand_categories as $category)
            <div class="col-4 col-sm-6 col-md-2 mb-4">
                <a href="{{ route('user.category_products', $category->id) }}" style="text-decoration: none;">
                <div class="card" id="category-card">
                    @if ($category->images->isNotEmpty())
                            <!-- Display the first image in the images collection -->
                            <img src="{{ url('storage/' . $category->images->first()->image) }}" class="card-img-top" alt="Category Image">
                        @else
                            <!-- Fallback image if no image exists -->
                            <img src="{{ asset('path_to_default_image.jpg') }}" class="card-img-top" alt="No Image Available">
                        @endif
                    <div class="" style="text-align: center !important;">
                        <h5 class="card-title-x" id="cart-xy" style="text-align: center !important;">{{ $category->name }}</h5>
                     </div>
                </div>
                </a>
            </div>
            @endforeach --}}


            {{-- <div class="col-12 col-sm-6 col-md-12 mb-4">


                <div class="" style="text-align: right; justify-content:right ; display: flex;">
                    <h5 class="card-title">
                        <a href="{{ route('user.category_page') }}" style="text-decoration: none; color: black;">View More...
                    </h5>
                    <button class="btn btn-primary" id="card-button">
                            <i class="fas fa-arrow-right"></i>
                        </button>
                    </a>
                </div>

            </div> --}}

            <!-- Add more cards as needed -->
        </div>

    </div>


    <!-- Bank Offer

    <div class="container mt-lg-0">
        <div class="row">
            <div class="col-6 col-sm-6 col-md-6 mb-4">
                <div class="card" id="product-card">
                    <img src="{{ asset('user/images/bank-offer-1.png') }}" class="card-img-top img-fluid" alt="Product 1">
                </div>
            </div>
            <div class="col-6 col-sm-6 col-md-6 mb-4">
                <div class="card" id="product-card">
                    <img src="{{ asset('user/images/bank-offer-2.png') }}" class="card-img-top" alt="Product 2">
                </div>
            </div>
            <div class="" style="text-align: right; justify-content:right ; display: flex;">
                <h5 class="card-title">View More...</h5>
                <button class="btn btn-primary" id="card-button">
                    <i class="fas fa-arrow-right"></i>
                </button>
            </div>
        </div>
    </div>
-->
    <!-- New Arriable -->

    <h2 class="text-center"> Welcome, {{ $sellerAdminName }}! Special Dashboard! </h2>
    <div class="container mt-5">
        <div class="row">
            @foreach ($products as $product)
            <div class="col-6 col-sm-6 col-md-4 mb-4">
                <a href="{{ route('seller-user.product-details', ['sellerAdminId' => $sellerAdminId, 'productId' => $product->id]) }}" style="text-decoration: none;">
                <div class="card" id="product-card">
                    <img src="{{ asset('storage/' . $product->main_image) }}" class="card-img-top img-fluid" alt="Product 1">
                    <div class="card-body">
                        <h5 class="card-title">{{ \Illuminate\Support\Str::words($product->product_name, 5, '...') }}</h5>
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

    {{-- <h2 class="text-center"> Brands </h2> --}}
    {{-- <div class="container-brand mt-0">
        <div class="row">
            @foreach ($brands as $brand)
            <div class="col-2 col-sm-6 col-md-2 mb-4">
                <a href="{{ route('user.brand_category', $brand->id) }}">
                <div class="card" id="brand-image-card">
                    <img src="{{ url('storage/' . $brand->image) }}" class="card-img-top img-fluid" alt="Product 1">
                </div>
            </a>
            </div>
            @endforeach
            <!-- Add more cards as needed -->
        </div>

    </div> --}}


    <!-- Body Section end -->

    <!-- Footer -->
   @include('user.footer');


    <!-- Bootstrap JS (with Popper) -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    
</body>

</html>
