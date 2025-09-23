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
                <li class="breadcrumb-item"><a href="{{ route('user.category_page') }}">Gujju Category Page</a></li>
            </ol>
        </nav>
    </div>
    <!-- Category Products ---->

    <div class="container mt-3">
        <div class="row">
            <div class="col-3">
                <h5>Filters</h5>
    
                <form method="GET" action="{{ route('user.gujju_category_products', $category->id) }}">
                    <div class="mb-3">
                        <label for="minPrice" class="form-label">Price Range</label>
                        <input type="range" class="form-range" id="minPrice" name="minPrice" min="0" max="100000" value="{{ request('minPrice', 0) }}">
                        <input type="range" class="form-range" id="maxPrice" name="maxPrice" min="0" max="100000" value="{{ request('maxPrice', 100000) }}">
                        <div id="price-range-display">
                            <span>₹{{ request('minPrice', 0) }} - ₹{{ request('maxPrice', 100000) }}</span>
                        </div>
                    </div>
    
                    <div class="mb-3">
                        <label for="brands" class="form-label">Brand</label>
                        <select name="brand" id="brands" class="form-select">
                            <option value="">All Brands</option>
                            @foreach ($brands as $brand)
                                <option value="{{ $brand->id }}" {{ request('brand') == $brand->id ? 'selected' : '' }}>
                                    {{ $brand->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
    
                    <button type="submit" class="btn btn-primary">Apply Filters</button>
                </form>
            </div>
    
            <div class="col-9">
                <h4>{{ $category->name }} Products</h4>
                <div class="row">
                    @foreach ($products as $product)
                        <div class="col-4 col-sm-6 col-md-3 mb-4">
                            <a href="{{ route('user.view_product', $product->id) }}" style="text-decoration: none; color: black; font-weight: 500;">
                                <div class="card" id="product-card">
                                    <img src="{{ asset('storage/' . $product->main_image) }}" id="c-product" class="card-img-top img-fluid" alt="Product 1">
                                    <div class="card-body">
                                        <div id="main_products_align">
                                            <h5 class="card-title">{{ \Illuminate\Support\Str::words($product->product_name, 8, '...') }}</h5>
                                            <p class="card-text">₹{{ $product->discount_price }}</p>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
    
    <script>
        // Get references to the range inputs and display element
        const minPriceInput = document.getElementById('minPrice');
        const maxPriceInput = document.getElementById('maxPrice');
        const priceRangeDisplay = document.getElementById('price-range-display');
    
        // Update the display whenever the input values change
        minPriceInput.addEventListener('input', updatePriceRange);
        maxPriceInput.addEventListener('input', updatePriceRange);
    
        function updatePriceRange() {
            const minPrice = minPriceInput.value;
            const maxPrice = maxPriceInput.value;
            priceRangeDisplay.innerHTML = `<span>₹${minPrice} - ₹${maxPrice}</span>`;
        }
    
        // Initial call to update the display
        updatePriceRange();
    </script>

    <script>
        function updateMinPriceLabel(value) {
            document.getElementById('minPriceLabel').textContent = value;
        }

        function updateMaxPriceLabel(value) {
            document.getElementById('maxPriceLabel').textContent = value;
        }
    </script>

    <!-- New Arrivals Section with Improved UI -->
<h2 class="text-center mb-4">New Arrivals</h2>
<div class="container mt-5">
    <div class="row">
        @foreach ($products as $product)
            <div class="col-6 col-sm-6 col-md-4 col-lg-4 mb-4">
                <div class="product-item">
                    <div class="pi-pic position-relative">
                        <a href="{{ route('user.view_product', $product->id) }}">
                            <img src="{{ asset('storage/' . $product->main_image) }}" class="img-fluid" alt="{{ $product->product_name }}">
                        </a>
                        @if ($product->discount_price < $product->price)
                            <div class="sale pp-sale position-absolute top-0 start-0 bg-danger text-white px-2 py-1" style="font-size: 12px;">Sale</div>
                        @endif
                        <div class="icon position-absolute top-0 end-0 p-2">
                            <i class="icon_heart_alt"></i>
                        </div>
                    </div>
                    <div class="pi-text mt-2">
                        <div class="catagory-name text-muted small">
                            {{ $product->brandCategory->name ?? 'Category' }}
                        </div>
                        <a href="{{ route('user.view_product', $product->id) }}">
                            <h5 class="fs-6 fw-bold">
                                {{ \Illuminate\Support\Str::words($product->product_name, 8, '...') }}
                            </h5>
                        </a>
                        <div class="product-price mt-1">
                            ₹ {{ number_format($product->discount_price, 2) }}
                            @if ($product->discount_price < $product->price)
                                <span class="text-decoration-line-through text-muted ms-2">
                                    ₹ {{ number_format($product->price, 2) }}
                                </span>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        @endforeach

        <div class="col-12 d-flex justify-content-end align-items-center mt-3">
            <h5 class="card-title mb-0 me-2">View More...</h5>
            <a href="{{ route('user.category_page') }}" class="btn btn-primary" id="card-button">
                <i class="fas fa-arrow-right"></i>
            </a>
        </div>
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