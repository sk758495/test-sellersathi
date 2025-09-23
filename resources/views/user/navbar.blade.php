    <header class="header-section">
        <div class="header-top">
            <div class="container">
                <div class="ht-left">
                    <div class="mail-service">
                        <i class=" fa fa-envelope"></i>
                        support@gujjuemarket.com
                    </div>
                </div>
                <div class="ht-right">
                    @if (Route::has('login'))
                        @auth
                            <a href="#" class="login-panel"><i class="fa fa-user"></i>{{ Auth::user()->name }}</a>
                        @else
                            <a href="{{ route('register') }}" class="login-panel"><i class="fa fa-user"></i>Register
                                Here</a>
                        @endauth
                    @endif
                    <div class="top-social">
                        <a href="{{ route('user.orders.status') }}">Track Order</a>
                    </div>
                </div>
            </div>
        </div>
        <div class="container">
            <div class="inner-header">
                <div class="row">
                    <div class="col-lg-2 col-md-2">
                        <div class="logo">
                            <a href="{{ route('dashboard') }}">
                                <img src="{{ asset('assets/img/lg.png') }}" alt=""
                                    style="height: 48px; width: 105px;">
                            </a>
                        </div>
                    </div>
                    <div class="col-lg-6 col-md-6">
                        <div class="search-container">
                            <form class="advanced-search" action="{{ route('admin.product.search') }}" method="GET">
                                <button type="button" class="category-btn">Search Here</button>
                                <div class="input-group">
                                    <input type="text" name="search" id="searchInput" placeholder="What do you need?"
                                        value="{{ request()->input('search') }}" autocomplete="off">
                                    <button type="submit"><i class="ti-search"></i></button>
                                </div>
                            </form>
                            <div id="searchSuggestions" class="search-suggestions"></div>
                        </div>
                    </div>
                    <div class="col-lg-3 text-right col-md-3">
                        <ul class="nav-right">
                            <li class="heart-icon">
                                <a href="#">
                                    <i class="icon_heart_alt"></i>
                                    <span>1</span>
                                </a>
                            </li>
                            <li class="cart-icon">
                                <a href="{{ route('user.cart') }}">
                                    <i class="icon_bag_alt"></i>
                                    <span>{{ Auth::check() ? Auth::user()->carts->count() : 0 }}</span>
                                </a>
                                @if (Auth::check() && Auth::user()->carts->count() > 0)
                                    <div class="cart-hover">
                                        <div class="select-items">
                                            <table>
                                                <tbody>
                                                    @foreach (Auth::user()->carts->take(2) as $cart)
                                                        <tr>
                                                            <td class="si-pic"><img
                                                                    src="{{ asset('storage/' . $cart->product->main_image) }}"
                                                                    alt=""></td>
                                                            <td class="si-text">
                                                                <div class="product-selected">
                                                                    <p>Rs
                                                                        {{ number_format($cart->product->discount_price, 2) }}
                                                                        x {{ $cart->quantity }}</p>
                                                                    <h6>{{ $cart->product->product_name }}</h6>
                                                                </div>
                                                            </td>
                                                            <td class="si-close">
                                                                <i class="ti-close"></i>
                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                        <div class="select-total">
                                            <span>total:</span>
                                            <h5>Rs
                                                {{ number_format(Auth::user()->carts->sum(function ($cart) {return $cart->product->discount_price * $cart->quantity;}),2) }}
                                            </h5>
                                        </div>
                                        <div class="select-button">
                                            <a href="{{ route('user.cart') }}" class="primary-btn view-card">VIEW
                                                CART</a>
                                            <a href="#" class="primary-btn checkout-btn">CHECK OUT</a>
                                        </div>
                                    </div>
                                @endif
                            </li>
                            <li class="cart-price">Rs
                                {{ Auth::check()? number_format(Auth::user()->carts->sum(function ($cart) {return $cart->product->discount_price * $cart->quantity;}),2): '0.00' }}
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <div class="nav-item">
            <div class="container">
                <div class="nav-depart">
                    <div class="depart-btn">
                        <i class="ti-menu"></i>
                        <span>All departments</span>
                        <ul class="depart-hover">
                            @foreach ($brands as $brand)
                                <li class="active"><a href="#">{{ $brand->name }}</a>
                                    <ul class="sub-menu">
                                        @foreach ($brand->brandCategories as $category)
                                            <li><a
                                                    href="{{ route('user.category_products', $category->id) }}">{{ $category->name }}</a>
                                                <ul class="sub-sub-menu">
                                                    @foreach ($category->subcategories as $subcategory)
                                                        <li><a
                                                                href="{{ route('user.subcategory_products', $subcategory->id) }}">{{ $subcategory->name }}</a>
                                                        </li>
                                                    @endforeach
                                                </ul>
                                            </li>
                                        @endforeach
                                    </ul>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
                <nav class="nav-menu mobile-menu">
                    <ul>
                        <li class="active"><a href="{{ route('dashboard') }}">Home</a></li>
                        <li><a href="{{ route('user.all_product_show_here') }}">Shop</a></li>
                        <li><a href="{{ route('user.collection') }}">Collection</a>
                            <ul class="dropdown">
                                @foreach($brand_categories as $category)
                                    <li><a href="{{ route('user.category_products', $category->id) }}">{{ $category->name }}</a></li>
                                @endforeach
                            </ul>
                        </li>
                        <li><a href="{{ route('contact-us') }}">Contact</a></li>
                        @if (Route::has('login'))
                            @auth
                                <li><a href="#">Account</a>
                                    <ul class="dropdown">
                                        <li><a href="#">{{ Auth::user()->name }}</a></li>
                                        <li><a href="#">Profile</a></li>
                                        <li>
                                            <form method="POST" action="{{ route('logout') }}">
                                                @csrf
                                                <button type="submit"
                                                    style="background: none; border: none; color: inherit; text-decoration: none; cursor: pointer; padding: 0; margin: 0;">Logout</button>
                                            </form>
                                        </li>
                                    </ul>
                                </li>
                            @else
                                <li><a href="#">Pages</a>
                                    <ul class="dropdown">
                                        <li><a href="{{ route('login') }}">Login</a></li>
                                        <li><a href="{{ route('register') }}">Register</a></li>
                                        <li><a href="{{ route('seller-admin.login') }}">Seller Login</a></li>
                                        <li><a href="{{ route('seller-admin.create') }}">New Seller</a></li>
                                    </ul>
                                </li>
                            @endauth
                        @endif
                    </ul>
                </nav>
                <div id="mobile-menu-wrap"></div>
            </div>
        </div>
    </header>


    <style>
        /* Multi-Level Dropdown Navigation Styles */
        .nav-item .nav-depart .depart-btn .depart-hover .sub-menu {
            position: absolute;
            left: 100%;
            top: 0;
            width: 100%;
            background: #ffffff;
            opacity: 0;
            visibility: hidden;
            box-shadow: 0 13px 32px rgba(51, 51, 51, 0.1);
            padding-bottom: 29px;
            z-index: 99;
            transition: all 0.3s;
        }

        .nav-item .nav-depart .depart-btn .depart-hover .sub-sub-menu {
            position: absolute;
            left: 100%;
            top: 0;
            width: 100%;
            background: #ffffff;
            opacity: 0;
            visibility: hidden;
            box-shadow: 0 13px 32px rgba(51, 51, 51, 0.1);
            padding-bottom: 29px;
            z-index: 100;
            transition: all 0.3s;
        }

        .nav-item .nav-depart .depart-btn .depart-hover li:hover>.sub-menu {
            opacity: 1;
            visibility: visible;
        }

        .nav-item .nav-depart .depart-btn .depart-hover .sub-menu li:hover>.sub-sub-menu {
            opacity: 1;
            visibility: visible;
        }

        .nav-item .nav-depart .depart-btn .depart-hover .sub-menu li {
            list-style: none;
            position: relative;
            margin: 0;
        }

        .nav-item .nav-depart .depart-btn .depart-hover .sub-menu li a {
            display: block;
            font-size: 16px;
            color: #000000;
            padding-left: 40px;
            padding-top: 16px;
            padding-right: 30px;
            transition: all 0.3s;
        }

        .nav-item .nav-depart .depart-btn .depart-hover .sub-menu li a:hover {
            color: #F4631E;
        }

        .nav-item .nav-depart .depart-btn .depart-hover .sub-sub-menu li {
            list-style: none;
            position: relative;
            margin: 0;
        }

        .nav-item .nav-depart .depart-btn .depart-hover .sub-sub-menu li a {
            display: block;
            font-size: 16px;
            color: #000000;
            padding-left: 40px;
            padding-top: 16px;
            padding-right: 30px;
            transition: all 0.3s;
        }

        .nav-item .nav-depart .depart-btn .depart-hover .sub-sub-menu li a:hover {
            color: #F4631E;
        }
        
        .search-container {
            position: relative;
        }
        
        .search-suggestions {
            position: absolute;
            top: 100%;
            left: 0;
            right: 0;
            background: white;
            border: 1px solid #ddd;
            border-top: none;
            border-radius: 0 0 8px 8px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.15);
            z-index: 1000;
            max-height: 400px;
            overflow-y: auto;
            display: none;
        }
        
        .suggestion-item {
            display: flex;
            align-items: center;
            padding: 12px 15px;
            border-bottom: 1px solid #f0f0f0;
            cursor: pointer;
            transition: background 0.2s ease;
        }
        
        .suggestion-item:hover {
            background: #f8f9fa;
        }
        
        .suggestion-image {
            width: 40px;
            height: 40px;
            object-fit: cover;
            border-radius: 4px;
            margin-right: 12px;
        }
        
        .suggestion-content {
            flex: 1;
        }
        
        .suggestion-name {
            font-size: 14px;
            color: #333;
            margin: 0 0 4px 0;
            font-weight: 500;
        }
        
        .suggestion-price {
            font-size: 14px;
            color: #F4631E;
            font-weight: 600;
        }
    </style>
    
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function() {
            let searchTimeout;
            
            $('#searchInput').on('input', function() {
                const query = $(this).val();
                
                clearTimeout(searchTimeout);
                
                if (query.length < 2) {
                    $('#searchSuggestions').hide();
                    return;
                }
                
                searchTimeout = setTimeout(function() {
                    $.ajax({
                        url: '{{ route("user.search_suggestions") }}',
                        method: 'GET',
                        data: { query: query },
                        success: function(products) {
                            displaySuggestions(products);
                        }
                    });
                }, 300);
            });
            
            function displaySuggestions(products) {
                const container = $('#searchSuggestions');
                container.empty();
                
                if (products.length === 0) {
                    container.hide();
                    return;
                }
                
                products.forEach(function(product) {
                    const item = $(`
                        <div class="suggestion-item" data-product-id="${product.id}">
                            <img src="/storage/${product.main_image}" alt="${product.product_name}" class="suggestion-image">
                            <div class="suggestion-content">
                                <div class="suggestion-name">${product.product_name.substring(0, 50)}${product.product_name.length > 50 ? '...' : ''}</div>
                            </div>
                            <div class="suggestion-price">₹${parseFloat(product.discount_price).toFixed(2)}</div>
                        </div>
                    `);
                    
                    item.on('click', function() {
                        window.location.href = `/view-product/${product.id}`;
                    });
                    
                    container.append(item);
                });
                
                container.show();
            }
            
            $(document).on('click', function(e) {
                if (!$(e.target).closest('.search-container').length) {
                    $('#searchSuggestions').hide();
                }
            });
        });
    </script>
