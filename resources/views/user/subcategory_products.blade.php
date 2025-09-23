<!DOCTYPE html>
<html lang="en">

<head>
    <title>Gujju E Market</title>
    @include('user.head')
</head>

<body>

@include('user.navbar')

<div class="container mt-3">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
            <li class="breadcrumb-item"><a href="{{ route('user.category_page') }}">Category Page</a></li>
            <li class="breadcrumb-item"><a href="{{ route('user.category_products', $subcategory->brand_category_id) }}">{{ $subcategory->brandCategory->name }}</a></li>
            <li class="breadcrumb-item active" aria-current="page">{{ $subcategory->name }}</li>
        </ol>
    </nav>
</div>

<!-- Product Shop Section Begin -->
<section class="product-shop spad">
    <div class="container">
        <div class="row">
            <div class="col-lg-3 col-md-6 col-sm-8 order-2 order-lg-1 produts-sidebar-filter">
                <div class="filter-widget">
                    <h4 class="fw-title">Categories</h4>
                    <ul class="filter-catagories">
                        @foreach($brand_categories as $category)
                            <li><a href="{{ route('user.category_products', $category->id) }}">{{ $category->name }}</a></li>
                        @endforeach
                    </ul>
                </div>
                <div class="filter-widget">
                    <h4 class="fw-title">Brand</h4>
                    <div class="fw-brand-check">
                        @foreach($brands as $brand)
                        <div class="bc-item">
                            <label for="bc-{{ $brand->id }}">
                                {{ $brand->name }}
                                <input type="checkbox" id="bc-{{ $brand->id }}">
                                <span class="checkmark"></span>
                            </label>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
            <div class="col-lg-9 order-1 order-lg-2">
                <div class="product-show-option">
                    <div class="row">
                        <div class="col-lg-7 col-md-7">
                            <div class="select-option">
                                <select class="sorting">
                                    <option value="">Default Sorting</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-5 col-md-5 text-right">
                            <p>{{ $subcategory->name }} Products</p>
                        </div>
                    </div>
                </div>
                <div class="product-list">
                    <div class="row">
                        @forelse($products as $product)
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
                                            <h5>{{ Str::words($product->product_name, 8, '...') }}</h5>
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
                        @empty
                            <div class="col-12 text-center">
                                <h4>No products found in this subcategory</h4>
                                <p>Please check other categories or try again later.</p>
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- Product Shop Section End -->

@include('user.footer')

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