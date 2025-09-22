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
        $user = Auth::user();  // The authenticated user (buyer)

        // Retrieve the selected address from session
        $address = session('selected_address');
        if (!$address) {
            return redirect()->route('checkout')->with('error', 'No address selected 😒😒.');
        }

        // Get the user's cart value (total price)
        $cartValue = CartValue::where('user_id', $user->id)->first();
        if (!$cartValue) {
            return redirect()->route('cart.view')->with('error', 'Cart value not found 😪.');
        }

        // Get cart items
        $cartItems = Cart::where('user_id', $user->id)->with('product', 'product.discount')->get();

        // Shipping charge (can be flat or calculated based on cart items or other logic)
        $shippingCharge = 10; // Flat fee for now (can be dynamic)

        // Array to store created order IDs
        $orderIds = [];

        // Loop through each cart item and create an order for it
        foreach ($cartItems as $cartItem) {
            // Get the product and its price
            $product = $cartItem->product;
            $price = $product->discount_price; // Default to discount price

            // Check if a discount exists and apply it
            if ($cartItem->discount_id && $cartItem->discount) {
                $discount = $cartItem->discount;
                $price = $product->price - ($product->price * ($discount->discount_percentage / 100));
            }

            // Calculate the total price for the product (price * quantity)
            $totalPrice = $price * $cartItem->quantity;

            // Add the shipping charge to the total price of each order
            $totalPriceWithShipping = $totalPrice + $shippingCharge;

            // Create a new order for each cart item
            $order = new Order();
            $order->user_id = $user->id;
            $order->address_id = $address->id;
            $order->product_id = $product->id;  // Save the product_id
            $order->payment_method = $request->payment_method;
            $order->quantity = $cartItem->quantity;
            $order->total_price = $totalPriceWithShipping;  // Save the total price for the specific product + shipping
            $order->order_status = 'Pending';
            $order->save();

            // Add the order ID to the array
            $orderIds[] = $order->id;

            // Send email after the last order is created (or after all orders are created)
            if (count($cartItems) == 1 || $cartItem === end($cartItems)) {
                Mail::to($user->email)->send(new OrderPlaced($order, $cartItems));
            }
        }

        // Optionally, clear the user's cart after placing the order
        Cart::where('user_id', $user->id)->delete();

        // Redirect to the details of the last created order
        return redirect()->route('user.order.details', ['order' => end($orderIds)])
                        ->with('success', '🥳🥳 Your order has been Received successfully 🥳🥳!');
    }




    public function showOrderDetails($orderId)
    {
        // Eager load the user relationship
        $order = Order::with('user', 'product')->where('user_id', Auth::id())->findOrFail($orderId);
    
        // Return the order details to the view
        return view('user.payment.details', compact('order'));
    }
   
}
