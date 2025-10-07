<?php


namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Address;
use App\Models\BrandCategory;
use App\Models\Cart;
use App\Models\CartValue;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\Log;
use App\Mail\OrderPlaced;
use Illuminate\Support\Facades\Mail;
use App\Models\Product;
use App\Models\Discount;
use Illuminate\Support\Facades\Http;

class PaymentController extends Controller
{

    public function view_payment()
{
    // Eager load 'images' relationship with brand categories
    $brand_categories = BrandCategory::with('images')->take(6)->get();
    // Get the currently authenticated user
    $user = Auth::user();
    $cartValue = CartValue::where('user_id', $user->id)->first(); // Get the cart value for the user

    // If the cart value doesn't exist, handle the error or redirect to cart
    if (!$cartValue) {
        return redirect()->route('user.cart')->with('error', 'Cart value not found.');
    }
    // Get the user's selected address (assuming the user has multiple addresses)
    $addresses = $user->addresses;

    // Calculate total amount from the cart
    $cartItems = $user->carts;
    $totalAmount = $cartValue->total_price;

    // Log totalAmount for debugging purposes
    Log::debug('Total Amount:', ['totalAmount' => $totalAmount]);

    // Pass the data to the view
    return view('user.payment.user_details', compact('addresses','cartValue', 'totalAmount','brand_categories'));
}


    // app/Http/Controllers/UserController.php


    public function saveAddress(Request $request)
{
    // Validate the request
    $request->validate([
        'address_line1' => 'required|string|max:255',
        'address_line2' => 'nullable|string|max:255',
        'city' => 'required|string|max:100',
        'state' => 'required|string|max:100',
        'country' => 'required|string|max:100',
        'postal_code' => 'required|string|max:20',
    ]);

    // Create a new address for the logged-in user
    $address = new Address();
    $address->user_id = auth()->id();
    $address->address_line1 = $request->address_line1;
    $address->address_line2 = $request->address_line2;
    $address->city = $request->city;
    $address->state = $request->state;
    $address->country = $request->country;
    $address->postal_code = $request->postal_code;
    $address->save();

    // Redirect to the address selection page
    return redirect()->route('user.payment')->with('success', 'New address added successfully 🤓!');
}

public function selectAddress(Request $request)
{
    $address = Address::findOrFail($request->address_id);
    
    // Verify the address belongs to the current user
    if ($address->user_id !== auth()->id()) {
        return redirect()->route('user.payment')->with('error', 'Invalid address selection.');
    }

    // Clear any existing payment session data and store the selected address
    session()->forget(['payment_address_id', 'payment_address_data', 'hdfc_txn_ref']);
    session(['selected_address_id' => $address->id]);
    
    Log::info('Address selected for user:', [
        'user_id' => auth()->id(),
        'address_id' => $address->id,
        'address_data' => $address->toArray()
    ]);

    // Redirect to the payment page
    return redirect()->route('user.payment.payment_page')->with('success', 'Address selected successfully 😎!');
}

public function payment_page()
{
    $user = Auth::user();
    $cartValue = CartValue::where('user_id', $user->id)->first(); // Get the cart value for the user

    $cart = Cart::where('user_id', $user->id)->first(); // Get the cart value for the user

    // If the cart value doesn't exist, handle the error or redirect to cart
    if (!$cartValue) {
        return redirect()->route('user.cart')->with('error', 'Cart value not found.');
    }

    $totalAmount = $cartValue->total_price;
    return view('user.payment.payment_page', compact('cartValue', 'totalAmount'));
}

    public function placeOrder(Request $request)
    {
        // Validate payment method
        $request->validate([
        'payment_method' => 'required|in:COD,HDFC'
    ]);

    if ($request->payment_method === 'HDFC') {
        return $this->initiateHdfcPayment($request);
    }
        
        $user = Auth::user();
        $addressId = session('selected_address_id');
        
        if (!$addressId) {
            return redirect()->route('user.payment')->with('error', 'No address selected 😒😒.');
        }
        
        $address = Address::findOrFail($addressId);
        
        // Log address information for debugging
        Log::info('Order placement - Address info:', [
            'address_id' => $address->id,
            'user_id' => $user->id,
            'address_details' => $address->toArray()
        ]);

        $cartValue = CartValue::where('user_id', $user->id)->first();
        if (!$cartValue || $cartValue->total_price <= 0) {
            return redirect()->route('cart.view')->with('error', 'Invalid cart value 😪.');
        }

        try {
            // Create single order with all cart items
            $order = $this->createOrderFromCart($user->id, $request->payment_method, 'Pending', 'COD' . time() . rand(1000, 9999));
            
            // Send confirmation email
            Mail::to($user->email)->send(new OrderPlaced($order));
            
            Log::info('COD Order created successfully:', [
                'order_id' => $order->id,
                'order_number' => $order->order_number,
                'total_items' => $order->orderItems->count(),
                'address_id' => $address->id,
                'user_id' => $user->id
            ]);
            
            return redirect()->route('user.order.details', ['order' => $order->id])
                            ->with('success', '🥳🥳 Your order has been Received successfully 🥳🥳!');
                            
        } catch (\Exception $e) {
            Log::error('Order creation failed:', [
                'error' => $e->getMessage(),
                'user_id' => $user->id
            ]);
            return redirect()->back()->with('error', 'Failed to create order: ' . $e->getMessage());
        }
    }


private function initiateHdfcPayment(Request $request)
{
    $user = Auth::user();
    $addressId = session('selected_address_id');
    $cartValue = CartValue::where('user_id', $user->id)->first();

    if (!$cartValue) {
        return redirect()->route('user.cart')->with('error', 'Cart value not found.');
    }
    
    if (!$addressId) {
        return redirect()->route('user.payment')->with('error', 'No address selected.');
    }
    
    $address = Address::findOrFail($addressId);

    // Generate secure order ID
    $orderId = 'ORD' . strtoupper(bin2hex(random_bytes(8)));
    $amount = number_format($cartValue->total_price, 2, '.', '');

    // Log payment initiation details
    Log::info('Initiating HDFC payment:', [
        'order_id' => $orderId,
        'amount' => $amount,
        'user_id' => $user->id,
        'address_id' => $address->id
    ]);

    // Get credentials from config
    $merchantId = config('payment.hdfc.merchant_id');
    $apiKey = config('payment.hdfc.api_key');
    $baseUrl = config('payment.hdfc.base_url');

    $payload = [
        "merchantTxnRefNumber" => $orderId,
        "amount" => $amount,
        "currency" => "INR",
        "redirectUrl" => route('user.hdfc.response'),
        "merchantId" => $merchantId,
        "requestType" => "T",
        "paymentInstrument" => [
            "paymentMode" => "ALL"
        ],
        "apiKey" => $apiKey
    ];

    try {
        $response = Http::timeout(30)->post("$baseUrl/payment/api/order/initiate", $payload);

        if ($response->successful()) {
            $res = $response->json();

            if (isset($res['paymentUrl'])) {
                // Store payment details in session with address data as backup
                session([
                    'hdfc_txn_ref' => $orderId,
                    'payment_amount' => $amount,
                    'payment_user_id' => $user->id,
                    'payment_address_id' => $address->id,
                    'payment_address_data' => $address->toArray() // Store full address as backup
                ]);
                
                Log::info('Payment session stored:', [
                    'hdfc_txn_ref' => $orderId,
                    'payment_user_id' => $user->id,
                    'payment_address_id' => $address->id,
                    'address_data' => $address->toArray()
                ]);

                return redirect($res['paymentUrl']);
            } else {
                Log::error('HDFC Payment initiation failed', ['response' => $res]);
                return back()->with('error', 'Payment initiation failed.');
            }
        }
    } catch (\Exception $e) {
        Log::error('HDFC Payment API error', ['error' => $e->getMessage()]);
    }

    return back()->with('error', 'Payment API error.');
}

public function handleHdfcResponse(Request $request)
{
    $status = $request->input('status');
    $txnRef = $request->input('orderId');
    $transactionId = $request->input('transactionId') ?? $request->input('cf_payment_id') ?? $txnRef;
    $sessionTxnRef = session('hdfc_txn_ref');

    // Log all received parameters for debugging
    Log::info('HDFC Response received:', $request->all());

    // Verify transaction reference
    if ($txnRef !== $sessionTxnRef) {
        Log::warning('Transaction reference mismatch', ['received' => $txnRef, 'session' => $sessionTxnRef]);
        return redirect()->route('user.cart')->with('error', 'Invalid transaction reference.');
    }

    if ($status === 'success') {
        try {
            // Get payment details from session with multiple fallbacks
            $userId = session('payment_user_id') ?? auth()->id();
            $addressId = session('payment_address_id') ?? session('selected_address_id');
            $addressData = session('payment_address_data');
            
            // Log all session data for debugging
            Log::info('HDFC Payment success - Session data:', [
                'user_id' => $userId,
                'address_id' => $addressId,
                'address_data' => $addressData,
                'txn_ref' => $txnRef,
                'transaction_id' => $transactionId
            ]);
            
            if (!$userId) {
                Log::error('Missing user ID');
                return redirect()->route('user.cart')->with('error', 'Session expired. Please try again.');
            }
            
            $user = User::findOrFail($userId);
            $address = null;
            
            // Try to get address with multiple fallbacks
            if ($addressId) {
                $address = Address::find($addressId);
            }
            
            // If address not found and we have address data, create a new address
            if (!$address && $addressData) {
                Log::info('Creating new address from stored data');
                $address = Address::create([
                    'user_id' => $userId,
                    'address_line1' => $addressData['address_line1'],
                    'address_line2' => $addressData['address_line2'] ?? null,
                    'city' => $addressData['city'],
                    'state' => $addressData['state'],
                    'country' => $addressData['country'],
                    'postal_code' => $addressData['postal_code']
                ]);
                $addressId = $address->id;
                session(['payment_address_id' => $addressId]);
            }
            
            if (!$address) {
                Log::error('No address found or created', ['address_id' => $addressId]);
                return redirect()->route('user.cart')->with('error', 'Address not found. Please select address again.');
            }
            
            Log::info('Using address:', ['address' => $address->toArray()]);
            
            // Create single order with all cart items
            $order = $this->createOrderFromCart($userId, 'HDFC', 'Confirmed', $txnRef, $transactionId);
            
            // Send confirmation email
            Mail::to($user->email)->send(new OrderPlaced($order));
            
            Log::info('HDFC Order created successfully:', [
                'order_id' => $order->id,
                'order_number' => $order->order_number,
                'total_items' => $order->orderItems->count(),
                'transaction_id' => $transactionId,
                'address_id' => $address->id
            ]);

            // Clear session
            session()->forget(['hdfc_txn_ref', 'payment_amount', 'payment_user_id', 'payment_address_id', 'payment_address_data', 'selected_address_id']);

            return redirect()->route('user.order.details', ['order' => $order->id])
                            ->with('success', '🎉 Payment successful! Your order has been confirmed.');
                            
        } catch (\Exception $e) {
            Log::error('Order creation failed after successful payment', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
                'txnRef' => $txnRef,
                'transactionId' => $transactionId
            ]);
            return redirect()->route('user.cart')->with('error', 'Payment successful but order creation failed. Please contact support.');
        }
    } else {
        Log::info('Payment failed or cancelled', ['status' => $status, 'txnRef' => $txnRef]);
        return redirect()->route('user.cart')->with('error', 'Payment failed or cancelled.');
    }
}

private function createOrderFromCart($userId, $paymentMethod, $orderStatus, $orderId = null, $transactionId = null)
{
    $carts = Cart::where('user_id', $userId)->with(['product', 'discount'])->get();
    $addressId = session('payment_address_id') ?? session('selected_address_id');
    
    if ($carts->isEmpty()) {
        throw new \Exception('Cart is empty');
    }
    
    if (!$addressId) {
        throw new \Exception('No address selected');
    }
    
    // Calculate totals
    $subtotal = 0;
    $orderItems = [];
    
    foreach ($carts as $cart) {
        $product = $cart->product;
        $price = $product->discount_price;
        
        if ($cart->discount_id && $cart->discount) {
            $price = $product->price - ($product->price * ($cart->discount->discount_percentage / 100));
        }
        
        $itemTotal = $price * $cart->quantity;
        $subtotal += $itemTotal;
        
        $orderItems[] = [
            'product_id' => $product->id,
            'quantity' => $cart->quantity,
            'price' => $price,
            'total_price' => $itemTotal,
            'discount_id' => $cart->discount_id
        ];
    }
    
    $shippingCharge = 50;
    $totalPrice = $subtotal + $shippingCharge;
    
    // Create single order
    $order = Order::create([
        'user_id' => $userId,
        'address_id' => $addressId,
        'order_number' => Order::generateOrderNumber(),
        'subtotal' => $subtotal,
        'shipping_charge' => $shippingCharge,
        'total_price' => $totalPrice,
        'payment_method' => $paymentMethod,
        'order_status' => $orderStatus,
        'order_id' => $orderId,
        'transaction_id' => $transactionId
    ]);
    
    // Create order items
    foreach ($orderItems as $item) {
        $item['order_id'] = $order->id;
        \App\Models\OrderItem::create($item);
    }
    
    // Clear cart and session
    Cart::where('user_id', $userId)->delete();
    CartValue::where('user_id', $userId)->delete();
    
    return $order;
}


    public function showOrderDetails($orderId)
    {
        $order = Order::with(['user', 'orderItems.product', 'address'])->where('user_id', Auth::id())->findOrFail($orderId);
        return view('user.order-details', compact('order'));
    }


   
}
