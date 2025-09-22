<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <title>Admin Panel</title>
    <link rel="icon" href="{{ asset('user/images/gujju-logo-removebg.png') }}" sizes="32x32" type="image/x-icon">
    <link rel="stylesheet" href="{{ asset('admin/css/styles.css') }}">
    <style>
        /* Sidebar styles */

        #sidebar {
            width: 250px;
            height: 100vh;
            position: fixed;
            top: 0;
            left: -250px;
            background-color: #343a40;
            color: #ffffff;
            transition: all 0.3s ease;
        }
        /* Sidebar visible state */

        #sidebar.show {
            left: 0;
        }
        /* Main content margin shift */

        #main-content {
            transition: margin-left 0.3s ease;
            margin-left: 0;
        }

        #main-content.shifted {
            margin-left: 250px;
        }
        /* Toggle button styling */

        #toggleSidebar {
            position: fixed;
            top: 20px;
            left: 20px;
            z-index: 1000;
        }
        /* Mobile Responsive adjustments */

        @media (max-width: 768px) {
            #sidebar {
                width: 100%;
                left: -100%;
            }
            #sidebar.show {
                left: 0;
            }
            #main-content.shifted {
                margin-left: 0;
            }
            .admin_image {
                width: 35px;
                height: 35px;
            }
        }
        /* Additional UI adjustments */

        .card-text {
            font-size: 0.9rem;
        }

        .navbar .dropdown-menu {
            min-width: unset;
        }
    </style>
</head>

<body>
  
     <!-- Navbar and side navbar here -->
    @include('admin.pages.navbar-sidebar')

        <!-- Main Content -->
         <main id="main-content" class="p-3">
            <h1 style="margin-top: 70px;">
                <span style="color: red; font-weight: 600;">Admin </span> 
                {{ Auth::guard('admin')->user()->name }}
            </h1>
        
            <div class="row mt-4">
                <!-- Total Amount -->
                <div class="col-md-4 col-sm-6 mb-3">
                    <a href="#total-sales" class="text-decoration-none">
                        <div class="card text-white bg-primary shadow">
                            <div class="card-body">
                                <h5 class="card-title">Total Amount Of Order's Come</h5>
                                <p class="card-text">₹{{ number_format($totalAmount, 2) }}</p>
                            </div>
                        </div>
                    </a>
                </div>
        
                <!-- Total Sale Product -->
                <div class="col-md-4 col-sm-6 mb-3">
                    <a href="#total-sales" class="text-decoration-none">
                        <div class="card text-white bg-primary shadow">
                            <div class="card-body">
                                <h5 class="card-title">Total Product Available in Order</h5>
                                <p class="card-text">{{ $totalProductsSold }}</p>
                            </div>
                        </div>
                    </a>
                </div>
        
                <!-- Total Order Received -->
                <div class="col-md-4 col-sm-6 mb-3">
                    <a href="#total-sales" class="text-decoration-none">
                        <div class="card text-white bg-primary shadow">
                            <div class="card-body">
                                <h5 class="card-title">Total Order Received</h5>
                                <p class="card-text">{{ $totalOrdersReceived }}</p>
                            </div>
                        </div>
                    </a>
                </div>
        
                <!-- Total Confirmed Orders -->
                <div class="col-md-4 col-sm-6 mb-3">
                    <a href="#confirmed-orders" class="text-decoration-none">
                        <div class="card text-white bg-success shadow">
                            <div class="card-body">
                                <h5 class="card-title">Confirmed Orders</h5>
                                <p class="card-text">{{ $totalConfirmedOrders }}</p>
                            </div>
                        </div>
                    </a>
                </div>
        
                <!-- Total Confirmed Orders Price -->
                <div class="col-md-4 col-sm-6 mb-3">
                    <a href="#confirmed-orders-price" class="text-decoration-none">
                        <div class="card text-white bg-success shadow">
                            <div class="card-body">
                                <h5 class="card-title">Confirmed Orders Price</h5>
                                <p class="card-text">₹{{ number_format($totalConfirmedPrice, 2) }}</p>
                            </div>
                        </div>
                    </a>
                </div>
        
                <!-- Total Cancelled Orders -->
                <div class="col-md-4 col-sm-6 mb-3">
                    <a href="#cancelled-orders" class="text-decoration-none">
                        <div class="card text-white bg-danger shadow">
                            <div class="card-body">
                                <h5 class="card-title">Cancelled Orders</h5>
                                <p class="card-text">{{ $totalCancelledOrders }}</p>
                            </div>
                        </div>
                    </a>
                </div>
        
                <!-- Total Cancelled Orders Price -->
                <div class="col-md-4 col-sm-6 mb-3">
                    <a href="#cancelled-orders-price" class="text-decoration-none">
                        <div class="card text-white bg-danger shadow">
                            <div class="card-body">
                                <h5 class="card-title">Cancelled Orders Price</h5>
                                <p class="card-text">₹{{ number_format($totalCancelledPrice, 2) }}</p>
                            </div>
                        </div>
                    </a>
                </div>
        
            </div>
        </main>
        
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

         <!-- js file attached here -->
    <script src="{{ asset('admin/js/admin.js') }}"></script>

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


</body>

</html>
