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
            <li class="breadcrumb-item active" aria-current="page">Brand Category Page</li>
        </ol>
    </nav>
</div>
<!-- category -->

<div class="container mt-5">
    <div class="row">
        @foreach ($brand as $brand_category)
        <div class="col-4 col-sm-6 col-md-3 mb-4">
            <a href="{{ route('user.category_products', $brand_category->id) }}" style="text-decoration: none; color: black;">
                <div class="card" id="category-card">
                    @if ($brand_category->images->isNotEmpty())
                        <!-- Display the first image in the images collection -->
                        <img src="{{ url('storage/' . $brand_category->images->first()->image) }}" class="card-img-top" alt="Category Image">
                    @else
                        <!-- Fallback image if no image exists -->
                        <img src="{{ asset('path_to_default_image.jpg') }}" class="card-img-top" alt="No Image Available">
                    @endif
                    <div class="card-body">
                        <h5 class="card-title">
                            {{ $brand_category->name }}
                        </h5>
                        <button class="btn btn-primary" id="card-button">
                            <i class="fas fa-arrow-right"></i>
                        </button>
                    </div>
                </div>
            </a>
        </div>
    @endforeach

        <!-- Add more cards as needed -->
    </div>

</div>
    <!-- New Arriable -->


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


