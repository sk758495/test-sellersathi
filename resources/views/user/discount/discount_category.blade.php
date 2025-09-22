<!DOCTYPE html>
<html lang="en">

<head>
    <title>Gujju E Market</title>
    @include('user.head')

</head>

<body>

    @include('user.navbar')

    <!-- Body Section -->

    <!-- Category Products ---->

    <div class="container mt-4">
        <div class="row">


            <div>
                <h4 class="my-3 mt-3"> Gujju E-Market Special Selling Offer</h4>
                <div class="row">
                    <div class="col-12 col-sm-6 col-md-4 col-lg-3 mb-4">
                        <a href="{{ route('user.discountBox', ['discountPercentage' => 50]) }}" class="card-link">
                            <div class="card discount-card">
                                <div class="card-body p-0">
                                    <div class="discount-image">
                                        <img src="{{ asset('user/images/50percent') }}" alt="50% Discount" class="img-fluid">
                                    </div>
                                    <div class="card-footer text-center">
                                        <h5 class="card-title">50% OFF</h5>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>
                    <div class="col-12 col-sm-6 col-md-4 col-lg-3 mb-4">
                        <a href="{{ route('user.discountBox', ['discountPercentage' => 60]) }}" class="card-link">
                            <div class="card discount-card">
                                <div class="card-body p-0">
                                    <div class="discount-image">
                                        <img src="{{ asset('user/images/60percent') }}" alt="60% Discount" class="img-fluid">
                                    </div>
                                    <div class="card-footer text-center">
                                        <h5 class="card-title">60% OFF</h5>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>
                    <div class="col-12 col-sm-6 col-md-4 col-lg-3 mb-4">
                        <a href="{{ route('user.discountBox', ['discountPercentage' => 70]) }}" class="card-link">
                            <div class="card discount-card">
                                <div class="card-body p-0">
                                    <div class="discount-image">
                                        <img src="{{ asset('user/images/70percent') }}" alt="70% Discount" class="img-fluid">
                                    </div>
                                    <div class="card-footer text-center">
                                        <h5 class="card-title">70% OFF</h5>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>
                    <div class="col-12 col-sm-6 col-md-4 col-lg-3 mb-4">
                        <a href="{{ route('user.discountBox', ['discountPercentage' => 80]) }}" class="card-link">
                            <div class="card discount-card">
                                <div class="card-body p-0">
                                    <div class="discount-image">
                                        <img src="{{ asset('user/images/80percent') }}" alt="80% Discount" class="img-fluid">
                                    </div>
                                    <div class="card-footer text-center">
                                        <h5 class="card-title">80% OFF</h5>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>
                    <!-- Add more cards here -->
                </div>

            </div>
        </div>
    </div>

    <script>
        function updateMinPriceLabel(value) {
            document.getElementById('minPriceLabel').textContent = value;
        }

        function updateMaxPriceLabel(value) {
            document.getElementById('maxPriceLabel').textContent = value;
        }
    </script>

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

    <script>
        function changeMainImage(imageSrc) {
            document.getElementById('main-image').src = imageSrc;
            
            // Update active thumbnail
            document.querySelectorAll('.thumb-item').forEach(item => {
                item.classList.remove('active');
            });
            event.target.closest('.thumb-item').classList.add('active');
        }

        // Tab functionality
        $(document).ready(function() {
            $('.pd-tab-list a').click(function(e) {
                e.preventDefault();
                
                // Remove active class from all tabs and content
                $('.pd-tab-list a').removeClass('active');
                $('.tab-pane').removeClass('active');
                
                // Add active class to clicked tab
                $(this).addClass('active');
                
                // Show corresponding content
                var target = $(this).data('target');
                $(target).addClass('active');
            });
        });
    </script>

</body>

</html>