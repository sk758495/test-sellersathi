<!-- resources/views/seller-admin/dashboard.blade.php -->
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Seller-Admin Dashboard</title>

    <!-- BOOTSTRAP STYLES-->
    <link href="{{ asset('assets/css/bootstrap.css') }}" rel="stylesheet" />
    <!-- FONTAWESOME STYLES-->
    <link href="{{ asset('assets/css/font-awesome.css') }}" rel="stylesheet" />
       <!--CUSTOM BASIC STYLES-->
    <link href="{{ asset('assets/css/basic.css') }}" rel="stylesheet" />
    <!--CUSTOM MAIN STYLES-->
    <link href="{{ asset('assets/css/custom.css') }}" rel="stylesheet" />
    <!-- GOOGLE FONTS-->
    <link href='http://fonts.googleapis.com/css?family=Open+Sans' rel='stylesheet' type='text/css' />
    <link rel="icon" href="{{ asset('user/images/gujju-logo-removebg.png') }}" sizes="32x32" type="image/x-icon">
</head>
<body>
    <div id="wrapper">
    @include('seller-admin.navbar')
        <!-- /. NAV SIDE  -->
        <div id="page-wrapper">
            <div id="page-inner">
                <div class="row">
                    <div class="col-md-12">
                        <h1 class="page-head-line">{{ $sellerAdmin->name }} DASHBOARD</h1>
                        <h1 class="page-subhead-line">
                            <a id="copy-link" class="nav-link" href="{{ route('seller-user.dashboard',['sellerAdminId' => auth()->user()->id]) }}">Copy Your Personal Dashboard Link</a>
                            <button id="copyButton" class="btn btn-primary" onclick="copyLink()">Copy Link</button>
                            <span id="copyStatus" style="display: none; margin-left: 10px; color: green;">Link copied!</span>
                        </h1>
                    </div>
                </div>
                <p>Total Products: {{ $productsCount }}</p>
                <!-- /. ROW  -->
                <div class="row">
                    <div class="col-md-4">
                        <div class="main-box mb-red">
                            <a href="#">
                                <i class="fa fa-bolt fa-5x"></i>
                                <h5>Total Completed Order Amount is: {{ number_format($totalCompletedAmount, 2) }}</h5>
                            </a>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="main-box mb-dull">
                            <a href="#">
                                <i class="fa fa-plug fa-5x"></i>
                                <h5>Total Canceled Order Amount is: {{ number_format($totalCanceledAmount, 2) }}</h5>
                            </a>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="main-box mb-pink">
                            <a href="#">
                                <i class="fa fa-shopping-cart fa-5x"></i>
                                <h5>Total {{ $pendingOrdersCount }} Order Pending</h5>
                            </a>
                        </div>
                    </div>

                </div>
                <!-- /. ROW  -->

                <!--/.Row-->
                <hr />
                <div class="row">

                    <div class="col-md-12">

                        <div class="table-responsive">
                            <table class="table table-striped table-bordered table-hover">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Main Image</th>
                                        <th>Product Name</th>
                                        <th>SKU</th>
                                        <th>Color</th>
                                        <th>Color Code</th>
                                        <th>Price</th>
                                        <th>Cost Price</th>
                                        <th>Discount Price</th>
                                        <th>Quantity</th>
                                        <th>Lead Time</th>
                                        <th>Brand</th>
                                        <th>Category</th>
                                        <th>Subcategory</th>
                                        <th>Update Price</th>
                                        <th>Delete Product</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($products as $product)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td><img src="{{ asset('storage/'.$product->main_image) }}" alt="Product Image" width="100"></td>
                                        <td>{{ $product->product_name }}</td>
                                        <td>{{ $product->sku }}</td>
                                        <td>{{ $product->color_name }}</td>
                                        <td>{{ $product->color_code }}</td>
                                        <td>{{ $product->price }}</td>
                                        <td>{{ $product->cost_price }}</td>
                                        <td>{{ $product->discount_price }}</td>
                                        <td>{{ $product->quantity }}</td>
                                        <td>{{ $product->lead_time }}</td>
                                        <td>{{ optional($product->brand)->name ?? 'N/A' }}</td>
                                        <td>{{ optional($product->category)->name ?? 'N/A' }}</td>
                                        <td>{{ optional($product->subcategory)->name ?? 'N/A' }}</td>
                                        <td>
                                            <!-- Edit Action for Discount Price -->
                                            <form action="{{ route('seller.products.updateDiscount', ['productId' => $product->id]) }}" method="POST" style="display:inline;">
                                                @csrf
                                                <div class="input-group">
                                                    <input type="number" name="price" class="form-control" value="{{ $product->price }}" step="0.01" min="0" placeholder="Enter new price">
                                                    <button type="submit" class="btn btn-warning">Update</button>
                                                </div>
                                            </form>
                                            @if (session('error'))
                                                <div class="alert alert-danger mt-2">
                                                    {{ session('error') }}
                                                </div>
                                            @endif
                                        </td>
                                        <td>
                                            <!-- Delete Form -->
                                            <form action="{{ route('seller.products.delete', ['productId' => $product->id]) }}" method="POST" style="display:inline;">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this product?')">Delete</button>
                                            </form>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                    </div>

                <!--/.Row-->
                <hr />

            </div>
            <!-- /. PAGE INNER  -->
        </div>
        <!-- /. PAGE WRAPPER  -->
    </div>
    <!-- /. WRAPPER  -->

    <div id="footer-sec">
        &copy; 2014 YourCompany | Design By : <a href="http://www.binarytheme.com/" target="_blank">BinaryTheme.com</a>
    </div>
    <!-- /. FOOTER  -->
    <!-- SCRIPTS -AT THE BOTOM TO REDUCE THE LOAD TIME-->
    <!-- JQUERY SCRIPTS -->
    <script src="{{ asset('assets/js/jquery-1.10.2.js') }}"></script>
    <!-- BOOTSTRAP SCRIPTS -->
    <script src="{{ asset('assets/js/bootstrap.js') }}"></script>
    <!-- METISMENU SCRIPTS -->
    <script src="{{ asset('assets/js/jquery.metisMenu.js') }}"></script>
       <!-- CUSTOM SCRIPTS -->
    <script src="{{ asset('assets/js/custom.js') }}"></script>


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

{{-- Copy link --}}
<script>
    function copyLink() {
        // Get the link URL
        var link = document.querySelector('#copy-link').href;

        // Create a temporary input element
        var tempInput = document.createElement('input');
        tempInput.value = link;
        document.body.appendChild(tempInput);

        // Select the link text
        tempInput.select();
        tempInput.setSelectionRange(0, 99999); // For mobile devices

        // Execute the copy command
        document.execCommand('copy');

        // Remove the temporary input element
        document.body.removeChild(tempInput);

        // Show feedback message to the user
        var copyStatus = document.getElementById('copyStatus');
        copyStatus.style.display = 'inline';
        setTimeout(function() {
            copyStatus.style.display = 'none';
        }, 2000);
    }
</script>

</body>
</html>
