<!DOCTYPE html>
<html lang="en">
<head>
    <title>Payment Flow Debug - Gujju E Market</title>
    @include('user.head')
</head>
<body>
    @include('user.navbar')

    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header bg-info text-white">
                        <h4>Payment Flow Debug Information</h4>
                    </div>
                    <div class="card-body">
                        <h5>Current Payment Flow:</h5>
                        
                        <div class="alert alert-success">
                            <h6>✅ HDFC Payment Flow (Correct):</h6>
                            <ol>
                                <li>User selects HDFC payment method</li>
                                <li>Cart data stored in session (no orders created yet)</li>
                                <li>User redirected to HDFC payment gateway</li>
                                <li>User completes payment</li>
                                <li><strong>Orders created ONLY after successful payment</strong></li>
                                <li>Order status set to "Confirmed"</li>
                                <li>Confirmation email sent</li>
                            </ol>
                        </div>

                        <div class="alert alert-warning">
                            <h6>⚠️ COD Payment Flow:</h6>
                            <ol>
                                <li>User selects COD payment method</li>
                                <li>Orders created immediately with "Pending" status</li>
                                <li>Confirmation email sent</li>
                                <li>No payment gateway involved</li>
                            </ol>
                        </div>

                        <hr>

                        <h5>Session Data:</h5>
                        <div class="row">
                            <div class="col-md-6">
                                <strong>Pending Order Data:</strong>
                                <pre>{{ json_encode(session('pending_order_data'), JSON_PRETTY_PRINT) ?: 'None' }}</pre>
                            </div>
                            <div class="col-md-6">
                                <strong>Selected Address:</strong>
                                <pre>{{ json_encode(session('selected_address'), JSON_PRETTY_PRINT) ?: 'None' }}</pre>
                            </div>
                        </div>

                        <hr>

                        <div class="text-center">
                            <a href="{{ route('user.payment.payment_page') }}" class="btn btn-primary">
                                Go to Payment Page
                            </a>
                            <a href="{{ route('dashboard') }}" class="btn btn-secondary">
                                Dashboard
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @include('user.footer')
</body>
</html>