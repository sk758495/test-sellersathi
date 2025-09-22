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
                            <a href="{{ route('register') }}" class="login-panel"><i class="fa fa-user"></i>Register Here</a>
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
                               <img src="{{ asset('assets/img/lg.jpg') }}" alt="" style="height: 48px; width: 105px;">
                            </a>
                        </div>
                    </div>
                    <div class="col-lg-6 col-md-6">
                        <form class="advanced-search" action="{{ route('admin.product.search') }}" method="GET">
                            <button type="button" class="category-btn">Search Here</button>
                            <div class="input-group">
                                <input type="text" name="search" placeholder="What do you need?" value="{{ request()->input('search') }}">
                                <button type="submit"><i class="ti-search"></i></button>
                            </div>
                        </form>
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
                                @if(Auth::check() && Auth::user()->carts->count() > 0)
                                <div class="cart-hover">
                                    <div class="select-items">
                                        <table>
                                            <tbody>
                                                @foreach(Auth::user()->carts->take(2) as $cart)
                                                <tr>
                                                    <td class="si-pic"><img src="{{ asset('storage/' . $cart->product->main_image) }}" alt=""></td>
                                                    <td class="si-text">
                                                        <div class="product-selected">
                                                            <p>Rs {{ number_format($cart->product->discount_price, 2) }} x {{ $cart->quantity }}</p>
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
                                        <h5>Rs {{ number_format(Auth::user()->carts->sum(function($cart) { return $cart->product->discount_price * $cart->quantity; }), 2) }}</h5>
                                    </div>
                                    <div class="select-button">
                                        <a href="{{ route('user.cart') }}" class="primary-btn view-card">VIEW CART</a>
                                        <a href="#" class="primary-btn checkout-btn">CHECK OUT</a>
                                    </div>
                                </div>
                                @endif
                            </li>
                            <li class="cart-price">Rs {{ Auth::check() ? number_format(Auth::user()->carts->sum(function($cart) { return $cart->product->discount_price * $cart->quantity; }), 2) : '0.00' }}</li>
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
                            @foreach($brand_categories as $category)
                                <li><a href="{{ route('user.category_products', $category->id) }}">{{ $category->name }}</a></li>
                            @endforeach
                        </ul>
                    </div>
                </div>
                <nav class="nav-menu mobile-menu">
                    <ul>
                        <li class="active"><a href="{{ route('dashboard') }}">Home</a></li>
                        <li><a href="{{ route('user.all_product_show_here') }}">Shop</a></li>
                        <li><a href="#">Collection</a>
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
                                                <button type="submit" style="background: none; border: none; color: inherit; text-decoration: none; cursor: pointer; padding: 0; margin: 0;">Logout</button>
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