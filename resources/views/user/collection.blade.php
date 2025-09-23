<!DOCTYPE html>
<html lang="en">
<head>
    <title>Collection - Gujju E Market</title>
    @include('user.head')
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: Arial, sans-serif;
            background-color: #f5f5f5;
        }
        .banner {
            background: linear-gradient(135deg, #ff1493, #ff6347, #ffa500);
            height: 200px;
            position: relative;
            overflow: hidden;
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0 50px;
            color: white;
        }

        .banner::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100"><circle cx="20" cy="20" r="2" fill="white" opacity="0.3"/><circle cx="80" cy="30" r="1" fill="yellow" opacity="0.5"/><circle cx="60" cy="70" r="1.5" fill="white" opacity="0.4"/><circle cx="30" cy="80" r="1" fill="yellow" opacity="0.6"/></svg>') repeat;
        }

        .festival-info {
            z-index: 2;
            display: flex;
            align-items: center;
            gap: 20px;
        }

        .festival-badge {
            background: rgba(255,255,255,0.2);
            padding: 20px;
            border-radius: 50%;
            text-align: center;
        }

        .festival-badge h3 {
            font-size: 18px;
            margin-bottom: 5px;
        }

        .festival-badge p {
            font-size: 14px;
        }

        .prime-section {
            background: rgba(255,255,255,0.9);
            color: #333;
            padding: 15px 20px;
            border-radius: 8px;
            text-align: center;
        }

        .prime-btn {
            background: #ff9900;
            color: white;
            padding: 8px 20px;
            border: none;
            border-radius: 4px;
            font-weight: bold;
            margin-top: 10px;
            cursor: pointer;
        }

        .early-deals {
            z-index: 2;
        }

        .early-deals h2 {
            font-size: 48px;
            font-weight: bold;
        }

        .early-deals h3 {
            font-size: 24px;
            color: #ffff00;
        }

        .early-deals p {
            font-size: 18px;
            margin-top: 10px;
        }

        .collections-container {
            max-width: 1400px;
            margin: 20px auto;
            padding: 0 20px;
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(320px, 1fr));
            gap: 20px;
        }

        .collection-card {
            background: white;
            border-radius: 8px;
            padding: 20px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.1);
            transition: transform 0.3s ease;
        }

        .collection-card:hover {
            transform: translateY(-5px);
        }

        .card-title {
            font-size: 18px;
            font-weight: bold;
            margin-bottom: 15px;
            color: #333;
        }

        .products-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 15px;
            margin-bottom: 15px;
        }

        .product-item {
            text-align: center;
            padding: 10px;
            border-radius: 4px;
            background: #f9f9f9;
            transition: background 0.3s ease;
        }

        .product-item:hover {
            background: #e9e9e9;
        }

        .product-image {
            width: 80px;
            height: 80px;
            background: #ddd;
            border-radius: 4px;
            margin: 0 auto 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 12px;
            color: #666;
            overflow: hidden;
        }
        
        .product-image img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .product-name {
            font-size: 12px;
            color: #333;
        }

        .explore-link {
            color: #007185;
            text-decoration: none;
            font-size: 14px;
            font-weight: 500;
        }

        .explore-link:hover {
            text-decoration: underline;
        }

        .headphones-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 10px;
            margin-bottom: 15px;
        }

        .brand-item {
            background: linear-gradient(135deg, #e3f2fd, #f3e5f5);
            padding: 15px;
            border-radius: 8px;
            text-align: center;
        }

        .brand-logo {
            font-weight: bold;
            font-size: 16px;
            margin-bottom: 5px;
        }

        .brand-price {
            font-size: 12px;
            color: #666;
        }

        .signin-card {
            text-align: center;
        }

        .signin-btn {
            background: #ffd814;
            color: #333;
            padding: 12px 30px;
            border: none;
            border-radius: 8px;
            font-weight: bold;
            cursor: pointer;
            width: 100%;
            margin: 20px 0;
        }

        .product-showcase {
            background: #f0f0f0;
            padding: 20px;
            border-radius: 8px;
            text-align: center;
        }

        .showcase-image {
            width: 120px;
            height: 120px;
            background: #ddd;
            border-radius: 8px;
            margin: 0 auto 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #666;
        }

        .product-title {
            font-size: 14px;
            margin-bottom: 5px;
        }

        .product-rating {
            color: #ff9900;
            font-size: 12px;
            margin-bottom: 5px;
        }

        .product-price {
            font-weight: bold;
            color: #B12704;
        }
    </style>
</head>
<body>
    @include('user.navbar')
    
    <!-- Banner Section -->
    {{-- <div class="banner">
        <div class="festival-info">
            <div class="festival-badge">
                <h3>Gujju E-Market Sales</h3>
                <p>Starts 13th Sept</p>
            </div>
            <div class="prime-section">
                <p>Starts 24 hours early for Prime members</p>
                <button class="prime-btn">Join Prime now</button>
            </div>
        </div>
        <div class="early-deals">
            <h2>Early Deals</h2>
            <h3>Live now</h3>
            <p>Grab festive deals before the sale</p>
        </div>
    </div> --}}

    <!-- Collections Container -->
    <div class="collections-container">
        @foreach($collections as $collection)
        <div class="collection-card">
            <h3 class="card-title">{{ $collection->name }} Collection</h3>
            <div class="products-grid">
                @foreach($collection->subcategories->take(4) as $subcategory)
                    <a href="{{ route('user.subcategory_products', $subcategory->id) }}" class="product-item">
                        <div class="product-image">
                            @if($subcategory->products->first() && $subcategory->products->first()->main_image)
                                <img src="{{ asset('storage/' . $subcategory->products->first()->main_image) }}" alt="{{ $subcategory->name }}">
                            @else
                                {{ $subcategory->name }}
                            @endif
                        </div>
                        <div class="product-name">{{ $subcategory->name }}</div>
                    </a>
                @endforeach
            </div>
            <a href="{{ route('user.category_products', $collection->id) }}" class="explore-link">Explore all {{ $collection->name }}</a>
        </div>
        @endforeach

        <!-- Featured Products -->
        @if($featuredProducts->count() > 0)
        <div class="collection-card">
            <h3 class="card-title">Featured Products</h3>
            <div class="products-grid">
                @foreach($featuredProducts->take(4) as $product)
                    <a href="{{ route('user.view_product', $product->id) }}" class="product-item">
                        <div class="product-image">
                            <img src="{{ asset('storage/' . $product->main_image) }}" alt="{{ $product->product_name }}">
                        </div>
                        <div class="product-name">{{ \Illuminate\Support\Str::words($product->product_name, 8, '...') }}</div>
                        <div class="product-price">Rs {{ number_format($product->discount_price, 2) }}</div>
                    </a>
                @endforeach
            </div>
            <a href="{{ route('user.all_product_show_here') }}" class="explore-link">View all products</a>
        </div>
        @endif


    </div>

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