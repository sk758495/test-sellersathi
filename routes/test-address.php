<?php

use App\Models\Address;
use Illuminate\Support\Facades\Route;

// Test route - remove this in production
Route::get('/test-address', function() {
    if (!auth()->check()) {
        return 'Please login first';
    }
    
    $addresses = Address::where('user_id', auth()->id())->get();
    $sessionAddressId = session('selected_address_id');
    
    $data = [
        'user_id' => auth()->id(),
        'session_address_id' => $sessionAddressId,
        'addresses_count' => $addresses->count(),
        'addresses' => $addresses->map(function($addr) {
            return [
                'id' => $addr->id,
                'address_line1' => $addr->address_line1,
                'city' => $addr->city,
                'state' => $addr->state,
                'postal_code' => $addr->postal_code
            ];
        })
    ];
    
    return response()->json($data, 200, [], JSON_PRETTY_PRINT);
})->name('test.address');