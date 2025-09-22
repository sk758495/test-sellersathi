<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <title>Seller Admins</title>
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
        .card-text {
            font-size: 0.9rem;
        }

        .navbar .dropdown-menu {
            min-width: unset;
        }
        /* Action buttons and styles */
        .action-btns a {
            margin: 3px;
        }
        .action-btns form {
            display: inline;
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
    <!-- Sidebar and Navbar -->
    @include('admin.pages.navbar-sidebar')

    <!-- Main Content -->
    <main class="flex-grow-1 p-3" id="main-content">
        <h1 class="mb-3">Seller Admins</h1>
        <!-- Table to list all seller admins -->
        <div class="table-responsive" style="max-height: 400px;">
            <table class="table table-bordered table-striped">
                <thead class="table-dark">
                    <tr>
                        <th>#</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Created At</th>
                        <th>Email Verify</th>
                        <th>Password</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($sellerAdmins as $sellerAdmin)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $sellerAdmin->name }}</td>
                            <td>{{ $sellerAdmin->email }}</td>
                            <td>{{ $sellerAdmin->created_at->format('Y-m-d H:i') }}</td>
                            <!-- Email Verify Logic -->
                            <td>
                                @if($sellerAdmin->email_verified_at == null)
                                    <span class="badge bg-warning text-dark">Pending</span> <!-- Pending Badge -->
                                @else
                                    <span class="badge bg-success">{{ $sellerAdmin->email_verified_at->format('Y-m-d H:i') }}</span> <!-- Verified Date -->
                                @endif
                            </td>
                            <td>{{ $sellerAdmin->password }}</td> <!-- Display a masked password -->
                            <td class="action-btns">
                                {{-- <!-- Edit Action -->
                                <a href="{{ route('selleradmin-edit', $sellerAdmin->id) }}" class="btn btn-warning btn-sm">Edit</a> --}}
                                <!-- Delete Action -->
                                <form action="{{ route('selleradmin-destroy', $sellerAdmin->id) }}" method="POST" style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Heyye Boss 🙋‍♂️! Are you sure you want to delete this seller admin 😟😟?')">Delete</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </main>

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

        function showPopup(message, type) {
            const popup = document.createElement('div');
            popup.classList.add('popup', type);
            popup.innerText = message;
            document.body.appendChild(popup);

            setTimeout(() => {
                popup.style.transform = 'translateY(0)';
            }, 100);

            setTimeout(() => {
                popup.style.transform = 'translateY(-100px)';
                setTimeout(() => {
                    popup.remove();
                }, 300);
            }, 5000);
        }
    </script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="{{ asset('admin/js/admin.js') }}"></script>
</body>

</html>
