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
    <!-- Modern Category Section -->
    <style>
        .category-section {
            padding: 60px 20px;
            min-height: 50vh;
        }
        .category-heading {
            text-align: center;
            margin-bottom: 50px;
            font-size: 3rem;
            color: #2d3748;
            font-weight: 700;
            letter-spacing: -0.5px;
        }
        .categories-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(320px, 1fr));
            gap: 30px;
            max-width: 1400px;
            margin: 0 auto;
        }
        .category-card {
            background: white;
            border-radius: 20px;
            padding: 0;
            box-shadow: 0 10px 40px rgba(0,0,0,0.15);
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            overflow: hidden;
            position: relative;
            text-decoration: none;
            color: inherit;
        }
        .category-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 4px;
            background: linear-gradient(90deg, #F4631E, #ff8a50);
            transform: scaleX(0);
            transition: transform 0.3s ease;
        }
        .category-card:hover::before {
            transform: scaleX(1);
        }
        .category-card:hover {
            transform: translateY(-8px) scale(1.02);
            box-shadow: 0 20px 60px rgba(0,0,0,0.25);
            text-decoration: none;
            color: inherit;
        }
        .category-card img {
            width: 100%;
            height: 200px;
            object-fit: cover;
            transition: transform 0.3s ease;
        }
        .category-card:hover img {
            transform: scale(1.05);
        }
        .category-card-content {
            padding: 24px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .category-card h3 {
            color: #2d3748;
            font-size: 1.0rem;
            font-weight: 800;
            margin: 0;
            flex: 1;
        }
        .explore-btn {
            background: linear-gradient(135deg, #F4631E, #ff8a50);
            color: white;
            border: none;
            padding: 12px 20px;
            border-radius: 25px;
            font-size: 0.9rem;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            box-shadow: 0 4px 15px rgba(244, 99, 30, 0.3);
            display: flex;
            align-items: center;
            gap: 8px;
        }
        .explore-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(244, 99, 30, 0.4);
        }
        @media (max-width: 768px) {
            .category-heading { font-size: 2.5rem; }
            .categories-grid { grid-template-columns: repeat(auto-fit, minmax(280px, 1fr)); gap: 20px; }
            .category-section { padding: 40px 15px; }
        }
        @media (max-width: 480px) {
            .category-heading { font-size: 2rem; }
            .categories-grid { grid-template-columns: 1fr; }
            .category-card-content { flex-direction: column; gap: 15px; align-items: stretch; }
            .explore-btn { justify-content: center; }
        }
    </style>

    <div class="category-section">
        <h1 class="category-heading">Explore Categories</h1>
        
        <div class="categories-grid">
            @foreach ($brand_categories as $category)
                <a href="{{ route('user.category_products', $category->id) }}" class="category-card">
                    @if ($category->images->isNotEmpty())
                        <img src="{{ url('storage/' . $category->images->first()->image) }}" alt="{{ $category->name }}">
                    @else
                        <img src="{{ asset('assets/img/default-category.jpg') }}" alt="{{ $category->name }}">
                    @endif
                    <div class="category-card-content">
                        <h3>{{ $category->name }}</h3>
                        <button class="explore-btn">Explore →</button>
                    </div>
                </a>
            @endforeach
        </div>
    </div>
        <!-- New Arriable -->

    <section class="product spad">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="section-title">
                        <h2>New Arrivals</h2>
                    </div>
                </div>
            </div>
            <div class="row">
                @foreach ($products->take(8) as $product)
                    <div class="col-lg-3 col-md-6 col-sm-6">
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
                                <div class="catagory-name">{{ $product->brandCategory->name ?? 'Category' }}</div>
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
                @endforeach
            </div>
            <div class="text-center mt-4">
                <a href="{{ route('user.all_product_show_here') }}" class="primary-btn">View More Products</a>
            </div>
        </div>
    </section>


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