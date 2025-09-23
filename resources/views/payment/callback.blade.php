@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Payment Status</div>
                <div class="card-body">
                    <div class="alert alert-info">
                        {{ $message }}
                    </div>
                    
                    @if(isset($order['status']) && $order['status'] === 'CHARGED')
                        <div class="alert alert-success">
                            <h4>Payment Successful!</h4>
                            <p>Transaction ID: {{ $order['transaction_id'] ?? 'N/A' }}</p>
                            <p>Order ID: {{ $order['order_id'] }}</p>
                            <p>Amount: ₹{{ $order['amount'] }}</p>
                        </div>
                        <a href="{{ route('user.orders.status') }}" class="btn btn-primary">View Orders</a>
                    @else
                        <div class="alert alert-warning">
                            <h4>Payment Status: {{ $order['status'] ?? 'Unknown' }}</h4>
                            <p>Order ID: {{ $order['order_id'] ?? 'N/A' }}</p>
                        </div>
                        <a href="{{ route('dashboard') }}" class="btn btn-secondary">Back to Dashboard</a>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection