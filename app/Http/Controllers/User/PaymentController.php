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

    // Store the selected address in the session for later use
    session(['selected_address' => $address]);

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
        $address = session('selected_address');
        
        if (!$address) {
            return redirect()->route('user.payment')->with('error', 'No address selected 😒😒.');
        }
        
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

        $cartItems = Cart::where('user_id', $user->id)->with('product', 'product.discount')->get();
        $shippingCharge = 10;
        $orderIds = [];

        // Create orders for COD
        foreach ($cartItems as $cartItem) {
            $product = $cartItem->product;
            $price = $product->discount_price;

            if ($cartItem->discount_id && $cartItem->discount) {
                $discount = $cartItem->discount;
                $price = $product->price - ($product->price * ($discount->discount_percentage / 100));
            }

            $totalPrice = $price * $cartItem->quantity;
            $totalPriceWithShipping = $totalPrice + $shippingCharge;

            $order = Order::create([
                'user_id' => $user->id,
                'address_id' => $address->id,
                'product_id' => $product->id,
                'payment_method' => $request->payment_method,
                'quantity' => $cartItem->quantity,
                'total_price' => $totalPriceWithShipping,
                'order_status' => 'Pending',
                'order_id' => 'COD' . time() . rand(1000, 9999)
            ]);

            $orderIds[] = $order->id;
        }

        // Send confirmation emails
        $orders = Order::whereIn('id', $orderIds)->get();
        foreach ($orders as $order) {
            Mail::to($user->email)->send(new OrderPlaced($order, $cartItems));
        }

        // Clear cart, cart value, and session data
        Cart::where('user_id', $user->id)->delete();
        CartValue::where('user_id', $user->id)->delete();
        session()->forget('selected_address');
        
        return redirect()->route('user.order.details', ['order' => end($orderIds)])
                        ->with('success', '🥳🥳 Your order has been Received successfully 🥳🥳!');
    }


private function initiateHdfcPayment(Request $request)
{
    $user = Auth::user();
    $address = session('selected_address');
    $cartValue = CartValue::where('user_id', $user->id)->first();

    if (!$cartValue) {
        return redirect()->route('user.cart')->with('error', 'Cart value not found.');
    }
    
    if (!$address) {
        return redirect()->route('user.payment')->with('error', 'No address selected.');
    }

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
                // Store payment details in session
                session([
                    'hdfc_txn_ref' => $orderId,
                    'payment_amount' => $amount,
                    'payment_user_id' => $user->id,
                    'payment_address_id' => $address->id
                ]);
                
                Log::info('Payment session stored:', [
                    'hdfc_txn_ref' => $orderId,
                    'payment_user_id' => $user->id,
                    'payment_address_id' => $address->id
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
            // Get payment details from session
            $userId = session('payment_user_id');
            $addressId = session('payment_address_id');
            
            // Also try to get address from selected_address session if payment_address_id is null
            if (!$addressId) {
                $selectedAddress = session('selected_address');
                $addressId = $selectedAddress ? $selectedAddress->id : null;
            }
            
            Log::info('HDFC Payment success - Session data:', [
                'user_id' => $userId,
                'address_id' => $addressId,
                'txn_ref' => $txnRef,
                'transaction_id' => $transactionId
            ]);
            
            if (!$userId || !$addressId) {
                Log::error('Missing user or address data', ['user_id' => $userId, 'address_id' => $addressId]);
                return redirect()->route('user.cart')->with('error', 'Session expired. Please try again.');
            }
            
            $user = User::findOrFail($userId);
            $address = Address::findOrFail($addressId);
            $cartItems = Cart::where('user_id', $userId)->with('product', 'product.discount')->get();
            
            if ($cartItems->isEmpty()) {
                return redirect()->route('user.cart')->with('error', 'Cart is empty.');
            }

            $shippingCharge = 10;
            $orderIds = [];

            // Create orders for successful payment
            foreach ($cartItems as $cartItem) {
                $product = $cartItem->product;
                $price = $product->discount_price;

                if ($cartItem->discount_id && $cartItem->discount) {
                    $discount = $cartItem->discount;
                    $price = $product->price - ($product->price * ($discount->discount_percentage / 100));
                }

                $totalPrice = $price * $cartItem->quantity;
                $totalPriceWithShipping = $totalPrice + $shippingCharge;

                $order = Order::create([
                    'user_id' => $userId,
                    'address_id' => $addressId,
                    'product_id' => $product->id,
                    'payment_method' => 'HDFC',
                    'quantity' => $cartItem->quantity,
                    'total_price' => $totalPriceWithShipping,
                    'order_status' => 'Confirmed',
                    'order_id' => $txnRef,
                    'transaction_id' => $transactionId
                ]);

                $orderIds[] = $order->id;
                
                Log::info('Order created successfully:', [
                    'order_id' => $order->id,
                    'transaction_id' => $transactionId,
                    'address_id' => $addressId
                ]);
            }

            // Send confirmation emails
            $orders = Order::whereIn('id', $orderIds)->get();
            foreach ($orders as $order) {
                Mail::to($user->email)->send(new OrderPlaced($order, $cartItems));
            }

            // Clear cart and session
            Cart::where('user_id', $userId)->delete();
            CartValue::where('user_id', $userId)->delete();
            session()->forget(['hdfc_txn_ref', 'payment_amount', 'payment_user_id', 'payment_address_id', 'selected_address']);

            return redirect()->route('user.order.details', ['order' => end($orderIds)])
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


    public function showOrderDetails($orderId)
    {
        $order = Order::with(['user', 'product', 'address'])->where('user_id', Auth::id())->findOrFail($orderId);
        return view('user.payment.details', compact('order'));
    }


   
}
