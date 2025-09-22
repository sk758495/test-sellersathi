<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gujju E-Market</title>
    <link rel="stylesheet" href="{{ asset('user/css/single_product.css') }}">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="icon" href="{{ asset('user/images/gujju-logo-removebg.png') }}" sizes="32x32" type="image/x-icon">
</head>

<body>

    @include('seller-user.navbar')

    <!-- Body Section -->
    {{-- <div class="container mt-3">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
                <li class="breadcrumb-item"><a href="{{ route('user.category_page') }}">Category Page</a></li>
                <li class="breadcrumb-item active" aria-current="page">Single Products</li>
            </ol>
        </nav>
    </div> --}}
    <!-- Single Products -->

    <!-- New Arriable -->
    <div class="container mt-5">
        <div class="row">
            <div class="col-6 col-sm-6 col-md-6 mb-6">
                <img id="mainImage" src="{{ asset('storage/' . $product->main_image) }}" class="img-fluid" alt="Main Product Image">
                <!---
                <div class="image-container mt-3" style="display: flex; gap: 5px;">
                    <img src="images/product-2.jpg" class="thumbnail" alt="Product Image 1 " onclick="changeImage(this) ">
                    <img src="images/product-1.jpeg " class="thumbnail " alt="Product Image 2" onclick="changeImage(this)">
                    <img src="images/baby-pic.jpeg" class="thumbnail" alt="Product Image 3 " onclick="changeImage(this) ">
                </div>-->
            </div>

            <div class="col-6 col-sm-6 col-md-6 mb-6 ">
                <h2>{{ $product->product_name }}</h2>
                <p class="text-muted ">Category: {{ $product->brandCategory ? $product->brandCategory->name : 'N/A' }}</p>
                <p class="text-muted ">Sku: {{ $product->sku }}</p>
                <h4 class="text-success ">Rs {{ $product->price }}</h4>
                <p class="mt-3 ">{!! old('short_description', $product->short_description ?? '') !!}</p>

                <div class="mt-3">
                    <h5>Color Variants:</h5>
                    <div>
                        <div class="color-circle" style="background-color: #{{ $product->color_code }};" data-color="{{ $product->color_name }}" onclick="selectColor('{{ $product->color_name }}')"></div>

                    </div>
                </div>


                <div class="mt-4 ">
                    <button class="btn btn-primary">
                        <form action="{{ route('seller.cart.add', ['sellerAdminId' => $sellerAdminId, 'productId' => $product->id]) }}" method="POST">
                            @csrf  <!-- CSRF Token for security -->
                            <button type="submit" class="btn btn-primary">Add to Cart</button>
                        </form>
                    </button>
                </div>
            </div>
        </div>
    </div>

    <div class="container mt-5 ">
        <div class="row ">
            <hr class="my-4 ">
            <div class="col-12 col-sm-6 col-md-12 mb-6 ">
                <h4>Description</h4>
                <p>{!! old('long_description', $product->long_description ?? '') !!}</p>
            </div>
            <div class="col-12 col-sm-6 col-md-12 mb-6 ">
                <h4>Features</h4>
                <ul class="feature-list ">
                    {!! old('features', $product->features ?? '') !!}

                </ul>
            </div>
            <!---
            <div class="col-12 col-sm-6 col-md-12 mb-6 ">
                <h4>Specifications</h4>
                <ul class="spec-list ">
                    <li>Specification 1</li>
                    <li>Specification 2</li>
                    <li>Specification 3</li>
                </ul>
            </div>-->
            <div class="col-12 col-sm-6 col-md-12 mb-6 ">
                <h4>What's Included</h4>
                <ul class="included-list ">
                    {!! old('whats_included', $product->whats_included ?? '') !!}

                </ul>
            </div>
        </div>
    </div>

    {{-- <div class="container mt-5 ">
        <div class="row ">
            <div class="col-12 ">
                <hr class="my-4 ">
                <h4>Customer Reviews</h4>

            </div>
            <div class="col-12 col-sm-6 col-md-12 mb-12 ">
                <h5>Sunil Chauhan</h5>
                <p>⭐⭐⭐⭐⭐</p>
                <p>Great product! Highly recommend.</p>
            </div>
            <div class="col-12 col-sm-6 col-md-12 mb-12 ">
                <h5>Nilesh Bhatiya</h5>
                <p>⭐⭐⭐⭐</p>
                <p>nice</p>
            </div>
            <div class="col-12 col-sm-6 col-md-12 mb-12 ">
                <h5>Rajib Kanojiya</h5>
                <p>⭐⭐⭐⭐⭐</p>
                <p>Customer helping support is good</p>
            </div>
            <div class="col-12 col-sm-6 col-md-12 mb-12 ">
                <h5>Suresh Bharwad</h5>
                <p>⭐⭐⭐⭐</p>
                <p>Delievery System is good.</p>
            </div>
        </div>
    </div> --}}

    <script>
        function selectColor(color) {
            alert("You selected: " + color);
            // Add additional logic for color selection here if needed
        }
    </script>


    <!-- Body Section end -->

    <!-- Footer -->
    @include('user.footer')

    <script>
        function changeImage(thumbnail) {
            const mainImage = document.getElementById('mainImage');
            mainImage.src = thumbnail.src; // Set the main image source to the thumbnail's source
        }
    </script>


        <!-- JavaScript to show custom pop-up -->
        <script>
            document.addEventListener('DOMContentLoaded', function () {
                // Check if there's a success, error or info message in the session
                @if(session('success'))
                    showPopup("{{ session('success') }}", "success");
                @elseif(session('error'))
                    showPopup("{{ session('error') }}", "error");
                @elseif(session('info'))
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
                    top: 20px;  /* Change to top */
                    left: 50%;
                    transform: translateX(-50%) translateY(-100px); /* Start above the screen */
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
                    background-color: #17a2b8; /* Blue color for info messages */
                }
            </style>

    <!-- Bootstrap JS (with Popper) -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js "></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js "></script>

</body>

</html>
