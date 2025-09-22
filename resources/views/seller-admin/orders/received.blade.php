<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Seller-Admin Received Orders</title>

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
    <style>
        /* Status color classes */
        .status-pending {
            background-color: black;
            color: yellow;
            padding: 5px;
            border-radius: 5px;
        }

        .status-completed {
            background-color: #28a745; /* Green */
            color: white;
            padding: 5px;
            border-radius: 5px;
        }

        .status-canceled {
            background-color: #dc3545; /* Red */
            color: white;
            padding: 5px;
            border-radius: 5px;
        }
    </style>

<body>
    <div id="wrapper">
        @include('seller-admin.navbar')  <!-- Navbar inclusion -->

        <div id="page-wrapper">
            <div id="page-inner">
                <div class="row">
                    <div class="col-md-12">
                        <h1 class="page-head-line">Received Orders</h1>
                        <h1 class="page-subhead-line">Manage all the orders that have been received for your products.</h1>
                    </div>
                </div>
                <p>Total Orders: {{ $orders->count() }}</p>
                <hr />

                <!-- Orders Table -->
                <div class="row">
                    <div class="col-md-12">
                        <div class="table-responsive">
                            <!-- Check for success/error messages -->
                            @if (session('error'))
                                <div class="alert alert-danger">{{ session('error') }}</div>
                            @endif

                            <!-- Check if there are no orders -->
                            @if ($orders->isEmpty())
                                <p>No orders received yet.</p>
                            @else
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Order ID</th>
                                            <th>Customer Name</th>
                                            <th>Total Amount</th>
                                            <th>Status</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($orders as $order)
                                            <tr>
                                                <td>{{ $loop->iteration }}</td>
                                                <td>{{ $order->id }}</td>
                                                <td>{{ $order->user->name }}</td>
                                                <td>₹{{ $order->total_price }}</td>
                                                <td>
                                                    <!-- Dynamically add status classes based on the order's status -->
                                                    <span class="status
                                                        @if($order->status == 'pending') status-pending
                                                        @elseif($order->status == 'completed') status-completed
                                                        @elseif($order->status == 'canceled') status-canceled
                                                        @endif">
                                                        {{ $order->status }}
                                                    </span>
                                                </td>
                                                <td>
                                                    <a href="{{ route('seller-admin.orders.view', ['orderId' => $order->id, 'sellerAdminId' => auth()->user()->id]) }}" class="btn btn-info">View</a>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            @endif
                        </div>
                    </div>
                </div>
                <hr />
            </div>
        </div>
    </div>

    <div id="footer-sec">
        &copy; 2024 YourCompany | Design By : <a href="http://www.binarytheme.com/" target="_blank">BinaryTheme.com</a>
    </div>

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

    <!-- JQUERY SCRIPTS -->
    <script src="{{ asset('assets/js/jquery-1.10.2.js') }}"></script>
    <!-- BOOTSTRAP SCRIPTS -->
    <script src="{{ asset('assets/js/bootstrap.js') }}"></script>
    <!-- METISMENU SCRIPTS -->
    <script src="{{ asset('assets/js/jquery.metisMenu.js') }}"></script>
    <!-- CUSTOM SCRIPTS -->
    <script src="{{ asset('assets/js/custom.js') }}"></script>
</body>
</html>
