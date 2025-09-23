@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Refund Status</div>
                <div class="card-body">
                    @if(isset($refund['status']) && $refund['status'] === 'SUCCESS')
                        <div class="alert alert-success">
                            <h4>Refund Processed Successfully!</h4>
                            <p>Refund ID: {{ $refund['refund_id'] ?? 'N/A' }}</p>
                            <p>Amount: ₹{{ $refund['amount'] }}</p>
                            <p>Status: {{ $refund['status'] }}</p>
                        </div>
                    @else
                        <div class="alert alert-warning">
                            <h4>Refund Status: {{ $refund['status'] ?? 'Pending' }}</h4>
                            <p>Amount: ₹{{ $refund['amount'] ?? 'N/A' }}</p>
                        </div>
                    @endif
                    <a href="{{ route('dashboard') }}" class="btn btn-primary">Back to Dashboard</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection