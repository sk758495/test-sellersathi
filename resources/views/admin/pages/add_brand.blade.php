<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <title>Admin Panel - Brand</title>
    <link rel="icon" href="{{ asset('user/images/gujju-logo-removebg.png') }}" sizes="32x32" type="image/x-icon">
    <link rel="stylesheet" href="{{ asset('admin/css/add_brand.css') }}">
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

    <!-- Body Part -->
    <main class="flex-grow-1 p-3" id="main-content">
        <h1 class="top-title" style="margin-top: 70px">Add Brand</h1>

        <!-- Add Brand Form -->
        <form id="add-brand-form" action="{{ route('pages.store_brand') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="form-box">
                <div class="form-group">
                    <label for="brand-name">Brand Name</label>
                    <input type="text" id="brand-name" name="name" required>
                </div>

                <div class="image-upload" style="margin-top: 10px;">
                    <label for="additional-images-2">Brand Image</label>
                    <input type="file" id="additional-images-2" name="image" accept="image/*" required>
                    <div class="image-preview" id="additional-image-preview-2"></div>
                </div>
            </div>

            <!-- Submit Button -->
            <div class="form-submit" style="gap: 20px">
                <button type="submit">Save</button>
                <a href="{{ route('pages.view_brands') }}" class="btn btn-info" style="height: 48px; align-content: center">Back</a>
            </div>
        </form>

    </main>
    </div>

     <!-- Image Preview Script -->
    <script>
        // Image Preview with Delete Option
        function handleImagePreview(inputElement, previewContainerId) {
            // Get the preview container
            const imagePreviewContainer = document.getElementById(previewContainerId);

            // Clear previous previews
            imagePreviewContainer.innerHTML = '';

            // Get the selected files
            const files = inputElement.files;

            // Loop through the files and create an image preview for each
            for (const file of files) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    const imgWrapper = document.createElement('div');
                    imgWrapper.classList.add('image-wrapper');

                    const img = document.createElement('img');
                    img.src = e.target.result; // Set the source to the file's result

                    const deleteIcon = document.createElement('span');
                    deleteIcon.classList.add('delete-icon');
                    deleteIcon.innerHTML = '&times;'; // Create a delete icon (×)
                    deleteIcon.onclick = function() {
                        imgWrapper.remove(); // Remove the image preview when clicked
                    };

                    imgWrapper.appendChild(img);
                    imgWrapper.appendChild(deleteIcon);
                    imagePreviewContainer.appendChild(imgWrapper);
                };
                reader.readAsDataURL(file);
            }
        }

        // Event listener for Additional Image 2 Preview
        document.getElementById('additional-images-2').addEventListener('change', function(event) {
            handleImagePreview(event.target, 'additional-image-preview-2');
        });
    </script>

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
