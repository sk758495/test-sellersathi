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
                <li class="breadcrumb-item active" aria-current="page">{{ $category->name }}</li>
            </ol>
        </nav>
    </div>
    <!-- subcategory -->

     {{-- Subcategories product list --}}
    <div class="container mt-5">
        <h2 class="text-center mb-4">{{ $category->name }} Colletion</h2>

        @foreach ($subcategoriesWithProducts as $subcategory)
            <div class="mb-5">
                <h4 class="mb-3">{{ $subcategory->name }}</h4>
                <div class="row">
                    @if ($subcategory->products->count() > 0)
                        @foreach ($subcategory->products as $product)
                            <div class="col-lg-4 col-sm-6">
                                <div class="product-item">
                                    <div class="pi-pic">
                                        <a href="{{ route('user.view_product', $product->id) }}">
                                            <img src="{{ asset('storage/' . $product->main_image) }}" alt="">
                                        </a>
                                        @if($product->discount_price < $product->price)
                                            <div class="sale pp-sale">Sale</div>
                                        @endif
                                        <div class="icon">
                                            <i class="icon_heart_alt"></i>
                                        </div>
                                    </div>
                                    <div class="pi-text">
                                        <div class="catagory-name">{{ $subcategory->name }}</div>
                                        <a href="{{ route('user.view_product', $product->id) }}">
                                            <h5>{{ $product->product_name }}</h5>
                                        </a>
                                        <div class="product-price">
                                            ₹ {{ number_format($product->discount_price, 2) }}
                                            @if($product->discount_price < $product->price)
                                                <span>₹ {{ number_format($product->price, 2) }}</span>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                        <div class="col-12 text-right mb-3">
                            <a href="{{ route('user.subcategory_products', $subcategory->id) }}"
                                class="btn btn-outline-primary">
                                View All {{ $subcategory->name }} Products
                            </a>
                        </div>
                    @else
                        <div class="col-12">
                            <p class="text-muted text-center">No products available in {{ $subcategory->name }}</p>
                        </div>
                    @endif
                </div>
                <hr>
            </div>
        @endforeach
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
