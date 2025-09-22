<!DOCTYPE html>
<html lang="en">

<head>
    <title>Gujju E Market</title>
    @include('user.head')
</head>

<body>

    @include('user.navbar')





    <!-- Carousel Section (Banner) -->
    <div class="container-x" id="carousel-banner">
        <div id="carouselExampleFade" class="carousel slide carousel-fade" data-bs-ride="carousel"
            data-bs-interval="3000">
            <div class="carousel-inner">
                @foreach ($carouselImages as $index => $carouselImage)
                    <div class="carousel-item {{ $index == 0 ? 'active' : '' }}">
                        <img src="{{ asset('storage/' . $carouselImage->image_path) }}" class="d-block w-100 img-fluid"
                            alt="...">
                        <div class="carousel-caption d-none d-md-block">
                            <div class="btn btn-success" id="carasoul-button">
                                <a href="{{ route('user.all_product_show_here') }}"
                                    class="text-white text-decoration-none">Shop</a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <!-- Carousel Indicators -->
            <div class="carousel-indicators">
                @foreach ($carouselImages as $index => $carouselImage)
                    <button type="button" data-bs-target="#carouselExampleFade" data-bs-slide-to="{{ $index }}"
                        class="{{ $index == 0 ? 'active' : '' }}" aria-current="true"
                        aria-label="Slide {{ $index + 1 }}"></button>
                @endforeach
            </div>

            <!-- Previous and Next Controls -->
            <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleFade"
                data-bs-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Previous</span>
            </button>
            <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleFade"
                data-bs-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Next</span>
            </button>
        </div>

    </div>


    <!-- Body Section -->

    <!-- category -->

    <div class="container mt-5" style="text-align: center!important;">
        <div class="row" id="category-card-row" style="text-align: center!important;">
            {{-- brand category show here
             @foreach ($brand_categories as $category)
            <div class="col-4 col-sm-6 col-md-2 mb-4">
                <a href="{{ route('user.category_products', $category->id) }}" style="text-decoration: none;">
                <div class="card" id="category-card">
                    @if ($category->images->isNotEmpty())
                            <!-- Display the first image in the images collection -->
                            <img src="{{ url('storage/' . $category->images->first()->image) }}" class="card-img-top" alt="Category Image">
                        @else
                            <!-- Fallback image if no image exists -->
                            <img src="{{ asset('path_to_default_image.jpg') }}" class="card-img-top" alt="No Image Available">
                        @endif
                    <div class="" style="text-align: center !important;">
                        <h5 class="card-title-x" id="cart-xy" style="text-align: center !important;">{{ $category->name }}</h5>
                     </div>
                </div>
                </a>
            </div>
            @endforeach --}}

            @foreach ($gujju_category as $category)
                <div class="col-4 col-sm-6 col-md-2 mb-4">
                    <a href="{{ route('user.gujju_category_products', $category->id) }}"
                        style="text-decoration: none;">
                        <div class="card" id="category-card">
                            @if ($category->image)
                                <!-- Display the category's image -->
                                <img src="{{ url('storage/' . $category->image) }}" class="card-img-top"
                                    alt="Category Image">
                            @else
                                <!-- Fallback image if no image exists -->
                                <img src="{{ asset('path_to_default_image.jpg') }}" class="card-img-top"
                                    alt="No Image Available">
                            @endif
                            <div class="" style="text-align: center !important;">
                                <h5 class="card-title-x" id="cart-xy" style="text-align: center !important;">
                                    {{ $category->name }}</h5>
                            </div>
                        </div>
                    </a>
                </div>
            @endforeach


            <div class="col-12 col-sm-6 col-md-12 mb-4">


                <div class="" style="text-align: right; justify-content:right ; display: flex;">
                    <h5 class="card-title">
                        <a href="{{ route('user.category_page') }}" style="text-decoration: none; color: black;">View
                            More...
                    </h5>
                    <button class="btn btn-primary" id="card-button">
                        <i class="fas fa-arrow-right"></i>
                    </button>
                    </a>
                </div>

            </div>

            <!-- Add more cards as needed -->
        </div>

    </div>

    <!-- discount -->
    <div class="container mt-lg-0">
        <a href="{{ route('show-discount-category') }}">
            <div class="row">
                <div class="col-12 col-sm-12 col-md-12 mb-12">
                    <div id="discount-card">
                        <img src="{{ asset('user/images/discount-banner') }}" class="card-img-top img-fluid"
                            alt="Product 1">
                    </div>
                </div>
            </div>
        </a>
    </div>

    <!-- Bank Offer

    <div class="container mt-lg-0">
        <div class="row">
            <div class="col-6 col-sm-6 col-md-6 mb-4">
                <div class="card" id="product-card">
                    <img src="{{ asset('user/images/bank-offer-1.png') }}" class="card-img-top img-fluid" alt="Product 1">
                </div>
            </div>
            <div class="col-6 col-sm-6 col-md-6 mb-4">
                <div class="card" id="product-card">
                    <img src="{{ asset('user/images/bank-offer-2.png') }}" class="card-img-top" alt="Product 2">
                </div>
            </div>
            <div class="" style="text-align: right; justify-content:right ; display: flex;">
                <h5 class="card-title">View More...</h5>
                <button class="btn btn-primary" id="card-button">
                    <i class="fas fa-arrow-right"></i>
                </button>
            </div>
        </div>
    </div>
-->
    <!-- New Arriable -->

    <div class="container mt-5">
        <div class="row">
            @foreach ($products as $product)
                <div class="col-6 col-sm-6 col-md-4 mb-4">
                    <a href="{{ route('user.view_product', $product->id) }}" style="text-decoration: none;">
                        <div class="card" id="product-card">
                            <img src="{{ asset('storage/' . $product->main_image) }}" class="card-img-top img-fluid"
                                alt="Product 1">
                            <div class="card-body">
                                <h5 class="card-title">
                                    {{ \Illuminate\Support\Str::words($product->product_name, 5, '...') }}</h5>
                                <button class="btn btn-primary" id="card-button">
                                    <i class="fas fa-arrow-right"></i>
                                </button>
                            </div>
                        </div>
                    </a>
                </div>
            @endforeach

            <div class="" style="text-align: right; justify-content:right ; display: flex;">
                <h5 class="card-title">View More...</h5>
                <button class="btn btn-primary" id="card-button">
                    <i class="fas fa-arrow-right"></i>
                </button>
            </div>

        </div>

        <!-- Add more cards as needed -->
    </div>

    </div>


    <!-- Br -->

    <div class="container-brand mt-0">
        <div class="row">
            @foreach ($brands as $brand)
                <div class="col-2 col-sm-6 col-md-2 mb-4">
                    <a href="{{ route('user.brand_category', $brand->id) }}">
                        <div class="card" id="brand-image-card">
                            <img src="{{ url('storage/' . $brand->image) }}" class="card-img-top img-fluid"
                                alt="Product 1">
                        </div>
                    </a>
                </div>
            @endforeach
            <!-- Add more cards as needed -->
        </div>

    </div>


    <!-- Body Section end -->

    <!-- Footer -->
    @include('user.footer')

    <!-- JavaScript to show custom pop-up -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Check if there's a success, error or info message in the session
            @if (session('success'))
                showPopup("{{ session('success') }}", "success");
            @elseif (session('error'))
                showPopup("{{ session('error') }}", "error");
            @elseif (session('info'))
                showPopup("{{ session('info') }}", "info");
            @endif
        });

        // Function to display pop-up message
        function showPopup(message, type) {
            // Create the pop-up element
            const popup = document.createElement('div');
            popup.classList.add('popup', type); // Add class based on message type
            popup.innerText = message;

            // Append the pop-up to the body
            document.body.appendChild(popup);

            // Make the pop-up visible with a delay to allow the browser to render it
            setTimeout(() => {
                popup.style.transform = 'translateY(0)'; // Show the popup with animation
            }, 100);

            // Hide the pop-up after 5 seconds
            setTimeout(() => {
                popup.style.transform = 'translateY(-100px)'; // Move the popup out of the screen
                // Remove the pop-up from DOM after animation
                setTimeout(() => {
                    popup.remove();
                }, 300);
            }, 5000);
        }
    </script>

    <style>
        /* Pop-up styles */
        .popup {
            position: fixed;
            top: 20px;
            /* Change to top */
            left: 50%;
            transform: translateX(-50%) translateY(-100px);
            /* Start above the screen */
            background-color: #333;
            color: white;
            padding: 10px 20px;
            border-radius: 5px;
            font-size: 16px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            opacity: 0.9;
            transition: transform 0.3s ease-in-out, opacity 0.3s ease-in-out;
            z-index: 9999;
        }

        /* Success message styles */
        .popup.success {
            background-color: #28a745;
        }

        /* Error message styles */
        .popup.error {
            background-color: #dc3545;
        }

        /* Info message styles */
        .popup.info {
            background-color: #17a2b8;
            /* Blue color for info messages */
        }
    </style>

    <!-- Google Tag Manager (noscript) -->
    <noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-W8N8F4V5" height="0" width="0"
            style="display:none;visibility:hidden"></iframe></noscript>
    <!-- End Google Tag Manager (noscript) -->

    <!-- Bootstrap JS (with Popper) -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

</body>

</html>
