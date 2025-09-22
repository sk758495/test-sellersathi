<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <title>Admin Panel - Edit Product</title>
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
        <h1>Edit Product</h1>

        <form id="add-brand-form" action="{{ route('admin.products.update', $product->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="form-box">
            <!-- Product Name -->
            <div class="form-group">
                <label for="product-name">Product Name</label>
                <input type="text" id="product-name" name="product_name" class="form-control" value="{{ old('product_name', $product->product_name) }}" required>
            </div>

            <!-- SKU -->
            <div class="form-group">
                <label for="sku">SKU</label>
                <input type="text" id="sku" name="sku" class="form-control" value="{{ old('sku', $product->sku) }}" required>
            </div>

            <div class="form-group">
                <label for="gujju_category_id">Select Gujju Category</label>
                <select id="gujju_category_id" name="gujju_category_id" class="form-control" required>
                    <option value="">Select Category</option>
                    @foreach ($gujju_categories as $category)
                    <option value="{{ $category->id }}" {{ $product->gujju_category_id == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                    @endforeach
                </select>
            </div>
            
            <!-- Brand -->
            <div class="form-group">
                <label for="brand">Select Brand</label>
                <select id="brand" name="brand" class="form-control" required>
                    <option value="">Select Brand</option>
                    @foreach ($brands as $brand)
                        <option value="{{ $brand->id }}" {{ $product->brand_id == $brand->id ? 'selected' : '' }}>{{ $brand->name }}</option>
                    @endforeach
                </select>
            </div>

            <!-- Brand Category -->
            <div class="form-group">
                <label for="brand_category">Select Brand Category</label>
                <select id="brand_category" name="brand_category" class="form-control" required>
                    <option value="">Select Brand Category</option>
                    @foreach ($brand_categories as $brand_category)
                        <option value="{{ $brand_category->id }}"
                                data-brand-id="{{ $brand_category->brand_id }}"
                                {{ $product->brand_category_id == $brand_category->id ? 'selected' : '' }}>
                            {{ $brand_category->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <!-- Subcategory -->
            <div class="form-group">
                <label for="subcategory">Select Subcategory</label>
                <select id="subcategory" name="subcategory_id" class="form-control">
                    <option value="">Select Subcategory</option>
                    @foreach ($subcategories as $subcategory)
                        <option value="{{ $subcategory->id }}" {{ $product->subcategory_id == $subcategory->id ? 'selected' : '' }}>
                            {{ $subcategory->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <!-- Quantity -->
            <div class="form-group">
                <label for="quantity">Quantity</label>
                <input type="number" id="quantity" name="quantity" class="form-control" value="{{ old('quantity', $product->quantity) }}" min="1" required>
            </div>

            <!-- Color -->
            <div class="form-group">
                <label for="color-name">Color Name</label>
                <input type="text" id="color-name" name="color_name" class="form-control" value="{{ old('color_name', $product->color_name) }}" required>
            </div>

            <!-- Color Code -->
            <div class="form-group">
                <label for="color-code">Color Code</label>
                <input type="text" id="color-code" name="color_code" class="form-control" value="{{ old('color_code', $product->color_code) }}" required>
            </div>

            <!-- Price -->
            <div class="form-group">
                <label for="price">RRP (Price)</label>
                <input type="number" id="price" name="price" class="form-control" value="{{ old('price', $product->price) }}" step="0.01" required>
            </div>

            <!-- Cost Price -->
            <div class="form-group">
                <label for="cost-price">Cost Price</label>
                <input type="number" id="cost-price" name="cost_price" class="form-control" value="{{ old('cost_price', $product->cost_price) }}" step="0.01" required>
            </div>

            <!-- Discount Price -->
            <div class="form-group">
                <label for="discount-price">Discount Price</label>
                <input type="number" id="discount-price" name="discount_price" class="form-control" value="{{ old('discount_price', $product->discount_price) }}" step="0.01">
            </div>

            <!-- Lead Time -->
            <div class="form-group">
                <label for="lead-time">Lead Time</label>
                <input type="text" id="lead-time" name="lead_time" class="form-control" value="{{ old('lead_time', $product->lead_time) }}" required>
            </div>

            <!-- Main Image -->
            <div class="image-upload form-group">
                <label for="main-images-2">Product Main Image</label>
                <input type="file" id="main-images-2" name="main_images" class="form-control" accept="image/*">
                <div class="image-preview" id="main-image-preview-2"></div>
                @if($product->main_image)
                    <img src="{{ asset('storage/' . $product->main_image) }}" alt="{{ $product->product_name }}" width="100">
                @endif
            </div>

            <!-- Description Editor -->
            <div class="box">
                <ul class="nav nav-tabs" id="descriptionTabs" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link active" id="short-description-tab" data-bs-toggle="tab" href="#short-description" role="tab">Short Description</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="long-description-tab" data-bs-toggle="tab" href="#long-description" role="tab">Long Description</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="features-tab" data-bs-toggle="tab" href="#features" role="tab">Features</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="whats-include-tab" data-bs-toggle="tab" href="#whats-include" role="tab" aria-controls="whats-include" aria-selected="false">What's Included</a>
                    </li>
                </ul>

                <div class="tab-content mt-3" id="descriptionTabsContent">
                    <div class="tab-pane fade show active" id="short-description" role="tabpanel">
                        <div id="short-description-editor"></div>
                    </div>
                    <div class="tab-pane fade" id="long-description" role="tabpanel">
                        <div id="long-description-editor"></div>
                    </div>
                    <div class="tab-pane fade" id="features" role="tabpanel">
                        <div id="features-editor"></div>
                    </div>
                    <div class="tab-pane fade" id="whats-include" role="tabpanel">
                        <div id="whats-include-editor"></div>
                    </div>
                </div>
            </div>

            <!-- Hidden inputs for Quill data -->
            <input type="hidden" name="short_description" id="short-description-hidden" value="{{ old('short_description', $product->short_description ?? '') }}">
            <input type="hidden" name="long_description" id="long-description-hidden" value="{{ old('long_description', $product->long_description ?? '') }}">
            <input type="hidden" name="features" id="features-hidden" value="{{ old('features', $product->features ?? '') }}">
            <input type="hidden" name="whats_included" id="whats-included-hidden" value="{{ old('whats_included', $product->whats_included ?? '') }}">

            <button type="submit" class="btn btn-info">Update Product</button>

        </div>
        </form>
        <button class="btn btn-danger" style="margin: 10px">
            <a href="{{ route('admin.products.view_product') }}" style="text-decoration: none; color: white;">Back</a>
        </button>
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
        document.addEventListener("DOMContentLoaded", function() {
            // Initialize Quill editors
            var shortDescEditor = new Quill('#short-description-editor', {
                theme: 'snow',
                placeholder: '',
                readOnly: false,  // Set to true for read-only
                modules: {
                    toolbar: [
                        [{ header: '1' }, { header: '2' }, { font: [] }],
                        [{ list: 'ordered' }, { list: 'bullet' }],
                        ['bold', 'italic', 'underline'],
                        ['link'],
                        [{ align: [] }],
                        ['image'],
                        ['blockquote']
                    ]
                }
            });

            var longDescEditor = new Quill('#long-description-editor', {
                theme: 'snow',
                placeholder: '',
                readOnly: false,
                modules: {
                    toolbar: [
                        [{ header: '1' }, { header: '2' }, { font: [] }],
                        [{ list: 'ordered' }, { list: 'bullet' }],
                        ['bold', 'italic', 'underline'],
                        ['link'],
                        [{ align: [] }],
                        ['image'],
                        ['blockquote']
                    ]
                }
            });

            var featuresEditor = new Quill('#features-editor', {
                theme: 'snow',
                placeholder: '',
                readOnly: false,
                modules: {
                    toolbar: [
                        [{ header: '1' }, { header: '2' }, { font: [] }],
                        [{ list: 'ordered' }, { list: 'bullet' }],
                        ['bold', 'italic', 'underline'],
                        ['link'],
                        [{ align: [] }],
                        ['image'],
                        ['blockquote']
                    ]
                }
            });

            var whatsIncludeEditor = new Quill('#whats-include-editor', {
                theme: 'snow',
                placeholder: "",
                readOnly: false,
                modules: {
                    toolbar: [
                        [{ header: '1' }, { header: '2' }, { font: [] }],
                        [{ list: 'ordered' }, { list: 'bullet' }],
                        ['bold', 'italic', 'underline'],
                        ['link'],
                        [{ align: [] }],
                        ['image'],
                        ['blockquote']
                    ]
                }
            });

            // Populate the editors with hidden input values
            shortDescEditor.root.innerHTML = document.getElementById('short-description-hidden').value;
            longDescEditor.root.innerHTML = document.getElementById('long-description-hidden').value;
            featuresEditor.root.innerHTML = document.getElementById('features-hidden').value;
            whatsIncludeEditor.root.innerHTML = document.getElementById('whats-included-hidden').value;

            // Listen for changes and update hidden inputs when the content changes
            shortDescEditor.on('text-change', function() {
                document.getElementById('short-description-hidden').value = shortDescEditor.root.innerHTML;
            });

            longDescEditor.on('text-change', function() {
                document.getElementById('long-description-hidden').value = longDescEditor.root.innerHTML;
            });

            featuresEditor.on('text-change', function() {
                document.getElementById('features-hidden').value = featuresEditor.root.innerHTML;
            });

            whatsIncludeEditor.on('text-change', function() {
                document.getElementById('whats-included-hidden').value = whatsIncludeEditor.root.innerHTML;
            });
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
