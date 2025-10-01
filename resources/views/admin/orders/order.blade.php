<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <title>Admin Panel - Order</title>
    <link rel="stylesheet" href="{{ asset('admin/css/brands.css') }}">
    <link rel="icon" href="{{ asset('user/images/gujju-logo-removebg.png') }}" sizes="32x32" type="image/x-icon">
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
        .edit-icon {
        color: #0d6efd; /* Change the color to your preference */
        text-decoration: none; /* Remove underline */
        padding: 5px; /* Optional padding */
        border: none; /* Remove button border */
        background: none; /* Remove background */
    }

    .edit-icon:hover {
        color: #004085; /* Optional: Darker color on hover */
    }
    .delete-icon {
        color: #fd0d0d; /* Change the color to your preference */
        text-decoration: none; /* Remove underline */
        padding: 5px; /* Optional padding */
        border: none; /* Remove button border */
        background: none; /* Remove background */
    }

    .delete-icon:hover {
        color: #850016; /* Optional: Darker color on hover */
    }
    
    .table th {
        font-size: 0.9rem;
        white-space: nowrap;
    }
    
    .table td {
        font-size: 0.85rem;
        vertical-align: middle;
    }
    
    .badge {
        font-size: 0.75rem;
    }
    
    @media (max-width: 1200px) {
        .table-responsive {
            font-size: 0.8rem;
        }
        .table th:nth-child(10),
        .table th:nth-child(11),
        .table td:nth-child(10),
        .table td:nth-child(11) {
            min-width: 120px;
        }
    }
    
    @media (max-width: 768px) {
        .table th:nth-child(10),
        .table th:nth-child(11),
        .table td:nth-child(10),
        .table td:nth-child(11) {
            font-size: 0.7rem;
            min-width: 100px;
        }
    }
    </style>
</head>

<body>

     <!-- Navbar and side navbar here -->
    @include('admin.pages.navbar-sidebar')


    <!-- Body Part -->
        <main class="flex-grow-1 p-3" id="main-content">

        <h1 class="mb-4">Manage Orders</h1>
        <div class="alert alert-info">
            <strong>Order Details:</strong> Shows unique orders with transaction count, product details, and current status.
        </div>

        <div class="table-responsive">
        <table class="table table-bordered table-striped">
            <thead class="table-dark">
                <tr>
                    <th>Order ID</th>
                    <th>Transaction Status</th>
                    <th>Transaction Amount</th>
                    <th>Transaction Count</th>
                    <th>Product Name</th>
                    <th>Product Type</th>
                    <th>User Name</th>
                    <th>User Mobile</th>
                    <th>Payment Method</th>
                    <th>Order Date</th>
                    <th>Last Updated</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($orders as $order)
                    <tr>
                        <td><strong>{{ $order->order_id ?? 'N/A' }}</strong></td>
                        <td>
                            <span class="badge 
                                @if($order->order_status == 'Pending') bg-warning
                                @elseif($order->order_status == 'Confirmed') bg-success
                                @else bg-danger
                                @endif">
                                {{ $order->order_status }}
                            </span>
                        </td>
                        <td><strong>₹{{ number_format($order->total_price, 2) }}</strong></td>
                        <td><span class="badge bg-info">{{ $order->transaction_count }}</span></td>
                        <td>{{ $order->product->product_name ?? 'N/A' }}</td>
                        <td>{{ $order->product->category->name ?? $order->product->brandCategory->name ?? 'N/A' }}</td>
                        <td>{{ $order->user ? $order->user->name : 'No user found' }}</td>
                        <td>{{ $order->user ? $order->user->phone : 'No user found' }}</td>
                        <td>{{ $order->payment_method }}</td>
                        <td><small>{{ $order->created_at->format('d M Y, h:i A') }}</small></td>
                        <td><small>{{ $order->updated_at->format('d M Y, h:i A') }}</small></td>
                        <td>
                            @if ($order->order_status == 'Pending')
                                <form action="{{ route('admin.order.confirm', $order->id) }}" method="POST" style="display: inline;">
                                    @csrf
                                    <button type="submit" class="btn btn-success btn-sm">Confirm</button>
                                </form>
                                <form action="{{ route('admin.order.cancel', $order->id) }}" method="POST" style="display: inline;">
                                    @csrf
                                    <button type="submit" class="btn btn-danger btn-sm">Cancel</button>
                                </form>
                            @else
                                <button class="btn btn-secondary btn-sm" disabled>{{ $order->order_status }}</button>
                            @endif
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        </div>

       
    </div>
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
