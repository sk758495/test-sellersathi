<!DOCTYPE html>
<html lang="en">

<head>
    <title>Gujju E Market</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    @include('user.head')
    <style>
        .produts-sidebar-filter {
            position: sticky;
            top: 20px;
            height: fit-content;
            max-height: calc(100vh - 40px);
            overflow-y: auto;
            background: #fff;
            border-radius: 12px;
            box-shadow: 0 0px 3px rgba(0, 0, 0, 0.1);
            padding: 20px;
        }

        .filter-widget {
            margin-bottom: 25px;
            border-bottom: 1px solid #f0f0f0;
            padding-bottom: 20px;
        }

        .fw-title {
            font-size: 16px;
            font-weight: 600;
            color: #333;
            margin-bottom: 15px;
            padding-bottom: 8px;
            border-bottom: 2px solid #F4631E;
            display: inline-block;
        }

        .filter-catagories {
            list-style: none;
            padding: 0;
            margin: 0;
        }

        .filter-catagories a {
            color: #666;
            text-decoration: none;
            padding: 8px 12px;
            border-radius: 6px;
            display: block;
            transition: all 0.3s ease;
            margin-bottom: 5px;
        }

        .filter-catagories a:hover {
            background: #F4631E;
            color: white;
            text-decoration: none;
        }

        .fw-brand-check label {
            display: flex;
            align-items: center;
            cursor: pointer;
            padding: 8px;
            border-radius: 6px;
            transition: background 0.3s ease;
        }

        .filter-btn {
            background: #F4631E;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 6px;
            text-decoration: none;
            display: inline-block;
            font-weight: 500;
        }

        .fw-color-choose {
            display: flex;
            flex-wrap: wrap;
            gap: 10px;
        }

        .cs-item label {
            width: 30px;
            height: 30px;
            border-radius: 50%;
            cursor: pointer;
            border: 2px solid #ddd;
            display: block;
        }

        .fw-size-choose {
            display: flex;
            flex-wrap: wrap;
            gap: 8px;
        }

        .sc-item label {
            padding: 8px 12px;
            border: 1px solid #ddd;
            border-radius: 6px;
            cursor: pointer;
            font-size: 14px;
        }

        .fw-tags {
            display: flex;
            flex-wrap: wrap;
            gap: 8px;
        }

        .fw-tags a {
            padding: 6px 12px;
            background: #f8f9fa;
            color: #666;
            text-decoration: none;
            border-radius: 20px;
            font-size: 12px;
        }

        .form-select {
            width: 100%;
            padding: 10px 12px;
            border: 1px solid #ddd;
            border-radius: 6px;
            font-size: 14px;
            background: white;
            cursor: pointer;
        }

        .select2-container {
            width: 100% !important;
        }

        .select2-selection {
            border: 1px solid #ddd !important;
            border-radius: 6px !important;
            padding: 8px !important;
            min-height: 40px !important;
        }

        .select2-selection__rendered {
            color: #333 !important;
            font-size: 14px !important;
        }

        .select2-dropdown {
            border-radius: 6px !important;
            border: 1px solid #ddd !important;
        }

        @media (max-width: 991px) {
            .produts-sidebar-filter {
                position: relative;
                top: auto;
                max-height: none;
            }
        }

        .category-section {
            border-bottom: 1px solid #eee;
            padding-bottom: 30px;
        }

        .section-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            border-bottom: 2px solid #F4631E;
            padding-bottom: 10px;
        }

        .category-title {
            font-size: 24px;
            font-weight: 600;
            color: #333;
            margin: 0;
        }

        .view-all-link {
            color: #F4631E;
            text-decoration: none;
            font-weight: 500;
            transition: color 0.3s ease;
        }

        .view-all-link:hover {
            color: #d4541a;
            text-decoration: none;
        }
    </style>
</head>

<body>
    @include('user.navbar')

    <!-- Product Shop Section Begin -->
    <section class="product-shop spad">
        <div class="container">
            <div class="row">
                <div class="col-lg-3 col-md-6 col-sm-8 order-2 order-lg-1 produts-sidebar-filter">
                    <div class="filter-widget">
                        <h4 class="fw-title">Categories</h4>
                        <select class="form-select category-select" id="categoryFilter">
                            <option value="">All Categories</option>
                            @foreach ($brand_categories as $category)
                                <option value="{{ $category->id }}">{{ $category->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="filter-widget">
                        <h4 class="fw-title">Brand</h4>
                        <select class="form-select brand-select" id="brandFilter">
                            <option value="">All Brands</option>
                            @foreach ($brands as $brand)
                                <option value="{{ $brand->id }}">{{ $brand->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="filter-widget">
                        <h4 class="fw-title">Price Range</h4>
                        <div class="price-inputs">
                            <input type="number" id="minPrice" placeholder="Min Price" class="form-control mb-2">
                            <input type="number" id="maxPrice" placeholder="Max Price" class="form-control mb-2">
                        </div>
                    </div>
                    {{-- <div class="filter-widget">
                        <h4 class="fw-title">Color</h4>
                        <div class="fw-color-choose">
                            <div class="cs-item">
                                <input type="radio" id="cs-black">
                                <label class="cs-black" for="cs-black">Black</label>
                            </div>
                            <div class="cs-item">
                                <input type="radio" id="cs-violet">
                                <label class="cs-violet" for="cs-violet">Violet</label>
                            </div>
                            <div class="cs-item">
                                <input type="radio" id="cs-blue">
                                <label class="cs-blue" for="cs-blue">Blue</label>
                            </div>
                            <div class="cs-item">
                                <input type="radio" id="cs-yellow">
                                <label class="cs-yellow" for="cs-yellow">Yellow</label>
                            </div>
                            <div class="cs-item">
                                <input type="radio" id="cs-red">
                                <label class="cs-red" for="cs-red">Red</label>
                            </div>
                            <div class="cs-item">
                                <input type="radio" id="cs-green">
                                <label class="cs-green" for="cs-green">Green</label>
                            </div>
                        </div>
                    </div> --}}
                    {{--                    
                    <div class="filter-widget">
                        <h4 class="fw-title">Tags</h4>
                        <div class="fw-tags">
                            <a href="#">phone</a>
                            <a href="#">apple</a>
                            <a href="#">laptop</a>
                            <a href="#">Usb cable</a>
                            <a href="#">speakers</a>
                            <a href="#">CCTC</a>
                            <a href="#">Digital Cameras</a>
                        </div>
                    </div> --}}
                </div>
                <div class="col-lg-9 order-1 order-lg-2">
                    <div class="product-show-option">
                        <div class="row">
                            <div class="col-lg-7 col-md-7">
                                <div class="select-option">
                                    <select class="sorting">
                                        <option value="">Default Sorting</option>
                                    </select>
                                    <select class="p-show">
                                        <option value="">Show:</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-5 col-md-5 text-right">
                                <p>Show All Products By Categories</p>
                            </div>
                        </div>
                    </div>

                    <!-- Products by Category Sections -->
                    <div id="productsContainer">
                        @foreach ($productsByCategory as $category)
                            @if ($category->products->count() > 0)
                                <div class="category-section mb-5">
                                    <div class="section-header mb-4">
                                        <h3 class="category-title">{{ $category->name }}</h3>
                                        <a href="{{ route('user.category_products', $category->id) }}"
                                            class="view-all-link">View All {{ $category->name }} →</a>
                                    </div>
                                    <div class="product-list">
                                        <div class="row">
                                            @foreach ($category->products->take(6) as $product)
                                                <div class="col-4 col-sm-4 col-md-4 col-lg-4 col-xl-4 col-xxl-4 mb-4">
                                                    <div class="product-item">
                                                        <div class="pi-pic">
                                                            <a href="{{ route('user.view_product', $product->id) }}">
                                                                <img src="{{ asset('storage/' . $product->main_image) }}"
                                                                    alt="">
                                                            </a>
                                                            @if ($product->discount_price < $product->price)
                                                                <div class="sale pp-sale">Sale</div>
                                                            @endif
                                                            <div class="icon">
                                                                <i class="icon_heart_alt"></i>
                                                            </div>
                                                        </div>
                                                        <div class="pi-text">
                                                            <div class="catagory-name">
                                                                {{ $product->brandCategory->name ?? 'Category' }}</div>
                                                            <a href="{{ route('user.view_product', $product->id) }}">
                                                                <h5 class="fs-6 fs-sm-5 fs-md-4 fs-lg-3 fs-xl-2">
                                                                    {{ Str::words($product->product_name, 8, '...') }}
                                                                </h5>
                                                            </a>
                                                            <div class="product-price">
                                                                ₹ {{ number_format($product->discount_price, 2) }}
                                                                @if ($product->discount_price < $product->price)
                                                                    <span>₹
                                                                        {{ number_format($product->price, 2) }}</span>
                                                                @endif
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                            @endif
                        @endforeach
                    </div>

                    {{-- <div class="loading-more">
                        <i class="icon_loading"></i>
                        <a href="#">
                            Loading More
                        </a>
                    </div> --}}
                </div>
            </div>
        </div>
    </section>
    <!-- Product Shop Section End -->

    <!-- Partner Logo Section -->
    <div class="partner-logo">
        <div class="container">
            <div class="logo-carousel owl-carousel">
                @foreach ($brands as $brand)
                    <div class="logo-item">
                        <div class="tablecell-inner">
                            @if ($brand->image)
                                <a href="{{ route('user.brand_category', $brand->id) }}">
                                    <img src="{{ url('storage/' . $brand->image) }}" alt="{{ $brand->name }}">
                                </a>
                            @else
                                <img src="{{ asset('path_to_default_logo.png') }}" alt="No Logo">
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
    <!-- Partner Logo Section End -->


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

    <!-- Select2 CSS and JS -->
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

    <script>
        $(document).ready(function() {
            // Initialize Select2
            $('#categoryFilter, #brandFilter').select2({
                placeholder: function() {
                    return $(this).data('placeholder');
                },
                allowClear: true,
                width: '100%'
            });

            // Dynamic filtering function
            function applyFilters() {
                var filters = {
                    category_id: $('#categoryFilter').val(),
                    brand_id: $('#brandFilter').val(),
                    min_price: $('#minPrice').val(),
                    max_price: $('#maxPrice').val(),
                    color: $('input[name="color"]:checked').val()
                };

                $.ajax({
                    url: '{{ route('user.dynamic_filter') }}',
                    method: 'POST',
                    data: filters,
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function(response) {
                        if (response.success) {
                            updateProductDisplay(response.productsByCategory);
                        }
                    },
                    error: function() {
                        console.log('Filter request failed');
                    }
                });
            }

            // Update product display
            function updateProductDisplay(productsByCategory) {
                var html = '';

                $.each(productsByCategory, function(index, category) {
                    if (category.products && category.products.length > 0) {
                        html += '<div class="category-section mb-5">';
                        html += '<div class="section-header mb-4">';
                        html += '<h3 class="category-title">' + category.name + '</h3>';
                        html += '</div>';
                        html += '<div class="product-list"><div class="row">';

                        $.each(category.products.slice(0, 6), function(i, product) {
                            html += '<div class="col-lg-4 col-sm-6 mb-4">';
                            html += '<div class="product-item">';
                            html += '<div class="pi-pic">';
                            html += '<a href="/view-product/' + product.id + '">';
                            html += '<img src="/storage/' + product.main_image + '" alt="">';
                            html += '</a>';
                            if (product.discount_price < product.price) {
                                html += '<div class="sale pp-sale">Sale</div>';
                            }
                            html += '<div class="icon"><i class="icon_heart_alt"></i></div>';
                            html += '</div>';
                            html += '<div class="pi-text">';
                            html += '<div class="catagory-name">' + (product.brand_category ?
                                product.brand_category.name : 'Category') + '</div>';
                            html += '<a href="/view-product/' + product.id + '">';
                            html += '<h5>' + product.product_name.split(' ').slice(0, 8).join(' ') +
                                (product.product_name.split(' ').length > 8 ? '...' : '') + '</h5>';
                            html += '</a>';
                            html += '<div class="product-price">';
                            html += '₹ ' + parseFloat(product.discount_price).toFixed(2);
                            if (product.discount_price < product.price) {
                                html += '<span>₹ ' + parseFloat(product.price).toFixed(2) +
                                    '</span>';
                            }
                            html += '</div></div></div></div>';
                        });

                        html += '</div></div></div>';
                    }
                });

                $('#productsContainer').html(html);
            }

            // Bind filter events
            $('#categoryFilter, #brandFilter').on('change', applyFilters);
            $('#minPrice, #maxPrice').on('input', debounce(applyFilters, 500));
            $('input[name="color"]').on('change', applyFilters);

            // Debounce function
            function debounce(func, wait) {
                let timeout;
                return function executedFunction(...args) {
                    const later = () => {
                        clearTimeout(timeout);
                        func(...args);
                    };
                    clearTimeout(timeout);
                    timeout = setTimeout(later, wait);
                };
            }
        });
    </script>

</body>

</html>
