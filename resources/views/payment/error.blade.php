@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Payment Error</div>
                <div class="card-body">
                    <div class="alert alert-danger">
                        <h4>Payment Failed</h4>
                        <p>{{ $error }}</p>
                    </div>
                    <a href="{{ route('dashboard') }}" class="btn btn-primary">Back to Dashboard</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection