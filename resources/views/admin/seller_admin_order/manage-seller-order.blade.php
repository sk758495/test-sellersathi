<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <title>Admin Panel - Seller Orders</title>
    <link rel="stylesheet" href="{{ asset('admin/css/styles.css') }}">
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

        /* Popup styles */
        .popup {
            position: fixed;
            top: 20px;
            left: 50%;
            transform: translateX(-50%) translateY(-100px);
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

        .popup.success {
            background-color: #28a745;
        }

        .popup.error {
            background-color: #dc3545;
        }

        .popup.info {
            background-color: #17a2b8;
        }
    </style>
</head>

<body>
    @if(session('status'))
    <div class="alert alert-success">
        {{ session('status') }}
    </div>
    @endif

    <!-- Navbar and side navbar here -->
    @include('admin.pages.navbar-sidebar')

    <!-- Main Content -->
    <main id="main-content" class="p-3">
        <h1>All Seller Admin Orders</h1>

        <!-- Button to toggle table view -->
        <div style="display: flex; justify-content: space-between; width: 100%; padding: 10px;">
            <button id="toggleTable" class="btn btn-info mb-3">
                Show/Hide Order Table
            </button>
        </div>

        <!-- Table container with scrollbar -->
        <div class="table-container" style="display: none;">
            @foreach($sellerAdmins as $sellerAdmin)
            <h3>{{ $sellerAdmin->name }} (ID: {{ $sellerAdmin->id }})</h3>

            @if(isset($orders[$sellerAdmin->id]) && $orders[$sellerAdmin->id]->count() > 0)
            <div class="table-responsive">
                <table class="table table-bordered table-striped">
                    <thead class="table-dark">
                        <tr>
                            <th>Order ID</th>
                            <th>SKU</th>
                            <th>Customer Name</th>
                            <th>Product</th>
                            <th>Quantity</th>
                            <th>Product Price</th>
                            <th>Total Price + 30 Delivery</th>
                            <th>Order Date</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($orders[$sellerAdmin->id] as $order)
                        <tr id="order-{{ $order->id }}">
                            <td>{{ $order->id }}</td>
                            <td>{{ $order->product->sku }}</td>
                            <td>{{ $order->user->name }}</td>
                            <td>{{ $order->product->product_name }}</td>
                            <td>{{ $order->quantity }}</td>
                            <td>{{ $order->product->price }}</td>
                            <td>{{ $order->total_price }}</td>
                            <td>{{ $order->created_at->format('Y-m-d') }}</td>
                            <td>{{ $order->status }}</td>
                            <td>
                                <form action="{{ route('admin.orders.confirm', $order->id) }}" method="POST" style="margin: 5px;">
                                    @csrf
                                    <button type="submit" class="btn btn-success btn-sm" {{ $order->status == 'completed' || $order->status == 'canceled' ? 'disabled' : '' }}>Confirm</button>
                                </form>

                                <form action="{{ route('admin.orders.cancel', $order->id) }}" method="POST" style="margin: 5px;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm" {{ $order->status == 'completed' || $order->status == 'canceled' ? 'disabled' : '' }}>Cancel</button>
                                </form>

                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            @else
            <p>No orders for this Seller Admin.</p>
            @endif
            @endforeach
        </div>
    </main>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Sidebar Toggle Logic
        document.getElementById("toggleSidebar").addEventListener("click", function() {
            var sidebar = document.getElementById("sidebar");
            var mainContent = document.getElementById("main-content");

            sidebar.classList.toggle("show");
            mainContent.classList.toggle("shifted");

            // Toggle the main content visibility in mobile view
            if (window.innerWidth <= 768) { // Check if it's mobile view
                mainContent.classList.toggle("hidden");
            }

            // Toggle icon change
            var icon = this.querySelector("i");
            icon.classList.toggle("fa-bars");
            icon.classList.toggle("fa-arrow-right");
        });
    </script>



    <script>
        // Toggle table visibility
        const toggleButton = document.getElementById('toggleTable');
        const tableContainer = document.querySelector('.table-container');

        toggleButton.addEventListener('click', function() {
            if (tableContainer.style.display === 'none' || tableContainer.style.display === '') {
                tableContainer.style.display = 'block'; // Show the table
            } else {
                tableContainer.style.display = 'none'; // Hide the table
            }
        });
    </script>

    <script>
            document.querySelectorAll('.btn-confirm').forEach(button => {
                button.addEventListener('click', function(e) {
                    if (!confirm("Are you sure you want to confirm this order?")) {
                        e.preventDefault();
                    } else {
                        // Disable the buttons after confirmation
                        disableButtons(this);
                    }
                });
            });

            document.querySelectorAll('.btn-cancel').forEach(button => {
                button.addEventListener('click', function(e) {
                    if (!confirm("Are you sure you want to cancel this order?")) {
                        e.preventDefault();
                    } else {
                        // Disable the buttons after cancellation
                        disableButtons(this);
                    }
                });
            });

            function disableButtons(button) {
                const row = button.closest('tr');
                const confirmButton = row.querySelector('.btn-confirm');
                const cancelButton = row.querySelector('.btn-cancel');

                // Disable the buttons and add a visual cue
                confirmButton.disabled = true;
                cancelButton.disabled = true;
                confirmButton.classList.add('btn-secondary');
                cancelButton.classList.add('btn-secondary');
            }

    </script>

    <!-- JavaScript to show custom pop-up -->
    <script>
    document.addEventListener('DOMContentLoaded', function () {
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
        const popup = document.createElement('div');
        popup.classList.add('popup', type);
        popup.innerText = message;

        document.body.appendChild(popup);

        setTimeout(() => {
            popup.style.transform = 'translateY(0)'; // Show popup
        }, 100);

        setTimeout(() => {
            popup.style.transform = 'translateY(-100px)';
            setTimeout(() => {
                popup.remove();
            }, 300);
        }, 5000);
    }
    </script>

</body>

</html>
