

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <title>Admin Panel - View Category</title>
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
    </style>
</head>

<body>
 
     <!-- Navbar and side navbar here -->
    @include('admin.pages.navbar-sidebar')


    <!-- Body Part -->
        <main class="flex-grow-1 p-3" id="main-content">
            <div class="heading" style="display: flex; justify-content: space-between">
                <h1 style="margin-top: 70px;">Hello, Admin Name</h1>
                <a href="{{ route('categories.create') }}" class="btn btn-success" style="height: 30px;margin-top: 70px;">Add Category</a>
            </div>

            <!-- Your existing Cards for Total Sales, Orders, etc. -->

            <div class="card shadow-sm mb-4">
                <div class="card-header">
                    <h5 class="mb-0">View Category</h5>
                </div>
                <div class="card-body">
                    <!-- Responsive and scrollable table -->

                    <div class="table-responsive" style="max-height: 400px;">
                        <table class="table table-bordered table-striped">
                            <thead class="table-dark">
                                <tr>
                                    <th>Category Name</th>
                                    <th>
                                        <li class="d-flex justify-content-between">
                                            <span>Child Categories</span>
                                            <!-- Flex container to push buttons to the right -->
                                            <div class="d-flex">
                                                <!-- Edit button for the child category -->
                                                <p style="margin-bottom: -15px; color: white;font-size: 14px;font-weight: bold;" >Action Child</p>


                                            </div>
                                        </li>
                                    </th>
                                    <th>Actions Category</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($categories as $category)
                                <tr>
                                    <td>{{ $category->name }}</td>
                                    <td>
                                        <ul class="list-unstyled">
                                            @foreach($category->children as $child)
                                                <li class="d-flex justify-content-between">
                                                    <span>{{ $child->name }}</span>
                                                    <!-- Flex container to push buttons to the right -->
                                                    <div class="d-flex">
                                                        <!-- Edit button for the child category -->
                                                        <a href="{{ route('categories.edit_child', $child->id) }}"
                                                            style="margin: 3px"  class="btn btn-warning btn-sm ms-2">Edit</a>
                                                        <!-- Delete button for the child category -->
                                                        <form action="{{ route('categories.destroy_child', $child->id) }}" style="margin: 3px"
                                                            method="POST" style="display:inline;"
                                                            onsubmit="return confirm('Are you sure you want to delete this child category?');">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit" class="btn btn-danger btn-sm ms-2">Delete</button>
                                                        </form>
                                                    </div>
                                                </li>
                                            @endforeach
                                        </ul>
                                    </td>
                                    <td class=" justify-content-center" style="align-content: center;">
                                        <!-- Edit button for the category -->
                                        <a href="{{ route('categories.edit', $category->id) }}"  class="btn btn-warning btn-sm ms-2">Edit</a>
                                        <!-- Delete button for the category -->
                                        <form action="{{ route('categories.destroy', $category->id) }}" method="POST"
                                            style="display:inline;"
                                            onsubmit="return confirm('Are you sure you want to delete this category?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-sm ms-2">Delete</button>
                                        </form>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
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

