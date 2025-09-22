<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <title>Admin Panel - Show Discount Products</title>
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
            <h1>Super Sell Discount Product! </h1>

            <!-- Main Content -->

            <div style="display: flex; justify-content: space-between; width: 100%; padding: 10px;">
                <!-- Button to toggle table view -->
                <button id="toggleTable" class="btn btn-info mb-3">
                    Show/Hide Product Table
                </button>

                <!-- Optionally, you can add more content here, and it will be spaced equally -->
                <button class="btn btn-success mb-3">
                    <a href="{{ route('dashboard.viewdiscounts') }}" style="text-decoration: none; color: white;">Add More discount</a>
                </button>
            </div>

            <!-- Table container with scrollbar -->
            <div class="table-container" style="display: none;">
                <div class="table-responsive">
                    <table class="table table-bordered table-striped">
                        <thead class="table-dark">
                            <tr>
                                <th>#</th>
                                <th>Image</th>
                                <th>SKU</th>
                                <th>Product Name</th>
                                <th>Price (RRP)</th>
                                <th>Cost Price</th>
                                <th>Discount Price</th>
                                <th style="background-color: rgb(194, 194, 69);">Event Offer Price Less</th>
                                <th style="background-color: rgb(69, 194, 177);">Event Offer Percentage Disc..</th>
                                <th>Lead Time</th>
                                <th>Edit Price</th>
                                <th>Delete</th>
                            </tr>
                            </thead>
                            <tbody>
                                @foreach ($discounts as $discount)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td><img src="{{ asset('storage/' . $discount->product->main_image) }}" class="img-fluid" alt="{{ $discount->product->product_name }}"  style="width: 100px; height: 80px;">
                                    </td>
                                    <td>{{ $discount->product->sku }}</td>
                                    <td>{{ $discount->product->product_name }}</td>
                                    <td>{{ $discount->product->price }}</td>
                                    <td>{{ $discount->product->cost_price }}</td>
                                    <td>{{ $discount->product->discount_price }}</td>
                                    <td>{{ $discount->discounted_price }}</td>
                                    <td>{{ $discount->discount_percentage }}%</td>
                                    <td>{{ $discount->product->lead_time }}</td>
                                    <td><a href="" style="text-decoration: none; " class="btn btn-success">Edit</a></td>
                                    <td><form action="{{ route('admin.discount.destroy', $discount->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this discount?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger">Delete</button>
                                    </form>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                    </table>
                </div>
            </div>
        </main>
    </div>

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


    <!-- table script -->

    <script>
        // Get the button and table container
        const toggleButton = document.getElementById('toggleTable');
        const tableContainer = document.querySelector('.table-container');

        // Add click event listener to toggle table view
        toggleButton.addEventListener('click', function() {
            if (tableContainer.style.display === 'none' || tableContainer.style.display === '') {
                tableContainer.style.display = 'block'; // Show the table
            } else {
                tableContainer.style.display = 'none'; // Hide the table
            }
        });
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

</body>

</html>
