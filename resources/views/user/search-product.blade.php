<!DOCTYPE html>
<html lang="en">

<head>
    <title>Gujju E Market</title>
    @include('user.head')

    <style>
        /* General Styles */
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f8f9fa;
            margin: 0;
            padding: 0;
        }

        /* Table Styles */
        .table {
            width: 100%;
            margin: 20px 0;
            border-collapse: collapse;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        .table thead {
            background-color: #007bff;
            color: #fff;
            text-align: left;
        }

        .table th, .table td {
            padding: 12px;
            border: 1px solid orange;
        }

        .table tbody tr:hover {
            background-color: orange;
            transform: scale(1.02);
            transition: transform 0.3s ease-in-out;
        }

        .table td a {
            text-decoration: none;
            color: #fff;
            background-color: #28a745!important;
            padding: 6px 12px;
            border-radius: 4px;
            transition: background-color 0.3s, transform 0.3s;
        }

        .table td a:hover {
            background-color: #218838;
            transform: scale(1.1);
        }

        /* Search Results Header */
        h2 {
            color: #333;
            font-size: 32px;
            margin: 40px 0;
            text-align: center;
            font-weight: 600;
        }

        /* Pagination Styling */
        .pagination {
            justify-content: center;
            padding: 20px 0;
        }

        .pagination .page-item .page-link {
            color: #007bff;
            border: none;
            padding: 8px 16px;
        }

        .pagination .page-item .page-link:hover {
            background-color: #007bff;
            color: white;
        }

        /* No Products Found */
        p {
            text-align: center;
            font-size: 18px;
            color: #888;
        }

        /* Add Horizontal Scroll to the Table */
        .table-responsive {
            overflow-x: auto;
            -webkit-overflow-scrolling: touch; /* For smooth scrolling on iOS */
        }
    </style>
</head>

<body>

    @include('user.navbar');

    <!-- New Arriable -->
    <div class="container" id="container-table">
        <h2 class="text-center">Search Result</h2>
    
        <!-- Display the message if search term is empty -->
        @if(isset($message))
            <p class="text-center text-danger">{{ $message }}</p>
        @endif
    
        <!-- Search Results Display -->
        @if($products->isEmpty())
            <!-- This can be a fallback message when no products are found -->
            <p>No products found matching your criteria.</p>
        @else
            <!-- Table Wrapper for Horizontal Scroll -->
            <div class="table-responsive">
                <table class="table">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Product Name</th>
                            <th>SKU</th>
                            <th>Price</th>
                            <th>Category</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($products as $product)
                        <tr>
                            <td>{{ $product->id }}</td>
                            <td>{{ $product->product_name }}</td>
                            <td>{{ $product->sku }}</td>
                            <td>{{ $product->discount_price }}</td>
                            <td>{{ $product->brandCategory->name ?? 'N/A' }}</td>
                            <td>
                                <a href="{{ route('user.view_product', $product->id) }}" class="btn btn-info">View</a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
    
            <!-- Pagination Links -->
            <div class="d-flex justify-content-center">
                {{ $products->links() }}
            </div>
        @endif
    </div>
    
    <!-- Body Section end -->

    <!-- Footer -->
    @include('user.footer');

 <!-- Footer -->
    @include('user.footer')

    <!-- Js Plugins -->
    <script src="{{ asset('assets/js/jquery-3.3.1.min.js') }}"></script>
    <script src="{{ asset('assets/js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('assets/js/jquery-ui.min.js') }}"></script>
    <script src="{{ asset('assets/js/jquery.countdown.min.js') }}"></script>
    <script src="{{ asset('assets/js/jquery.nice-select.min.js') }}"></script>
    <script src="{{ asset('assets/js/jquery.zoom.min.js') }}"></script>
    <script src="{{ asset('assets/js/jquery.dd.min.js') }}"></script>
    <script src="{{ asset('assets/js/jquery.slicknav.js') }}"></script>
    <script src="{{ asset('assets/js/owl.carousel.min.js') }}"></script>
    <script src="{{ asset('assets/js/main.js') }}"></script>

    <!-- Bootstrap JS (with Popper) -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

</body>

</html>
