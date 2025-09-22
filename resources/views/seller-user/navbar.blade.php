    <!-- Top Bar -->
    <div class="top-bar bg-warning text-white py-2">
        <div class="container d-flex justify-content-between align-items-center">
            <span></span>
            <div>
                <a href="" class="text-white mx-2">GST No: 24DMYPB6859M1Z4</a> |
                <a href="{{ route('order.track', ['sellerAdminId' => $sellerAdminId]) }}" class="text-white mx-2">Track Order</a> |
                <a href="tel:+91 96244 02490" class="text-white mx-2">+91 96244 02490</a>
            </div>
        </div>
    </div>

    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="container" style="padding: 2px;">
            <a class="navbar-brand" href="{{ route('seller-user.dashboard', ['sellerAdminId' => $sellerAdminId]) }}">
                <img src="{{ asset('user/images/gujju-logo.jpg') }}" alt="Electro Store Logo" style="max-height: 50px;">
            </a>

            <!-- Search Bar -->
            <form class="d-flex search-bar ml-3" action="{{ route('admin.product.search') }}" method="GET">
                <input class="form-control me-2" type="search" name="search" placeholder="Search" aria-label="Search" value="{{ request()->input('search') }}">
                <button class="btn btn-danger" type="submit">Search</button>
            </form>

        </div>
    </nav>

    <!-- Navbar 2-->
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="container">

            {{-- <div class="dropdown">
                <button class="btn btn-light dropdown-toggle" type="button" id="categoryDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                    Shop By Categories
                </button>
                <ul class="dropdown-menu wrap-dropdown" aria-labelledby="categoryDropdown">
                    @foreach($brand_categories as $category)
                    <li><a class="dropdown-item" href="{{ route('user.category_products', $category->id) }}">{{ $category->name }}</a></li>
                @endforeach
                </ul>
            </div> --}}
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('seller-user.dashboard', ['sellerAdminId' => $sellerAdminId]) }}">Home</a>
                    </li>
                    <!--
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="electronicsDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            Electronics
                        </a>
                        <ul class="dropdown-menu" aria-labelledby="electronicsDropdown">
                            <li><a class="dropdown-item" href="#">Mobiles, Computers</a></li>
                            <li><a class="dropdown-item" href="#">Laptops</a></li>
                            <li><a class="dropdown-item" href="#">Drives & Storage</a></li>
                            <li><a class="dropdown-item" href="#">Printers & Ink</a></li>
                            <li><a class="dropdown-item" href="#">Networking Devices</a></li>
                            <li><a class="dropdown-item" href="#">Computer Accessories</a></li>
                        </ul>
                    </li>
                    -->

                    <li class="nav-item">
                        <div class="dropdown" style="text-align: center; align-content: center; justify-content: center;">
                            <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-expanded="false" style="background-color: transparent; border: none; box-shadow: none;">
                                <i class="fas fa-user" style="color: #000; margin-top: 13px; margin-left: 13px;"></i>
                            </button>
                            <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="dropdownMenuButton">

                                @if (Route::has('login'))
                                @auth
                                    <!-- User is logged in
                                    <li>
                                        <a href="{{ url('/dashboard') }}" class="rounded-md px-3 py-2 text-black ring-1 ring-transparent transition hover:text-black/70 focus:outline-none focus-visible:ring-[#FF2D20] dark:text-white dark:hover:text-white/80 dark:focus-visible:ring-white">
                                            Dashboard
                                        </a>
                                    </li> -->
                                    <!-- Admin Name and Profile Links (can be dynamic) -->
                                    <li>
                                        <a href="#" class="dropdown-item">{{ Auth::user()->name }}</a>
                                    </li>
                                    <li>
                                        <a href="#" class="dropdown-item">Profile</a>
                                    </li>
                                    <!-- Logout Form -->
                                    <li>
                                        <form method="POST" action="{{ route('logout') }}" style="padding: 10px;">
                                            @csrf
                                            <input type="submit" value="Logout" style="background-color: transparent!important; border: none; box-shadow: none;">
                                        </form>
                                    </li>

                                @else
                                    <!-- User is not logged in -->
                                    <li>
                                        <a href="{{ route('login') }}" style="text-decoration: none;" class="rounded-md px-3 py-2 text-black ring-1 ring-transparent transition hover:text-black/70 focus:outline-none focus-visible:ring-[#FF2D20] dark:text-white dark:hover:text-white/80 dark:focus-visible:ring-white">
                                            Log in
                                        </a>
                                    </li>
                                    <li>
                                        <a href="{{ route('admin.login') }}" style="text-decoration: none;" class="rounded-md px-3 py-2 text-black ring-1 ring-transparent transition hover:text-black/70 focus:outline-none focus-visible:ring-[#FF2D20] dark:text-white dark:hover:text-white/80 dark:focus-visible:ring-white">
                                            Admin Log in
                                        </a>
                                    </li>
                                    @if (Route::has('register'))
                                        <li>
                                            <a href="{{ route('register') }}" style="text-decoration: none;" class="rounded-md px-3 py-2 text-black ring-1 ring-transparent transition hover:text-black/70 focus:outline-none focus-visible:ring-[#FF2D20] dark:text-white dark:hover:text-white/80 dark:focus-visible:ring-white">
                                                New User
                                            </a>
                                        </li>
                                    @endif
                                @endauth
                            @endif
                            </ul>
                        </div>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('seller.cart.view', ['sellerAdminId' => $sellerAdminId]) }}">
                            <i class="fas fa-shopping-cart"></i>
                            {{ Auth::check() ? Auth::user()->sellerCarts()->where('seller_admin_id', $sellerAdminId)->distinct('product_id')->count() : 0 }}  <!-- This counts cart items -->
                        </a>
                    </li>

                </ul>
            </div>
        </div>
    </nav>
