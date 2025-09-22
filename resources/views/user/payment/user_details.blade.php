<!DOCTYPE html>
<html lang="en">

<head>
    <title>Gujju E Market</title>
    @include('user.head')

</head>

<body>

    @include('user.navbar')

    <div class="cart-body">
        <!-- Step 1: Address Selection -->
        <div id="address-section">
            <h2>1. Select a delivery address</h2>

            <!-- Display saved addresses only if they exist -->
            @if ($addresses->isEmpty())
                <!-- If no addresses are available, show only the "Add New Address" option -->
                <h4>No saved addresses found. Please add a new address.</h4>
            @else
                <h4>Choose a saved address</h4>
                <form action="{{ route('user.select_address') }}" method="POST">
                    @csrf
                    <div class="form-group">
                        @foreach ($addresses as $address)
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="address_id"
                                    id="address{{ $address->id }}" value="{{ $address->id }}" required>
                                <label class="form-check-label" for="address{{ $address->id }}">
                                    {{ $address->address_line1 }}, {{ $address->city }}, {{ $address->state }},
                                    {{ $address->country }} - {{ $address->postal_code }}
                                </label>
                            </div>
                        @endforeach
                    </div>
                    <button type="submit" class="btn btn-primary">Select Address</button>
                </form>
            @endif

            <hr>

            <!-- Option to Add New Address -->
            <button id="add-new-address-btn" class="btn btn-secondary">Add New Address</button>

            <div id="new-address-form" style="display:none;">
                <!-- Address Form to Add New Address -->
                <h4 style="margin-top: 15px;">Enter New Address</h4>
                <form action="{{ route('user.save_address') }}" method="POST">
                    @csrf
                    <div class="form-group">
                        <label for="address_line1">Address Line 1</label>
                        <input type="text" name="address_line1" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label for="address_line2">Address Line 2</label>
                        <input type="text" name="address_line2" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="city">City</label>
                        <input type="text" name="city" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label for="state">State</label>
                        <input type="text" name="state" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label for="country">Country</label>
                        <input type="text" name="country" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label for="postal_code">Postal Code</label>
                        <input type="text" name="postal_code" class="form-control" required>
                    </div>
                    <button type="submit" class="btn btn-primary" style="margin-top: 10px;">Save Address</button>
                </form>
            </div>
        </div>
    </div>

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
