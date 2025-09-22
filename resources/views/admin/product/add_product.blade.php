<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <title>Admin Panel - Brand</title>
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



        <main class="flex-grow-1 p-3" id="main-content">
            <h1>Hello, Admin Name</h1>

            <!-- Add Brand Form -->
            <!-- Add Brand Form -->
<form id="add-brand-form" action="{{ route('admin.products.store') }}" method="POST" enctype="multipart/form-data">
    @csrf
    <div class="form-box">
        <div class="form-group">
            <label for="product-name">Product Name</label>
            <input type="text" id="product-name" name="product_name" required>
        </div>
        <div class="form-group">
            <label for="sku">SKU</label>
            <input type="text" id="sku" name="sku" required>
        </div>

        <div class="form-group">
            <label for="gujju_category_id">Select Category</label>
            <select id="gujju_category_id" name="gujju_category_id" required>
                <option value="">Select Category</option>
                @foreach ($gujju_categories as $category)
                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                @endforeach
            </select>
        </div>
            

        <div class="form-group">
            <label for="brand">Select Brand</label>
            <select id="brand" name="brand" required>
                <option value="">Select Brand</option>
                @foreach ($brands as $brand)
                    <option value="{{ $brand->id }}">{{ $brand->name }}</option>
                @endforeach
            </select>
        </div>


        <div class="form-group">
            <label for="brand_category">Select Brand Category</label>
            <select id="brand_category" name="brand_category" required>
                <option value="">Select Brand Category</option>
                @foreach ($brand_categories as $brand_category)
                    <option value="{{ $brand_category->id }}" class="brand-category" data-brand-id="{{ $brand_category->brand_id }}" style="display: none;">{{ $brand_category->name }}</option>
                @endforeach
            </select>
        </div>

        <div class="form-group">
            <label for="subcategory">Select Subcategory (Optional)</label>
            <select id="subcategory" name="subcategory_id">
                <option value="">Select Subcategory</option>
            </select>
        </div>


        <div class="form-group">
            <label for="quantity">Quantity</label>
            <input type="number" id="quantity" name="quantity" min="1" required>
        </div>
        <div class="form-group">
            <label for="color-name">Color Name</label>
            <input type="text" id="color-name" name="color_name" required>
        </div>
        <div class="form-group">
            <label for="color-code">Color Code</label>
            <input type="text" id="color-code" name="color_code" required>
        </div>
        <div class="form-group">
            <label for="price">RRP (Price)</label>
            <input type="number" id="price" name="price" step="0.01" required>
        </div>
        <div class="form-group">
            <label for="cost-price">Cost Price</label>
            <input type="number" id="cost-price" name="cost_price" step="0.01" required>
        </div>
        <div class="form-group">
            <label for="discount-price">Discount Price</label>
            <input type="number" id="discount-price" name="discount_price" step="0.01">
        </div>
        <div class="form-group">
            <label for="lead-time">Lead Time</label>
            <input type="text" id="lead-time" name="lead_time" required>
        </div>

        <div class="image-upload">
            <label for="main-images-2">Product Main Image</label>
            <input type="file" id="main-images-2" name="main_images" accept="image/*">
            <div class="image-preview" id="main-image-preview-2"></div>
        </div>
<!-----
        <div class="image-upload">
            <label for="product-images">Product Images (up to 4 images)</label>
            <input type="file" id="product-images" name="product_images[]" accept="image/*" multiple required>
            <div class="image-preview" id="image-preview"></div>
        </div>
    </div>
-->
    <!-- Product Descriptions Section -->
    <div class="box">
        <!-- Nav Tabs -->
        <ul class="nav nav-tabs" id="descriptionTabs" role="tablist">
            <li class="nav-item" role="presentation">
                <a class="nav-link active" id="short-description-tab" data-bs-toggle="tab" href="#short-description" role="tab" aria-controls="short-description" aria-selected="true">Short Description</a>
            </li>
            <li class="nav-item" role="presentation">
                <a class="nav-link" id="long-description-tab" data-bs-toggle="tab" href="#long-description" role="tab" aria-controls="long-description" aria-selected="false">Long Description</a>
            </li>
            <li class="nav-item" role="presentation">
                <a class="nav-link" id="features-tab" data-bs-toggle="tab" href="#features" role="tab" aria-controls="features" aria-selected="false">Features</a>
            </li>
            <li class="nav-item" role="presentation">
                <a class="nav-link" id="whats-include-tab" data-bs-toggle="tab" href="#whats-include" role="tab" aria-controls="whats-include" aria-selected="false">What's Included</a>
            </li>
        </ul>

        <!-- Tab Content -->
        <div class="tab-content mt-3" id="descriptionTabsContent">
            <div class="tab-pane fade show active" id="short-description" role="tabpanel" aria-labelledby="short-description-tab">
                <div id="short-description-editor"></div>
            </div>
            <div class="tab-pane fade" id="long-description" role="tabpanel" aria-labelledby="long-description-tab">
                <div id="long-description-editor"></div>
            </div>
            <div class="tab-pane fade" id="features" role="tabpanel" aria-labelledby="features-tab">
                <div id="features-editor"></div>
            </div>
            <div class="tab-pane fade" id="whats-include" role="tabpanel" aria-labelledby="whats-include-tab">
                <div id="whats-include-editor"></div>
            </div>
        </div>
    </div>

    <!-- Hidden inputs for Quill data -->
    <input type="hidden" name="short_description" id="short-description-hidden">
    <input type="hidden" name="long_description" id="long-description-hidden">
    <input type="hidden" name="features" id="features-hidden">
    <input type="hidden" name="whats_included" id="whats-included-hidden">

    <!-- Submit Button -->
    <button type="submit" class="btn btn-info">Save Product</button>

    <button class="btn btn-danger">
        <a href="{{ route('admin.products.view_product') }}" style="text-decoration: none; color: white;">Cancel</a>
    </button>
</form>

        </main>
    </div>


    <script>
        // On Brand change, filter Brand Categories
        document.getElementById('brand').addEventListener('change', function() {
            const brandId = this.value;

            // Show only brand categories that belong to the selected brand
            document.querySelectorAll('#brand_category option').forEach(option => {
                option.style.display = (option.dataset.brandId == brandId || brandId === '') ? 'block' : 'none';
            });

            // Reset subcategory dropdown
            document.getElementById('subcategory').innerHTML = '<option value="">Select Subcategory</option>';
        });

        // On Brand Category change, fetch and show subcategories
        document.getElementById('brand_category').addEventListener('change', function() {
            const brandCategoryId = this.value;

            if (brandCategoryId) {
                fetch(`/admin/get-subcategories/${brandCategoryId}`)
                    .then(response => response.json())
                    .then(data => {
                        const subcategorySelect = document.getElementById('subcategory');
                        subcategorySelect.innerHTML = '<option value="">Select Subcategory</option>';

                        data.forEach(subcategory => {
                            const option = document.createElement('option');
                            option.value = subcategory.id;
                            option.textContent = subcategory.name;
                            subcategorySelect.appendChild(option);
                        });
                    });
            }
        });
    </script>


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    <!-- Quill Editor Script -->
    <script src="https://cdn.quilljs.com/1.3.6/quill.min.js"></script>

    <script>
        // Initialize Quill Editors
        const shortDescEditor = new Quill('#short-description-editor', {
            theme: 'snow',
            placeholder: 'Enter short description here...',
        });

        const longDescEditor = new Quill('#long-description-editor', {
            theme: 'snow',
            placeholder: 'Enter long description here...',
        });

        const featuresEditor = new Quill('#features-editor', {
            theme: 'snow',
            placeholder: 'Enter features here...',
        });

        const whatsIncludeEditor = new Quill('#whats-include-editor', {
            theme: 'snow',
            placeholder: 'Enter what\'s included here...',
        });

        // Handle form submission to grab content from each Quill editor
        document.getElementById('add-brand-form').addEventListener('submit', function(e) {
            e.preventDefault();

            // Get content from the Quill editors
            const shortDescription = shortDescEditor.root.innerHTML;
            const longDescription = longDescEditor.root.innerHTML;
            const features = featuresEditor.root.innerHTML;
            const whatsInclude = whatsIncludeEditor.root.innerHTML;

            // Assign the content to hidden input fields
            document.getElementById('short-description-hidden').value = shortDescription;
            document.getElementById('long-description-hidden').value = longDescription;
            document.getElementById('features-hidden').value = features;
            document.getElementById('whats-included-hidden').value = whatsInclude;

            // Log the values (for debugging purposes)
            console.log("Short Description:", shortDescription);
            console.log("Long Description:", longDescription);
            console.log("Features:", features);
            console.log("What's Included:", whatsInclude);

            // Now you can submit the form via AJAX or a regular POST
            // e.g., using fetch, or you can submit the form normally:
            this.submit();
        });
    </script>


    <!-- Image Preview Script
<script>
    // Image Preview for Main Image Only
    document.getElementById('main-images-2').addEventListener('change', function(event) {
        const imagePreviewContainer = document.getElementById('main-image-preview-2');
        const files = event.target.files;

        // Clear previous previews
        imagePreviewContainer.innerHTML = '';

        // Check if there are any files selected
        if (files.length > 0) {
            const file = files[0]; // Get the first file (since we are only interested in one image)

            // Check if the selected file is an image
            if (!file.type.startsWith('image/')) {
                alert('Please select a valid image.');
                return;
            }

            const reader = new FileReader();

            reader.onload = function(e) {
                // Create an image element
                const img = document.createElement('img');
                img.src = e.target.result; // Set the image source to the file's data URL
                img.alt = 'Main Image Preview'; // Add alt text for accessibility

                // Clear the preview container and append the new image
                imagePreviewContainer.innerHTML = ''; // Clear any previous previews
                imagePreviewContainer.appendChild(img); // Append the image element
            };

            reader.readAsDataURL(file); // Read the selected image as a Data URL
        }
    });
</script>
 -->
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
