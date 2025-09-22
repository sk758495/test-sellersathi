<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <title>Admin Panel - Add Discount</title>
    <link rel="stylesheet" href="{{ asset('admin/css/add_product.css') }}">
    <link rel="icon" href="{{ asset('user/images/gujju-logo-removebg.png') }}" sizes="32x32" type="image/x-icon">

    <!-- Quill Editor -->
    <link href="https://cdn.quilljs.com/1.3.6/quill.snow.css" rel="stylesheet">


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

        #sidebar.show {
            left: 0;
        }

        #main-content {
            transition: margin-left 0.3s ease;
            margin-left: 0;
        }

        #main-content.shifted {
            margin-left: 250px;
        }

        #toggleSidebar {
            position: fixed;
            top: 20px;
            left: 20px;
            z-index: 1000;
        }

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
        /* General form styles */

        .image-upload {
            display: flex;
            flex-direction: column;
            margin-bottom: 20px;
        }

        .image-upload input[type="file"] {
            padding: 5px;
            border: none;
            background-color: #f8f8f8;
        }

        .image-upload label {
            margin-bottom: 10px;
            font-weight: 600;
        }

        .image-preview {
            margin-top: 15px;
            display: flex;
            flex-wrap: wrap;
            gap: 10px;
        }

        .image-preview img {
            width: 100px;
            height: 100px;
            object-fit: cover;
            border-radius: 5px;
        }
    </style>

</head>

<body>


     <!-- Navbar and side navbar here -->
    @include('admin.pages.navbar-sidebar')


<style>
    /* General Dropdown Styling */
    select {
        color: #000 !important; /* Black text */
        background-color: #fff !important; /* White background */
        border: 1px solid #ccc !important;
        padding: 5px !important;
        border-radius: 4px !important;
        width: 100% !important;
        appearance: none !important;
    }

    select option {
        color: #000 !important;
        background-color: #fff !important;
    }
    </style>

<main class="flex-grow-1 p-3" id="main-content">
    <form action="{{ route('admin.storeDiscount') }}" method="POST" class="p-4 shadow-lg rounded bg-light">
        @csrf

        <h3 class="mb-4 text-center text-primary">Add Discount</h3>

        <!-- Product Selection -->
        <div class="form-group mb-3">
            <label for="product" class="form-label">Select Product:</label>
            <select name="product_id" id="product" class="form-control">
                <option value="" disabled selected>Choose a product</option>
                @foreach ($products as $product)
                    <option value="{{ $product->id }}">{{ $product->sku }} | {{ $product->product_name }}</option>
                @endforeach
            </select>
        </div>

        <!-- Discount Percentage -->
        <div class="form-group mb-3">
            <label style="color: red;">10%, 20%, 30%, 40%, 50%, 60%, 70%, 80%, 90% Only Enter 👇🏻 !.. </label>
            <label for="discount_percentage" class="form-label">Discount Percentage:</label>
            <input
                type="number"
                name="discount_percentage"
                id="discount_percentage"
                class="form-control"
                placeholder="Enter discount percentage e.g. 10%, 20%, 30%, 40%, 50%.."
                min="0" max="100"
                required
            >
        </div>

        <!-- Discounted Price -->
        <div class="form-group mb-4">
            <label for="discounted_price" class="form-label">Discounted Price:</label>
            <input
                type="number"
                name="discounted_price"
                id="discounted_price"
                class="form-control"
                placeholder="Enter discounted price"
                step="0.01"
                required
            >
        </div>

        <!-- Submit Button -->
        <div class="text-center">
            <button type="submit" class="btn btn-primary w-100">Add Discount</button>
        </div>
    </form>


    <a href="{{ route('dashboard.discounts') }}">View All Product</a>

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
