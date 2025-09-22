<!DOCTYPE html>
<html lang="en">

<head>
    <title>Gujju E Market</title>
    @include('user.head') 
</head>

<body>
    @include('user.navbar')

    <!-- Hero Section -->
    <section class="hero-section">
        <div class="hero-items owl-carousel">
            @foreach ($carouselImages as $carouselImage)
                <div class="single-hero-items set-bg"
                    data-setbg="{{ asset('storage/' . $carouselImage->image_path) }}">
                    <div class="container">
                        <div class="row">
                            <div class="col-lg-5">
                                @if ($carouselImage->title)
                                    <span>{{ $carouselImage->title }}</span>
                                @endif
                                @if ($carouselImage->heading)
                                    <h1>{{ $carouselImage->heading }}</h1>
                                @endif
                                @if ($carouselImage->description)
                                    <p>{{ $carouselImage->description }}</p>
                                @endif
                                <a href="{{ route('user.all_product_show_here') }}" class="primary-btn">Shop Now</a>
                            </div>
                        </div>
                        @if ($carouselImage->discount)
                            <div class="off-card">
                                <h2>Sale <span>{{ $carouselImage->discount }}%</span></h2>
                            </div>
                        @endif
                    </div>
                </div>
            @endforeach
        </div>
    </section>
    <!-- Hero Section End -->

    <!-- Shop by Category Section Begin -->
    <section class="shop-category spad">
        <div class="container">
            <div class="section-title">
                <h2>Shop by Category</h2>
            </div>
            <div class="row">
                @foreach ($gujju_category as $category)
                    <div class="col-lg-2 col-md-3 col-sm-4 col-6">
                        <a href="{{ route('user.gujju_category_products', $category->id) }}"
                            style="text-decoration: none;">
                            <div class="category-item">
                                <div class="ci-pic">
                                    @if ($category->image)
                                        <img src="{{ url('storage/' . $category->image) }}"
                                            alt="{{ $category->name }}">
                                    @else
                                        <img src="{{ asset('path_to_default_image.jpg') }}"
                                            alt="{{ $category->name }}">
                                    @endif
                                </div>
                                <div class="ci-text">
                                    <h5>{{ $category->name }}</h5>
                                </div>
                            </div>
                        </a>
                    </div>
                @endforeach

                <!-- Optional "View More" card -->
                {{-- <div class="col-lg-2 col-md-3 col-sm-4 col-6">
                    <a href="{{ route('user.category_page') }}" style="text-decoration: none;">
                        <div class="category-item">
                            <div class="ci-pic d-flex align-items-center justify-content-center" style="height: 100px; background: #f5f5f5;">
                                <i class="fas fa-arrow-right fa-2x"></i>
                            </div>
                            <div class="ci-text">
                                <h5>View More</h5>
                            </div>
                        </div>
                    </a>
                </div> --}}

            </div>
        </div>
    </section>
    <!-- Shop by Category Section End -->

    <!-- Deal Of The Week Section Begin-->
    <section class="deal-of-week set-bg spad" data-setbg="{{ asset('assets/img/lop.png') }}">
        <div class="container">
            <div class="col-lg-6 text-center">
                <div class="section-title">
                    <h2>Deal Of The Week</h2>
                    <p>"Your perfect deal of the week awaits – shop smart, save big!"<br /> "This week's hottest deal –
                        grab it before it's gone!" </p>
                    <div class="product-price">
                        ₹ 35000.00
                        <span>/ Gaming Laptop</span>
                    </div>
                </div>
                <div class="countdown-timer" id="countdown">
                    <div class="cd-item">
                        <span>56</span>
                        <p>Days</p>
                    </div>
                    <div class="cd-item">
                        <span>12</span>
                        <p>Hrs</p>
                    </div>
                    <div class="cd-item">
                        <span>40</span>
                        <p>Mins</p>
                    </div>
                    <div class="cd-item">
                        <span>52</span>
                        <p>Secs</p>
                    </div>
                </div>
                <a href="{{ route('show-discount-category') }}" class="primary-btn">Shop Now</a>
            </div>
        </div>
    </section>
    <!-- Deal Of The Week Section End -->

    <!-- Women Banner Section Begin -->
    <section class="women-banner spad">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-3">
                    <div class="product-large set-bg" data-setbg="{{ asset('assets/img/products/women-1.png') }}">
                        <h2>Women's</h2>
                        <a href="{{ route('user.gujju_category_products', $gujju_category->where('name', "Women's")->first()->id ?? '#') }}">Discover More</a>
                    </div>
                </div>
                <div class="col-lg-8 offset-lg-1">
                    <div class="filter-control">
                        <ul>
                            @forelse($womensSubcategories as $index => $subcategory)
                                <li class="{{ $index === 0 ? 'active' : '' }}" data-subcategory="{{ $subcategory->id }}" onclick="filterWomensProducts({{ $subcategory->id }})">{{ $subcategory->name }}</li>
                            @empty
                                <li class="active">Clothings</li>
                                <li>HandBag</li>
                                <li>Shoes</li>
                                <li>Accessories</li>
                            @endforelse
                        </ul>
                    </div>
                    <div class="product-slider owl-carousel" id="womens-products">
                        @forelse($womensProducts as $product)
                            <div class="product-item">
                                <div class="pi-pic">
                                    @if($product->main_image)
                                        <img src="{{ asset('storage/' . $product->main_image) }}" alt="{{ $product->product_name }}">
                                    @else
                                        <img src="{{ asset('assets/img/default-product.jpg') }}" alt="{{ $product->product_name }}">
                                    @endif
                                    @if($product->discount_price < $product->price)
                                        <div class="sale">Sale</div>
                                    @endif
                                    <div class="icon">
                                        <i class="icon_heart_alt"></i>
                                    </div>
                                </div>
                                <div class="pi-text">
                                    <div class="catagory-name">{{ $product->brandCategory->name ?? 'Category' }}</div>
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
                        @empty
                            <div class="product-item">
                                <div class="pi-text text-center">
                                    <p>No women's products available</p>
                                </div>
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Women Banner Section End -->

    <!-- Man Banner Section Begin -->
    <section class="man-banner spad">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-8">
                    <div class="filter-control">
                        <ul>
                            @forelse($mensSubcategories as $index => $subcategory)
                                <li class="{{ $index === 0 ? 'active' : '' }}" data-subcategory="{{ $subcategory->id }}" onclick="filterMensProducts({{ $subcategory->id }})">{{ $subcategory->name }}</li>
                            @empty
                                <li class="active">Clothings</li>
                                <li>Watches</li>
                                <li>Shoes</li>
                                <li>Accessories</li>
                            @endforelse
                        </ul>
                    </div>
                    <div class="product-slider owl-carousel" id="mens-products">
                        @forelse($mensProducts as $product)
                            <div class="product-item">
                                <div class="pi-pic">
                                    @if($product->main_image)
                                        <img src="{{ asset('storage/' . $product->main_image) }}" alt="{{ $product->product_name }}">
                                    @else
                                        <img src="{{ asset('assets/img/default-product.jpg') }}" alt="{{ $product->product_name }}">
                                    @endif
                                    @if($product->discount_price < $product->price)
                                        <div class="sale">Sale</div>
                                    @endif
                                    <div class="icon">
                                        <i class="icon_heart_alt"></i>
                                    </div>
                                </div>
                                <div class="pi-text">
                                    <div class="catagory-name">{{ $product->brandCategory->name ?? 'Category' }}</div>
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
                        @empty
                            <div class="product-item">
                                <div class="pi-text text-center">
                                    <p>No men's products available</p>
                                </div>
                            </div>
                        @endforelse
                    </div>
                </div>
                <div class="col-lg-3 offset-lg-1">
                    <div class="product-large set-bg m-large" data-setbg="{{ asset('assets/img/products/man.png') }}">
                        <h2>Men's</h2>
                        <a href="{{ route('user.gujju_category_products', $gujju_category->where('name', "Men's")->first()->id ?? '#') }}">Discover More</a>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Man Banner Section End -->

    <!-- Electronic Banner Section Begin -->
    <section class="women-banner spad">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-3">
                    <div class="product-large set-bg" data-setbg="{{ asset('assets/img/products/electro.png') }}">
                        <h2>Electronics’s</h2>
                        <a href="{{ route('user.gujju_category_products', $gujju_category->where('name', 'Electronics')->first()->id ?? '#') }}">Discover More</a>
                    </div>
                </div>
                <div class="col-lg-8 offset-lg-1">
                    <div class="filter-control">
                        <ul>
                            @forelse($electronicsSubcategories as $index => $subcategory)
                                <li class="{{ $index === 0 ? 'active' : '' }}" data-subcategory="{{ $subcategory->id }}" onclick="filterElectronicsProducts({{ $subcategory->id }})">{{ $subcategory->name }}</li>
                            @empty
                                <li class="active">Phones</li>
                                <li>Mobile Phones</li>
                                <li>Laptops</li>
                                <li>Accessories</li>
                            @endforelse
                        </ul>
                    </div>
                    <div class="product-slider owl-carousel" id="electronics-products">
                        @forelse($electronicsProducts as $product)
                            <div class="product-item">
                                <div class="pi-pic">
                                    @if($product->main_image)
                                        <img src="{{ asset('storage/' . $product->main_image) }}" alt="{{ $product->product_name }}">
                                    @else
                                        <img src="{{ asset('assets/img/default-product.jpg') }}" alt="{{ $product->product_name }}">
                                    @endif
                                    @if($product->discount_price < $product->price)
                                        <div class="sale">Sale</div>
                                    @endif
                                    <div class="icon">
                                        <i class="icon_heart_alt"></i>
                                    </div>
                                </div>
                                <div class="pi-text">
                                    <div class="catagory-name">{{ $product->brandCategory->name ?? 'Category' }}</div>
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
                        @empty
                            <div class="product-item">
                                <div class="pi-text text-center">
                                    <p>No electronics products available</p>
                                </div>
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Women Banner Section End -->
    
    {{-- logo section --}}
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


    <!-- Google Tag Manager (noscript) -->
    <noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-W8N8F4V5" height="0" width="0"
            style="display:none;visibility:hidden"></iframe></noscript>
    <!-- End Google Tag Manager (noscript) -->


    <!-- Bootstrap JS (with Popper) -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>


    <script>
        $(document).ready(function() {
            // Component loading configuration
            const components = {
                "navbar.html": "navbar",
                "dealofday.html": "dealofd",
                "footer.html": "footer",
                "recentviewed.html": "recently-viewed",
                "womensection.html": "women",
                "mensection.html": "men",
                "electronic.html": "electronics",
                "logosection.html": "logosec",
                "shopbycategory.html": "category"
            };

            // Function to extract body content and clean it
            function extractContent(html) {
                const tempDiv = document.createElement('div');
                tempDiv.innerHTML = html;

                // Remove script tags to avoid conflicts
                const scripts = tempDiv.querySelectorAll('script');
                scripts.forEach(script => script.remove());

                // Remove head tags and doctype
                const heads = tempDiv.querySelectorAll('head');
                heads.forEach(head => head.remove());

                // Get body content or return all content if no body tag
                const body = tempDiv.querySelector('body');
                return body ? body.innerHTML : tempDiv.innerHTML;
            }

            // Load components sequentially
            let loadedCount = 0;
            const totalComponents = Object.keys(components).length;

            function loadComponent(file, containerId) {
                fetch(file)
                    .then(response => {
                        if (!response.ok) throw new Error(`Failed to load ${file}`);
                        return response.text();
                    })
                    .then(data => {
                        const cleanContent = extractContent(data);
                        document.getElementById(containerId).innerHTML = cleanContent;
                        loadedCount++;

                        // Initialize plugins after all components are loaded
                        if (loadedCount === totalComponents) {
                            initializePlugins();
                        }
                    })
                    .catch(error => {
                        console.error(`Error loading ${file}:`, error);
                        loadedCount++;
                        if (loadedCount === totalComponents) {
                            initializePlugins();
                        }
                    });
            }

            // Load all components
            Object.entries(components).forEach(([file, containerId]) => {
                loadComponent(file, containerId);
            });

            // Initialize all plugins after components load
            function initializePlugins() {
                // Initialize hero carousel
                $('.hero-items').owlCarousel({
                    items: 1,
                    loop: true,
                    autoplay: true,
                    autoplayTimeout: 5000,
                    nav: false,
                    dots: true
                });

                // Initialize product sliders
                $('.product-slider').owlCarousel({
                    items: 4,
                    loop: false,
                    autoplay: false,
                    nav: true,
                    dots: false,
                    responsive: {
                        0: {
                            items: 1
                        },
                        576: {
                            items: 2
                        },
                        768: {
                            items: 3
                        },
                        992: {
                            items: 4
                        }
                    }
                });

                // Initialize logo carousel
                $('.logo-carousel').owlCarousel({
                    items: 5,
                    loop: true,
                    autoplay: true,
                    autoplayTimeout: 2000,
                    nav: false,
                    dots: false,
                    responsive: {
                        0: {
                            items: 2
                        },
                        576: {
                            items: 3
                        },
                        768: {
                            items: 4
                        },
                        992: {
                            items: 5
                        }
                    }
                });

                // Initialize nice select
                $('select').niceSelect();

                // Set background images
                $('.set-bg').each(function() {
                    const bg = $(this).data('setbg');
                    $(this).css('background-image', 'url(' + bg + ')');
                });

                console.log('All components loaded and plugins initialized');
            }
        });
        
        // Product filtering functions
        const womensProductsData = @json($womensProductsBySubcategory);
        const mensProductsData = @json($mensProductsBySubcategory);
        const electronicsProductsData = @json($electronicsProductsBySubcategory);
        
        function filterWomensProducts(subcategoryId) {
            // Remove active class from all women's filter items
            document.querySelectorAll('.women-banner .filter-control li').forEach(li => li.classList.remove('active'));
            // Add active class to clicked item
            document.querySelector(`[data-subcategory="${subcategoryId}"]`).classList.add('active');
            
            // Update products
            updateProductSlider('womens-products', womensProductsData[subcategoryId] || []);
        }
        
        function filterMensProducts(subcategoryId) {
            // Remove active class from all men's filter items
            document.querySelectorAll('.man-banner .filter-control li').forEach(li => li.classList.remove('active'));
            // Add active class to clicked item
            document.querySelector(`[data-subcategory="${subcategoryId}"]`).classList.add('active');
            
            // Update products
            updateProductSlider('mens-products', mensProductsData[subcategoryId] || []);
        }
        
        function filterElectronicsProducts(subcategoryId) {
            // Remove active class from all electronics filter items
            document.querySelectorAll('.women-banner:last-of-type .filter-control li').forEach(li => li.classList.remove('active'));
            // Add active class to clicked item
            document.querySelector(`[data-subcategory="${subcategoryId}"]`).classList.add('active');
            
            // Update products
            updateProductSlider('electronics-products', electronicsProductsData[subcategoryId] || []);
        }
        
        function updateProductSlider(sliderId, products) {
            const slider = document.getElementById(sliderId);
            if (!slider) return;
            
            // Destroy existing owl carousel
            $(slider).trigger('destroy.owl.carousel');
            
            // Clear existing content
            slider.innerHTML = '';
            
            if (products.length === 0) {
                slider.innerHTML = '<div class="product-item"><div class="pi-text text-center"><p>No products available</p></div></div>';
            } else {
                products.forEach(product => {
                    const productHtml = `
                        <div class="product-item">
                            <div class="pi-pic">
                                <img src="${product.main_image ? '/storage/' + product.main_image : '/assets/img/default-product.jpg'}" alt="${product.product_name}">
                                ${product.discount_price < product.price ? '<div class="sale">Sale</div>' : ''}
                                <div class="icon"><i class="icon_heart_alt"></i></div>
                            </div>
                            <div class="pi-text">
                                <div class="catagory-name">${product.brand_category?.name || 'Category'}</div>
                                <a href="/products/product/${product.id}"><h5>${product.product_name}</h5></a>
                                <div class="product-price">
                                    ₹ ${parseFloat(product.discount_price).toLocaleString('en-IN', {minimumFractionDigits: 2})}
                                    ${product.discount_price < product.price ? `<span>₹ ${parseFloat(product.price).toLocaleString('en-IN', {minimumFractionDigits: 2})}</span>` : ''}
                                </div>
                            </div>
                        </div>`;
                    slider.innerHTML += productHtml;
                });
            }
            
            // Reinitialize owl carousel
            $(slider).owlCarousel({
                items: 4,
                loop: false,
                autoplay: false,
                nav: true,
                dots: false,
                responsive: {
                    0: { items: 1 },
                    576: { items: 2 },
                    768: { items: 3 },
                    992: { items: 4 }
                }
            });
        }
    </script>


</body>

</html>
