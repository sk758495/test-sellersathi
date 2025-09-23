<div class="container-fluid vh-100 p-0">
    <!-- Navbar -->
    <nav class="navbar navbar-dark sticky-top bg-dark">
        <div class="container-fluid d-flex justify-content-between align-items-center">
            <div class="d-flex align-items-center">
                <img src="{{ asset('assets/img/lg.jpg') }}" id="toggleSidebar" class="admin_image" alt="Admin Image" style="border-radius: 50%; margin-right: 10px; width: 70px">
                <span class="navbar-brand mb-0"></span>
            </div>
            <div class="dropdown">
                <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-expanded="false">
                    <i class="fas fa-user"></i>
                </button>
                <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="dropdownMenuButton">
                    <li><a class="dropdown-item" href="#">{{ Auth::guard('admin')->user()->name }}</a></li>
                    <li>
                        <form style="padding: 10px" method="POST" action="{{ route('admin.logout') }}">
                            @csrf
                            <input type="submit" style="background-color: transparent!important; border: none; box-shadow: none;" value="Logout">
                        </form>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Sidebar -->
    <aside id="sidebar" class="p-3 my-3">
        <ul class="nav flex-column">
            <li class="nav-item">
                <a class="nav-link text-white" style="margin-top: 30px;" href="{{ route('admin.dashboard') }}">
                    <i class="fas fa-tachometer-alt"></i> Dashboard
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link text-white" href="{{ route('gujjucategory.view_gujjucategory') }}">
                    <i class="fas fa-th"></i> Add Gujju Category
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link text-white" data-bs-toggle="collapse" href="#brandsOptions" role="button" aria-expanded="false" aria-controls="brandsOptions">
                    <i class="fas fa-tag"></i> Brands
                </a>
                <div class="collapse" id="brandsOptions">
                    <ul class="nav flex-column ms-3">
                        <li class="nav-item">
                            <a class="nav-link text-white" href="{{ route('pages.view_brands') }}">Show/Manage Brands</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link text-white" href="{{ route('pages.add_brand') }}">Add Brand</a>
                        </li>
                    </ul>
                </div>
            </li>
            <li class="nav-item">
                <a class="nav-link text-white" data-bs-toggle="collapse" href="#categoryOptions" role="button" aria-expanded="false" aria-controls="categoryOptions">
                    <i class="fas fa-gift"></i> Discount
                </a>
                <div class="collapse" id="categoryOptions">
                    <ul class="nav flex-column ms-3">
                        <li class="nav-item">
                            <a class="nav-link text-white" href="{{ route('dashboard.discounts') }}">View/Manage Discount</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link text-white" href="{{ route('dashboard.viewdiscounts') }}">Add Discount</a>
                        </li>
                    </ul>
                </div>
            </li>
            <li class="nav-item">
                <a class="nav-link text-white" data-bs-toggle="collapse" href="#productsOptions" role="button" aria-expanded="false" aria-controls="productsOptions">
                    <i class="fas fa-box"></i> Products
                </a>
                <div class="collapse" id="productsOptions">
                    <ul class="nav flex-column ms-3">
                        <li class="nav-item">
                            <a class="nav-link text-white" href="{{ route('admin.products.view_product') }}">View All Products</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link text-white" href="{{ route('admin.products.create') }}">Add Product</a>
                        </li>
                    </ul>
                </div>
            </li>
            <li class="nav-item">
                <a class="nav-link text-white" data-bs-toggle="collapse" href="#ordersOptions" role="button" aria-expanded="false" aria-controls="ordersOptions">
                    <i class="fas fa-shopping-cart"></i> Orders
                </a>
                <div class="collapse" id="ordersOptions">
                    <ul class="nav flex-column ms-3">
                        <li class="nav-item">
                            <a class="nav-link text-white" href="{{ route('admin.orders') }}">View All Orders</a>
                        </li>
                    </ul>
                </div>
            </li>
            <li class="nav-item">
                <a class="nav-link text-white" data-bs-toggle="collapse" href="#CarouselOptions" role="button" aria-expanded="false" aria-controls="CarouselOptions">
                    <i class="fas fa-layer-group"></i> Carousel Banner
                </a>
                <div class="collapse" id="CarouselOptions">
                    <ul class="nav flex-column ms-3">
                        <li class="nav-item">
                            <a class="nav-link text-white" href="{{ route('carousel.carousel_view') }}">View</a>
                        </li>
                    </ul>
                </div>
            </li>
            <li class="nav-item">
                <a class="nav-link text-white" href="{{ route('admin-seller-index') }}">
                    <i class="fas fa-user-shield"></i> Seller Admin Account
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link text-white" href="{{ route('admin.orders.all') }}">
                    <i class="fas fa-shopping-cart"></i> Seller Order Manage
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link text-white" href="{{ route('admin.seller-accounts.index') }}">
                    <i class="fa fa-university"></i> Seller Admin Bank
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link text-white" href="{{ route('admin.products.export.filter') }}">
                    <i class="fas fa-file-export"></i> Export
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link text-white" href="{{ route('products.import.form') }}">
                    <i class="fas fa-file-import"></i> Import
                </a>
            </li>


            <!-- Additional sidebar items here -->
        </ul>
    </aside>



